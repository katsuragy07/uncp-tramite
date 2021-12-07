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
    <td valign="top"><h2>Generalidades</h2>
      <p>Dentro del Sistema observará varios valores junto a los nombres o descripciones encerrados entre parentesis, sirven para informar de forma rápida sobre el estado de ese registro como:      </p>
      <h3>Gestión documentaria</h3>
      <p>Indica la cantidad de acciones que tiene el folio</p>
      <h2><strong><img src="help-17.jpg" width="263" height="181" class="right" style="margin-left:15px" /></strong>Opciones de página</h2>
      <p>Dentro de cada página verá a la derecha una columna bajo de nombre de &quot;Opciones&quot; que contiene todas las acciones, información rápida, enlaces y otros valores con referencia a la página activa.</p>
      <h3>Acciones</h3>
      <p>Contiene todas las acciones para la página o forumario actual como: Actualizar, cancelar, modificar, enlaces, etc.</p>
      <h3>Información</h3>
      <p>Muestra una pequeña ayuda sobre la página o formulario actual.</p>
      <h3>Agregar</h3>
      <p>Comunmente los registros que pueden ser agregados desde las opciones de página sirven para las tareas de configuración y sólo los Administradores y Administradores básicos tienen acceso.</p></td>
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
