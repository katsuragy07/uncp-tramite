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

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO reqs (id, nombre, descrip, precio, obs) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString(nl2br($_POST['nombre']), "text"),
                       GetSQLValueString(nl2br($_POST['descrip']), "text"),
					   GetSQLValueString(nl2br($_POST['precio']), "text"),
					   GetSQLValueString(nl2br($_POST['obs']), "text"));

  mysql_select_db($database_cn1, $cn1);
  $Result1 = mysql_query($insertSQL, $cn1) or die(mysql_error());

  $insertGoTo = "reqs.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_rs1 = 50;
$pageNum_rs1 = 0;
if (isset($_GET['pageNum_rs1'])) {
  $pageNum_rs1 = $_GET['pageNum_rs1'];
}
$startRow_rs1 = $pageNum_rs1 * $maxRows_rs1;

mysql_select_db($database_cn1, $cn1);
$query_rs1 = "SELECT * FROM reqs ORDER BY id DESC";
$query_limit_rs1 = sprintf("%s LIMIT %d, %d", $query_rs1, $startRow_rs1, $maxRows_rs1);
$rs1 = mysql_query($query_limit_rs1, $cn1) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);

if (isset($_GET['totalRows_rs1'])) {
  $totalRows_rs1 = $_GET['totalRows_rs1'];
} else {
  $all_rs1 = mysql_query($query_rs1);
  $totalRows_rs1 = mysql_num_rows($all_rs1);
}
$totalPages_rs1 = ceil($totalRows_rs1/$maxRows_rs1)-1;

$queryString_rs1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rs1") == false && 
        stristr($param, "totalRows_rs1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rs1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rs1 = sprintf("&totalRows_rs1=%d%s", $totalRows_rs1, $queryString_rs1);

$TFM_LimitLinksEndCount = 10;
$TFM_temp = $pageNum_rs1 + 1;
$TFM_startLink = max(1,$TFM_temp - intval($TFM_LimitLinksEndCount/2));
$TFM_temp = $TFM_startLink + $TFM_LimitLinksEndCount - 1;
$TFM_endLink = min($TFM_temp, $totalPages_rs1 + 1);
if($TFM_endLink != $TFM_temp) $TFM_startLink = max(1,$TFM_endLink - $TFM_LimitLinksEndCount + 1);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/int.css" rel="Stylesheet" type="text/css" />
<style>
#wpag{background:transparent url(../images/pico_4.jpg) no-repeat fixed bottom right;}
</style>

<script src="../scripts/SpryValidationTextarea.js" type="text/javascript"></script>
<script type="text/javascript">function dlitem(ord){if(confirm("Deseas eliminar este registro?")){document.location.href= '../opers/del_reqs.php?pk='+ord;}}</script>

<link href="../scripts/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container"><div id="wpag"><div id="content">

<h1>Trámite documentario &raquo; Requisitos</h1>
<div class="hr"><em></em><span></span></div>

<div class="clear" style="height:5px"></div>
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>


<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><h2>Lista de requisitos registrados</h2>
        <table width="90%" border="0" cellpadding="0" cellspacing="0" class="tabla2">
          <tr>
            <td width="20" align="center" class="btit_1">#</td>
            <td width="180" class="btit_1">Nombre</td>
            <td class="btit_1">Requisitos</td>
            <td class="btit_1">Precio</td>
            <td class="btit_1">Observaciones</td>
            <td width="160" class="btit_1">&nbsp;</td>
          </tr>
          <?php $cont=0;$ccant=0; ?>
          <?php do { ?>
          <?php $cont++;$ccant=$ccant+$row_rs1['imp'];?>
          <?php if ($totalRows_rs1 > 0) { // Show if recordset not empty ?>
            <tr>
              <td width="20" align="center"><?php echo $cont; ?></td>
              <td width="180"><?php echo $row_rs1['nombre']; ?></td>
              <td><?php echo $row_rs1['descrip']; ?></td>
              <td><?php echo $row_rs1['precio']; ?></td>
              <td><?php echo $row_rs1['obs']; ?></td>
              <td width="160"><div class="barlist right" style="width:140px">
                <ul>
                  <li><a href="../opers/mod_reqs.php?pk=<?php echo $row_rs1['id']; ?>"><span class="skin left" style="background-position:-48px -63px;margin-right:3px;"></span> Editar</a></li>
  <li><a href="javascript:dlitem(<?php echo $row_rs1['id']; ?>);">
    <div class="skin left" style="background-position:-64px -63px;margin-right:3px;"></div>
    Eliminar            </a></li>
  </ul>
              </div></td>
            </tr>
            <?php } // Show if recordset not empty ?>

          <?php } while ($row_rs1 = mysql_fetch_assoc($rs1)); ?>
      </table>
      
      
      <?php include("../includes/navbar.php");?>
      
      </td>
    <td width="20" valign="top">&nbsp;</td>
    <td width="250" valign="top"><h2>Opciones</h2>
        <div class="btit_2">Acciones</div>
        <div class="bcont">
        <div class="spacer"><a href="#" onClick="location.reload();"><div class="skin left" style="background-position:-80px -63px;margin-right:3px;"></div>Refrescar p&aacute;gina</a></div>
		  </div>
        <div class="btit_2">Agregar valores</div>
        <div class="bcont2">Para agregar nuevos valores rellene el siguiente formulario.<br>
        </div>
        <div class="bcont2">
          <form method="post" name="form1" action="<?php echo $editFormAction; ?>">          
          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr valign="baseline">
                <td class="normal">Nombre:</td>
              </tr>
              <tr valign="baseline">
                <td><span id="sprytextarea2">
                  <label>
                  <textarea name="nombre" rows="2" class="tbox1" id="nombre"></textarea>
                  </label>
                  <span class="textareaRequiredMsg">A value is required.</span></span></td>
              </tr>
              <tr valign="baseline">
                <td class="normal">Requisitos:</td>
              </tr>
              <tr valign="baseline">
                <td><span id="sprytextarea1">
                <textarea name="descrip" rows="6" class="tbox1" id="descrip"></textarea>
                <span class="textareaMinCharsMsg">Pocos caracteres.</span></span></td>
              </tr>
              <tr valign="baseline">
                <td>Precio</td>
              </tr>
              <tr valign="baseline">
                <td>
                  <input name="precio" type="text" class="tbox1" id="precio" /></td>
              </tr>
              <tr valign="baseline">
                <td>Observaciones</td>
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
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {minChars:2, validateOn:["change"]});
var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprytextarea2", {validateOn:["change"]});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($rs1);
?>