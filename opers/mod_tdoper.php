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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE log_derivar SET forma=%s, obs=%s, `user`=%s, d_oficina=%s WHERE id=%s",
                       GetSQLValueString($_POST['forma'], "int"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['user'], "text"),
                       GetSQLValueString($_POST['d_oficina'], "int"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_cn1, $cn1);
  $Result1 = mysql_query($updateSQL, $cn1) or die(mysql_error());

  $updateGoTo = "../modulos/td_verfolio.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_cn1, $cn1);
$query_rs1 = "SELECT oficinas.id, CONCAT(lugares.nombre,'&nbsp;&nbsp;|&nbsp;&nbsp;',oficinas.nombre) AS nombre FROM oficinas, lugares WHERE oficinas.lugares_id = lugares.id ORDER BY lugares.id, nombre ASC";
$rs1 = mysql_query($query_rs1, $cn1) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
$totalRows_rs1 = mysql_num_rows($rs1);

$colname_rs2 = "-1";
if (isset($_SESSION['u_empid'])) {
  $colname_rs2 = $_SESSION['u_empid'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs2 = sprintf("SELECT id, oficinas_id FROM empleado WHERE id = %s", GetSQLValueString($colname_rs2, "int"));
$rs2 = mysql_query($query_rs2, $cn1) or die(mysql_error());
$row_rs2 = mysql_fetch_assoc($rs2);
$totalRows_rs2 = mysql_num_rows($rs2);

$colname_rs = "-1";
if (isset($_GET['pk'])) {
  $colname_rs = $_GET['pk'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs = sprintf("SELECT * FROM folioext WHERE id = %s", GetSQLValueString($colname_rs, "int"));
$rs = mysql_query($query_rs, $cn1) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);
$totalRows_rs = mysql_num_rows($rs);

$colname_rs3 = "-1";
if (isset($_GET['fk'])) {
  $colname_rs3 = $_GET['fk'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs3 = sprintf("SELECT * FROM log_derivar WHERE id = %s", GetSQLValueString($colname_rs3, "int"));
$rs3 = mysql_query($query_rs3, $cn1) or die(mysql_error());
$row_rs3 = mysql_fetch_assoc($rs3);
$totalRows_rs3 = mysql_num_rows($rs3);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/int.css" rel="Stylesheet" type="text/css" />
<style>
#wpag{background:transparent url(../images/pico_6.jpg) no-repeat fixed bottom right;}
</style>

<script type="text/javascript">
function ocultar2() {
	var elem1 = document.getElementsByName("hos2");
	for (k = 0; k< elem1.length; k++) {
		elem1[k].style.display = "none";
	}
}
function mostrar2() {
	var elem1 = document.getElementsByName("hos2");
	for (i = 0; i< elem1.length; i++) {
	var visible = 'block'
	elem1[i].style.display = visible;
	}
}
function selca2(sdep2){
	if(sdep2!=25){
		ocultar2();
	}else{
		mostrar2();
		document.forms[0].t_otro.value="";
	}
}
</script>

</head>
<body>
<div id="container"><div id="wpag"><div id="content">
<h1>Modificar datos</h1>
<div class="hr"><em></em><span></span></div>
<div class="clear" style="height:5px"></div>
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>
<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">
    <h2>Modificar log de expediente</h2>
    <h3><?php echo $row_rs['firma']; ?></h3>
    <p><?php echo $row_rs['asunto']; ?></p>
    <form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
        <tr valign="baseline">
          <td width="130" align="right" class="btit_1">Item</td>
          <td class="btit_1">Valor</td>
          </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" class="btit_3">Forma</td>
          <td><select name="forma">
              <option value="0" <?php if (!(strcmp(0, $row_rs3['forma']))) {echo "selected=\"selected\"";} ?>>Original</option>
              <option value="1" <?php if (!(strcmp(1, $row_rs3['forma']))) {echo "selected=\"selected\"";} ?>>Copia</option>
          </select></td>
        </tr>
        
        <tr valign="baseline">
          <td width="130" align="right" valign="middle" class="btit_3">Oficina de destino</td>
          <td>
            <select name="d_oficina" class="tbox2" id="d_oficina">
              <?php
do {  
?>
              <option value="<?php echo $row_rs1['id']?>"<?php if (!(strcmp($row_rs1['id'], $row_rs3['d_oficina']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rs1['nombre']?></option>
              <?php
} while ($row_rs1 = mysql_fetch_assoc($rs1));
  $rows = mysql_num_rows($rs1);
  if($rows > 0) {
      mysql_data_seek($rs1, 0);
	  $row_rs1 = mysql_fetch_assoc($rs1);
  }
?>
            </select>            </td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" class="btit_3">Mensaje</td>
          <td><textarea name="obs" rows="4" class="tbox2" id="obs"><?php echo $row_rs3['obs']; ?></textarea>          </td>
        </tr>
        <tr valign="baseline">
          <td width="130">&nbsp;</td>
          <td><input type="submit" class="but1" value="Modificar"></td>
          </tr>
      </table>
      <input type="hidden" name="id" value="<?php echo $row_rs3['id']; ?>">
      <input type="hidden" name="folio_id" value="<?php echo $row_rs3['folio_id']; ?>">
      <input type="hidden" name="user" value="<?php echo $_SESSION['u_id']; ?>">
      <input type="hidden" name="MM_update" value="form1" />
</form></td>
    <td width="20" valign="top">&nbsp;</td>
    <td width="250" valign="top"><h2>Opciones</h2>
        <div class="btit_2">Acciones</div>
        <div class="bcont">
        <div class="spacer"><a href="#" onClick="location.reload();"><div class="skin left" style="background-position:-80px -63px;margin-right:3px;"></div>Refrescar p&aacute;gina</a></div>
        <div class="spacer"><a href="../modulos/td_verfolio.php?pk=<?php echo $_GET['pk'];?>" >
          <div class="skin left" style="background-position:-48px -79px;margin-right:3px;"></div>
          Cancelar y volver</a></div>
        </div>
        <div class="btit_2">Informaci&oacute;n</div>
        <div class="bcont2">Rellene los cuadros y luego pulse el boton modificar para almacenar los datos, si desea cancelar puede usar el bot&oacute;n respectivo de la lista de acciones.</div>
        </td>
  </tr>
</table>

</div></div></div>

<script type="text/javascript">
<?php if($row_rs['t_tipo']!=25){?>
ocultar2();
<?php }else{ ?>
mostrar2();
<?php } ?>
</script>
</body>
</html>
<?php
mysql_free_result($rs1);

mysql_free_result($rs2);

mysql_free_result($rs);

mysql_free_result($rs3);
?>