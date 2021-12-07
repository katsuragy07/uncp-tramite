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

$maxRows_rs1 = 50;
$pageNum_rs1 = 0;
if (isset($_GET['pageNum_rs1'])) {
  $pageNum_rs1 = $_GET['pageNum_rs1'];
}
$startRow_rs1 = $pageNum_rs1 * $maxRows_rs1;

mysql_select_db($database_cn1, $cn1);
$query_rs1 = "SELECT fecha, td_tipos_id, COUNT(*) AS tot, DATE_FORMAT(fecha, '%Y-%m-%d') AS dd FROM folioext GROUP BY dd, td_tipos_id ORDER BY fecha DESC";
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
?><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../images/favprint.ico" />
<title>Resumen de los registros - <?php include("../includes/title.php");?></title>
<link href="../css/print.css" rel="Stylesheet" type="text/css" />
<style type="text/css">
@media print{.alert{visibility: hidden;margin-top:-20px;height:0px;padding:0;}.boxes{display:none;}}
</style>

</head>
<body>
<?php include("../includes/print.php");?>
<?php include("../includes/pcab_tram.php");?>
<h1>Resumen de los Registros</h1>
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>


<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><h2>Expedientes por fecha</h2>

      <table width="90%" border="0" cellpadding="0" cellspacing="0" class="tabla">
          <tr>
            <td class="btit_1">Fecha</td>
            <td class="btit_1">Tipo</td>
            <td width="100" align="right" class="btit_1">Cantidad</td>
        </tr>
          <?php $vtota=0; ?>
        <?php do { ?>
          <tr>
            <td><?php echo dptiemp($row_rs1['fecha']); ?></td>
            <td><?php echo dftipo($row_rs1['td_tipos_id'],$row_rs1['t_otro']); ?></td>
            <td width="100" align="right"><?php echo $row_rs1['tot']; ?></td>
          </tr>
            <?php $vtota=$vtota+$row_rs1['tot']; ?>
           <?php } while ($row_rs1 = mysql_fetch_assoc($rs1)); ?>
            <tr>
            <td>&nbsp;</td>
            <td align="right">Total &raquo;</td>
            <td width="100" align="right"><?php echo $vtota; ?></td>
            </tr>
</table>
<?php include("../includes/navbar.php");?>

</td>
  </tr>
</table>

</body>
</html>
<?php
mysql_free_result($rs1);
?>