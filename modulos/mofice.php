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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO oficinas (id, nombre, siglas, obs, lugares_id) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['nombre'], "text"),
							  GetSQLValueString($_POST['siglas'], "text"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['lugares_id'], "int"));

  mysql_select_db($database_cn1, $cn1);
  $Result1 = mysql_query($insertSQL, $cn1) or die(mysql_error());

  $insertGoTo = "mofice.php?pk=".$_GET['pk'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_rs1 = "-1";
if (isset($_GET['pk'])) {
  $colname_rs1 = $_GET['pk'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs1 = sprintf("SELECT oficinas.*,(SELECT COUNT(empleado.id) FROM empleado WHERE empleado.oficinas_id=oficinas.id) AS cant FROM oficinas WHERE oficinas.lugares_id = %s ORDER BY oficinas.nombre ASC", GetSQLValueString($colname_rs1, "int"));
$rs1 = mysql_query($query_rs1, $cn1) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
$totalRows_rs1 = mysql_num_rows($rs1);

$colname_rs2 = "-1";
if (isset($_GET['pk'])) {
  $colname_rs2 = $_GET['pk'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs2 = sprintf("SELECT * FROM lugares WHERE id = %s", GetSQLValueString($colname_rs2, "int"));
$rs2 = mysql_query($query_rs2, $cn1) or die(mysql_error());
$row_rs2 = mysql_fetch_assoc($rs2);
$totalRows_rs2 = mysql_num_rows($rs2);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/int.css" rel="Stylesheet" type="text/css" />
<style>
#wpag{background:transparent url(../images/pico_7.jpg) no-repeat fixed bottom right;}
</style>
<script src="../scripts/SpryValidationTextField.js" type="text/javascript"></script>
<script type="text/javascript">function dlitem(ord){if(confirm("Deseas eliminar este registro?")){document.location.href= '../opers/del_mofice.php?pk='+ord;}}</script> 
<link href="../scripts/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="container"><div id="wpag"><div id="content">

<h1>Oficinas &raquo; <?php echo $row_rs2['nombre']; ?></h1>
<div class="hr"><em></em><span></span></div>

<div class="clear" style="height:5px"></div>
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>


<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><h2>Oficinas registradas</h2>
        <table width="90%" border="0" cellpadding="0" cellspacing="0" class="tabla">
          <tr>
            <td width="20" align="center" class="btit_1">#</td>
            <td class="btit_1">Nombre</td>
            <td class="btit_1">Siglas</td>
            <td class="btit_1">Observaciones</td>
            <td width="160" class="btit_1">&nbsp;</td>
          </tr>
          <?php $cont=0; ?>
          <?php do { ?>
          <?php $cont++; ?>
          <?php if ($totalRows_rs1 > 0) { // Show if recordset not empty ?>
            <tr>
              <td width="20" align="center"><?php echo $cont; ?></td>
              <td><a href="mperso.php?pk=<?php echo $row_rs1['id']; ?>&fk=<?php echo $_GET['pk']; ?>"><?php echo $row_rs1['nombre']; ?></a> (<?php echo $row_rs1['cant']; ?>)</td>
              <td><?php echo $row_rs1['siglas']; ?></td>
              <td><?php echo $row_rs1['obs']; ?></td>
              <td width="150"><div class="barlist right" style="width:140px">
                <ul>
                  <li><a href="../opers/mod_mofice.php?pk=<?php echo $_GET['pk']; ?>&fk=<?php echo $row_rs1['id']; ?>"><span class="skin left" style="background-position:-48px -63px;margin-right:3px;"></span> Editar</a></li>
                  <?php if($row_rs1['id']!=1){ ?>
                          <li><a href="javascript:dlitem(<?php echo $row_rs1['id']; ?>);">
                            <div class="skin left" style="background-position:-64px -63px;margin-right:3px;"></div>
                  Eliminar            </a></li>
                  <?php } ?>
                        </ul>
              </div></td>
            </tr>
            <?php } // Show if recordset not empty ?>

          <?php } while ($row_rs1 = mysql_fetch_assoc($rs1)); ?>
      </table></td>
    <td width="20" valign="top">&nbsp;</td>
    <td width="250" valign="top"><h2>Opciones</h2>
        <div class="btit_2">Acciones</div>
        <div class="bcont">
        <div class="spacer"><a href="#" onClick="location.reload();"><div class="skin left" style="background-position:-80px -63px;margin-right:3px;"></div>Refrescar p&aacute;gina</a></div>
        <div class="spacer"><a href="mlocal.php?pk=<?php echo $_GET['fk']; ?>" >
          <div class="skin left" style="background-position:-96px -63px;margin-right:3px;"></div>
          Volver a la lista de oficina</a></div>
        </div>
        <div class="btit_2">Informaci&oacute;n</div>
        <div class="bcont">Para ver el personal de un clic sobre el nombre de la oficina.</div>
        <div class="btit_2">Agregar oficina</div>
        <div class="bcont2">Para agregar nuevas oficinas rellene el siguiente formulario.</div>
        <div class="bcont2">
          <form method="post" name="form1" action="<?php echo $editFormAction; ?>">          
          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr valign="baseline">
                <td class="normal">Nombre de la oficina:</td>
              </tr>
              <tr valign="baseline">
                <td><span id="sprytextfield1">
                  <input name="nombre" type="text" class="tbox1" id="nombre" value=""></span></td>
              </tr>
              <tr valign="baseline">
                <td class="normal">Siglas:</td>
              </tr>
              <tr valign="baseline">
                <td><span id="sprytextfield2">
                  <input name="siglas" type="text" class="tbox1" id="siglas" value="" />
                </span></td>
              </tr>
              <tr valign="baseline">
                <td class="normal">Observaciones:</td>
              </tr>
              <tr valign="baseline">
                <td><textarea name="obs" rows="3" class="tbox1" id="obs"></textarea></td>
              </tr>
              <tr valign="baseline">
                <td><input type="submit" class="but1" value="Agregar"></td>
              </tr>
            </table>
              <input type="hidden" name="MM_insert" value="form1">
              <input type="hidden" name="id" value="">
              <input type="hidden" name="lugares_id" value="<?php echo $_GET['pk']?>">
          </form>
          </div>
        </td>
  </tr>
</table>
</div></div></div>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["change"]});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($rs1);

mysql_free_result($rs2);
?>