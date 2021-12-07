<?php
include '../../Connections/cn1.php';

error_reporting(E_ALL);
ini_set('display_errors',1);

$opcion=$_POST['opcion'];
switch ($opcion) {
	case 'verificar':
		$dato=$_POST['dato']."-".date("Y");
		$sql="SELECT  numerorecibo FROM `folioext` WHERE numerorecibo='$dato'";

		$resultado=mysql_query($sql, $cn1);
		$fila = mysql_fetch_row($resultado);
		$resultadonumero=$fila[0];
		if(is_null($resultadonumero)){
			echo 0;
		}else{
			echo 1;
		}
	break;
	case 'nuevo':
        
		$tipodoc=$_POST['td_tipos_id'];
		$cabecer=$_POST['cabecera'];
		$asunto=$_POST['asunto'];
		$firma=$_POST['firma'];
		$nfolios=$_POST['nfolios'];
		$oficina="113";
		$observaciones=$_POST['obs'];
		$id=$_POST['id'];
		$fecha=$_POST['fecha'];
		$empleadoid=$_POST['empid'];
		$user=$_POST['user'];
		$pago=isset($_POST['pago'])? $_POST['pago']: '';
		$numerorecibo=isset($_POST['numerorecibo'])? $_POST['numerorecibo']."-".date("Y"):null;
		$urgente=0;

		$sql_nuevoid="SELECT id FROM `folioext` ORDER BY id DESC limit 1";
		$resultado=mysql_query($sql_nuevoid, $cn1);
		$fila = mysql_fetch_row($resultado);
		$resultadonumero=$fila[0];

		if(is_null($resultadonumero)){
			$nuevoid=1;
		}else{
			$nuevoid=$fila[0]+1;	
		}
		

		$sql_nuevoexp="SELECT exp FROM `folioext` ORDER BY exp DESC limit 1";
		$resultado1=mysql_query($sql_nuevoexp, $cn1);
		$fila1 = mysql_fetch_row($resultado1);
		$resultadonumero1=$fila1[0];
		if(is_null($resultadonumero1)){
			$nuevoexp=1;
		}else{
			$nuevoexp=$fila1[0]+1;
		}
		


		$extension=pathinfo($_FILES['archivo']['name'],PATHINFO_EXTENSION);
		$size=$_FILES['archivo']['size'];
		$size1=$size." bytes";

		$rutaservidor='./../../data/tdex_adjuntos/';
		$rutatemporal=$_FILES['archivo']['tmp_name'];
		$nombre=md5(uniqid(rand(), true));
		$rutadestino=$rutaservidor.$nombre.".".$extension;
		move_uploaded_file($rutatemporal, $rutadestino);
		$nombrefinal=$nombre.'.'.$extension;
 
		$sql="INSERT INTO `folioext`(`id`, `exp`, `asunto`, `firma`, `nfolios`, `fecha`, `user`, `empid`, `c_oficina`, `obs`, `file`, `ext`, `size`, `cabecera`, `env`, `aid`, `atendido`, `td_tipos_id`, `pago`,`numerorecibo`,`urgente`) VALUES ($nuevoid,$nuevoexp,'$asunto','$firma','$nfolios','$fecha','vecino',532,$oficina,'$observaciones','$nombrefinal','$extension','$size1','$cabecer',null,null,null,'$tipodoc','$pago','$numerorecibo','$urgente')";
		$sentencia=mysql_query($sql, $cn1);
		
		if($sentencia){
			$sql2="INSERT INTO `log_derivar`(`id`, `tipo`, `forma`, `obs`, `fecha`, `user`, `empid`, `d_oficina`, `atendido`, `recibido`, `file`, `ext`, `size`, `provei`, `c_oficina`, `folioext_id`) VALUES (null,0,0,'$observaciones','$fecha','vecino',532,'$oficina',null,null,null,null,null,null,'$oficina',$nuevoid)";
			$sentencia2=mysql_query($sql2, $cn1);
			if($sentencia2){
					$sql_barcdode="SELECT folioext.* ,(SELECT CONCAT(empleado.apellido,', ',empleado.nombre) FROM empleado WHERE folioext.empid=empleado.id)AS enombre ,(SELECT CONCAT(lugares.nombre,' | ',oficinas.nombre) FROM oficinas,lugares,folioext WHERE oficinas.id=folioext.c_oficina AND oficinas.lugares_id=lugares.id LIMIT 1) AS conombre ,(SELECT oficinas.nombre FROM oficinas WHERE oficinas.id = folioext.c_oficina LIMIT 1)AS onombre FROM folioext WHERE folioext.id=$nuevoid";
					$datos=mysql_query($sql_barcdode, $cn1);
					if($datos){
						$fila = mysql_fetch_assoc($datos);
						print json_encode($fila,JSON_UNESCAPED_UNICODE);
					}

			}

		}
	break;
	
	default:
		# code...
		break;
}
?>