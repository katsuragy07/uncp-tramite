<?php require_once('../Connections/cn1.php'); ?>
<?php require_once('../includes/functions.php'); ?>
<?php require_once('../includes/permisos_all_ui.php'); ?>
<?php

//$opcionSeleccionada=$_GET["opcion"];

$colname_rs1 = "-1";
if (isset($_GET["opcion"])) {
  $colname_rs1 = $_GET["opcion"];
}
mysql_select_db($database_cn1, $cn1);
$query_rs1 = sprintf("SELECT * FROM reqs WHERE id=%s", GetSQLValueString($colname_rs1, "text"));
$rs1 = mysql_query($query_rs1, $cn1) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
$totalRows_rs1 = mysql_num_rows($rs1);

	
echo "<h3>".$row_rs1['nombre']."</h3>";
echo ($row_rs1['descrip']);

mysql_free_result($rs1);
?>