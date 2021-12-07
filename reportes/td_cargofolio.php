<?php require_once('../Connections/cn1.php'); ?>
<?php require_once('../includes/functions.php'); ?>
<?php require_once('../includes/permisos_all_ui.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_rs1 = "-1";
if (isset($_GET['pk'])) {
  $colname_rs1 = $_GET['pk'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs1 = sprintf("
SELECT folioext.*
,(SELECT CONCAT(empleado.apellido,', ',empleado.nombre) FROM empleado WHERE folioext.empid=empleado.id)AS enombre
,(SELECT CONCAT(lugares.nombre,' | ',oficinas.nombre) FROM oficinas,lugares,folioext WHERE oficinas.id=folioext.c_oficina AND oficinas.lugares_id=lugares.id LIMIT 1) AS conombre

,(SELECT oficinas.nombre FROM oficinas WHERE oficinas.id = folioext.c_oficina LIMIT 1)AS onombre


FROM folioext 
WHERE folioext.id=%s", GetSQLValueString($colname_rs1, "int"));
$rs1 = mysql_query($query_rs1, $cn1) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
$totalRows_rs1 = mysql_num_rows($rs1);

$colname_rs2 = "-1";
if (isset($_GET['pk'])) {
  $colname_rs2 = $_GET['pk'];
}

mysql_select_db($database_cn1, $cn1);
$query_rs2 = "SELECT log_archivo.*
,(SELECT CONCAT(empleado.apellido,', ',empleado.nombre) FROM empleado WHERE log_archivo.empid=empleado.id)AS enombre
,(SELECT CONCAT(lugares.nombre,' | ',oficinas.nombre) FROM oficinas,lugares,empleado 
WHERE empleado.id=log_archivo.empid AND oficinas.lugares_id=lugares.id AND oficinas.id = empleado.oficinas_id
LIMIT 1) AS onombre
,(SELECT oficinas.nombre FROM oficinas WHERE oficinas.id = log_archivo.c_oficina LIMIT 1)AS conombre

FROM log_archivo
WHERE log_archivo.folioext_id=$colname_rs2 
ORDER BY log_archivo.fecha ASC";
$rs2 = mysql_query($query_rs2, $cn1) or die(mysql_error());

$row_rs2 = mysql_fetch_assoc($rs2);
$totalRows_rs2 = mysql_num_rows($rs2);

$maxRows_rs3 = 500;
$pageNum_rs3 = 0;
if (isset($_GET['pageNum_rs3'])) {
  $pageNum_rs3 = $_GET['pageNum_rs3'];
}
$startRow_rs3 = $pageNum_rs3 * $maxRows_rs3;

$colname_rs3 = "-1";
if (isset($_GET['pk'])) {
  $colname_rs3 = $_GET['pk'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs3 = sprintf("SELECT log_derivar.*
,(SELECT CONCAT(empleado.apellido,', ',empleado.nombre) FROM empleado WHERE log_derivar.empid=empleado.id)AS enombre
,(SELECT CONCAT(lugares.nombre,' | ',oficinas.nombre) FROM oficinas,lugares,folioext WHERE oficinas.id=log_derivar.d_oficina AND oficinas.lugares_id=lugares.id LIMIT 1)AS onombre
FROM log_derivar
WHERE log_derivar.folioext_id=%s
ORDER BY log_derivar.fecha ASC", GetSQLValueString($colname_rs3, "int"));
$query_limit_rs3 = sprintf("%s LIMIT %d, %d", $query_rs3, $startRow_rs3, $maxRows_rs3);
$rs3 = mysql_query($query_limit_rs3, $cn1) or die(mysql_error());
$row_rs3 = mysql_fetch_assoc($rs3);

if (isset($_GET['totalRows_rs3'])) {
  $totalRows_rs3 = $_GET['totalRows_rs3'];
} else {
  $all_rs3 = mysql_query($query_rs3);
  $totalRows_rs3 = mysql_num_rows($all_rs3);
}
$totalPages_rs3 = ceil($totalRows_rs3/$maxRows_rs3)-1;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../images/favprint.ico" />
<title>Variaci&oacute;n del impuesto m&iacute;nimo - <?php include("../includes/title.php");?></title>
<link href="../css/print.css" rel="Stylesheet" type="text/css" />
<style type="text/css">
@media print {.alert{visibility: hidden;margin-top:-20px;height:0px;padding:0;}}
</style>
</head>
<body>

<?php include("../includes/print.php");?>
<div id="ticket" align="center">
<?php include("../includes/pcab_tram.php");?>

<div class="clear" style="height:5px;border-bottom:2px solid #000;"></div>
<h2 style="font-family:Arial, Helvetica, sans-serif">Datos del expediente</h2>
<div class="clear" style="border-bottom:2px solid #000;margin-bottom:5px;"></div>

<div class="cont">
<p><strong>Expediente Nº: <?php 
$barcode = ($row_rs1['td_tipos_id'].$row_rs1['exp'].substr($row_rs1['fecha'],0,4));
echo $barcode;

?></strong></p>
<p><strong>Solicitante:</strong> <?php echo $row_rs1['firma']; ?></p>
<p><strong>Asunto:</strong> <?php echo $row_rs1['asunto']; ?></p>
<p><strong>Unidad org&aacute;nica:</strong> <?php echo $row_rs1['onombre']; ?></p>

<p><strong>N° de Folios:</strong> <?php echo $row_rs1['nfolios']; ?></p>
<p><strong>Observaciones:</strong> <?php echo $row_rs1['obs']; ?></p>

</div>

<p>

<p><strong>Registrado por:</strong> <?php echo $row_rs1['enombre']; ?></p>
<div class="clear" style=""></div>
</p>

<img src="http://www.barcodesinc.com/generator/image.php?code=<?php echo $barcode; ?>&amp;style=453&amp;type=C128B&amp;width=298&amp;height=70&amp;xres=2&amp;font=1" alt="barcode" />

<div class="clear"></div>
</div>
</body>
</html>
<?php
mysql_free_result($rs1);

mysql_free_result($rs2);

mysql_free_result($rs3);
?>