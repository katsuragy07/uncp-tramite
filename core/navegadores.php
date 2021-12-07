<?php
/*
comprobar el tipo de navegador
*/

// si es explorer
function dev_explorerdesf($var1){
	$var1=dev_navegador($var1);
	switch ($var1){
		case"Explorer4": return true;break;
		case"Explorer5": return true;break;
		case"Explorer6": return true;break;
		case"Explorer7": return true;break;
		default:return false;
	}
}
function dev_phone($var1){
	$var1=dev_navegador($var1);
	switch ($var1){
		case "iPad": return false;break;
		case "iPhone": return false;break;
		case "Android": return false;break;
		case "Googlebot": return false;break;
		case "msnbot": return false;break;
		default:return true;
	}
}
function dev_navegador($user_agent){
     $navegadores = array(
          'Opera' => '/Opera/i',
		  'iPad'=>'/iPad/i',
		  'iPhone'=>'/iPhone/i',
		  'Android Nexus'=>'/Nexus/i',
		  'Android'=>'/Android/i',		  
		  'Googlebot'=>'/Googlebot/i',
		  'msnbot'=>'/msnbot/i',
          'Firefox'=> '/Firefox/i',
          'Galeon' => '/Galeon/i',
          'Mozilla'=>'/Gecko/i',
          'MyIE'=>'/MyIE/i',
          'Lynx' => '/Lynx/i',
		  'Netscape' => '/Netscape/i',
          'Konqueror'=>'/Konqueror/i',		  
		  'Explorer 9' => '/MSIE 9/i',
		  'Explorer 8' => '/MSIE 8/i',
          'Explorer 7' => '/MSIE 7/i',
          'Explorer 6' => '/MSIE 6/i',
          'Explorer 5' => '/MSIE 5/i',
          'Explorer 4' => '/MSIE 4/i',
	);
	foreach($navegadores as $navegador=>$pattern){
		if(preg_match($pattern, $user_agent)){
			return $navegador;
		}
    }
return 'Desconocido';  
}
?>