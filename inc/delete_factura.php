<?php
$data = $_GET['cod_fac'];

$dp = mysql_connect("localhost", "root", "" );
mysql_select_db("facturas", $dp);

$selectfac = mysql_query("SELECT * FROM facturas WHERE cod_fac=$data");
$selectten = mysql_query("SELECT * FROM tener_f_c WHERE cod_fac=$data");
while ($row = mysql_fetch_assoc($selectfac)) {
	mysql_query("INSERT INTO deleted_facturas (cod_fac,fecha,IVA,existe_cli,cliente,cuenta_laboral,cuenta_kutxa,detalles) VALUES ($row[cod_fac],'$row[fecha]',$row[IVA],$row[existe_cli],'$row[cliente]','$row[cuenta_laboral]','$row[cuenta_kutxa]','$row[detalles]')");
}
while ($row2 = mysql_fetch_assoc($selectten)) {
	mysql_query("INSERT INTO deleted_tener_f_c (orden,concepto,cod_fac,cantidad,precio_u) VALUES ($row2[orden],'$row2[concepto]',$row2[cod_fac],$row2[cantidad],'$row2[precio_u]')");
}

$eliminar="DELETE FROM tener_f_c WHERE cod_fac=$data";
mysql_query($eliminar);
$eliminar2="DELETE FROM facturas WHERE cod_fac=$data";
mysql_query($eliminar2);
header("Location: ../index.php");

mysql_close($dp);
?>