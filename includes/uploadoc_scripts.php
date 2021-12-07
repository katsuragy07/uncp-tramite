<script type="text/javascript" src="../scripts/ajaxupload.3.5.js"></script>
<?php 
if($up_val=="") {
	$up_id=$up_pref.$idautom;
}else{
	$up_id=substr($up_val,0,-4);
}
?>
<script type="text/javascript" >
	$(function(){
		var btnUpload=$('#upload');
		var status=$('#status');
		new AjaxUpload(btnUpload, {
			action: '../includes/uploadoc_file.php?nm=<?php echo $up_id;?>&ub=<?php echo $up_url;?>',
			name: 'uploadfile',
			onSubmit: function(file, ext){
				document.forms[0].ext.value = ext;
				document.getElementById('cam').innerHTML = '<img src="../images/loader.gif" alt="Cargando..." /><br /><span class="ti4b">Cargando la imagen al servidor<br />La carga tardar&aacute; aproximadamente de unos <strong>20 a 50 segundos</strong>. <br />Si la carga demora demasiado es debido a que el <strong>archivo es muy pesado</strong>.</span>';
			},
			onComplete: function(file, response){
				status.text('');
				cext=new Array("avi","doc","docx","dwg","exe","mp3","mpg","pdf","ppt","pptx","pub","rar","rtf","wav","wma","wmv","xls","xlsx","zip","jpg","bmp","gif","png");
				if(response!=="error"){
					var ntp="<?php echo $up_id;?>"+file.substr(file.lastIndexOf(".")).toLowerCase();
					var cvar=(ntp.substring(ntp.lastIndexOf(".")+1)).toLowerCase();
					var ind, pos,cres;pos=-1;
					for(ind=0; ind<cext.length; ind++){
						if (cext[ind]==cvar){
							pos=cext[ind];
							break;
						}
					}
					cres=pos;
					if(pos==-1) cres="no";					
					cres="ico_"+cres+".png";
					$('<li></li>').appendTo('#files').html('<img src="../images/'+cres+'?nocache='+Math.random()+'" alt="" class="img_uplo"/><br /><div class="cel_3" align="center"></div>').addClass('success');
					$("#subir").hide();
					document.forms[0].file.value = ntp;
					document.forms[0].size.value = response;
					document.getElementById('cam').innerHTML = '<span class="rojo"><a href="javascript:quita();">[x] Quitar este archivo</a></span>';
				} else{
					$('<li></li>').appendTo('#files').text("Error al subir: "+file).addClass('error');
				}
			}
		});
		
	});
	function quita(){
	$("ul").empty();
	document.forms[0].file.value = "";
	document.forms[0].ext.value = "";
	document.forms[0].size.value = "";
	$("#subir").show();
	document.getElementById('cam').innerHTML = '';
	}
</script>
<style>
#upload{
margin:10px 0 0 0; 
padding:8px 10px 0 0;
font-weight: bold; 
font-size: 14px;
font-family: Arial, Helvetica, sans-serif;
text-align:right; 
color: #0066cc;
width: 125px; height: 27px; cursor:pointer !important;
background:#eef4fb url(../images/bgpb.png) repeat-x top left;
border:1px solid #c2c4c5;
-moz-border-radius:3px;-webkit-border-radius:3px;
-moz-box-shadow:0 1px 2px #ddd;
-webkit-box-shadow:0 1px 2px #ddd;    	
}

.darkbg{background:#ddd !important;}
#status{font-family: Arial; padding: 5px;}
ul#files{list-style: none; padding: 0; margin: 0;}
ul#files li{padding: 0; width: auto; float: center;}
.upsuccess{
margin-top:10px;
}
.error{background: #f0c6c3; border: 1px solid #cc6622;}
</style>