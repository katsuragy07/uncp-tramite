<?php
/*
funciones para codificar o decodificar URL
*/

// crear id unico
function dev_sinesp($da1){
	$busca=array("ב","י","ם","ף","ת","ס","ֱ","ֹ","ֽ","׃","Ú","ׁ","  ");
	$repla=array("a","e","i","o","u","n","a","e","i","o","u","n"," ");
	$da1=str_replace($busca,$repla,utf8_decode($da1));
	$da1=strtolower($da1);
	//$da2=ereg_replace("[^a-z0-9_]", "",$da1);
	$da2=$da1;
	if(substr($da2,-1,1)=="_") $da2=substr($da2,0,-1);
	$da2=str_replace("__","_",$da2);
	return $da2;
}
function dev_string2url($cadena) {
	$cadena = trim($cadena);
	$cadena = strtr($cadena,
	"ְֱֲֳִֵאבגדהוׂ׃װױײ״עףפץצרָֹÊֻטיךכַחּֽ־ֿלםמןÙÚÛÜשתû üÿׁס",
	"aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuu uynn");
	$cadena = strtr($cadena,"ABCDEFGHIJKLMNOPQRSTUVWXYZ","abcdef ghijklmnopqrstuvwxyz");
	$cadena = preg_replace('#([^.a-z0-9]+)#i', '-', $cadena);
	$cadena = preg_replace('#-{2,}#','-',$cadena);
	$cadena = preg_replace('#-$#','',$cadena);
	$cadena = preg_replace('#^-#','',$cadena);
	return $cadena;
} 
?>