<?php require_once('../includes/functions.php'); ?>
<?php require_once('../includes/permisos_all_ui.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
    <td valign="top"><h2>Interfáz de usuario</h2>
        <p>Al iniciar su sesión verá que la interfáz del sistema es muy semejante a la de MS Office 2010 y el funcionamiento junto con las operaciones tambien lo son, de este modo podrá usar el sistema con más facilidad y comodidad.</p>
        <p>La cinta de opciones o ribbon es un elemento de las interfaces gráficas en el cual van    ubicadas todas las funcionalidades de una aplicación y siempre esta ubicado en la parte superior del sistema.</p>
        <p align="center"><img src="../help/help-02.jpg" width="700" height="329" /></p>
        <img src="../help/help-01.png" width="276" height="236" class="right" style="margin-left:15px" />
        <h2>Partes de la interfáz</h2>
        <h3>Botón escritorio</h3>
        <p>Con este botón podrá cambiar a la pantalla de inicio para realizar las configuraciones básicas de su cuenta y tambien para ver los mensajes del sistema.</p>
        <h3>A.- Cinta</h3>
        <p>Cada cinta contiene una serie de grupos y botones para interactuar con el sistema en este caso cada cinta representa un sistema y estarán activas según el sistema al que tenga acceso.</p>
        <h3>B.- Grupos</h3>
        <p>Dentro de la cinta de opciones verá todos los botones agrupados según su funcionalidad.</p>
        <h3>C.- Botón</h3>
        <p>Con los botones podrá direccionarse y navegar por el sistema, tenga en consideración que los botones y sus acciones dependen del grupo al que pertenezcan.</p>
        <h3><img src="../help/help-03.jpg" width="234" height="31" class="right" style="margin-left:15px" />Opciones rápidas</h3>
        <p>Son opciones que permiten realizar la tareas comunes como: </p>
        <ul>
          <li><strong>Cerrar sesión.-</strong> Para terminar la sesión actual</li>
          <li><strong>Duplicar ventana.-</strong> Para crear una nueva ventana con acceso al sistema (Al terminar la sesión todas las ventanas ya no podrán seguir interactuando con el servidor).</li>
          <li><strong>Configurar la cuenta.-</strong> Para acceder al panel de configuración de su cuenta de usuario.</li>
          <li><strong>Contraer o expander.-</strong> Con este boton podrá ocultar o mostrar la cinta de opciones, con ello podrá ampliar el área de trabajo en las páginas con contenido amplio. Tambien puede contraer la cinta de opciones dando un doble clic sobre el nombre de la cinta y para expanderla solo tiene tiene que hacer un clic simple sobre cualquier cinta.</li>
          <li><strong>Ayuda.-</strong> Para acceder a los temas de ayuda.</li>
        </ul>
        <h3>Barra de estado</h3>        
        <p>A la izquierda muestra el nombre del empleado (Usuario) conectado y a la derecha muestra la hora en la que inició su sesión, tambien tiene dos botones que sirven para:</p>
        <div align="center"><img src="../help/help-04.jpg" width="659" height="23" />        </div>
        <ul>
          <li>Contenido.- Para actualizar sólo el contenido del sistema.</li>
          <li>Ventana.- Para actualizar la página completa.</li>
        </ul>
        <p>Puede usar estas opciones para recargar el contenido rápidamente o también cuando la respuesta del servidor demora demasiado.</p>
        
        <ol>
          <li>Barra normal.</li>
          <li>Mouse sobre la barra (Cambia a color naranja)</li>
          <li>Boton contraer o mostrar el panel dentro de la interfáz.<br />
        </li>
        </ol>
        </td>
    <td width="20" valign="top">&nbsp;</td>
    <td width="250" valign="top"><?php include("../includes/bar_help.php");?></td>
  </tr>
</table>
</div></div></div>

</body>
</html>
