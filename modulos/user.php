<?php require_once('../Connections/cn1.php'); ?>
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

$colname_rs1 = "-1";
if (isset($_GET['pk'])) {
  $colname_rs1 = $_GET['pk'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs1 = sprintf("SELECT empleado.*, oficinas.nombre AS onombre FROM empleado, oficinas WHERE empleado.oficinas_id=oficinas.id AND empleado.id= %s ORDER BY oficinas.nombre ASC", GetSQLValueString($colname_rs1, "int"));
$rs1 = mysql_query($query_rs1, $cn1) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
$totalRows_rs1 = mysql_num_rows($rs1);

$colname_rs2 = "-1";
if (isset($_GET['pk'])) {
  $colname_rs2 = $_GET['pk'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs2 = sprintf("SELECT * FROM users WHERE empleado_id = %s", GetSQLValueString($colname_rs2, "int"));
$rs2 = mysql_query($query_rs2, $cn1) or die(mysql_error());
$row_rs2 = mysql_fetch_assoc($rs2);
$totalRows_rs2 = mysql_num_rows($rs2);

$maxRows_rs3 = 20;
$pageNum_rs3 = 0;
if (isset($_GET['pageNum_rs3'])) {
  $pageNum_rs3 = $_GET['pageNum_rs3'];
}
$startRow_rs3 = $pageNum_rs3 * $maxRows_rs3;

$colname_rs3 = "-1";
if (isset($_GET['pk'])) {
  $colname_rs3 = $_GET['pk'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs3 = sprintf("SELECT * FROM log WHERE users_empleado_id = %s ORDER BY fecha DESC", GetSQLValueString($colname_rs3, "int"));
$query_limit_rs3 = sprintf("%s LIMIT %d, %d", $query_rs3, $startRow_rs3, $maxRows_rs3);
$rs3 = mysql_query($query_limit_rs3, $cn1) or die(mysql_error());
$row_rs3 = mysql_fetch_assoc($rs3);

if (isset($_GET['totalRows_rs3'])) {
  $totalRows_rs3 = $_GET['totalRows_rs3'];
} else {
  $all_rs3 = mysql_query($query_rs3);
  $totalRows_rs3 = mysql_num_rows($all_rs3);
}
$totalPages_rs3 = ceil($totalRows_rs3/$maxRows_rs3)-1;
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

<h1>Personal Administrativo &raquo; <?php echo $row_rs1['apellido'].", ".$row_rs1['nombre']; ?></h1>
<div class="hr"><em></em><span></span></div>

<div class="clear" style="height:5px"></div>
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>


<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><h4>Datos personales</h4>
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
        <tr valign="baseline">
          <td width="150" align="right" valign="middle" class="btit_3">Apellidos y Nombres</td>
          <td><?php echo $row_rs1['apellido'].", ".$row_rs1['nombre']; ?></td>
          </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" class="btit_3">Sexo</td>
          <td><?php echo dsexo($row_rs1['sexo']); ?></td>
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
      </table>
      <?php if ($totalRows_rs2 == 0) { // Show if recordset empty ?>
        <h2>Datos de la cuenta</h2>
          <div class="alert1">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><span class="skin left" style="background-position:-16px -79px;margin-right:3px;"></span>Este empleado no tiene cuenta de acceso</td>
                    <td width="75"><div class="spacer"><a href="add_user.php?pk=<?php echo $_GET['pk']?>">
                      <div class="skin left" style="background-position:-32px -79px;margin-right:3px;"></div>
                  Agregar      </a></div></td>
                  </tr>
                        </table>
          </div>
          <?php } // Show if recordset empty ?>
      <?php if ($totalRows_rs2 > 0) { // Show if recordset not empty ?>
      <h4>Datos de la cuenta</h4>
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
          <tr valign="baseline">
            <td width="150" align="right" valign="middle" class="btit_3">Usuario</td>
                <td><?php echo $row_rs2['nombre']; ?></td>
              </tr>
          <tr valign="baseline">
            <td align="right" valign="middle" class="btit_3"><a href="javascript:alert('Permisos: <?php echo $row_rs2['pass']; ?>');">Contraseña</a></td>
                <td>**********</td>
            </tr>
          <tr valign="baseline">
            <td align="right" valign="middle" class="btit_3">Nivel</td>
                <td><?php echo dlev($row_rs2['level']); ?></td>
            </tr>
          <tr valign="baseline">
            <td align="right" valign="middle" class="btit_3">Sistemas</td>
                <td><?php echo dsis($row_rs2['snom']); ?></td>
            </tr>
          <tr valign="baseline">
            <td align="right" valign="middle" class="btit_3">Perfil de cuenta</td>
            <td><?php echo dperfi($row_rs2['level'],$row_rs2['perfil_id']); ?></td>
          </tr>
        </table>
        
        
<h2>Últimos logs de acceso</h2>
      <table width="90%" border="0" cellpadding="0" cellspacing="0" class="tabla2">
          <tr>
            <td width="20" align="center" class="btit_1">#</td>
            <td class="btit_1">Fecha</td>
            <td class="btit_1">IP</td>
            <td class="btit_1">Host</td>
            <td class="btit_1">Navegador</td>
            <td class="btit_1">Acción</td>
            </tr>
          <?php $cont=0; ?>
          <?php do { ?>
          <?php $cont++; ?>
          <?php if ($totalRows_rs3 > 0) { // Show if recordset not empty ?>
            <tr>
              <td width="20" align="center"><?php echo $cont; ?></td>
              <td><?php echo dptiemp($row_rs3['fecha']);?></td>
              <td><?php echo $row_rs3['ip']; ?></td>
              <td><?php echo $row_rs3['hostip']; ?></td>
              <td><?php echo $row_rs3['nav_id']; ?></td>
              <td><?php echo duacco($row_rs3['accion']); ?></td>
            </tr>
            <?php } // Show if recordset not empty ?>

          <?php } while ($row_rs3 = mysql_fetch_assoc($rs3)); ?>
      </table>
      <?php } // Show if recordset not empty ?>
      </td>
    <td width="20" valign="top">&nbsp;</td>
    <td width="250" valign="top"><h2>Opciones</h2>
        <div class="btit_2">Acciones</div>
        <div class="bcont">
        <div class="spacer"><a href="#" onClick="location.reload();"><div class="skin left" style="background-position:-80px -63px;margin-right:3px;"></div>Refrescar p&aacute;gina</a></div>
        <div class="spacer"><a href="../opers/mod_perso.php?pk=<?php echo $_GET['pk']?>" >
          <div class="skin left" style="background-position:-48px -63px;margin-right:3px;"></div>
          Modificar datos personales</a></div>
          
<?php if ($totalRows_rs2 > 0) { // Show if recordset not empty ?>
  <div class="spacer"><a href="../opers/mod_user.php?ck=<?php echo $row_rs2['id']; ?>" >
    <div class="skin left" style="background-position:-48px -63px;margin-right:3px;"></div>
        Modificar datos de la cuenta    </a></div>
<?php } // Show if recordset not empty ?>
<div class="spacer"><a href="perso.php" >
          <div class="skin left" style="background-position:-64px -79px;margin-right:3px;"></div>
          Ir a la lista general de empleados</a></div>
        </div>
        <div class="btit_2">Informaci&oacute;n</div>
        <div class="bcont">Para acceder a las oficinas de un clic sobre el nombre del local.</div>
        </td>
  </tr>
</table>
</div></div></div>

</body>
</html>
<?php
mysql_free_result($rs1);

mysql_free_result($rs2);

mysql_free_result($rs3);
?>