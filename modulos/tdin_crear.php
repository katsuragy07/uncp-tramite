<?php require_once('../Connections/cn2.php'); ?>
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
?>
<?php
$cn2 = mysql_pconnect($hostname_cn1, $username_cn1, $password_cn1) or trigger_error(mysql_error(),E_USER_ERROR); 
$colname_rs = "-1";
if (isset($_SESSION['pk'])) {
  $colname_rs = $_SESSION['pk'];
}
mysql_select_db($database_cn2, $cn2);
$query_rs = sprintf("SELECT * FROM folioint WHERE id = %s", GetSQLValueString($colname_rs, "int"));
$rs = mysql_query($query_rs, $cn2) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);
$totalRows_rs = mysql_num_rows($rs);
?>
<?php

$insertSQL = sprintf("INSERT INTO log_folioint (id, folioint_id, oficinas_id, ope, forma, fecha, user, empid, d_oficina, c_oficina) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
GetSQLValueString("", "int"),
GetSQLValueString($_GET['pk'], "int"),//folioint_id
GetSQLValueString($_SESSION['u_ofice'], "int"),
GetSQLValueString(0, "int"),//ope
GetSQLValueString(0, "int"),//forma
GetSQLValueString(date("Y-m-d H:i:s"), "date"),
GetSQLValueString($_SESSION['u_id'], "text"),
GetSQLValueString($_SESSION['u_empid'], "text"),
GetSQLValueString($_SESSION['u_ofice'], "text"),
GetSQLValueString($_SESSION['u_ofice'], "text"));

mysql_select_db($database_cn2, $cn2);
$Result1 = mysql_query($insertSQL, $cn2) or die(mysql_error());


if ($Result1) {
	header("Location: "."../modulos/tdin_recibidos.php");
}else{
	header("Location: ../error.php");
}
?>
<?php
mysql_free_result($rs);
?>