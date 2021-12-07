<!DOCTYPE html>
<?php
$key=$_GET['key'];
?> 
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>GESDOC - Activacion de Cuenta Via Email</title>
    <link rel="stylesheet" href="css/jquery-ui.css" />
	<link rel="stylesheet" href="css/estilo.css" />
	<link rel="stylesheet" href="css/bootstrap.css" />
    
</head>
<body>
<center>
	<form name="formulario" id="formulario" method="post" action="">
	<table width="50%">
		<tr>
			<td><br/><div id="mensaje"></div></td>
		</tr>
		<tr>
			<td><center>
				<table border=0 class="ventanas" width="70%">
					<tr>
    				  <td colspan="2" class="tabla_ventanas_login" height="10"><legend align="center">::: Restablecer contraseña ::: </legend></td>
					</tr>
					<tr><td colspan=2><br/></td></tr>
					<tr>
						<td colspan=2><center>
							<table>
								<tr>
								<td align="right">Contraseña: </td><td><input type="password" class="caja"  name="pas" id="pas" /></td>
								</tr>
								<tr>
								<td align="right">Repetir contraseña: </td><td><input type="password" class="caja"  name="pas1" id="pas1" /></td>

								<td align="right"></td><td><input type="hidden" class="caja"  value="<?php echo $key;?>" name="key" id="key" /></td>
								</tr>
								
								<tr><td colspan=2><center><input type="submit" id="guarda" name="guarda" class="btn btn-sm btn-success" value="Restablecer Contraseña" /></center></td></tr>

							</table>
						</center>
						</td>
					</tr>
					
				   </table>
				</center>
			</td>
		</tr>

	</table>
	</form>
   
 </center>
 <script src="js/jquery-1.8.2.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script>
	$(document).ready(function(){
		$('#formulario').on('submit', function(e){
    			e.preventDefault();
    			var opcion="resstablecer";
    			var pw = $.trim($('#pas').val());
    			var pw1 = $.trim($('#pas1').val());
    			var key = $.trim($('#key').val());
    			
    			
    			if(pw.length==0 || pw1.length==0 ){
    				alert("todos los campos son obligatorios");
    			}else{
    				if(pw === pw1){
    					$.ajax({
            	   			url: "../controlador/validar.php",
              				type: "POST",
              				datatype:"json",    
              				data:  {pw:pw,key:key,opcion:opcion},
        					}).done(function(resp){
           						if(resp==1){
           							alert("Contraseña restablecida");
           							window.location.href="index.html";
           						}else{
           							alert("error");
           						}
            				});

    				}else{
    						alert("las contraseñas no coinciden");	
    				}
    			}				
    	});
	});
    </script>
</body>
</html>