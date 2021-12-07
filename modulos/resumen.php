<?php require_once('../Connections/cn1.php'); ?>
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

mysql_select_db($database_cn1, $cn1);
$query_rs1 = "SELECT COUNT(id) AS tot, pini_anno, pfin_anno, tipo FROM exoneracion GROUP BY pfin_anno, tipo";
$rs1 = mysql_query($query_rs1, $cn1) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
$totalRows_rs1 = mysql_num_rows($rs1);

mysql_select_db($database_cn1, $cn1);
$query_rs2 = "SELECT COUNT(id) AS tot, YEAR(fecha) AS anno FROM predio GROUP BY YEAR(fecha)";
$rs2 = mysql_query($query_rs2, $cn1) or die(mysql_error());
$row_rs2 = mysql_fetch_assoc($rs2);
$totalRows_rs2 = mysql_num_rows($rs2);

mysql_select_db($database_cn1, $cn1);
$query_rs3 = "SELECT COUNT(id) AS tot, YEAR(fecha) AS anno, tipo FROM contribuyente GROUP BY YEAR(fecha), tipo";
$rs3 = mysql_query($query_rs3, $cn1) or die(mysql_error());
$row_rs3 = mysql_fetch_assoc($rs3);
$totalRows_rs3 = mysql_num_rows($rs3);

mysql_select_db($database_cn1, $cn1);
$query_rs4 = "SELECT COUNT(id) AS tot, YEAR(fecha) AS anno, con_tipo FROM contribuyente_has_predio GROUP BY YEAR(fecha)";
$rs4 = mysql_query($query_rs4, $cn1) or die(mysql_error());
$row_rs4 = mysql_fetch_assoc($rs4);
$totalRows_rs4 = mysql_num_rows($rs4);

mysql_select_db($database_cn1, $cn1);
$query_rs5 = "SELECT * FROM declar";
$rs5 = mysql_query($query_rs5, $cn1) or die(mysql_error());
$row_rs5 = mysql_fetch_assoc($rs5);
$totalRows_rs5 = mysql_num_rows($rs5);

mysql_select_db($database_cn1, $cn1);
$query_rs6 = "SELECT COUNT(id) AS cant, YEAR(fecha) AS anno, SUM(monto) AS tot FROM declar GROUP BY YEAR(fecha) ORDER BY anno DESC";
$rs6 = mysql_query($query_rs6, $cn1) or die(mysql_error());
$row_rs6 = mysql_fetch_assoc($rs6);
$totalRows_rs6 = mysql_num_rows($rs6);
?>
<?php require_once('../includes/functions.php'); ?>
<?php require_once('../includes/permisos_all_ui.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/int.css" rel="Stylesheet" type="text/css" />
<style>
#wpag{background:transparent url(../images/pico_12.jpg) no-repeat fixed bottom right;}
</style>

<script type="text/javascript">function dlitem(ord){if(confirm("Deseas eliminar este registro?")){document.location.href= '../opers/del_uit.php?pk='+ord;}}</script> 

</head>
<body>
<div id="container"><div id="wpag"><div id="content">

<h1>Resumen de los Registros</h1>
<div class="hr"><em></em><span></span></div>

<div class="clear" style="height:5px"></div>
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>


<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><h4>Predios</h4>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="49%" valign="top"><h3>Predios registrados</h3>
    <table width="90%" border="0" cellpadding="0" cellspacing="0" class="tabla">
          <tr>
            <td class="btit_1">Año</td>
            <td width="100" align="right" class="btit_1">Cantidad</td>
            <td width="110" align="right" class="btit_1">&nbsp;</td>
            </tr>
          <?php $vtota=0; ?>
          <?php do { ?>
          <tr>
            <td><?php echo $row_rs2['anno']; ?></td>
            <td width="100" align="right"><?php echo $row_rs2['tot']; ?></td>
            <td width="110" align="right">
            <div class="spacer right" style="width:90px"><a href="../reportes/res_pred.php?pk=<?php echo $row_rs2['anno']; ?>" target="_blank">
		  		<div class="skin left" style="background-position:-0px -79px;margin-right:3px;"></div>Ver reporte</a></div>
            </td>
            </tr>
            <?php $vtota=$vtota+$row_rs2['tot']; ?>
           <?php } while ($row_rs2 = mysql_fetch_assoc($rs2)); ?>
           <tr>
            <td align="right">Total &raquo;</td>
            <td width="100" align="right"><?php echo $vtota; ?></td>
            <td width="110" align="right">&nbsp;</td>
          </tr>
</table>
    </td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="49%" valign="top"><h3>Predios exoneraciones</h3>
      <table width="90%" border="0" cellpadding="0" cellspacing="0" class="tabla">
          <tr>
            <td class="btit_1">Año de Vencimiento</td>
            <td class="btit_1">Tipo</td>
            <td width="100" align="right" class="btit_1">Cantidad</td>
            <td class="btit_1">&nbsp;</td>
            </tr>
          <?php $vtota=0; ?>
          <?php do { ?>
          <tr>
            <td><?php echo $row_rs1['pfin_anno']; ?></td>
            <td><?php echo dpexo($row_rs1['tipo']); ?></td>
            <td width="100" align="right"><?php echo $row_rs1['tot']; ?></td>
            <td width="110" align="right">
            <div class="spacer right" style="width:90px"><a href="../reportes/res_exo.php?pk=<?php echo $row_rs1['pfin_anno']; ?>" target="_blank">
		  		<div class="skin left" style="background-position:-0px -79px;margin-right:3px;"></div>Ver reporte</a></div>
            </td>
            </tr>
            <?php $vtota=$vtota+$row_rs1['tot']; ?>
           <?php } while ($row_rs1 = mysql_fetch_assoc($rs1)); ?>
            <tr>
            <td>&nbsp;</td>
            <td align="right">Total &raquo;</td>
            <td width="100" align="right"><?php echo $vtota; ?></td>
            <td>&nbsp;</td>
          </tr>
</table></td>
  </tr>
</table>
        <h4>Contribuyentes</h4>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="49%" valign="top"><h3>Contribuyentes  registrados</h3>
      <table width="90%" border="0" cellpadding="0" cellspacing="0" class="tabla">
          <tr>
            <td class="btit_1">Año</td>
            <td class="btit_1">Tipo</td>
            <td width="100" align="right" class="btit_1">Cantidad</td>
            </tr>
          <?php $vtota=0; ?>
          <?php do { ?>
          <tr>
            <td><?php echo $row_rs3['anno']; ?></td>
            <td><?php echo dtpers($row_rs3['tipo']); ?></td>
            <td width="100" align="right"><?php echo $row_rs3['tot']; ?></td>
            </tr>
            <?php $vtota=$vtota+$row_rs3['tot']; ?>
           <?php } while ($row_rs3 = mysql_fetch_assoc($rs3)); ?>
            <tr>
            <td>&nbsp;</td>
            <td align="right">Total &raquo;</td>
            <td width="100" align="right"><?php echo $vtota; ?></td>
            </tr>
</table>
    </td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="49%" valign="top"><h3>Contribuyentes asociados a los predios</h3>
      <table width="90%" border="0" cellpadding="0" cellspacing="0" class="tabla">
          <tr>
            <td class="btit_1">Año</td>
            <td width="100" align="right" class="btit_1">Cantidad</td>
            </tr>
           <?php $vtota=0; ?>
          <?php do { ?>
          <tr>
            <td><?php echo $row_rs4['anno']; ?></td>
            <td width="100" align="right"><?php echo $row_rs4['tot']; ?></td>
            </tr>
            <?php $vtota=$vtota+$row_rs4['tot']; ?>
           <?php } while ($row_rs4 = mysql_fetch_assoc($rs4)); ?>
            <tr>
              <td align="right">Total &raquo;</td>
            <td width="100" align="right"><?php echo $vtota; ?></td>
          </tr>
</table></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="49%" valign="top"><h3>Pagos registrados de los años</h3>
      <table width="90%" border="0" cellpadding="0" cellspacing="0" class="tabla">
          <tr>
            <td class="btit_1">Año</td>
            <td width="100" align="right" class="btit_1">Cantidad</td>
            <td width="110" align="right" class="btit_1">&nbsp;</td>
          </tr>
            <?php
				
			
$vtotales=array(); 
$vto2=array(); 
for($xa=2001;$xa<=date("Y");$xa++){ 		 
	$vtota=0;  
	mysql_data_seek($rs5, 0);
	$row_rs5 = mysql_fetch_assoc($rs5);
			do {
			$canno=explode(",",$row_rs5['annos']);
			
			if (in_array($xa, $canno)) {
				$vtotales[$xa]++;
				array_push($vto2,1);
				
				$vtota++;
			}
			  
			} while ($row_rs5 = mysql_fetch_assoc($rs5)); 
			?>
          <tr>
            <td>				
				<?php echo $xa; ?></td>
            <td width="100" align="right"><?php 
				if($vtotales[$xa]==""){
				echo 0;
				}else{
				echo $vtotales[$xa];
				}?></td>
            <td width="110" align="right">
            <?php if($vtotales[$xa]!=""){?>
            <div class="spacer right" style="width:90px"><a href="../reportes/res_pagos.php?pk=<?php echo $xa; ?>" target="_blank">
		  		<div class="skin left" style="background-position:-0px -79px;margin-right:3px;"></div>Ver reporte</a></div>
            <?php }?>
            </td>
          </tr>            
           <?php } ?>
           <?php $vtota=array_sum($vto2); ?>
            <tr>
              <td align="right">Total &raquo;</td>
              <td align="right"><?php echo $vtota; ?></td>
              <td width="110" align="right">&nbsp;</td>
            </tr>
</table>
    </td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="49%" valign="top">
    <h3>Monto recaudado por año</h3>
    <table width="90%" border="0" cellpadding="0" cellspacing="0" class="tabla">
          <tr>
            <td class="btit_1">Cantidad</td>
            <td class="btit_1">Año</td>
            <td width="100" align="right" class="btit_1">Monto</td>
            </tr>
           <?php $vtota=0; ?>
          <?php do { ?>
          <tr>
            <td><?php echo $row_rs6['cant']; ?></td>
            <td><?php echo $row_rs6['anno']; ?></td>
            <td width="100" align="right"><?php echo dvac($row_rs6['tot']); ?></td>
            </tr>
            <?php $vtota=$vtota+$row_rs6['tot']; ?>
           <?php } while ($row_rs6 = mysql_fetch_assoc($rs6)); ?>
            <tr>
            <td align="right">&nbsp;</td>
            <td align="right">Total &raquo;</td>
            <td width="100" align="right"><?php echo dvac($vtota); ?></td>
          </tr>
</table>
    </td>
  </tr>
</table>

</td>
    <td width="20" valign="top">&nbsp;</td>
    <td width="250" valign="top"><h2>Opciones</h2>
        <div class="btit_2">Acciones</div>
        <div class="bcont">
        <div class="spacer"><a href="#" onClick="location.reload();">
        <div class="skin left" style="background-position:-80px -63px;margin-right:3px;"></div>Refrescar p&aacute;gina</a></div>
        
        <div class="spacer"><a href="../reportes/resumen.php" target="_blank">
		  <div class="skin left" style="background-position:-0px -79px;margin-right:3px;"></div>
		  Preparar para impresión</a></div>
        
        <div class="spacer"><a href="../reportes/res_contrib.php" target="_blank">
		  <div class="skin left" style="background-position:-0px -79px;margin-right:3px;"></div>Reporte de contribuyentes</a></div>
          
          <div class="spacer"><a href="../reportes/res_letras.php" target="_blank">
		  <div class="skin left" style="background-position:-0px -79px;margin-right:3px;"></div>
		  Contribuyentes por letras</a></div>
        
        </div>
        <div class="bcont2"></div>
        </td>
  </tr>
</table>
</div></div></div>

</body>
</html>
<?php
mysql_free_result($rs1);

mysql_free_result($rs2);

mysql_free_result($rs3);

mysql_free_result($rs4);

mysql_free_result($rs5);

mysql_free_result($rs6);
?>
