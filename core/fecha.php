<?php
// parse una fecha yyyy/mm/dd hh:mm:ss en formato UNIX
function dev_crtdatetime($str){
	if($str!=""){
		list($date, $time) = explode(' ', $str);
		list($year, $month, $day) = explode('-', $date);
		list($hour, $minute, $second) = explode(':', $time);
		$timestamp = mktime($hour, $minute, $second, $month, $day, $year);
		return $timestamp;
	}
}
//devuelve el nombre del dia en español
function dev_dia($da1){
	switch($da1){
	case 1: return "Lunes";break;
	case 2: return "Martes";break;
	case 3: return "Miercoles";break;
	case 4: return "Jueves";break;
	case 5: return "Viernes";break;
	case 6: return "Sabado";break;
	case 7: return "Domingo";break;
	};
}
//devuelve el nombre del mes en español
function dev_mes($vdi){
	switch($vdi){
	case 1: return "Enero";break;
	case 2: return "Febrero";break;
	case 3: return "Marzo";break;
	case 4: return "Abril";break;
	case 5: return "Mayo";break;
	case 6: return "Junio";break;
	case 7: return "Julio";break;
	case 8: return "Agosto";break;
	case 9: return "Septiembre";break;
	case 10: return "Octubre";break;
	case 11: return "Noviembre";break;
	case 12: return "Diciembre";break;
	};
}
//devuelve una fecha en formato: 15 de enero, 2011
function dev_fecha_esp($da1){
	if($da1!=""){
		$var1=dev_crtdatetime($da1." 00:00:00");
		return dev_dia(date("N",$var1))." ".date("j",$var1)." de ".dev_mes(date("n",$var1)).", ".date("Y",$var1);
	}else{
		return "-.-";
	}
}
//devuelve una fecha en formato: dd/mm/yyyy
function dev_fecha_cal($var1){
	if($var1!=""){
		$da1=dev_crtdatetime($var1." 00:00:00");
		return date("d/m/Y",$da1);
	}else{
		return "";
	}
}
//devuelve fecha con formato: hoy, ayer y fecha
function dev_fecha_hum($var1){
	if($var1!=""){
		$var=date("Y-m-d H:i:s");
		$vars=date("Y-m-d",dev_crtdatetime($var1))." 00:00:00";
		$da1=dev_crtdatetime($var1);
		$da1b=dev_crtdatetime($vars);
		$da2=dev_crtdatetime($var);
		if($da2-$da1b>=0){
		if($da2-$da1b<=86400){
			return "<strong>Hoy</strong>, a las ".date("h:iA",$da1)." y ".date("s",$da1)."s";
		}else{
			if($da2-$da1b<=172800){
				return "Ayer, a las ".date("h:iA",$da1);
			}else{
				return date("d/m/Y h:iA",$da1);
			}
		}
		}else{
			return date("d/m/Y h:iA",$da1);
		}
	}else{
		return "";
	}
}
?>