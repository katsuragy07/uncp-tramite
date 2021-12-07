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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form")) {
  $updateSQL = sprintf("UPDATE const SET tipo=%s, nivel=%s, fech_const=%s, ar_const=%s, e1=%s, e2=%s, a1=%s, a2=%s, a3=%s, a4=%s, i1=%s, clasi=%s, mat=%s, conserv=%s, fecha=%s, `user`=%s WHERE id=%s",
                       GetSQLValueString($_POST['tipo'], "int"),
                       GetSQLValueString($_POST['nivel'], "int"),
                       GetSQLValueString($_POST['fech_const'], "date"),
                       GetSQLValueString($_POST['ar_const'], "double"),
                       GetSQLValueString($_POST['e1'], "int"),
                       GetSQLValueString($_POST['e2'], "int"),
                       GetSQLValueString($_POST['a1'], "int"),
                       GetSQLValueString($_POST['a2'], "int"),
                       GetSQLValueString($_POST['a3'], "int"),
                       GetSQLValueString($_POST['a4'], "int"),
                       GetSQLValueString($_POST['i1'], "int"),
                       GetSQLValueString($_POST['clasi'], "int"),
                       GetSQLValueString($_POST['mat'], "int"),
                       GetSQLValueString($_POST['conserv'], "int"),
                       GetSQLValueString($_POST['fecha'], "date"),
                       GetSQLValueString($_POST['user'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_cn1, $cn1);
  $Result1 = mysql_query($updateSQL, $cn1) or die(mysql_error());

  $updateGoTo = "../modulos/verpredio_cnst.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rs1 = "-1";
if (isset($_GET['pr'])) {
  $colname_rs1 = $_GET['pr'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs1 = sprintf("SELECT * FROM predio WHERE id = %s", GetSQLValueString($colname_rs1, "int"));
$rs1 = mysql_query($query_rs1, $cn1) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
$totalRows_rs1 = mysql_num_rows($rs1);

$colname_rs2 = "-1";
if (isset($_GET['pk'])) {
  $colname_rs2 = $_GET['pk'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs2 = sprintf("SELECT * FROM const WHERE id = %s", GetSQLValueString($colname_rs2, "int"));
$rs2 = mysql_query($query_rs2, $cn1) or die(mysql_error());
$row_rs2 = mysql_fetch_assoc($rs2);
$totalRows_rs2 = mysql_num_rows($rs2);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/int.css" rel="Stylesheet" type="text/css" />
<style>
#wpag{background:transparent url(../images/pico_6.jpg) no-repeat fixed bottom right;}
</style>

<script src="../scripts/SpryValidationTextField.js" type="text/javascript"></script>
<script type="text/javascript">
function cant(num){
var1=document.forms[0].fech_const.value;
var2=document.forms[0].antig.value;
annos=<?php echo $_GET['anno'];?>;
salid="";
	switch(num){
		case 1:
		salid=annos-parseInt(var1.substr(0,4));
		if(salid==0)salid=1;
		document.forms[0].antig.value=salid;
		break;
		case 2:
		salid=annos-var2;
		document.forms[0].fech_const.value=salid+var1.substr(4);
		break;
	}
}
</script>

<link href="../scripts/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container"><div id="wpag"><div id="content">
<h1>Predio <span style="color:#FF9900"><?php echo $_GET['anno']?></span>  &raquo;  <?php echo "<strong> ".$row_rs1['cod']."</strong> - ".ddiret($row_rs1['dir_tipo'],1).$row_rs1['dir_nombre'].ddirnu($row_rs1['dir_num'],$row_rs1['dir_dpto'],$row_rs1['dir_mz'],$row_rs1['dir_lote']); ?></h1>
<div class="hr"><em></em><span></span></div>
<div class="clear" style="height:5px"></div>
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>
<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">
    <h2>Descripción de construcción</h2>
      <form action="<?php echo $editFormAction; ?>" name="form" method="POST">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">
    <h3>Datos Generales</h3>
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
        <tr valign="baseline">
          <td width="150" align="right" class="btit_1">Item</td>
          <td class="btit_1">Valor</td>
          </tr>
        <tr valign="baseline">
          <td width="150" align="right" valign="middle" class="btit_3">Construcción</td>
          <td valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabla3">
            <tr>
              <td width="90" align="right" class="btit_3">Tipo                </td>
              <td><select name="tipo" id="tipo">
                <option value="1" <?php if (!(strcmp(1, $row_rs2['tipo']))) {echo "selected=\"selected\"";} ?>>Piso</option>
                <option value="2" <?php if (!(strcmp(2, $row_rs2['tipo']))) {echo "selected=\"selected\"";} ?>>Azotea</option>
                <option value="3" <?php if (!(strcmp(3, $row_rs2['tipo']))) {echo "selected=\"selected\"";} ?>>Sótano</option>
              </select></td>
            </tr>
            <tr>
              <td width="90" align="right" class="btit_3">Nivel</td>
              <td><span id="sprytextfield3">
              <input name="nivel" type="text" id="nivel" value="<?php echo $row_rs2['nivel']; ?>" size="5" />
              <span class="textfieldInvalidFormatMsg">Número entero</span></span></td>
            </tr>
            <tr>
              <td width="90" align="right" class="btit_3">Fecha de construcción </td>
              <td><span id="sprytextfield2">
              <input name="fech_const" type="text" id="fech_const" value="<?php echo $row_rs2['fech_const']; ?>" size="12" onchange="cant(1);" /><span class="textfieldInvalidFormatMsg">Año-mes-dia</span></span> </td>
            </tr>
            <tr>
              <td width="90" align="right" class="btit_3">Antigüedad</td>
              <td><span id="sprytextfield4">
              <input name="antig" type="text" id="antig" value="<?php echo date("Y")-substr($row_rs2['fech_const'],0,4); ?>" size="5" onchange="cant(2);"/>
              <span class="textfieldInvalidFormatMsg">Número entero</span></span> 
                Años</td>
            </tr>
            <tr>
              <td align="right" class="btit_3">Área construida</td>
              <td><span id="sprytextfield1">
              <input name="ar_const" type="text" id="ar_const" value="<?php echo $row_rs2['ar_const']; ?>" size="7" />
              <span class="textfieldInvalidFormatMsg">Número Ej. 150.50</span></span> m2</td>
            </tr>
          </table></td>
        </tr>
        <tr valign="baseline">
          <td width="150" align="right" valign="middle" class="btit_3">Clasificación</td>
          <td valign="middle"><select name="clasi" id="clasi">
              <option value="1" <?php if (!(strcmp(1, $row_rs2['clasi']))) {echo "selected=\"selected\"";} ?>>Casa Habitación</option>
              <option value="2" <?php if (!(strcmp(2, $row_rs2['clasi']))) {echo "selected=\"selected\"";} ?>>Tienda Depósito o Almacén</option>
              <option value="3" <?php if (!(strcmp(3, $row_rs2['clasi']))) {echo "selected=\"selected\"";} ?>>Edificio ó Predio en Edificio</option>
              <option value="4" <?php if (!(strcmp(4, $row_rs2['clasi']))) {echo "selected=\"selected\"";} ?>>Oficina, Hospital, Cine, Industria, Taller, etc</option>
          </select></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" class="btit_3">Material Estructural Predominante</td>
          <td valign="middle"><select name="mat" id="mat">
              <option value="1" <?php if (!(strcmp(1, $row_rs2['mat']))) {echo "selected=\"selected\"";} ?>>Concreto</option>
              <option value="2" <?php if (!(strcmp(2, $row_rs2['mat']))) {echo "selected=\"selected\"";} ?>>Ladrillo</option>
              <option value="3" <?php if (!(strcmp(3, $row_rs2['mat']))) {echo "selected=\"selected\"";} ?>>Adobe (Quincha o madera)</option>
          </select></td>
        </tr>
        <tr valign="baseline" id="hos1" name="hos1">
          <td align="right" valign="middle" class="btit_3">Estado de Conservación</td>
          <td valign="middle"><select name="conserv" id="conserv">
              <option value="1" <?php if (!(strcmp(1, $row_rs2['conserv']))) {echo "selected=\"selected\"";} ?>>Muy Bueno</option>
              <option value="2"  <?php if (!(strcmp(2, $row_rs2['conserv']))) {echo "selected=\"selected\"";} ?>>Bueno</option>
              <option value="3" <?php if (!(strcmp(3, $row_rs2['conserv']))) {echo "selected=\"selected\"";} ?>>Regular</option>
              <option value="4" <?php if (!(strcmp(4, $row_rs2['conserv']))) {echo "selected=\"selected\"";} ?>>Malo</option>
                    </select></td>
        </tr>
        <tr valign="baseline">
          <td width="150">&nbsp;</td>
          <td><input name="Submit" type="submit" class="but1" value="Modificar"></td>
          </tr>
      </table></td>
    <td width="2%">&nbsp;</td>
    <td width="250" valign="top">
    <h3>Categorias</h3>
    <table border="0" cellpadding="0" cellspacing="0" class="tabla2">
    <tr>
              <td align="right" class="btit_1">&nbsp;</td>
              <td align="right" class="btit_1">Item</td>
              <td class="btit_1">Valor</td>
            </tr>
            <tr>
              <td rowspan="2" align="right" class="btit_3">Estructura</td>
              <td align="right" class="min">Muros y
columnas</td>
              <td><select name="e1" id="e1">
                <option value="1" <?php if (!(strcmp(1, $row_rs2['e1']))) {echo "selected=\"selected\"";} ?>>A</option>
                <option value="2" <?php if (!(strcmp(2, $row_rs2['e1']))) {echo "selected=\"selected\"";} ?>>B</option>
                <option value="3" <?php if (!(strcmp(3, $row_rs2['e1']))) {echo "selected=\"selected\"";} ?>>C</option>
                <option value="4" <?php if (!(strcmp(4, $row_rs2['e1']))) {echo "selected=\"selected\"";} ?>>D</option>
                <option value="5" <?php if (!(strcmp(5, $row_rs2['e1']))) {echo "selected=\"selected\"";} ?>>E</option>
                <option value="6" <?php if (!(strcmp(6, $row_rs2['e1']))) {echo "selected=\"selected\"";} ?>>F</option>
                <option value="7" <?php if (!(strcmp(7, $row_rs2['e1']))) {echo "selected=\"selected\"";} ?>>G</option>
                <option value="8" <?php if (!(strcmp(8, $row_rs2['e1']))) {echo "selected=\"selected\"";} ?>>H</option>
<option value="9" <?php if (!(strcmp(9, $row_rs2['e1']))) {echo "selected=\"selected\"";} ?>>I</option>
              </select></td>
            </tr>
            <tr>
              <td align="right" class="min">Techos</td>
              <td><select name="e2" id="e2">
                <option value="1" <?php if (!(strcmp(1, $row_rs2['e2']))) {echo "selected=\"selected\"";} ?>>A</option>
                <option value="2" <?php if (!(strcmp(2, $row_rs2['e2']))) {echo "selected=\"selected\"";} ?>>B</option>
                <option value="3" <?php if (!(strcmp(3, $row_rs2['e2']))) {echo "selected=\"selected\"";} ?>>C</option>
                <option value="4" <?php if (!(strcmp(4, $row_rs2['e2']))) {echo "selected=\"selected\"";} ?>>D</option>
                <option value="5" <?php if (!(strcmp(5, $row_rs2['e2']))) {echo "selected=\"selected\"";} ?>>E</option>
                <option value="6" <?php if (!(strcmp(6, $row_rs2['e2']))) {echo "selected=\"selected\"";} ?>>F</option>
                <option value="7" <?php if (!(strcmp(7, $row_rs2['e2']))) {echo "selected=\"selected\"";} ?>>G</option>
                <option value="8" <?php if (!(strcmp(8, $row_rs2['e2']))) {echo "selected=\"selected\"";} ?>>H</option>
<option value="9" <?php if (!(strcmp(9, $row_rs2['e2']))) {echo "selected=\"selected\"";} ?>>I</option>
              </select></td>
            </tr>
            <tr>
              <td rowspan="4" align="right" class="btit_3">Acabados</td>
              <td align="right" class="min">Pisos</td>
              <td><select name="a1" id="a1">
                <option value="1" <?php if (!(strcmp(1, $row_rs2['a1']))) {echo "selected=\"selected\"";} ?>>A</option>
                <option value="2" <?php if (!(strcmp(2, $row_rs2['a1']))) {echo "selected=\"selected\"";} ?>>B</option>
                <option value="3" <?php if (!(strcmp(3, $row_rs2['a1']))) {echo "selected=\"selected\"";} ?>>C</option>
                <option value="4" <?php if (!(strcmp(4, $row_rs2['a1']))) {echo "selected=\"selected\"";} ?>>D</option>
                <option value="5" <?php if (!(strcmp(5, $row_rs2['a1']))) {echo "selected=\"selected\"";} ?>>E</option>
                <option value="6" <?php if (!(strcmp(6, $row_rs2['a1']))) {echo "selected=\"selected\"";} ?>>F</option>
                <option value="7" <?php if (!(strcmp(7, $row_rs2['a1']))) {echo "selected=\"selected\"";} ?>>G</option>
                <option value="8" <?php if (!(strcmp(8, $row_rs2['a1']))) {echo "selected=\"selected\"";} ?>>H</option>
<option value="9" <?php if (!(strcmp(9, $row_rs2['a1']))) {echo "selected=\"selected\"";} ?>>I</option>
              </select></td>
            </tr>
            
            <tr>
              <td align="right" class="min">Puertas y
ventanas</td>
              <td><select name="a2" id="a2">
                <option value="1" <?php if (!(strcmp(1, $row_rs2['a2']))) {echo "selected=\"selected\"";} ?>>A</option>
                <option value="2" <?php if (!(strcmp(2, $row_rs2['a2']))) {echo "selected=\"selected\"";} ?>>B</option>
                <option value="3" <?php if (!(strcmp(3, $row_rs2['a2']))) {echo "selected=\"selected\"";} ?>>C</option>
                <option value="4" <?php if (!(strcmp(4, $row_rs2['a2']))) {echo "selected=\"selected\"";} ?>>D</option>
                <option value="5" <?php if (!(strcmp(5, $row_rs2['a2']))) {echo "selected=\"selected\"";} ?>>E</option>
                <option value="6" <?php if (!(strcmp(6, $row_rs2['a2']))) {echo "selected=\"selected\"";} ?>>F</option>
                <option value="7" <?php if (!(strcmp(7, $row_rs2['a2']))) {echo "selected=\"selected\"";} ?>>G</option>
                <option value="8" <?php if (!(strcmp(8, $row_rs2['a2']))) {echo "selected=\"selected\"";} ?>>H</option>
<option value="9" <?php if (!(strcmp(9, $row_rs2['a2']))) {echo "selected=\"selected\"";} ?>>I</option>
              </select></td>
            </tr>
            <tr>
              <td align="right" class="min">Revestimientos</td>
              <td><select name="a3" id="a3">
                <option value="1" <?php if (!(strcmp(1, $row_rs2['a3']))) {echo "selected=\"selected\"";} ?>>A</option>
                <option value="2" <?php if (!(strcmp(2, $row_rs2['a3']))) {echo "selected=\"selected\"";} ?>>B</option>
                <option value="3" <?php if (!(strcmp(3, $row_rs2['a3']))) {echo "selected=\"selected\"";} ?>>C</option>
                <option value="4" <?php if (!(strcmp(4, $row_rs2['a3']))) {echo "selected=\"selected\"";} ?>>D</option>
                <option value="5" <?php if (!(strcmp(5, $row_rs2['a3']))) {echo "selected=\"selected\"";} ?>>E</option>
                <option value="6" <?php if (!(strcmp(6, $row_rs2['a3']))) {echo "selected=\"selected\"";} ?>>F</option>
                <option value="7" <?php if (!(strcmp(7, $row_rs2['a3']))) {echo "selected=\"selected\"";} ?>>G</option>
                <option value="8" <?php if (!(strcmp(8, $row_rs2['a3']))) {echo "selected=\"selected\"";} ?>>H</option>
<option value="9" <?php if (!(strcmp(9, $row_rs2['a3']))) {echo "selected=\"selected\"";} ?>>I</option>
              </select></td>
            </tr>
            <tr>
              <td align="right" class="min">Baños</td>
              <td><select name="a4" id="a4">
                <option value="1" <?php if (!(strcmp(1, $row_rs2['a4']))) {echo "selected=\"selected\"";} ?>>A</option>
                <option value="2" <?php if (!(strcmp(2, $row_rs2['a4']))) {echo "selected=\"selected\"";} ?>>B</option>
                <option value="3" <?php if (!(strcmp(3, $row_rs2['a4']))) {echo "selected=\"selected\"";} ?>>C</option>
                <option value="4" <?php if (!(strcmp(4, $row_rs2['a4']))) {echo "selected=\"selected\"";} ?>>D</option>
                <option value="5" <?php if (!(strcmp(5, $row_rs2['a4']))) {echo "selected=\"selected\"";} ?>>E</option>
                <option value="6" <?php if (!(strcmp(6, $row_rs2['a4']))) {echo "selected=\"selected\"";} ?>>F</option>
                <option value="7" <?php if (!(strcmp(7, $row_rs2['a4']))) {echo "selected=\"selected\"";} ?>>G</option>
                <option value="8" <?php if (!(strcmp(8, $row_rs2['a4']))) {echo "selected=\"selected\"";} ?>>H</option>
<option value="9" <?php if (!(strcmp(9, $row_rs2['a4']))) {echo "selected=\"selected\"";} ?>>I</option>
              </select></td>
            </tr>
            <tr>
              <td align="right" class="btit_3">Instalaciones</td>
              <td align="right" class="min">Electricas y 
                sanitarias</td>
              <td><select name="i1" id="i1">
                <option value="1" <?php if (!(strcmp(1, $row_rs2['i1']))) {echo "selected=\"selected\"";} ?>>A</option>
                <option value="2" <?php if (!(strcmp(2, $row_rs2['i1']))) {echo "selected=\"selected\"";} ?>>B</option>
                <option value="3" <?php if (!(strcmp(3, $row_rs2['i1']))) {echo "selected=\"selected\"";} ?>>C</option>
                <option value="4" <?php if (!(strcmp(4, $row_rs2['i1']))) {echo "selected=\"selected\"";} ?>>D</option>
                <option value="5" <?php if (!(strcmp(5, $row_rs2['i1']))) {echo "selected=\"selected\"";} ?>>E</option>
                <option value="6" <?php if (!(strcmp(6, $row_rs2['i1']))) {echo "selected=\"selected\"";} ?>>F</option>
                <option value="7" <?php if (!(strcmp(7, $row_rs2['i1']))) {echo "selected=\"selected\"";} ?>>G</option>
                <option value="8" <?php if (!(strcmp(8, $row_rs2['i1']))) {echo "selected=\"selected\"";} ?>>H</option>
<option value="9" <?php if (!(strcmp(9, $row_rs2['i1']))) {echo "selected=\"selected\"";} ?>>I</option>
              </select></td>
            </tr>
          </table>
<h2>Nota:</h3>
<p>Para agregar un nuevo piso debe considerar los datos generales y las categorias.</p></td>
    </tr>
</table>
<input type="hidden" name="id" value="<?php echo $row_rs2['id']; ?>">
<input type="hidden" name="fecha" value="<?php echo date("Y-m-d H:i:s");?>">
<input type="hidden" name="user" value="<?php echo $_SESSION['u_id']; ?>">
<input type="hidden" name="MM_update" value="form" />
</form>

</td>
    <td width="20" valign="top">&nbsp;</td>
    <td width="250" valign="top"><h2>Opciones</h2>
        <div class="btit_2">Acciones</div>
        <div class="bcont">
        <div class="spacer"><a href="javascript:location.reload();"><div class="skin left" style="background-position:-80px -63px;margin-right:3px;"></div>Refrescar p&aacute;gina</a></div>
        <div class="spacer"><a href="../modulos/verpredio_cnst.php?<?php echo dlanno($_GET['anno']);?>pr=<?php echo $_GET['pr']?>" >
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
cant(1);
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "real", {validateOn:["change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "date", {validateOn:["change"], format:"yyyy-mm-dd"});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "integer", {validateOn:["change"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "integer", {validateOn:["change"]});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($rs1);

mysql_free_result($rs2);

?>
