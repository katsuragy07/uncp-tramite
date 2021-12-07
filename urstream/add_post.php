<?php require_once('../Connections/cn1.php'); ?>
<?php require_once('../includes/functions.php'); ?>
<?php require_once('../includes/permisos_all_ui.php'); ?>
<?php
$show_comments_per_page = 2;
$user_id = $_SESSION['u_empid']; // it should be dynamic with current logged in ID
$logged_id = $_SESSION['u_empid'];


$memberPic = getUserImg($logged_id);
$logged_user_pic = $_SESSION['u_foto'];
?>
<?php
if(checkValues(@$_REQUEST['value']))
{
$userid = $_SESSION['u_id'];
$empid = $_SESSION['u_empid'];

$posted_on = $_REQUEST['p'];
$tema = $_REQUEST['te'];

$ima_file = checkValues($_REQUEST['file']);
$ima_ext = $_REQUEST['ext'];
$ima_size = $_REQUEST['size'];
/*
echo $ima_ext."<br>";
echo $ima_size."<br>";
*/
$post = checkValues($_REQUEST['value']);

$uip = $_SERVER['REMOTE_ADDR'];

$cn2 = mysql_pconnect($hostname_cn1, $username_cn1, $password_cn1) or trigger_error(mysql_error(),E_USER_ERROR); 
$insertSQLlog = sprintf("INSERT INTO ur_posts (id, `post`, `fecha`, `userid`, `empid`, `uip`, ur_tema_id, `file`, `para`, `size`, `ext`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
	GetSQLValueString("", "int"),
	GetSQLValueString(utf8_urldecode($post), "text"),
	GetSQLValueString(date("Y-m-d H:i:s"), "date"),
	GetSQLValueString($userid, "text"),				//userid
	GetSQLValueString($empid, "text"),
	GetSQLValueString($uip, "text"), 				//uip
	GetSQLValueString($tema, "text"), 				//ur_tema_id
	GetSQLValueString($ima_file, "text"),
	GetSQLValueString("0", "text"),
	GetSQLValueString($ima_size, "text"),
	GetSQLValueString($ima_ext, "text"));
	mysql_select_db($database_cn1, $cn2);
	$Result2 = mysql_query($insertSQLlog, $cn2) or die(mysql_error());

echo 1;

}
?>
