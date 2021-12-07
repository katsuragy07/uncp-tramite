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

$maxRows_rs1 = 20;
$pageNum_rs1 = 0;
if (isset($_GET['pageNum_rs1'])) {
  $pageNum_rs1 = $_GET['pageNum_rs1'];
}
$startRow_rs1 = $pageNum_rs1 * $maxRows_rs1;

$colname_rs1 = "-1";
if (isset($_SESSION['u_ofice'])) {
  $colname_rs1 = $_SESSION['u_ofice'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs1 = ("SELECT * 
FROM acuerdos 
WHERE (SELECT SUM(acuitem.estado = 'Pendiente') FROM acuitem WHERE acuitem.acuerdos_id = acuerdos.id) > 0

ORDER BY anno DESC, num DESC");
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

<script type="text/javascript" src="../scripts/sorttable.js"></script>
<script type="text/javascript" src="<?php echo WB_JQUERY;?>"></script>
<script type="text/javascript">
function dactiv2(ord) {
	if(confirm("Deseas cambiar el estado de este elemento a NO PUBLICADO?")){
		document.location.href= 'activar.php?ac=2&ta=paginas&rf=paginas_list&pk='+ord
	}
}
function dactiv1(ord) {
	if(confirm("Deseas cambiar el estado de este elemento a PUBLICADO?")){
		document.location.href= 'activar.php?ac=1&ta=paginas&rf=paginas_list&pk='+ord
	}
}

</script>

<script type="text/javascript" src="../scripts/jquery.uitablefilter.js"></script>

<script type="text/javascript">
$(function() { 
  var theTable = $('table.tabmetro')
  theTable.find("tbody > tr").find("td:eq(1)").mousedown(function(){
    $(this).prev().find(":checkbox").click()
  });
  $("#filter").keyup(function() {
    $.uiTableFilter( theTable, this.value );
  })
  $('#filter-form').submit(function(){
    theTable.find("tbody > tr:visible > td:eq(1)").mousedown();
    return false;
  }).focus(); //Give focus to input field
});  
</script>

<style>
.cdates{
	background:#2083dc;
	color:#fff;
	text-align:center;
	margin-top: 3px;
	font-size:10px;
	padding: 3px 5px;
	font-weight:bold;
	
	text-shadow: 0px 0px 3px #006;
	
	border-radius: 5px;
	-moz-border-radius: 5px;
	
	
}
.blinkss{
	display:block;
	background: #fff;
	border-radius: 5px;
	
	padding: 5px;
	
	-moz-border-radius: 5px;
	
	box-shadow: 0 0 2px #666;
	-moz-box-shadow: 0 0 2px #666;
	

}

.blinkss:hover {
	text-decoration: none;
	color: #fff;
	background:#fd7a30;
}


.amsj {
	font-size: 9px;
	background:#fff;
	
	text-align: center;
	
	padding: 2px 3px;
	width: 70px;
	
	border: 1px solid #d0d0d0;
	
	border-radius: 		3px;
	-moz-border-radius: 3px;
	
	box-shadow: 		0 0 1px #999;
	-moz-box-shadow: 	0 0 1px #999;
}


.amsj1 { background:#249817; color:#FFF; }
.amsj2 { background:#fff; color:#000; }
.amsj3 { background:#df0050; color:#FFF; }
.amsj0 { background:#f0f0f0; color:#000; }
.SGgrod{
	background: #fff;
	border-top: 1px dotted #aaa;
	border-left: 1px dotted #aaa;
}

.stitles{
	color: #098d19;
	text-decoration: underline;
}

.aopera{
	background:#fff url(../images/bgi3.png) repeat-x bottom left;
	
	margin-top: 7px;
	padding: 10px 8px;
	border: 1px solid #add1fd;
	
	border-radius: 		5px;
	-moz-border-radius: 5px;
	
	box-shadow: 		0 0 3px #999;
	-moz-box-shadow: 	0 0 3px #999;
}

</style>

<script type="text/javascript">function dlitem(ord){if(confirm("Deseas eliminar este registro?")){document.location.href= '../opers/del_acu.php?pk='+ord;}}</script> 

</head>
<body>
<div id="container"><div id="wpag">
  <div id="content">

<h1>Sesiones con acuerdos pendientes</h1>
<div class="hr"><em></em><span></span></div>

<div class="clear" style="height:5px"></div>
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>


<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">


<h2>Lista de valores filtrados</h2>




<div class="clear"></div>
      <table width="90%" border="0" cellpadding="0" cellspacing="0" class="tabla2 sortable">
          <thead>
          <tr>
          	<th class="btit_1" width="90"><span class="min">Año - Número<br />
            Fecha</span></th>
            <th align="left" class="btit_1">Sesión</th>            
            
            <th class="btit_1" width="60">Adjunto</th>

            <th width="60" class="btit_1">&nbsp;</th>

          </tr>
          </thead>
          <?php if ($totalRows_rs1 > 0) { // Show if recordset not empty ?>
          <?php $cont=0; ?>          
          <?php do { ?>
          <?php $cont++; ?>
          <tr <?php 
		  if ($row_rs1['urgente']==1) echo " class=\"urgente\" ";
		  ?>>

            <td align="center" valign="top">
              <a href="acu_ver.php?pk=<?php echo $row_rs1['id'];?> " title="Abrir acuerdo" class="blinkss">
              <div >
              <span class="min">
			  <?php echo ($row_rs1['anno']);?> - <strong><?php echo fillceros($row_rs1['num']);?></strong>
              </span>
              
              <br />
              <div class="cdates">
			  <?php echo dfecha5($row_rs1['fecha']); ?>
              </div>
              </div>
              </a>
              
            </td>
            <td align="left" valign="top">

<?php echo dbla($row_rs1['descrip']); ?>




<div class="clear" style="10px;"></div>

<strong style="color:#0d55d8;">Acuerdos:</strong>

<div class="clear" style="5px;"></div>

<?php

$colname_rs3 = "-1";
if (isset($row_rs1['id'])) {
  $colname_rs3 = $row_rs1['id'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs3 = sprintf("SELECT * FROM acuitem WHERE acuerdos_id = %s", GetSQLValueString($colname_rs3, "int"));
$rs3 = mysql_query($query_rs3, $cn1) or die(mysql_error());
$row_rs3 = mysql_fetch_assoc($rs3);
$totalRows_rs3 = mysql_num_rows($rs3);

?>

<div style="background:#FFF" class="SGgrod">
<table width="90%" border="0" cellpadding="0" cellspacing="0" class="tablanone">
          <?php if ($totalRows_rs3 > 0) { // Show if recordset not empty ?>
          <?php $cont=0; ?>          
          <?php do { ?>
          <?php $cont++; ?>
          <tr>

            <td width="10%" align="center">
              
              <?php echo destadoFS($row_rs3['estado']); ?>
              
              
            </td>
            <td align="left">
              <?php echo dbla($row_rs3['nombre']); ?>
              
              <?php if($row_rs3['fecha_fin']!="" || $row_rs3['descrip']!=""){ ?>
           
           <div class="aopera">
           
           <?php if($row_rs3['fecha_fin']!=""){ ?>
           <strong class="stitles">Fecha de finalización:</strong> <?php echo dfecha5($row_rs3['fecha_fin']); ?>
           <div class="clear" style="height:7px"></div>
           <?php } // Fin IF ?>
           
			<?php if($row_rs3['descrip']!=""){ ?>
           <strong class="stitles">Detalles:</strong> <?php echo dbla($row_rs3['descrip']); ?>
           <?php } // Fin IF ?>
           
           
           </div>
           
           <?php } // Fin IF ?>
              
              
            </td>
            </tr>
          <?php } while ($row_rs3 = mysql_fetch_assoc($rs3)); ?>          
          <?php } // Show if recordset not empty ?>
      </table>
</div>

<?php
mysql_free_result($rs3);
?>  


              
            </td>
            <td align="center" valign="top"><?php if($row_rs1['file']!=""){?>
              <a href="../data/acuerdos/<?php echo $row_rs1['file'];?>" target="_blank" title="Descargar el archivo adjunto, <?php echo $row_rs1['size'];?>"><img src="../images/<?php echo dtarchivo($row_rs1['ext']);?>" style="border:none;" /></a>
              <?php }else{ ?>No<?php } ?></td>
      

            <td valign="top"><div class="barlist right" style="width: 80px">
                <ul>
                  <li><a href="../opers/mod_acu.php?pk=<?php echo $row_rs1['id']; ?>"><span class="skin left" style="background-position:-48px -63px;margin-right:3px;"></span> Editar</a></li>
  <li><a href="javascript:dlitem(<?php echo $row_rs1['id']; ?>);">
    <div class="skin left" style="background-position:-64px -63px;margin-right:3px;"></div>
    Eliminar            </a></li>
  </ul>
              </div></td>

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

	
          
        <div class="spacer"><a href="acu_list.php" >
          <div class="skin left" style="background-position:-96px -63px;margin-right:3px;"></div>
          Volver a la lista de acuerdos</a></div>

        </div>
        
        
        
        
        
        
        <div class="btit_2">Información</div>
        <div class="bcont2">Desde este panel puede revisar todos los acuerdos tomados dentro de las reuniones.</div>
        </td>
  </tr>
</table>
</div></div></div>

</body>
</html>
<?php
mysql_free_result($rs1);
?>