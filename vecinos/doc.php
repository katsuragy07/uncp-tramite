<?php require_once('../Connections/cn1.php'); 
session_start();
if($_SESSION['positivo']==true){
    
    if(time()-$_SESSION['actividad'] >300){
        session_destroy();
        header('Location: index.html');
    }
    
$token=$_GET['tokken'];
mysql_select_db($database_cn1, $cn1);
$sqldatoscli="SELECT * FROM vecino WHERE `codigodeactivacion`='$token'";
$resdatos = mysql_query($sqldatoscli, $cn1) or die(mysql_error());
$row_resdatos = mysql_fetch_assoc($resdatos);
$correo=$row_resdatos['email'];

$sql="SELECT * FROM `folioext` WHERE obs='$correo' ";

$datosconsul=mysql_query($sql,$cn1);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/int.css" rel="Stylesheet" type="text/css" />
<style>
#wpag{background:transparent url(../images/pico_5.jpg) no-repeat fixed bottom right;}
</style>
<script type="text/javascript">
  setTimeout(function() {
    window.location.reload();
}, 300000);
</script>
<script src="../scripts/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../scripts/SpryValidationTextarea.js" type="text/javascript"></script>
<script type="text/javascript" src="../scripts/jquery.js"></script>

<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link href="../scripts/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../scripts/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
</head>
<body >

  

<div style="padding-top: 20px;padding-right: 50px;padding-left: 50px;">
  <div class="row " style="padding: 15px; background: #dfedff;">
    <div class="col-md-3">
      <a href="nuevo.php?token=<?php echo $row_resdatos['codigodeactivacion'];?>" style="text-decoration: none;color: black;">
        <img src="../images/unnamed.png" style="width: 25px;"> 
        <span><strong>Nuevo documento</strong></span>
      </a>
    </div>
    <div>
       <a href="doc.php?tokken=<?php echo $row_resdatos['codigodeactivacion'];?>" data-toggle="modal" style="text-decoration: none;color: black;">
         <img src="../images/following.png" style="width: 25px;"> 
          <span><strong>Seguimiento</strong></span>
       </a>
    </div class="col-md-3">  
  </div>
  <div class="row">
   
    <div id="container"><div id="wpag"><div id="content">
  
<h1>Lista de Tramites</h1>
<div class="hr"><em></em><span></span></div>
<br>
<div class="row">
  <div class="col-md-9">
    <div class="row"> 
<?php
                  
                   
                    $sql="SELECT * FROM `folioext` WHERE obs='$correo'";
                    $resultado=mysql_query($sql,$cn1);        
                    $fol_xpersona=12;
                    $total_fol=mysql_num_rows($resultado);
                    $paginas=$total_fol/$fol_xpersona;
                    $paginas=ceil($paginas);

                    
                    if (empty($_GET['pagina'])) {
                      $pagina=1;
                    }else if ($_GET['pagina']>$paginas) {
                      $pagina=1;
                    }
                    else{
                      $pagina=$_GET['pagina'];
                    }
                    $desde=($pagina-1)*$fol_xpersona;
                    $sql_fol=("SELECT * FROM `folioext` WHERE obs='$correo' limit $desde,$fol_xpersona ");
                    
                    $resultado=mysql_query($sql_fol,$cn1);
                    
                  
while ($fila = mysql_fetch_assoc($resultado)){
?>

  <div class="col-md-3">
          <div class="card" >
    <div class="card-body">
      <h4 class="card-title">Expediente: <?php echo $fila['td_tipos_id'].$fila['id']. substr($fila['fecha'],0,4);?></h4>
      <p class="card-text">Asunto:  <br> <?php echo $fila['asunto'];?></p>
      <a href="seguimiento.php?pk=<?php echo $fila['id']?>" class="btn btn-primary stretched-link" target="_blank">Seguimiento</a>
    </div>
  </div>
        </div>

<?php
}
?>
                
    </div>
    <br>
        <div style="margin-left: 480px;"><center>
    <nav aria-label="Page navigation example">
                      <ul class="pagination">
                        <?php if ($pagina<=1) { ?>
                            <li class="page-item disabled">
                                <a class="page-link" href="">&laquo;</a>
                            </li>
                        <?php }else{ ?>
                            <li class="page-item">
                                <a class="page-link" href="?tokken=<?php echo $row_resdatos['codigodeactivacion'];?>&pagina=<?php echo $pagina-1; ?>">&laquo;</a>
                            </li>
                        <?php } ?>
                        

                        <?php for ($i=1; $i <= $paginas ; $i++) { ?>
                            <li class="page-item <?php echo $pagina==$i? 'active': ''; ?>">
                                <a class="page-link" href="?tokken=<?php echo $row_resdatos['codigodeactivacion'];?>&pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                       <?php } ?>
                        
                        <?php if ($pagina>=$paginas) { ?>
                            <li class="page-item disabled">
                                <a class="page-link" href="">&raquo;</a>
                            </li>
                        <?php }else{ ?>
                            <li class="page-item">
                                <a class="page-link" href="?tokken=<?php echo $row_resdatos['codigodeactivacion'];?>&pagina=<?php echo $pagina+1; ?>">&raquo;</a>
                            </li>
                        <?php } ?>
                        

                      </ul>
                    </nav></center></div>

  </div>
  <div class="col-md-3">
          <div class="btit_2">Acciones</div>
        <div class="bcont">
        
        <div class="spacer"><a href="logout.php" >
          <div class="skin left" style="background-position:-48px -79px;margin-right:3px;"></div>
          Cerrar sesion</a></div>
        </div>
        <div class="btit_2">Informaci&oacute;n</div>
        <div class="bcont2">Se muestra la lista de Tramites solicitados para ver el seguimiento debe hacer click en uno de ellos.</div>
  </div>
</div>
</div></div></div>
  </div>
</div>




<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="js/popper.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/JsBarcode.all.min.js"></script>

</body>
</html>
<?php
}else{
  header('Location: validar/index.html');
}
?>
