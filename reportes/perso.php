<?php require_once('../Connections/cn1.php'); ?>
<?php require_once('../includes/functions.php'); ?>
<?php require_once('../includes/permisos_adm.php'); ?>
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

mysql_select_db($database_cn1, $cn1);
$query_rs1 = "SELECT empleado.*
,(SELECT oficinas.nombre FROM oficinas,lugares
WHERE empleado.oficinas_id=oficinas.id AND oficinas.lugares_id=lugares.id AND oficinas.id = empleado.oficinas_id
LIMIT 1)AS onombre
,(SELECT COUNT(users.id) FROM users WHERE empleado.id=users.empleado_id LIMIT 1)AS tot
,(SELECT users.nombre FROM users WHERE empleado.id=users.empleado_id LIMIT 1)AS nuser
,(SELECT users.pass FROM users WHERE empleado.id=users.empleado_id LIMIT 1)AS npass
,(SELECT users.snom FROM users WHERE empleado.id=users.empleado_id LIMIT 1)AS nsis
FROM empleado
WHERE empleado.id <> 1
ORDER BY empleado.apellido ASC";
$rs1 = mysql_query($query_rs1, $cn1) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
$totalRows_rs1 = mysql_num_rows($rs1);
?><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../images/favprint.ico" />
<title>Resumen de los registros - <?php include("../includes/title.php");?></title>
<link href="../css/print.css" rel="Stylesheet" type="text/css" />
<style type="text/css">
@media print {.alert{visibility: hidden;margin-top:-20px;height:0px;padding:0;}}
</style>

</head>
<body>
<?php include("../includes/print.php");?>
<div class="cabecera">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="normal" <?php echo dtabla();?>>
  <tr>
    <td width="155" align="right">
	<strong><?php echo date("d/m/Y");?></strong><br>
	<span class="min">	
	<?php echo date("h:iA");?> y <?php echo date("s");?>s	</span><br>
    ADMINISTRADOR DEL SISTEMA</td>
  </tr>
</table>
</div>
<h1>Lista de personal administrativo</h1>
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>


<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><h4>Empleados registrados en el sistema</h4>
    <table width="90%" border="0" cellpadding="0" cellspacing="0" class="tabla2">
          <tr>
            <td width="20" align="center" class="btit_1">#</td>
            <td width="250" class="btit_1">Apellidos y Nombres</td>
            <td class="btit_1">Usuario</td>
            <td class="btit_1">Oficina</td>            
            <td class="btit_1">Encargado</td>
            <td class="btit_1">Cargo</td>
            <td class="btit_1">E-mail</td>
            <td class="btit_1">Fecha de nacimiento</td>
            <td class="btit_1">Sexo</td>
          </tr>
          <?php $cont=0; ?>
          <?php do { ?>
          <?php $cont++; ?>
          <tr>
            <td width="20" align="center"><?php echo $cont; ?></td>
            <td width="250"><?php echo $row_rs1['apellido'].", ".$row_rs1['nombre']; ?></td>
            <td><?php echo dbol($row_rs1['tot']); ?></td>
            <td><?php echo dbla($row_rs1['onombre']); ?></td>
            <td><?php echo denca($row_rs1['encargado']); ?></td>
            <td><?php echo dbla($row_rs1['cargo']); ?></td>
            <td><?php echo dbla($row_rs1['mail']); ?></td>
            <td><?php echo dbla($row_rs1['fechnac']); ?></td>
            <td><?php echo dbla(dsexo($row_rs1['sexo'])); ?></td>
          </tr>
          <?php } while ($row_rs1 = mysql_fetch_assoc($rs1)); ?>
      </table>
        
        
</td>
  </tr>
</table>

</body>
</html>
<?php
mysql_free_result($rs1);
?>