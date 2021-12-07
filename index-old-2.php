<?php require_once('Connections/cn1.php'); ?>
<?php require_once('core/encript.php'); ?>
<?php
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
   ?>
<?php
   // *** Validate request to login to this site.
   $caid = session_id();
   if(empty($caid)){
    session_name("_tambosid");
    session_start();
   }
   
   $loginFormAction = $_SERVER['PHP_SELF'];
   
   if (isset($_POST['nombre'])) {
     $loginUsername=$_POST['nombre'];
     $password=$_POST['pass'];
     $MM_fldUserAuthorization = "level";
     $MM_redirectLoginSuccess = "check.php";
     $MM_redirectLoginFailed = "error.php";
     $MM_redirecttoReferrer = false;
     mysql_select_db($database_cn1, $cn1);
      
     $LoginRS__query=sprintf("SELECT nombre, pass, level FROM users WHERE nombre=%s AND pass=%s",
     GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
      
     $LoginRS = mysql_query($LoginRS__query, $cn1) or die(mysql_error());
     $loginFoundUser = mysql_num_rows($LoginRS);
     if ($loginFoundUser) {
       
       $loginStrGroup  = mysql_result($LoginRS,0,'level');
       
    if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
       //declare two session variables and assign them
       $_SESSION['MM_Username'] = $loginUsername;
       $_SESSION['MM_UserGroup'] = $loginStrGroup;        
   
       if (isset($_SESSION['PrevUrl']) && false) {
         $MM_redirectLoginSuccess = $_SESSION['PrevUrl']; 
       }
       header("Location: " . $MM_redirectLoginSuccess );
     }
     else {
       header("Location: ". $MM_redirectLoginFailed );
     }
   }
   ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <title>Login - SISTRAM</title>
      <link rel="shortcut icon" href="images/favicon.ico" />
      <style type="text/css" href=""></style>
      <style>
         html, body{margin:0;padding:0;height:100%;}
         body{font-family:Tahoma, Arial, sans-serif;font-size:11pt;font-weight:normal;
         text-decoration:none;color:#000000;padding:0px;margin:0px;
         background-image: url(images/FONDO.jpg); background-repeat: no-repeat;background-size: cover;
         }
         a{color:#fff;text-decoration:none;}a:hover{text-decoration:underline;}
         #container{
         display:table;height:100%;width:100%;margin:0;}
         #content{display:table-cell;vertical-align:middle;position:relative;}#inner{width:550px;margin:0 auto;padding:0px;text-align:center;}.logue{background:transparent url() no-repeat center top;width:550px;height:350px;}* html #content{top:50%;left:0;height:1px;}* html #content #inner{position:relative;top:-50%;}
         form{color:#000;text-align:center;margin-left: 2px;}fieldset{border:none;padding:5px}div.medidas{margin:3px 0 0 0;}div.medidas2{margin:3px 0 6px 0;color:#007EA6; font-weight:bold; font-size:14px;}div.medidas input{width:250px;color:#000;border:1px solid #bbb;font-size:12pt;padding:2px 5px 2px 5px;margin:0;}input#login{width:261px;height:32px;margin:0 0 5px 0;border:none;background:transparent url(images/bott_1.jpg) no-repeat center;font-weight:bold;}input#login:hover{background:transparent url(images/bott_1b.jpg) no-repeat center;color:#fff;}
         .desc{font-size:12px;width:260px;right:20px;color:#fff;}
         .infos{font-size:14px;
         font-weight:bold;
         top:250px;
         width:220px;left:20px;color:#fff;}
         #formulario{
         width:310px;
         
         }
      </style>
   </head>
   <body>
      
      <div id="container">
         <div id="content">
            <div id="inner">
               <div class="logue">
                  <div id="formulario">
                     <?php if(!isset($_SESSION['MM_Username'])){?>
                      <table >
         <tr>
            <td>
               <table  width="100%">
                  <tr>
                     <td><img src="images/escudo.png" width="200"></td>
                  </tr>
                  <tr>
                     <td>
                       <center><div class="infos" style="background-color: #fa7600; border-radius: 15px 15px 15px 15px;padding: 5px;">Si tiene problemas para ingresar al sistema, comuníquese con el Área de Soporte Técnico</div></center>
                     </td>
                  </tr>
               </table>
            </td>
            <td style="background-color:rgb(209 164 71);border-radius: 15px 15px 15px 15px;
   opacity:0.8;">
              
              <form name="auth" method="POST" action="<?php echo $loginFormAction; ?>">
                        <fieldset>
                           <div class="medidas2">Acceso restringido<br>Solo personal autorizado</div>
                           <br>
                           <div class="medidas">
                              <input type="text" id="nombre" name="nombre" autocomplete="off" value="" onFocus="this.style.background='#fff';" onBlur="cfond();"/>
                           </div>
                           <div class="medidas">
                              <input type="password" id="pass" name="pass" autocomplete="off"  value="" onFocus="this.style.background='#fff';" onBlur="cfond();"/>
                           </div>
                        </fieldset>
                        <div class="medidas"><input type="submit" id="login" value="Ingresar"></div>
                     </form>
                   
            </td>
         </tr>
         <tr>
            <td><div>
                        <a href="mesapartes/nuevo.php" target="_blank"><img src="images/mesadepartes.gif"  height="80"></a>
                     </div></td>
            <td> <div class="desc" style="background-color: #30a90e; border-radius: 15px 15px 15px 15px;padding: 5px;">
                     <div style="clear:both;height:20px;">
                     </div >
                     Acceso con protección, si no cuenta con un usuario no intente acceder a esta sección.<br /><br />Por motivos de seguridad se estará almacenando la dirección IP de su computadora y <strong>con 6 intentos fallidos su IP será bloqueada.</strong>
                     <?php }else{?>
                     <form action="" method="get">
                        <div class="medidas2">
                           <div style="clear:both;height:30px;"></div>
                           Estas conectado como:<br> <?php echo $_SESSION['u_nombre'];?>
                        </div>
                        <input name="Button" type="button" id="login" value="Ir al Panel del Sistema" onclick="location.href='ui/'"><input name="Button" type="button" id="login" value="Desconectarme" onclick="location.href='logout.php'">
                        <div style="clear:both;height:40px;"></div>
                     </form>
                  </div>
                  <div class="desc">Si ve esta pantalla significa que su sesión de usuario se encuentra abierta.<br> Pulse el boton <strong>&quot;Ir al Panel del Sistema&quot;</strong> para ingresar al sistema.<br /><br /><strong>Si ya no desea seguir usando el sistema, no olvide desconectarse de su cuenta.</strong></div></td>
         </tr>
      </table>
                     
                     
                  </div>
                  
                 
                  <?php }?>
               </div>
            </div>
         </div>
      </div>
      <?php if(!isset($_SESSION['MM_Username'])){?>
      <script type="text/javascript">
         cfond();
         function cfond(){
         if(document.forms[0].nombre.value=="")
          document.forms[0].nombre.style.background='#fff url(images/tb_0.gif) no-repeat left';
         if(document.forms[0].pass.value=="")
          document.forms[0].pass.style.background='#fff url(images/tb_1.gif) no-repeat left';
         
         }
      </script>
      <?php }?>
   </body>
</html>