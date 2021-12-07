<?php
/*
funciones de uso comun
*/

// crear id unico
function dev_uid(){
	return md5(uniqid(rand(), true));
}
// tipo de sexo
function dev_sexo($var){
	switch ($var){
		case "1":return "Masculino";break;
		case "0":return "Femenino";break;
		default:return "-.-";break;
	}
}
// estado conyugal
// vs1 valor
// vs1 sexo
function dev_conyugal($vs1,$vs2){
	if($vs1==0){
		$vts="a";
	}else{
		$vts="o";
	};
	switch($vs2){
	case 0: return "Solter".$vts;break;
	case 1: return "Casad".$vts;break;
	case 2: return "Divorciad".$vts;break;
	case 3: return "Viud".$vts;break;	
	};
}
// devolver blanco
function dev_blanco($var){
	if($var==""){
		return "-.-";
	}else{
		return $var;
	}
}
// devolver si / no
function dev_sino($var){
	if($var==1){
		return "Si";
	}else{
		return "No";
	}
}
function dev_sinoc($var){
	if($var==1){
		return "<span class=\"bsi\">Si</span>";
	}else{
		return "<span class=\"bno\">No</span>";
	}
}

?>