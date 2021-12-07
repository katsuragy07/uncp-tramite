<?php require_once('Connections/cn1.php'); ?>
<?php require_once('includes/functions.php'); ?>
<?php include("includes/permisos_all.php"); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

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
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
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

$colname_rs = "-1";

if (isset($_SESSION['MM_Username'])) {
  $colname_rs = $_SESSION['MM_Username'];
}

mysql_select_db($database_cn1, $cn1);
$query_rs = sprintf("SELECT * FROM `users` WHERE nombre = %s", GetSQLValueString($colname_rs, "text"));
$rs = mysql_query($query_rs, $cn1) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);
$totalRows_rs = mysql_num_rows($rs);

$colname_rs1 = "-1";
if (isset($row_rs['empleado_id'])) {
  $colname_rs1 = $row_rs['empleado_id'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs1 = sprintf("SELECT * FROM empleado WHERE id = %s", GetSQLValueString($colname_rs1, "int"));
$rs1 = mysql_query($query_rs1, $cn1) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
$totalRows_rs1 = mysql_num_rows($rs1);

$colname_rs2 = "-1";
if (isset($row_rs1['oficinas_id'])) {
  $colname_rs2 = $row_rs1['oficinas_id'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs2 = sprintf("SELECT * FROM oficinas WHERE id = %s", GetSQLValueString($colname_rs2, "int"));
$rs2 = mysql_query($query_rs2, $cn1) or die(mysql_error());
$row_rs2 = mysql_fetch_assoc($rs2);
$totalRows_rs2 = mysql_num_rows($rs2);
?>
<?php
$_SESSION['u_level']=$row_rs['level'];
$_SESSION['u_nombre']=$row_rs1['apellido'].", ".$row_rs1['nombre'];
$_SESSION['u_id']=$row_rs['id'];
$_SESSION['u_perf']=$row_rs['perfil_id'];
$_SESSION['u_empid']=$row_rs1['id'];
$_SESSION['u_sis']=$row_rs['snom'];
$_SESSION['u_ofice']=$row_rs1['oficinas_id'];
$_SESSION['u_nofice']=$row_rs2['nombre'];
$_SESSION['u_foto']=$row_rs1['foto'];
$_SESSION['sdate']=date("h:i:s A");
?>
<?php

$insertSQL = sprintf("INSERT INTO log (id, fecha, accion, ip, nav_id, navegador, hostip, users_id, users_empleado_id) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
GetSQLValueString("", "int"),
GetSQLValueString(date("Y-m-d H:i:s"), "date"),
GetSQLValueString("1", "text"),
GetSQLValueString($_SERVER['REMOTE_ADDR'], "text"),
GetSQLValueString(ObtenerNavegador($_SERVER['HTTP_USER_AGENT']), "text"),
GetSQLValueString($_SERVER['HTTP_USER_AGENT'], "text"),
GetSQLValueString(gethostbyaddr($_SERVER['REMOTE_ADDR']), "text"),
GetSQLValueString($_SESSION['u_id'], "text"),
GetSQLValueString($_SESSION['u_empid'], "text"));


mysql_select_db($database_cn1, $cn1);
$Result1 = mysql_query($insertSQL, $cn1) or die(mysql_error());

$rdir= "ui/";

/*
if($_SESSION['u_sis']==2){
	$rdir= "intranet/";
}
*/


if ($Result1) {
	header("Location: ".$rdir);
}else{
	header("Location: error.php");
}

?>


<?php
mysql_free_result($rs);

mysql_free_result($rs1);
?>
