<?php require_once("../includes/permisos_main.php"); ?>
<?php require_once("../includes/functions_UI.php"); ?>
<?php 
$vrs1=$_SESSION['u_level'];
$vrs2=$_SESSION['u_sis'];
$vrs3=$_SESSION['u_perf'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="es" />
<title><?php include("../includes/title.php");?></title>
<link rel="shortcut icon" href="../images/favicon.ico" />
<link rel="stylesheet" type="text/css" href="../css/layout.css" />
<script type="text/javascript" src="../scripts/jquery.js"></script>
<script type="text/javascript">

eval(function(p,a,c,k,e,r){e=function(c){return c.toString(a)};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('2 3;$(4).8(1(){$().5();$(\'9.a-6 b\').c(1(){$().5({6:$(d).e(\'g\').h(7)})});3=$(\'i\').j({k:l,m:0,n:o,p:q,r:0})});1 s(){2 f=4.t(\'u\');f.v.w.x(y)}',35,35,'|function|var|myLayout|document|Ribbon|theme||ready|ul|ribbon|li|click|this|attr||class|substring|body|layout|south__size|22|south__spacing_open|south__resizable|false|north__size|120|north__spacing_open|rcont|getElementById|mainFrame|contentWindow|location|reload|true'.split('|'),0,{}))


</script>
</head>
<body>
<h1>Cargando la interf&aacute;z</h1>
<h2>Espere por favor...</h2>
<iframe id="mainFrame" name="mainFrame" class="ui-layout-center" src="../modulos/main.php" frameborder="0" scrolling="auto"></iframe>
<div class="ui-layout-north"><?php include("../includes/ribbon.php");?></div><div class="ui-layout-south"><div id="stbar"><div class="content">
<div class="left">Usuario: <?php echo $_SESSION['u_nombre']; ?> <span class="spbar">|</span><?php echo $_SESSION['u_nofice']; ?><span class="spbar">|</span></div><div class="right"><span class="spbar">|</span> <a href="javascript:rcont();" title="Forzar recarga del contenido">Contenido</a> <span class="spbar">|</span> <a href="javascript:location.reload();" title="Forzar recarga de toda la ventana">Ventana</a> <span class="spbar">|</span> Sesi&oacute;n iniciada a las <?php echo lcok("sdate");?></div>
<div class="clear"></div></div></div></div>
<?php if($_SESSION['u_sis']!=1){ ?>
<div id="descone" class="botright" style="right:133px;width:96px;" title="Desconectarse de la sesi&oacute;n actual"><span class="skin1 right" style="background-position:-80px 0px"></span><em>Desconectar</em></div>
<div id="../urstream/index" class="rbbtn botright" style="right:108px;" title="Intranet"><span class="skin1" style="background-position:-112px 0px"></span></div>
<?php }else{ ?>
<div id="descone" class="botright" style="right:108px;width:96px;" title="Desconectarse de la sesi&oacute;n actual"><span class="skin1 right" style="background-position:-80px 0px"></span><em>Desconectar</em></div>
<?php } ?>


<div id="botdup" class="botright" style="right:83px;" title="Duplicar ventana"><span class="skin1" style="background-position:-16px -16px"></span></div>
<div id="account" class="rbbtn botright" style="right:58px;" title="Configurar la cuenta"><span class="skin1" style="background-position:-96px 0px"></span></div>
<div id="botrgle" class="botright" style="right:33px;" title="Contraer o expander la cinta de opciones"><span class="skin1" style="background-position:-32px -63px"></span></div>
<div id="help" class="rbbtn botright" style="right:8px;" title="Ayuda"><span class="skin1" style="background-position:0px -63px"></span></div>
<a class="descon"><div id="menorb"></div></a>

</body>
</html> 