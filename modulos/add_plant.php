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

$colname_rs1 = "-1";
if (isset($_SESSION['u_ofice'])) {
  $colname_rs1 = $_SESSION['u_ofice'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs1 = sprintf("SELECT * FROM oficinas WHERE id = %s", GetSQLValueString($colname_rs1, "int"));
$rs1 = mysql_query($query_rs1, $cn1) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
$totalRows_rs1 = mysql_num_rows($rs1);

mysql_select_db($database_cn1, $cn1);
$query_rs2 = "SELECT oficinas.id, CONCAT(lugares.nombre,'&nbsp;&nbsp;|&nbsp;&nbsp;',oficinas.nombre) AS nombre FROM oficinas, lugares WHERE oficinas.lugares_id = lugares.id ORDER BY lugares.id, nombre ASC";
$rs2 = mysql_query($query_rs2, $cn1) or die(mysql_error());
$row_rs2 = mysql_fetch_assoc($rs2);
$totalRows_rs2 = mysql_num_rows($rs2);
?>
<?php
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO folioint (id, exp, t_tipo, asunto, cabecera, firma, nfolios, fecha, `user`, empid, c_oficina, `file`, ext, size, aid, obs) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
							  GetSQLValueString($_POST['exp'], "int"),
                       GetSQLValueString($_POST['t_tipo'], "int"),							  
                       GetSQLValueString(nl2br($_POST['asunto']), "text"),
							  GetSQLValueString($_POST['cabecera'], "text"),
                       GetSQLValueString($_POST['firma'], "text"),
                       GetSQLValueString($_POST['nfolios'], "int"),
                       GetSQLValueString($_POST['fecha'], "date"),
                       GetSQLValueString($_POST['user'], "text"),
                       GetSQLValueString($_POST['empid'], "int"),
                       GetSQLValueString($_POST['c_oficina'], "int"),
							  GetSQLValueString($_POST['file'], "text"),
							  GetSQLValueString($_POST['ext'], "text"),
							  GetSQLValueString($_POST['size'], "text"),
							  GetSQLValueString($_POST['aid'], "text"),
                       GetSQLValueString(nl2br($_POST['obs']), "text"));

  mysql_select_db($database_cn1, $cn1);
  $Result1 = mysql_query($insertSQL, $cn1) or die(mysql_error());

  $insertGoTo = "tdin_folemtd.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  logac("Expediente interno|EXP:".$_POST['exp'],0,$_SESSION['u_id'],$_SESSION['u_empid']);
  
  //sleep(100);
  //enviar a multiples oficinas ilimitadamente
  $torig=vfaid($_POST['aid'],"folioint");//id actual
  $toarr=explode(",",implode(",",$_POST['d_oficina']));//recibe array
  $tocan=count($toarr);//total de envios
	//v1 oficina origen
	//v2 tipo, 0 externo, 1 interno
	//v3 forma
	//v4 folio relacionado
  for($xb=0;$xb<$tocan;$xb++){
		//v1 origen//v2 destino//v3 tipo//v4 forma
		folio_derivar($toarr[$xb],1,0,$torig,$_POST['obs']);		
  }
  //fin de envios
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/int.css" rel="Stylesheet" type="text/css" />


<script type="text/javascript" src="../scripts/jquery.js"></script>
<?php 
$idautom = md5(uniqid(rand(), true)); 
$up_pref="of".date("His");
$up_url="tdin_adjuntos";
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
	if(sdep2!=25){
		ocultar2();
	}else{
		mostrar2();
		document.forms[0].t_otro.value="";
	}
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
<style>
#container{background:#D8E2E4 url(../images/bgi3.png) repeat-x fixed top;}
</style>
</head>
<body>

<div id="container"><div id="wpag">
<div id="bartop">

    <ul id="baropt">
    <li><a onClick="document.forms['form1'].submit();" class="bsav"><div class="skin left" style="background-position:-80px -127px;margin-right:3px;"></div>
    Continuar</a></li>
    <li><a onClick="document.forms['form1'].submit();" class="bsend"><div class="skin left" style="background-position:-48px -95px;margin-right:3px;"></div>Guardar</a></li>
    <li><a href="mesa_folios.php" onClick="location.reload();">
      <div class="skin left" style="background-position:-48px -79px;margin-right:3px;"></div>Cancelar</a></li>
    <li style="float:right"><a href="#" onClick="location.reload();"><div class="skin left" style="background-position:-80px -63px;margin-right:3px;"></div>Refrescar p&aacute;gina</a></li>   
    </ul>

</div>


<div class="clear" style="height:23px"></div>

<div id="tools">
<div id="navdir" class="nnormal">
		<div class="content" style="height:20px;">
		
        </div>
        
	</div>
    <div style="margin:0 auto 0 auto;">
    <script type="text/javascript" src="../scripts/nicEdit-latest.js"></script> <script type="text/javascript">
//<![CDATA[
     bkLib.onDomLoaded(function() {
          var myNicEditor = new nicEditor();
          myNicEditor.setPanel('myNicPanel');
          myNicEditor.addInstance('descrip');
     });
  //]]>
  </script>
    <div id="myNicPanel" style="width: 700px;"></div>
    </div>
    
<div class="hr"><em></em><span></span></div>
</div>




<div id="content">
<div class="clear" style="height:10px"></div>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
<div id="cpagina">
<div class="shadow">
<div class="cuerpo">
<textarea name="descrip" rows="40" class="paper" id="descrip" style="border:none;"></textarea>
</div>
</div>
</div>




<input type="hidden" name="id" value="">
<input type="hidden" name="c_oficina" value="<?php echo $_SESSION['u_ofice']; ?>">
<input type="hidden" name="fecha" value="<?php echo date("Y-m-d H:i:s");?>">
<input type="hidden" name="empid" value="<?php echo $_SESSION['u_empid']; ?>">
<input type="hidden" name="user" value="<?php echo $_SESSION['u_id']; ?>">
<input type="hidden" name="t_tipo" value="<?php echo $_GET['tip'];?>">
<input type="hidden" name="ext" value="">
<input type="hidden" name="file" value="">
<input type="hidden" name="size" value="">
<input type="hidden" name="aid" value="<?php echo dev_uid();?>">
<input type="hidden" name="MM_insert" value="form1" />
</form>
</div></div></div>

<script type="text/javascript">
document.forms[0].d_oficina.value=<?php echo $_SESSION['us_officeid']; ?>;
ocultar();
ocultar2();
</script>
</body>
</html>
<?php
mysql_free_result($rs1);

mysql_free_result($rs2);
?>
