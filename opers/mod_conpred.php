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
  $updateSQL = sprintf("UPDATE contribuyente_has_predio SET obs=%s, con_tipo=%s, con_otro=%s, ncondo=%s, fecha=%s, `user`=%s, empid=%s, baja=%s, baja_obs=%s WHERE id=%s",
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['con_tipo'], "int"),
                       GetSQLValueString($_POST['con_otro'], "text"),
                       GetSQLValueString($_POST['ncondo'], "int"),
                       GetSQLValueString($_POST['fecha'], "date"),
                       GetSQLValueString($_POST['user'], "text"),
                       GetSQLValueString($_POST['empid'], "int"),
                       GetSQLValueString($_POST['baja'], "int"),
                       GetSQLValueString($_POST['baja_obs'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_cn1, $cn1);
  $Result1 = mysql_query($updateSQL, $cn1) or die(mysql_error());

  $updateGoTo = "../modulos/verpredio.php?pr=".$_POST['predio_id'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rs0 = "-1";
if (isset($_GET['ck'])) {
  $colname_rs0 = $_GET['ck'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs0 = sprintf("SELECT * FROM contribuyente_has_predio WHERE id = %s", GetSQLValueString($colname_rs0, "int"));
$rs0 = mysql_query($query_rs0, $cn1) or die(mysql_error());
$row_rs0 = mysql_fetch_assoc($rs0);
$totalRows_rs0 = mysql_num_rows($rs0);

$colname_rs1 = "-1";
if (isset($row_rs0['predio_id'])) {
  $colname_rs1 = $row_rs0['predio_id'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs1 = sprintf("SELECT * FROM predio WHERE id = %s", GetSQLValueString($colname_rs1, "int"));
$rs1 = mysql_query($query_rs1, $cn1) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
$totalRows_rs1 = mysql_num_rows($rs1);

$colname_rs2 = "-1";
if (isset($row_rs0['contribuyente_id'])) {
  $colname_rs2 = $row_rs0['contribuyente_id'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs2 = sprintf("SELECT * FROM contribuyente WHERE id = %s", GetSQLValueString($colname_rs2, "int"));
$rs2 = mysql_query($query_rs2, $cn1) or die(mysql_error());
$row_rs2 = mysql_fetch_assoc($rs2);
$totalRows_rs2 = mysql_num_rows($rs2);

mysql_select_db($database_cn1, $cn1);
$query_rs3 = sprintf("SELECT COUNT(contribuyente_has_predio.con_tipo) AS tot FROM contribuyente_has_predio WHERE contribuyente_has_predio.con_tipo=1 AND contribuyente_has_predio.predio_id = %s", GetSQLValueString($colname_rs1, "int"));
$rs3 = mysql_query($query_rs3, $cn1) or die(mysql_error());
$row_rs3 = mysql_fetch_assoc($rs3);
$totalRows_rs3 = mysql_num_rows($rs3);

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
function ocultar() {
	var elem1 = document.getElementsByName("hos1");
	for (k = 0; k< elem1.length; k++) {
		elem1[k].style.display = "none";
	}
}
function ocultar2() {
	var elem1 = document.getElementsByName("hos2");
	for (k = 0; k< elem1.length; k++) {
		elem1[k].style.display = "none";
	}
}
function ocultar3() {
	var elem3 = document.getElementsByName("hos3");
	for (k = 0; k< elem3.length; k++) {
		elem3[k].style.display = "none";
	}
}
function mostrar() {
	var elem1 = document.getElementsByName("hos1");
	for (i = 0; i< elem1.length; i++) {
		if(navigator.appName.indexOf("Microsoft") > -1){
		var visible = 'block'
	} else {
		var visible = 'table-row';
	}
	elem1[i].style.display = visible;
	}
}
function mostrar2() {
	var elem1 = document.getElementsByName("hos2");
	for (i = 0; i< elem1.length; i++) {
		if(navigator.appName.indexOf("Microsoft") > -1){
		var visible = 'block'
	} else {
		var visible = 'table-row';
	}
	elem1[i].style.display = visible;
	}
}
function mostrar3() {
	var elem3 = document.getElementsByName("hos3");
	for (i = 0; i< elem3.length; i++) {
		if(navigator.appName.indexOf("Microsoft") > -1){
		var visible = 'block'
	} else {
		var visible = 'table-row';
	}
	elem3[i].style.display = visible;
	}
}
function selca(opes){	
	if(opes==5){
		mostrar2();
		document.forms[0].ncondo.value="";
		ocultar();
	}else{
		if(opes==6){
			mostrar();
			document.forms[0].con_otro.value="";
			ocultar2();
		}else{
			ocultar2();
			ocultar();
			document.forms[0].ncondo.value="";
			document.forms[0].con_otro.value="";
		}
	}
}
function selca3(opes2){	
	if(opes2==1){
		mostrar3();
	}else{
		ocultar3();
		document.forms[0].baja_obs.value="";
	}
}

</script>
<link href="../scripts/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container"><div id="wpag"><div id="content">
<h1>Modificar Datos</h1>
<div class="hr"><em></em><span></span></div>
<div class="clear" style="height:5px"></div>
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>
<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">
    <h2>Modificar asociación de contribuyente y predio</h2>
    <h3>Elementos seleccionados</h3>
    <form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
        <tr valign="baseline">
          <td width="150" align="right" class="btit_1">Item</td>
          <td class="btit_1">Valor</td>
          </tr>
        <tr valign="baseline">
          <td width="150" align="right" valign="middle" class="btit_3">Predio</td>
          <td><span class="med"><?php echo "<strong> ".$row_rs1['cod']."</strong> - ".ddiret($row_rs1['dir_tipo'],1).$row_rs1['dir_nombre'].ddirnu($row_rs1['dir_num'],$row_rs1['dir_dpto'],$row_rs1['dir_mz'],$row_rs1['dir_lote']); ?></span></td>
          </tr>
        <tr valign="baseline">
          <td width="150" align="right" valign="middle" class="btit_3">Contribuyente</td>
          <td><span class="med"><?php echo "<strong> ".$row_rs2['cod']."</strong> - ".ddcont($row_rs2['tipo'],$row_rs2['apellido'].", ".$row_rs2['nombre'],$row_rs2['rasocial']); ?></span></td>
        </tr>
      </table>

      <h3>Sobre el contribuyente</h3>
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
        <tr valign="baseline">
          <td width="150" align="right" class="btit_1">Item</td>
          <td class="btit_1">Valor</td>
          </tr>
        <tr valign="baseline">
          <td width="150" align="right" valign="middle" class="btit_3">Condición de Propiedad</td>
          <td><select name="con_tipo" onchange="selca(this.value);">
          <?php if($row_rs3['tot']<1){ ?>
            <option value="1" <?php if (!(strcmp(1, $row_rs0['con_tipo']))) {echo "selected=\"selected\"";} ?>>Propietario único</option>
            <?php }?>
            <option value="2" <?php if (!(strcmp(2, $row_rs0['con_tipo']))) {echo "selected=\"selected\"";} ?>>Sucesión indivisa</option>
            <option value="3" <?php if (!(strcmp(3, $row_rs0['con_tipo']))) {echo "selected=\"selected\"";} ?>>Poseedor o tenedor</option>
            <option value="4" <?php if (!(strcmp(4, $row_rs0['con_tipo']))) {echo "selected=\"selected\"";} ?>>Sociedad Conyugal</option>
            <option value="5" <?php if (!(strcmp(5, $row_rs0['con_tipo']))) {echo "selected=\"selected\"";} ?>>Condominio</option>
            <option value="6" <?php if (!(strcmp(6, $row_rs0['con_tipo']))) {echo "selected=\"selected\"";} ?>>Otro</option>
            &nbsp;
          </select>
          <div name="hos1" id="hos1">
            Especificar &raquo; 
            <input name="con_otro" type="text" id="con_otro" value="<?php echo $row_rs0['con_otro']; ?>" size="30" />
            </div>          </td>
          </tr>
        <tr valign="baseline" name="hos2" id="hos2">
          <td width="150" align="right" valign="middle" class="btit_3">N° de condominios</td>
          <td><span id="sprytextfield1">
            <input name="ncondo" type="text" value="<?php echo $row_rs0['ncondo']; ?>" size="10" />
          </span></td>
        </tr>
        <tr valign="baseline">
          <td width="150" align="right" valign="middle" class="btit_3">Observaciones adicionales</td>
          <td><textarea name="obs" rows="3" class="tbox2" id="obs"><?php echo $row_rs0['obs']; ?></textarea></td>
        </tr>
      </table>
      <h3>Baja de contribuyente</h3>
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
        <tr valign="baseline">
          <td width="150" align="right" class="btit_1">Item</td>
          <td class="btit_1">Valor</td>
          </tr>
        <tr valign="baseline">
          <td width="150" align="right" valign="middle" class="btit_3">Dar de baja a contribuyente</td>
          <td>
          <select name="baja" id="baja" onchange="selca3(this.value);">
            <option value="0" <?php if (!(strcmp(0, $row_rs0['baja']))) {echo "selected=\"selected\"";} ?>>No</option>
            <option value="1" <?php if (!(strcmp(1, $row_rs0['baja']))) {echo "selected=\"selected\"";} ?>>Si, dar de baja</option>
            &nbsp;
          </select></td>
          </tr>
        <tr valign="baseline" name="hos3" id="hos3">
          <td width="150" align="right" valign="middle" class="btit_3">Observaciones sobre baja </td>
          <td><textarea name="baja_obs" rows="3" class="tbox2" id="baja_obs"><?php echo $row_rs0['baja_obs']; ?></textarea></td>
        </tr>
        <tr valign="baseline">
          <td width="150">&nbsp;</td>
          <td><input name="Submit" type="submit" class="but1" value="Modificar"></td>
          </tr>
      </table>
      <input type="hidden" name="id" value="<?php echo $row_rs0['id']; ?>">
      <input type="hidden" name="fecha" value="<?php echo date("Y-m-d H:i:s");?>">
      <input type="hidden" name="predio_id" value="<?php echo $row_rs0['predio_id']; ?>">
      <input type="hidden" name="user" value="<?php echo $_SESSION['u_id']; ?>">
      <input type="hidden" name="empid" value="<?php echo $_SESSION['u_empid']; ?>">
      <input type="hidden" name="MM_insert" value="form1" />
      <input type="hidden" name="MM_update" value="form1" />
		</form>

</td>
    <td width="20" valign="top">&nbsp;</td>
    <td width="250" valign="top"><h2>Opciones</h2>
        <div class="btit_2">Acciones</div>
        <div class="bcont">
        <div class="spacer"><a href="javascript:location.reload();"><div class="skin left" style="background-position:-80px -63px;margin-right:3px;"></div>Refrescar p&aacute;gina</a></div>
        <div class="spacer"><a href="../modulos/verpredio.php?anno=<?php echo $_GET['anno']; ?>&pr=<?php echo $row_rs1['id']; ?>" >
          <div class="skin left" style="background-position:-48px -79px;margin-right:3px;"></div>
          Cancelar y volver</a></div>
        </div>
        <div class="btit_2">Informaci&oacute;n</div>
        <div class="bcont2">Rellene los cuadros y luego pulse el boton modificar para almacenar los datos.<br />
        Dar de baja a un contribuyente significa marcar que el contribuyente ya no es propietario de este predio, pero se mantiene la ascociación entre el predio y contribuyente como un historial, si no desea almacenar esta asociación puede eliminarla.</div>
        </td>
  </tr>
</table>

</div></div></div>

<script type="text/javascript">
<?php if($row_rs0['con_tipo']!=6){ ?>
ocultar();
<?php } ?>
<?php if($row_rs0['con_tipo']!=5){ ?>
ocultar2();
<?php } ?>
<?php if($row_rs0['baja']!=1){ ?>
ocultar3();
<?php } ?>
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {isRequired:false});
</script>
</body>
</html>
<?php
mysql_free_result($rs0);

mysql_free_result($rs1);

mysql_free_result($rs2);

mysql_free_result($rs3);
?>
