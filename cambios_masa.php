<!DOCTYPE html>
<html lang="es">
<head>
<title>Cambios en masa</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="shortcut icon" href="images/icon.png" type="image/png"/>
<link rel="stylesheet" type="text/css" href="css/estilo.css"/>
<script type="text/javascript" src="js/scripts.js" ></script>
</head>
<body>
<header>
<div class="nav">
<ul>
    <li><a href="index.php">Facturas</a>
        <ul>
            <li><a href="index.php">Administrar</a></li>
            <li><a href="add_factura.php">Añadir</a></li>
        </ul>
    </li>
    <li><a href="manage_conce.php">Conceptos</a>
        <ul>
            <li><a href="manage_conce.php">Administrar</a></li>
            <li><a href="add_conce.php">Añadir</a></li>
        </ul>
    </li>
    <li><a href="manage_cliente.php">Clientes</a>
        <ul>
            <li><a href="manage_cliente.php">Administrar</a></li>
            <li><a href="add_cliente.php">Añadir</a></li>
        </ul>
    </li>
    <li class="about"><a href="about.html">About</a></li>
</ul>
</div>
</header>
<div class="cuerpo">
    <h1><u><i>Cambios en masa</i></u></h1>
    <?php
    $dp = mysql_connect("localhost", "root", "" );
    mysql_select_db("facturas", $dp);
    ?>

    <!--<style type="text/css">
        table { border: 1px solid black; border-collapse: collapse }
        td { border: 1px solid black }
    </style>-->

    <form enctype="multipart/form-data" action="" method="post">
        <input type="checkbox" name="cambiar[]" value="fecha">
        <label><u>Fecha:</u></label><br>
        Vieja: <input type="date" name="fechav" value="<?php echo date('Y-m-d'); ?>"/><br>
        Nueva: <input type="date" name="fechan" value="<?php echo date('Y-m-d'); ?>"/><br>
        
        <br>

        <input type="checkbox" name="cambiar[]" value="cliente">
        <label><u>Cliente:</u></label><br>
        Viejo: <select name="cliv1" onchange="changeClim(this,1)" style="white-space:pre-wrap; width: 100px;" >
            <option selected="selected"></option>
            <!--<option value="1">Otro</option>-->
            <?php
            $sql = "SELECT existe_cli, cliente FROM facturas GROUP BY cliente";
            $clis = mysql_query($sql);
            while ($row = mysql_fetch_assoc($clis)) {
                if ($row[existe_cli] == 0) {
                    print("<option value='".$row[cliente]."|No Guardado'>$row[cliente]</option>");
                } else {
                    $sqlc = mysql_query("SELECT direccion,cif FROM clientes WHERE cif='$row[cliente]'");
                    $direccion = mysql_result($sqlc,0,0);
                    $cif = mysql_result($sqlc,0,1);
                    print("<option value='".$direccion."|".$cif."'>$direccion</option>");
                }
            }
            ?>
        </select><br>
        <input id="cif11" type="text" name="cif11" value="" style="display: none" disabled/>
        <textarea id="cliente11" name="cliente11" rows="5" style="display: none"></textarea><br>
        Nuevo: <select name="clin1" onchange="changeClim(this,2)" style="white-space:pre-wrap; width: 100px;" >
            <option selected="selected"></option>
            <option value="1">Otro</option>
            <?php
            $sql2 = "SELECT * FROM clientes";
            $clis2 = mysql_query($sql2);
            while ($row3 = mysql_fetch_assoc($clis2)) {
                print("<option value='".$row3[direccion]."|".$row3[cif]."'>$row3[direccion]</option>");
            }
            ?>
        </select><br>
        <input id="cif12" type="text" name="cif12" value="" style="display: none" disabled/>
        <textarea id="cliente12" name="cliente12" rows="5" style="display: none"></textarea>

        <br>

        <input type="checkbox" name="cambiar[]" value="concepto">
        <label><u>Concepto:</u></label><br>
        Viejo: <select name="conce1" onchange="changeConIndem(this,1)" style="white-space:pre-wrap; width: 250px;">
            <option selected="selected"></option>
            <!--<option value="1">Otro</option>-->
            <?php
            $sqlcon = "SELECT concepto FROM tener_f_c GROUP BY concepto";
            $cons = mysql_query($sqlcon);
            while ($rowcon = mysql_fetch_assoc($cons)) {
                print("<option value='".$rowcon[concepto]."'>$rowcon[concepto]</option>");
            }
            ?>
        </select>
        <textarea id="text_area1" name="concepto1" rows="1" cols="50" style="display: none"></textarea><br>
        Nuevo: <select name="conce2" onchange="changeConIndem(this,2)" style="white-space:pre-wrap; width: 250px;">
            <option selected="selected"></option>
            <option value="1">Otro</option>
            <?php
                $sql = "SELECT * FROM conceptos";
                $cons = mysql_query($sql);
                while ($row = mysql_fetch_assoc($cons)) {
                    print("<option value='".$row[concepto]."'>$row[concepto]</option>");
                }
            ?>
        </select>
        <textarea id="text_area2" name="concepto2" rows="1" cols="50" style="display: none"></textarea><br>

        <br>

        <input type="checkbox" name="cambiar[]" value="iva">
        <label><u>IVA:</u></label><br>
        Viejo: <input type="number" name="ivav" value="21" Style="width:40Px"/><br>
        Nuevo: <input type="number" name="ivan" value="21" Style="width:40Px"/><br>

        <br>

        <input type="submit" name="cambiar1" value="Cambiar"/>
    </form>

    <?php
    if(isset($_POST['cambiar1'])){
        $upda1 = "";
        $upda2 = "";
        $updacon = "";

        function IsChecked($chkname,$value){
            if(!empty($_POST[$chkname])){
                foreach($_POST[$chkname] as $chkval){
                    if($chkval == $value){
                        return true;
                    }
                }
            }
            return false;
        }

        if (IsChecked('cambiar','fecha')){
            $insfechan = date("Y-m-d",strtotime($_POST['fechan']));
            $insfechav = date("Y-m-d",strtotime($_POST['fechav']));
            if($upda1 == ""){
                $upda1 = "UPDATE facturas SET fecha='$insfechan'";
                $upda2 = " WHERE fecha='$insfechav'";
                //$upda1 = "SELECT facturas.cod_fac as cod_fac,facturas.fecha as fecha, facturas.cliente as cliente, facturas.existe_cli as existe, facturas.iva as iva, facturas.detalles as detalles, tener_f_c.concepto as concepto, tener_f_c.cantidad as cantidad, tener_f_c.precio_u as precio FROM facturas, tener_f_c WHERE facturas.cod_fac=tener_f_c.cod_fac AND facturas.fecha='$fecha'";
            } else {
                $upda1 .= ",fecha='$insfechan'";
                $upda2 .= " AND fecha='$insfechav'";
            }
        }

        if (IsChecked('cambiar','cliente')){
            $cliv = explode('|', $_POST['cliv1']);
            if ($cliv[1] == "No Guardado") {
                $clivi = $cliv[0];
            } else {
                $clivi = $cliv[1];
            }

            if ($_POST['clin1'] == 1) {
                $clinu = $_POST['cliente12'];
                $exi = 0;
            } else {
                $clin = explode('|', $_POST['clin1']);
                $clinu = $clin[1];
                $exi = 1;
            }

            if($upda1 == ""){
                $upda1 = "UPDATE facturas SET cliente='$clinu',existe_cli=$exi";
                $upda2 = " WHERE cliente='$clivi'";
            } else {
                $upda1 .= ",cliente='$clinu',existe_cli=$exi";
                $upda2 .= " AND cliente='$clivi'";
            }
        }

        if (IsChecked('cambiar','concepto')){
            $conceptov = $_POST['conce1'];
            $concepn = $_POST['conce2'];
            if ($concepn == 1) {
                $concepton = $_POST['concepto2'];
            } else {
                $concepton = $concepn;
            }

            $updacon = "UPDATE tener_f_c SET concepto='$concepton' WHERE concepto='$conceptov'";
        }

        if (IsChecked('cambiar','iva')){
            $ivav = $_POST['ivav'];
            $ivan = $_POST['ivan'];
            if($upda1 == ""){
                $upda1 = "UPDATE facturas SET IVA='$ivan'";
                $upda2 = " WHERE IVA='$ivav'";
            } else {
                $upda1 .= ",IVA='$ivan'";
                $upda2 .= " AND IVA='$ivav'";
            }
        }

        //if (!IsChecked('cambiar','fecha') && !IsChecked('cambiar','numero') && !IsChecked('cambiar','cliente') && !IsChecked('cambiar','concepto') && !IsChecked('cambiar','iva')) {
        if (!IsChecked('cambiar','fecha') && !IsChecked('cambiar','cliente') && !IsChecked('cambiar','concepto') && !IsChecked('cambiar','iva')) {
            echo "¡ATENCIÓN! ¡Puede que te hayas olvidado de seleccionar los CheckBox!<br/><br/>";
        }
        $update = $upda1 . $upda2;
        //echo $sele;
        mysql_query($update);
        mysql_query($updacon);
    }
    mysql_close($dp);
    ?>
</div>
</body>
</html>