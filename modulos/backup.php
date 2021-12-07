<?php require_once('../Connections/cn1.php'); ?>
<?php require_once('../includes/functions.php'); ?>
<?php require_once('../includes/permisos_adm.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/int.css" rel="Stylesheet" type="text/css" />
<style>
#wpag{background:transparent url(../images/pico_12.jpg) no-repeat fixed bottom right;}
</style>
</head>
<body>
<div id="container"><div id="wpag"><div id="content">

<h1>Base de datos</h1>
<div class="hr"><em></em><span></span></div>

<div class="clear" style="height:5px"></div>
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>
<?php
$DirPath="../../dumper/work/backup/";
$mydir_list="";
if (($handle=opendir($DirPath)))
{
$files = array();
$times = array();
	while ($node = readdir($handle)){
		$nodebase = basename($node);
		if ($nodebase!="." && $nodebase!=".."){
			if(!is_dir($DirPath.$node)){
				$pos1 = strrpos($node,".gz");
				$pos2 = strrpos($node,".sql");
				if($pos1===false && $pos2===false){
				}else{
					//export to xml
					$filestat = stat($DirPath.$node);
					$times[] = $filestat['mtime'];
					$files[] = $DirPath.$node;
					//$mydir_list.="<img src=\"".$DirPath.$node."\" />\n";
					array_multisort($times, SORT_NUMERIC, SORT_DESC, $files);
				}
			}
		}
	}
}
$cnt=0;
$largt=strlen($DirPath);
?>

<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><h2>Copias de seguridad del sistema</h2>
        <table width="90%" border="0" cellpadding="0" cellspacing="0" class="tabla">
          <tr>
            <td width="20" align="center" class="btit_1">#</td>
            <td class="btit_1">Nobre</td>
            <td class="btit_1">Tamaño</td>
            <td class="btit_1">Fecha</td>
            </tr>
<?php 
function bytesConvert($bytes){
    $ext = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $unitCount = 0;
    for(; $bytes > 1024; $unitCount++) $bytes /= 1024;
    return round($bytes,1) ." ". $ext[$unitCount];
}
$cnt=1;
$largt=strlen($DirPath);
	foreach($files as $file){
		$fed=dptiemp(date("Y-m-d H:i:s",filectime($file)));
		$tam=bytesConvert(filesize($file));
		$nom=substr($file,$largt);
?>
          <tr>
            <td width="20" align="center"><?php echo $cnt; ?></td>
            <td><a href="<?php echo $file ?>" target="_blank"><?php echo $nom; ?></a></td>
            <td><?php echo $tam; ?></td>
            <td><?php echo $fed; ?></td>
            </tr>
<?php 
		$cnt++;
		if($cnt>15) break;
}
?>
      </table></td>
    <td width="20" valign="top">&nbsp;</td>
    <td width="250" valign="top"><h2>Opciones</h2>
        <div class="btit_2">Acciones</div>
        <div class="bcont">
        <div class="spacer"><a href="#" onClick="location.reload();"><div class="skin left" style="background-position:-80px -63px;margin-right:3px;"></div>Refrescar p&aacute;gina</a></div>
        </div>
        <div class="btit_2">Informaci&oacute;n</div>
        <div class="bcont">Para descargar de un clic derecho sobre el enlace y luego elija la opción que dice: &quot;Guardar enlace como&quot;.</div>
        </td>
  </tr>
</table>
</div></div></div>
</body>
</html>