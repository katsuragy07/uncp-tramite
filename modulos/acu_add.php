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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	
  $insertSQL = sprintf("INSERT INTO acuerdos (id, anno, num, descrip, fecha, `file`, ext, size, `user`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString("", "int"),
                       GetSQLValueString($_POST['anno'], "int"),
                       GetSQLValueString($_POST['num'], "int"),
                       GetSQLValueString($_POST['descrip'], "text"),
                       GetSQLValueString($_POST['fecha'], "date"),
					   GetSQLValueString($_POST['file'], "text"),
					   GetSQLValueString($_POST['ext'], "text"),
					   GetSQLValueString($_POST['size'], "text"),
                       GetSQLValueString($_POST['user'], "text"));

  mysql_select_db($database_cn1, $cn1);
  $Result1 = mysql_query($insertSQL, $cn1) or die(mysql_error());

  $insertGoTo = "../modulos/acu_list.php?pk=".$uid;
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/int.css" rel="Stylesheet" type="text/css" />


<script type="text/javascript" src="../scripts/jquery.js"></script>

<script src="../scripts/calendar.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
 new DatePicker("#fecha",{longDateFormat:"Y-m-d", setDate:new Date("<?php echo date("j M Y"); ?>")});
});
</script>


<script type="text/javascript" src="../scripts/ckeditor/ckeditor.js"></script>



<script src="../scripts/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../scripts/SpryValidationTextField.css" rel="stylesheet" type="text/css">

<?php 
$idautom = md5(uniqid(rand(), true)); 
$up_pref="acu".date("His");
$up_url="acuerdos";
include("../includes/uploadoc_scripts.php");
?>

</head>
<body>
<div id="container"><div id="wpag">
  <div id="content">

<h1>Agregar valores</h1><div class="hr"><em></em><span></span></div>

<div class="clear" style="height:5px"></div>
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>


<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">


<h2>Acuerdos</h2>
<div class="clear"></div>



<form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
      <div id="dpersona" name="dpersona" class="clear">
   
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
                <input name="anno" type="text" id="anno" size="6" value="<?php echo date("Y");?>" />
                <br />
                <span class="textfieldRequiredMsg">Escriba el año del acuerdo.</span>
                <span class="textfieldInvalidFormatMsg">El valor debe ser un número entero.</span></span>
              </td>
          </tr>
          <tr valign="baseline">
            <td width="100" align="right" valign="middle" class="btit_3">Número</td>
            <td valign="middle">
              <span id="sprytextfield2">
              <input name="num" type="text" id="num" size="8"  value="" />
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
          <td width="100" align="right" valign="middle"class="btit_3" >Acuerdo</td>
          <td valign="middle" bgcolor="#FFF"><textarea name="descrip" class="ckeditor"  id="descrip"></textarea>
          </td>
        </tr>
        
        
        <tr valign="baseline">
          <td align="right" valign="middle" class="btit_3">Adjuntar archivo</td>
          <td valign="middle"><?php include("../includes/uploadoc.php");?></td>
        </tr>
        
        
        
        
        <tr valign="baseline">
          <td class="btit_3">&nbsp;</td>
          <td><input type="submit" class="bsend" value="Agregar"></td>
        </tr>
          

      </table>
    
    
      <input type="hidden" name="id" value="">
      <input type="hidden" name="file" value="">
      <input type="hidden" name="size" value="">
      <input type="hidden" name="ext" value="">
      <input type="hidden" name="user"  value="<?php echo $_SESSION['u_id']; ?>" />
      <input type="hidden" name="MM_insert" value="form1" />
    </form>
    
    

</td>
    <td width="20" valign="top">&nbsp;</td>
    <td width="250" valign="top"><h2>Opciones</h2>
        <div class="btit_2">Acciones</div>
        <div class="bcont">
        <div class="spacer"><a href="#" onClick="location.reload();"><div class="skin left" style="background-position:-80px -63px;margin-right:3px;"></div>Refrescar p&aacute;gina</a></div>
        <div class="spacer"><a href="../modulos/acu_list.php" >
          <div class="skin left" style="background-position:-48px -79px;margin-right:3px;"></div>
          Cancelar y volver</a></div>
        </div>
        <div class="btit_2">Información</div>
        <div class="bcont2">Rellene los cuadros y luego pulse el boton agregar para almacenar los datos, si desea cancelar puede usar el bot&oacute;n respectivo de la lista de acciones.<br />
        </div>
        </td>
  </tr>
</table>
</div></div></div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {validateOn:["change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "integer", {validateOn:["change"], minValue:1});
</script>
</body>
</html>
