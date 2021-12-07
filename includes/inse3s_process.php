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

$colname_rs2 = "-1";
if (isset($_GET['opcion'])) {
  $colname_rs2 = $_GET['opcion'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs2 = sprintf("SELECT * FROM provincia WHERE depart_id = %s ORDER BY nombre ASC", GetSQLValueString($colname_rs2, "int"));
$rs2 = mysql_query($query_rs2, $cn1) or die(mysql_error());
$row_rs2 = mysql_fetch_assoc($rs2);
$totalRows_rs2 = mysql_num_rows($rs2);

$colname_rs3 = "-1";
if (isset($_GET['opcion'])) {
  $colname_rs3 = $_GET['opcion'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs3 = sprintf("SELECT * FROM distrito WHERE provincia_id = %s ORDER BY nombre ASC", GetSQLValueString($colname_rs3, "int"));
$rs3 = mysql_query($query_rs3, $cn1) or die(mysql_error());
$row_rs3 = mysql_fetch_assoc($rs3);
$totalRows_rs3 = mysql_num_rows($rs3);



// Array que vincula los IDs de los selects declarados en el HTML con el nombre de la tabla donde se encuentra su contenido
$listadoSelects=array(
"select1"=>"select_1",
"select2"=>"select_2",
"select3"=>"select_3"
);

function validaSelect($selectDestino)
{
	// Se valida que el select enviado via GET exista
	global $listadoSelects;
	if(isset($listadoSelects[$selectDestino])) return true;
	else return false;
}

function validaOpcion($opcionSeleccionada)
{
	// Se valida que la opcion seleccionada por el usuario en el select tenga un valor numerico
	if(is_numeric($opcionSeleccionada)) return true;
	else return false;
}

$selectDestino=$_GET["select"]; $opcionSeleccionada=$_GET["opcion"];

if(validaSelect($selectDestino) && validaOpcion($opcionSeleccionada)){
	
	if($selectDestino=="select3"){
	echo "<select name='select3' id='select3' style='width:100%' onChange=\"asig(3,this.value);\">";
	echo "<option value='0'>Elige &raquo;</option>";
	do{
		$registro[1]=htmlentities($registro[1]);
		echo "<option value='".$row_rs3['id']."'>".$row_rs3['nombre']."</option>";
	} while ($row_rs3 = mysql_fetch_assoc($rs3));	
	echo "</select>";
		
	}else{	
	// Comienzo a imprimir el select
	echo "<select name='".$selectDestino."' id='".$selectDestino."' style='width:100%' onChange='cargaContenido(this.id)'>";
	echo "<option value='0'>Elige &raquo;</option>";
	do{
		$registro[1]=htmlentities($registro[1]);
		echo "<option value='".$row_rs2['id']."'>".$row_rs2['nombre']."</option>";
	} while ($row_rs2 = mysql_fetch_assoc($rs2));	
	echo "</select>";
	
	}
}

mysql_free_result($rs2);

mysql_free_result($rs3);
?>
