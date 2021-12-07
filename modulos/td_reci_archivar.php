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
?>
<?php
$colname_rs = "-1";
if (isset($_SESSION['pk'])) {
  $colname_rs = $_SESSION['pk'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs = sprintf("SELECT * FROM folio WHERE id = %s", GetSQLValueString($colname_rs, "int"));
$rs = mysql_query($query_rs, $cn1) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);
$totalRows_rs = mysql_num_rows($rs);
?>
<?php

$insertSQL = sprintf("INSERT INTO log_folio (id, folio_id, oficinas_id, ope, forma, fecha, user, empid, d_oficina, c_oficina) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
GetSQLValueString("", "int"),
GetSQLValueString($_GET['pk'], "int"),//folio_id
GetSQLValueString($_SESSION['u_ofice'], "int"),
GetSQLValueString(1, "int"),//ope
GetSQLValueString(0, "int"),//forma
GetSQLValueString(date("Y-m-d H:i:s"), "date"),
GetSQLValueString($_SESSION['u_id'], "text"),
GetSQLValueString($_SESSION['u_empid'], "text"),
GetSQLValueString($_SESSION['u_ofice'], "text"),
GetSQLValueString($_SESSION['u_ofice'], "text"));

mysql_select_db($database_cn1, $cn1);
$Result1 = mysql_query($insertSQL, $cn1) or die(mysql_error());


if ($Result1) {
	header("Location: "."../modulos/td_farchivar.php?pk=".$_GET['pk']);
}else{
	header("Location: ../error.php");
}
?>
<?php
mysql_free_result($rs);
?>