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
  $insertSQL = sprintf("INSERT INTO folioext (id, exp, td_tipos_id, asunto, cabecera, firma, nfolios, fecha, `user`, empid, c_oficina, `file`, ext, size, aid, pago, urgente, obs) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
					GetSQLValueString($_POST['id'], "int"),
					GetSQLValueString(vfoexp($_POST['td_tipos_id']), "int"),
					GetSQLValueString($_POST['td_tipos_id'], "int"),							  
					GetSQLValueString(nl2br($_POST['asunto']), "text"),
					GetSQLValueString(dscomi($_POST['cabecera']), "text"),
					GetSQLValueString(dscomi($_POST['firma']), "text"),
					GetSQLValueString($_POST['nfolios'], "int"),
					GetSQLValueString($_POST['fecha'], "date"),
					GetSQLValueString($_POST['user'], "text"),
					GetSQLValueString($_POST['empid'], "int"),
					GetSQLValueString($_POST['c_oficina'], "int"),
					GetSQLValueString($_POST['file'], "text"),
					GetSQLValueString($_POST['ext'], "text"),
					GetSQLValueString($_POST['size'], "text"),
					GetSQLValueString($_POST['aid'], "text"),
					GetSQLValueString($_POST['pago'], "int"),
					GetSQLValueString($_POST['urgente'], "int"),
					GetSQLValueString(nl2br($_POST['obs']), "text"));

  mysql_select_db($database_cn1, $cn1);
  $Result1 = mysql_query($insertSQL, $cn1) or die(mysql_error());

  $insertGoTo = "td_folios.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  
  //sleep(100);
  //enviar a multiples oficinas ilimitadamente
  $torig=vfaid($_POST['aid'],"folioext");//id actual
  $toarr=explode(",",implode(",",$_POST['d_oficina']));//recibe array
  $tocan=count($toarr);//total de envios
	//v1 oficina origen
	//v2 tipo, 0 externo, 1 interno
	//v3 forma
	//v4 folio relacionado
  for($xb=0;$xb<$tocan;$xb++){
		//v1 origen//v2 destino//v3 tipo//v4 forma
		folio_derivar($toarr[$xb],0,0,$torig,$_POST['obs']);		
  }
  //fin de envios
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_cn1, $cn1);
$query_rs1 = "SELECT oficinas.id, CONCAT(lugares.nombre,' - ',oficinas.nombre) AS nombre FROM oficinas, lugares WHERE oficinas.lugares_id = lugares.id ORDER BY lugares.id, nombre ASC";
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

mysql_select_db($database_cn1, $cn1);
$query_rp1 = "SELECT id, nombre FROM reqs ORDER BY nombre ASC";
$rp1 = mysql_query($query_rp1, $cn1) or die(mysql_error());
$row_rp1 = mysql_fetch_assoc($rp1);
$totalRows_rp1 = mysql_num_rows($rp1);

mysql_select_db($database_cn1, $cn1);
$query_rs3 = "SELECT * FROM td_tipos WHERE td_tipos.ext=1 ORDER BY nombre ASC";
$rs3 = mysql_query($query_rs3, $cn1) or die(mysql_error());
$row_rs3 = mysql_fetch_assoc($rs3);
$totalRows_rs3 = mysql_num_rows($rs3);
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
<script src="../scripts/SpryValidationTextarea.js" type="text/javascript"></script>
<script type="text/javascript" src="../scripts/jquery.js"></script>
<?php 
$idautom = md5(uniqid(rand(), true)); 
$up_pref="of".date("His");
$up_url="tdex_adjuntos";
include("../includes/uploadoc_scripts.php");
?>

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
function mostrar() {
	var elem1 = document.getElementsByName("hos1");
	for (i = 0; i< elem1.length; i++) {
	var visible = 'block'
	elem1[i].style.display = visible;
	}
}
function mostrar2() {
	var elem1 = document.getElementsByName("hos2");
	for (i = 0; i< elem1.length; i++) {
	var visible = 'block'
	elem1[i].style.display = visible;
	}
}
function selca(sdep){
	if(!sdep){
		ocultar();
	}else{
		mostrar();
		document.forms[0].obs.value="";
	}
}
function selca2(sdep2){
	var ttec=" <?php echo date("d/m/Y");?>";
	var edest=document.getElementById("cabecera");
	var myselect=document.getElementById("td_tipos_id");
	var imsel=0;
	for (var i=0; i<myselect.options.length; i++){
	 if (myselect.options[i].value==sdep2){
	  imsel=i;
	  break
	 }
	}
	var tdec=myselect.options[imsel].text;
	if(tdec=="Otro...") tdec="(Especifique)";
	edest.value=tdec+" "+ttec;
}
</script>
<script type="text/javascript">
function nuevoAjax(){ 
var xmlhttp=false;
try{
xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
}
catch(e)
{
try{		
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
catch(E)
{
if (!xmlhttp && typeof XMLHttpRequest!='undefined') xmlhttp=new XMLHttpRequest();
}
}
return xmlhttp; 
}


function bres(id){
var selectDestino=document.getElementById("caja");
var ajax=nuevoAjax();
var opcionSeleccionada=id;
ajax.open("GET", "../includes/reqs_proceso.php?&opcion="+opcionSeleccionada, true);
ajax.onreadystatechange=function(){ 
if (ajax.readyState==1)
{
selectDestino.length=0;
var nuevaOpcion=document.createElement("option"); nuevaOpcion.value=0; nuevaOpcion.innerHTML="Cargando...";
selectDestino.appendChild(nuevaOpcion); selectDestino.disabled=true;	
}
if (ajax.readyState==4)
{
selectDestino.innerHTML=ajax.responseText;
} 
}
ajax.send(null);
}

function sli(t){
var dlista=document.getElementById("d_oficina");
switch (t){
	case 1:
		for (x=0;x<dlista.length;x++)
		dlista.options[x].selected = true;
	break;
	case 2:
		for (x=0;x<dlista.length;x++)
		dlista.options[x].selected = false;
	break;
	case 3:
		for (x=0;x<dlista.length;x++)
		if(dlista.options[x].selected==true){
			dlista.options[x].selected = false;
		}else{
			dlista.options[x].selected = true;
		}
		
	break;

}
	
} 
</script>

<script type="text/javascript">

pavalue = new Array(<?php
$ttdo="";
do { 
$csalto=$row_rp1['nombre'];
$ssalto = eregi_replace("[\n|\r|\n\r]", ' ', $csalto);
$ttdo = $ttdo."\"".strip_tags($ssalto)."\", ";
} while ($row_rp1 = mysql_fetch_assoc($rp1));
echo substr(str_replace("  ","",$ttdo),0,-2);
?>);

palabel = new Array(<?php
$ttdo="";
mysql_data_seek($rp1, 0);
$row_rp1 = mysql_fetch_assoc($rp1);
do { 
$csalto=$row_rp1['id'];
$ssalto = eregi_replace("[\n|\r|\n\r]", ' ', $csalto);
$ttdo = $ttdo.$ssalto.", ";
} while ($row_rp1 = mysql_fetch_assoc($rp1));
echo substr($ttdo,0,-2);
?>);
   
function cargarLista() {
  for (x=0;x<pavalue.length;x++)
    document.forms[1].reqnombre[x] = new Option(pavalue[x],palabel[x]);
 }
   
 function cargarpavalue() {
  for (x=0;x<pavalue.length;x++)
    document.forms[1].reqnombre[x] = new Option(pavalue[x],palabel[x]);
 }
function buscar() {

   limpiarpavalue();
   texto = document.getElementById("busca").value;
   expr = new RegExp(texto,"i");
   y = 0;
   for (x=0;x<pavalue.length;x++) {
     if (expr.test(pavalue[x])) {
      document.forms[1].reqnombre[y] = new Option(pavalue[x],palabel[x]);
       y++;
     }
   }
 }
   
 function limpiarpavalue() {
   for (x=document.forms[1].reqnombre.length;x>=0;x--)
	    document.forms[1].reqnombre[x] = null; 
 }
</script>


<script type="text/javascript">

pavalue2 = new Array(<?php
$ttdo="";
do { 
$csalto=$row_rs1['nombre'];
$ssalto = eregi_replace("[\n|\r|\n\r]", ' ', $csalto);
$ttdo = $ttdo."\"".strip_tags($ssalto)."\", ";
} while ($row_rs1 = mysql_fetch_assoc($rs1));
echo substr(str_replace("  ","",$ttdo),0,-2);
?>);

palabel2 = new Array(<?php
$ttdo="";
mysql_data_seek($rs1, 0);
$row_rs1 = mysql_fetch_assoc($rs1);
do { 
$csalto=$row_rs1['id'];
$ssalto = eregi_replace("[\n|\r|\n\r]", ' ', $csalto);
$ttdo = $ttdo.$ssalto.", ";
} while ($row_rs1 = mysql_fetch_assoc($rs1));
echo substr($ttdo,0,-2);
?>);
   
function cargarLista2() {
	for (x=0;x<pavalue2.length;x++)
		document.forms[0].d_oficina[x] = new Option(pavalue2[x],palabel2[x]);
		
		document.forms[0].d_oficina.value=1;
	}
   
 function cargarpavalue2() {
  for (x=0;x<pavalue2.length;x++)
    document.forms[0].d_oficina[x] = new Option(pavalue2[x],palabel2[x]);
 }
function buscar2() {

   limpiarpavalue2();
   texto = document.getElementById("busca2").value;
   expr = new RegExp(texto,"i");
   y = 0;
   for (x=0;x<pavalue2.length;x++) {
     if (expr.test(pavalue2[x])) {
      document.forms[0].d_oficina[y] = new Option(pavalue2[x],palabel2[x]);
       y++;
     }
   }
 }
   
 function limpiarpavalue2() {
   for (x=document.forms[0].d_oficina.length;x>=0;x--)
	    document.forms[0].d_oficina[x] = null; 
 }
</script>

<link href="../scripts/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../scripts/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
</head>
<body onload="cargarLista();cargarLista2();">
<div id="container"><div id="wpag"><div id="content">
<h1>Trámite Documentario</h1>
<div class="hr"><em></em><span></span></div>
<div class="clear" style="height:5px"></div>
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>
<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">
    <h2>Agregar un nuevo expediente externo</h2>
    <h3>Datos básicos</h3>
    <form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
        <tr valign="baseline">
          <td width="130" align="right" class="btit_1">Item</td>
          <td class="btit_1">Valor</td>
          </tr>
          
        <tr valign="baseline">
          <td width="130" align="right" valign="middle" class="btit_3">Tipo</td>
          <td><select name="td_tipos_id" id="td_tipos_id" onchange="selca2(this.value);">
            <?php
do {  
?>
            <option value="<?php echo $row_rs3['id']?>"<?php if (!(strcmp($row_rs3['id'], 25))) {echo "selected=\"selected\"";} ?>><?php echo $row_rs3['nombre']?></option>
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
        <tr valign="baseline">
          <td width="130" align="right" valign="middle" class="btit_3">Con pago</td>
          <td><label>
            <input name="pago" type="checkbox" id="pago" value="1" />
            ¿El expediente viene con recibo alg&uacute;n de pago?</label></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" class="btit_3">Cabecera</td>
          <td>
            <input name="cabecera" type="text" class="tbox2" id="cabecera" value="Solicitud <?php echo date("d/m/Y");?>" /></td>
        </tr>
        <tr valign="baseline">
          <td width="130" align="right" valign="middle" class="btit_3">Asunto</td>
          <td><span id="sprytextarea1">
            <textarea name="asunto" rows="2" class="tbox2" id="asunto"></textarea></span></td>
          </tr>
        <tr valign="baseline">
          <td width="130" align="right" valign="middle" class="btit_3">Firma (Nombre)</td>
          <td><span id="sprytextfield1">
            <input name="firma" type="text" class="tbox2" id="firma" /></span></td>
        </tr>
        <tr valign="baseline">
          <td width="130" align="right" valign="middle" class="btit_3">N&deg; de folios</td>
          <td><input name="nfolios" type="text" id="nfolios" value="1" size="10" autocomplete="off" /></td>
        </tr>
        <tr valign="baseline">
          <td align="left" valign="middle"  class="btit_3">Oficina de destino
            <p>
              <label><input type="radio" name="sel" id="sel_0" value="radio" onclick="sli(1);" onselect="sli(1);"/>Todos</label><br />
              <label><input type="radio" name="sel" id="sel_1" value="radio" onclick="sli(2);" onselect="sli(2);"/>Ninguno</label><br />
              <label><input type="radio" name="sel" id="sel_2" value="radio" onclick="sli(3);" onselect="sli(3);"/>Invertir</label><br />
            </p></td>
          <td>
          <div>
          <input name="busca2" type="text" class="tb2" id="busca2" style="width:200px" onkeyup="buscar2();" autocomplete="off" />
<input name="button2" type="button" class="bt1" id="button2" value="Limpiar filtro" onclick="document.forms[0].busca2.value='';buscar2();"/>
          </div>
          <div class="clear" style="height:10px;"></div>
            <select name="d_oficina[]" size="10" multiple="multiple" class="tbox2" id="d_oficina">
            </select>            </td>
        </tr>
        <tr valign="baseline">
          <td width="130" align="right" valign="middle" class="btit_3">Prioridad</td>
          <td  bgcolor="#def0ff"><label>
            <input name="urgente" type="checkbox" id="urgente" value="1" />
            Marcar el expediente como ¡Urgente!</label></td>
        </tr>
        <tr valign="baseline">
          <td width="130" align="right" valign="middle" class="btit_3">Observaciones y/o Correo electrónico</td>
          <td><label>
            <input type="checkbox" name="tobs" id="tobs" onclick="selca(this.checked);" />
            ¿Desea agregar algunas obervaciones y/o Correo Electrónico?</label><div name="hos1" id="hos1">
              <textarea name="obs" rows="4" class="tbox2" id="obs"></textarea>
            </div></td>
        </tr>
        
        <tr valign="baseline">
          <td align="right" valign="middle" class="btit_3">Adjuntar archivo</td>
          <td valign="middle"><?php include("../includes/uploadoc.php");?></td>
        </tr>
        <tr valign="baseline">
          <td width="130">&nbsp;</td>
          <td><input type="submit" class="but1" value="Guardar"></td>
          </tr>
      </table>
      <input type="hidden" name="id" value="">
      <input type="hidden" name="c_oficina" value="<?php echo $row_rs2['oficinas_id']; ?>">
      <input type="hidden" name="fecha" value="<?php echo date("Y-m-d H:i:s");?>">
      <input type="hidden" name="empid" value="<?php echo $_SESSION['u_empid']; ?>">
      <input type="hidden" name="user" value="<?php echo $_SESSION['u_id']; ?>">
      <input type="hidden" name="ext" value="">
      <input type="hidden" name="file" value="">
      <input type="hidden" name="size" value="">
      <input type="hidden" name="aid" value="<?php echo did();?>">      
      <input type="hidden" name="MM_insert" value="form1" />
</form></td>
    <td width="20" rowspan="2" valign="top">&nbsp;</td>
    <td width="250" rowspan="2" valign="top"><h2>Opciones</h2>
        <div class="btit_2">Acciones</div>
        <div class="bcont">
        <div class="spacer"><a href="#" onClick="location.reload();"><div class="skin left" style="background-position:-80px -63px;margin-right:3px;"></div>Refrescar p&aacute;gina</a></div>
        <div class="spacer"><a href="td_folios.php" >
          <div class="skin left" style="background-position:-48px -79px;margin-right:3px;"></div>
          Cancelar e ir a la lista general</a></div>
        </div>
        <div class="btit_2">Informaci&oacute;n</div>
        <div class="bcont2">Rellene los cuadros y luego pulse el boton agregar para almacenar los datos, si desea cancelar puede usar el bot&oacute;n respectivo de la lista de acciones.<br />
        El número de expediente se asignará automáticamente, si desea cambiarlo tiene que editar el documento despues de crearlo.</div>        </td>
  </tr>
  <tr>
    <td valign="top">
    <br>
    <h3>Requisitos</h3>
    <form action="" method="get">
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
        <tr valign="baseline">
          <td width="130" align="right" class="btit_1">Item</td>
          <td class="btit_1">Valor</td>
          </tr>
        <tr valign="baseline">
          <td width="130" align="right" class="btit_3">Filtrar lista:</td>
          <td><input name="busca" type="text" class="tb2" id="busca" style="width:200px" onkeyup="buscar();" autocomplete="off" />
			<input name="button" type="button" class="bt1" id="button2" value="Limpiar filtro" onclick="document.forms[1].busca.value='';buscar();"/></td>
        </tr>
        <tr valign="baseline">
          <td width="130" align="right" valign="middle" class="btit_3">Nombre</td>
          <td>
          
          
          
          
          <label>
            <select name="reqnombre" size="6" id="reqnombre" onchange="bres(this.value);" style="max-width:800px;">           
            </select>
          </label></td>
        </tr>
        <tr valign="baseline">
          <td width="130" align="right" valign="middle" class="btit_3">Descripción</td>
          <td><div id="caja">&nbsp;</div></td>
        </tr>
      </table>
    </form>
    </td>
  </tr>
</table>

</div></div></div>

<script type="text/javascript">
document.forms[0].d_oficina.value=27;
ocultar();
ocultar2();
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
</script>
</body>
</html>
<?php
mysql_free_result($rs1);

mysql_free_result($rs2);

mysql_free_result($rp1);

mysql_free_result($rs3);
?>