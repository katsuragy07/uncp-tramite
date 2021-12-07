<?php
include '../../Connections/cn1.php';
error_reporting(E_ALL);
ini_set('display_errors',1);
$opcion=$_POST['opcion'];
switch ($opcion) {
    case 'cuenta':
            $contra=$_POST['contra'];
            $email=$_POST['email'];
            
            $sql="SELECT * FROM `vecino` WHERE email='$email'";
            $resultado=mysql_query($sql, $cn1);
		    $numero=mysql_num_rows($resultado);
		   
		    
		    if($numero>0){
		        $sql1="UPDATE `vecino` SET `Password`='$contra',`estatus`=1 WHERE email='$email'";
	            $resultado1=mysql_query($sql1,$cn1);
	            if($resultado1){
		            echo 1;
		            //si todo esta bien
	            }else{
		            echo 2;
		            //si esta mal
	            }
		    }else{
		        echo 4;
		        //cuando el correo no esta registrado
		    }
		        

	
	break;
  
	case 'ingresar':
	 	$email=$_POST['email'];
	 	$contra=$_POST['pcontra'];
	 	
	 	$U=explode('@',$email);
        //var_dump($U[1]);
        if($U[1]=="uncp.edu.pe"){
            $cor1="uncp.edu.pe";
        }else{
            $cor1=$U[1];
        }
        $final=$U[0]."@".$cor1;
        
	 	$sql="SELECT * FROM `vecino` WHERE `email`='$final' and `Password`='$contra'";
		$resultado=mysql_query($sql, $cn1);
	
		$fila = mysql_fetch_row($resultado);
		$numero=mysql_num_rows($resultado);
		$stado=$fila[8];
		
				if ($numero==1){
					if($stado==0){
						echo 2;
					}else{
						$datos=mysql_query($sql, $cn1);
						if($datos){
                          	session_start();
						    $_SESSION['positivo']   = true;	

$_SESSION['actividad']      =time();
$fila = mysql_fetch_assoc($datos);
							echo json_encode($fila,JSON_UNESCAPED_UNICODE);
						}
					}
				}else{
					echo 0;
				}
		
	break;
	case 'validar':
	
		$nombre=$_POST['nombre'];
		$apellido=$_POST['apellidos'];
		$edad=$_POST['edad'];
		$mail=$_POST['mail'];
		$sexo=$_POST['cbsexo'];


        $U=explode('@',$mail);
        //var_dump($U[1]);
        if($U[1]=="uncp.edu.pe"){
            $cor1="uncp.edu.pe";
        }else{
            $cor1=$U[1];
        }
        $final=$U[0]."@".$cor1;

		$sql="SELECT * FROM `vecino` WHERE `email`='$final'";
		$resultado=mysql_query($sql, $cn1);
		$fila = mysql_fetch_row($resultado);
		$numero=mysql_num_rows($resultado);

		if($numero==0){
			//cuando el correo no existe
			$sql_nuevoexp="SELECT * FROM vecino ORDER BY id DESC limit 1";
			$resultado1=mysql_query($sql_nuevoexp, $cn1);
			$fila1 = mysql_fetch_row($resultado1);
			$resultadonumero1=$fila1[0];
			if(is_null($resultadonumero1)){
				$idnuevo=1;
			}else{
				$idnuevo=$fila1[0]+1;
			}
			
			$codigo=substr(md5(uniqid()), 0, 5);
			$valor=$idnuevo.$codigo;





			$sql2="INSERT INTO `vecino`(`id`, `nombre`, `apellidos`, `sexo`, `edad`, `email`, `Password`, `codigodeactivacion`, `estatus`) VALUES ($idnuevo,'$nombre','$apellido','$sexo',$edad,'$final',NULL,'$valor',0)";
			$sentencia2=mysql_query($sql2, $cn1);
			
			if($sentencia2){
 
					$asunto = "Validacion de cuenta"; 
					$cuerpo = ' 
						<html> 
							<head> 
   								<title>Universidad Nacional del Centro del Peru</title> 
							</head> 
							<body> 
								<h1>GESDOC!</h1> 
								<p> 
								<b>Bienvenidos al Sistema de Gestion Documentaria</b>. Por cuestiones de seguridad usted tendra que activar su cuenta para poder utilizar el sistema. <br>
									Para activar su cuenta haga click en el siguiente enlace <br> 
									<a href="http://gestionuncp.edu.pe/tramite/vecinos/validar/activar.php?key='.$valor.'">Activar cuenta</a> 
								</p>  	
							</body> 
						</html>'; 
						//para el envío en formato HTML 
					$headers = "MIME-Version: 1.0\r\n"; 
					$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
					$headers .= "From: Universidad Nacional del Centro del Peru <mesadepartes@uncp.edu.pe>\r\n"; 
					mail($final,$asunto,$cuerpo,$headers);
					echo 2;
					//cuando todo esta bien
			}else{
				echo 3;
				//error al insertar
			}
		}else{
			echo 4;
			//cuando el correo ya esta en uso;
		}
break;
  case 'activar':
 $contra=$_POST['pw'];
 $key=$_POST['key'];

	$sql="UPDATE `vecino` SET `Password`='$contra',`estatus`=1 WHERE `codigodeactivacion`='$key'";
	$resultado=mysql_query($sql,$cn1);
	if($resultado){
		echo 1;
		//si todo esta bien
	}else{
		echo 2;
		//si esta mal
	}
	break;
  case 'verificarcorreo':

		$mail=$_POST['correo'];
		
		$U=explode('@',$mail);
        //var_dump($U[1]);
        if($U[1]=="uncp.edu.pe"){
            $cor1="uncp.edu.pe";
        }else{
            $cor1=$U[1];
        }
        $final=$U[0]."@".$cor1;
		
		$sql="SELECT * FROM `vecino` WHERE `email`='$final'";
		$resultado=mysql_query($sql, $cn1);
		$fila = mysql_fetch_row($resultado);
		$numero=mysql_num_rows($resultado);
  
		

		if($numero==0){
			echo 2;
			//cuando el correo no existe
		}else if($numero>0){
					$valor=$fila[7];

          	
          
			$asunto = "Recuperar Contraseña";
			$asunto="=?UTF-8?B?".base64_encode($asunto)."=?=";
					$cuerpo = ' 
						<html> 
							<head> 
   								<title>Universidad Nacional del Centro</title> 
							</head> 
							<body> 
								<h1>GESDOC!</h1> 
								<p> 
								<b>Bienvenidos a GESDOC UNCP</b>. Se solicito restablecer su clave de acceso desde el sistema de tramite virtual de la UNCP si no fue usted ignore este mensaje. <br>
									Para restrablecer su clave de acceso haga click en el enlace<br> 
									<a href="http://gestionuncp.edu.pe/tramite/vecinos/validar/restablecer.php?key='.$valor.'">Restablecer Clave de Acceso</a>
								</p>  	
							</body> 
						</html>'; 
						//para el envío en formato HTML 
					$headers = "MIME-Version: 1.0\r\n"; 
					$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
					$headers .= "From: Universidad Nacional del Centro del Peru <mesadepartes@uncp.edu.pe>\r\n"; 
					mail($final,$asunto,$cuerpo,$headers);
					echo 1;
					//todo bien

		}
	break;
  case 'resstablecer':
		$contra=$_POST['pw'];
 		$key=$_POST['key'];

	$sql="UPDATE `vecino` SET `Password`='$contra' WHERE `codigodeactivacion`='$key'";
	
	
	$resultado=mysql_query($sql,$cn1);
	if($resultado){
		echo 1;
		//si todo esta bien
	}else{
		echo 2;
		//si esta mal
	}
		break;
  
}
?>

