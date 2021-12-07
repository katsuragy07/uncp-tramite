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
$query_rs1 = "SELECT users.*
,(SELECT CONCAT(empleado.apellido,', ',empleado.nombre) FROM empleado WHERE users.empleado_id=empleado.id)AS enombre
,(SELECT CONCAT(lugares.nombre,' | ',oficinas.nombre) FROM oficinas,lugares,empleado WHERE users.empleado_id=empleado.id AND oficinas.id = empleado.oficinas_id AND oficinas.lugares_id=lugares.id LIMIT 1)AS onombre
FROM users
WHERE users.level <> 0
ORDER BY enombre ASC";
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
<?php echo dbla($row_rs1['cargo']); ?>
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
<h1>Lista de usuarios registrados</h1>
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>


<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><h4>Empleados con permisos de acceso al sistema</h4>
    <table width="90%" border="0" cellpadding="0" cellspacing="0" class="tabla2">
          <tr>
            <td width="20" align="center" class="btit_1">#</td>
            <td class="btit_1">Apellidos y Nombres</td>
            <td class="btit_1">Oficina</td>
            <td class="btit_1">Usuario</td>            
            <td class="btit_1">Contraseña</td>
            <td class="btit_1">Nivel</td>
            <td class="btit_1">Sistemas</td>
          </tr>
          <?php $cont=0; ?>
          <?php do { ?>
          <?php $cont++; ?>
          <tr>
            <td width="20" align="center"><?php echo $cont; ?></td>
            <td><?php echo dbla($row_rs1['enombre']); ?></td>
            <td><?php echo dbla($row_rs1['onombre']); ?></td>
            <td><?php echo dbla($row_rs1['nombre']); ?></td>
            <td><?php echo dbla($row_rs1['pass']); ?></td>
            <td><?php echo dbla(dlev($row_rs1['level'])); ?></td>
            <td><?php echo dbla(dsis($row_rs1['level'],$row_rs1['snom'])); ?></td>
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