<?php
function callantq($var){
	switch (true){
		case ($var>=50):return 100;break;
		case ($var>45): return 50;break;
		case ($var>40): return 45;break;
		case ($var>35): return 40;break;
		case ($var>30): return 35;break;
		case ($var>25): return 30;break;
		case ($var>20): return 25;break;
		case ($var>15): return 20;break;
		case ($var>10): return 15;break;
		case ($var>5): return 10;break;
		default: return 5;break;
	}
}
function callclas($var){
	switch ($var){
		case 1: return "A";break;
		case 2: return "B";break;
		case 3: return "C";break;
		case 4: return "D";break;
		case 5: return "E";break;
		case 6: return "F";break;
		case 7: return "G";break;
		case 8: return "H";break;
		case 9: return "I";break;
	}
}
function lldepre($var1,$var2,$var3,$var4){
	include('../Connections/cn1.php');	
	mysql_select_db($database_cn1, $cn1);
	$query_rp1 = "SELECT cose_".$var4." as val FROM tabdepre WHERE clase=".$var1." AND antig=".$var2." AND mat=".$var3." LIMIT 1";
	$rp1 = mysql_query($query_rp1, $cn1) or die(mysql_error());
	$row_rp1 = mysql_fetch_assoc($rp1);
	$totalRows_rp1 = mysql_num_rows($rp1);
	return $row_rp1['val'];
	mysql_free_result($rp1);
}
function llvalu($var1,$var2,$var3,$var4,$var5,$var6,$var7,$var8){
	include('../Connections/cn1.php');	
	mysql_select_db($database_cn1, $cn1);
	$query_rp1 = "SELECT e1 as val FROM vunit WHERE afiscal_anno=".$var1." AND clase ='".$var2."' LIMIT 1";
	$rp1 = mysql_query($query_rp1, $cn1) or die(mysql_error());
	$row_rp1 = mysql_fetch_assoc($rp1);
	$totalRows_rp1 = mysql_num_rows($rp1);
	
	$query_rp2 = "SELECT e2 as val FROM vunit WHERE afiscal_anno=".$var1." AND clase ='".$var3."' LIMIT 1";
	$rp2 = mysql_query($query_rp2, $cn1) or die(mysql_error());
	$row_rp2 = mysql_fetch_assoc($rp2);
	$totalRows_rp2 = mysql_num_rows($rp2);
	
	$query_rp3 = "SELECT a1 as val FROM vunit WHERE afiscal_anno=".$var1." AND clase ='".$var4."' LIMIT 1";
	$rp3 = mysql_query($query_rp3, $cn1) or die(mysql_error());
	$row_rp3 = mysql_fetch_assoc($rp3);
	$totalRows_rp3 = mysql_num_rows($rp3);
	
	$query_rp4 = "SELECT a2 as val FROM vunit WHERE afiscal_anno=".$var1." AND clase ='".$var5."' LIMIT 1";
	$rp4 = mysql_query($query_rp4, $cn1) or die(mysql_error());
	$row_rp4 = mysql_fetch_assoc($rp4);
	$totalRows_rp4 = mysql_num_rows($rp4);
	
	$query_rp5 = "SELECT a3 as val FROM vunit WHERE afiscal_anno=".$var1." AND clase ='".$var6."' LIMIT 1";
	$rp5 = mysql_query($query_rp5, $cn1) or die(mysql_error());
	$row_rp5 = mysql_fetch_assoc($rp5);
	$totalRows_rp5 = mysql_num_rows($rp5);
	
	$query_rp6 = "SELECT a4 as val FROM vunit WHERE afiscal_anno=".$var1." AND clase ='".$var7."' LIMIT 1";
	$rp6 = mysql_query($query_rp6, $cn1) or die(mysql_error());
	$row_rp6 = mysql_fetch_assoc($rp6);
	$totalRows_rp6 = mysql_num_rows($rp6);
	
	$query_rp7 = "SELECT i1 as val FROM vunit WHERE afiscal_anno=".$var1." AND clase ='".$var8."' LIMIT 1";
	$rp7 = mysql_query($query_rp7, $cn1) or die(mysql_error());
	$row_rp7 = mysql_fetch_assoc($rp7);
	$totalRows_rp7 = mysql_num_rows($rp7);
		
	return $row_rp1['val']+$row_rp2['val']+$row_rp3['val']+$row_rp4['val']+$row_rp5['val']+$row_rp6['val']+$row_rp7['val'];
	
	mysql_free_result($rp1);
	mysql_free_result($rp2);
	mysql_free_result($rp3);
	mysql_free_result($rp4);
	mysql_free_result($rp5);
	mysql_free_result($rp6);
	mysql_free_result($rp7);
}
function llexo1($var1){
	include('../Connections/cn1.php');	
	mysql_select_db($database_cn1, $cn1);
	$query_rp1 = "SELECT imp AS val FROM variacion WHERE anno=".$var1." LIMIT 1";
	$rp1 = mysql_query($query_rp1, $cn1) or die(mysql_error());
	$row_rp1 = mysql_fetch_assoc($rp1);
	$totalRows_rp1 = mysql_num_rows($rp1);
	return $row_rp1['val'];
	mysql_free_result($rp1);
}
function llexo2($var1){
	include('../Connections/cn1.php');	
	mysql_select_db($database_cn1, $cn1);
	$query_rp1 = "SELECT porc AS val FROM variacion WHERE anno=".$var1." LIMIT 1";
	$rp1 = mysql_query($query_rp1, $cn1) or die(mysql_error());
	$row_rp1 = mysql_fetch_assoc($rp1);
	$totalRows_rp1 = mysql_num_rows($rp1);
	return $row_rp1['val'];
	mysql_free_result($rp1);
}
function llexo3($var1,$var2){
	include('../Connections/cn1.php');	
	mysql_select_db($database_cn1, $cn1);
	$query_rp1 = "SELECT imp AS val,importe FROM variacion WHERE anno=".$var1." LIMIT 1";
	$rp1 = mysql_query($query_rp1, $cn1) or die(mysql_error());
	$row_rp1 = mysql_fetch_assoc($rp1);
	$totalRows_rp1 = mysql_num_rows($rp1);
	if($var2>$row_rp1['importe']*60){
		return $row_rp1['importe']/100*$var2;
	}else{
		if($var2>$row_rp1['importe']*15){
			return ($var2/100*0.6);
		}else{
			if($var2>$row_rp1['importe']*3){
				return ($var2/100*0.2);
			}else{
				return $row_rp1['val'];
			}
		}
	}
	mysql_free_result($rp1);
}
//1 predio
//2 año
//3 id direccion
function dev_valpre($var1,$var2,$var3){

	include('../Connections/cn1.php');	
	
	mysql_select_db($database_cn1, $cn1);
	$query_crp1 = "SELECT * FROM const WHERE predio_id = $var1 AND anno=$var2";
	$crp1 = mysql_query($query_crp1, $cn1) or die(mysql_error());
	$row_crp1 = mysql_fetch_assoc($crp1);
	$totalRows_crp1 = mysql_num_rows($crp1);
	
	mysql_select_db($database_cn1, $cn1);
	$query_crp2 = sprintf("SELECT * FROM adqui WHERE predio_id = $var1", GetSQLValueString($colname_crp2, "int"));
	$crp2 = mysql_query($query_crp2, $cn1) or die(mysql_error());
	$row_crp2 = mysql_fetch_assoc($crp2);
	$totalRows_crp2 = mysql_num_rows($crp2);
	
	mysql_select_db($database_cn1, $cn1);
	$query_crp3 = sprintf("SELECT * FROM arancelario WHERE calles_id = $var3 AND annos_anno= $var2", GetSQLValueString($colname_crp3, "int"));
	$crp3 = mysql_query($query_crp3, $cn1) or die(mysql_error());
	$row_crp3 = mysql_fetch_assoc($crp3);
	$totalRows_crp3 = mysql_num_rows($crp3);
	
	$cont=0;$ttcont=0; 
	$vtota=array();
	if ($totalRows_crp1 > 0) {
		do { 
			$cont++;
			$antigu=0;
			$antigu=$row_crp3['annos_anno']-substr($row_crp1['fech_const'],0,4); 
			$vunita=llvalu($row_crp3['annos_anno'],
			callclas($row_crp1['e1']),
			callclas($row_crp1['e2']),
			callclas($row_crp1['a1']),
			callclas($row_crp1['a2']),
			callclas($row_crp1['a3']),
			callclas($row_crp1['a4']),
			callclas($row_crp1['i1'])); 
			$pdepre=lldepre($row_crp1['clasi'],callantq($antigu),$row_crp1['mat'],$row_crp1['conserv']); 
			$vdepre=$vunita-round($vunita/100*$pdepre,2); 
			$vlacnst=round($row_crp1['ar_const']*$vdepre,2); 
			$vtota[$cont-1]=$vlacnst;
			$ttcont=$row_crp1['con_tipo'];
		} while ($row_crp1 = mysql_fetch_assoc($crp1));
	}
	$tconst=0;

	for($xa=0;$xa<count($vtota);$xa++){
		$tconst=$tconst+$vtota[$xa];
	}
	$vterr=$row_crp2['area']*$row_crp3['valor'];
	//echo $row_crp3['valor']." ";
	$vtopre=$vterr+$tconst;

	return $vtopre;
	
	
	mysql_free_result($crp1);
	mysql_free_result($crp2);
	mysql_free_result($crp3);
}


// 1 predio
function dev_area($var1){
	include('../Connections/cn1.php');
	mysql_select_db($database_cn1, $cn1);
	$query_crp2 = sprintf("SELECT * FROM adqui WHERE predio_id = $var1", GetSQLValueString($colname_crp2, "int"));
	$crp2 = mysql_query($query_crp2, $cn1) or die(mysql_error());
	$row_crp2 = mysql_fetch_assoc($crp2);
	$totalRows_crp2 = mysql_num_rows($crp2);
	return number_format($row_crp2['area'],2,".",",")."m2";
	mysql_free_result($crp2);
}
function dev_exo1($var1){
	include('../Connections/cn1.php');
	mysql_select_db($database_cn1, $cn1);
	$query_crp2 = sprintf("SELECT exoneracion.tipo FROM exoneracion WHERE exoneracion.predio_id=$var1 AND (exoneracion.pfin_anno >= YEAR(NOW()) OR MONTH(NOW()) DIV 3 <= exoneracion.pfin_trim) ORDER BY pfin_anno DESC LIMIT 1", GetSQLValueString($colname_crp2, "int"));
	$crp2 = mysql_query($query_crp2, $cn1) or die(mysql_error());
	$row_crp2 = mysql_fetch_assoc($crp2);
	$totalRows_crp2 = mysql_num_rows($crp2);
	return dpexo($row_crp2['tipo']);	
	mysql_free_result($crp2);
}
//1 predio
//2 año
//3 valor
function dev_exo2($var1, $var2, $var3){
	include('../Connections/cn1.php');
	mysql_select_db($database_cn1, $cn1);
	$query_crp2 = sprintf("SELECT exoneracion.tipo FROM exoneracion WHERE exoneracion.predio_id=$var1 AND (exoneracion.pfin_anno >= YEAR(NOW()) OR MONTH(NOW()) DIV 3 <= exoneracion.pfin_trim) ORDER BY pfin_anno DESC LIMIT 1", GetSQLValueString($colname_crp2, "int"));
	$crp2 = mysql_query($query_crp2, $cn1) or die(mysql_error());
	$row_crp2 = mysql_fetch_assoc($crp2);
	$totalRows_crp2 = mysql_num_rows($crp2);
	
	//return dpexo($row_crp2['tipo']);	
	$vtopre=$var3;
	$vaexo=0;
		switch($row_crp2['tipo']){
			case 1:$vtopre=0;break;
			case 2:$vtopre=porcentaje($vtopre,llexo2($var2),2);break;
			case 3:$vtopre=0;break;
			case NULL:$vtopre=$vtopre;break;
		}
	//return number_format($vtopre,2,".",",");
	return $vtopre;
	
	mysql_free_result($crp2);
}
?>
