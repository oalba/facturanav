<!DOCTYPE html>
<html lang="es">
<head>
<title>Añadir concepto</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="shortcut icon" href="images/icon.png" type="image/png"/>
<link rel="stylesheet" type="text/css" href="css/estilo.css">
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
    <li><a class="active" href="manage_conce.php">Conceptos</a>
        <ul>
            <li><a href="manage_conce.php">Administrar</a></li>
            <li><a class="active" href="add_conce.php">Añadir</a></li>
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
    <h1><u><i>Nuevo concepto</i></u></h1>
Añadir concepto: <br/><br/>
<table border=0>
    <tr><th>Concepto</th><th>Precio</th></tr>
    <form enctype='multipart/form-data' action='' method='post'>
        <tr>
            <td><textarea name='concepto' rows="1" cols="50"></textarea></td>
            <td><input type='number' name='precio' step="any" Style="width:60Px">€</td>
            <td><input type='submit' name='guardar' value='Guardar'/></td>
        </tr>
    </form>
</table>

<?php
if(isset($_POST['guardar'])){
    $conce = $_POST['concepto'];
    $precio = $_POST['precio'];
    $conce = trim(preg_replace('/\s\s+/', ' ', $conce));

    $dp = mysql_connect("localhost", "root", "" );
	mysql_select_db("facturas", $dp);

    $sql = "SELECT * FROM conceptos WHERE concepto='$conce'";
    $cons = mysql_query($sql);
    if (mysql_num_rows($cons) == 0){
        $sartu="INSERT INTO conceptos (concepto, precio) VALUES ('$conce', '$precio')";
        mysql_query($sartu);
        echo "Concepto añadido correctamente.<br/>";
    } else {
        echo "¡ERROR! Este concepto ya existe.";
        $num_fila = 0; 
        echo "<table border=1>";
        echo "<tr bgcolor=\"bbbbbb\" align=center><th>Concepto</th><th>Precio</th></tr>";
        while ($row = mysql_fetch_assoc($cons)) {
            echo "<tr "; 
            if ($num_fila%2==0) 
                echo "bgcolor=#dddddd"; //si el resto de la división es 0 pongo un color 
            else 
                echo "bgcolor=#ddddff"; //si el resto de la división NO es 0 pongo otro color 
            echo ">";
            echo "<td>$row[concepto]</td>";
            echo "<td>$row[precio]€</td>";
            echo "<td><button onclick=\"window.location.href='edit_conce.php?cod_con=$row[cod_con]'\">Editar</button></td>";
            echo "</tr>";
            $num_fila++;
        }
        echo "</table><br/>";
    }

    mysql_close($dp);
}
?>
</div>
</body>
</html>