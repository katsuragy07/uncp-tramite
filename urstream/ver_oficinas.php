<?php require_once('../Connections/cn1.php'); ?>
<?php require_once('../includes/functions.php'); ?>
<?php require_once('../includes/permisos_all_ui.php'); ?>
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

mysql_select_db($database_cn1, $cn1);
$query_rs2 = "SELECT empleado.* 
,(SELECT nombre FROM oficinas WHERE id=empleado.oficinas_id) AS oficina
,(SELECT lugares.nombre FROM lugares,oficinas WHERE oficinas.id=empleado.oficinas_id AND lugares.id=oficinas.lugares_id) AS lugar
FROM empleado ORDER BY 
lugar ASC, oficina ASC, 
apellido ASC";
$rs2 = mysql_query($query_rs2, $cn1) or die(mysql_error());
$row_rs2 = mysql_fetch_assoc($rs2);
$totalRows_rs2 = mysql_num_rows($rs2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Intranet</title>
<link href="../css/int.css" rel="Stylesheet" type="text/css" />

<link href="wall.css" type="text/css" rel="stylesheet" />
<link type="text/css" href="fb/stylesheet.css" rel="stylesheet">

</head>
<body>


<div id="container"><div id="wpag">
	<div id="content">
    
    

<div class="btam">

<div class="rbbtn botimg" id="uit" style="margin-right:3px;"><a  href="#" onClick="location.reload();">
<span class="icon ico_big" style="background-position:-25px -135px"></span>
<div class="botimg_con"><strong>Refrescar</strong><br/>
<span>p&aacute;gina</span></div>
</a></div>


<div class="rbbtn botimg" id="uit" style="margin-right:0px;"><a href="mywall.php">
<span class="icon ico_big" style="background-position:-25px -111px"></span>
<div class="botimg_con"><strong>Mensajes</strong><br/>
  <span>En mi muro</span></div>
</a></div>

<div class="rbbtn botimg" id="uit" style="margin-right:3px;"><a href="index.php">
<span class="icon ico_big" style="background-position:0px -111px"></span>
<div class="botimg_con"><strong>Noticias</strong><br/>
<span>En general</span></div>
</a></div>

</div>

<h1>Intranet</h1>

<div class="hr"><em></em><span></span></div>

<div class="clear" style="height:5px"></div>


<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>


<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">
    <h2>Todas las oficinas</h2>
    <h3>Lista de personas que laboran</h3>
    
    <div class="clear" style="height:3px"></div>
    
<table width="90%" border="0" cellpadding="0" cellspacing="0" class="tabla2">
          <tr>
            <td width="20" align="center" class="btit_1">#</td>
            <td class="btit_1">Local</td>
            <td class="btit_1">Oficina</td>
            <td class="btit_1">Apellidos y Nombres</td>
            <td class="btit_1">E-mail</td>
            </tr>
          <?php $cont=0; ?>
          
          <?php if ($totalRows_rs2 > 0) { // Show if recordset not empty ?>
          <?php do { ?>
          <?php $cont++; ?>
            <tr>
              <td width="20" align="center"><?php echo $cont; ?></td>
              <td><span class="min"><?php echo $row_rs2['lugar']; ?></span></td>
              <td><span class="min"><?php echo $row_rs2['oficina']; ?></span></td>
              <td><a href="ver_wall.php?pk=<?php echo $row_rs2['id']; ?>"><?php echo $row_rs2['apellido'].", ".$row_rs2['nombre']; ?></a></td>
              <td><?php echo dbla($row_rs2['mail']); ?></td>
              </tr>
            <?php } while ($row_rs2 = mysql_fetch_assoc($rs2)); ?>
            <?php } // Show if recordset not empty ?>
</table>
     
     
     
     
     
     
     
      </td>
    <td width="20" valign="top">&nbsp;</td>
    <td width="250" valign="top">
<div class="btit_2"><?php echo $_SESSION['u_nombre']; ?></div>
<div class="bcont"  style="background-color:#FFF;border:1px solid #CCC;border-top:none;">
<img src="../data/users/<?php echo $_SESSION['u_foto']; ?>" class="CommentImg" style="float:left;" width="225" alt="" />
<div class="clear"></div>
</div>
    
    
    
    <h2>Opciones</h2>



<div class="btit_2">Acciones</div>
<div class="bcont">

<div class="spacer"><a href="#" onClick="location.reload();"><div class="skin left" style="background-position:-80px -63px;margin-right:3px;"></div>Refrescar p&aacute;gina</a></div>

<div class="spacer"><a href="../modulos/account.php" >
          <div class="skin left" style="background-position:-96px 0px;margin-right:3px;"></div>
          Configurar mi cuenta</a></div>


</div>

<div class="btit_2">Buscar personas</div>
<div class="bcont">

<div class="spacer"><a href="ver_mioficina.php"><div class="skin left" style="background-position:-96px -63px;margin-right:3px;"></div>
Dentro de mi oficina</a></div>
<div class="spacer"><a href="ver_oficinas.php" >
  <div class="skin left" style="background-position:-96px -63px;margin-right:3px;"></div>
  En todas las Oficinas</a></div>
</div>


<div class="btit_2">Temas de ayuda</div>
<div class="bcont">

<div class="spacer"><a href="../modulos/help.php" >
          <div class="skin left" style="background-position:0px -16px;margin-right:3px;"></div>
          Interf&aacute;z de usuario</a></div>
          <div class="spacer"><a href="../help/acerca.php" >
          <div class="skin left" style="background-position:0px -16px;margin-right:3px;"></div>
          Acerca del sistema</a></div>
          
</div>


</td>
  </tr>
</table>
</div></div></div>






<div id="popUpDiv" style="display:none;"> 
<a href="javascript:;" onclick="popup('popUpDiv')"><img border="0" src="hide.png" alt="Close" title="Close" /></a> 
<div>
<span></span>
<div id="comment_part"></div>
</div>

</div>


</body>
</html>
<?php
mysql_free_result($rs2);
?>
