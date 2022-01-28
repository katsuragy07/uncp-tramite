<?php 
require_once('../Connections/cn1.php');
require_once('../includes/functions.php');
if(isset($_POST['queryString'])) {
	$queryString = ($_POST['queryString']);	
	$queryOfice = ($_POST['queryOfice']);	
	if(strlen($queryString) >0){		
		mysql_select_db($database_cn1, $cn1);
		$query = "SELECT log_archivo_int.*
		,(SELECT CONCAT(empleado.apellido,', ',empleado.nombre) FROM empleado WHERE empleado.id = log_archivo_int.empid LIMIT 1) AS enombre
		,(SELECT CONCAT(lugares.nombre,' | ',oficinas.nombre) FROM oficinas,lugares,log_archivo_int WHERE oficinas.id=log_archivo_int.c_oficina AND oficinas.lugares_id=lugares.id AND oficinas.id = '$varssess' LIMIT 1)AS onombre
		,(SELECT folioint.firma FROM folioint WHERE folioint.id=log_archivo_int.folioint_id LIMIT 1) AS firma
		,(SELECT folioint.asunto FROM folioint WHERE folioint.id=log_archivo_int.folioint_id LIMIT 1) AS asunto
		,(SELECT folioint.obs FROM folioint WHERE folioint.id=log_archivo_int.folioint_id LIMIT 1) AS obser
		,(SELECT folioint.urgente FROM folioint WHERE folioint.id=log_archivo_int.folioint_id LIMIT 1) AS urgente
		,(SELECT folioint.id FROM folioint WHERE folioint.id=log_archivo_int.folioint_id LIMIT 1) AS foid
		,(SELECT folioint.cabecera FROM folioint WHERE folioint.id=log_archivo_int.folioint_id LIMIT 1) AS cabecera
		,(SELECT folioint.`exp` FROM folioint WHERE folioint.id=log_archivo_int.folioint_id LIMIT 1) AS `exp`
		,(SELECT folioint.td_tipos_id FROM folioint WHERE folioint.id=log_archivo_int.folioint_id LIMIT 1) AS td_tipos_id
		,(SELECT folioint.nfolios FROM folioint WHERE folioint.id=log_archivo_int.folioint_id LIMIT 1) AS nfolios
		,(SELECT folioint.file FROM folioint WHERE folioint.id=log_archivo_int.folioint_id LIMIT 1) AS ofile
		,(SELECT folioint.ext FROM folioint WHERE folioint.id=log_archivo_int.folioint_id LIMIT 1) AS oext
		,(SELECT folioint.size FROM folioint WHERE folioint.id=log_archivo_int.folioint_id LIMIT 1) AS osize
		FROM log_archivo_int INNER JOIN  folioint ON folioint.id = log_archivo_int.folioint_id
		WHERE log_archivo_int.c_oficina = $queryOfice
		AND log_archivo_int.tipo = 1
		AND (SELECT folioint.id FROM folioint WHERE folioint.id=log_archivo_int.folioint_id LIMIT 1) IS NOT NULL
		AND
		
		(
				CONCAT(folioint.td_tipos_id, folioint.exp,YEAR(folioint.fecha)) LIKE '%$queryString%' OR
				folioint.asunto LIKE '%$queryString%' OR
				folioint.firma LIKE '%$queryString%' OR
				folioint.obs LIKE '%$queryString%'		
		)
		
		ORDER BY log_archivo_int.fecha DESC LIMIT 20;";		
		
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
					echo "<li style=\"margin-bottom:5px !important;\" onClick=\"location.href='tdin_verfolio.php?pk=".$row_rs1['folioint_id']."'\">".$name2.'</li>';
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