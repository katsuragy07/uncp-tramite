<?php require_once('Connections/cn1.php'); ?>
<?php require_once('includes/functions.php'); ?>
<?php include("includes/permisos_all.php"); ?>
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
$insertSQL = sprintf("INSERT INTO log (id, fecha, accion, ip, nav_id, navegador, hostip, users_id, users_empleado_id) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
GetSQLValueString("", "int"),
GetSQLValueString(date("Y-m-d H:i:s"), "date"),
GetSQLValueString("0", "text"),
GetSQLValueString($_SERVER['REMOTE_ADDR'], "text"),
GetSQLValueString(ObtenerNavegador($_SERVER['HTTP_USER_AGENT']), "text"),
GetSQLValueString($_SERVER['HTTP_USER_AGENT'], "text"),
GetSQLValueString(gethostbyaddr($_SERVER['REMOTE_ADDR']), "text"),
GetSQLValueString($_SESSION['u_id'], "text"),
GetSQLValueString($_SESSION['u_empid'], "text"));

mysql_select_db($database_cn1, $cn1);
$Result1 = mysql_query($insertSQL, $cn1) or die(mysql_error());
?>
<?php
// *** Logout the current user.
$logoutGoTo = "index.php";
$caid = session_id();
if(empty($caid)){
	session_name("_tambosid");
	session_start();
}
$_SESSION['MM_Username'] = NULL;
$_SESSION['MM_UserGroup'] = NULL;
unset($_SESSION['MM_Username']);
unset($_SESSION['MM_UserGroup']);
if ($logoutGoTo != "") {header("Location: $logoutGoTo");
exit;
}
?>
