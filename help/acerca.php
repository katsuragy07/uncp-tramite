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

mysql_select_db($database_cn1, $cn1);
$query_rs1 = "SELECT VERSION() AS version";
$rs1 = mysql_query($query_rs1, $cn1) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
$totalRows_rs1 = mysql_num_rows($rs1);
?>
<?php
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO empleado (id, nombre, apellido, mail, oficinas_id, encargado) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['apellido'], "text"),
							  GetSQLValueString($_POST['mail'], "text"),
							  GetSQLValueString($_POST['oficinas_id'], "int"),
                       GetSQLValueString($_POST['encargado'], "int"));

  mysql_select_db($database_cn1, $cn1);
  $Result1 = mysql_query($insertSQL, $cn1) or die(mysql_error());

  $insertGoTo = "mperso.php?pk=".$_GET['pk'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/int.css" rel="Stylesheet" type="text/css" />
<style>
#wpag{background:transparent url(../images/pico_10.jpg) no-repeat fixed bottom right;}
</style>

<script type="text/javascript">function dlitem(ord){if(confirm("Deseas eliminar este registro?")){document.location.href= '../opers/del_perso.php?pk='+ord;}}</script> 

</head>
<body>
 <div id="container"><div id="wpag"><div id="content">

<h1><span id="result_box" lang="es" xml:lang="es"><span title="">Ayuda y soporte técnico</span></span></h1>
<div class="hr"><em></em><span></span></div>

<div class="clear" style="height:5px"></div>
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>


<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">
    <h4>Acerca del sistema</h4>
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
        <tr valign="baseline">
          <td width="200" align="right" valign="middle" class="btit_3">Nombre</td>
          <td>Sistema de Tr&aacute;mite Documentario</td>
          </tr>
        <tr valign="baseline">
          <td width="200" align="right" valign="middle" class="btit_3">Año de desarrollo</td>
          <td>2019</td>
        </tr>
        <tr valign="baseline">
          <td width="200" align="right" valign="middle" class="btit_3">Versión del sistema</td>
          <td>1.0</td>
          </tr>

        
        
      </table>
      <?php if($vrs1==0){?>
      <h4>Estado del servidor</h4>
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
        <tr valign="baseline">
          <td width="200" align="right" valign="middle" class="btit_3">Versión PHP</td>
          <td><?php echo phpversion();?></td>
        </tr>
        <tr valign="baseline">
          <td width="200" align="right" valign="middle" class="btit_3">Versión MySQL</td>
          <td><?php echo $row_rs1['version']; ?></td>
          </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" class="btit_3">Fecha y hora de Apache</td>
          <td><?php echo date("d/m/Y H:m:s A"); ?></td>
        </tr>
        <tr valign="baseline">
          <td width="200" align="right" valign="middle" class="btit_3">Tamaño del disco</td>
          <td valign="middle"><?php echo dinfo(1);?>
          </td>
        </tr>
        <tr valign="baseline">
          <td width="200" align="right" valign="middle" class="btit_3">Espacio Ocupado</td>
          <td><?php echo dinfo(2);?></td>
        </tr>
        <tr valign="baseline">
          <td width="200" align="right" valign="middle" class="btit_3">Espacio Libre</td>
          <td><?php echo dinfo(3);?></td>
        </tr>
        <tr valign="baseline">
          <td width="200" align="right" valign="middle" class="btit_3">Porcentaje de espacio usado</td>
          <td><?php echo dinfo(4);?></td>
        </tr>
        <tr valign="baseline">
          <td width="200" align="right" valign="middle" class="btit_3">Porcentaje de espacio libre</td>
          <td><?php echo dinfo(5);?></td>
        </tr>
      </table>
      <?php } ?>
        </td>
    <td width="20" valign="top">&nbsp;</td>
    <td width="250" valign="top"><?php include("../includes/bar_help.php");?></td>
  </tr>
</table>
</div></div></div>

</body>
</html>
<?php
mysql_free_result($rs1);
?>
