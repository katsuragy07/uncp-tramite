<?php 
require_once('../Connections/cn1.php');
require_once('../includes/functions.php');
if(isset($_POST['queryString'])) {
	$queryString = ($_POST['queryString']);	
	if(strlen($queryString) >0){		
		mysql_select_db($database_cn1, $cn1);
		$query = "SELECT folioext.*
		,(SELECT CONCAT(empleado.apellido,', ',empleado.nombre) FROM empleado WHERE empleado.id = folioext.empid LIMIT 1) AS enombre
		,(SELECT CONCAT(lugares.nombre,' | ',oficinas.nombre) FROM oficinas,lugares,folioext WHERE oficinas.id=folioext.c_oficina AND oficinas.lugares_id=lugares.id LIMIT 1)AS onombre
		FROM folioext
		WHERE
		
		CONCAT(folioext.td_tipos_id, folioext.exp,YEAR(folioext.fecha)) LIKE '%$queryString%' OR
		folioext.asunto LIKE '%$queryString%' OR
		folioext.firma LIKE '%$queryString%' OR
		folioext.obs LIKE '%$queryString%'		
		
		ORDER BY folioext.fecha DESC
		LIMIT 10";		
		
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