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
  
  //enviar a multiples oficinas ilimitadamente
  $torig=$_POST['folio_id'];//id actual
  $toarr=explode(",",implode(",",$_POST['d_oficina']));//recibe array
  $tocan=count($toarr);//total de envios
	//v1 oficina destinada
	//v2 tipo, 0 externo, 1 interno
	//v3 forma
	//v4 folio relacionado
  for($xb=0;$xb<$tocan;$xb++){
		//v1 origen//v2 destino//v3 tipo//v4 forma
		folio_derivar_int($toarr[$xb],1,$_POST['forma'],$torig,nl2br($_POST['obs']),$_POST['provei'],$_POST['file'],$_POST['ext'],$_POST['size']);
  }
  folio_doperado_int($_POST['id']);
    
  
  
  $insertGoTo = "../modulos/tdin_recibidosya.php";
  header(sprintf("Location: %s", $insertGoTo));
}


mysql_select_db($database_cn1, $cn1);
$query_rs1 = "SELECT oficinas.id, CONCAT(lugares.nombre,'&nbsp;&nbsp;|&nbsp;&nbsp;',oficinas.nombre) AS nombre FROM oficinas, lugares WHERE oficinas.lugares_id = lugares.id ORDER BY lugares.id, nombre ASC";
$rs1 = mysql_query($query_rs1, $cn1) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
$totalRows_rs1 = mysql_num_rows($rs1);

$colname_rs2 = "-1";
if (isset($_GET['pk'])) {
  $colname_rs2 = $_GET['pk'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs2 = sprintf("SELECT * FROM folioint WHERE id = %s", GetSQLValueString($colname_rs2, "int"));
$rs2 = mysql_query($query_rs2, $cn1) or die(mysql_error());
$row_rs2 = mysql_fetch_assoc($rs2);
$totalRows_rs2 = mysql_num_rows($rs2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/int.css" rel="Stylesheet" type="text/css" />
<style>
#wpag{background:transparent url(../images/pico_5.jpg) no-repeat fixed bottom right;}
</style>
<script type="text/javascript" src="../scripts/jquery.js"></script>
<script src="../scripts/SpryValidationTextField.js" type="text/javascript"></script>
<?php 
$idautom = md5(uniqid(rand(), true)); 
$up_pref="of".date("His");
$up_url="tdin_adjuntos";
include("../includes/uploadoc_scripts.php");
?>
<link href="../scripts/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container"><div id="wpag"><div id="content">
<h1>Expedientes Internos</h1>
<div class="hr"><em></em><span></span></div>
<div class="clear" style="height:5px"></div>
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>
<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">
    <h2>Derivar Expediente con Proveido</h2>
    <h3><?php echo $row_rs2['firma']; ?></h3>
    <p>
    <strong>Cabecera:</strong> <?php echo $row_rs2['cabecera']; ?><br/>
    <strong>Asunto:</strong> <?php echo $row_rs2['asunto']; ?><br/>
    <strong>Fecha:</strong> <?php echo dptiemp($row_rs2['fecha']); ?><br/>
    </p>
    <form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
        <tr valign="baseline">
          <td width="130" align="right" class="btit_1">Item</td>
          <td class="btit_1">Valor</td>
          </tr>
        <tr valign="baseline">
          <td width="130" align="right" valign="middle" class="btit_3">Forma</td>
          <td><select name="forma">
<option value="0" selected="selected">Original</option>
<option value="1">Copia</option>
          </select></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" class="btit_3">Proveido</td>
          <td><span id="sprytextfield1">
            <input name="provei" type="text" class="tbox2" id="provei" /></span></td>
        </tr>
        <tr valign="baseline">
          <td width="130" align="right" valign="middle" class="btit_3">Oficina de destino<br />
            (Seleccione múltiples oficinas arrastrando el mouse o haciendo Ctrl + Clic sobre la oficina)</td>
          <td>
            <select name="d_oficina[]" size="10" multiple="multiple" class="tbox2" id="d_oficina">
              <?php
do {  
?>
              <option value="<?php echo $row_rs1['id']?>"><?php echo $row_rs1['nombre']?></option>
              <?php
} while ($row_rs1 = mysql_fetch_assoc($rs1));
  $rows = mysql_num_rows($rs1);
  if($rows > 0) {
      mysql_data_seek($rs1, 0);
	  $row_rs1 = mysql_fetch_assoc($rs1);
  }
?>
            </select>            </td>
        </tr>
        <tr valign="baseline">
          <td width="130" align="right" valign="middle" class="btit_3">Observaciones</td>
          <td>
              <textarea name="obs" rows="4" class="tbox2" id="obs"></textarea>              </td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" class="btit_3">Adjuntar archivo</td>
          <td valign="middle"><?php include("../includes/uploadoc.php");?></td>
        </tr>
        <tr valign="baseline">
          <td width="130">&nbsp;</td>
          <td><input type="submit" class="but1" value="Agregar"></td>
          </tr>
      </table>
      <input type="hidden" name="folio_id" value="<?php echo $row_rs2['id']; ?>">
      <input type="hidden" name="id" value="<?php echo $_GET['fk']; ?>">
      <input type="hidden" name="ext" value="">
      <input type="hidden" name="file" value="">
      <input type="hidden" name="size" value="">
      <input type="hidden" name="MM_insert" value="form1" />
</form></td>
    <td width="20" valign="top">&nbsp;</td>
    <td width="250" valign="top"><h2>Opciones</h2>
        <div class="btit_2">Acciones</div>
        <div class="bcont">
        <div class="spacer"><a href="#" onClick="location.reload();"><div class="skin left" style="background-position:-80px -63px;margin-right:3px;"></div>Refrescar p&aacute;gina</a></div>
        <div class="spacer"><a href="td_recibidos.php" >
          <div class="skin left" style="background-position:-48px -79px;margin-right:3px;"></div>
          Cancelar e ir a la lista general</a></div>
        </div>
        <div class="btit_2">Informaci&oacute;n</div>
        <div class="bcont2">Rellene los cuadros y luego pulse el boton agregar para almacenar los datos, si desea cancelar puede usar el bot&oacute;n respectivo de la lista de acciones.</div>
        </td>
  </tr>
</table>

</div></div></div>

<script type="text/javascript">
document.forms[0].d_oficina.value=<?php echo $_SESSION['u_ofice']; ?>;
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["change"]});
</script>
</body>
</html>
<?php
mysql_free_result($rs1);

mysql_free_result($rs2);
?>