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
  $insertSQL = sprintf("INSERT INTO tabdepre (id, clase, antig, mat, cose_1, cose_2, cose_3, cose_4) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['clase'], "int"),
                       GetSQLValueString($_POST['antig'], "int"),
                       GetSQLValueString($_POST['mat'], "int"),
                       GetSQLValueString($_POST['cose_1'], "int"),
                       GetSQLValueString($_POST['cose_2'], "int"),
                       GetSQLValueString($_POST['cose_3'], "int"),
                       GetSQLValueString($_POST['cose_4'], "int"));

  mysql_select_db($database_cn1, $cn1);
  $Result1 = mysql_query($insertSQL, $cn1) or die(mysql_error());

  $insertGoTo = "c_depre2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_cn1, $cn1);
$query_rs1 = "SELECT * FROM tabdepre WHERE clase=2 ORDER BY antig, mat ASC";
$rs1 = mysql_query($query_rs1, $cn1) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
$totalRows_rs1 = mysql_num_rows($rs1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/int.css" rel="Stylesheet" type="text/css" />
<style>
#wpag{background:transparent url(../images/pico_4.jpg) no-repeat fixed bottom right;}
</style>
<script src="../scripts/SpryValidationTextField.js" type="text/javascript"></script>
<script type="text/javascript">function dlitem(ord){if(confirm("Deseas eliminar este registro?")){document.location.href= '../opers/del_cdepre.php?fk=2&pk='+ord;}}</script>
</head>
<link href="../scripts/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="container"><div id="wpag"><div id="content">

<h1>Tabla de Depreciación</h1>
<div class="hr"><em></em><span></span></div>

<div class="clear" style="height:5px"></div>
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>


<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">
    <h2>Tiendas, depósitos, clubes, instituciones, etc</h2>
    <h3>Valores registrados</h3>
    <table border="0" cellpadding="0" cellspacing="0" class="tabla2">
          <tr>
            <td rowspan="2" align="center" class="btit_1">Antigüedad <br />
              (En años)</td>
            <td rowspan="2" align="center" class="btit_1">Material Estructural <br />
              Predominante</td>
            <td colspan="4" align="center" class="btit_1">Estado de conservación</td>
            <td width="140" rowspan="2" class="btit_1">&nbsp;</td>
          </tr>
          <tr>
            <td class="btit_3">Muy Bueno %</td>
            <td class="btit_3">Bueno %</td>
            <td class="btit_3">Regular %</td>
            <td class="btit_3">Malo %</td>
            </tr>
          <?php do { ?>
          <tr>
            <td align="center"><?php echo dtant($row_rs1['antig']); ?></td>
            <td><?php echo dpre2($row_rs1['mat']); ?></td>
            <td><?php echo $row_rs1['cose_1']; ?></td>
            <td><?php echo $row_rs1['cose_2']; ?></td>
            <td><?php echo $row_rs1['cose_3']; ?></td>
            <td><?php echo $row_rs1['cose_4']; ?></td>
            <td width="140"><div class="barlist right" style="width:140px">
                <ul>
                  <li><a href="../opers/mod_cdepre.php?fk=2&pk=<?php echo $row_rs1['id']; ?>"><span class="skin left" style="background-position:-48px -63px;margin-right:3px;"></span> Editar</a></li>
                  <li><a href="javascript:dlitem(<?php echo $row_rs1['id']; ?>);">
                    <div class="skin left" style="background-position:-64px -63px;margin-right:3px;"></div>
                    Eliminar</a></li>
                </ul>
            </div></td>
          </tr>
          <?php } while ($row_rs1 = mysql_fetch_assoc($rs1)); ?>
      </table></td>
    <td width="20" valign="top">&nbsp;</td>
    <td width="250" valign="top"><h2>Opciones</h2>
        <div class="btit_2">Acciones</div>
        <div class="bcont">
        <div class="spacer"><a href="#" onClick="location.reload();"><div class="skin left" style="background-position:-80px -63px;margin-right:3px;"></div>Refrescar p&aacute;gina</a></div>
        </div>
        <div class="btit_2">Agregar valores</div>
        <div class="bcont2">Para agregar nuevos valores rellene el siguiente formulario.</div>
        <div class="bcont2">
          <form action="<?php echo $editFormAction; ?>" method="POST" name="form1">          
          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr valign="baseline">
                <td class="normal">Antogüedad en años:</td>
              </tr>
              <tr valign="baseline">
                <td><span id="sprytextfield1">
                  <input name="antig" type="text" class="tbox1" id="antig" value="" /></span></td>
              </tr>
              <tr valign="baseline">
                <td class="normal">Material Estructural Predominante</td>
              </tr>
              <tr valign="baseline">
                <td>
                  <select name="mat" id="mat">
                    <option value="1">Concreto</option>
                    <option value="2">Ladrillo</option>
                    <option value="3">Adobe (Quincha o madera)</option>
                  </select>                  </td>
              </tr>
              <tr valign="baseline">
                <td class="normal">Estado &raquo; Muy Bueno:</td>
              </tr>
              <tr valign="baseline">
                <td><span id="sprytextfield2">
                <input name="cose_1" type="text" class="tbox1" id="cose_1" value="" />
                </span></td>
              </tr>
              <tr valign="baseline">
                <td class="normal">Estado &raquo; Bueno:</td>
              </tr>
              <tr valign="baseline">
                <td><span id="sprytextfield3">
                <input name="cose_2" type="text" class="tbox1" id="cose_2" value="" />
                </span></td>
              </tr>
              <tr valign="baseline">
                <td class="normal">Estado &raquo; Regular:</td>
              </tr>
              <tr valign="baseline">
                <td><span id="sprytextfield4">
                <input name="cose_3" type="text" class="tbox1" id="cose_3" value="" />
                </span></td>
              </tr>
              <tr valign="baseline">
                <td class="normal">Estado &raquo; Malo:</td>
              </tr>
              <tr valign="baseline">
                <td><span id="sprytextfield5">
                <input name="cose_4" type="text" class="tbox1" id="cose_4" value="" />
                </span></td>
              </tr>
              <tr valign="baseline">
                <td><input type="submit" class="but1" value="Agregar"></td>
              </tr>
            </table>
            <input type="hidden" name="id" value="">
            <input type="hidden" name="clase" value="2">
            <input type="hidden" name="MM_insert" value="form1" />
          </form>
          </div>
        </td>
  </tr>
</table>

</div></div></div>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {validateOn:["change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "integer", {validateOn:["change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "integer", {validateOn:["change"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "integer", {validateOn:["change"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "integer", {validateOn:["change"]});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($rs1);
?>