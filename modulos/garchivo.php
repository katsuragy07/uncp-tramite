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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO lugares (id, nombre) VALUES (%s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['nombre'], "text"));

  mysql_select_db($database_cn1, $cn1);
  $Result1 = mysql_query($insertSQL, $cn1) or die(mysql_error());

  $insertGoTo = "mlocal.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_cn1, $cn1);
$query_rs1 = "SELECT * FROM lugares ORDER BY nombre ASC";
$rs1 = mysql_query($query_rs1, $cn1) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
$totalRows_rs1 = mysql_num_rows($rs1);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/int.css" rel="Stylesheet" type="text/css" />
<style>
#wpag{background:transparent url(../images/pico_7.jpg) no-repeat fixed bottom right;}
</style>
<script src="../scripts/SpryValidationTextField.js" type="text/javascript"></script>
<script type="text/javascript">function dlitem(ord){if(confirm("Deseas eliminar este registro?")){document.location.href= '../opers/del_mlocal.php?pk='+ord;}}</script> 
<link href="../scripts/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="container"><div id="wpag"><div id="content">

<h1>Áreas Administrativas</h1>
<div class="hr"><em></em><span></span></div>

<div class="clear" style="height:5px"></div>
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>


<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><h2>Áreas registrados</h2>
        <table width="90%" border="0" cellpadding="0" cellspacing="0" class="tabla">
          <tr>
            <td width="20" align="center" class="btit_1">#</td>
            <td class="btit_1">Nombre</td>
            <td width="160" class="btit_1">&nbsp;</td>
          </tr>
          <?php $cont=0; ?>
          <?php do { ?>
          <?php $cont++; ?>
          <tr>
            <td width="20" align="center"><?php echo $cont; ?></td>
            <td><a href="mofice.php?pk=<?php echo $row_rs1['id']; ?>"><?php echo $row_rs1['nombre']; ?></a></td>
            <td width="150"><div class="barlist right" style="width:140px">
                <ul>
                  <li><a href="../opers/mod_mlocal.php?pk=<?php echo $row_rs1['id']; ?>"><span class="skin left" style="background-position:-48px -63px;margin-right:3px;"></span> Editar</a></li>
<li><a href="javascript:dlitem(<?php echo $row_rs1['id']; ?>);">
                    <div class="skin left" style="background-position:-64px -63px;margin-right:3px;"></div>
                    Eliminar</a></li>
</ul>
            </div></td>
          </tr>
          <?php } while ($row_rs1 = mysql_fetch_assoc($rs1)); ?>
      </table></td>
    <td width="20" valign="top">&nbsp;</td>
    <td width="250" valign="top"><h2>Opciones</h2>
        <div class="btit_2">Acciones</div>
        <div class="bcont">
        <div class="spacer"><a href="#" onClick="location.reload();"><div class="skin left" style="background-position:-80px -63px;margin-right:3px;"></div>Refrescar p&aacute;gina</a></div>
        </div>
        <div class="btit_2">Informaci&oacute;n</div>
        <div class="bcont">Para acceder a las oficinas de un clic sobre el nombre del local.</div>
        <div class="btit_2">Agregar local</div>
        <div class="bcont2">Para agregar nuevos locales rellene el siguiente formulario.</div>
        <div class="bcont2">
          <form method="post" name="form1" action="<?php echo $editFormAction; ?>">          
          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr valign="baseline">
                <td class="normal">Nombre del local:</td>
              </tr>
              <tr valign="baseline">
                <td><span id="sprytextfield1">
                  <input name="nombre" type="text" class="tbox1" id="nombre" value=""></span></td>
              </tr>
              <tr valign="baseline">
                <td><input type="submit" class="but1" value="Agregar"></td>
              </tr>
            </table>
              <input type="hidden" name="MM_insert" value="form1">
              <input type="hidden" name="id" value="">
          </form>
          </div>
        </td>
  </tr>
</table>
</div></div></div>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($rs1);
?>