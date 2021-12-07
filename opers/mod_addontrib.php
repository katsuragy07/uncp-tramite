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
  $updateSQL = sprintf("UPDATE contribuyente SET tipo=%s, rasocial=%s, ruc=%s, nombre=%s, apellido=%s, dni=%s, sexo=%s, fechnac=%s, estcivil=%s, distrito_id=%s, distrito_provincia_id=%s, distrito_provincia_depart_id=%s, baja=%s, baja_obs=%s, fecha=%s, `user`=%s, dir_tipo=%s, dir_nombre=%s, dir_num=%s, dir_dpto=%s, dir_mz=%s, dir_lote=%s, telef=%s, celu=%s WHERE id=%s",
                       GetSQLValueString($_POST['tipo'], "int"),
                       GetSQLValueString($_POST['rasocial'], "text"),
                       GetSQLValueString($_POST['ruc'], "text"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['apellido'], "text"),
                       GetSQLValueString($_POST['dni'], "text"),
                       GetSQLValueString($_POST['sexo'], "int"),
                       GetSQLValueString($_POST['fechnac'], "date"),
                       GetSQLValueString($_POST['estcivil'], "int"),
                       GetSQLValueString($_POST['distrito_id'], "int"),
                       GetSQLValueString($_POST['distrito_provincia_id'], "int"),
                       GetSQLValueString($_POST['distrito_provincia_depart_id'], "int"),
                       GetSQLValueString($_POST['baja'], "int"),
                       GetSQLValueString($_POST['baja_obs'], "text"),
                       GetSQLValueString($_POST['fecha'], "date"),
                       GetSQLValueString($_POST['user'], "text"),
                       GetSQLValueString($_POST['dir_tipo'], "int"),
                       GetSQLValueString($_POST['dir_nombre'], "text"),
                       GetSQLValueString($_POST['dir_num'], "text"),
                       GetSQLValueString($_POST['dir_dpto'], "text"),
                       GetSQLValueString($_POST['dir_mz'], "text"),
                       GetSQLValueString($_POST['dir_lote'], "text"),
                       GetSQLValueString($_POST['telef'], "text"),
                       GetSQLValueString($_POST['celu'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_cn1, $cn1);
  $Result1 = mysql_query($updateSQL, $cn1) or die(mysql_error());

  $updateGoTo = "../modulos/vercontrib.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}


mysql_select_db($database_cn1, $cn1);
$query_rd1 = "SELECT * FROM depart";
$rd1 = mysql_query($query_rd1, $cn1) or die(mysql_error());
$row_rd1 = mysql_fetch_assoc($rd1);
$totalRows_rd1 = mysql_num_rows($rd1);

mysql_select_db($database_cn1, $cn1);
$query_rs1 = "SELECT MAX(LAST_INSERT_ID(id)) AS ultimo FROM contribuyente";
$rs1 = mysql_query($query_rs1, $cn1) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
$totalRows_rs1 = mysql_num_rows($rs1);

$colname_rs0 = "-1";
if (isset($_GET['pk'])) {
  $colname_rs0 = $_GET['pk'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs0 = sprintf("SELECT * FROM contribuyente WHERE id = %s", GetSQLValueString($colname_rs0, "int"));
$rs0 = mysql_query($query_rs0, $cn1) or die(mysql_error());
$row_rs0 = mysql_fetch_assoc($rs0);
$totalRows_rs0 = mysql_num_rows($rs0);

mysql_select_db($database_cn1, $cn1);
$query_rsg = "SELECT distrito.nombre,(SELECT provincia.nombre FROM provincia WHERE provincia.id=distrito.provincia_id) AS pnombre,
(SELECT depart.nombre FROM depart WHERE depart.id=distrito.provincia_depart_id) AS dnombre FROM distrito WHERE distrito.id=".$row_rs0['distrito_id'];
$rsg = mysql_query($query_rsg, $cn1) or die(mysql_error());
$row_rsg = mysql_fetch_assoc($rsg);
$totalRows_rsg = mysql_num_rows($rsg);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
#wpag{background:transparent url(../images/pico_6.jpg) no-repeat fixed bottom right;}#demoIzq, #demoDer, #demoMed{
width:33%; text-align:center; margin:0 1px 0 1px;}#demoDer, #demoMed{float:right;}.aselect{ width:33%;}
</style>
<link href="../css/int.css" rel="Stylesheet" type="text/css" />
<script src="../scripts/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../scripts/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
function ocultar1() {
	var elem1 = document.getElementsByName("dempresa");
	for (k = 0; k< elem1.length; k++) {
		elem1[k].style.display = "none";
	}
}
function ocultar2() {
	var elem1 = document.getElementsByName("dpersona");
	for (k = 0; k< elem1.length; k++) {
		elem1[k].style.display = "none";
	}
}
function ocultar3() {
	var elem1 = document.getElementsByName("hosi");
	for (k = 0; k< elem1.length; k++) {
		elem1[k].style.display = "none";
	}
}

function mostrar1() {
	var elem1 = document.getElementsByName("dempresa");
	for (i = 0; i< elem1.length; i++) {
	var visible = 'block'
	elem1[i].style.display = visible;
	elem1[i].style.width="100%";
	}
}
function mostrar2() {
	var elem1 = document.getElementsByName("dpersona");
	for (i = 0; i< elem1.length; i++) {
	var visible = 'block'
	elem1[i].style.display = visible;
	}
}
function mostrar3() {
	var elem1 = document.getElementsByName("hosi");
	for (i = 0; i< elem1.length; i++) {
		if(navigator.appName.indexOf("Microsoft") > -1){
		var visible = 'block'
	} else {
		var visible = 'table-row';
	}
	elem1[i].style.display = visible;
	}
}
function selca(sdep){
	if(sdep!=2){
		ocultar1();
		mostrar2();
	}else{
		mostrar1();
		ocultar2();
		document.forms[0].slocal_0.style.display = "none";
	}
}
function blocal(sdep2){
	if(sdep2!=2){
		mostrar3();
	}else{
		ocultar3();
	}
}

function fyea(dota){
var thoy= <?php echo date("Y");?>;
var tanno=document.forms[0].fanno.value;
var tedad=document.forms[0].edad.value;
var vart=dota;
if(vart==0){
	document.forms[0].edad.value=thoy-tanno;
}else{
	document.forms[0].fanno.value=thoy-tedad;
}
fdate(dota);
}

function fdate(doty){
document.forms[0].fechnac.value=document.forms[0].fanno.value+"-"+document.forms[0].fmes.value+"-"+document.forms[0].fdia.value;
fedad(doty);
}
function fedad(doty){
var fhoy= <?php echo date("Y");?>;
var tcon=0;
var vart=doty;
if(doty==0){
	tcon = fhoy-document.forms[0].fanno.value;
	document.forms[0].edad.value=tcon;
}
}
function asig(va1,va2){
	switch(va1){
		case 1:document.forms[0].distrito_provincia_depart_id.value=va2;break;
		case 2:document.forms[0].distrito_provincia_id.value=va2;break;
		case 3:document.forms[0].distrito_id.value=va2;break;
	}
}
function nuevoAjax(){ 
	var xmlhttp=false;
	try
	{
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch(e)
	{
		try
		{
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(E)
		{
			if (!xmlhttp && typeof XMLHttpRequest!='undefined') xmlhttp=new XMLHttpRequest();
		}
	}
	return xmlhttp; 
}
var listadoSelects=new Array();
listadoSelects[0]="select1";
listadoSelects[1]="select2";
listadoSelects[2]="select3";
function buscarEnArray(array, dato)
{
	var x=0;
	while(array[x])
	{
		if(array[x]==dato) return x;
		x++;
	}
	return null;
}

function cargaContenido(idSelectOrigen)
{
	var posicionSelectDestino=buscarEnArray(listadoSelects, idSelectOrigen)+1;
	var selectOrigen=document.getElementById(idSelectOrigen);
	var opcionSeleccionada=selectOrigen.options[selectOrigen.selectedIndex].value;
	if(opcionSeleccionada==0)
	{
		var x=posicionSelectDestino, selectActual=null;
		while(listadoSelects[x])
		{
			selectActual=document.getElementById(listadoSelects[x]);
			selectActual.length=0;
			var nuevaOpcion=document.createElement("option"); nuevaOpcion.value=0; nuevaOpcion.innerHTML="Selecciona Opci&oacute;n...";
			selectActual.appendChild(nuevaOpcion);	selectActual.disabled=true;
			x++;
		}
	}
	else if(idSelectOrigen!=listadoSelects[listadoSelects.length-1])
	{
		var idSelectDestino=listadoSelects[posicionSelectDestino];
		var selectDestino=document.getElementById(idSelectDestino);
		switch(idSelectOrigen){
			case "select2":asig(2,opcionSeleccionada);break;
			case "select3":asig(3,opcionSeleccionada);break;
	}
		var ajax=nuevoAjax();
		ajax.open("GET", "../includes/inse3s_process.php?select="+idSelectDestino+"&opcion="+opcionSeleccionada, true);
		ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{
				selectDestino.length=0;
				var nuevaOpcion=document.createElement("option"); nuevaOpcion.value=0; nuevaOpcion.innerHTML="Cargando...";
				selectDestino.appendChild(nuevaOpcion); selectDestino.disabled=true;	
			}
			if (ajax.readyState==4)
			{
				selectDestino.parentNode.innerHTML=ajax.responseText;
			} 
		}
		ajax.send(null);
	}
}
function nsin(){
	if(document.forms[0].sin.checked==true){
		document.forms[0].dir_num.value="S/N";
	}else{
		document.forms[0].dir_num.value="";
	}
}
function ndin(){
	var snom=document.getElementById('moes');
	var snom2=document.getElementById('dir_tipo');
	switch (snom2.value){		
		case "0":snom.innerHTML=" Av. ";break;
		case "1":snom.innerHTML=" Jr. ";break;
		case "2":snom.innerHTML=" Calle ";break;
		case "3":snom.innerHTML=" Psje. ";break;
		case "4":snom.innerHTML=" Especificar &raquo; ";break;
	}
}
</script>
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
    <h2>Contribuyente &raquo; <?php echo $row_rs0['cod']; ?></h2>
    <form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
    <h3>Tipo de contribuyente</h3>    
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
      <tr valign="baseline">
          <td width="100" align="right" class="btit_1">Item</td>
          <td class="btit_1">Valor</td>
          </tr>
        <tr valign="baseline">
          <td width="100" align="right" valign="middle" class="btit_3">Seleccione</td>
          <td><p>
            <label><input <?php if (!(strcmp($row_rs0['tipo'],"0"))) {echo "checked=\"checked\"";} ?> name="tipo" type="radio" id="tipo_0" onclick="selca(1);" value="0" /> 
            Persona Natural</label>
            <br />
            <label><input <?php if (!(strcmp($row_rs0['tipo'],"1"))) {echo "checked=\"checked\"";} ?> type="radio" name="tipo" value="1" id="tipo_1" onclick="selca(2);" />
             Persona Jurídica (Empresa)</label>
            <br />
          </p></td>
          </tr>
      </table>
    <div id="dempresa" name="dempresa">
<h3>Datos básicos &raquo; Persona jurídica</h3>    
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
        <tr valign="baseline">
          <td width="100" align="right" class="btit_1">Item</td>
          <td class="btit_1">Valor</td>
          </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" class="btit_3">Razon Social</td>
          <td><input name="rasocial" type="text" class="tbox2" id="rasocial" value="<?php echo $row_rs0['rasocial']; ?>" /></td>
        </tr>
        <tr valign="baseline">
          <td width="100" align="right" valign="middle" class="btit_3">RUC</td>
          <td><span id="sprytextfield1">
          <input name="ruc" type="text" class="tbox1" id="ruc" value="<?php echo $row_rs0['ruc']; ?>" />
          <span class="textfieldMinCharsMsg">El RUC debe tener 11 digitos enteros.</span></span></td>
        </tr>
      </table>
	  </div>
     <div id="dpersona" name="dpersona" class="clear">
    <h3>Datos básicos &raquo; Persona natural</h3>    
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
        <tr valign="baseline">
          <td width="100" align="right" class="btit_1">Item</td>
          <td class="btit_1">Valor</td>
          </tr>
        <tr valign="baseline">
          <td width="100" align="right" valign="middle" class="btit_3">Nombres</td>
          <td><input name="nombre" type="text" class="tbox2" id="nombre" value="<?php echo $row_rs0['nombre']; ?>" /></td>
        </tr>
        <tr valign="baseline">
          <td width="100" align="right" valign="middle" class="btit_3">Apellidos</td>
          <td><input name="apellido" type="text" class="tbox2" id="apellido" value="<?php echo $row_rs0['apellido']; ?>"></td>
          </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" class="btit_3">DNI</td>
          <td><span id="sprytextfield2">
          <input name="dni" type="text" id="dni" value="<?php echo $row_rs0['dni']; ?>" size="15" />
          <span class="textfieldMinCharsMsg">El DNI debe tener 8 digitos enteros.</span></span></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" class="btit_3">Sexo</td>
          <td>
            <select name="sexo" id="sexo">
              <option value="1" <?php if (!(strcmp(1, $row_rs0['sexo']))) {echo "selected=\"selected\"";} ?>>Masculino</option>
              <option value="0" <?php if (!(strcmp(0, $row_rs0['sexo']))) {echo "selected=\"selected\"";} ?>>Femenino</option>
            </select></td>
        </tr>
      </table>
      <h3>Datos personales &raquo; Persona natural</h3>    
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
        <tr valign="baseline">
          <td width="100" align="right" class="btit_1">Item</td>
          <td class="btit_1">Valor</td>
          </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" class="btit_3">Fecha Nacimiento</td>
          <td>día:
<select name="fdia" class="tb3" id="fdia" onchange="fdate()">
<script type="text/javascript">var dd; for(var j=1;j<32;j++){if(j<10){dd="0"+j;}else{dd=j;}document.write("<option value="+dd+">"+dd+"</option>");}
document.forms[0].fdia.selectedIndex = <?php 
if (substr($row_rs0['fechnac'],8,1)=="0"){
echo substr($row_rs0['fechnac'],9,1);
}else{
echo substr($row_rs0['fechnac'],8,2);
};
?>-1;
</script>
</select> / mes: 
<select name="fmes" class="tb3" id="fmes" onchange="fdate()">
<option value="01">Enero</option>
<option value="02">Febrero</option>
<option value="03">Marzo</option>
<option value="04">Abril</option>
<option value="05">Mayo</option>
<option value="06">Junio</option>
<option value="07">Julio</option>
<option value="08">Agosto</option>
<option value="09">Setiembre</option>
<option value="10">Octubre</option>
<option value="11">Noviembre</option>
<option value="12">Diciembre</option>
<script type="text/javascript">
document.forms[0].fmes.selectedIndex = <?php 
if (substr($row_rs0['fechnac'],5,1)=="0"){
echo substr($row_rs0['fechnac'],6,1);
}else{
echo substr($row_rs0['fechnac'],5,2);
};
?>-1;
</script>
</select> / año:
<select name="fanno" class="tb3" id="fanno" onchange="fyea(0);">
<script type="text/javascript">for(var j=1850;j<<?php echo date("Y");?>+1;j++) document.write("<option value="+j+">"+j+"</option>");
document.forms[0].fanno.selectedIndex = <?php echo substr($row_rs0['fechnac'],0,4);?>-1850;
</script>
</select></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" class="btit_3">Edad</td>
          <td><select name="edad" class="tb3" id="edad" onchange="fyea(1);">
<?php  
for($xt=(date("Y")-1850);$xt>0;$xt--){
echo "<option value=\"".$xt."\">".$xt."</option>";
}
?>
</select> 
          Años</td>
        </tr>
        <tr valign="baseline">
          <td width="100" align="right" valign="middle" class="btit_3">Estado civil</td>
          <td><select name="estcivil" class="tb3" id="estcivil">
  <option value="0" <?php if (!(strcmp(0, $row_rs0['estcivil']))) {echo "selected=\"selected\"";} ?>>Soltero (a)</option>
  <option value="1" <?php if (!(strcmp(1, $row_rs0['estcivil']))) {echo "selected=\"selected\"";} ?>>Casado (a)</option>
  <option value="2" <?php if (!(strcmp(2, $row_rs0['estcivil']))) {echo "selected=\"selected\"";} ?>>Divorciado (a)</option>
  <option value="3" <?php if (!(strcmp(3, $row_rs0['estcivil']))) {echo "selected=\"selected\"";} ?>>Viudo (a)</option>
</select></td>
          </tr>
      </table>
      </div>
      <h3>Baja de contribuyente</h3>    
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
        <tr valign="baseline">
          <td width="100" align="right" class="btit_1">Item</td>
          <td class="btit_1">Valor</td>
          </tr>
        <tr valign="baseline">
          <td width="100" align="right" valign="middle" class="btit_3">¿Dar de baja?</td>
          <td><select name="baja" id="baja" onchange="selca3(this.value);">
            <option value="0" <?php if (!(strcmp(0, $row_rs0['baja']))) {echo "selected=\"selected\"";} ?>>No</option>
            <option value="1" <?php if (!(strcmp(1, $row_rs0['baja']))) {echo "selected=\"selected\"";} ?>>Si, dar de baja</option>
            &nbsp;
          </select></td>
        </tr>
        <tr valign="baseline">
          <td width="100" align="right" valign="middle" class="btit_3">Observaciones</td>
          <td><textarea name="baja_obs" rows="3" class="tbox2" id="baja_obs"><?php echo $row_rs0['baja_obs']; ?></textarea></td>
          </tr>
      </table>
      <h3>Contacto</h3>    
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
        <tr valign="baseline">
          <td width="100" align="right" class="btit_1">Item</td>
          <td class="btit_1">Valor</td>
          </tr>
        <tr valign="baseline">
          <td width="100" align="right" valign="middle" class="btit_3">Teléfono</td>
          <td><input name="telef" type="text" class="tbox1" id="telef" value="<?php echo $row_rs0['telef']; ?>" /></td>
        </tr>
        <tr valign="baseline">
          <td width="100" align="right" valign="middle" class="btit_3">Celular</td>
          <td><input name="celu" type="text" class="tbox1" id="celu" value="<?php echo $row_rs0['celu']; ?>" /></td>
          </tr>
      </table>
      <h3>Domicilio fiscal</h3>    
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
        <tr valign="baseline">
          <td width="100" align="right" class="btit_1">Item</td>
          <td class="btit_1">Valor</td>
          </tr>
        <tr valign="baseline">
          <td width="100" align="right" valign="middle" class="btit_3">Dirección</td>
          <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabla3">
            <tr>
              <td width="60" rowspan="2" align="right" class="btit_3">Dirección</td>
              <td><select name="dir_tipo" id="dir_tipo" onchange="ndin();">
                <option value="0" selected="selected" <?php if (!(strcmp(0, $row_rs0['dir_tipo']))) {echo "selected=\"selected\"";} ?>>Avenida</option>
                <option value="1" <?php if (!(strcmp(1, $row_rs0['dir_tipo']))) {echo "selected=\"selected\"";} ?>>Jirón</option>
                <option value="2" <?php if (!(strcmp(2, $row_rs0['dir_tipo']))) {echo "selected=\"selected\"";} ?>>Calle</option>
                <option value="3" <?php if (!(strcmp(3, $row_rs0['dir_tipo']))) {echo "selected=\"selected\"";} ?>>Pasaje</option>
                <option value="4" <?php if (!(strcmp(4, $row_rs0['dir_tipo']))) {echo "selected=\"selected\"";} ?>>Otro</option>
                </select>
                </td>
            </tr>
            <tr>
              <td><div id="moes" name="moes" style="display:inline;"> Av. </div>
<input name="dir_nombre" type="text" id="dir_nombre" style="width:70%" value="<?php echo $row_rs0['dir_nombre']; ?>" /></td>
            </tr>

            <tr>
              <td width="60" align="right" class="btit_3">Número</td>
              <td><input name="dir_num" type="text" id="dir_num" value="<?php echo $row_rs0['dir_num']; ?>" size="10" onkeypress="document.getElementById('sin').checked=false;" />
                <label>
                <input name="sin" type="checkbox" id="sin" onclick="nsin();" />
                Sin número</label></td>
            </tr>
            <tr>
              <td width="60" align="right" class="btit_3">Dpto.</td>
              <td><input name="dir_dpto" type="text" id="dir_dpto" value="<?php echo $row_rs0['dir_dpto']; ?>" size="10" /></td>
            </tr>
            <tr>
              <td width="60" align="right" class="btit_3">Mz.</td>
              <td><input name="dir_mz" type="text" id="dir_mz" value="<?php echo $row_rs0['dir_mz']; ?>" size="10" /></td>
            </tr>
            <tr>
              <td width="60" align="right" class="btit_3">Lote</td>
              <td><input name="dir_lote" type="text" id="dir_lote" value="<?php echo $row_rs0['dir_lote']; ?>" size="10" /></td>
            </tr>
          </table></td>
          </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" class="btit_3">Localización</td>
          <td>
          <?php echo $row_rsg['dnombre']." &raquo; ".$row_rsg['pnombre']." &raquo; ".$row_rsg['nombre']; ?>
          <input type="button" name="button" id="button" value="Cambiar"  onclick="mostrar3();" /></td>
        </tr>
        <tr valign="baseline" id="hosi" name="hosi">
          <td width="100" align="right" valign="middle" class="btit_3">Seleccione la localización</td>
          <td valign="middle">
          <div id="demo" style="width:100%;">
				<div id="demoDer">
				<select name="select3" disabled="disabled" class="aselect" id="select3" style="width:100%">
            <option value="0">&laquo; Elige</option>
            </select>
             </div>
				<div id="demoMed">
				<select name="select2" disabled="disabled" class="aselect" id="select2" style="width:100%">
            <option value="0">&laquo; Elige</option>
            </select>
            </div>
				<div id="demoIzq">
            <span id="spryselect1">
				<select name="select1" class="aselect" id="select1" style="width:100%" onchange='cargaContenido(this.id);asig(1,this.value);'>
				<option value="0">Elije un Departamento &raquo;</option>
				    <?php
do {  
?>
				    <option value="<?php echo $row_rd1['id']?>"><?php echo utf8_encode($row_rd1['nombre']);?></option>
				    <?php
} while ($row_rd1 = mysql_fetch_assoc($rd1));
  $rows = mysql_num_rows($rd1);
  if($rows > 0) {
      mysql_data_seek($rd1, 0);
	  $row_rd1 = mysql_fetch_assoc($rd1);
  }
?>
				    </select>
				 </span></div>
			</div>          </td>
        </tr>
        <tr valign="baseline">
          <td width="100">&nbsp;</td>
          <td><input type="submit" class="but1" value="Modificar"></td>
          </tr>
      </table>
      <input type="hidden" name="id" value="<?php echo $row_rs0['id']; ?>">
      <input type="hidden" name="fechnac" value="<?php echo $row_rs0['fechnac']; ?>">
      <input type="hidden" name="distrito_id" value="<?php echo $row_rs0['distrito_id']; ?>">
      <input type="hidden" name="distrito_provincia_id" value="<?php echo $row_rs0['distrito_provincia_id']; ?>">
      <input type="hidden" name="distrito_provincia_depart_id" value="<?php echo $row_rs0['distrito_provincia_depart_id']; ?>">
      <input type="hidden" name="fecha" value="<?php echo date("Y-m-d H:i:s");?>">
      <input type="hidden" name="user" value="<?php echo $_SESSION['u_id']; ?>">
      <input type="hidden" name="MM_insert" value="form1" />
      <input type="hidden" name="MM_update" value="form1" />
</form></td>
    <td width="20" valign="top">&nbsp;</td>
    <td width="250" valign="top"><h2>Opciones</h2>
        <div class="btit_2">Acciones</div>
        <div class="bcont">
        <div class="spacer"><a href="#" onClick="location.reload();"><div class="skin left" style="background-position:-80px -63px;margin-right:3px;"></div>Refrescar p&aacute;gina</a></div>
        <div class="spacer"><a href="../modulos/vercontrib.php?<?php echo dlanno($_GET['anno']);?>pk=<?php echo $_GET['pk'];?>" >
          <div class="skin left" style="background-position:-48px -79px;margin-right:3px;"></div>
          Cancelar e ir volver</a></div>
        </div>
        <div class="btit_2">Informaci&oacute;n</div>
        <div class="bcont2">Rellene los cuadros y luego pulse el boton agregar para almacenar los datos, si desea cancelar puede usar el bot&oacute;n respectivo de la lista de acciones.<br />
        Si desea hacer un registro rápido solo necesita rellenar el tipo de contribuyente y los datos básicos,</div>
        </td>
  </tr>
</table>

</div></div></div>

<script type="text/javascript">
<?php if($row_rs0['tipo']==0){ ?>
ocultar1();
<?php }else{ ?>
ocultar2();
<?php } ?>


<?php if($row_rs0['dir_num']==0){ ?>
document.getElementById('sin').checked=true;
document.getElementById('dir_num').value="S/N";
<?php } ?>
fyea(0);
ocultar3();


var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {isRequired:false, minChars:11, validateOn:["change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "integer", {isRequired:false, minChars:8, validateOn:["change"]});
</script>
</body>
</html>
<?php
mysql_free_result($rd1);

mysql_free_result($rs1);

mysql_free_result($rs0);

mysql_free_result($rsg);
?>
