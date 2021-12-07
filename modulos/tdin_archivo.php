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

$colname_rs2 = "-1";
if (isset($_SESSION['u_empid'])) {
  $colname_rs2 = $_SESSION['u_empid'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs2 = sprintf("SELECT id, oficinas_id FROM empleado WHERE id = %s", GetSQLValueString($colname_rs2, "int"));
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
#wpag{background:transparent url(../images/pico_11.jpg) no-repeat fixed bottom right;}
</style>
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
ajax.open("GET", "../modulos/tdin_listarch.php?of=<?php echo $_SESSION['u_ofice']; ?>&val="+opcionSeleccionada, true);
ajax.onreadystatechange=function(){ 
	if (ajax.readyState==1){
		selectDestino.length=0;
		var nuevaOpcion=document.createElement("option"); nuevaOpcion.value=0;
		selectDestino.innerHTML="<h1>Cargando los datos</h1><h2>Espere por favor...</h2>";
		selectDestino.appendChild(nuevaOpcion); 
		selectDestino.disabled=true;	
	}
	if (ajax.readyState==4){
		selectDestino.innerHTML=ajax.responseText;
	} 
}
ajax.send(null);
}
</script>

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
    <h2>Archivos de oficina</h2>
    <h3>Expedientes enviados</h3>
    <form method="POST" name="form1">
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla4">
        <tr valign="baseline">
          <td width="180" class="btit_1">Tipo</td>
          <td class="btit_1">Numeración</td>
          </tr>
        <tr valign="baseline">
          <td width="180" align="left" valign="top"><select name="td_tipos_id" size="25" id="td_tipos_id" onchange="bres(this.value);" style="width:175px">
            <option value="0">Acuerdo</option>
            <option value="1">Aviso</option>
            <option value="2">Boletin</option>
            <option value="3">Carta</option>
            <option value="4">Circular</option>
            <option value="5">Decreto Legislativo</option>
            <option value="6">Decreto Regional</option>
            <option value="7">Decreto Supremo</option>
            <option value="8">Denuncia</option>
            <option value="9">Dictamen</option>
            <option value="10">Directiva</option>
            <option value="11">Expediente</option>
            <option value="12">Hoja Informativa</option>
            <option value="13">Informe</option>
            <option value="14">Memo</option>
            <option value="15">Nota de Pedido</option>
            <option value="16">Nota de Prensa</option>
            <option value="17">Notificacion</option>
            <option value="18">Oficio</option>
            <option value="19">Oficio Circular</option>
            <option value="20">Oficio Multiple</option>
            <option value="21">Resoluci&oacute;n</option>
            <option value="22">Revista</option>
            <option value="23">Sobre</option>
            <option value="25">Otro...</option>
          </select></td>
          <td valign="top">          
          <div id="caja"></div>
          </td>
        </tr>
        <tr valign="baseline">
          <td width="180">&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
      </table>
      <input type="hidden" name="id" value="">
      <input type="hidden" name="c_oficina" value="<?php echo $row_rs2['oficinas_id']; ?>">
      <input type="hidden" name="fecha" value="<?php echo date("Y-m-d H:i:s");?>">
      <input type="hidden" name="empid" value="<?php echo $_SESSION['u_empid']; ?>">
      <input type="hidden" name="user" value="<?php echo $_SESSION['u_id']; ?>">
      <input type="hidden" name="sal" value="1">
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
        <div class="bcont2">Rellene los cuadros y luego pulse el boton agregar para almacenar los datos, si desea cancelar puede usar el bot&oacute;n respectivo de la lista de acciones.</div>        </td>
  </tr>
</table>

</div></div></div>

</body>
</html>
<?php
mysql_free_result($rs2);
?>