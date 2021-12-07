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
$query_rs1 = sprintf("SELECT * FROM calles WHERE tipo = %s ORDER BY nombre ASC", GetSQLValueString($colname_rs1, "text"));
$rs1 = mysql_query($query_rs1, $cn1) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
$totalRows_rs1 = mysql_num_rows($rs1);

	
	// Comienzo a imprimir el select
	echo "<select name='dir_id' id='dir_id' onChange='document.forms[0].dir_nombre.value=(this.options[this.selectedIndex].text);' class='left' size='10' >";
	//echo "<option value='0'>Elige &raquo;</option>";
	do { 
		//echo "<option value='".$row_rs1['id']."'>".$row_rs1['nombre']."</option>";
		echo "<option value='".$row_rs1['id']."'>".$row_rs1['nombre']."</option>";
	}while ($row_rs1 = mysql_fetch_assoc($rs1));
	echo "</select>";

mysql_free_result($rs1);
?>