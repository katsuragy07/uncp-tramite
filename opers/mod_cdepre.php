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
  $updateSQL = sprintf("UPDATE tabdepre SET antig=%s, mat=%s, cose_1=%s, cose_2=%s, cose_3=%s, cose_4=%s WHERE id=%s",
                       GetSQLValueString($_POST['antig'], "int"),
                       GetSQLValueString($_POST['mat'], "int"),
                       GetSQLValueString($_POST['cose_1'], "int"),
                       GetSQLValueString($_POST['cose_2'], "int"),
                       GetSQLValueString($_POST['cose_3'], "int"),
                       GetSQLValueString($_POST['cose_4'], "int"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_cn1, $cn1);
  $Result1 = mysql_query($updateSQL, $cn1) or die(mysql_error());

  $updateGoTo = "../modulos/c_depre".$_GET['fk'].".php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rs1 = "-1";
if (isset($_GET['pk'])) {
  $colname_rs1 = $_GET['pk'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs1 = sprintf("SELECT * FROM tabdepre WHERE id = %s", GetSQLValueString($colname_rs1, "int"));
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
    <h2>Tabla de deprecicación</h2>
        
    <form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
        <tr valign="baseline">
          <td width="150" align="right" class="btit_1">Item</td>
          <td class="btit_1">Valor</td>
          </tr>
        <tr valign="baseline">
          <td width="150" align="right" valign="middle">Antogüedad en años:</td>
          <td valign="middle"><span id="sprytextfield1">
          <input name="antig" type="text" class="tbox1" id="antig" value="<?php echo $row_rs1['antig']; ?>">
          </span></td>
          </tr>
        <tr valign="baseline">
          <td width="150" align="right" valign="middle">Material Estructural Predominante</td>
          <td valign="middle"><select name="mat" id="mat">
                    <option value="1" <?php if (!(strcmp(1, $row_rs1['mat']))) {echo "selected=\"selected\"";} ?>>Concreto</option>
                    <option value="2" <?php if (!(strcmp(2, $row_rs1['mat']))) {echo "selected=\"selected\"";} ?>>Ladrillo</option>
                    <option value="3" <?php if (!(strcmp(3, $row_rs1['mat']))) {echo "selected=\"selected\"";} ?>>Adobe (Quincha o madera)</option>
                  </select></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle">Estado &raquo; Muy Bueno:</td>
          <td valign="middle"><input name="cose_1" type="text" class="tbox1" id="cose_1" value="<?php echo $row_rs1['cose_1']; ?>"></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle">Estado &raquo;  Bueno:</td>
          <td valign="middle"><input name="cose_2" type="text" class="tbox1" id="cose_2" value="<?php echo $row_rs1['cose_2']; ?>" /></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle">Estado &raquo; Regular</td>
          <td valign="middle"><input name="cose_3" type="text" class="tbox1" id="cose_3" value="<?php echo $row_rs1['cose_3']; ?>" /></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle">Estado &raquo; Malo</td>
          <td valign="middle"><input name="cose_4" type="text" class="tbox1" id="cose_4" value="<?php echo $row_rs1['cose_4']; ?>" /></td>
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
        <div class="spacer"><a href="../modulos/c_depre<?php echo $_GET['fk'];?>.php" >
          <div class="skin left" style="background-position:-48px -79px;margin-right:3px;"></div>
          Cancelar y volver</a></div>
        </div>
        <div class="btit_2">Informaci&oacute;n</div>
        <div class="bcont2">Rellene los cuadros y luego pulse el boton modificar para almacenar los datos, si desea cancelar puede usar el bot&oacute;n respectivo de la lista de acciones.</div>
        </td>
  </tr>
</table>
</div></div></div>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "real", {isRequired:false});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($rs1);
?>