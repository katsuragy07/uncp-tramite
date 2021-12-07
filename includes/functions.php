<?php
ini_set( "display_errors", 0);


function dscomi($var1){
	return str_replace("\"","&quot;",$var1);
}
function ddcont($var1,$var2,$var3){
	if($var1==0){
		return $var2." (Nat.)";
	}else{
		return $var3." (Jur.)";
	}
}


function dlink($da1){
	$busca=array("á","é","í","ó","ú","ñ"," ","Á","É","Í","Ó","Ú","Ñ");
	$repla=array("a","e","i","o","u","n","_","a","e","i","o","u","n");
	$da1=str_replace($busca,$repla,$da1);
	$da1=strtolower($da1);
	$da2=ereg_replace("[^a-z0-9_]", "",$da1);
	if(substr($da2,-1,1)=="_") $da2=substr($da2,0,-1);
	$da2=str_replace("__","_",$da2);
	return date("Ymds")."_".$da2;
}


function destadoFS($var){
	switch ($var)
	{
		case "Completado": echo '<div class="amsj amsj1">'.$var.'</div>'; break;
		case "Pendiente": echo '<div class="amsj amsj2">'.$var.'</div>'; break;
		case "Anulado": echo '<div class="amsj amsj3">'.$var.'</div>'; break;
		default: echo '<div class="amsj amsj0">'.$var.'</div>'; break;
	}
}


function dfecha5($da1){
	$da1=substr($da1,0,10);
	$var1=crt_datetime($da1." 00:00:00");
	return date("j",$var1)."/".strtoupper(substr(dmes(date("n",$var1)),0,3))."/".date("Y",$var1);
}

function dlanno($var1){
	if($var1==""){
		return "anno=".date("Y")."&";
	}else{
		return "anno=".$var1."&";
	}
}
function extension_archivo($ruta) {
    $res = explode(".", $ruta);
    $extension = $res[count($res)-1];
    return $extension ;
}
function isblanc($var){
	if($var==""){
		return "default.jpg";
	}else{
		return $var;
	}
}
function dtarchivo($var1){
	switch ($var1){
		case "avi":return "ico_avi.png";break;
		case "doc":return "ico_doc.png";break;
		case "docx":return "ico_docx.png";break;
		case "dwg":return "ico_dwg.png";break;
		case "exe":return "ico_exe.png";break;
		case "mp3":return "ico_mp3.png";break;
		case "mpg":return "ico_mpg.png";break;
		case "pdf":return "ico_pdf.png";break;
		case "ppt":return "ico_ppt.png";break;
		case "pptx":return "ico_pptx.png";break;
		case "pub":return "ico_pub.png";break;
		case "rar":return "ico_rar.png";break;
		case "rtf":return "ico_rtf.png";break;
		case "wav":return "ico_wav.png";break;
		case "wma":return "ico_wma.png";break;
		case "wmv":return "ico_wmv.png";break;
		case "xls":return "ico_xls.png";break;
		case "xlsx":return "ico_xlsx.png";break;
		case "zip":return "ico_zip.png";break;
		case "rar":return "ico_rar.png";break;
		case "jpg":return "ico_img.png";break;
		case "jepg":return "ico_img.png";break;
		case "bmp":return "ico_img.png";break;
		case "gif":return "ico_img.png";break;
		case "png":return "ico_img.png";break;
		default:return "ico_no.png";break;
	}
}
function ddcont2($var1,$var2,$var3){
	if($var1==0){
		return "DNI: ".$var2;
	}else{
		return "RUC: ".$var3;
	}
}
function dfechv($var1,$var2){
$vtemp=crt_datetime($var1);
$thoy=crt_datetime(date("Y-m-d H:i:s"));
$difer=$thoy-$vtemp;
$tdias1=7-intval($difer/86400);
$tdias2=8-intval($difer/86400);
$txven="<span style=\"color:#FF5538\"><strong>Vencido</strong></span>";
if($var2!=26){
	if($tdias1>0) {
	return "<span style=\"color:#4F8A1E\"><strong>".$tdias1." dias</strong></span>";
	}else{
	return $txven;
	}
}else{
	if($tdias1>0) {
	return "<span style=\"color:#4F8A1E\"><strong>".$tdias2." dias</strong></span>";;
	}else{
	return $txven;
	}
}
}

function strtoupper_utf8($string){
    $string=utf8_decode($string);
    $string=strtoupper($string);
    $string=utf8_encode($string);
    return $string;
}
function ccok($var1,$var2){
	$_SESSION[$var1]=$var2;
}
function lcok($var1){
	return $_SESSION[$var1];
}
function dribbut($var1,$var2){
	if($var1==0){
		return true;
	}else{
		switch ($var2){
			case 3:return true;break;
			case 4:return false;break;
		}
	}
}
function dtpers($var){
	switch ($var){
		case 0:return "Persona Natural";break;
		case 1:return "Persona Jur&iacute;dica";break;
	}
}
function dtnivel($var){
	switch ($var){
		case 1:return "Piso";break;
		case 2:return "Azotea";break;
		case 3:return "S&oacute;tano";break;
	}
}
function dclase($var){
	switch ($var){
		case 1:return "A";break;
		case 2:return "B";break;
		case 3:return "C";break;
		case 4:return "D";break;
		case 5:return "E";break;
		case 6:return "F";break;
		case 7:return "G";break;
		case 8:return "H";break;
		case 9:return "I";break;
	}
}
function dcnpro($var1,$var2,$var3){
$sres="";$sres2="";
	switch($var1){
	case 1:$sres="Propietario &Uacute;nico";break;
	case 2:$sres="Sucesi&oacute;n Indivisa";break;
	case 3:$sres="Poseedor o Tenedor";break;
	case 4:$sres="Sociedad Conyugal";break;
	case 5:$sres="Condominio";$sres2="<br /><span class='min'>Cantidad: ".$var3."</span>";break;
	case 6:$sres=$var2;break;
	}
	return $sres.$sres2;
}
function dcnpro2($var1){
$sres="";
	switch($var1){
	case 1:$sres="Propietario &Uacute;nico";break;
	case 2:$sres="Sucesi&oacute;n Indivisa";break;
	case 3:$sres="Poseedor o Tenedor";break;
	case 4:$sres="Sociedad Conyugal";break;
	case 5:$sres="Condominio";break;
	case 6:$sres="Otro Tipo";break;
	}
	return $sres;
}

function dtant($var){
	if($var<51){
		return "Hasta ".$var." a&ntilde;os";
	}else{
		return "M&aacute;s de 50 a&ntilde;os";
	}
}
function dpre1($var){
	switch($var){	
	case 1:return "Casa &oacute; Habitaci&oacute;n";break;
	case 2:return "Tienda Dep&oacute;sito o Almac&eacute;n";break;
	case 3:return "Edificio &oacute; Predio en Edificio";break;
	case 4:return "Oficina, Hospital, Cine, Industria, Taller, etc";break;
	}
}
function dpre2($var){
	switch($var){	
	case 1:return "Concreto";break;
	case 2:return "Ladrillo";break;
	case 3:return "Adobe (Quincha o madera)";break;
	}
}
function dpre3($var){
	switch($var){	
	case 1:return "Muy Bueno";break;
	case 2:return "Bueno";break;
	case 3:return "Regular";break;
	case 4:return "Malo";break;
	case 4:return "Muy Malo";break;
	}
}
function dpre4($var){
	switch($var){	
	case 1:return "Hasta el 4to Piso";break;
	case 2:return "A partir del 5to Piso";break;
	}
}
function did(){
	return md5(uniqid(rand(), true));
}
function dftipo($var1,$var2="otro"){

	include('../Connections/cn1.php');	
	mysql_select_db($database_cn1, $cn1);
	$query_rp1 = "SELECT nombre FROM td_tipos WHERE id='$var1' LIMIT 1";
	$rp1 = mysql_query($query_rp1, $cn1) or die(mysql_error());
	$row_rp1 = mysql_fetch_assoc($rp1);
	$totalRows_rp1 = mysql_num_rows($rp1);
	if($row_rp1['nombre']==NULL){
		return "Documento desconocido";
	}else{
		return $row_rp1['nombre'];
	}
	mysql_free_result($rp1);

}

function dftipo2($var1){
	include('../Connections/cn1.php');	
	mysql_select_db($database_cn1, $cn1);
	$query_rp1 = "SELECT nombre FROM td_tipos WHERE id='$var1' LIMIT 1";
	$rp1 = mysql_query($query_rp1, $cn1) or die(mysql_error());
	$row_rp1 = mysql_fetch_assoc($rp1);
	$totalRows_rp1 = mysql_num_rows($rp1);
	if($row_rp1['nombre']==NULL){
		return "Documento desconocido";
	}else{
		return $row_rp1['nombre'];
	}
	mysql_free_result($rp1);
}


function dsigla($var1){
	if($var1==""){
		return "(Siglas)";
	}else{
		return $var1;
	}
}

function dopes($var){
	switch($var){		
	case 0:return "<span style=\"color:#333\">Creado</span>";break;
	case 1:return "<span style=\"color:#4F8A1E\">Recibido</span>";break;
	case 2:return "<span style=\"color:#0099CC\">Deribado</span>";break;
	case 3:return "<span style=\"color:#FF9751\"><strong>Archivado</strong></span>";break;
	default:return "Espera";break;
	}
}
function dfolc($var){
	if($var==3) return " class=\"trcols\" ";
}

function dforma($var){
	switch($var){
	case 1:return "Copia";break;
	default:return "Original";break;
	}
}
function destado($var){
	switch($var){
	case 1:return "1.- Terreno sin construir";break;
	case 2:return "2.- En construcci&oacute;n";break;
	case 3:return "3.- Terminado";break;
	case 4:return "4.- En ruinas";break;
	}
}
function dptipo($var,$var2){
	switch($var){
	case 1:return "1.- Predio Independiente";break;
	case 2:return "2.- Departamento u Oficina en Edificio";break;
	case 3:return "3.- Predio en Quinta";break;
	case 4:return "4.- Cuarto en Casa de vecindad (Callej&oacute;n, Solar o Corral&oacute;n)";break;
	case 5:return "5.- ".$var2;break;
	}
}
function dpexo($var){
	switch($var){
	case 1:return "Inafecto";break;
	case 2:return "Exonerado Parcialmente";break;
	case 3:return "Exonerado Totalmente";break;
	case NULL:return "No";break;
	}
}
function porcentaje($cantidad,$porciento,$decimales){
	return number_format($cantidad*$porciento/100 ,$decimales);
}
function dpuso($var,$var2){
	switch($var){
	case 1:return "1.- Casa Habitaci&oacute;n";break;
	case 2:return "2.- Comercio";break;
	case 3:return "3.- Industria";break;
	case 4:return "4.- Servicio en General";break;
	case 5:return "5.- Educacional";break;
	case 6:return "6.- Gobierno Central, Instituci&oacute;n P&uacute;blica Desentralizada, Gobierno Local o Regional";break;
	case 7:return "7.- Gobierno Extranjero";break;
	case 8:return "8.- Fundaci&oacute;n &oacute; Asociaci&oacute;n";break;
	case 9:return "9.- Templo, Convento o Monasterio";break;
	case 10:return "10.- Museo";break;
	case 11:return "11.- Compa&ntilde;ia de Bomberos";break;
	case 12:return "12.- Organizaci&oacute;n Sindical";break;
	case 13:return "13.- Comunidad Campesina o Nativa";break;
	case 14:return "14.- Cultural";break;
	case 15:return "15.- Partido Pol&iacute;tico";break;
	case 16:return "16.- Asistencia Gratuita";break;
	case 17:return "17.- Comunidad Laboral o de Compensaci&oacute;n";break;
	case 18:return "18.- Monumento Hist&oacute;rico";break;
	case 19:return "19.- ".$var2;break;
	}
}
function dptiemp2($var1){
	if($var1!=""){
		$da1=crt_datetime($var1." 00:00:00");
		return date("d/m/Y",$da1);
	}else{
		return "";
	}
}

function dptiemp($var1){
	if($var1!=""){
		$var=date("Y-m-d H:i:s");
		$vars=date("Y-m-d",crt_datetime($var1))." 00:00:00";
		$da1=crt_datetime($var1);
		$da1b=crt_datetime($vars);
		$da2=crt_datetime($var);
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
function dbol($var){
	if($var==0){
		return "<strong>No</strong>";
	}else{
		return "Si";
	}
}
function dsexo($var){
	if($var==0){
		return "Femenino";
	}else{
		return "Masculino";
	}
}
function dtitu($var1,$var2,$var3){
if($var2==1){
	if($var1==0){
		return "Sra.";
	}else{
		return "Sr.";
	}
}else{
	switch($var2){
	case 0: return $var3;break;
	case 2: return "Lic.";break;
	case 3: return "Ing.";break;
	case 4: return "C.C.";break;	
	};
}


	
}
function destad($vs1,$vs2){
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
function ddiret($var1,$var2){
		if($var2==0){
			switch ($var1){
				case 0:return "Avenida ";break;
				case 1:return "Jir&oacute;n ";break;
				case 2:return "Calle ";break;
				case 3:return "Pasaje ";break;
				case 4:return "Malec&oacute;n ";break;
				case 5:return "Prolongaci&oacute;n ";break;
				case 6:return "Zona rural ";break;
				case 7:return "Carretera ";break;
				case 8:return "Alameda ";break;
				case 9:return "Ovalo ";break;
				case 10:return "Plaza ";break;
				default:return "";break;
			}
		}else{
			switch ($var1){
				case 0:return "Av. ";break;
				case 1:return "Jr. ";break;
				case 2:return "Calle ";break;
				case 3:return "Psje. ";break;
				case 4:return "Malec&oacute;n ";break;
				case 5:return "Prolong. ";break;
				case 6:return "Zona rural ";break;
				case 7:return "Carretera ";break;
				case 8:return "Alameda ";break;
				case 9:return "Ovalo ";break;
				case 10:return "Plaza ";break;
				default:return "";break;
			}
		}
}
function ddirnu($var1,$var2,$var3,$var4){
$vs1="";$vs2="";$vs3="";$vs4="";
if(intval($var1)>0){
	$vs1=" N&deg; ".$var1;
}else{
	$vs1=" S/N ";
}

if($var2!="") $vs2=" Dpto. ".$var2;
if($var3!="") $vs3=" Mz. ".$var3;
if($var4!="") $vs4=" Lote ".$var4;
return $vs1." ".$vs2." ".$vs3." ".$vs4;
}

function dnuser($var1,$var2,$var3){
	$var2=dpanom($var2);
	$var3=dpanom($var3);
	$cade1=explode(" ",$var2);
	$cade2=explode(" ",$var3);
	$nuser=substr($cade2[0],0,1).substr($cade2[1],0,1).$cade1[0].substr($cade1[1],0,1);	
	if(strlen($nuser)<5){
		$nuser=$nuser.did();
		$nuser=substr($nuser,0,8);
	}
	if($var1==0){
		return $nuser;
	}else{
		return "@".$nuser;
	}
}
function dcoid($var){
	$var2=str_pad($var+1,5,"00000",STR_PAD_LEFT);
	return substr(date("Y"),-2).$var2;
}
function fillc($var){
	$var2=str_pad($var,4,"0000",STR_PAD_LEFT);
	return $var2."-".substr(date("Y"),-2);
}

function fillceros($var){
	$var2=str_pad($var,4,"0000",STR_PAD_LEFT);
	return $var2;
}

function dcoidfo($var1,$var2){
	$vart=str_pad($var1,5,"00000",STR_PAD_LEFT);
	$vart2=date("Y",crt_datetime($var2));
	return $vart."-".$vart2;
}

function dtabla(){
	$var=ObtenerNavegador($_SERVER['HTTP_USER_AGENT']);
	$var=substr($var,0,8);
	if($var == "Internet"){
		return "width=96%";
	}else{
		return "width=100%";
	}
}
function dbla($var){
	if($var==""){
		return "&nbsp;";
	}else{
		return $var;
	}
}
function denca($var){
	if($var==1){
		return "Si";
	}else{
		return "No";
	}
}
function denca2($var,$va2){
	if($var==1){
		return "Si &raquo; ".$va2;
	}else{
		return "No";
	}
}
function denca3($var,$va2){
	if($var==1){
		$vto="";
		if($va2!="") $vto=", <span class='min'>".$va2."</span>";
		return "<span style='color:#FF5538;'><strong>SI</strong>".$vto."</span>";
	}else{
		return "<span class='min'>Contribuyente activo</span>";
	}
}
function dsis2($var1,$var2){
	if($var1==0){
		return "- Todos (Administrador)";
	}else{
		switch ($var2){
			case 1:return "Predios Urbanos";break;
			case 2:return "Gesti&oacute;n Documentaria";break;
			case 3:return "- Predios Urbanos<br />- Gesti&oacute;n Documentaria";break;
			default:return "Administrador";break;
		}
	}
}

function dsis($var){
	switch ($var){
		case "":return "Administrador";break;
		case 1:return "Tr&aacute;mite Documentario";break;
		case 2:return "Intranet";break;
		case 3:return "- Tr&aacute;mite Documentario <br />- Intranet";break;
		default:return "Administrador";break;
	}
}
function dperfi($var1,$var2){
	if($var1==0){
		return "Administrador";
	}else{
		switch($var2){
			case 3: return "Encargado de oficina (Administrador)";break;
			case 4: return "Empleado normal";break;
		}
	}	
}
function dmes($var){
	switch($var){
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
function dubic($var1,$var2){
	switch($var1){
	case 0: return "Anexo";break;
	case 1: return "Barrio";break;
	case 2: return $var2;break;
	};
}
function dpanom($da1){
$busca=array("á","é","í","ó","ú","ñ","Á","É","Í","Ó","Ú","Ñ","  ");
$repla=array("a","e","i","o","u","n","a","e","i","o","u","n"," ");
$da1=str_replace($busca,$repla,utf8_decode($da1));
$da1=strtolower($da1);
//$da2=ereg_replace("[^a-z0-9_]", "",$da1);
$da2=$da1;
if(substr($da2,-1,1)=="_") $da2=substr($da2,0,-1);
$da2=str_replace("__","_",$da2);
return $da2;
}
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
function duacco($var1){
	if($var1==0){
		return "<span style=\"color:#FF5538\">&laquo;Desconectar</span>";
	}else{
		return "<span style=\"color:#4F8A1E\"><strong>&raquo;Conectar</strong></span>";
	}
}
function dacc($var){
	switch($var){
		case 0:return "<span style=\"color:#4F8A1E\">Insertar</span>";break;
		case 1:return "<span style=\"color:#0099CC\">Modificar</span>";break;
		case 2:return "<span style=\"color:#FF5538\">Eliminar</span>";break;
	}
}
function dfref($var){
	$cade1=explode("|",$var);
	return $cade1[0]." &raquo; ".$cade1[1];
}

function dlev($var){
	if($var==0){
		return "Administrador de sistema";
	}else{
		return "Empleado normal";
	}
}
function dvac($var){
	if($var==""){
		return "<div align='center'>x</div>";
	}else{	
		return "S/. ".number_format($var,2,".",",");
	}
}


function crt_datetime($str){
	if($str!=""){
		list($date, $time) = explode(' ', $str);
		list($year, $month, $day) = explode('-', $date);
		list($hour, $minute, $second) = explode(':', $time);
		$timestamp = mktime($hour, $minute, $second, $month, $day, $year);
		return $timestamp;
	}
}

function dcero($var,$var2){
	if($var2!=0){
		if($var!=0){
			return $var;
		}else{
			return "";
		}
	}else{
		return "checked=\"checked\"";
	}
}
function ObtenerNavegador($user_agent) {  
     $navegadores = array(  
          'Opera' => 'Opera',  
          'Mozilla Firefox'=> '(Firebird)|(Firefox)',  
          'Galeon' => 'Galeon',  
          'Chrome'=>'Gecko',  
          'MyIE'=>'MyIE',  
          'Lynx' => 'Lynx',  
          'Netscape' => '(Mozilla/4\.75)|(Netscape6)|(Mozilla/4\.08)|(Mozilla/4\.5)|(Mozilla/4\.6)|(Mozilla/4\.79)',  
          'Konqueror'=>'Konqueror',  
			'Internet Explorer 10' => '(MSIE 10\.[0-10]+)',  
			'Internet Explorer 9' => '(MSIE 9\.[0-9]+)',  
			'Internet Explorer 8' => '(MSIE 8\.[0-9]+)',  
          'Internet Explorer 7' => '(MSIE 7\.[0-9]+)',  
          'Internet Explorer 6' => '(MSIE 6\.[0-9]+)',  
          'Internet Explorer 5' => '(MSIE 5\.[0-9]+)',  
          'Internet Explorer 4' => '(MSIE 4\.[0-9]+)',  
);  



foreach($navegadores as $navegador=>$pattern){  
       if (eregi($pattern, $user_agent))  
       return $navegador;  
    }




 
return 'Desconocido';  
}

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
//registrar acciones
//v1 formulario
//v2 Accion
//v3 user
function logac($var1,$var2,$var3,$var4){
	include('../Connections/cn1.php');
	$cn2 = mysql_pconnect($hostname_cn1, $username_cn1, $password_cn1) or trigger_error(mysql_error(),E_USER_ERROR); 
	$insertSQLlog = sprintf("INSERT INTO log_acc (id, fecha, user, empid, form, accion, ip, hostip) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
	GetSQLValueString("", "int"),
	GetSQLValueString(date("Y-m-d H:i:s"), "date"),
	GetSQLValueString($var3, "text"),
	GetSQLValueString($var4, "text"),
	GetSQLValueString($var1, "text"),
	GetSQLValueString($var2, "text"),
	GetSQLValueString($_SERVER['REMOTE_ADDR'], "text"),
	GetSQLValueString(gethostbyaddr($_SERVER['REMOTE_ADDR']), "text"));
	mysql_select_db($database_cn1, $cn2);
	$Result2 = mysql_query($insertSQLlog, $cn2) or die(mysql_error());
}
//v2 destino
//v3 tipo, 0 externo, 1 interno
//v4 forma
//v5 folio relacionado
//v7 oficina de creacion
function folio_derivar($var2,$var3,$var4,$var5,$var6=""){
	include('../Connections/cn1.php');
	
	$cn2 = mysql_pconnect($hostname_cn1, $username_cn1, $password_cn1) or trigger_error(mysql_error(),E_USER_ERROR); 
//id,tipo,folio,forma,obs,fecha,user,empid,d_oficina,atendido,recibido
	$insertSQL = sprintf("INSERT INTO log_derivar (id, tipo, folioext_id, forma, obs, fecha, user, empid, c_oficina, d_oficina) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
	GetSQLValueString("", "int"),//id
	GetSQLValueString($var3, "int"),//tipo
	GetSQLValueString($var5, "int"),//folio
	GetSQLValueString($var4, "int"),//forma
	GetSQLValueString($var6, "text"),//obs
	GetSQLValueString(date("Y-m-d H:i:s"), "date"),//fecha
	GetSQLValueString($_SESSION['u_id'], "text"),//user
	GetSQLValueString($_SESSION['u_empid'], "text"),//empid
	GetSQLValueString($_SESSION['u_ofice'], "text"),//oficiac de creacion
	GetSQLValueString($var2, "text"));//d_oficina

	mysql_select_db($database_cn1, $cn2);
	$Result1 = mysql_query($insertSQL, $cn2) or die(mysql_error());
	
}
function folio_derivar_int($var2,$var3,$var4,$var5,$var6=""){
	include('../Connections/cn1.php');
	
	$cn2 = mysql_pconnect($hostname_cn1, $username_cn1, $password_cn1) or trigger_error(mysql_error(),E_USER_ERROR); 
//id,tipo,folio,forma,obs,fecha,user,empid,d_oficina,atendido,recibido
	$insertSQL = sprintf("INSERT INTO log_derivar_int (id, tipo, folioint_id, forma, obs, fecha, user, empid, c_oficina, d_oficina) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
	GetSQLValueString("", "int"),//id
	GetSQLValueString($var3, "int"),//tipo
	GetSQLValueString($var5, "int"),//folio
	GetSQLValueString($var4, "int"),//forma
	GetSQLValueString($var6, "text"),//obs
	GetSQLValueString(date("Y-m-d H:i:s"), "date"),//fecha
	GetSQLValueString($_SESSION['u_id'], "text"),//user
	GetSQLValueString($_SESSION['u_empid'], "text"),//empid
	GetSQLValueString($_SESSION['u_ofice'], "text"),//oficiac de creacion
	GetSQLValueString($var2, "text"));//d_oficina

	mysql_select_db($database_cn1, $cn2);
	$Result1 = mysql_query($insertSQL, $cn2) or die(mysql_error());
	
}
//v2 destino
//v3 tipo, 0 externo, 1 interno
//v4 forma
//v5 folio relacionado
//v6 folio relacionado
//v7 provei
//v8 file
//v9 ext
//v10 size
function folio_derivar2($var2,$var3,$var4,$var5,$var6="",$var7="",$var8="",$var9="",$var10=""){
	include('../Connections/cn1.php');
	
	$cn2 = mysql_pconnect($hostname_cn1, $username_cn1, $password_cn1) or trigger_error(mysql_error(),E_USER_ERROR); 
//id,tipo,folio,forma,obs,fecha,user,empid,d_oficina,atendido,recibido
	$insertSQL = sprintf("INSERT INTO log_derivar (id, tipo, folioext_id, forma, obs, fecha, user, empid, c_oficina, d_oficina, provei, file, ext, size) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
	GetSQLValueString("", "int"),//id
	GetSQLValueString($var3, "int"),//tipo
	GetSQLValueString($var5, "int"),//folio
	GetSQLValueString($var4, "int"),//forma
	GetSQLValueString($var6, "text"),//obs
	GetSQLValueString(date("Y-m-d H:i:s"), "date"),//fecha
	GetSQLValueString($_SESSION['u_id'], "text"),//user
	GetSQLValueString($_SESSION['u_empid'], "text"),//empid
	GetSQLValueString($_SESSION['u_ofice'], "text"),//oficiac de creacion
	GetSQLValueString($var2, "text"),
	GetSQLValueString($var7, "text"),
	GetSQLValueString($var8, "text"),
	GetSQLValueString($var9, "text"),
	GetSQLValueString($var10, "text"));//d_oficina

	mysql_select_db($database_cn1, $cn2);
	$Result1 = mysql_query($insertSQL, $cn2) or die(mysql_error());
	
}
function folio_derivar2_int($var2,$var3,$var4,$var5,$var6="",$var7="",$var8="",$var9="",$var10=""){
	include('../Connections/cn1.php');
	
	$cn2 = mysql_pconnect($hostname_cn1, $username_cn1, $password_cn1) or trigger_error(mysql_error(),E_USER_ERROR); 
//id,tipo,folio,forma,obs,fecha,user,empid,d_oficina,atendido,recibido
	$insertSQL = sprintf("INSERT INTO log_derivar_int (id, tipo, folioext_id, forma, obs, fecha, user, empid, c_oficina, d_oficina, provei, file, ext, size) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
	GetSQLValueString("", "int"),//id
	GetSQLValueString($var3, "int"),//tipo
	GetSQLValueString($var5, "int"),//folio
	GetSQLValueString($var4, "int"),//forma
	GetSQLValueString($var6, "text"),//obs
	GetSQLValueString(date("Y-m-d H:i:s"), "date"),//fecha
	GetSQLValueString($_SESSION['u_id'], "text"),//user
	GetSQLValueString($_SESSION['u_empid'], "text"),//empid
	GetSQLValueString($_SESSION['u_ofice'], "text"),//oficiac de creacion
	GetSQLValueString($var2, "text"),
	GetSQLValueString($var7, "text"),
	GetSQLValueString($var8, "text"),
	GetSQLValueString($var9, "text"),
	GetSQLValueString($var10, "text"));//d_oficina

	mysql_select_db($database_cn1, $cn2);
	$Result1 = mysql_query($insertSQL, $cn2) or die(mysql_error());
	
}
//v1 id
function folio_doperado($var1){
	include('../Connections/cn1.php');
	
	$cn2 = mysql_pconnect($hostname_cn1, $username_cn1, $password_cn1) or trigger_error(mysql_error(),E_USER_ERROR); 
				  
	$updateSQL = sprintf("UPDATE log_derivar SET atendido=%s WHERE id=%s",
					   GetSQLValueString(1, "int"),
					   GetSQLValueString($var1, "int"));

	mysql_select_db($database_cn1, $cn2);
	$Result1 = mysql_query($updateSQL, $cn2) or die(mysql_error());
		
}


function folio_doperado_int($var1){
	include('../Connections/cn1.php');
	
	$cn2 = mysql_pconnect($hostname_cn1, $username_cn1, $password_cn1) or trigger_error(mysql_error(),E_USER_ERROR); 
				  
	$updateSQL = sprintf("UPDATE log_derivar_int SET atendido=%s WHERE id=%s",
					   GetSQLValueString(1, "int"),
					   GetSQLValueString($var1, "int"));

	mysql_select_db($database_cn1, $cn2);
	$Result1 = mysql_query($updateSQL, $cn2) or die(mysql_error());
		
}



//id
function folxt_aten($var1){
	include('../Connections/cn1.php');	
	$cn2 = mysql_pconnect($hostname_cn1, $username_cn1, $password_cn1) or trigger_error(mysql_error(),E_USER_ERROR); 
				  
	$updateSQL = sprintf("UPDATE folioext SET atendido=%s WHERE id=%s",
					   GetSQLValueString(1, "int"),
					   GetSQLValueString($var1, "int"));

	mysql_select_db($database_cn1, $cn2);
	$Result1 = mysql_query($updateSQL, $cn2) or die(mysql_error());
		
}
function folxt_aten_int($var1){
	include('../Connections/cn1.php');	
	$cn2 = mysql_pconnect($hostname_cn1, $username_cn1, $password_cn1) or trigger_error(mysql_error(),E_USER_ERROR); 
				  
	$updateSQL = sprintf("UPDATE folioext SET atendido=%s WHERE id=%s",
					   GetSQLValueString(1, "int"),
					   GetSQLValueString($var1, "int"));

	mysql_select_db($database_cn1, $cn2);
	$Result1 = mysql_query($updateSQL, $cn2) or die(mysql_error());
		
}
//buscar id desde aid
//v1 aid
//v2 tabla
function vfaid($var1,$var2){
// crea el contador de registros
	include('../Connections/cn1.php');	
	mysql_select_db($database_cn1, $cn1);
	$query_rp1 = "SELECT id FROM $var2 WHERE aid='$var1' LIMIT 1";
	$rp1 = mysql_query($query_rp1, $cn1) or die(mysql_error());
	$row_rp1 = mysql_fetch_assoc($rp1);
	$totalRows_rp1 = mysql_num_rows($rp1);
	if($row_rp1['id']==NULL){
		return 0;
	}else{
		return $row_rp1['id'];
	}
	mysql_free_result($rp1);
}

function vfoexp($var1){
// crea el contador de registros
	include('../Connections/cn1.php');	
	mysql_select_db($database_cn1, $cn1);
	$query_rp1 = "SELECT (MAX(exp)+1) AS val FROM folioext WHERE YEAR(fecha)= YEAR(NOW()) AND td_tipos_id=".$var1;
	$rp1 = mysql_query($query_rp1, $cn1) or die(mysql_error());
	$row_rp1 = mysql_fetch_assoc($rp1);
	$totalRows_rp1 = mysql_num_rows($rp1);
	if($row_rp1['val']==NULL){
		return 1;
	}else{
		return $row_rp1['val'];
	}
	mysql_free_result($rp1);
}
function impmsj(){
// extrae mensaje de la DB
	include('../Connections/cn1.php');	
	mysql_select_db($database_cn1, $cn1);
	$query_rp1 = "SELECT * FROM opciones WHERE id=1";
	$rp1 = mysql_query($query_rp1, $cn1) or die(mysql_error());
	$row_rp1 = mysql_fetch_assoc($rp1);
	$totalRows_rp1 = mysql_num_rows($rp1);
	return "<strong>".$row_rp1['valor']."</strong>";
	mysql_free_result($rp1);
}
function vfoid(){
	include('../Connections/cn1.php');	
	mysql_select_db($database_cn1, $cn1);
	$query_rp1 = "SELECT (MAX(id)+1) AS val FROM folio ORDER BY fecha DESC";
	$rp1 = mysql_query($query_rp1, $cn1) or die(mysql_error());
	$row_rp1 = mysql_fetch_assoc($rp1);
	$totalRows_rp1 = mysql_num_rows($rp1);
	if($row_rp1['val']==NULL){
		return 1;
	}else{
		return $row_rp1['val'];
	}
	mysql_free_result($rp1);
}
function dandisp($var1,$var2,$var3,$var4){	
	include('../Connections/cn1.php');	
	mysql_select_db($database_cn1, $cn1);
	$query_rp1 = "SELECT * FROM arancelario WHERE calles_id=$var1 ORDER BY annos_anno ASC";
	$rp1 = mysql_query($query_rp1, $cn1) or die(mysql_error());
	$row_rp1 = mysql_fetch_assoc($rp1);
	$totalRows_rp1 = mysql_num_rows($rp1);
	$vtemp="";
	if($row_rp1['annos_anno']==NULL){
		//return "<div class=\"alert1\"><span class=\"skin left\" style=\"background-position:-16px -79px;margin-right:3px;\"></span> No hay aranceles disponibles para esta calle</div>";
		return 0;
	}else{
		do{
			if($var3==$row_rp1['annos_anno']){
			$vtemp.="<span style=\"text-decoration:underline;font-weight:bold;font-size:12px;\">".$row_rp1['annos_anno']."</span><span class=\"spbar\">|</span>";
			}else{
			$vtemp.="<a href=\"$var4.php?pr=$var2&anno=".$row_rp1['annos_anno']."\">".$row_rp1['annos_anno']."</a><span class=\"spbar\">|</span>";
			}
		}while ($row_rp1 = mysql_fetch_assoc($rp1));
		return substr($vtemp,0,-32)."</span>";
	}	
	mysql_free_result($rp1);
}
function dandisp2($var1){	
	include('../Connections/cn1.php');	
	mysql_select_db($database_cn1, $cn1);
	$query_rp1 = "SELECT * FROM arancelario WHERE calles_id=$var1 ORDER BY annos_anno DESC LIMIT 1";
	$rp1 = mysql_query($query_rp1, $cn1) or die(mysql_error());
	$row_rp1 = mysql_fetch_assoc($rp1);
	$totalRows_rp1 = mysql_num_rows($rp1);
	$vtemp="";
	if($row_rp1['annos_anno']==NULL){
		return 0;
	}else{
		return $row_rp1['annos_anno'];
	}	
	return substr($vtemp,0,-32);
	mysql_free_result($rp1);
}
function dandisp3($var1,$var2){	
	include('../Connections/cn1.php');	
	mysql_select_db($database_cn1, $cn1);
	$query_rp1 = "SELECT * FROM arancelario WHERE calles_id=$var1 AND annos_anno=$var2 LIMIT 1";
	$rp1 = mysql_query($query_rp1, $cn1) or die(mysql_error());
	$row_rp1 = mysql_fetch_assoc($rp1);
	$totalRows_rp1 = mysql_num_rows($rp1);
	$vtemp="";
	if($row_rp1['annos_anno']==NULL){
		return 0;
	}else{
		return $row_rp1['annos_anno'];
	}	
	return substr($vtemp,0,-32);
	mysql_free_result($rp1);
}

function dev_sinoc($var){
	if($var==1){
		return "<span class=\"bsi\">Si</span>";
	}else{
		return "<span class=\"bno\">No</span>";
	}
}

function getUserImg($user_id = ""){
	
	include('../Connections/cn1.php');	
	mysql_select_db($database_cn1, $cn1);
	$query_rp1 = "SELECT foto, sexo FROM empleado WHERE id='".$user_id."' LIMIT 1";
	
	$rp1 = mysql_query($query_rp1, $cn1) or die(mysql_error());
	$row_rp1 = mysql_fetch_assoc($rp1);
	$totalRows_rp1 = mysql_num_rows($rp1);
	
	
	$picture = $row_rp1['foto'];
	$gender = $row_rp1['sexo'];
		
	$imageUser = '../data/users/'.$picture;
	
		if (!file_exists($imageUser) || $picture=='')  
		{
			if($gender == 1)
				$imageUser = '../data/users/no-image-m.png';
			else
				$imageUser = '../data/users/no-image-f.png';
		}
		
	return  $imageUser;
	mysql_free_result($rp1);

}

##########################
function checkValues($value){
	$value = trim($value);
	// Stripslashes
	if (get_magic_quotes_gpc()) {
		$value = stripslashes($value);
	}
	// Convert all &lt;, &gt; etc. to normal html and then strip these
	$value = strtr($value,array_flip(get_html_translation_table(HTML_ENTITIES)));
	// Strip HTML Tags
	$value = strip_tags($value);
	
	// Quote the value
	$value = mysql_real_escape_string($value);
	$value = htmlspecialchars ($value);
	return $value;		
}	

function utf8_urldecode($str) {
	$varex = urldecode($str);
	$varex = nl2br(stripcslashes($varex));
	
	$vrr1= array("%u201C","%u201D");
	$vrr2= array("&quot;","&quot;");
	
	$varex = utf8_encode($varex);
	
    return str_replace($vrr1,$vrr2,$varex);
	//htmlentities
   
    //return stripcslashes(html_entity_decode($str,null,'UTF-8'));
}
function dameURL(){
$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
return $url;
}

?>