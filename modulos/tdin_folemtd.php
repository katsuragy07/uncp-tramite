<?php require_once('../Connections/cn1.php'); ?>
<?php require_once('../includes/permisos_all_ui.php'); ?>
<?php require_once('../includes/functions.php'); ?>
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

$varssess=$_SESSION['u_ofice'];

mysql_select_db($database_cn1, $cn1);
$query_rs1 = "SELECT folioint.*
,(SELECT CONCAT(empleado.apellido,', ',empleado.nombre) FROM empleado WHERE empleado.id = folioint.empid LIMIT 1) AS enombre
,(SELECT CONCAT(lugares.nombre,' | ',oficinas.nombre) FROM oficinas,lugares WHERE oficinas.id=folioint.c_oficina AND oficinas.lugares_id=lugares.id LIMIT 1)AS onombre
FROM folioint 
WHERE folioint.c_oficina = $varssess
ORDER BY folioint.fecha DESC";
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
<style>#wpag{background:transparent url(../images/pico_11.jpg) no-repeat fixed bottom right;}</style>
<script type="text/javascript">function dlitem(ord){if(confirm("Deseas eliminar este registro?")){document.location.href= '../opers/del_td_nuevo.php?pk='+ord;}}</script> 

</head>
<body>
<div id="container"><div id="wpag">
  <div id="content">

<h1>Expedientes Emitidos (Internos) </h1>
<div class="hr"><em></em><span></span></div>

<div class="clear" style="height:5px"></div>
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>


<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><h2>Lista de expedientes emitidos desde la oficina</h2>
        <table width="90%" border="0" cellpadding="0" cellspacing="0" class="tabla2">
          <tr>
            <td width="93" class="btit_1">Número interno</td>
            <td align="left" class="btit_1">Cabecera y fecha</td>            
            <td class="btit_1">Firma, asunto y observaciones</td>
            <td class="btit_1">Oficina de creación</td>
            <td align="center" class="btit_1">N° de<br />Folios</td>
            <td align="center" class="btit_1">Adjunto</td>
            <td width="80" class="btit_1">Acciones</td>
          </tr>
          <?php if ($totalRows_rs1 > 0) { // Show if recordset not empty ?>
          <?php $cont=0; ?>
          <?php do { ?>
          <?php $cont++; ?>
          <tr <?php 
		  if ($row_rs1['urgente']==1) echo " class=\"urgente\" ";
		  ?>>
            <td width="93"><?php echo dftipo($row_rs1['td_tipos_id']); ?>
            <br /><span class="min"><?php echo dcoidfo($row_rs1['exp'],$row_rs1['fecha']);?></span>            </td>
            <td align="left"><?php echo ($row_rs1['cabecera']); ?><br><span class="min">Fecha: 
              <?php echo dptiemp($row_rs1['fecha']); ?></span></td>            
            <td><a href="tdin_verfolio.php?pk=<?php echo $row_rs1['id'];?>"><?php echo $row_rs1['firma']."<br /><span class='min'>".$row_rs1['asunto']."</span>"; ?><br><span class="min">Observaciones: <?php echo $row_rs1['obser']; ?></span></a></td>
            <td><strong><?php echo $row_rs1['onombre']; ?></strong><br /> 
            <span class="min">A&ntilde;adido por: <?php echo $row_rs1['enombre']; ?></span><br><span class="min">Observaciones: <?php echo $row_rs1['obs']; ?></span>
            <?php if ($row_rs1['urgente']==1) {?>
            <br /><span class="min" style="color:#FF6600;"><strong>Prioridad: URGENTE</strong></span>
			<?php }?>
            </td>
            <td align="center"><?php echo $row_rs1['nfolios']; ?></td>
            <td align="center"><?php if($row_rs1['file']!=""){?>
      <a href="../data/tdin_adjuntos/<?php echo $row_rs1['file'];?>" target="_blank" title="Descargar el archivo adjunto"><img src="../images/<?php echo dtarchivo($row_rs1['ext']);?>" style="border:none;" /></a>
      <?php }else{ ?>No<?php } ?></td>
      
            <td width="80"><div class="spacer"><a href="../opers/mod_tdin_nuevo.php?pk=<?php echo $row_rs1['id']; ?>"><span class="skin left" style="background-position:-48px -63px;margin-right:3px;"></span> Editar</a></div>
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
        <div class="spacer"><a href="tdin_nuevo.php" >
            <div class="skin left" style="background-position:-32px -79px;margin-right:3px;"></div>
            Agregar un nuevo Folio</a></div>
        </div>
        <div class="btit_2">Información</div>
        <div class="bcont2">Para ver los detalles del folio de un clic sobre el asunto.<br />
        OJO: Si elimina un folio que ya tiene un seguimiento guardado, tambien se eliminarán todos los registros relacionados al mismo.</div>
        </td>
  </tr>
</table>
</div></div></div>

</body>
</html>
<?php
mysql_free_result($rs1);
?>