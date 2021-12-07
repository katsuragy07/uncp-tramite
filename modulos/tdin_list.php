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
$query_rs1 = "SELECT exp AS val FROM folioint WHERE YEAR(fecha)=YEAR(NOW()) AND c_oficina = $vra1 AND td_tipos_id=$vra2";
$rs1 = mysql_query($query_rs1, $cn1) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
$totalRows_rs1 = mysql_num_rows($rs1);
?>
<?php require_once('../includes/functions.php'); ?>
<?php require_once('../includes/permisos_all_ui.php'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
<?php do{ ?>
<?php 
$vagr[$row_rs1['val']]=$row_rs1['val'];
$ccont++; 
?>
<?php } while ($row_rs1 = mysql_fetch_assoc($rs1)); ?>

<div class="clear"></div>
<?php for($xa=1;$xa<max($vagr)+31;$xa++){?>
	<?php if($vagr[$xa]==$xa){?>
   <div class="vinactive left"><?php echo $xa;?></div>
   <?php }else{?>
   <a href="../modulos/tdin_nuevofol.php?tip=<?php echo $vra2;?>&num=<?php echo $xa;?>"><div class="vactive left"><?php echo $xa;?></div></a>
   <?php }?>
<?php }?>
<div class="clear"></div>

</body>
</html>
<?php
mysql_free_result($rs1);
?>
