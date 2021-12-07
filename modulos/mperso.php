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
$query_rs1 = sprintf("SELECT * FROM empleado WHERE oficinas_id = %s ORDER BY apellido ASC", GetSQLValueString($colname_rs1, "int"));
$rs1 = mysql_query($query_rs1, $cn1) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
$totalRows_rs1 = mysql_num_rows($rs1);

$colname_rs2 = "-1";
if (isset($_GET['pk'])) {
  $colname_rs2 = $_GET['pk'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs2 = sprintf("SELECT * FROM oficinas WHERE id = %s", GetSQLValueString($colname_rs2, "int"));
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

<script type="text/javascript">function dlitem(ord){if(confirm("Deseas eliminar este registro?")){document.location.href= '../opers/del_perso.php?pk='+ord;}}</script> 

</head>
<body>
<div id="container"><div id="wpag"><div id="content">

<h1>Personal Administrativo</h1>
<div class="hr"><em></em><span></span></div>

<div class="clear" style="height:5px"></div>
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>


<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><h2>Personal registrado &raquo;</h2>
      <h3><?php echo $row_rs2['nombre']; ?></h3>
        <table width="90%" border="0" cellpadding="0" cellspacing="0" class="tabla2">
          <tr>
            <td width="20" align="center" class="btit_1">#</td>
            <td class="btit_1">Apellidos y Nombres</td>
            <td class="btit_1">E-mail</td>
            <td class="btit_1">Encargado</td>
            <td width="150" class="btit_1">&nbsp;</td>
          </tr>
          <?php $cont=0; ?>
          <?php $cont++; ?>
          <?php if ($totalRows_rs1 > 0) { // Show if recordset not empty ?>
          <?php do { ?>
            <tr>
              <td width="20" align="center"><?php echo $cont; ?></td>
              <td><a href="user.php?pk=<?php echo $row_rs1['id']; ?>"><?php echo $row_rs1['apellido'].", ".$row_rs1['nombre']; ?></a></td>
              <td><?php echo dbla($row_rs1['mail']); ?></td>
              <td><?php echo denca($row_rs1['encargado']); ?></td>
              <td width="150"><div class="barlist right" style="width:140px">
                <ul>
                  <li><a href="../opers/mod_perso.php?ck=<?php echo $row_rs1['id']; ?>&pk=<?php echo $_GET['pk']; ?>&fk=<?php echo $_GET['fk']; ?>"><span class="skin left" style="background-position:-48px -63px;margin-right:3px;"></span> Editar</a></li>
                  <?php if($row_rs1['id']!=1){ ?>
                        <li><a href="javascript:dlitem(<?php echo $row_rs1['id']; ?>);">
                          <div class="skin left" style="background-position:-64px -63px;margin-right:3px;"></div>
                  Eliminar             </a></li>
                  <?php } ?>
                      </ul>
              </div></td>
            </tr>
            <?php } while ($row_rs1 = mysql_fetch_assoc($rs1)); ?>
            <?php } // Show if recordset not empty ?>
</table></td>
    <td width="20" valign="top">&nbsp;</td>
    <td width="250" valign="top"><h2>Opciones</h2>
        <div class="btit_2">Acciones</div>
        <div class="bcont">
        <div class="spacer"><a href="#" onClick="location.reload();"><div class="skin left" style="background-position:-80px -63px;margin-right:3px;"></div>Refrescar p&aacute;gina</a></div>
        <div class="spacer"><a href="mofice.php?pk=<?php echo $_GET['fk']; ?>" >
          <div class="skin left" style="background-position:-96px -63px;margin-right:3px;"></div>
          Volver a la lista de oficinas</a></div>
          <div class="spacer"><a href="mlocal.php" >
          <div class="skin left" style="background-position:-96px -63px;margin-right:3px;"></div>
          Volver a la lista de locales</a></div>
          <div class="spacer"><a href="add_empleado.php?ck=<?php echo $_GET['pk']; ?>" >
            <div class="skin left" style="background-position:-32px -79px;margin-right:3px;"></div>
            Agregar un empleado</a></div>
          <div class="spacer"><a href="perso.php" >
          <div class="skin left" style="background-position:-64px -79px;margin-right:3px;"></div>
          Ir a la lista general de empleados</a></div>
        </div>
        <div class="btit_2">Informaci&oacute;n</div>
        <div class="bcont">Para ver el personal de un clic sobre el nombre de la oficina.</div>
        <div class="bcont2"></div>
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