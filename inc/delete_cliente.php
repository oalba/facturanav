<?php
$data = $_GET['cif'];

$dp = mysql_connect("localhost", "root", "" );
mysql_select_db("facturas", $dp);

$sele  =mysql_query("SELECT direccion FROM clientes WHERE cif='$data'");
$direccion = mysql_result($sele,0,0);

$update="UPDATE facturas SET existe_cli=0, cliente='$direccion' WHERE cliente='$data'";
mysql_query($update);

$eliminar="DELETE FROM clientes WHERE cif='$data'";
mysql_query($eliminar);
header("Location: ../manage_cliente.php");

mysql_close($dp);
?>