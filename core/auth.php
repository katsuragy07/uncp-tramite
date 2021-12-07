<?php
/*
crear sesion
*/
function dev_sesion(){
	$caid = session_id();
	if(empty($caid)){
		session_name("_mksid");
		session_start();
	}
}

?>