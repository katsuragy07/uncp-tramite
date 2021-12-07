<?php require_once('../Connections/cn1.php'); ?>
<?php require_once('../includes/functions.php'); ?>
<?php require_once('../includes/functions.php'); ?>
<?php require_once('../includes/permisos_all_ui.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

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
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO msg (id, obs, `user`, empid, fecha, sis) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['user'], "text"),
                       GetSQLValueString($_POST['empid'], "int"),
                       GetSQLValueString($_POST['fecha'], "date"),
                       GetSQLValueString($_POST['sis'], "int"));

  mysql_select_db($database_cn1, $cn1);
  $Result1 = mysql_query($insertSQL, $cn1) or die(mysql_error());

  $insertGoTo = "main.php?ok=1";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));

}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/int.css" rel="Stylesheet" type="text/css" />
<style>
#wpag{background:transparent url(../images/pico_0.jpg) no-repeat fixed bottom right;}
</style>

<script src="../scripts/SpryValidationTextarea.js" type="text/javascript"></script>
<script type="text/javascript">function dlitem(ord){if(confirm("Deseas eliminar este registro?")){document.location.href= '../opers/del_perso.php?pk='+ord;}}</script> 

<link href="../scripts/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container"><div id="wpag"><div id="content">

<?php if($_SESSION['u_sis']!=1){ ?>
<div class="btam">

<div class="rbbtn botimg" id="uit" style="margin-right:3px;"><a  href="#" onClick="location.reload();">
<span class="icon ico_big" style="background-position:-25px -135px"></span>
<div class="botimg_con"><strong>Refrescar</strong><br/>
<span>p&aacute;gina</span></div>
</a></div>


<div class="rbbtn botimg" id="uit" style="margin-right:3px;"><a href="../urstream/index.php">
<span class="icon ico_big" style="background-position:-25px -111px"></span>
<div class="botimg_con"><strong>Noticias</strong><br/>
<span>Intranet</span></div>
</a></div>

</div>
<?php } ?>


<h1>Universidad Nacional del Centro del Peru</h1>
<div class="hr"><em></em><span></span></div>

<div class="clear" style="height:5px"></div>
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>


<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">
    <h2>Sistema de Tr&aacute;mite Documentario</h2>
    <h3>Bienvenido: <?php echo $_SESSION['u_nombre']; ?></h3>
    <div class="clear" style="height:5px"></div>
    <div style="border-top:1px solid #fff;border-bottom:1px solid #E1E5E8;"></div>
    <div class="clear" style="height:5px"></div>
    <h4>Enviar mensaje al sistema</h4>
<?php if(!$_GET['ok']==1){ ?>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
<tr valign="baseline">
<td width="100" align="right" valign="middle" class="btit_3">Escriba su mensaje</td>
<td><span id="sprytextarea1">
  <textarea name="obs" rows="3" class="tbox2" id="obs"><?php echo $row_rs1['obs']; ?></textarea>
  </span></td>
</tr>
<tr valign="baseline">
<td width="100">&nbsp;</td>
<td><input type="submit" class="but1" value="Enviar"></td>
</tr>
</table>
<input type="hidden" name="id" value="">
<input type="hidden" name="empid" value="<?php echo $_SESSION['u_empid']; ?>">
<input type="hidden" name="sis" value="<?php echo $_SESSION['u_sis']; ?>">
<input type="hidden" name="fecha" value="<?php echo date("Y-m-d H:i:s");?>">
<input type="hidden" name="user" value="<?php echo $_SESSION['u_id']; ?>">
<input type="hidden" name="MM_update" value="form1" />
<input type="hidden" name="MM_insert" value="form1" />
</form>
<?php }else{ ?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr valign="baseline">
<td width="150" valign="middle"><img src="../images/alert.png" width="120" height="111" /></td>
<td valign="middle"><h3>Su mensaje fue enviado correctamente</h3>
<div class="bcont">
  <div class="spacer"><a href="../modulos/main.php" >
<div class="skin left" style="background-position:-96px -63px;margin-right:3px;"></div>
Mandar otro mensaje</a></div>
</div></td>
</tr>
</table>
<?php } ?>
    <p>Los mensajes enviados sirven para indicar los problemas que tuvo, tambien puede enviar recomendaciones y otros comentarios con respecto al funcionamiento del sistema. Estos mensajes serán vistos por el Administrador y podrá realizar los cambios respectivos.</p>
    <div class="clear" style="height:5px"></div>
    <div style="border-top:1px solid #fff;border-bottom:1px solid #E1E5E8;"></div>
    <div class="clear" style="height:5px"></div>
    <h2>Temas de ayuda</h2>
    <div class="spacer"><a href="../modulos/help.php" >
          <div class="skin left" style="background-position:0px -16px;margin-right:3px;"></div>
          Interf&aacute;z de usuario</a></div>
          <div class="spacer"><a href="../help/acerca.php" >
          <div class="skin left" style="background-position:0px -16px;margin-right:3px;"></div>
          Acerca del sistema</a></div>
        </td>
    <td width="20" valign="top">&nbsp;</td>
    <td width="250" valign="top"><h2>Opciones</h2>
        <div class="btit_2">Acciones</div>
        <div class="bcont">
        <div class="spacer"><a href="#" onClick="location.reload();"><div class="skin left" style="background-position:-80px -63px;margin-right:3px;"></div>Refrescar p&aacute;gina</a></div>
        <div class="spacer"><a href="account.php" >
          <div class="skin left" style="background-position:-96px 0px;margin-right:3px;"></div>
          Configurar mi cuenta</a></div>
          </div>
        <div class="btit_2">Informaci&oacute;n</div>
        <div class="bcont">Si desea obtener ayuda para aprender a usar el sistema de un clic en el boton Ayuda de los botones generales (Parte superior derecha).</div>
        </td>
  </tr>
</table>
</div></div></div>

<script type="text/javascript">
<!--
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
//-->
</script>
</body>
</html>
