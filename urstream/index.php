<?php require_once('../Connections/cn1.php'); ?>
<?php require_once('../includes/functions.php'); ?>
<?php require_once('../includes/permisos_all_ui.php'); ?>
<?php
$show_comments_per_page = 2;
$user_id = $_SESSION['u_empid']; // it should be dynamic with current logged in ID
$logged_id = $_SESSION['u_empid'];

$memberPic = getUserImg($logged_id);
$logged_user_pic = $_SESSION['u_foto'];
?>
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
  $insertSQL = sprintf("INSERT INTO ur_tema (id, nombre, descrip, alcalde) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['nombre'], "text"),
					   GetSQLValueString($_POST['descrip'], "text"),
					   GetSQLValueString(isset($_POST['alcalde']) ? "true" : "", "defined","1","0"));

  mysql_select_db($database_cn1, $cn1);
  $Result1 = mysql_query($insertSQL, $cn1) or die(mysql_error());

  $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  
  header(sprintf("Location: %s", $insertGoTo));
}



$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rs1 = 10;
$pageNum_rs1 = 0;
if (isset($_GET['pageNum_rs1'])) {
  $pageNum_rs1 = $_GET['pageNum_rs1'];
}
$startRow_rs1 = $pageNum_rs1 * $maxRows_rs1;


mysql_select_db($database_cn1, $cn1);
$query_rs1 = "SELECT * FROM ur_tema WHERE alcalde =0 ORDER BY nombre ASC";
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



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta charset="gb18030">

<title>Intranet Municipal</title>
<link href="../css/int.css" rel="Stylesheet" type="text/css" />


<script src="../scripts/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../scripts/SpryValidationTextField.css" rel="stylesheet" type="text/css">

<script type="text/javascript">function dlitem(ord){if(confirm("Deseas eliminar este registro?")){document.location.href= '../urstream/del_tema.php?pk='+ord;}}</script>

<link href="wall.css" type="text/css" rel="stylesheet" />
<link type="text/css" href="fb/stylesheet.css" rel="stylesheet">
<style>
div.grippie {
	margin-left: 5px;
	float:left;
	width: 345px;
}
.resizable-textarea textarea {
	overflow: auto;
	display:block;
	margin-bottom:0pt;
	width:50%;
	height: 30%;

}
.commentMark{
	overflow:auto;
}
.bgchatt{
	background-position:top left;
}
.more_records:hover{
	border-color:#add1ff;
	background: #e9f2ff url("../images/bg_el.png") repeat-x top left;
}
</style>

</head>
<body>


<div id="container"><div id="wpag">
	<div id="content">
    
    

<div class="btam">

<div class="rbbtn botimg" id="uit" style="margin-right:3px;"><a  href="#" onClick="location.reload();">
<span class="icon ico_big" style="background-position:-25px -135px"></span>
<div class="botimg_con"><strong>Refrescar</strong><br/>
<span>p&aacute;gina</span></div>
</a></div>

<?php if($_SESSION['u_level'] == 0){ ?>
<div class="rbbtn botimg" id="uit" style="margin-right:3px;"><a href="wall_alcalde.php">
<span class="icon ico_big" style="background-position:0px -111px"></span>
<div class="botimg_con"><strong>Muro</strong><br/>
<span>del Rector</span></div>
</a></div>
<?php } ?>


<div class="rbbtn botimg" id="uit" style="margin-right:3px;"><a href="index.php">
<span class="icon ico_big" style="background-position:-25px -111px"></span>
<div class="botimg_con"><strong>Noticias</strong><br/>
<span>En general</span></div>
</a></div>

</div>

<h1>Intranet</h1>

<div class="hr"><em></em><span></span></div>

<div class="clear" style="height:5px"></div>


<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>


<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">

<h2>Bienvenido &raquo; <?php echo $_SESSION['u_nombre']; ?></h2>
    
    <div class="clear" style="height:8px"></div>
    
    <div align="center" class="bgchatt">
    
<div style="width: 99%; padding:5px;">


    <h3 style="margin:0;padding:0;">Indice de temas</h3>
    
    <div class="clear" style="height:0px"></div>
<div class="wrap" align="center" id="show_img_upload_div" style="padding-top:10px; display:none">
<div align="left" >


<div id="showthumb">
</div>

</div>

</div>




<br clear="all">


<div class="hr"><em></em><span></span></div>


<div class="clear" style="height:20px"></div>


<?php do { ?>


<?php
$colname_rs0 = "-1";
if (isset($row_rs1["id"])) {
  $colname_rs0 = $row_rs1["id"];
}

mysql_select_db($database_cn1, $cn1);
$query_rs0 = sprintf("SELECT ur_posts.*
,(SELECT CONCAT(apellido,', ',nombre) FROM empleado WHERE id=ur_posts.empid) as nombre
FROM ur_posts WHERE ur_tema_id=%s", GetSQLValueString($colname_rs0, "int"));
$rs0 = mysql_query($query_rs0, $cn1) or die(mysql_error());
$row_rs0 = mysql_fetch_assoc($rs0);
$totalRows_rs0 = mysql_num_rows($rs0);
?>
	

<div class="tema">

<a href="wall.php?te=<?php  echo $row_rs1['id']?>" class="more_records2">&raquo; <?php  echo $row_rs1['nombre']?></a>
<div class="commentPanel2" align="left" style="width:550px;">
<div class="commTem"><?php echo $row_rs1['descrip'];?></div>
	<div class="clear"></div>
    



<?php
$n_tems= $totalRows_rs0;
$ncomTXT="";

switch(true){
	case ($n_tems==0): $ncomTXT="Sin publicaciones"; break;
	case ($n_tems==1): $ncomTXT="1 publicaci&oacute;n"; break;
	case ($n_tems>1): $ncomTXT=$n_tems." publicaciones"; break;
}

?>



<div class="yxTEM" align="left">


	<?php if($_SESSION['u_level'] == 0){ ?>
        <div class="min right">
        <a href="mod_tema.php?pk=<?php  echo $row_rs1['id']?>">[Editar]</a> 
        <a href="javascript:dlitem(<?php  echo $row_rs1['id']?>);">[Eliminar]</a>
        </div>    
    <?php } ?>
    
        
    <div class="Ko">
    <?php echo $ncomTXT?>
    </div>
     
</div>






    
    
    
</div>

<div class="clear"></div>


</div>


<?php } while ($row_rs1 = mysql_fetch_assoc($rs1)); ?>




<div class="clear"></div>


<br clear="all" /><br clear="all" />



</div>

</div>
     
     
     
     
     
     
     
      </td>
    <td width="20" valign="top">&nbsp;</td>
    <td width="250" valign="top">
<div class="btit_2"><?php echo $_SESSION['u_nombre']; ?></div>
<div class="bcont"  style="background-color:#FFF;border:1px solid #CCC;border-top:none;">
<img src="../data/users/<?php echo isblanc($_SESSION['u_foto']); ?>" class="CommentImg" style="float:left;" width="225" alt="" />
<div class="clear"></div>
</div>
    
    
    
    <h2>Opciones</h2>



<div class="btit_2">Acciones</div>
<div class="bcont">

<div class="spacer"><a href="#" onClick="location.reload();"><div class="skin left" style="background-position:-80px -63px;margin-right:3px;"></div>Refrescar p&aacute;gina</a></div>

<div class="spacer"><a href="../modulos/account.php" >
          <div class="skin left" style="background-position:-96px 0px;margin-right:3px;"></div>
          Configurar mi cuenta</a></div>


</div>


<?php if($_SESSION['u_level'] == 0){ ?>

<div class="btit_2">Agregar un nuevo tema</div>
<div class="bcont2">Para agregar nuevos temas rellene el siguiente formulario.</div>
<div class="bcont2">
  <form method="post" name="form1" action="<?php echo $editFormAction; ?>">          
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr valign="baseline">
        <td class="normal">Nombre del tema:</td>
      </tr>
      <tr valign="baseline">
        <td><span id="sprytextfield1">
          <input name="nombre" type="text" class="tbox1" id="nombre" value=""></span></td>
      </tr>
      <tr valign="baseline">
        <td class="normal">Descripción:</td>
      </tr>
      <tr valign="baseline">
        <td><span id="sprytextfield1">
          <textarea name="descrip" rows="3" class="tbox1" id="descrip"></textarea>
        </span></td>
      </tr>
     
      <tr valign="baseline">
        <td height="30" valign="middle"><input name="alcalde" type="checkbox" id="alcalde" value="1" />
          <label for="alcalde">Privado para el Alcalde</label></td>
      </tr>
      <tr valign="baseline">
        <td><input type="submit" class="but1" value="Agregar"></td>
      </tr>
    </table>
      <input type="hidden" name="MM_insert" value="form1">
      <input type="hidden" name="id" value="">
  </form>
  </div>

<?php }  ?>
</td>
  </tr>
</table>
</div></div></div>






<div id="popUpDiv" style="display:none;"> 
<a href="javascript:;" onclick="popup('popUpDiv')"><img border="0" src="hide.png" alt="Close" title="Close" /></a> 
<div>
<span></span>
<div id="comment_part"></div>
</div>

</div>

<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
//-->
</script>
</body>
</html>



<?php
mysql_free_result($rs1);
?>
