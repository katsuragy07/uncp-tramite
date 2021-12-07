<?php
$uploaddir = '../data/'.$_GET['ub'].'/'; 
$partes_ruta = pathinfo(basename($_FILES['uploadfile']['name']));

$file = $uploaddir.$_GET['nm'].".".strtolower($partes_ruta['extension']); 

function bytesConvert($bytes){
    $ext = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $unitCount = 0;
    for(; $bytes > 1024; $unitCount++) $bytes /= 1024;
    return round($bytes,1) ." ". $ext[$unitCount];
}
 
if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) { 
  //echo "success"; 
  echo bytesConvert($_FILES["uploadfile"]["size"]);
}else{
	echo "error";
}
?>