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
$vra1=$_GET['of'];//oficina
$vra2=$_GET['val'];//tipo doc

mysql_select_db($database_cn1, $cn1);
$query_rs1 = "SELECT * FROM folioint WHERE YEAR(fecha)=YEAR(NOW()) AND c_oficina = $vra1 AND td_tipos_id=$vra2 ORDER BY fecha ASC";
$rs1 = mysql_query($query_rs1, $cn1) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
$totalRows_rs1 = mysql_num_rows($rs1);
?>
<?php require_once('../includes/functions.php'); ?>
<?php require_once('../includes/permisos_all_ui.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/int.css" rel="Stylesheet" type="text/css" />
<style>
#wpag{background:transparent url(../images/pico_5.jpg) no-repeat fixed bottom right;}
</style>
</head>
<body>
<?php 
$ccont=0;
$vagr=array(); 
?>

<?php 
$vagr[$row_rs1['val']]=$row_rs1['val'];
$ccont++; 
?>
<div class="clear"></div>
<h3>DocumnenExpedientes disponibles - <?php echo dftipo2($vra2);?></h3>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabla2">
  <tr>
    <td width="50" align="center" class="btit_1">Número</td>
    <td width="200" class="btit_1">Cabecera</td>
    <td class="btit_1">Asunto</td>
    <td width="60" align="center" class="btit_1">Adjunto</td>
  </tr>
  <?php $ccont=0; ?>
  <?php do{ ?>
  <?php $ccont++; ?>
  <?php if ($totalRows_rs1 > 0) { // Show if recordset not empty ?>
    <tr>
      <td width="50" align="center"><div class="vactive left" style="margin:0;"><?php echo $ccont;?></div></td>
      <td width="200"><a href="#"><?php echo $row_rs1['cabecera']; ?></a><br /><span class="min">Fecha: <?php echo dptiemp($row_rs1['fecha']); ?></span></td>
      <td><strong><?php echo $row_rs1['firma']; ?></strong><br>
          <?php echo $row_rs1['asunto']; ?></td>
      <td width="60" align="center">
      <?php if($row_rs1['file']!=""){?>
      <a href="../data/tdin_adjuntos/<?php echo $row_rs1['file'];?>" target="_blank" title="Descargar el archivo adjunto"><img src="../images/<?php echo dtarchivo($row_rs1['ext']);?>" style="border:none;" /></a>
      <?php }else{ ?>No<?php } ?>
      </td>
    </tr>
    <?php } // Show if recordset not empty ?>

  <?php } while ($row_rs1 = mysql_fetch_assoc($rs1)); ?>
</table>
<div class="clear"></div>

</body>
</html>
<?php
mysql_free_result($rs1);
?>
