<?php
/*
funciones de uso comun
*/

// tamaño de archivo
function dinfo($var){
	$dev = '/';
	//$dev = '/home';
	$freespace = disk_free_space($dev);  
	$totalspace = disk_total_space($dev);
	$freespace_mb = $freespace/1024/1024;  
	$totalspace_mb = $totalspace/1024/1024;  
	$total_used = $totalspace_mb-$freespace_mb;
	$freespace_percent = ($freespace/$totalspace)*100;  
	$used_percent = (1-($freespace/$totalspace))*100;  
	switch($var){
		case 1:return number_format($totalspace_mb,0,".",",")." MB"."<br />".
		number_format($totalspace_mb/1024,0,".",",")." GB";break;
		case 2:return number_format($total_used,0,".",",")." MB"."<br />".
		number_format($total_used/1024,0,".",",")." GB";break;
		case 3:return number_format($freespace_mb,0,".",",")." MB"."<br />".
		number_format($freespace_mb/1024,0,".",",")." GB";break;
		case 4:return round($used_percent,2)."%";break;
		case 5:return round(100-$used_percent,2)."%";break;
	}
}

?>