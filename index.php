<!DOCTYPE html>
<html lang="es">
<head>
<title>Administrar facturas</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="shortcut icon" href="images/icon.png" type="image/png"/>
<link rel="stylesheet" type="text/css" href="css/estilo.css"/>
<script type="text/javascript" src="js/scripts.js" ></script>
</head>
<body>
<header>
<div class="nav">
<ul>
    <li><a class="active" href="index.php">Facturas</a>
        <ul>
            <li><a class="active" href="index.php">Administrar</a></li>
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
    <h1><u><i>Administrar facturas</i></u></h1>
    <?php
    $dp = mysql_connect("localhost", "root", "" );
    mysql_select_db("facturas", $dp);
    ?>

    <!--<style type="text/css">
        table { border: 1px solid black; border-collapse: collapse }
        td { border: 1px solid black }
    </style>-->

    <form enctype="multipart/form-data" action="" method="post">
        <input type="checkbox" name="buscar[]" value="fecha"><label>Fecha:</label> <input type="date" name="fecha" value="<?php echo date('Y-m-d'); ?>"/><br><br>

        <input type="checkbox" name="buscar[]" value="numero"><label>Nº de factura:</label> <input type="number" name="num"/><br><br>

        <input type="checkbox" name="buscar[]" value="cliente"><label>Cliente:</label> 
        <select name="cli1" onchange="changeCliman(this)" style="white-space:pre-wrap; width: 100px;" >
            <option selected="selected"></option>
            <option value="1">Otro</option>
            <?php
            $sql = "SELECT existe_cli, cliente FROM facturas GROUP BY cliente";
            $clis = mysql_query($sql);
            while ($row = mysql_fetch_assoc($clis)) {
                if ($row[existe_cli] == 0) {
                    print("<option value='".$row[cliente]."'>$row[cliente]</option>");
                } else {
                    $sqlc = mysql_query("SELECT direccion,cif FROM clientes WHERE cif='$row[cliente]'");
                    $direccion = mysql_result($sqlc,0,0);
                    $cif = mysql_result($sqlc,0,1);
                    print("<option value='".$cif."'>$direccion</option>");
                }
            }
            ?>
            <!--<?php
            /*$sql = "SELECT * FROM clientes";
            $clis = mysql_query($sql);
            while ($row = mysql_fetch_assoc($clis)) {
                print("<option value='".$row[direccion]."|".$row[cif]."'>$row[direccion]</option>");
            }*/
            ?>-->
        </select>
        <input id="cif1" type="text" name="cif1" value="" style="display: none" disabled/>
        <textarea id="cliente1" name="cliente1" rows="5" style="display: none"></textarea><br><br>

        <input type="checkbox" name="buscar[]" value="concepto">
        <label>Concepto:</label> 
        <select name="conce" onchange="changeConInde(this)" style="white-space:pre-wrap; width: 250px;">
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
        <textarea id="text_area" name="concepto" rows="1" cols="50" style="display: none"></textarea><br><br>

        <input type="checkbox" name="buscar[]" value="iva"><label>IVA:</label> <input type="number" name="iva" value="21" Style="width:40Px"/><br><br>
        <input type="submit" name="buscar1" value="Buscar"/>
    </form>
    <?php
    if(isset($_POST['buscar1'])){
        $sele = "";

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

        if (IsChecked('buscar','fecha')){
            $fecha = $_POST['fecha'];
            if($sele == ""){
                $sele = "SELECT facturas.cod_fac as cod_fac,facturas.fecha as fecha, facturas.cliente as cliente, facturas.existe_cli as existe, facturas.iva as iva, facturas.detalles as detalles, tener_f_c.concepto as concepto, tener_f_c.cantidad as cantidad, tener_f_c.precio_u as precio FROM facturas, tener_f_c WHERE facturas.cod_fac=tener_f_c.cod_fac AND facturas.fecha='$fecha'";
            } else {
                $sele = $sele." AND facturas.fecha='$fecha'";
            }
        }

        if (IsChecked('buscar','numero')){
            $numero = $_POST['num'];
            if($sele == ""){
                $sele = "SELECT facturas.cod_fac as cod_fac,facturas.fecha as fecha, facturas.cliente as cliente, facturas.existe_cli as existe, facturas.iva as iva, facturas.detalles as detalles, tener_f_c.concepto as concepto, tener_f_c.cantidad as cantidad, tener_f_c.precio_u as precio FROM facturas, tener_f_c WHERE facturas.cod_fac=tener_f_c.cod_fac AND facturas.cod_fac=$numero";
            } else {
                $sele = $sele." AND facturas.cod_fac=$numero";
            }
        }

        if (IsChecked('buscar','cliente')){
            if($sele == ""){
                if ($_POST['cli1'] == 1) {
                    $cli1 = $_POST['cliente1'];
                    $sele = "SELECT facturas.cod_fac as cod_fac,facturas.fecha as fecha, facturas.cliente as cliente, facturas.existe_cli as existe, facturas.iva as iva, facturas.detalles as detalles, tener_f_c.concepto as concepto, tener_f_c.cantidad as cantidad, tener_f_c.precio_u as precio FROM facturas, tener_f_c WHERE facturas.cod_fac=tener_f_c.cod_fac AND facturas.cliente LIKE '%$cli1%'";
                } else {
                    $inscli = $_POST['cli1'];
                    $sele = "SELECT facturas.cod_fac as cod_fac,facturas.fecha as fecha, facturas.cliente as cliente, facturas.existe_cli as existe, facturas.iva as iva, facturas.detalles as detalles, tener_f_c.concepto as concepto, tener_f_c.cantidad as cantidad, tener_f_c.precio_u as precio FROM facturas, tener_f_c WHERE facturas.cod_fac=tener_f_c.cod_fac AND facturas.cliente='$inscli'";
                }
            } else {
                if ($_POST['cli1'] == 1) {
                    $cli1 = $_POST['cliente1'];
                    $sele = $sele." AND facturas.cliente LIKE '%$cli1%'";
                } else {
                    $inscli = $_POST['cli1'];
                    $sele = $sele." AND facturas.cliente='$inscli'";
                }
            }
        }

        if (IsChecked('buscar','concepto')){
            $concep = $_POST['conce'];
            if ($concep == 1) {
                $concepto = $_POST['concepto'];
            } else {
                $concepto = $concep;
            }
            if($sele == ""){
                $sele = "SELECT facturas.cod_fac as cod_fac,facturas.fecha as fecha, facturas.cliente as cliente, facturas.existe_cli as existe, facturas.iva as iva, facturas.detalles as detalles, tener_f_c.concepto as concepto, tener_f_c.cantidad as cantidad, tener_f_c.precio_u as precio FROM facturas, tener_f_c WHERE tener_f_c.cod_fac=facturas.cod_fac AND tener_f_c.concepto LIKE '%$concepto%'";
            } else {
                $sele = $sele." AND tener_f_c.cod_fac=facturas.cod_fac AND tener_f_c.concepto LIKE '%$concepto%'";
            }
        }

        if (IsChecked('buscar','iva')){
            $iva = $_POST['iva'];
            if($sele == ""){
                $sele = "SELECT facturas.cod_fac as cod_fac,facturas.fecha as fecha, facturas.cliente as cliente, facturas.existe_cli as existe, facturas.iva as iva, facturas.detalles as detalles, tener_f_c.concepto as concepto, tener_f_c.cantidad as cantidad, tener_f_c.precio_u as precio FROM facturas, tener_f_c WHERE facturas.cod_fac=tener_f_c.cod_fac AND facturas.IVA=$iva";
            } else {
                $sele = $sele." AND facturas.IVA=$iva";
            }
        }

        if (!IsChecked('buscar','fecha') && !IsChecked('buscar','numero') && !IsChecked('buscar','cliente') && !IsChecked('buscar','concepto') && !IsChecked('buscar','iva')) {
            $sele = "SELECT facturas.cod_fac as cod_fac,facturas.fecha as fecha, facturas.cliente as cliente, facturas.existe_cli as existe, facturas.iva as iva, facturas.detalles as detalles, tener_f_c.concepto as concepto, tener_f_c.cantidad as cantidad, tener_f_c.precio_u as precio FROM facturas, tener_f_c WHERE facturas.cod_fac=tener_f_c.cod_fac";
            echo "¡ATENCIÓN! ¡Puede que te hayas olvidado de seleccionar los CheckBox!<br/><br/>";
        }
        $sele = $sele." GROUP BY facturas.cod_fac ORDER BY facturas.cod_fac";
        //echo $sele;
        $selec = mysql_query($sele);
        if (mysql_num_rows($selec) == 0){
            echo "<br/>¡ERROR! No hay facturas que cumplan esas condiciones.";
        }else{
            $num_fila = 0; 
            echo "<table border=1 style='border: 1px solid black; border-collapse: collapse;width: 100%;'>";
            while ($row = mysql_fetch_assoc($selec)) {
                echo "<tr><td><table style='width: 100%;'>";
                echo "<tr bgcolor=\"bbbbbb\" align=center><th>Codigo</th><th style='width: 15%;'>Fecha</th><th>Cliente</th><th>CIF</th><th style='width: 15%;'>IVA %</th></tr>";
                $precio = 0;
                echo "<tr "; 
                if ($num_fila%2==0) 
                    echo "bgcolor=#dddddd"; //si el resto de la división es 0 pongo un color 
                else 
                    echo "bgcolor=#ddddff"; //si el resto de la división NO es 0 pongo otro color 
                //,facturas.fecha as fecha, facturas.cliente as cliente, facturas.existe_cli as existe, facturas.iva as iva, facturas.detalles as detalles, tener_f_c.concepto as concepto, tener_f_c.cantidad as cantidad, tener_f_c.precio as precio
                echo ">";
                echo "<td>$row[cod_fac]</td>";
                $fecha = date_format(date_create_from_format('Y-m-d', $row['fecha']), 'd/m/Y');
                echo "<td style='text-align:center'>$fecha</td>";
                $exis = "$row[existe]";
                if ($exis==0) {
                    echo "<td>";
                    echo nl2br($row['cliente']);
                    echo "</td><td></td>";
                }else{

                    $selec3 = mysql_query("SELECT direccion,cif FROM clientes WHERE cif='$row[cliente]'");
                    $direccion = mysql_result($selec3,0,0);
                    $cif = mysql_result($selec3,0,1);
                    echo "<td>";
                    echo nl2br($direccion);
                    echo "</td>";
                    echo "<td>$cif</td>";
                    //while ($row3 = mysql_fetch_assoc($selec3)) {
                        //echo "<td>$row3[direccion]</td>";
                        //echo "<td>$row3[cif]</td>";
                    //}
                }
                echo "<td style='text-align:center'>$row[iva]%</td></tr>";
                if ($row['detalles'] != NULL) {
                    echo "<tr "; 
                    if ($num_fila%2==0) 
                        echo "bgcolor=#dddddd"; //si el resto de la división es 0 pongo un color 
                    else 
                        echo "bgcolor=#ddddff"; //si el resto de la división NO es 0 pongo otro color 
                    echo ">";

                    echo "<td colspan=5><b>Detalles:</b><br/>$row[detalles]</td>";

                    echo "</tr>";
                }
                $seleccu = mysql_query("SELECT cuenta_laboral,cuenta_kutxa FROM facturas WHERE cod_fac=$row[cod_fac]");
                $laboral = mysql_result($seleccu,0,0);
                $kutxa = mysql_result($seleccu,0,1);
                
                if ($laboral != NULL) {
                    echo "<tr "; 
                    if ($num_fila%2==0) 
                        echo "bgcolor=#dddddd"; //si el resto de la división es 0 pongo un color 
                    else 
                        echo "bgcolor=#ddddff"; //si el resto de la división NO es 0 pongo otro color 
                    echo ">";
                    echo "<td colspan=5>$laboral</td></tr>";
                }
                if ($kutxa != NULL) {
                    echo "<tr "; 
                    if ($num_fila%2==0) 
                        echo "bgcolor=#dddddd"; //si el resto de la división es 0 pongo un color 
                    else 
                        echo "bgcolor=#ddddff"; //si el resto de la división NO es 0 pongo otro color 
                    echo ">";
                    echo "<td colspan=5>$kutxa</td></tr>";
                }
                
                echo "</table>";
                echo "<table style='width: 100%;'>";

                echo "<tr bgcolor=\"bbbbbb\" align=center><th colspan=2 style='width: 70%;'>Concepto</th><th style='width: 15%;'>Cantidad</th><th style='width: 15%;'>Precio</th></tr>";
                $selec2 = mysql_query("SELECT concepto, cantidad, precio_u as precio FROM tener_f_c WHERE cod_fac='$row[cod_fac]' ORDER BY orden");
                while ($row2 = mysql_fetch_assoc($selec2)) {
                    echo "<tr "; 
                    if ($num_fila%2==0) 
                        echo "bgcolor=#dddddd"; //si el resto de la división es 0 pongo un color 
                    else 
                        echo "bgcolor=#ddddff"; //si el resto de la división NO es 0 pongo otro color 
                    echo ">";
                    echo "<td colspan=2>$row2[concepto]</td>";
                    echo "<td style='text-align:right'>$row2[cantidad]</td>";
                    echo "<td style='text-align:right'>$row2[precio]€</td>";
                    //echo "<td colspan=3>";
                    echo "</tr>";
                    $precio = $precio + ($row2['precio'] * $row2['cantidad']);
                }
                echo "<tr bgcolor=\"bbbbbb\" align=center><th style='width: 55%;'></th><th style='width: 15%;'>Subtotal</th><th style='width: 15%;'>IVA €</th><th style='width: 15%;'>TOTAL</th></tr>";
                echo "<tr "; 
                if ($num_fila%2==0) 
                    echo "bgcolor=#dddddd"; //si el resto de la división es 0 pongo un color 
                else 
                    echo "bgcolor=#ddddff"; //si el resto de la división NO es 0 pongo otro color 
                echo ">";
                echo "<td></td>";
                echo "<td style='text-align:right'>$precio €</td>";
                $ivatot = $precio * $row['iva'] / 100;
                echo "<td style='text-align:right'>$ivatot €</td>";
                $total = $ivatot + $precio;
                echo "<th style='color:red'>$total €</th>";
                //echo "</tr>";
                //echo "<td>$row[precio]€</td>";
                //echo "<td><a href=\"edit_conce.php?concepto=$row[cod_con]\"><input type=\"button\" value=\"Editar\"></a></td>";
                //echo "<td><button onclick=\"seguroFac($row[cod_con]);\">Delete</button></td>";
                echo "</table></td>";
                echo "<td><button onclick=\"window.location.href='edit_factura.php?cod_fac=$row[cod_fac]'\" class='button1'>Editar</button></td>";
                echo "<td><button onclick=\"window.location.href='inc/crear_excell.php?cod_fac=$row[cod_fac]'\" class='button2'>Crear Excel</button>";
                echo "<br/><button onclick=\"window.location.href='inc/crear_pdf.php?cod_fac=$row[cod_fac]'\" class='button2'>Crear PDF</button></td>";
                echo "<td><button onclick=\"seguroFac($row[cod_fac]);\" class='button1'>Eliminar</button></td></tr>";

                

                
                $num_fila++;
            }
            echo "</table><br/> Se han encontrado $num_fila facturas que cumplen esas condiciones.";
        }
    }
    mysql_close($dp);
    ?>
</div>
</body>
</html>