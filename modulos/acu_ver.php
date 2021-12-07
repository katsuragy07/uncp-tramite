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
  $insertSQL = sprintf("INSERT INTO acuitem (id, nombre, estado, fecha, acuerdos_id) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['nombre'], "text"),
					   GetSQLValueString("Pendiente", "text"),
					   GetSQLValueString($_POST['fecha'], "date"),
					   GetSQLValueString($_POST['acuerdos_id'], "int"));

  mysql_select_db($database_cn1, $cn1);
  $Result1 = mysql_query($insertSQL, $cn1) or die(mysql_error());

  $insertGoTo = "acu_ver.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  
  header(sprintf("Location: %s", $insertGoTo));
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

$colname_rs1 = "-1";
if (isset($_GET['pk'])) {
  $colname_rs1 = $_GET['pk'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs1 = sprintf("SELECT * FROM acuitem WHERE acuerdos_id = %s", GetSQLValueString($colname_rs1, "int"));
$rs1 = mysql_query($query_rs1, $cn1) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
$totalRows_rs1 = mysql_num_rows($rs1);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
#wpag{background:transparent url(../images/pico_6.jpg) no-repeat fixed bottom right;}

.amsj {
	font-size: 9px;
	background:#fff;
	
	text-align: center;
	
	padding: 2px 3px;
	width: 70px;
	
	border: 1px solid #d0d0d0;
	
	border-radius: 		3px;
	-moz-border-radius: 3px;
	
	box-shadow: 		0 0 1px #999;
	-moz-box-shadow: 	0 0 1px #999;
}


.amsj1 { background:#249817; color:#FFF; }
.amsj2 { background:#fff; color:#000; }
.amsj3 { background:#df0050; color:#FFF; }
.amsj0 { background:#f0f0f0; color:#000; }

.stitles{
	color: #098d19;
	text-decoration: underline;
}

.aopera{
	background:#fff url(../images/bgi3.png) repeat-x bottom left;
	
	margin-top: 7px;
	padding: 10px 8px;
	border: 1px solid #add1fd;
	
	border-radius: 		5px;
	-moz-border-radius: 5px;
	
	box-shadow: 		0 0 3px #999;
	-moz-box-shadow: 	0 0 3px #999;
}

</style>
<link href="../css/int.css" rel="Stylesheet" type="text/css" />





<script src="../scripts/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../scripts/SpryValidationTextField.css" rel="stylesheet" type="text/css">

<script type="text/javascript">
function dlitem(ord){if(confirm("Deseas eliminar este registro?")){document.location.href= '../opers/del_acuitem.php?pk=<?php echo $_GET['pk'];?>&fk='+ord;}}
</script> 


</head>
<body>
<div id="container"><div id="wpag"><div id="content">
<h1>Visor de sesiones</h1>
<div class="hr"><em></em><span></span></div>	
<div class="clear" style="height:5px"></div>
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>
<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">
    <h2>Sesión N&deg; <?php echo $row_rs0['num']; ?> - <?php echo $row_rs0['anno']; ?></h2>
    
    
    
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
        <thead>
        <tr valign="baseline">
          <th width="100" align="right" class="btit_1">Item</th>
          <th class="btit_1">Valor</th>
        </tr>
        </thead>
          <tr valign="baseline">
            <td width="100" align="right" valign="middle" class="btit_3">Número</td>
            <td valign="middle">Acuerdo N&deg; <?php echo $row_rs0['num']; ?> - <?php echo $row_rs0['anno']; ?></td>
          </tr>
        <tr valign="baseline">
          <td width="100" align="right" valign="middle" class="btit_3">Fecha</td>
          <td valign="middle">
          <?php echo dfecha5($row_rs0['fecha']); ?>
          </td>
        </tr>
          
          
          <tr valign="baseline">
          <td width="100" align="right" valign="middle" class="btit_3">Sesión</td>
          <td valign="middle" bgcolor="#FFF"><?php echo dbla($row_rs0['descrip']); ?>
          </td>
        </tr>
        
        <tr valign="baseline">
          <td width="100" align="right" valign="middle" class="btit_3">Adjunto</td>
          <td valign="middle" bgcolor="#FFF">
          <?php if($row_rs0['file']!=""){?>
          
          <div style="max-width:300px">
          <table border="0" cellspacing="0" cellpadding="0" class="tablanone">
            <tr>
              <td>
              
              <a href="../data/acuerdos/<?php echo $row_rs0['file'];?>" target="_blank" title="Descargar el archivo adjunto, <?php echo $row_rs0['size'];?>"><img src="../images/<?php echo dtarchivo($row_rs0['ext']);?>" style="border:none;" /></a>
              
              
              
              </td>
              <td>
              <span class="min">
              <strong>Tamaño:</strong> <?php echo dbla($row_rs0['size']);?>
              </span>
              </td>
              <td>
              <span class="min">
              <strong>Tipo:</strong> <?php echo dbla($row_rs0['ext']);?>
              </span>
              </td>
            </tr>
          </table>
         </div> 
          	<?php }else{ ?>No<?php } ?>
          </td>
        </tr>
          

      </table>
   
   
<h3>Acuerdos</h3>


<table width="90%" border="0" cellpadding="0" cellspacing="0" class="tabla2">
          <thead>
          <tr>
          	<th width="10" class="btit_1">&nbsp;</th>

          	<th class="btit_1" width="10%">Estado</th>
            <th align="left" class="btit_1">Objetivo</th>            
            
            <th width="10" class="btit_1">&nbsp;</th>

          </tr>
          </thead>
          <?php if ($totalRows_rs1 > 0) { // Show if recordset not empty ?>
          <?php $cont=0; ?>          
          <?php do { ?>
          <?php $cont++; ?>
          <tr <?php 
		  if ($row_rs1['urgente']==1) echo " class=\"urgente\" ";
		  ?>>

            <td align="center" valign="top">
            <a href="../opers/mod_acuitem.php?pk=<?php echo $_GET['pk'];?>&fk=<?php echo $row_rs1['id']; ?>" title="Modificar"><span class="skin left" style="background-position:-48px -63px;margin-right:3px;"></span></a>
            
            </td>
            
           <td align="center" valign="top">
           
           <?php echo destadoFS($row_rs1['estado']); ?>
           
           
           </td>
            <td align="left" valign="top">
            <?php echo dbla($row_rs1['nombre']); ?>
            
            
            <?php if($row_rs1['fecha_fin']!="" || $row_rs1['descrip']!=""){ ?>
            
            <div class="aopera">
            
            <?php if($row_rs1['fecha_fin']!=""){ ?>
            <strong class="stitles">Fecha de finalización:</strong> <?php echo dfecha5($row_rs1['fecha_fin']); ?>
            <div class="clear" style="height:7px"></div>
            <?php } // Fin IF ?>
            
			<?php if($row_rs1['descrip']!=""){ ?>
            <strong class="stitles">Detalles:</strong> <?php echo dbla($row_rs1['descrip']); ?>
            <?php } // Fin IF ?>
            
            
            </div>
            
            <?php } // Fin IF ?>
              
              
            </td>
            <td valign="top">
<a href="javascript:dlitem(<?php echo $row_rs1['id']; ?>);" title="Eliminar">
<div class="skin left" style="background-position:-64px -63px;margin-right:3px;"></div>
</a>
          </td>

          </tr>
          <?php } while ($row_rs1 = mysql_fetch_assoc($rs1)); ?>          
          <?php } // Show if recordset not empty ?>
      </table>
    
    
    
    </td>
    <td width="20" valign="top">&nbsp;</td>
    <td width="250" valign="top"><h2>Opciones</h2>
        <div class="btit_2">Acciones</div>
        <div class="bcont">
        <div class="spacer"><a href="#" onClick="location.reload();"><div class="skin left" style="background-position:-80px -63px;margin-right:3px;"></div>Refrescar p&aacute;gina</a></div>
        
        <div class="spacer"><a href="acu_list.php" >
          <div class="skin left" style="background-position:-96px -63px;margin-right:3px;"></div>
          Volver a la lista de acuerdos</a></div>
          
        </div>
        
        <div class="btit_2">Agregar acuerdos</div>
        <div class="bcont2">Para agregar nuevos acuerdos a la agenda, rellene el siguiente formulario.</div>
        <div class="bcont2">
          <form method="post" name="form1" action="<?php echo $editFormAction; ?>">          
          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr valign="baseline">
                <td class="normal">Nombre o descripción:</td>
              </tr>
              <tr valign="baseline">
                <td><span id="sprytextfield1">
                  <input name="nombre" type="text" class="tbox1" id="nombre" value=""></span></td>
              </tr>
              <tr valign="baseline">
                <td><input type="submit" class="but1" value="Agregar"></td>
              </tr>
            </table>
              <input type="hidden" name="MM_insert" value="form1">
              <input type="hidden" name="estado"  value="0" />
              <input type="hidden" name="fecha"  value="<?php echo date("Y-m-d H:i:s"); ?>" />
              <input type="hidden" name="acuerdos_id"  value="<?php echo $_GET['pk']; ?>" />
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
//-->
</script>


</body>
</html>
<?php
mysql_free_result($rs0);

mysql_free_result($rs1);

mysql_free_result($rs2);
?>
