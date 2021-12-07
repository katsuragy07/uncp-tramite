<?php require_once('../Connections/cn1.php'); ?>
<?php require_once('../includes/functions.php'); ?>
<?php require_once('../includes/permisos_all_ui.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/int.css" rel="Stylesheet" type="text/css" />
<link href="../css/stream.css" rel="Stylesheet" type="text/css" />

<script type="text/javascript" src="../scripts/jquery.js"></script>

<?php 
$idautom = md5(uniqid(rand(), true)); 
$up_pref="dc".date("His");
$up_url="urstream";
include("../includes/uploadoc_scripts.php");
?>


<script type="text/javascript" src="../scripts/jquery.livequery.js"></script>
<script type="text/javascript" src="../scripts/jquery.elastic.js"></script>
<script type="text/javascript" src="../scripts/jquery.watermarkinput.js"></script>

<script type="text/javascript">

	// <![CDATA[	

	$(document).ready(function(){	
	
		$('#shareButton').click(function(){

			var a = $("#watermark").val();
			var ab = $("#wa_file").val();
			var ac = $("#wa_ext").val();
			var ad = $("#wa_size").val();
			
			if(a != "¿Qué estas pensando?")
			{
				$.post("../urstream/posts.php?value="+a+"&file="+ab+"&ext="+ac+"&size="+ad, {
	
				}, function(response){
					
					$('#posting').prepend($(response).fadeIn('slow'));
					$("#watermark").val("¿Qué estas pensando?");
				});
			}
		});	
		
		
		$('.commentMark').livequery("focus", function(e){
			
			var parent  = $('.commentMark').parent();
			$(".commentBox").children(".commentMark").css('width','320px');
			$(".commentBox").children("a#SubmitComment").hide();
			$(".commentBox").children(".CommentImg").hide();			
		
			var getID =  parent.attr('id').replace('record-','');			
			$("#commentBox-"+getID).children("a#SubmitComment").show();
			$('.commentMark').css('width','300px');
			$("#commentBox-"+getID).children(".CommentImg").show();			
		});	
		
		//showCommentBox
		$('a.showCommentBox').livequery("click", function(e){
			
			var getpID =  $(this).attr('id').replace('post_id','');	
			
			$("#commentBox-"+getpID).css('display','');
			$("#commentMark-"+getpID).focus();
			$("#commentBox-"+getpID).children("CommentImg").show();			
			$("#commentBox-"+getpID).children("a#SubmitComment").show();		
		});	
		
		//SubmitComment
		$('a.comment').livequery("click", function(e){
			
			var getpID =  $(this).parent().attr('id').replace('commentBox-','');	
			var comment_text = $("#commentMark-"+getpID).val();
			
			if(comment_text != "Escriba un comentario...")
			{
				$.post("../urstream/add_comment.php?comment_text="+comment_text+"&post_id="+getpID+"&f_name="+"<?php echo $_SESSION['u_empid']; ?>", {
	
				}, function(response){
					
					$('#CommentPosted'+getpID).append($(response).fadeIn('slow'));
					$("#commentMark-"+getpID).val("Escriba un comentario...");					
				});
			}
			
		});	
		
		//more records show
		$('a.more_records').livequery("click", function(e){
			
			var next =  $('a.more_records').attr('id').replace('more_','');
			
			$.post("../urstream/posts.php?show_more_post="+next, {

			}, function(response){
				$('#bottomMoreButton').remove();
				$('#posting').append($(response).fadeIn('slow'));

			});
			
		});	
		
		//deleteComment
		$('a.c_delete').livequery("click", function(e){
			
			if(confirm('¿Deseas eliminar este comentario?')==false)

			return false;
	
			e.preventDefault();
			var parent  = $('a.c_delete').parent();
			var c_id =  $(this).attr('id').replace('CID-','');	
			
			$.ajax({

				type: 'get',

				url: '../urstream/delete_comment.php?c_id='+ c_id,

				data: '',

				beforeSend: function(){

				},

				success: function(){

					parent.fadeOut(200,function(){

						parent.remove();

					});

				}

			});
		});	
		
		/// hover show remove button
		$('.friends_area').livequery("mouseenter", function(e){
			$(this).children("a.delete").show();	
		});	
		$('.friends_area').livequery("mouseleave", function(e){
			$('a.delete').hide();	
		});	
		/// hover show remove button
		
		
		$('a.delete').livequery("click", function(e){

		if(confirm('¿Deseas eliminar esta publicación?')==false)

		return false;

		e.preventDefault();

		var parent  = $('a.delete').parent();

		var temp    = parent.attr('id').replace('record-','');

		var main_tr = $('#'+temp).parent();

			$.ajax({

				type: 'get',

				url: '../urstream/delete.php?id='+ parent.attr('id').replace('record-',''),

				data: '',

				beforeSend: function(){

				},

				success: function(){

					parent.fadeOut(200,function(){

						main_tr.remove();

					});

				}

			});

		});

		$('textarea').elastic();

		jQuery(function($){

		   $("#watermark").Watermark("¿Qué estas pensando?");
		   $(".commentMark").Watermark("Escriba un comentario...");

		});

		jQuery(function($){

		   $("#watermark").Watermark("watermark","#369");
		   $(".commentMark").Watermark("watermark","#EEEEEE");

		});	

		function UseData(){

		   $.Watermark.HideAll();

		   //Do Stuff

		   $.Watermark.ShowAll();

		}

	});	

	// ]]>

</script>


</head>
<body>
<div id="container"><div id="wpag">
	<div id="content">





<h1>Intranet Municipal</h1>
<div class="hr"><em></em><span></span></div>

<div class="clear" style="height:5px"></div>


<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>


<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">
    <h2><?php echo $_SESSION['u_nombre']; ?></h2>
    
    <div class="clear" style="height:3px"></div>
    
    <div align="center">
	
		<form action="" method="post" name="postsForm">
	
		<div class="UIComposer_Box">
        	<div class="ui-content">
            
            <div class="msgui">Escriba el mensaje que desea compartir.</div>
	
		<span class="w">
		<textarea class="input" id="watermark" name="watermark" style="height:20px"></textarea>
        <input name="file" id="wa_file" type="hidden" />
        <input name="ext" id="wa_ext" type="hidden" />
        <input name="size" id="wa_size" type="hidden" />
		</span>
	
			<br clear="all" />
			
			<div align="left" style="height:30px; padding:0 5px;">
				
			<div class="clear" style="height:10px"></div>
            
            <div class="left" style="width:80%">
                <?php include("../includes/uploadoc2.php");?>
            </div>    
				<a id="shareButton" class="smallbutton Detail right logbu">Compartir</a>
	
			</div>
            
            </div>
		</div>
	
		</form>
	
		<br clear="all" />
        
        <div class="hr"><em></em><span></span></div>
        <div class="clear" style="height:10px"></div>
	
		<div id="posting" align="center">
	
		<?php include_once('../urstream/posts.php');?>
		  
		</div>
	</div>
     
     
     
     
     
     
     
      </td>
    <td width="20" valign="top">&nbsp;</td>
    <td width="250" valign="top">
<div class="btit_2"><?php echo $_SESSION['u_nombre']; ?></div>
<div class="bcont"  style="background-color:#FFF;border:1px solid #CCC;border-top:none;">
<img src="../data/users/<?php echo $_SESSION['u_foto']; ?>" class="CommentImg" style="float:left;" width="225" alt="" />
<div class="clear"></div>
</div>
    
    
    
    <h2>Opciones</h2>



<div class="btit_2">Acciones</div><div class="bcont">

<div class="spacer"><a href="#" onClick="location.reload();"><div class="skin left" style="background-position:-80px -63px;margin-right:3px;"></div>Refrescar p&aacute;gina</a></div>

<div class="spacer"><a href="../opers/mod_td_nuevo.php?pk=<?php echo $_GET['pk']; ?>" >
  <div class="skin left" style="background-position:-48px -63px;margin-right:3px;"></div>
  Configurar mi cuenta
</a></div>


</div></td>
  </tr>
</table>
</div></div></div>

</body>
</html>
