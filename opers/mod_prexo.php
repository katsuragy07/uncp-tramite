<?php require_once('../Connections/cn1.php'); ?>
<?php require_once('../includes/functions.php'); ?>
<?php require_once('../includes/permisos_all_ui.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

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
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
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
  $updateSQL = sprintf("UPDATE exoneracion SET tipo=%s, baselegal=%s, nexpediente=%s, nres=%s, fecha_res=%s, pini_trim=%s, pini_anno=%s, pfin_trim=%s, pfin_anno=%s, fecha=%s, `user`=%s WHERE id=%s",
                       GetSQLValueString($_POST['tipo'], "int"),
                       GetSQLValueString($_POST['baselegal'], "text"),
                       GetSQLValueString($_POST['nexpediente'], "text"),
                       GetSQLValueString($_POST['nres'], "text"),
                       GetSQLValueString($_POST['fecha_res'], "date"),
                       GetSQLValueString($_POST['pini_trim'], "int"),
                       GetSQLValueString($_POST['pini_anno'], "text"),
                       GetSQLValueString($_POST['pfin_trim'], "int"),
                       GetSQLValueString($_POST['pfin_anno'], "text"),
                       GetSQLValueString($_POST['fecha'], "date"),
                       GetSQLValueString($_POST['user'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_cn1, $cn1);
  $Result1 = mysql_query($updateSQL, $cn1) or die(mysql_error());

  $updateGoTo = "../modulos/verpredio.php";
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
$query_rs2 = sprintf("SELECT * FROM exoneracion WHERE id = %s", GetSQLValueString($colname_rs2, "int"));
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
function fdate(){
document.forms[0].fecha_res.value=document.forms[0].fanno.value+"-"+document.forms[0].fmes.value+"-"+document.forms[0].fdia.value;
fedad(doty);
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
    <h2>Regimen de Inafectación o Exoneración</h2>
    <h3>Sobre la Exoneración</h3>
    <form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
        <tr valign="baseline">
          <td width="150" align="right" class="btit_1">Item</td>
          <td class="btit_1">Valor</td>
          </tr>
        <tr valign="baseline">
          <td width="150" align="right" valign="middle" class="btit_3">Tipo</td>
          <td><select name="tipo">
            <option value="1" <?php if (!(strcmp(1, $row_rs2['tipo']))) {echo "selected=\"selected\"";} ?>>Inafecto</option>
            <option value="2" <?php if (!(strcmp(2, $row_rs2['tipo']))) {echo "selected=\"selected\"";} ?>>Exonerado Parcialmente</option>
            <option value="3" <?php if (!(strcmp(3, $row_rs2['tipo']))) {echo "selected=\"selected\"";} ?>>Exonerado Totalmente</option>
          </select></td>
        </tr>
        <tr valign="baseline">
          <td width="150" align="right" valign="middle" class="btit_3">Base legal</td>
          <td><span id="sprytextfield1">
            <input name="baselegal" type="text" class="tbox2" id="baselegal" value="<?php echo $row_rs2['baselegal']; ?>" size="10" />
          </span></td>
        </tr>
        <tr valign="baseline" name="hos2">
          <td align="right" valign="middle" class="btit_3">Expediente N°</td>
          <td><span id="sprytextfield2">
            <input name="nexpediente" type="text" class="tbox2" id="nexpediente" value="<?php echo $row_rs2['nexpediente']; ?>" size="10" /></span></td>
        </tr>
        <tr valign="baseline" name="hos2">
          <td align="right" valign="middle" class="btit_3">Resolución N°</td>
          <td><span id="sprytextfield3">
            <input name="nres" type="text" class="tbox2" id="nres" value="<?php echo $row_rs2['nres']; ?>" size="10" /></span></td>
        </tr>
        <tr valign="baseline" name="hos2">
          <td align="right" valign="middle" class="btit_3">Fecha de Resolución</td>
          <td><span id="sprytextfield4">
          <input name="fecha_res" type="text" id="fecha_res" value="<?php echo $row_rs2['fecha_res']; ?>" size="14" />
          <span class="textfieldInvalidFormatMsg"> Año-mes-dia.</span></span> AAAA-MM-DD</td>
        </tr>
        <tr valign="baseline" name="hos2">
          <td align="right" valign="middle" class="btit_3">Periodo de Exoneración</td>
          <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabla3">
            <tr>
              <td width="60" rowspan="2" align="right" class="btit_3">DEL<br />
                (Inicio)</td>
              <td width="70" align="right">Trimestre                </td>
              <td><select name="pini_trim" id="pini_trim">
                <option value="1" <?php if (!(strcmp(1, $row_rs2['pini_trim']))) {echo "selected=\"selected\"";} ?>>I</option>
                <option value="2" <?php if (!(strcmp(2, $row_rs2['pini_trim']))) {echo "selected=\"selected\"";} ?>>II</option>
                <option value="3" <?php if (!(strcmp(3, $row_rs2['pini_trim']))) {echo "selected=\"selected\"";} ?>>III</option>
                <option value="4" <?php if (!(strcmp(4, $row_rs2['pini_trim']))) {echo "selected=\"selected\"";} ?>>IV</option>
              </select></td>
            </tr>
            <tr>
              <td width="70" align="right">Año</td>
              <td><select name="pini_anno" class="tb3" id="pini_anno" onchange="fyea(0);">
              <?php
			  for($xa=date("Y")+10;$xa>=date("Y")-30;$xa--){
				echo "<option value='".$xa."'>".$xa."</option>";
			  }
			  ?>
              <script type="text/javascript">
			  document.forms[0].pini_anno.value=<?php echo $row_rs2['pini_anno']; ?>;
              </script>
						</select>
					</td>
            </tr>
            <tr>
              <td width="60" rowspan="2" align="right" class="btit_3">AL<br />
                (Fin)</td>
              <td align="right">Trimestre </td>
              <td><select name="pfin_trim" id="pfin_trim">
                <option value="1" <?php if (!(strcmp(1, $row_rs2['pfin_trim']))) {echo "selected=\"selected\"";} ?>>I</option>
                <option value="2" <?php if (!(strcmp(2, $row_rs2['pfin_trim']))) {echo "selected=\"selected\"";} ?>>II</option>
                <option value="3" <?php if (!(strcmp(3, $row_rs2['pfin_trim']))) {echo "selected=\"selected\"";} ?>>III</option>
                <option value="4" <?php if (!(strcmp(4, $row_rs2['pfin_trim']))) {echo "selected=\"selected\"";} ?>>IV</option>
              </select></td>
            </tr>
            <tr>
              <td width="70" align="right">Año</td>
              <td><select name="pfin_anno" class="tb3" id="pfin_anno" onchange="fyea(0);">
				 <?php
			  for($xa=date("Y")+10;$xa>=date("Y")-30;$xa--){
				echo "<option value='".$xa."'>".$xa."</option>";
			  }
			  ?>
              <script type="text/javascript">
			  document.forms[0].pfin_anno.value=<?php echo $row_rs2['pfin_anno']; ?>;
              </script>
						</select></td>
            </tr>
          </table></td>
        </tr>
        <tr valign="baseline">
          <td width="150">&nbsp;</td>
          <td><input type="submit" class="but1" value="Modificar"></td>
          </tr>
      </table>
      <input type="hidden" name="id" value="<?php echo $row_rs2['id']; ?>">
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
        <div class="spacer"><a href="../modulos/verpredio.php?pr=<?php echo $_GET['pr']?>" >
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
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "date", {format:"yyyy-mm-dd", validateOn:["change"]});
</script>
</body>
</html>
<?php
mysql_free_result($rs1);

mysql_free_result($rs2);

?>
