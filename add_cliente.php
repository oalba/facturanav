<!DOCTYPE html>
<html lang="es">
<head>
<title>Añadir cliente</title>
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
    <li><a href="manage_conce.php">Conceptos</a>
        <ul>
            <li><a href="manage_conce.php">Administrar</a></li>
            <li><a href="add_conce.php">Añadir</a></li>
        </ul>
    </li>
    <li><a class="active" href="manage_cliente.php">Clientes</a>
        <ul>
            <li><a href="manage_cliente.php">Administrar</a></li>
            <li><a class="active" href="add_cliente.php">Añadir</a></li>
        </ul>
    </li>
    <li class="about"><a href="about.html">About</a></li>
</ul>
</div>
</header>
<div class="cuerpo">
    <h1><u><i>Nuevo cliente</i></u></h1>
Añadir cliente: <br/><br/>
<form enctype='multipart/form-data' action='' method='post'>
Dirección: <br/><textarea name="direccion" rows="5"></textarea><br/><br/>
CIF: <input type="text" name="cif" required/><br/><br/>
Cuenta: <input type="text" name="cuenta" size="30"/><br/><br/>
<input type='submit' name='guardar' value='Guardar'/><br/>
</form>

<?php
if(isset($_POST['guardar'])){
    $direccion = $_POST['direccion'];
    $cif = $_POST['cif'];
    $cuenta = $_POST['cuenta'];

    $dp = mysql_connect("localhost", "root", "" );
	mysql_select_db("facturas", $dp);

	$sql = "SELECT * FROM clientes WHERE cif='$cif'";
	$clis = mysql_query($sql);
	if (mysql_num_rows($clis) == 0){
        $anadir="INSERT INTO clientes(cif,direccion,cuenta) VALUES ('$cif','$direccion','$cuenta')";
		mysql_query($anadir);
        echo "Cliente añadido correctamente.<br/>";
    } else {
		echo "¡ERROR! Este cliente ya existe.";
        $num_fila = 0; 
        echo "<table border=1>";
        echo "<tr bgcolor=\"bbbbbb\" align=center><th>CIF</th><th>Dirección</th><th>Cuenta</th></tr>";
        while ($row = mysql_fetch_assoc($clis)) {
            echo "<tr "; 
            if ($num_fila%2==0) 
                echo "bgcolor=#dddddd"; //si el resto de la división es 0 pongo un color 
            else 
                echo "bgcolor=#ddddff"; //si el resto de la división NO es 0 pongo otro color 
            echo ">";
            echo "<td>$row[cif]</td>";
            echo "<td>$row[direccion]</td>";
            echo "<td>$row[cuenta]</td>";
            echo "<td><a href=\"edit_cliente.php?cif=$row[cif]\"><input type=\"button\" value=\"Editar\"></a></td>";
            //echo "<td><button onclick=\"seguro($row[cod_con]);\">Delete</button></td>";
            echo "</tr>";
            $num_fila++;
        }
        echo "</table><br/>";
    }
	mysql_close($dp);

}
?>
</div>
<a href="#" class="go-top" id="go-top">Subir</a>
</body>
</html>