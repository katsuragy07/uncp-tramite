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
  $insertSQL = sprintf("INSERT INTO log_archivo (id, tipo, folioext_id, forma, obs, fecha, `user`, c_oficina, empid) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['tipo'], "int"),
                       GetSQLValueString($_POST['folio'], "int"),
                       GetSQLValueString($_POST['forma'], "int"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['fecha'], "date"),
                       GetSQLValueString($_POST['user'], "text"),
							  GetSQLValueString($_POST['c_oficina'], "int"),
                       GetSQLValueString($_POST['empid'], "int"));

  mysql_select_db($database_cn1, $cn1);
  $Result1 = mysql_query($insertSQL, $cn1) or die(mysql_error());

  $insertGoTo = "../modulos/td_recibidosya.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }

  folio_doperado($_POST['deid']);  //marcar como atendido en los derivos
  folxt_aten($_POST['folio']); //marca folio como atendido
  
  
  header(sprintf("Location: %s", $insertGoTo));
}


mysql_select_db($database_cn1, $cn1);
$query_rs1 = "SELECT * FROM oficinas ORDER BY nombre ASC";
$rs1 = mysql_query($query_rs1, $cn1) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
$totalRows_rs1 = mysql_num_rows($rs1);

$colname_rs2 = "-1";
if (isset($_GET['pk'])) {
  $colname_rs2 = $_GET['pk'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs2 = sprintf("SELECT * FROM folioext WHERE id = %s", GetSQLValueString($colname_rs2, "int"));
$rs2 = mysql_query($query_rs2, $cn1) or die(mysql_error());
$row_rs2 = mysql_fetch_assoc($rs2);
$totalRows_rs2 = mysql_num_rows($rs2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/int.css" rel="Stylesheet" type="text/css" />
<style>
#wpag{background:transparent url(../images/pico_5.jpg) no-repeat fixed bottom right;}
</style>
<script src="../scripts/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../scripts/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container">
<div id="wpag"><div id="content">
<h1>Expedientes Externos</h1>
<div class="hr"><em></em><span></span></div>
<div class="clear" style="height:5px"></div>
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>
<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">
    <h2>Archivar Expediente</h2>
    <h3><?php echo $row_rs2['firma']; ?></h3>
    <p>
    <strong>Cabecera:</strong> <?php echo $row_rs2['cabecera']; ?><br/>
    <strong>Asunto:</strong> <?php echo $row_rs2['asunto']; ?><br/>
    <strong>Fecha:</strong> <?php echo dptiemp($row_rs2['fecha']); ?><br/>
    </p>
    <form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
        <tr valign="baseline">
          <td width="130" align="right" class="btit_1">Item</td>
          <td class="btit_1">Valor</td>
          </tr>
        <tr valign="baseline">
          <td width="130" align="right" valign="middle" class="btit_3">Forma</td>
          <td><select name="forma">
<option value="0" selected="selected">Original</option>
<option value="1">Copia</option>
          </select></td>
        </tr>
        <tr valign="baseline">
          <td width="130" align="right" valign="middle" class="btit_3">Observaciones</td>
          <td><span id="sprytextarea1">
            <textarea name="obs" rows="4" class="tbox2" id="obs"></textarea></span></td>
        </tr>
        <tr valign="baseline">
          <td width="130">&nbsp;</td>
          <td><input type="submit" class="but1" value="Agregar"></td>
          </tr>
      </table>
      <input type="hidden" name="id" value="">
      <input type="hidden" name="deid" value="<?php echo $_GET['fk'];?>">
      <input type="hidden" name="tipo" value="0">
      <input type="hidden" name="folio" value="<?php echo $row_rs2['id']; ?>">
      <input type="hidden" name="fecha" value="<?php echo date("Y-m-d H:i:s");?>">
      <input type="hidden" name="empid" value="<?php echo $_SESSION['u_empid']; ?>">
      <input type="hidden" name="user" value="<?php echo $_SESSION['u_id']; ?>">
      <input type="hidden" name="c_oficina" value="<?php echo $_SESSION['u_ofice']; ?>">
      <input type="hidden" name="MM_insert" value="form1" />
</form></td>
    <td width="20" valign="top">&nbsp;</td>
    <td width="250" valign="top"><h2>Opciones</h2>
        <div class="btit_2">Acciones</div>
        <div class="bcont">
        <div class="spacer"><a href="#" onClick="location.reload();"><div class="skin left" style="background-position:-80px -63px;margin-right:3px;"></div>Refrescar p&aacute;gina</a></div>
        <div class="spacer"><a href="td_recibidos.php" >
          <div class="skin left" style="background-position:-48px -79px;margin-right:3px;"></div>
          Cancelar e ir a la lista general</a></div>
        </div>
        <div class="btit_2">Informaci&oacute;n</div>
        <div class="bcont2">Rellene los cuadros y luego pulse el boton agregar para almacenar los datos, si desea cancelar puede usar el bot&oacute;n respectivo de la lista de acciones.</div>
        </td>
  </tr>
</table>

</div></div></div>

<script type="text/javascript">
ocultar();
ocultar2();
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
</script>
</body>
</html>
<?php
mysql_free_result($rs1);

mysql_free_result($rs2);
?>