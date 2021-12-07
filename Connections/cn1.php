<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_cn1 = "localhost";
$database_cn1 = "uncp_tramite";
$username_cn1 = "root";
$password_cn1 = "ae9a56ed87";
$cn1 = mysql_pconnect($hostname_cn1, $username_cn1, $password_cn1); 
mysql_select_db($database_cn1,$cn1);

?>