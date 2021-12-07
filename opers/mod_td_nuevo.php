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
  $updateSQL = sprintf("UPDATE folioext SET exp=%s, t_tipo=%s, asunto=%s, firma=%s, nfolios=%s, obs=%s, `file`=%s, ext=%s, `size`=%s, cabecera=%s WHERE id=%s",
                       GetSQLValueString($_POST['exp'], "int"),
                       GetSQLValueString($_POST['t_tipo'], "int"),
                       GetSQLValueString($_POST['asunto'], "text"),
                       GetSQLValueString($_POST['firma'], "text"),
                       GetSQLValueString($_POST['nfolios'], "int"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['file'], "text"),
                       GetSQLValueString($_POST['ext'], "text"),
                       GetSQLValueString($_POST['size'], "text"),
                       GetSQLValueString($_POST['cabecera'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_cn1, $cn1);
  $Result1 = mysql_query($updateSQL, $cn1) or die(mysql_error());

  $updateGoTo = "../modulos/td_folios.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}




mysql_select_db($database_cn1, $cn1);
$query_rs1 = "SELECT * FROM oficinas ORDER BY nombre ASC";
$rs1 = mysql_query($query_rs1, $cn1) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
$totalRows_rs1 = mysql_num_rows($rs1);

$colname_rs2 = "-1";
if (isset($_SESSION['u_empid'])) {
  $colname_rs2 = $_SESSION['u_empid'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs2 = sprintf("SELECT id, oficinas_id FROM empleado WHERE id = %s", GetSQLValueString($colname_rs2, "int"));
$rs2 = mysql_query($query_rs2, $cn1) or die(mysql_error());
$row_rs2 = mysql_fetch_assoc($rs2);
$totalRows_rs2 = mysql_num_rows($rs2);

$colname_rs = "-1";
if (isset($_GET['pk'])) {
  $colname_rs = $_GET['pk'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs = sprintf("SELECT * FROM folioext WHERE id = %s", GetSQLValueString($colname_rs, "int"));
$rs = mysql_query($query_rs, $cn1) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);
$totalRows_rs = mysql_num_rows($rs);
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
<script src="../scripts/SpryValidationTextarea.js" type="text/javascript"></script>
<script type="text/javascript" src="../scripts/jquery.js"></script>
<?php 
$idautom = md5(uniqid(rand(), true)); 
$up_pref="of".date("His");
$up_url="tdex_adjuntos";
$up_val=$row_rs['file'];
include("../includes/uploadoc_scripts.php");
?>

<script type="text/javascript">
function ocultar2() {
	var elem1 = document.getElementsByName("hos2");
	for (k = 0; k< elem1.length; k++) {
		elem1[k].style.display = "none";
	}
}
function mostrar2() {
	var elem1 = document.getElementsByName("hos2");
	for (i = 0; i< elem1.length; i++) {
	var visible = 'block'
	elem1[i].style.display = visible;
	}
}
function selca2(sdep2){
	var ttec="<?php echo $row_rs['cabecera']; ?>";
	var edest=document.getElementById("cabecera");
	var myselect=document.getElementById("t_tipo");
	var imsel=0;
	for (var i=0; i<myselect.options.length; i++){
	 if (myselect.options[i].value==sdep2){
	  imsel=i;
	  break
	 }
	}
	var tdec=myselect.options[imsel].text;
	if(tdec=="Otro...") tdec="(Especifique)";
	edest.value=tdec+" - "+ttec;
}
</script>
<link href="../scripts/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../scripts/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container"><div id="wpag"><div id="content">
<h1>Modificar datos</h1>
<div class="hr"><em></em><span></span></div>
<div class="clear" style="height:5px"></div>
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>
<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">
    <h2>Modificar Expediente Externo</h2>
    <h3>Datos básicos</h3>
    <form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
        <tr valign="baseline">
          <td width="130" align="right" class="btit_1">Item</td>
          <td class="btit_1">Valor</td>
          </tr>
        <tr valign="baseline">
          <td width="130" align="right" valign="middle" class="btit_3">Tipo</td>
          <td><select name="t_tipo" id="t_tipo" onchange="selca2(this.value);">
<option value="0" <?php if (!(strcmp(0, $row_rs['t_tipo']))) {echo "selected=\"selected\"";} ?>>Acuerdo</option>
<option value="1" <?php if (!(strcmp(1, $row_rs['t_tipo']))) {echo "selected=\"selected\"";} ?>>Aviso</option>
<option value="2" <?php if (!(strcmp(2, $row_rs['t_tipo']))) {echo "selected=\"selected\"";} ?>>Boletin</option>
<option value="3" <?php if (!(strcmp(3, $row_rs['t_tipo']))) {echo "selected=\"selected\"";} ?>>Carta</option>
<option value="4" <?php if (!(strcmp(4, $row_rs['t_tipo']))) {echo "selected=\"selected\"";} ?>>Circular</option>
<option value="5" <?php if (!(strcmp(5, $row_rs['t_tipo']))) {echo "selected=\"selected\"";} ?>>Decreto Legislativo</option>
<option value="6" <?php if (!(strcmp(6, $row_rs['t_tipo']))) {echo "selected=\"selected\"";} ?>>Decreto Regional</option>
<option value="7" <?php if (!(strcmp(7, $row_rs['t_tipo']))) {echo "selected=\"selected\"";} ?>>Decreto Supremo</option>
<option value="8" <?php if (!(strcmp(8, $row_rs['t_tipo']))) {echo "selected=\"selected\"";} ?>>Denuncia</option>
<option value="9" <?php if (!(strcmp(9, $row_rs['t_tipo']))) {echo "selected=\"selected\"";} ?>>Dictamen</option>
<option value="10" <?php if (!(strcmp(10, $row_rs['t_tipo']))) {echo "selected=\"selected\"";} ?>>Directiva</option>
<option value="11" <?php if (!(strcmp(11, $row_rs['t_tipo']))) {echo "selected=\"selected\"";} ?>>Expediente</option>
<option value="12" <?php if (!(strcmp(12, $row_rs['t_tipo']))) {echo "selected=\"selected\"";} ?>>Hoja Informativa</option>
<option value="13" <?php if (!(strcmp(13, $row_rs['t_tipo']))) {echo "selected=\"selected\"";} ?>>Informe</option>
<option value="26" <?php if (!(strcmp(26, $row_rs['t_tipo']))) {echo "selected=\"selected\"";} ?>>Licencia de construcci&oacute;n</option>
<option value="14" <?php if (!(strcmp(14, $row_rs['t_tipo']))) {echo "selected=\"selected\"";} ?>>Memo</option>
<option value="15" <?php if (!(strcmp(15, $row_rs['t_tipo']))) {echo "selected=\"selected\"";} ?>>Nota de Pedido</option>
<option value="16" <?php if (!(strcmp(16, $row_rs['t_tipo']))) {echo "selected=\"selected\"";} ?>>Nota de Prensa</option>
<option value="17" <?php if (!(strcmp(17, $row_rs['t_tipo']))) {echo "selected=\"selected\"";} ?>>Notificacion</option>
<option value="18" <?php if (!(strcmp(18, $row_rs['t_tipo']))) {echo "selected=\"selected\"";} ?>>Oficio</option>
<option value="19" <?php if (!(strcmp(19, $row_rs['t_tipo']))) {echo "selected=\"selected\"";} ?>>Oficio Circular</option>
<option value="20" <?php if (!(strcmp(20, $row_rs['t_tipo']))) {echo "selected=\"selected\"";} ?>>Oficio Multiple</option>
<option value="21" <?php if (!(strcmp(21, $row_rs['t_tipo']))) {echo "selected=\"selected\"";} ?>>Resoluci&oacute;n</option>
<option value="22" <?php if (!(strcmp(22, $row_rs['t_tipo']))) {echo "selected=\"selected\"";} ?>>Revista</option>
<option value="23" <?php if (!(strcmp(23, $row_rs['t_tipo']))) {echo "selected=\"selected\"";} ?>>Sobre</option>
<option value="24" <?php if (!(strcmp(24, $row_rs['t_tipo']))) {echo "selected=\"selected\"";} ?>>Solicitud</option>
<option value="25" <?php if (!(strcmp(25, $row_rs['t_tipo']))) {echo "selected=\"selected\"";} ?>>Otro...</option>
          </select></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" class="btit_3">Expediente N°</td>
          <td><span id="sprytextfield2">
          <input name="exp" type="text" id="exp" size="10" value="<?php echo $row_rs['exp']; ?>" /><span class="textfieldInvalidFormatMsg">Tiene que ser un n&uacute;mero entero.</span><span class="textfieldMinValueMsg">El n&uacute;mero debe ser mayor a 1.</span></span></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" class="btit_3">Cabecera</td>
          <td><span style="padding-top:5px">
            <input name="cabecera" type="text" class="tbox2" id="cabecera" value="<?php echo $row_rs['cabecera']; ?>" />
          </span></td>
        </tr>
        <tr valign="baseline">
          <td width="130" align="right" valign="middle" class="btit_3">Asunto</td>
          <td><span id="sprytextarea1">
            <textarea name="asunto" rows="2" class="tbox2" id="asunto"><?php echo $row_rs['asunto']; ?></textarea>
</span></td>
          </tr>
        <tr valign="baseline">
          <td width="130" align="right" valign="middle" class="btit_3">Firma</td>
          <td><span id="sprytextfield1">
            <input name="firma" type="text" class="tbox2" id="firma" value="<?php echo $row_rs['firma']; ?>" />
          </span></td>
        </tr>
        <tr valign="baseline">
          <td width="130" align="right" valign="middle" class="btit_3">N&deg; de folios</td>
          <td><input name="nfolios" type="text" id="nfolios" value="<?php echo $row_rs['nfolios']; ?>" size="10" /></td>
        </tr>
        <tr valign="baseline">
          <td width="130" align="right" valign="middle" class="btit_3">Observaciones</td>
          <td><label></label>
          <div name="hos1" id="hos1">
              <textarea name="obs" rows="4" class="tbox2" id="obs"><?php echo strip_tags($row_rs['obs']); ?></textarea>
            </div></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" class="btit_3">Adjuntar archivo</td>
          <td valign="middle"><?php include("../includes/uploadoc.php");?></td>
        </tr>
        <tr valign="baseline">
          <td width="130">&nbsp;</td>
          <td><input type="submit" class="but1" value="Modificar"></td>
          </tr>
      </table>
      <input type="hidden" name="id" value="<?php echo $row_rs['id']; ?>">
      <input type="hidden" name="ext" value="<?php echo $row_rs['ext']; ?>">
      <input type="hidden" name="file" value="<?php echo $row_rs['file']; ?>">
      <input type="hidden" name="size" value="<?php echo $row_rs['size']; ?>">
      <input type="hidden" name="MM_update" value="form1" />
</form></td>
    <td width="20" valign="top">&nbsp;</td>
    <td width="250" valign="top"><h2>Opciones</h2>
        <div class="btit_2">Acciones</div>
        <div class="bcont">
        <div class="spacer"><a href="#" onClick="location.reload();"><div class="skin left" style="background-position:-80px -63px;margin-right:3px;"></div>Refrescar p&aacute;gina</a></div>
        <div class="spacer"><a href="../modulos/td_folios.php" >
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
<?php if($row_rs['t_tipo']!=25){?>
ocultar2();
<?php }else{ ?>
mostrar2();
<?php } ?>


var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "integer", {validateOn:["change"], minValue:1});
</script>
</body>
</html>
<?php
mysql_free_result($rs1);

mysql_free_result($rs2);

mysql_free_result($rs);
?>