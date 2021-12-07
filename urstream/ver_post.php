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


$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rs1 = 10;
$pageNum_rs1 = 0;
if (isset($_GET['pageNum_rs1'])) {
  $pageNum_rs1 = $_GET['pageNum_rs1'];
}
$startRow_rs1 = $pageNum_rs1 * $maxRows_rs1;


$colname_rs1 = "-1";
if (isset($_GET["id"])) {
  $colname_rs1 = $_GET["id"];
}

mysql_select_db($database_cn1, $cn1);
$query_rs1 = sprintf("SELECT ur_posts.*
,(SELECT CONCAT(nombre, ', ', apellido) FROM empleado WHERE id=ur_posts.empid) AS nombre 
,(SELECT foto FROM empleado WHERE id=ur_posts.empid) AS foto
,(SELECT sexo FROM empleado WHERE id=ur_posts.empid) AS sexo
FROM ur_posts WHERE id=%s ORDER BY fecha DESC", GetSQLValueString($colname_rs1, "int"));
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
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Intranet</title>
<link href="../css/int.css" rel="Stylesheet" type="text/css" />

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>  
<script src="fb/jquery.livequery.js" type="text/javascript"></script>
<script src="jquery.form.js" type="text/javascript"></script>
<script type="text/javascript">
(function($){var textarea,staticOffset;var iLastMousePos=0;var iMin=32;var grip;$.fn.TextAreaResizer=function(){return this.each(function(){textarea=$(this).addClass('processed'),staticOffset=null;$(this).wrap('<div class="resizable-textarea"><span></span></div>').parent().append($('<div class="grippie"></div>').bind("mousedown",{el:this},startDrag));var grippie=$('div.grippie',$(this).parent())[0];grippie.style.marginRight=(grippie.offsetWidth-$(this)[0].offsetWidth)+'px'})};function startDrag(e){textarea=$(e.data.el);textarea.blur();iLastMousePos=mousePosition(e).y;staticOffset=textarea.height()-iLastMousePos;textarea.css('opacity',0.25);$(document).mousemove(performDrag).mouseup(endDrag);return false}function performDrag(e){var iThisMousePos=mousePosition(e).y;var iMousePos=staticOffset+iThisMousePos;if(iLastMousePos>=(iThisMousePos)){iMousePos-=5}iLastMousePos=iThisMousePos;iMousePos=Math.max(iMin,iMousePos);textarea.height(iMousePos+'px');if(iMousePos<iMin){endDrag(e)}return false}function endDrag(e){$(document).unbind('mousemove',performDrag).unbind('mouseup',endDrag);textarea.css('opacity',1);textarea.focus();textarea=null;staticOffset=null;iLastMousePos=0}function mousePosition(e){return{x:e.clientX+document.documentElement.scrollLeft,y:e.clientY+document.documentElement.scrollTop}}})(jQuery);
</script>

<script>


$(document).ready(function() {
	$('textarea.resizable:not(.processed)').TextAreaResizer();
	$('iframe.resizable:not(.processed)').TextAreaResizer();
});

$(document).ready(function(){	
	$('#shareButtons').click(function(){	
		//var tmptxt = document.getElementById("watermark");		
		var a = $("#commentMark").val();
		//var a = nl2br(tmptxt.value);
		if(a != "")
		{
		
			var posted_on = "<?php echo $_GET['id'];?>";
			var ptema = "<?php echo $_GET['id'];?>";
			
			$.post("add_comment.php?value="+escape(a)+'&p='+posted_on, {

			}, function(response){
				$("#watermark").val("");
				location.reload();
			});
		}
	});
	
							  
});	

</script>


<script type="text/javascript">
function dlcom(ord){
	if(confirm("¿Deseas eliminar este registro?"))
	{
		$.post("del_comment.php?id="+ord, {

		}, function(response){
			cadena="#cv"+ord;
			$(cadena).animate( {backgroundColor:'red'}, 1000).fadeOut(1000,function() {
				$(cadena).remove();
			});
		});
	}
}
</script>
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
<span>del Decano</span></div>
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

<?php
$ankt="";

if($_GET['al']==1){
	$ankt='<h3>Muro del alcalde</h3>';
}
echo $ankt;
?>


    <div class="clear" style="height:15px"></div>
    
    <div align="center" class="bgchatt">
    
<div style="width: 99%; padding:5px;">


    <h3 style="margin:0;padding:0;">Ver publicación de: <?php echo dptiemp($row_rs1['fecha']);?></h3>
    
    <div class="clear" style="height:0px"></div>
<div class="wrap" align="center" id="show_img_upload_div" style="padding-top:10px; display:none">
<div align="left" >

<form action="ajax_image_uploading.php" id="ajaxuploadfrm" method="post" enctype="multipart/form-data" >
<b class="msgui">Seleccione el archivo que desea adjuntar.</b><br />
Puede ser en los formatos: PDF, DOC, XLS, PPT, MP3, ZIP, RAR, JPG, etc.
<br />
<input type="file" name="current_image" id="current_image" />
</form>
<br />
<div id="showthumb">
</div>

<div id="shareImageDiv" align="left" style="display:none">
<br clear="all" />
<div style=" margin-bottom:10px ; margin-right:0px;" class="gbuttonnew ">
<div role="button" class="gbutton" aria-disabled="true" style="-webkit-user-select: none; opacity:1 " id="shareImageButton">Compartir</div>
</div>
</div>
</div>

</div>




<br clear="all">


<div class="hr"><em></em><span></span></div>



<div class="friends_area" id="dv<?php  echo $row_rs1['id']?>">

<?php 
$user_avatar_2 = $row_rs1['foto'];
$user_id_2 = $row_rs1['empid'];
$fname_2 = $row_rs1['nombre'];
$s_memberPic = getUserImg($row_rs1['empid']);
?>


<a href="#1" title="Ver muro">
<img src="<?php echo $s_memberPic;?>" style="float:left; padding-right:9px;" width="50" height="50" border="0" alt="" />
</a>
<label style="float:left; width: 520px;" class="name">
<b>
<a href="ver_post.php?id=<?php echo $row_rs1['id']; ?>" title="Ver completo">
<?php echo $fname_2; ?>
</a>
</b>


<br clear="all" /> 
<div class="name" style="text-align:justify;float:left;">
<em>
<?php  

$html ='';
$html .= '<em>';
$pdata = $row_rs1['post'];
$html .= '<div class="attach_content2" style="width:510px;">'.$pdata.'<br />';
$img = $row_rs1["file"];
$urls = '../data/urstream/'.$img;
$clickc = $urls;
$html .= '<div class="atc_images2s"> <a href="'.$clickc.'" target="_blank" title="Clic para descargar...">';
$valid_formats_img = array("jpg", "jpeg", "gif", "png");
$ext= $row_rs1["ext"];
$size= $row_rs1["size"];
$dexrl=dtarchivo($ext);
if(in_array($ext, $valid_formats_img)){
	$html .= '<div class="atflise2">';
	$html .= "<img src='../data/urstream/".$img."'  class='showthumb' width='150'>";
	$html .= '<div class="sprimer tbfile">';
	$html .= 'Tipo: <strong>'.strtoupper($ext).'</strong>, Tama&ntilde;o: <strong>'.$size.'</strong></div>';
	$html .= '<div class="clear"></div>';
	$html .= "</div>";
}else{
	if($img!=""){
		$html .= '<div class="atflise">';
		$html .= '<img src="../images/'
				.$dexrl
				.'" alt="" class="img_uplo left" width="40"/>';
		$html .= '<div class="sprimer tbfile left">Archivo adjunto<br />';
		$html .= 'Tipo: <strong>'.strtoupper($ext).'</strong>, Tama&ntilde;o: <strong>'.$size.'</strong></div>';
		$html .= "</div>";
	}  

}

//=====================
 
$html .= '</a>';
$html .= '</div>';
$html .= '</div>';
$html .= '</em>';
echo $html;
?>
</em>
<div class="clear"></div>

<?php
$colname_rs2 = "-1";
if (isset($row_rs1["id"])) {
  $colname_rs2 = $row_rs1["id"];
}

mysql_select_db($database_cn1, $cn1);
$query_rs2 = sprintf("SELECT ur_posts_comments.*
,(SELECT CONCAT(apellido,', ',nombre) FROM empleado WHERE id=ur_posts_comments.empid) AS nombre
,(SELECT foto FROM empleado WHERE id=ur_posts_comments.empid) AS foto
FROM ur_posts_comments WHERE post_id=%s", GetSQLValueString($colname_rs2, "int"));
$rs2 = mysql_query($query_rs2, $cn1) or die(mysql_error());
$row_rs2 = mysql_fetch_assoc($rs2);
$totalRows_rs2 = mysql_num_rows($rs2);
?>
<div style="height:10px;">
<span>
Publicado: 
<?php
$number_of_comments= $totalRows_rs2;
?>
<?php  
$crfecha=crt_datetime($row_rs1['fecha']);
$days = floor($crfecha / (60 * 60 * 24)); 
$remainder = $crfecha % (60 * 60 * 24);
$hours = floor($remainder / (60 * 60));
$remainder = $remainder % (60 * 60);
$minutes = floor($remainder / 60);
$seconds = $remainder % 60;

if($days > 0) {
	$postFecha = dptiemp($row_rs1['fecha']); 
	echo $postFecha;
} 

elseif($days == 0 && $hours == 0 && $minutes == 0)
echo "Hace unos segundos";		
elseif($hours)
echo "Hace ".$hours.' horas';
elseif($days == 0 && $hours == 0)
echo "Hace ".$minutes.' minutos';
else
echo "Hace unos segundos"; ?>
</span> 
&nbsp;<div onclick="javascript:window.location.hash='#comentar';" class="zx2">Comentar &dArr;</div> 


</div>
</div>	
</label>

<?php if($_SESSION['u_level'] == 10000){ ?>
<a href="javascript:dlpost(<?php  echo $row_rs1['id']?>);" class="delete_pa" style="color:#ff0000;"><img src="hide.png" border="0" title="Eliminar esta publicación" /></a>
<?php } ?>

<br clear="all" /><br clear="all" />

<a name="comment" id="comment"></a>
<?php if($totalRows_rs2 > 0){?>

<div class="Vr yx" align="left" onclick="javascript:window.location='#comment';">
	<span role="button" class="a-j ug Ss" tabindex="0"></span>
    <div class="Ko">
    	<span role="button" class="a-j zx" tabindex="0">
        <span class="Fw tx"><?php echo $number_of_comments?></span>
        <span class="ux"> comentarios</span>
        </span>
        
    </div>
</div>

<?php }?>


<div id="CommentPosted<?php  echo $row_rs1['p_id']?>">
<div id="loadComments<?php  echo $row_rs1['p_id']?>" style="display:none"></div>
<?php

if($totalRows_rs2 > 0){



$days2 = floor($row_rs2['fecha'] / (60 * 60 * 24));
$remainder = $row_rs2['fecha'] % (60 * 60 * 24);
$hours = floor($remainder / (60 * 60));
$remainder = $remainder % (60 * 60);
$minutes = floor($remainder / 60);
$seconds = $remainder % 60;		?>

<?php $ccont=0;?>

<?php do{ ?>
<?php 
$ccont++;
$comm_avatar = getUserImg($row_rs2['empid']);
?>
<div class="commentPanel" align="left" id="cv<?php echo $row_rs2['id'];?>">

<a href="javascript:;">
<img src="<?php echo $comm_avatar;?>" style="float:left; padding-right:9px;" width="40" height="40" border="0" alt="" />
</a>

<label class="name">
<b>
<a href="javascript:;">
<?php echo $row_rs2['nombre'];?>
</a>
</b>
<div class="name" style="text-align:justify;float:left;">
<em><?php echo $row_rs2['comments'];?></em>
</div>
<br/>
<div style="width:350px;float:right;">
<div style="float:left; padding-top:3px;">
<span class="timeanddate">
<?php
if($days2 > 0) 
{
$row_rs2['fecha'] = dptiemp($row_rs2['fecha']); 

echo $row_rs2['fecha'];

} 
elseif($days2 == 0 && $hours == 0 && $minutes == 0)
 echo "Hace unos segundos";			
elseif($hours)
echo "Hace ".$hours.' horas';
elseif($days2 == 0 && $hours == 0)
echo "Hace ".$minutes.' minutos';
else
echo "Hace unos segundos";?>
</span>

<?php if($_SESSION['u_level'] == 0){ ?>
&nbsp;<a href="javascript:dlcom(<?php echo $row_rs2['id'];?>)" id="CID-<?php  echo $rows['c_id'];?>" class="c_delete">Eliminar</a>
<?php }?>


</div>

<span></span>
</div>
<div class="clear"></div>

</label>
</div>

<?php } while ($row_rs2 = mysql_fetch_assoc($rs2)); ?>
<?php } ?>	


<a name="comentar" id="comentar"></a>


<div class="commentBox" align="right" style="background-color:#f5f7fa">

<img src="<?php echo $memberPic;?>" style="float:left; padding-right:6px;" width="37" height="37" border="0" alt="" class="CommentImg" />
<div style="margin-left:45px;">
<input type="hidden" id="owner<?php  echo $row['p_id'];?>" value="<?php  echo $row['posted_by']?>" />
<label id="record-<?php  echo $row['p_id'];?>">
<textarea name="commentMark" rows="3" wrap="hard" class="commentMark resizable" id="commentMark" style="background-color:#fff;width:345px;" placeholder="Escriba su comentario"></textarea>
</label>
</div>

<div class="clear" style="height:5px"></div>
	
   
<div role="button" class="gbutCom left" aria-disabled="true" style="-webkit-user-select: none; " id="shareButtons">Comentar</div>

 <br clear="all" />
    
    
</div>
			

</div>


</div>
<?php mysql_free_result($rs2); ?>




<div class="clear"></div>


<br clear="all" /><br clear="all" />

<?php
$linkt="wall";
$talink="";

if($_GET['al']==1){
	$linkt="wall_alcalde";
	$talink="&al=1";
}

?>
<div id="bottomMoreButton" >

<a href="wall.php?te=<?php echo $row_rs1['ur_tema_id'].$talink;?>" class="more_records" name="2">&laquo; Volver al tema</a>
</div>


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



<div class="btit_2">Temas de ayuda</div>
<div class="bcont">

<div class="spacer"><a href="../modulos/help.php" >
          <div class="skin left" style="background-position:0px -16px;margin-right:3px;"></div>
          Interf&aacute;z de usuario</a></div>
          <div class="spacer"><a href="../help/acerca.php" >
          <div class="skin left" style="background-position:0px -16px;margin-right:3px;"></div>
          Acerca del sistema</a></div>
          
</div>


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


</body>
</html>



<?php
mysql_free_result($rs1);
?>
