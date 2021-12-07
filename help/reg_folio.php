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

mysql_select_db($database_cn1, $cn1);
$query_rs1 = "SELECT VERSION() AS version";
$rs1 = mysql_query($query_rs1, $cn1) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
$totalRows_rs1 = mysql_num_rows($rs1);
?>
<?php
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO empleado (id, nombre, apellido, mail, oficinas_id, encargado) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['apellido'], "text"),
							  GetSQLValueString($_POST['mail'], "text"),
							  GetSQLValueString($_POST['oficinas_id'], "int"),
                       GetSQLValueString($_POST['encargado'], "int"));

  mysql_select_db($database_cn1, $cn1);
  $Result1 = mysql_query($insertSQL, $cn1) or die(mysql_error());

  $insertGoTo = "mperso.php?pk=".$_GET['pk'];
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
<style>
#wpag{background:transparent url(../images/pico_10.jpg) no-repeat fixed bottom right;}
</style>

<script type="text/javascript">function dlitem(ord){if(confirm("Deseas eliminar este registro?")){document.location.href= '../opers/del_perso.php?pk='+ord;}}</script> 

</head>
<body>
 <div id="container"><div id="wpag"><div id="content">

<h1><span id="result_box" lang="es" xml:lang="es"><span title="">Ayuda y soporte técnico</span></span></h1>
<div class="hr"><em></em><span></span></div>

<div class="clear" style="height:5px"></div>
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>


<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><h2>Folios</h2>
      <h3><img src="help-13.jpg" width="46" height="58" class="left" style="margin-right:15px" />Registrar Folio </h3>
      <p>Para registrar un folio de un clic sobre el botón respectivo de la cinta de opciones, luego cargara un formulario para completar los datos relacionados al folio.</p>
      <p><strong>Nota: </strong>Las oficinas disponibles dependerán de los Lugares y Personal creado por el Administrador del Sistema.</p>
      <p><strong><img src="help-14.jpg" width="127" height="85" class="right" style="margin-left:15px" /></strong>Los Administradores Básicos del Módulo de Gestión Documentaria podrán Agregar y Revisar el Historial completo de los folios registrados desde el grupo &quot;Operaciones&quot; de la cinta de opciones.</p>
      <h3>Recientes</h3>
      <p>Contiene una página con un buscador y un archivo paginado de todos los folios registradosen todas las oficinas, dando un clic sobre la &quot;Firma y Asunto&quot; podrá ver los detalles del folio y el estado en que se encuentra, tambien puede imprimir el seguimimiento desde el botón respectivo de las acciones de la página.</p>
      <h2>Folios de Oficina</h2>
      <img src="help-15.jpg" width="198" height="85" class="right" style="margin-left:15px" />
      <p>Este grupo de opciones estará disponible para todas las oficinas con acceso simple al módulo de &quot;Gestión Documentaria&quot; con el podrá realizar una serie de acciones cómodas para el trabajo con folio como:</p>
      <p><strong>Nota: </strong>Las acciones y folios recibidos estarán relacionadas con su cuenta de usuario, es decir que sólo podrá ver los folios enviados, derivados, y archivados a la oficina asociada con su cuenta. Para cambiar de oficina y perfiles consulte con el administrador del sistema.</p>
      <h3>Recibir</h3>
      <p>Muestra todos los folios derivados a la oficina actual, contiene las acciones:</p>
      <ol>
        <li><strong>Recibir: </strong>Para marcar un folio como recibido (El folio se ocultará y estara disponible en el botón de recibidos).</li>
        <li><strong>Derivar:</strong> Para derivar directamente un folio recibido.</li>
        <li><strong>Archivar: </strong>Para terminar el curso del folio y guardarlo en el archivo de la oficina actual.</li>
      </ol>
      <h3>Recibidos</h3>
      <p>Muestra todos los folios marcados como recibidos y tambien los derivados a oficina actual, contiene las acciones para &quot;Derivar&quot; ó &quot;Archivar&quot; un folio.</p>
      <h3>Archivos</h3>
      <p>Contiene todos los folios archivados en la oficina actual, puede dar un clic en la firma o asunto para ver los detalles y el seguimiento del folio.</p>
      <p><strong>Nota: </strong>Las acciones &quot;Recibir&quot;, &quot;Derivar&quot; y &quot;Archivar&quot; generan un registro que se almacena para realizar el seguimiento de los folios, es decir si tenemos un folio en &quot;Recibidos&quot; y directamente lo archivamos se generarán dos registros, el primero marcando que el folio fue recibido en la oficina actual y el segundo indicando que el folio fue archivado.</p>
      </td>
    <td width="20" valign="top">&nbsp;</td>
    <td width="250" valign="top"><?php include("../includes/bar_help.php");?></td>
  </tr>
</table>
</div></div></div>

</body>
</html>
<?php
mysql_free_result($rs1);
?>
