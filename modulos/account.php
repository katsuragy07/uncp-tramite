<?php require_once('../Connections/cn1.php'); ?>
<?php require_once('../includes/functions.php'); ?>
<?php require_once('../includes/permisos_all.php'); ?>
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

$colname_rs1 = "-1";
if (isset($_SESSION['u_empid'])) {
  $colname_rs1 = $_SESSION['u_empid'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs1 = sprintf("SELECT empleado.*, oficinas.nombre AS onombre FROM empleado, oficinas WHERE empleado.oficinas_id=oficinas.id AND empleado.id= %s ORDER BY oficinas.nombre ASC", GetSQLValueString($colname_rs1, "int"));
$rs1 = mysql_query($query_rs1, $cn1) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
$totalRows_rs1 = mysql_num_rows($rs1);

$colname_rs2 = "-1";
if (isset($_SESSION['u_empid'])) {
  $colname_rs2 = $_SESSION['u_empid'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs2 = sprintf("SELECT * FROM users WHERE empleado_id = %s", GetSQLValueString($colname_rs2, "int"));
$rs2 = mysql_query($query_rs2, $cn1) or die(mysql_error());
$row_rs2 = mysql_fetch_assoc($rs2);
$totalRows_rs2 = mysql_num_rows($rs2);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/int.css" rel="Stylesheet" type="text/css" />
<style>
#wpag{background:transparent url(../images/pico_3.jpg) no-repeat fixed bottom right;}
</style>

<script type="text/javascript">function dlitem(ord){if(confirm("Deseas eliminar este registro?")){document.location.href= '../opers/del_mlocal.php?pk='+ord;}}</script> 

</head>
<body>
<div id="container"><div id="wpag"><div id="content">

<h1>Cuentas de usuario</h1>
<div class="hr"><em></em><span></span></div>

<div class="clear" style="height:5px"></div>
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>
<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">
<h2><?php echo $row_rs1['apellido'].", ".$row_rs1['nombre']; ?></h2>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="49%" valign="top"><h5>Datos personales</h5>
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
        <tr valign="baseline">
          <td width="150" align="right" valign="middle" class="btit_3">Empleado</td>
          <td><?php echo dtitu($row_rs1['sexo'],$row_rs1['tit_tipo'],$row_rs1['tit_otro'])." ".$row_rs1['apellido'].", ".$row_rs1['nombre']; ?></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" class="btit_3">Sexo</td>
          <td><?php echo dsexo($row_rs1['sexo']); ?></td>
        </tr>
        <tr valign="baseline">
          <td width="150" align="right" valign="middle" class="btit_3">E-mail</td>
          <td><?php echo $row_rs1['mail']; ?></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" class="btit_3">Oficina asignada</td>
          <td><?php echo dbla($row_rs1['onombre']); ?></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" class="btit_3">Encargado</td>
          <td><?php echo denca($row_rs1['encargado']); ?></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" class="btit_3">Cargo</td>
          <td><?php echo $row_rs1['cargo']; ?></td>
        </tr>
      </table></td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="49%" valign="top"><h5>Datos de la cuenta</h5>
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
        <tr valign="baseline">
          <td width="150" align="right" valign="middle" class="btit_3">Usuario</td>
          <td><?php echo $row_rs2['nombre']; ?></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" class="btit_3">Contraseña</td>
          <td>**********</td>
        </tr>

        <tr valign="baseline">
          <td align="right" valign="middle" class="btit_3">Sistemas autorizados</td>
          <td><?php echo dsis($row_rs2['level'],$row_rs2['snom']); ?></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" class="btit_3">Perfil de cuenta</td>
          <td><?php echo dperfi($row_rs2['level'],$row_rs2['perfil_id']); ?></td>
        </tr>
      </table></td>
  </tr>
</table>
</td>
    <td width="20" valign="top">&nbsp;</td>
    <td width="250" valign="top"><h2>Opciones</h2>
        <div class="btit_2">Acciones</div>
        <div class="bcont">
        <div class="spacer"><a href="#" onClick="location.reload();"><div class="skin left" style="background-position:-80px -63px;margin-right:3px;"></div>Refrescar p&aacute;gina</a></div>
        <div class="spacer"><a href="account_perso.php" >
          <div class="skin left" style="background-position:-48px -63px;margin-right:3px;"></div>
          Modificar los datos personales</a></div>
        
        <div class="spacer"><a href="account_user.php" >
          <div class="skin left" style="background-position:-48px -63px;margin-right:3px;"></div>
          Modificar los datos de la cuenta </a></div>
        </div>
        </td>
  </tr>
</table>
</div></div></div>

</body>
</html>
<?php
mysql_free_result($rs1);

mysql_free_result($rs2);
?>