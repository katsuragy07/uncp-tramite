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
  $insertSQL = sprintf("INSERT INTO empleado (id, nombre, apellido, oficinas_id, encargado, sexo, tit_tipo, tit_otro, cargo) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['apellido'], "text"),
                       GetSQLValueString($_POST['oficinas_id'], "int"),
                       GetSQLValueString($_POST['encargado'], "int"),
                       GetSQLValueString($_POST['sexo'], "int"),
                       GetSQLValueString($_POST['tit_tipo'], "int"),
                       GetSQLValueString($_POST['tit_otro'], "text"),
                       GetSQLValueString($_POST['cargo'], "text"));

  mysql_select_db($database_cn1, $cn1);
  $Result1 = mysql_query($insertSQL, $cn1) or die(mysql_error());

  $insertGoTo = "../modulos/perso.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_cn1, $cn1);
$query_rs1 = "SELECT * FROM oficinas ORDER BY nombre ASC";
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
#wpag{background:transparent url(../images/pico_5.jpg) no-repeat fixed bottom right;}
</style>

<script src="../scripts/SpryValidationTextField.js" type="text/javascript"></script>
<script type="text/javascript">
function ocultar() {
	var elem1 = document.getElementsByName("hos1");
	for (k = 0; k< elem1.length; k++) {
		elem1[k].style.display = "none";
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
function selca(){
	var sdep=document.forms[0].tit_tipo.value;
	if(sdep!=0){
		ocultar();
	}else{
		mostrar();
		document.forms[0].tit_otro.value="";
	}
}
</script>

<link href="../scripts/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container"><div id="wpag"><div id="content">

<h1>Personal Administrativo</h1>
<div class="hr"><em></em><span></span></div>

<div class="clear" style="height:5px"></div>
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>


<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">
    <h2>Datos personales</h2>
        
    <form method="POST" name="form1" action="<?php echo $editFormAction; ?>">
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
        <tr valign="baseline">
          <td width="150" align="right" class="btit_1">Item</td>
          <td class="btit_1">Valor</td>
          </tr>
        <tr valign="baseline">
          <td width="150" align="right" valign="middle">Nombres</td>
          <td><span id="sprytextfield1">
            <input name="nombre" type="text" class="tbox2" id="nombre" /></span></td>
          </tr>
        <tr valign="baseline">
          <td width="150" align="right" valign="middle">Apellidos</td>
          <td><span id="sprytextfield2">
            <input name="apellido" type="text" class="tbox2" id="apellido" /></span></td>
        </tr>
        <tr valign="baseline">
          <td width="150" align="right" valign="middle">Sexo</td>
          <td>
            <select name="sexo" id="sexo">
              <option value="1">Masculino</option>
              <option value="0">Femenino</option>
            </select></td>
          </tr>
        <tr valign="baseline">
          <td width="150" align="right" valign="middle">Título</td>
          <td valign="middle">
          <select name="tit_tipo" id="tit_tipo" onchange="selca();">
            <option value="1">Sr. (a)</option>
            <option value="2">Lic.</option>
            <option value="3">Ing.</option>
            <option value="4">C.C.</option>
            <option value="0">Otro</option>
          </select>
            <div name="hos1" id="hos1">Especificar &raquo; <input name="tit_otro" type="text" id="tit_otro" size="20" /></div></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle">Oficina</td>
          <td valign="middle"><select name="oficinas_id" id="oficinas_id">
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
          </select></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle">Encargado</td>
          <td><select name="encargado" id="encargado">
              <option value="0">No, es el encargado</option>
              <option value="1">Si, es el encargado</option>
          </select></td>
        </tr>
        <tr valign="baseline">
          <td width="150" align="right" valign="middle">Cargo</td>
          <td valign="middle"><span id="sprytextfield3">
            <input name="cargo" type="text" class="tbox1" id="cargo" /></span></td>
        </tr>
        <tr valign="baseline">
          <td width="150">&nbsp;</td>
          <td><input type="submit" class="but1" value="Agregar"></td>
          </tr>
      </table>
      <input type="hidden" name="id" value="">
      <input type="hidden" name="snom" value="">
      <input type="hidden" name="MM_insert" value="form1" />
</form>
    <p>&nbsp;</p></td>
    <td width="20" valign="top">&nbsp;</td>
    <td width="250" valign="top"><h2>Opciones</h2>
        <div class="btit_2">Acciones</div>
        <div class="bcont">
        <div class="spacer"><a href="#" onClick="location.reload();"><div class="skin left" style="background-position:-80px -63px;margin-right:3px;"></div>Refrescar p&aacute;gina</a></div>
        <div class="spacer"><a href="vcuadro.php?pk=<?php echo $_GET['pk']?>" >
          <div class="skin left" style="background-position:-48px -79px;margin-right:3px;"></div>
          Cancelar y volver al cuadro</a></div>
        </div>
        <div class="btit_2">Informaci&oacute;n</div>
        <div class="bcont2">Rellene los cuadros y luego pulse el boton agregar para almacenar los datos, si desea cancelar puede usar el bot&oacute;n respectivo de la lista de acciones.</div>
        </td>
  </tr>
</table>

</div></div></div>
<script type="text/javascript">
ocultar();
<?php 
if($_GET['ck']!=""){
	echo "document.forms[0].oficinas_id.value=".$_GET['ck'].";";
}
?>;
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
</script>
</body>
</html>
<?php
mysql_free_result($rs1);
?>
