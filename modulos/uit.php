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
  $insertSQL = sprintf("INSERT INTO uit (id, anno, valor, obs) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['anno'], "text"),
                       GetSQLValueString($_POST['valor'], "double"),
                       GetSQLValueString($_POST['obs'], "text"));

  mysql_select_db($database_cn1, $cn1);
  $Result1 = mysql_query($insertSQL, $cn1) or die(mysql_error());

  $insertGoTo = "uit.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_cn1, $cn1);
$query_rs1 = "SELECT * FROM uit ORDER BY anno ASC";
$rs1 = mysql_query($query_rs1, $cn1) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
$totalRows_rs1 = mysql_num_rows($rs1);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/int.css" rel="Stylesheet" type="text/css" />
<style>
#wpag{background:transparent url(../images/pico_4.jpg) no-repeat fixed bottom right;}
</style>
<script src="../scripts/SpryValidationTextField.js" type="text/javascript"></script>
<script type="text/javascript">function dlitem(ord){if(confirm("Deseas eliminar este registro?")){document.location.href= '../opers/del_uit.php?pk='+ord;}}</script> 
<link href="../scripts/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="container"><div id="wpag"><div id="content">

<h1>Unidad Impositiva Tributaria (UIT)</h1>
<div class="hr"><em></em><span></span></div>

<div class="clear" style="height:5px"></div>
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>


<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><h2>A&ntilde;os registrados</h2>
        <table width="90%" border="0" cellpadding="0" cellspacing="0" class="tabla">
          <tr>
            <td width="20" align="center" class="btit_1">#</td>
            <td class="btit_1">A&ntilde;o</td>
            <td class="btit_1">Valor</td>
            <td class="btit_1">Observaci&oacute;n</td>
            <td width="160" class="btit_1">&nbsp;</td>
          </tr>
          <?php $cont=0; ?>
          <?php do { ?>
          <?php $cont++; ?>
          <?php if ($totalRows_rs1 > 0) { // Show if recordset not empty ?>
            <tr>
              <td width="20" align="center"><?php echo $cont; ?></td>
              <td><?php echo $row_rs1['anno']; ?></td>
              <td>S/. <?php echo number_format($row_rs1['valor'],2,".",",");?></td>
              <td><?php echo dbla($row_rs1['obs']); ?></td>
              <td width="150"><div class="barlist right" style="width:140px">
                <ul>
                  <li><a href="../opers/mod_uit.php?pk=<?php echo $row_rs1['id']; ?>"><span class="skin left" style="background-position:-48px -63px;margin-right:3px;"></span> Editar</a></li>
                          <li><a href="javascript:dlitem(<?php echo $row_rs1['id']; ?>);">
                            <div class="skin left" style="background-position:-64px -63px;margin-right:3px;"></div>
                  Eliminar            </a></li>
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
        </div>
        <div class="btit_2">Agregar valores</div>
        <div class="bcont2">Para agregar nuevos valores UIT rellene el siguiente formulario.</div>
        <div class="bcont2">
          <form method="post" name="form1" action="<?php echo $editFormAction; ?>">          
          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr valign="baseline">
                <td class="normal">A&ntilde;o:</td>
              </tr>
              <tr valign="baseline">
                <td><span id="sprytextfield1">
                  <input name="anno" type="text" class="tbox1" id="anno" value=""></span></td>
              </tr>
              <tr valign="baseline">
                <td class="normal">Valor en soles (S/.0000.00):</td>
              </tr>
              <tr valign="baseline">
                <td><span id="sprytextfield2">
                  <input name="valor" type="text" class="tbox1" id="valor" value="">
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
          </form>
          </div>
        </td>
  </tr>
</table>
</div></div></div>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($rs1);
?>