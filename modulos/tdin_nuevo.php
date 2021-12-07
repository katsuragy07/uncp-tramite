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


mysql_select_db($database_cn1, $cn1);
$query_rs3 = "SELECT * FROM td_tipos WHERE td_tipos.int=1 ORDER BY nombre ASC";
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
ajax.open("GET", "../modulos/tdin_list.php?of=<?php echo $_SESSION['u_ofice']; ?>&val="+opcionSeleccionada, true);
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
    <h2>Seleccione un tipo de expediente</h2>
    <h3>Seleccione un tipo</h3>
    <form method="POST" name="form1">
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla4">
        <tr valign="baseline">
          <td width="180" class="btit_1">Tipo</td>
          <td class="btit_1">Numeración</td>
          </tr>
        <tr valign="baseline">
          <td width="180" align="left" valign="top"><select name="td_tipos_id" size="25" id="td_tipos_id" onchange="bres(this.value);" style="width:175px">
            <?php
do {  
?>
            <option value="<?php echo $row_rs3['id']?>"><?php echo $row_rs3['nombre']?></option>
            <?php
} while ($row_rs3 = mysql_fetch_assoc($rs3));
  $rows = mysql_num_rows($rs3);
  if($rows > 0) {
      mysql_data_seek($rs3, 0);
	  $row_rs3 = mysql_fetch_assoc($rs3);
  }
?>
            
          </select></td>
          <td valign="top">
          <h3>Elija un número de expediente - <?php echo date("Y");?></h3>
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
        <div class="spacer"><a href="tdin_folemtd.php" >
          <div class="skin left" style="background-position:-48px -79px;margin-right:3px;"></div>
          Cancelar y volver a los emitidos</a></div>
        </div>
        <div class="btit_2">Informaci&oacute;n</div>
        <div class="bcont2">Seleccione un tipo de documento para ver una lista completa de los expedientes disponibles, los que ya fueron usados seran marcados con color gris y el texto tachado.</div>        </td>
  </tr>
</table>

</div></div></div>

</body>
</html>
<?php
mysql_free_result($rs2);

mysql_free_result($rs3);
?>