<?php 
require_once('../Connections/cn1.php');
require_once('../includes/functions.php');
if(isset($_POST['queryString'])) {
	$queryString = ($_POST['queryString']);	
	$queryOfice = ($_POST['queryOfice']);	
	if(strlen($queryString) >0){		
		mysql_select_db($database_cn1, $cn1);
		$query = "SELECT log_derivar.*
		,(SELECT CONCAT(empleado.apellido,', ',empleado.nombre) FROM empleado WHERE empleado.id = log_derivar.empid LIMIT 1) AS enombre
		,(SELECT CONCAT(lugares.nombre,' | ',oficinas.nombre) FROM oficinas,lugares,log_derivar WHERE oficinas.id=log_derivar.c_oficina AND oficinas.lugares_id=lugares.id LIMIT 1)AS onombre
		,(SELECT folioext.firma FROM folioext WHERE folioext.id=log_derivar.folioext_id LIMIT 1) AS firma
		,(SELECT folioext.asunto FROM folioext WHERE folioext.id=log_derivar.folioext_id LIMIT 1) AS asunto
		,(SELECT folioext.obs FROM folioext WHERE folioext.id=log_derivar.folioext_id LIMIT 1) AS obser
		,(SELECT folioext.urgente FROM folioext WHERE folioext.id=log_derivar.folioext_id LIMIT 1) AS urgente
		,(SELECT folioext.id FROM folioext WHERE folioext.id=log_derivar.folioext_id LIMIT 1) AS foid
		,(SELECT folioext.nfolios FROM folioext WHERE folioext.id=log_derivar.folioext_id LIMIT 1) AS nfolios
		,(SELECT folioext.cabecera FROM folioext WHERE folioext.id=log_derivar.folioext_id LIMIT 1) AS cabecera
		,(SELECT folioext.`exp` FROM folioext WHERE folioext.id=log_derivar.folioext_id LIMIT 1) AS `exp`
		,(SELECT folioext.td_tipos_id FROM folioext WHERE folioext.id=log_derivar.folioext_id LIMIT 1) AS td_tipos_id
		,(SELECT folioext.file FROM folioext WHERE folioext.id=log_derivar.folioext_id LIMIT 1) AS ofile
		,(SELECT folioext.atendido FROM folioext WHERE folioext.id=log_derivar.folioext_id LIMIT 1) AS atendido
		,(SELECT folioext.ext FROM folioext WHERE folioext.id=log_derivar.folioext_id LIMIT 1) AS oext
		,(SELECT folioext.size FROM folioext WHERE folioext.id=log_derivar.folioext_id LIMIT 1) AS osize
		FROM log_derivar INNER JOIN  folioext ON folioext.id = log_derivar.folioext_id
		WHERE log_derivar.c_oficina = $queryOfice
		AND (SELECT folioext.id FROM folioext WHERE folioext.id=log_derivar.folioext_id LIMIT 1) IS NOT NULL
		AND log_derivar.tipo=0
		AND
		
		(
				CONCAT(folioext.td_tipos_id, folioext.exp,YEAR(folioext.fecha)) LIKE '%$queryString%' OR
				folioext.asunto LIKE '%$queryString%' OR
				folioext.firma LIKE '%$queryString%' OR
				folioext.obs LIKE '%$queryString%'		
		)
		
		ORDER BY log_derivar.fecha DESC LIMIT 20;";		
		
		$result = mysql_query($query, $cn1) or die(mysql_error());
		$row_rs1 = mysql_fetch_assoc($result);
		$sptab="&nbsp;&nbsp;&nbsp;&nbsp;";						
		echo '<ul>';
			do{
				$name = strip_tags(str_replace("\n","",$row_rs1['firma']." ( ".$row_rs1['asunto']." )"));
				$name = strtoupper_utf8($name);
				//$name = str_replace($queryString,"<span class=\"red\">".$queryString."</span>",$name);
				$fech="Fecha: ".dptiemp($row_rs1['fecha']);
				$queryString = strtoupper_utf8($_POST['queryString']);
				$name=str_replace($queryString,"<span class=\"red\">".$queryString."</span>",$name);
				$dcod=dcoidfo($row_rs1['exp'],$row_rs1['fecha']);
				$name2 = "<span class=\"min\" style=\"color:#999;\">".dftipo($row_rs1['td_tipos_id'])." ".$dcod.$sptab."|".$sptab.$fech."</span>";
				$name2 = $name2."<br>Asunto: ".$name;
				if($row_rs1['id']!=""){
					echo "<li style=\"margin-bottom:5px !important;\" onClick=\"location.href='td_verfolio.php?pk=".$row_rs1['folioext_id']."'\">".$name2.'</li>';
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