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
  $updateSQL = sprintf("UPDATE users SET nombre=%s, pass=%s, `level`=%s, perfil_id=%s, snom=%s WHERE id=%s",
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['pass'], "text"),
                       GetSQLValueString($_POST['level'], "int"),
                       GetSQLValueString($_POST['perfil_id'], "int"),
                       GetSQLValueString($_POST['snom'], "int"),
                       GetSQLValueString($_POST['id'], "text"));

  mysql_select_db($database_cn1, $cn1);
  $Result1 = mysql_query($updateSQL, $cn1) or die(mysql_error());

  $updateGoTo = "../modulos/user.php?pk=".$_POST['empleado_id'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  
  header(sprintf("Location: %s", $updateGoTo));
}

  

mysql_select_db($database_cn1, $cn1);
$query_rs2 = "SELECT * FROM sistemas ORDER BY nombre ASC";
$rs2 = mysql_query($query_rs2, $cn1) or die(mysql_error());
$row_rs2 = mysql_fetch_assoc($rs2);
$totalRows_rs2 = mysql_num_rows($rs2);

mysql_select_db($database_cn1, $cn1);
$query_rs3 = "SELECT * FROM perfil ORDER BY nombre ASC";
$rs3 = mysql_query($query_rs3, $cn1) or die(mysql_error());
$row_rs3 = mysql_fetch_assoc($rs3);
$totalRows_rs3 = mysql_num_rows($rs3);

$colname_rs4 = "-1";
if (isset($_GET['ck'])) {
  $colname_rs4 = $_GET['ck'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs4 = sprintf("SELECT * FROM users WHERE id = %s", GetSQLValueString($colname_rs4, "text"));
$rs4 = mysql_query($query_rs4, $cn1) or die(mysql_error());
$row_rs4 = mysql_fetch_assoc($rs4);
$totalRows_rs4 = mysql_num_rows($rs4);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/int.css" rel="Stylesheet" type="text/css" />
<style>
#wpag{background:transparent url(../images/pico_6.jpg) no-repeat fixed bottom right;}
</style>
<script src="../scripts/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../scripts/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
function gpass() {
	var strCaracteresPermitidos = '_,+,-,a,b,c,d,e,f,g,h,j,k,m,n,p,q,r,s,t,u,v,w,x,y,z,1,2,3,4,5,6,7,8,9';
	var strArrayCaracteres = new Array(34);
	strArrayCaracteres = strCaracteresPermitidos.split(',');
	var length=7, i = 0, j, tmpstr = "";
	do {
		var randscript = -1
		while (randscript < 1 || randscript > strArrayCaracteres.length || isNaN(randscript)) {
			randscript = parseInt(Math.random() * strArrayCaracteres.length)
		}
		j = randscript;
		tmpstr = tmpstr + strArrayCaracteres[j];
		i = i + 1;
	} while (i < length)
 document.forms[0].pass.value='@'+tmpstr;
}

function camb(){
  var selectedArray=0;
  var selObj = document.getElementById('snom2');
  var i;
  var count = 1;
  for (i=0; i<selObj.options.length; i++) {
    if (selObj.options[i].selected) {
      selectedArray = selectedArray+parseInt(selObj.options[i].value);
      count++;
    }
  }

  document.forms[0].snom.value=selectedArray;
}
function ocultar() {
	var elem1 = document.getElementsByName("hos1");
	var elem2 = document.getElementsByName("hos2");
	for (k = 0; k< elem1.length; k++) {
		elem1[k].style.display = "none";
		elem2[k].style.display = "none";
	}
}

function mostrar() {
	var elem1 = document.getElementsByName("hos1");
	var elem2 = document.getElementsByName("hos2");
	for (i = 0; i< elem1.length; i++) {
		if(navigator.appName.indexOf("Microsoft") > -1){
		var visible = 'block'
	} else {
		var visible = 'table-row';
	}
	elem1[i].style.display = visible;
	elem2[i].style.display = visible;
	}
}


function selca(){
	var sdep=document.forms[0].level.value;
	if(sdep==0){
		ocultar();
		document.forms[0].perfil_id.value=1;
		document.forms[0].snom.value=3;
	}else{
		mostrar();
		document.forms[0].perfil_id.value=4;
		document.forms[0].snom.value=2;
	}
}
</script>

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
    <h2>Empleado municipal</h2>
        
    <form method="POST" name="form1" action="<?php echo $editFormAction; ?>">
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
        <tr valign="baseline">
          <td width="150" align="right" class="btit_1">Item</td>
          <td class="btit_1">Valor</td>
          </tr>
        <tr valign="baseline">
          <td width="150" align="right" valign="middle">Nombre de usuario</td>
          <td><span id="sprytextfield1">
          <input name="nombre" type="text" class="tbox2" id="nombre" value="<?php echo $row_rs4['nombre']; ?>" /><span class="textfieldMinCharsMsg"><br/>Se necesitan 4 car&aacute;cteres como m&iacute;nimo</span></span></td>
          </tr>
        <tr valign="baseline">
          <td width="150" align="right" valign="middle">Contraseña</td>
          <td><span id="sprytextfield2">
            <input name="pass" type="text" class="tbox1" id="pass" value="<?php echo $row_rs4['pass']; ?>" />
            <span class="textfieldMinCharsMsg">Se necesitan 4 car&aacute;cteres como m&iacute;nimo</span></span>
<input type="button" onclick="gpass();" name="button" id="button" value="Generar" /></td>
        </tr>
        <?php if($row_rs4['empleado_id']!=1){ ?>
        <tr valign="baseline">
          <td width="150" align="right" valign="middle">Nivel de acceso</td>
          <td>
            <select name="level" id="level" onchange="selca();">
              <option value="1" <?php if (!(strcmp(1, $row_rs4['level']))) {echo "selected=\"selected\"";} ?>>Empleado normal</option>
              <option value="0" <?php if (!(strcmp(0, $row_rs4['level']))) {echo "selected=\"selected\"";} ?>>Administrador General</option>
            </select>            </td>
          </tr>
        <tr valign="baseline" name="hos1" id="hos1">
          <td width="150" align="right" valign="middle">Sistemas autorizados<br />
            (Ctrl+clic para selección múltiple)</td>
          <td valign="middle"><select name="snom2" size="2" multiple="multiple" id="snom2" onchange="camb();">
            <?php
do {  
?>
            <option value="<?php echo $row_rs2['id']?>"><?php echo $row_rs2['nombre']?></option>
            <?php
} while ($row_rs2 = mysql_fetch_assoc($rs2));
  $rows = mysql_num_rows($rs2);
  if($rows > 0) {
      mysql_data_seek($rs2, 0);
	  $row_rs2 = mysql_fetch_assoc($rs2);
  }
?>           
            </select></td>
          </tr>
        <tr valign="baseline" name="hos2" id="hos2">
          <td width="150" align="right" valign="middle">Perfil</td>
          <td><select name="perfil_id" id="perfil_id">
<?php do { ?>
<?php if($row_rs3['id']!=1){ ?>
<option value="<?php echo $row_rs3['id']?>"<?php if (!(strcmp($row_rs3['id'], 4))) {echo "selected=\"selected\"";} ?>><?php echo $row_rs3['nombre']?></option>
<?php } ?>
<?php
} while ($row_rs3 = mysql_fetch_assoc($rs3));
  $rows = mysql_num_rows($rs3);
  if($rows > 0) {
      mysql_data_seek($rs3, 0);
	  $row_rs3 = mysql_fetch_assoc($rs3);
  }
?>
                    </select></td>
          </tr>
          <?php } ?>
        <tr valign="baseline">
          <td width="150">&nbsp;</td>
          <td><input type="submit" class="but1" value="Modificar"></td>
          </tr>
      </table>
      <input type="hidden" name="id" value="<?php echo $row_rs4['id']; ?>">
      <input type="hidden" name="snom" value="<?php echo $row_rs4['snom']; ?>">
      <input type="hidden" name="empleado_id" value="<?php echo $row_rs4['empleado_id']; ?>">
      <input type="hidden" name="MM_update" value="form1" />
    </form>
    <p>&nbsp;</p></td>
    <td width="20" valign="top">&nbsp;</td>
    <td width="250" valign="top"><h2>Opciones</h2>
        <div class="btit_2">Acciones</div>
        <div class="bcont">
        <div class="spacer"><a href="#" onClick="location.reload();"><div class="skin left" style="background-position:-80px -63px;margin-right:3px;"></div>Refrescar p&aacute;gina</a></div>
        <div class="spacer"><a href="../modulos/user.php?pk=<?php echo $row_rs4['empleado_id']; ?>" >
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
<?php if($row_rs4['snom']==3){ ?>
document.forms[0].snom2.options[0].selected=true;
document.forms[0].snom2.options[1].selected=true;
<?php }else{ ?>
<?php if($row_rs4['snom']==1){ ?>
document.forms[0].snom2.options[0].selected=true;
<?php }else{ ?>
document.forms[0].snom2.options[1].selected=true;
<?php }} ?>
</script>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {minChars:4});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {minChars:4});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($rs2);

mysql_free_result($rs3);

mysql_free_result($rs4);
?>