<?php 
require_once('../Connections/cn1.php');
require_once('../includes/functions.php');
if(isset($_POST['queryString'])) {
	$queryString = ($_POST['queryString']);	
	if(strlen($queryString) >0){		
		mysql_select_db($database_cn1, $cn1);
		$query = "SELECT folio.id,folio.firma,folio.asunto,folio.fecha,CONCAT(empleado.apellido,', ',empleado.nombre) AS enombre,oficinas.nombre AS onombre, (SELECT COUNT(log_folio.id)FROM log_folio WHERE log_folio.c_oficina=folio.id) AS tot FROM folio,empleado,oficinas WHERE
		folio.empid=empleado.id AND 
		folio.d_oficina=oficinas.id AND 
		CONCAT(folio.firma,' ',folio.asunto) LIKE '%$queryString%'

		ORDER BY folio.fecha DESC LIMIT 10
		
		
		
		SELECT * FROM folio 
		WHERE 
		id LIKE '$queryString' OR
		asunto LIKE '%$queryString%' OR
		firma LIKE '%$queryString%' OR
		obs LIKE '%$queryString%'
		ORDER BY fecha DESC
		LIMIT 10";		
		
		$result = mysql_query($query, $cn1) or die(mysql_error());
		$row_rs1 = mysql_fetch_assoc($result);
		$sptab="&nbsp;&nbsp;&nbsp;&nbsp;";
		echo '<ul>';
			do{
				$name = $row_rs1['firma'].$sptab." ( ".$row_rs1['asunto']." )";
				//$name = str_replace($queryString,"<span class=\"red\">".$queryString."</span>",$name);
				$fech="Fecha: ".dptiemp($row_rs1['fecha']);
				$vdir="<br /><span class='min'>".$row_rs1['asunto']."</span>";
				$name = $name.$sptab.$sptab."|".$sptab.$sptab.$fech;
				if($row_rs1['id']!=""){
				echo "<li onClick=\"location.href='".$_COOKIE['pk'].".php?pk=".$row_rs1['id']."'\">".$name.'</li>';
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