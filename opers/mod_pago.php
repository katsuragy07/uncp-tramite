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
  $updateSQL = sprintf("UPDATE declar SET annos=%s, recib_num=%s, monto=%s, obs=%s, fecha=%s, `user`=%s WHERE id=%s",
                       GetSQLValueString($_POST['annos'], "text"),
                       GetSQLValueString($_POST['recib_num'], "text"),
							  GetSQLValueString($_POST['monto'], "double"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['fecha'], "date"),
                       GetSQLValueString($_POST['user'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_cn1, $cn1);
  $Result1 = mysql_query($updateSQL, $cn1) or die(mysql_error());
  
  

  $updateGoTo = "../modulos/verpredio_pagos.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rs1 = "-1";
if (isset($_GET['pr'])) {
  $colname_rs1 = $_GET['pr'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs1 = sprintf("SELECT * FROM predio WHERE id = %s", GetSQLValueString($colname_rs1, "int"));
$rs1 = mysql_query($query_rs1, $cn1) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
$totalRows_rs1 = mysql_num_rows($rs1);

$colname_rs2 = "-1";
if (isset($_GET['pk'])) {
  $colname_rs2 = $_GET['pk'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs2 = sprintf("SELECT * FROM declar WHERE id = %s", GetSQLValueString($colname_rs2, "int"));
$rs2 = mysql_query($query_rs2, $cn1) or die(mysql_error());
$row_rs2 = mysql_fetch_assoc($rs2);
$totalRows_rs2 = mysql_num_rows($rs2);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/int.css" rel="Stylesheet" type="text/css" />
<style>
#wpag{background:transparent url(../images/pico_6.jpg) no-repeat fixed bottom right;}
</style>

<script src="../scripts/SpryValidationTextField.js" type="text/javascript"></script>
<script type="text/javascript">
function cant(num){
var1=document.forms[0].fech_const.value;
var2=document.forms[0].antig.value;
annos=<?php echo date("Y")?>;
salid="";
	switch(num){
		case 1:
		salid=annos-parseInt(var1.substr(0,4));
		if(salid==0)salid=1;
		document.forms[0].antig.value=salid;
		break;
		case 2:
		salid=annos-var2;
		document.forms[0].fech_const.value=salid+var1.substr(4);
		break;
	}
}
</script>

<link href="../scripts/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container"><div id="wpag"><div id="content">
<h1>Predio &raquo;  <?php echo "<strong> ".$row_rs1['cod']."</strong> - ".ddiret($row_rs1['dir_tipo'],1).$row_rs1['dir_nombre'].ddirnu($row_rs1['dir_num'],$row_rs1['dir_dpto'],$row_rs1['dir_mz'],$row_rs1['dir_lote']); ?></h1>
<div class="hr"><em></em><span></span></div>
<div class="clear" style="height:5px"></div>
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>
<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">
    <h2>Descripción de construcción</h2>
      <form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
        <tr valign="baseline">
          <td width="100" align="right" class="btit_1">Item</td>
          <td class="btit_1">Valor</td>
          </tr>
        <tr valign="baseline">
          <td width="100" align="right" valign="middle" class="btit_3">Años</td>
          <td valign="middle"><span id="sprytextfield1">
            <input name="annos" type="text" class="tbox2" id="annos" value="<?php echo $row_rs2['annos']; ?>" />
            </span></td>
        </tr>
        <tr valign="baseline">
          <td width="100" align="right" valign="middle" class="btit_3">Número de recibo</td>
          <td valign="middle"><span id="sprytextfield2">
            <input name="recib_num" type="text" class="tbox2" id="recib_num" value="<?php echo $row_rs2['recib_num']; ?>" />
            </span></td>
        </tr>
        <tr valign="baseline">
          <td width="100" align="right" valign="middle" class="btit_3">Monto S/.</td>
          <td valign="middle"><span id="sprytextfield3">
          <input name="monto" type="text" id="monto" value="<?php echo $row_rs2['monto']; ?>"/>
          <span class="textfieldInvalidFormatMsg">Decimal 0.00</span><span class="textfieldMinValueMsg">El valor es demasiado bajo.</span></span></td>
        </tr>
        <tr valign="baseline">
          <td width="100" align="right" valign="middle" class="btit_3">Observaciones</td>
          <td valign="middle"><textarea name="obs" rows="3" class="tbox2" id="obs"><?php echo $row_rs2['obs']; ?></textarea></td>
        </tr>
        <tr valign="baseline">
          <td width="100">&nbsp;</td>
          <td><input type="submit" class="but1" value="Modificar"></td>
          </tr>
      </table>
      <input type="hidden" name="id" value="<?php echo $row_rs2['id']; ?>">
      <input type="hidden" name="predio_cod" value="<?php echo $row_rs2['predio_cod']; ?>">      
      <input type="hidden" name="fecha" value="<?php echo date("Y-m-d H:i:s");?>">
      <input type="hidden" name="user" value="<?php echo $_SESSION['u_id']; ?>">
      <input type="hidden" name="MM_update" value="form1" />

      </form>

</td>
    <td width="20" valign="top">&nbsp;</td>
    <td width="250" valign="top"><h2>Opciones</h2>
        <div class="btit_2">Acciones</div>
        <div class="bcont">
        <div class="spacer"><a href="javascript:location.reload();"><div class="skin left" style="background-position:-80px -63px;margin-right:3px;"></div>Refrescar p&aacute;gina</a></div>
        <div class="spacer"><a href="../modulos/verpredio_cnst.php?anno=<?php echo $_GET['anno']?>&pr=<?php echo $_GET['pr']?>" >
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
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "real", {validateOn:["change"], minValue:1});

//-->
</script>
</body>
</html>
<?php
mysql_free_result($rs1);

mysql_free_result($rs2);

?>
