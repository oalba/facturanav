<html>
<head>
<title>Editar concepto</title>
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
	<h1><u><i>Editar concepto</i></u></h1>
<?php
$data = $_GET['cod_con'];

$dp = mysql_connect("localhost", "root", "" );
mysql_select_db("facturas", $dp);

$sql = "SELECT * FROM conceptos WHERE cod_con=$data";
$phones = mysql_query($sql);

$num_fila = 0; 
echo "<table border=1>";
echo "<tr bgcolor=\"bbbbbb\" align=center><th>Concepto</th><th>Precio</th></tr>";
while ($row = mysql_fetch_assoc($phones)) {
	//echo "<form enctype='multipart/form-data' action='t_edit.php?telephone=$row[Telephone]' method='post'>";
	echo "<form enctype='multipart/form-data' action='' method='post'>";
	echo "<tr "; 
   	if ($num_fila%2==0) 
      	echo "bgcolor=#dddddd"; //si el resto de la división es 0 pongo un color 
   	else 
      	echo "bgcolor=#ddddff"; //si el resto de la división NO es 0 pongo otro color 
   	echo ">";
    echo "<td><textarea name='concepto' rows='3' cols='50'>$row[concepto]</textarea></td>";
    echo "<td><input type='number' name='precio' step='any' Style='width:60Px' value='$row[precio]'>€</td>";
	echo "<td><input type='submit' name='guardar' value='Guardar' class='button1'/></td>";
	echo "</tr>";
	echo "</form>";
	$num_fila++; 
};
echo "</table>";

if(isset($_POST['guardar'])){
//$tlf = $_POST['telephone'];
$concepto = $_POST['concepto'];
$precio = $_POST['precio'];
$concepto = trim(preg_replace('/\s\s+/', ' ', $concepto));

$aldatu="UPDATE conceptos SET concepto='$concepto',precio='$precio' WHERE cod_con=$data";
mysql_query($aldatu);
header("Refresh:0");
}
mysql_close($dp);
?>
<br/>
<a href="manage_conce.php"><input type="button" value="Atrás"></a>
</div>
</body>
</html>