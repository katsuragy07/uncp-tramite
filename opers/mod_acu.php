<?php require_once('../Connections/cn1.php'); ?>
<?php require_once('../includes/functions.php'); ?>
<?php require_once('../includes/permisos_all_ui.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

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
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
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
  $updateSQL = sprintf("UPDATE acuerdos SET anno=%s, num=%s, fecha=%s, descrip=%s, `file`=%s, ext=%s, size=%s WHERE id=%s",
                       GetSQLValueString($_POST['anno'], "text"),
                       GetSQLValueString($_POST['num'], "text"),
                       GetSQLValueString($_POST['fecha'], "date"),
					   GetSQLValueString($_POST['descrip'], "text"),
                       GetSQLValueString($_POST['file'], "text"),
                       GetSQLValueString($_POST['ext'], "text"),
					   GetSQLValueString($_POST['size'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_cn1, $cn1);
  $Result1 = mysql_query($updateSQL, $cn1) or die(mysql_error());

  $updateGoTo = "../modulos/acu_list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rs0 = "-1";
if (isset($_GET['pk'])) {
  $colname_rs0 = $_GET['pk'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs0 = sprintf("SELECT * FROM acuerdos WHERE id = %s", GetSQLValueString($colname_rs0, "int"));
$rs0 = mysql_query($query_rs0, $cn1) or die(mysql_error());
$row_rs0 = mysql_fetch_assoc($rs0);
$totalRows_rs0 = mysql_num_rows($rs0);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
#wpag{background:transparent url(../images/pico_6.jpg) no-repeat fixed bottom right;}
</style>
<link href="../css/int.css" rel="Stylesheet" type="text/css" />

<script type="text/javascript" src="../scripts/SpryValidationTextField.js"></script>
<link href="../scripts/SpryValidationTextField.css" rel="stylesheet" type="text/css" />



<script type="text/javascript" src="../scripts/jquery.js"></script>
<script src="../scripts/calendar.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
 new DatePicker("#fecha",{longDateFormat:"Y-m-d"<?php if($row_rs0['fecha']!=""){?>,setDate:new Date("<?php echo date("j M Y",crt_datetime($row_rs0['fecha']." 00:00:00")); ?>")<?php }?>});
});
</script>


<script type="text/javascript" src="../scripts/ckeditor/ckeditor.js"></script>

<?php 
$idautom = md5(uniqid(rand(), true)); 
$up_pref="acu".date("His");
$up_url="acuerdos";
$up_val=$row_rs0['file'];
include("../includes/uploadoc_scripts.php");
?>


</head>
<body>
<div id="container"><div id="wpag"><div id="content">
<h1>Modificar valores</h1>
<div class="hr"><em></em><span></span></div>	
<div class="clear" style="height:5px"></div>
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>
<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">
    <h2>Acuerdos</h2>
    <form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
        <thead>
        <tr valign="baseline">
          <th width="100" align="right" class="btit_1">Item</th>
          <th class="btit_1">Valor</th>
        </tr>
        </thead>
        
         <tr valign="baseline">
            <td width="100" align="right" valign="middle" class="btit_3">Año</td>
            <td valign="middle">
            	<span id="sprytextfield1">
                <input name="anno" type="text" id="anno" size="6" value="<?php echo $row_rs0['anno']; ?>" />
                <br />
                <span class="textfieldRequiredMsg">Escriba el año del acuerdo.</span>
                <span class="textfieldInvalidFormatMsg">El valor debe ser un número entero.</span></span>
              </td>
          </tr>
          <tr valign="baseline">
            <td width="100" align="right" valign="middle" class="btit_3">Número</td>
            <td valign="middle">
              <span id="sprytextfield2">
              <input name="num" type="text" id="num" size="8"  value="<?php echo $row_rs0['num']; ?>" />
              <br />
              <span class="textfieldRequiredMsg">Escriba el número del acuerdo.</span>
              <span class="textfieldInvalidFormatMsg">El valor debe ser un número entero.</span>
              <span class="textfieldMinValueMsg">El valor debe ser mayor de 1.</span>
              </span>
              </td>
          </tr>
          
          
          
        <tr valign="baseline">
            <td width="100" align="right" valign="middle" class="btit_3">Fecha</td>
            <td valign="middle"><input name="fecha" type="text" id="fecha" style="width:169px" value="<?php echo $row_rs0['fecha']; ?>" />
            </td>
          </tr>
          
          <tr valign="baseline">
          <td width="100" align="right" valign="middle" class="btit_3">Acuerdo</td>
          <td valign="middle" bgcolor="#FFF"><textarea name="descrip" class="ckeditor"  id="descrip"><?php echo $row_rs0['descrip']; ?></textarea>
          </td>
        </tr>
        
         <tr valign="baseline">
          <td align="right" valign="middle" class="btit_3">Adjuntar archivo</td>
          <td valign="middle"><?php include("../includes/uploadoc.php");?></td>
        </tr>
        
        <tr valign="baseline">
          <td class="btit_3">&nbsp;</td>
          <td><input type="submit" class="butt_send" value="Guardar"></td>
        </tr>
          

      </table>
      
      
      <input type="hidden" name="id" value="<?php echo $row_rs0['id']; ?>">
      
      <input type="hidden" name="file" value="<?php echo $row_rs0['file']; ?>">
      <input type="hidden" name="size" value="<?php echo $row_rs0['size']; ?>">
      <input type="hidden" name="ext" value="<?php echo $row_rs0['ext']; ?>">
      
      <input type="hidden" name="MM_update" value="form1" />
    </form></td>
    <td width="20" valign="top">&nbsp;</td>
    <td width="250" valign="top"><h2>Opciones</h2>
        <div class="btit_2">Acciones</div>
        <div class="bcont">
        <div class="spacer"><a href="#" onClick="location.reload();"><div class="skin left" style="background-position:-80px -63px;margin-right:3px;"></div>Refrescar p&aacute;gina</a></div>
        
        <div class="spacer"><a href="../modulos/acu_list.php" >
          <div class="skin left" style="background-position:-48px -79px;margin-right:3px;"></div>
          Cancelar y volver</a></div>
          
        </div>
        <div class="btit_2">Informaci&oacute;n</div>
        <div class="bcont2">Rellene los cuadros y luego pulse el boton agregar para almacenar los datos, si desea cancelar puede usar el bot&oacute;n respectivo de la lista de acciones.<br />
        </div>
        </td>
  </tr>
</table>

</div></div></div>

<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["change"]});
</script>

</body>
</html>
<?php
mysql_free_result($rs0);

mysql_free_result($rs1);

mysql_free_result($rs2);
?>
