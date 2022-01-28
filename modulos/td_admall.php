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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rs1 = 50;
$pageNum_rs1 = 0;
if (isset($_GET['pageNum_rs1'])) {
  $pageNum_rs1 = $_GET['pageNum_rs1'];
}
$startRow_rs1 = $pageNum_rs1 * $maxRows_rs1;

mysql_select_db($database_cn1, $cn1);
$query_rs1 = "SELECT folioext.*
,(SELECT CONCAT(empleado.apellido,', ',empleado.nombre) FROM empleado WHERE empleado.id = folioext.empid LIMIT 1) AS enombre
,(SELECT CONCAT(lugares.nombre,' | ',oficinas.nombre) FROM oficinas,lugares,folioext WHERE oficinas.id=folioext.c_oficina AND oficinas.lugares_id=lugares.id LIMIT 1)AS onombre
FROM folioext
ORDER BY folioext.fecha DESC";
$query_limit_rs1 = sprintf("%s LIMIT %d, %d", $query_rs1, $startRow_rs1, $maxRows_rs1);
$rs1 = mysql_query($query_limit_rs1, $cn1) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);

if (isset($_GET['totalRows_rs1'])) {
  $totalRows_rs1 = $_GET['totalRows_rs1'];
} else {
  $all_rs1 = mysql_query($query_rs1);
  $totalRows_rs1 = mysql_num_rows($all_rs1);
}
$totalPages_rs1 = ceil($totalRows_rs1/$maxRows_rs1)-1;

$queryString_rs1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rs1") == false && 
        stristr($param, "totalRows_rs1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rs1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rs1 = sprintf("&totalRows_rs1=%d%s", $totalRows_rs1, $queryString_rs1);

$TFM_LimitLinksEndCount = 10;
$TFM_temp = $pageNum_rs1 + 1;
$TFM_startLink = max(1,$TFM_temp - intval($TFM_LimitLinksEndCount/2));
$TFM_temp = $TFM_startLink + $TFM_LimitLinksEndCount - 1;
$TFM_endLink = min($TFM_temp, $totalPages_rs1 + 1);
if($TFM_endLink != $TFM_temp) $TFM_startLink = max(1,$TFM_endLink - $TFM_LimitLinksEndCount + 1);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/int.css" rel="Stylesheet" type="text/css" />
<style>
#wpag{background:transparent url(../images/pico_11.jpg) no-repeat fixed bottom right;}
#result{height:20px;font-size:16px;font-family:Arial,Helvetica,sans-serif;color:#333;padding:5px;margin-bottom:10px;background-color:#ff9;}#country{padding:3px;border:1px #CCC solid;font-size:17px;}.suggestionsBox{margin:26px 0px 0px 0px;width:100%;padding:0px;background-color:#fff;border-top:3px solid #add1ff;color:#00e;}.suggestionList{margin:0px;padding:0px;}.suggestionList ul li{list-style:none;cursor:pointer;margin-bottom:5px;padding:7px;border:1px solid #c0c0c2;}.suggestionList ul li:hover{color:#000;border:1px solid #ffb700;background-color:#ffd86c;font-weight:bold;}.suggestionList ul{font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#333;padding:0;margin:0;}.load{background-image:url(../images/loader.gif);background-position:right;background-repeat:no-repeat;}#suggest{position:relative;}.suggenfer{margin:0px;padding:0px;}.suggenfer ul li{list-style:none;cursor:pointer;margin-bottom:5px;padding:7px;border:1px solid #a8ccea;background-color:#f3f8fc;color:#555;}.suggenfer ul li:hover{color:#00e;border:1px solid #00e;}.suggenfer ul li a{text-decoration:none;font-weight:bold;color:#1a4568;}.suggenfer ul li a:visited{text-decoration:none;font-weight:bold;color:#1a4568;}.suggenfer ul{font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#333;padding:0;margin:0;}
</style>
<script type="text/javascript">function dlitem(ord){if(confirm("Deseas eliminar este registro?")){document.location.href= '../opers/del_td_nuevo.php?pk='+ord;}}</script> 
<script type="text/javascript" src="../scripts/jquery.js"></script>
<script type="text/javascript">
function suggest(inputString){if(inputString.length==0){$('#suggestions').fadeOut()}else{$('#pname').addClass('load');$.post("../includes/autos_folio.php",{queryString:""+inputString+""},function(data){if(data.length>0){$('#suggestions').fadeIn();$('#suggestionsList').html(data);$('#pname').removeClass('load')}})}}function fill(thisValue){$('#pname').val(thisValue);setTimeout("$('#suggestions').fadeOut();",600)}var default_content="";
</script>
<script language="javascript"> 
eval(function(p,a,c,k,e,r){e=function(c){return c.toString(a)};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('$(7).8(1(){$(\'9\').2(1(0){3(0==4){5 6}});$(\'a\').2(1(0){3(0.b==4){5 6}})});',12,12,'e|function|keypress|if|13|return|false|document|ready|form|input|which'.split('|'),0,{}))
</script> 
</head>
<body>
<div id="container"><div id="wpag">
  <div id="content">

<h1>Expedientes Externos (Todos)</h1>
<div class="hr"><em></em><span></span></div>

<div class="clear" style="height:5px"></div>
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>


<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">

    
    <form id="form" action="#">
    <div id="suggest">
    <h2>Búsqueda rápida (Ingrese la firma o asunto):</h2>
    <br />
    <input type="text" size="25" value="" id="pname" onkeyup="suggest(this.value);" onblur="fill();" class="tbox2" autocomplete="off"/>
    <div class="suggestionsBox" id="suggestions" style="display: none;"> <img src="../images/arrowb.png" style="position: relative; top: -12px; left: 30px;" alt="fecha" />
    <div class="suggestionList" id="suggestionsList"> &nbsp; </div></div></div>
    </form>

    
    <h2>Lista de expedientes registrados (Internos)</h2>
        <table width="90%" border="0" cellpadding="0" cellspacing="0" class="tabla2">
          <tr>
            <td width="70" class="btit_1">Número interno</td>
            <td align="left" class="btit_1">Cabecera y fecha</td>            
            <td class="btit_1">Firma, asunto y observaciones</td>
            <td class="btit_1">Oficina de creación</td>
            <td align="center" class="btit_1">Vence en</td>
            <td align="center" class="btit_1">Adjunto</td>
            <td width="80" class="btit_1">Acciones</td>
          </tr>
          <?php if ($totalRows_rs1 > 0) { // Show if recordset not empty ?>
          <?php $cont=0; ?>
          <?php do { ?>
          <?php $cont++; ?>
          <tr>
            <td width="70"><?php echo dftipo($row_rs1['td_tipos_id']); ?>
            <br /><span class="min"><?php echo dcoidfo($row_rs1['exp'],$row_rs1['fecha']);?></span>            </td>
            <td align="left"><?php echo ($row_rs1['cabecera']); ?><br><span class="min">Fecha: 
              <?php echo dptiemp($row_rs1['fecha']); ?></span></td>            
            <td><a href="td_verfolio.php?pk=<?php echo $row_rs1['id'];?>"><?php echo $row_rs1['firma']."<br /><span class='min'>".$row_rs1['asunto']."</span>"; ?><br><span class="min">Observaciones: <?php echo $row_rs1['obser']; ?></span></a></td>
            <td><strong><?php echo $row_rs1['onombre']; ?></strong><br /> 
            <span class="min">A&ntilde;adido por: <?php echo $row_rs1['enombre']; ?></span><br><span class="min">Observaciones: <?php echo $row_rs1['obs']; ?></span></td>
            <td align="center"><?php 
				if($row_rs1['atendido']==NULL){
					echo dfechv($row_rs1['fecha'],$row_rs1['td_tipos_id']); 
				}else{
					echo "Atendido";
				}
				?></td>
            <td align="center"><?php if($row_rs1['file']!=""){?>
      <a href="../data/tdex_adjuntos/<?php echo $row_rs1['file'];?>" target="_blank" title="Descargar el archivo adjunto"><img src="../images/<?php echo dtarchivo($row_rs1['ext']);?>" style="border:none;" /></a>
      <?php }else{ ?>No<?php } ?></td>
            <td width="80">
                 <div class="spacer"><a href="../opers/mod_td_nuevo.php?pk=<?php echo $row_rs1['id']; ?>"><span class="skin left" style="background-position:-48px -63px;margin-right:3px;"></span> Editar</a></div>
                  </td>
          </tr>
          <?php } while ($row_rs1 = mysql_fetch_assoc($rs1)); ?>
          <?php } // Show if recordset not empty ?>
      </table>
      <?php include("../includes/navbar.php");?></td>
    <td width="20" valign="top">&nbsp;</td>
    <td width="250" valign="top"><h2>Opciones</h2>
        <div class="btit_2">Acciones</div>
        <div class="bcont">
        <div class="spacer"><a href="#" onClick="location.reload();"><div class="skin left" style="background-position:-80px -63px;margin-right:3px;"></div>Refrescar p&aacute;gina</a></div>
        </div>
        <div class="btit_2">Información</div>
        <div class="bcont2">Para ver los detalles del folio de un clic sobre el asunto.<br />
        </div>
        </td>
  </tr>
</table>
</div></div></div>

</body>
</html>
<?php
mysql_free_result($rs1);
?>