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
,(SELECT CONCAT(lugares.nombre,' | ',oficinas.nombre) FROM oficinas,lugares,folioext WHERE oficinas.id=folioext.c_oficina AND oficinas.lugares_id=lugares.id LIMIT 1)AS onombre
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
LIMIT 1)AS onombre
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
<?php include("../includes/pcab_tram.php");?>
<h1>Expediente Externo &raquo; <?php echo $row_rs1['firma']; ?></h1>
<div class="clear" style="height:5px"></div>
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>


<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="58%" valign="top"> <h4>Datos del expediente</h4>
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
        <tr valign="baseline">
          <td width="80" align="right" valign="middle" class="btit_3">Firma</td>
          <td><?php echo $row_rs1['firma']; ?></td>
          </tr>
        <tr valign="baseline">
          <td width="80" align="right" valign="middle" class="btit_3">Tipo</td>
          <td><?php echo dftipo($row_rs1['t_tipo'],$row_rs1['t_otro']); ?></td>
        </tr>
        <tr valign="baseline">
          <td width="80" align="right" valign="middle" class="btit_3">Asunto</td>
          <td><?php echo $row_rs1['asunto']; ?></td>
        </tr>        
        <tr valign="baseline">
          <td width="80" align="right" valign="middle" class="btit_3">Cabecera</td>
          <td><?php echo $row_rs1['cabecera']; ?></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" class="btit_3">N° Folios</td>
          <td><?php echo $row_rs1['nfolios']; ?></td>
        </tr>
        <tr valign="baseline">
          <td width="80" align="right" valign="middle" class="btit_3">Observaciones</td>
          <td><?php echo $row_rs1['obs']; ?></td>
        </tr>        
      </table></td>
<td width="2%" valign="top">&nbsp;</td>
<td width="40%" valign="top"><h4>Datos de creación</h4>
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
        <tr valign="baseline">
          <td width="80" align="right" valign="middle" class="btit_3">Fecha</td>
          <td valign="middle"><?php echo dptiemp($row_rs1['fecha']);?></td>
          </tr>
        <tr valign="baseline">
          <td width="80" align="right" valign="middle" class="btit_3">Oficina</td>
          <td valign="middle"><?php echo $row_rs1['onombre']; ?></td>
        </tr>
        <tr valign="baseline">
          <td width="80" align="right" valign="middle" class="btit_3">Empleado</td>
          <td valign="middle"><?php echo $row_rs1['enombre']; ?></td>
        </tr>
        <tr valign="baseline">
          <td width="80" align="right" valign="middle" class="btit_3">  N° Interno</td>
          <td valign="middle"><?php echo dftipo($row_rs1['t_tipo'],$row_rs1['t_otro']); ?> <span class="min"><?php echo dcoidfo($row_rs1['exp'],$row_rs1['fecha']);?></span></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" class="btit_3">Código para búsqueda web:</td>
          <td valign="middle"><?php echo $row_rs1['t_tipo'].$row_rs1['exp'].date("Y",crt_datetime($row_rs1['fecha']));?></td>
        </tr>
      </table></td>
</tr>
</table>

   
    
      
            <h3>Seguimiento del expediente - Derivados</h3>
            <table width="90%" border="0" cellpadding="0" cellspacing="0" class="tabla2">
          <tr>
            <td width="20" align="center" class="btit_1">#</td>
            <td width="75" class="btit_1">Fecha</td>
            <td class="btit_1">Oficina</td>
            <td class="btit_1">Observaciones</td>
            <td class="btit_1">Forma</td>
            <td class="btit_1">Proveido</td>
            <?php if(dribbut($vrs1,$vrs3)){?>
            <?php } ?>
          </tr>
          <?php $cont=0; ?>
          <?php do { ?>
          <?php $cont++; ?>
          <?php if ($totalRows_rs3 > 0) { // Show if recordset not empty ?>
            <tr <?php echo dfolc($row_rs3['ope']); ?>>
              <td width="20" align="center"><?php echo $cont; ?></td>
              <td width="75"><span class="min"><?php echo dptiemp($row_rs3['fecha']);?></span></td>
              <td>A: <?php echo $row_rs3['onombre']; ?><br><span class="min">Por: <?php echo $row_rs3['enombre']; ?></span></td>
              <td><?php echo $row_rs3['obs']; ?></td>
              <td><?php echo dforma($row_rs3['forma']); ?></td>
              <td><?php echo $row_rs3['proveido']; ?></td>
              <?php if(dribbut($vrs1,$vrs3)){?>
              <?php } ?>
            </tr>
            <?php } // Show if recordset not empty ?>

          <?php } while ($row_rs3 = mysql_fetch_assoc($rs3)); ?>
      </table>
      
      <h3>Seguimiento del expediente - Archivados</h3>
            <table width="90%" border="0" cellpadding="0" cellspacing="0" class="tabla2">
          <tr>
            <td width="20" align="center" class="btit_1">#</td>
            <td width="75" class="btit_1">Fecha</td>
            <td class="btit_1">Oficina</td>
            <td class="btit_1">Observaciones</td>
            <td class="btit_1">Forma</td>
            <td class="btit_1">Proveido</td>
            <?php if(dribbut($vrs1,$vrs2)){?>
            <?php } ?>
          </tr>
          <?php $cont=0; ?>
          <?php do { ?>
          <?php $cont++; ?>
          <?php if ($totalRows_rs2 > 0) { // Show if recordset not empty ?>
            <tr <?php echo dfolc($row_rs2['ope']); ?>>
              <td width="20" align="center"><?php echo $cont; ?></td>
              <td width="75"><span class="min"><?php echo dptiemp($row_rs2['fecha']);?></span></td>
              <td><?php echo $row_rs2['onombre']; ?><br><span class="min"><?php echo $row_rs2['enombre']; ?></span></td>
              <td><?php echo $row_rs2['obs']; ?></td>
              <td><?php echo dforma($row_rs2['forma']); ?></td>
              <td><?php echo $row_rs2['proveido']; ?></td>
              <?php if(dribbut($vrs1,$vrs2)){?>
              <?php } ?>
            </tr>
            <?php } // Show if recordset not empty ?>

          <?php } while ($row_rs2 = mysql_fetch_assoc($rs2)); ?>
      </table>

    </td>
    </tr>
</table>

</body>
</html>
<?php
mysql_free_result($rs1);

mysql_free_result($rs2);

mysql_free_result($rs3);
?>