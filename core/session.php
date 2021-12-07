<?php
/*
crear y leer variables de sesion
*/
function ccok($var1,$var2){
	$_SESSION[$var1]=$var2;
}
function lcok($var1){
	return $_SESSION[$var1];
}
?>