<html>
<head>
<title>Administrar conceptos</title>
<link rel="stylesheet" type="text/css" href="estilo.css">
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
            <li><a class="active" href="manage_conce.php">Administrar</a></li>
            <li><a href="add_conce.php">Añadir</a></li>
        </ul>
    </li>
    <li><a href="manage_cliente.php">Clientes</a>
        <ul>
            <li><a href="manage_cliente.php">Administrar</a></li>
            <li><a href="add_cliente.php">Añadir</a></li>
        </ul>
    </li>
    <li style="float:right;list-style-type:none;margin: 0 0 10px 10px;"><a href="about.html">About</a></li>
</ul>
</div>
</header>
<div class="cuerpo">
	<h1><u><i>Administrar conceptos</i></u></h1>
<form enctype="multipart/form-data" action="" method="post">
	Insertar dato: <br/>
	<textarea name="data" rows="3" cols="50" placeholder="Concepto o Precio"></textarea><br/><br/>
	Ordenar por: 
	<select name="orden">
		<option value="concepto" selected>Concepto</option>
		<option value="precio">Precio</option>
	</select>
	<input type="submit" name="buscar" value="Buscar"/>
</form>
<?php 
if(isset($_POST['buscar'])){
$data = $_POST['data'];
$orden = $_POST['orden'];

$dp = mysql_connect("localhost", "root", "" );
mysql_select_db("facturas", $dp);

$sql = "SELECT * FROM conceptos WHERE concepto LIKE '%$data%' OR precio LIKE '%$data%' ORDER BY $orden";
$conce = mysql_query($sql);

$conce2 = mysql_query($sql);
$zenbat = 0;
while ($row2 = mysql_fetch_assoc($conce2)) {
 $zenbat = $zenbat+1;
};
echo "$zenbat conceptos en total.";

$num_fila = 0; 
echo "<table border=1>";
echo "<tr bgcolor=\"bbbbbb\" align=center><th>Concepto</th><th>Precio</th></tr>";
while ($row = mysql_fetch_assoc($conce)) {
	echo "<tr "; 
   	if ($num_fila%2==0) 
      	echo "bgcolor=#dddddd"; //si el resto de la división es 0 pongo un color 
   	else 
      	echo "bgcolor=#ddddff"; //si el resto de la división NO es 0 pongo otro color 
   	echo ">";
	echo "<td>$row[concepto]</td>";
    echo "<td>$row[precio]€</td>";
	echo "<td><button onclick=\"window.location.href='edit_conce.php?cod_con=$row[cod_con]'\">Editar</button></td>";
	echo "<td><button onclick=\"seguro($row[cod_con],'$row[concepto]');\">Eliminar</button></td>";
	//echo "<td><button onclick=\"window.location.href='edit_conce.php?cod_con=$row[cod_con]'\" class='button1'>Editar</button></td>";
	//echo "<td><button onclick=\"seguro($row[cod_con],'$row[concepto]');\" class='button1'>Eliminar</button></td>";
	echo "</tr>";
	$num_fila++; 
};
echo "</table><br/>";
echo "¿No está aquí? <a href='add_conce.php'><input type='button' value='Añadir'></a>";

mysql_close($dp);
}
?>
<script type="text/javascript">
function seguro($cod,$con){
//var con = document.getElementById('cod_con').value;
confirmar=confirm("¿Seguro que quieres eliminar el concepto \"" + $con + "\"?"); 
	if (confirmar) {
		// si pulsamos en aceptar
		alert('El concepto será eliminado.');
		window.location='delete_con.php?cod_con='+$cod;
		return true;
	}else{ 
		// si pulsamos en cancelar
		return false;
	}			
}
</script>
</div>
</body>
</html>