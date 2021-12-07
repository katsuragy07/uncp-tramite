<?php
ini_set( "display_errors", 0); ?>
<?php
$path = "../data/urstream/";

$valid_formats_img = array("jpg", "jpeg", "gif", "png");

function bytesConvert($bytes){
    $ext = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $unitCount = 0;
    for(; $bytes > 1024; $unitCount++) $bytes /= 1024;
    return round($bytes,1) ." ". $ext[$unitCount];
}
function dtarchivo($var1){
	switch ($var1){
		case "avi":return "ico_avi.png";break;
		case "doc":return "ico_doc.png";break;
		case "docx":return "ico_docx.png";break;
		case "dwg":return "ico_dwg.png";break;
		case "exe":return "ico_exe.png";break;
		case "mp3":return "ico_mp3.png";break;
		case "mpg":return "ico_mpg.png";break;
		case "pdf":return "ico_pdf.png";break;
		case "ppt":return "ico_ppt.png";break;
		case "pptx":return "ico_pptx.png";break;
		case "pub":return "ico_pub.png";break;
		case "rar":return "ico_rar.png";break;
		case "rtf":return "ico_rtf.png";break;
		case "wav":return "ico_wav.png";break;
		case "wma":return "ico_wma.png";break;
		case "wmv":return "ico_wmv.png";break;
		case "xls":return "ico_xls.png";break;
		case "xlsx":return "ico_xlsx.png";break;
		case "zip":return "ico_zip.png";break;
		case "rar":return "ico_rar.png";break;
		case "jpg":return "ico_img.png";break;
		case "jepg":return "ico_img.png";break;
		case "bmp":return "ico_img.png";break;
		case "gif":return "ico_img.png";break;
		case "png":return "ico_img.png";break;
		default:return "ico_no.png";break;
	}
}

 
 

if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
	{
	$name = $_FILES['current_image']['name'];
	$size = $_FILES['current_image']['size'];

	if(strlen($name))
		{
		list($txt, $ext) = explode(".", $name);
			if($size<(1024*1024*10))
			{
				$actual_image_name = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
				$tmp = $_FILES['current_image']['tmp_name'];

				if(move_uploaded_file($tmp, $path.$actual_image_name))
					{
						$eSize=bytesConvert($_FILES["current_image"]["size"]);
						echo "<input type='hidden' id='ima_file' value='".$actual_image_name."'>";
						echo "<input type='hidden' id='ima_ext' value='".$ext."'>";
						echo "<input type='hidden' id='ima_size' value='".$eSize."'>";
						
						  $duurl="../images/".$actual_image_name;
						  $dexrl=dtarchivo($ext);
						   
                    
                    	if(in_array($ext, $valid_formats_img)){
						echo "<img src='../data/urstream/".$actual_image_name."'  class='showthumb' width='150'>";
						}else{
							
							if($actual_image_name!=""){
								echo '<img src="../images/'
										.$dexrl
										.'?nocache=123" alt="" class="img_uplo"/>';
    //echo '<span class="rojo"><a href="javascript:quita();">[x] Quitar el archivo</a></span>';
                     		}  
					 
						}
						echo '<div class="min">Tipo: <strong>'.strtoupper($ext)
								.'</strong>, Tama&ntilde;o: <strong>'.$eSize
								.'</strong><div>';
					}
					else
					echo "Parece que hubo un error, intentelo nueavamente.";
			}
			else
			echo "Lo sentimos, pero el tama&ntilde;o m&aacute;ximo es de 10MB";					

		}
		else
		echo "Seleccione un archivo v&aacute;lido.";
	exit;
	}
?>