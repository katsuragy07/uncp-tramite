<?php 
require_once('../Connections/cn1.php');
require_once('../includes/functions.php');
require_once('../includes/permisos_all_ui.php');
if(isset($_POST['queryString'])) {
	$queryString = ($_POST['queryString']);	
	$soffice=$_SESSION['u_ofice'];
	if(strlen($queryString) >0){		
		mysql_select_db($database_cn1, $cn1);
		$query = "SELECT folio.*, CONCAT(empleado.apellido,', ',empleado.nombre) AS enombre,oficinas.nombre AS onombre,
		(SELECT MAX(log_folio.ope) FROM log_folio WHERE log_folio.folio_id=folio.id ORDER BY log_folio.fecha DESC) AS tot,		
		(SELECT log_folio.ope FROM log_folio WHERE log_folio.folio_id=folio.id ORDER BY log_folio.fecha DESC LIMIT 1) AS ops 
		
		FROM folio,empleado,oficinas 
		
		WHERE 
		folio.empid=empleado.id 

		AND folio.d_oficina='$soffice'
		
		OR folio.id LIKE '$queryString' 
		OR folio.asunto LIKE '%$queryString%'
		OR folio.firma LIKE '%$queryString%'
		OR folio.obs LIKE '%$queryString%'
		
		group by folio.id
		ORDER BY folio.fecha DESC
		LIMIT 10";		
		
		$result = mysql_query($query, $cn1) or die(mysql_error());
		$row_rs1 = mysql_fetch_assoc($result);
		$sptab="&nbsp;&nbsp;&nbsp;&nbsp;";
		echo $soffice.'<ul>';
			do{
				$name = $row_rs1['firma']." ( ".$row_rs1['asunto']." )";
				$name = strtoupper_utf8($name);
				//$name = str_replace($queryString,"<span class=\"red\">".$queryString."</span>",$name);
				$fech="Fecha: ".dptiemp($row_rs1['fecha']);
				$vdir="<br /><span class='min'>".$row_rs1['asunto']."</span>";
				$queryString = strtoupper_utf8($_POST['queryString']);
				$name=str_replace($queryString,"<span class=\"red\">".$queryString."</span>",$name);
				$name2 = "Folio: ".$row_rs1['id'].$sptab.$name.$sptab.$sptab."|".$sptab.$sptab.$fech;
				if($row_rs1['id']!=""){
				echo "<li onClick=\"location.href='td_verfolio.php?pk=".$row_rs1['id']."'\">".$name2.'</li>';
				}
			}while ($row_rs1 = mysql_fetch_assoc($result));
		echo '</ul>';					
		
	} else {
		// do nothing
	}
}else{
	echo 'No tienes acceso a este modulo!';
}
?>