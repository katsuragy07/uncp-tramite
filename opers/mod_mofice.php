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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE oficinas SET nombre=%s, siglas=%s, obs=%s WHERE id=%s",
                       GetSQLValueString($_POST['nombre'], "text"),
							  GetSQLValueString($_POST['siglas'], "text"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_cn1, $cn1);
  $Result1 = mysql_query($updateSQL, $cn1) or die(mysql_error());

  $updateGoTo = "../modulos/mofice.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rs1 = "-1";
if (isset($_GET['fk'])) {
  $colname_rs1 = $_GET['fk'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs1 = sprintf("SELECT * FROM oficinas WHERE id = %s", GetSQLValueString($colname_rs1, "int"));
$rs1 = mysql_query($query_rs1, $cn1) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
$totalRows_rs1 = mysql_num_rows($rs1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/int.css" rel="Stylesheet" type="text/css" />
<style>
#wpag{background:transparent url(../images/pico_6.jpg) no-repeat fixed bottom right;}
</style>
<script src="../scripts/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../scripts/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="container"><div id="wpag"><div id="content">

<h1>Modificar Valores</h1>
<div class="hr"><em></em><span></span></div>

<div class="clear" style="height:5px"></div>
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>


<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">
    <h2>Locales &raquo; Oficinas</h2>
        
    <form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
        <tr valign="baseline">
          <td width="150" align="right" class="btit_1">Item</td>
          <td class="btit_1">Valor</td>
          </tr>
        <tr valign="baseline">
          <td width="150" align="right" valign="middle">A&ntilde;o</td>
          <td><span id="sprytextfield1">
          <input name="nombre" type="text" class="tbox2" id="nombre" value="<?php echo $row_rs1['nombre']; ?>" />
          </span></td>
          </tr>
          <tr valign="baseline">
          <td width="150" align="right" valign="middle">Siglas</td>
          <td><span id="sprytextfield2">
            <input name="siglas" type="text" class="tbox1" id="siglas" value="<?php echo $row_rs1['siglas']; ?>" />
          </span></td>
          </tr>
        <tr valign="baseline">
          <td align="right" valign="middle">Observaciones</td>
          <td><textarea name="obs" rows="3" class="tbox2" id="obs"><?php echo $row_rs1['obs']; ?></textarea></td>
        </tr>
        <tr valign="baseline">
          <td width="150">&nbsp;</td>
          <td><input type="submit" class="but1" value="Modificar"></td>
          </tr>
      </table>
      <input type="hidden" name="id" value="<?php echo $row_rs1['id']; ?>">
      <input type="hidden" name="MM_update" value="form1" />
</form>
    <p>&nbsp;</p></td>
    <td width="20" valign="top">&nbsp;</td>
    <td width="250" valign="top"><h2>Opciones</h2>
        <div class="btit_2">Acciones</div>
        <div class="bcont">
        <div class="spacer"><a href="#" onClick="location.reload();"><div class="skin left" style="background-position:-80px -63px;margin-right:3px;"></div>Refrescar p&aacute;gina</a></div>
        <div class="spacer"><a href="../modulos/mofice.php?pk=<?php echo $_GET['pk']; ?>" >
          <div class="skin left" style="background-position:-48px -79px;margin-right:3px;"></div>
          Cancelar y volver</a></div>
        </div>
        <div class="btit_2">Informaci&oacute;n</div>
        <div class="bcont2">Rellene los cuadros y luego pulse el boton agregar para almacenar los datos, si desea cancelar puede usar el bot&oacute;n respectivo de la lista de acciones.</div>
        </td>
  </tr>
</table>
</div></div></div>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["change"]});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($rs1);
?>
