<html>
<head>
<title>Administrar clientes</title>
<link rel="shortcut icon" href="icon.png" type="image/png"/>
<link rel="stylesheet" type="text/css" href="estilo.css">
<script type="text/javascript" src="scripts.js" ></script>
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
            <li><a class="active" href="manage_cliente.php">Administrar</a></li>
            <li><a href="add_cliente.php">Añadir</a></li>
        </ul>
    </li>
    <li class="about"><a href="about.html">About</a></li>
</ul>
</div>
</header>
<div class="cuerpo">
	<h1><u><i>Administrar clientes</i></u></h1>
<form enctype="multipart/form-data" action="" method="post">
	Insertar dato: <br/>
	<textarea name="data" rows="3" cols="50" placeholder="CIF, Dirección o Cuenta"></textarea><br/><br/>
	Ordenar por: 
	<select name="orden">
		<option value="cif" selected>CIF</option>
		<option value="direccion">Dirección</option>
		<option value="cuenta">Cuenta</option>
	</select>
	<input type="submit" name="buscar" value="Buscar"/>
</form>
<?php 
if(isset($_POST['buscar'])){
$data = $_POST['data'];
$orden = $_POST['orden'];

$dp = mysql_connect("localhost", "root", "" );
mysql_select_db("facturas", $dp);

$sql = "SELECT * FROM clientes WHERE cif LIKE '%$data%' OR direccion LIKE '%$data%' OR cuenta LIKE '%$data%' ORDER BY $orden";
$conce = mysql_query($sql);

$conce2 = mysql_query($sql);
$zenbat = 0;
while ($row2 = mysql_fetch_assoc($conce2)) {
 $zenbat = $zenbat+1;
};
echo "$zenbat clientes en total.";

$num_fila = 0; 
echo "<table border=1>";
echo "<tr bgcolor=\"bbbbbb\" align=center><th>CIF</th><th>Dirección</th><th>Cuenta</th></tr>";
while ($row = mysql_fetch_assoc($conce)) {
	echo "<tr "; 
   	if ($num_fila%2==0) 
      	echo "bgcolor=#dddddd"; //si el resto de la división es 0 pongo un color 
   	else 
      	echo "bgcolor=#ddddff"; //si el resto de la división NO es 0 pongo otro color 
   	echo ">";
	echo "<td>$row[cif]</td>";
    echo "<td>".nl2br($row['direccion'])."</td>";
    echo "<td>$row[cuenta]</td>";
	echo "<td><button onclick=\"window.location.href='edit_cliente.php?cif=$row[cif]'\" class='button1'>Editar</button></td>";
	echo "<td><button onclick=\"segurocli('$row[cif]');\" class='button1'>Eliminar</button></td>";
	echo "</tr>";
	$num_fila++; 
};
echo "</table><br/>";
echo "¿No está aquí? <a href='add_cliente.php'><input type='button' value='Añadir'></a>";

mysql_close($dp);
}
?>
</div>
</body>
</html>