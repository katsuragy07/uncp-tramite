<?php require_once('../Connections/cn1.php'); ?>
<?php require_once('../includes/functions.php'); ?>
<?php require_once('../includes/permisos_all_ui.php'); ?>
<?php
$show_comments_per_page = 2;
$logged_id = $_SESSION['u_empid'];


?>
<?php
if(checkValues(@$_REQUEST['value']))
{
$userid = $_SESSION['u_id'];
$empid = $_SESSION['u_empid'];

$posted_on = $_REQUEST['p'];
$post = checkValues($_REQUEST['value']);

$uip = $_SERVER['REMOTE_ADDR'];
//INSERT INTO `ur_posts_comments` (`id`, `userid`, `empid`, `comments`, `fecha`, `uip`, `post_id`)

$cn2 = mysql_pconnect($hostname_cn1, $username_cn1, $password_cn1) or trigger_error(mysql_error(),E_USER_ERROR); 
$insertSQLlog = sprintf("INSERT INTO ur_posts_comments (`id`, `userid`, `empid`, `comments`, `fecha`, `uip`, `post_id`) VALUES (%s, %s, %s, %s, %s, %s, %s)",
	GetSQLValueString("", "int"),
	GetSQLValueString($userid, "text"),				//userid
	GetSQLValueString($empid, "text"),
	GetSQLValueString(utf8_urldecode($post), "text"),
	GetSQLValueString(date("Y-m-d H:i:s"), "date"),
	GetSQLValueString($uip, "text"), 				//uip
	GetSQLValueString($posted_on, "text"));
	mysql_select_db($database_cn1, $cn2);
	
	$Result2 = mysql_query($insertSQLlog, $cn2) or die(mysql_error());

echo 1;

}
?>
