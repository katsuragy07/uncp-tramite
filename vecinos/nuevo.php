<?php require_once('../Connections/cn1.php');
session_start();
if($_SESSION['positivo']==true){
    if(time()-$_SESSION['actividad'] >300){
        session_destroy();
        header('Location: index.html');
    }

$token=$_GET['token'];
mysql_select_db($database_cn1, $cn1);
$sqldatoscli="SELECT * FROM vecino WHERE `codigodeactivacion`='$token'";
$resdatos = mysql_query($sqldatoscli, $cn1) or die(mysql_error());
$row_resdatos = mysql_fetch_assoc($resdatos);

?>
<?php require_once('../includes/functions.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

mysql_select_db($database_cn1, $cn1);
$query_rs1 = "SELECT oficinas.id, CONCAT(lugares.nombre,' - ',oficinas.nombre) AS nombre FROM oficinas, lugares WHERE oficinas.id!=109 and oficinas.lugares_id = lugares.id ORDER BY lugares.id, nombre ASC";
$rs1 = mysql_query($query_rs1, $cn1) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
$totalRows_rs1 = mysql_num_rows($rs1);

$colname_rs2 = "-1";
if (isset($_SESSION['u_empid'])) {
  $colname_rs2 = $_SESSION['u_empid'];
}
mysql_select_db($database_cn1, $cn1);
$query_rs2 = sprintf("SELECT id, oficinas_id FROM empleado WHERE id = %s", GetSQLValueString($colname_rs2, "int"));
$rs2 = mysql_query($query_rs2, $cn1) or die(mysql_error());
$row_rs2 = mysql_fetch_assoc($rs2);
$totalRows_rs2 = mysql_num_rows($rs2);

mysql_select_db($database_cn1, $cn1);
$query_rp1 = "SELECT id, nombre FROM reqs ORDER BY nombre ASC";
$rp1 = mysql_query($query_rp1, $cn1) or die(mysql_error());
$row_rp1 = mysql_fetch_assoc($rp1);
$totalRows_rp1 = mysql_num_rows($rp1);

mysql_select_db($database_cn1, $cn1);
$query_rs3 = "SELECT * FROM td_tipos WHERE td_tipos.ext=1 ORDER BY nombre ASC";
$rs3 = mysql_query($query_rs3, $cn1) or die(mysql_error());
$row_rs3 = mysql_fetch_assoc($rs3);
$totalRows_rs3 = mysql_num_rows($rs3);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/int.css" rel="Stylesheet" type="text/css" />
<style>
#wpag{background:transparent url(../images/pico_5.jpg) no-repeat fixed bottom right;}
</style>

<script src="../scripts/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../scripts/SpryValidationTextarea.js" type="text/javascript"></script>
<script type="text/javascript" src="../scripts/jquery.js"></script>


<script type="text/javascript">
  setTimeout(function() {
    window.location.reload();
}, 300000);
</script>

<script type="text/javascript">
function ocultar() {
  var elem1 = document.getElementsByName("hos1");
  for (k = 0; k< elem1.length; k++) {
    elem1[k].style.display = "none";
  }
}
function ocultar2() {
  var elem1 = document.getElementsByName("hos2");
  for (k = 0; k< elem1.length; k++) {
    elem1[k].style.display = "none";
  }
}
function mostrar() {
  var elem1 = document.getElementsByName("hos1");
  for (i = 0; i< elem1.length; i++) {
  var visible = 'block'
  elem1[i].style.display = visible;
  }
}
function mostrar2() {
  var elem1 = document.getElementsByName("hos2");
  for (i = 0; i< elem1.length; i++) {
  var visible = 'block'
  elem1[i].style.display = visible;
  }
}
function selca(sdep){
  if(!sdep){
    ocultar();
  }else{
    mostrar();
    document.forms[0].obs.value="";
  }
}
function selca2(sdep2){
  var ttec=" <?php echo date("d/m/Y");?>";
  var edest=document.getElementById("cabecera");
  var myselect=document.getElementById("td_tipos_id");
  var imsel=0;
  for (var i=0; i<myselect.options.length; i++){
   if (myselect.options[i].value==sdep2){
    imsel=i;
    break
   }
  }
  var tdec=myselect.options[imsel].text;
  if(tdec=="Otro...") tdec="(Especifique)";
  edest.value=tdec+" "+ttec;
}
</script>
<script type="text/javascript">
function nuevoAjax(){ 
var xmlhttp=false;
try{
xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
}
catch(e)
{
try{    
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
catch(E)
{
if (!xmlhttp && typeof XMLHttpRequest!='undefined') xmlhttp=new XMLHttpRequest();
}
}
return xmlhttp; 
}


function bres(id){
var selectDestino=document.getElementById("caja");
var ajax=nuevoAjax();
var opcionSeleccionada=id;
ajax.open("GET", "../includes/reqs_proceso.php?&opcion="+opcionSeleccionada, true);
ajax.onreadystatechange=function(){ 
if (ajax.readyState==1)
{
selectDestino.length=0;
var nuevaOpcion=document.createElement("option"); nuevaOpcion.value=0; nuevaOpcion.innerHTML="Cargando...";
selectDestino.appendChild(nuevaOpcion); selectDestino.disabled=true;  
}
if (ajax.readyState==4)
{
selectDestino.innerHTML=ajax.responseText;
} 
}
ajax.send(null);
}

function sli(t){
var dlista=document.getElementById("d_oficina");
switch (t){
  case 1:
    for (x=0;x<dlista.length;x++)
    dlista.options[x].selected = true;
  break;
  case 2:
    for (x=0;x<dlista.length;x++)
    dlista.options[x].selected = false;
  break;
  case 3:
    for (x=0;x<dlista.length;x++)
    if(dlista.options[x].selected==true){
      dlista.options[x].selected = false;
    }else{
      dlista.options[x].selected = true;
    }
    
  break;

}
  
} 
</script>

<script type="text/javascript">

pavalue = new Array(<?php
$ttdo="";
do { 
$csalto=$row_rp1['nombre'];
$ssalto = eregi_replace("[\n|\r|\n\r]", ' ', $csalto);
$ttdo = $ttdo."\"".strip_tags($ssalto)."\", ";
} while ($row_rp1 = mysql_fetch_assoc($rp1));
echo substr(str_replace("  ","",$ttdo),0,-2);
?>);

palabel = new Array(<?php
$ttdo="";
mysql_data_seek($rp1, 0);
$row_rp1 = mysql_fetch_assoc($rp1);
do { 
$csalto=$row_rp1['id'];
$ssalto = eregi_replace("[\n|\r|\n\r]", ' ', $csalto);
$ttdo = $ttdo.$ssalto.", ";
} while ($row_rp1 = mysql_fetch_assoc($rp1));
echo substr($ttdo,0,-2);
?>);
   
function cargarLista() {
  for (x=0;x<pavalue.length;x++)
    document.forms[1].reqnombre[x] = new Option(pavalue[x],palabel[x]);
 }
   
 function cargarpavalue() {
  for (x=0;x<pavalue.length;x++)
    document.forms[1].reqnombre[x] = new Option(pavalue[x],palabel[x]);
 }
function buscar() {

   limpiarpavalue();
   texto = document.getElementById("busca").value;
   expr = new RegExp(texto,"i");
   y = 0;
   for (x=0;x<pavalue.length;x++) {
     if (expr.test(pavalue[x])) {
      document.forms[1].reqnombre[y] = new Option(pavalue[x],palabel[x]);
       y++;
     }
   }
 }
   
 function limpiarpavalue() {
   for (x=document.forms[1].reqnombre.length;x>=0;x--)
      document.forms[1].reqnombre[x] = null; 
 }
</script>


<script type="text/javascript">

pavalue2 = new Array(<?php
$ttdo="";
do { 
$csalto=$row_rs1['nombre'];
$ssalto = eregi_replace("[\n|\r|\n\r]", ' ', $csalto);
$ttdo = $ttdo."\"".strip_tags($ssalto)."\", ";
} while ($row_rs1 = mysql_fetch_assoc($rs1));
echo substr(str_replace("  ","",$ttdo),0,-2);
?>);

palabel2 = new Array(<?php
$ttdo="";
mysql_data_seek($rs1, 0);
$row_rs1 = mysql_fetch_assoc($rs1);
do { 
$csalto=$row_rs1['id'];
$ssalto = eregi_replace("[\n|\r|\n\r]", ' ', $csalto);
$ttdo = $ttdo.$ssalto.", ";
} while ($row_rs1 = mysql_fetch_assoc($rs1));
echo substr($ttdo,0,-2);
?>);
   

   
 function cargarpavalue2() {
  for (x=0;x<pavalue2.length;x++)
    document.forms[0].d_oficina[x] = new Option(pavalue2[x],palabel2[x]);
 }
function buscar2() {

   limpiarpavalue2();
   texto = document.getElementById("busca2").value;
   expr = new RegExp(texto,"i");
   y = 0;
   for (x=0;x<pavalue2.length;x++) {
     if (expr.test(pavalue2[x])) {
      document.forms[0].d_oficina[y] = new Option(pavalue2[x],palabel2[x]);
       y++;
     }
   }
 }
   
 function limpiarpavalue2() {
   for (x=document.forms[0].d_oficina.length;x>=0;x--)
      document.forms[0].d_oficina[x] = null; 
 }
</script>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link href="../scripts/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../scripts/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
</head>
<body onload="cargarLista();">

  

<div class="container">
  <div class="row " style="padding: 15px; background: #dfedff;">
    <div class="col-md-3">
      <a href="nuevo.php?token=<?php echo $row_resdatos['codigodeactivacion'];?>" style="text-decoration: none;color: black;">
        <img src="../images/unnamed.png" style="width: 25px;"> 
        <span><strong>Nuevo documento</strong></span>
      </a>
    </div>
    <div>
       <a href="doc.php?tokken=<?php echo $row_resdatos['codigodeactivacion'];?>"  style="text-decoration: none;color: black;">
         <img src="../images/following.png" style="width: 25px;"> 
          <span><strong>Seguimiento</strong></span>
       </a>
    </div class="col-md-3">  
  </div>
  <div class="row">
   
    <div id="container"><div id="wpag"><div id="content">
  
<h1>Trámite Documentario</h1>
<div class="hr"><em></em><span></span></div>
<div class="clear" style="height:5px"></div>
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0"><tr></tr>
</table>
<div >
<table <?php echo dtabla();?> border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">
    
    <form  method="POST" name="form1" id="form1" enctype="multipart/form-data">
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
        <tr valign="baseline">
          <td width="130" align="right" class="btit_1">Item</td>
          <td class="btit_1">Valor</td>
          </tr>
          
        <tr valign="baseline">
          <td width="130" align="right" valign="middle" class="btit_3">Tipo</td>
          <td><select name="td_tipos_id" id="td_tipos_id" onchange="selca2(this.value);">
            <?php
do {  
?>
            <option value="<?php echo $row_rs3['id']?>"<?php if (!(strcmp($row_rs3['id'], 25))) {echo "selected=\"selected\"";} ?>><?php echo $row_rs3['nombre']?></option>
            <?php
} while ($row_rs3 = mysql_fetch_assoc($rs3));
  $rows = mysql_num_rows($rs3);
  if($rows > 0) {
      mysql_data_seek($rs3, 0);
    $row_rs3 = mysql_fetch_assoc($rs3);
  }
?>

          </select></td>
        </tr>
        <tr valign="baseline">
          <td width="130" align="right" valign="middle" class="btit_3">Con pago</td>
          <td><label>
            <input name="pago" type="checkbox" id="pago" value="1"  />
            ¿El expediente viene con recibo alg&uacute;n de pago?</label>
            <br>
            <input name="numerorecibo" type="text" class="tbox2" id="numerorecibo" style="display:none;width: 25%;" placeholder="Número de recibo" /></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" class="btit_3">Cabecera</td>
          <td>
            <input name="cabecera" type="text" class="tbox2" id="cabecera" value="Solicitud <?php echo date("d/m/Y");?>" /></td>
        </tr>
        <tr valign="baseline">
          <td width="130" align="right" valign="middle" class="btit_3">Asunto y dependencia</td>
          <td><span id="sprytextarea1">
            <textarea name="asunto" rows="2" class="tbox2" id="asunto"></textarea></span></td>
          </tr>
        <tr valign="baseline">
          <td width="130" align="right" valign="middle" class="btit_3" >Firma (Nombre)</td>
          <td><span id="sprytextfield1">
            <input name="firma" type="text" class="tbox2" id="firma"  value="<?php echo 
            $row_resdatos['nombre'].' '.$row_resdatos['apellidos'];?>" readonly/></span></td>
        </tr>
        <tr valign="baseline">
          <td width="130" align="right" valign="middle" class="btit_3">N&deg; de folios</td>
          <td><input name="nfolios" type="text" id="nfolios" value="1" size="10" autocomplete="off" /></td>
        </tr>
        
        <tr valign="baseline" hidden="true">
          <td width="130" align="right" valign="middle" class="btit_3">Prioridad</td>
          <td  bgcolor="#def0ff"><label>
            <input name="urgente" type="checkbox" id="urgente" value="1" />
            Marcar el expediente como ¡Urgente!</label></td>
        </tr>
        <tr valign="baseline">
          <td width="130" align="right" valign="middle" id="obs" class="btit_3">Correo Electronico</td>
          <td><label>
              <input name="obs" style="width: 450px;"   value="<?php echo 
            $row_resdatos['email']; ?>" readonly/>
            </div></td>
        </tr>
        
        <tr valign="baseline">
          <td align="right" valign="middle" class="btit_3">Adjuntar archivo <br> <span style="color:green;">Si el tramite a realizar contiene varios archivos comprima en una carpeta y cargelo</span></td>
          <td ><input type="file" name="archivo" id="archivo"></td>
        </tr>
        <tr>
          <td width="130" align="right" valign="middle" id="obs" class="btit_3">Estado</td>
          <td class="position-relative pr-5">
              
            <div class="" id="estado_envio" style="font-size: 22px;">
                <div class="alert alert-primary mb-0" role="alert">
                    &nbsp Por enviar
                </div>
            </div>
            <div class="d-none" id="estado_envio2" style="font-size: 22px;">
                <center>
                    <div class="alert alert-warning mb-0 pr-5">
                          <div class="spinner-border text-primary m-3" role="status">
                            <span class="sr-only">Loading...</span>
                          </div>
                          <span class="position-absolute" style="top:50%; transform: translateY(-50%);">
                              Cargando...
                          </span>
                    </div>
                </center> 
            </div>
            
          </td>
        </tr>
        <tr valign="baseline">
          <td width="130">&nbsp;</td>
          <td>
            <center><input type="button" id="submit_formulario" class="btn btn-success lg pl-5 pr-5 font-weight-bold" value="Enviar"  onclick="validar();"></center></td>
          </tr>
      </table>
      <input type="hidden" name="id" value="vecino">
      <input type="hidden" name="c_oficina" value="<?php echo $row_rs2['oficinas_id']; ?>">
      <input type="hidden" name="fecha" value="<?php echo date("Y-m-d H:i:s");?>">
      <input type="hidden" name="empid" value="5">
      <input type="hidden" name="user" value="vecino">
      <input type="hidden" name="ext" value="">
      <input type="hidden" name="file" value="">
      <input type="hidden" name="size" value="">
      <input type="hidden" name="aid" value="<?php echo did();?>">      
      <input type="hidden" name="MM_insert" value="form1" />
</form></td>
    <td width="20" rowspan="2" valign="top">&nbsp;</td>
    <td width="250" rowspan="2" valign="top"><h2>Opciones</h2>
        <div class="btit_2">Acciones</div>
        <div class="bcont">
        <div class="spacer"><a href="nuevo.php?token=<?php echo $row_resdatos['codigodeactivacion'];?>"><div class="skin left" style="background-position:-80px -63px;margin-right:3px;"></div>Refrescar p&aacute;gina</a></div>
        <div class="spacer"><a  href="logout.php">
          <div class="skin left" style="background-position:-48px -79px;margin-right:3px;"></div>
          Cerrar sesion</a></div>
        </div>
        <div class="btit_2">Informaci&oacute;n</div>
        <div class="bcont2">Rellene los cuadros y luego pulse el boton agregar para almacenar los datos.</div></td>
  </tr>
  <tr hidden>
    <td valign="top">
    <br>
    <h3>Requisitos</h3>
    <form action="" method="get">
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
        <tr valign="baseline">
          <td width="130" align="right" class="btit_1">Item</td>
          <td class="btit_1">Valor</td>
          </tr>
        <tr valign="baseline">
          <td width="130" align="right" class="btit_3">Filtrar lista:</td>
          <td><input name="busca" type="text" class="tb2" id="busca" style="width:200px" onkeyup="buscar();" autocomplete="off" />
      <input name="button" type="button" class="bt1" id="button2" value="Limpiar filtro" onclick="document.forms[1].busca.value='';buscar();"/></td>
        </tr>
        <tr valign="baseline">
          <td width="130" align="right" valign="middle" class="btit_3">Nombre</td>
          <td>
          <label>
            <select name="reqnombre" size="6" id="reqnombre" onchange="bres(this.value);" style="max-width:800px;">           
            </select>
          </label></td>
        </tr>
        <tr valign="baseline">
          <td width="130" align="right" valign="middle" class="btit_3">Descripción</td>
          <td><div id="caja">&nbsp;</div></td>
        </tr>
      </table>
    </form>
    </td>
  </tr>
</table>

</div></div></div>
  </div>
</div>
<div class="modal fade" id="datosexpedientess" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog " >
    <div class="modal-content">
      
      <div class="modal-body">

        <center><h5 style="color:black"><strong>Datos del Expediente Creado</strong></h5></center>
          
          <table class="table table-striped">
            <tr>
            <td><strong>Expediente N°:</strong></td>
            <td><strong><label id="nexp"></label></strong></td>
          </tr>
           <tr>
            <td><strong>Asunto:</strong></td>
            <td><label id="asuntodescripcio"></label></td>
           </tr>
          <tr>
            <td><strong>Unidad org&aacute;nica:</strong></td>
            <td><label id="unidad"></label></td>
          </tr>
          <tr>
            <td><strong>N° de Folios:</strong></td>
            <td><label id="folio"></label></td>
          </tr>
          <tr>
            <td><strong>Solicitante:</strong></td>
            <td><label id="solicitante"></label></td>
          </tr>
          <tr>
            <td><strong>Correo Electronico:</strong></td>
            <td><label id="correo"></label></td>
          </tr>
        </table>
        <center>
          <svg id="barcode" style="border:1px;"></svg>
        </center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="modalsehuimiento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <center><h5 style="color:black;"><strong>SEGUIMIENTO DE EXPEDIENTES</strong></h5></center>
      
        <div>
          <label>Ingrese el numero de expediente</label>
          <br>
          <form id="frmseguimiento" method="GET">
          <input type="text" class="form-control" name="idexpedienteseguir" id="idexpedienteseguir">
          
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="limpiarn();">Cerrar</button>
        <button type="submit" class="btn btn-success">Continuar</button>
        </form>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
ocultar();
ocultar2();
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
</script>
<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="js/popper.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/JsBarcode.all.min.js"></script>
<script type="text/javascript">

    
    function validar(){
      var tipo = $.trim($('#td_tipos_id').val()); 
      var cabecera = $.trim($('#cabecera').val()); 
      var asunto = $.trim($('#asunto').val()); 
      var nfolios = $.trim($('#nfolios').val()); 
      var firma = $.trim($('#firma').val());
      var enviarnumero="";
      
      

          if($("#archivo").val().length==0){
            alert("Se debe seleccionar un archivo");
          }else if(tipo.length == 0 || firma.length == 0 || asunto.length == 0 || cabecera.length == 0 || nfolios.length == 0 ){
              alert("Rellene todos los datos");
          }else{
              if($('#pago').is(':checked')){
                var numrecibo = $.trim($('#numerorecibo').val());
                var enviarnumero;
                  if(numrecibo.length== 0){
                    alert("Debe de ingresar el numero del recibo de pago");
                  }else{
                    var opcion="verificar";
                    
                    var boton_enviar = document.getElementById("submit_formulario");
                    boton_enviar.disabled = true;
                    var estado_env = document.getElementById("estado_envio");
                    estado_env.innerHTML = `
                         <center>
                            <div class="alert alert-warning mb-0 pr-5">
                                  <div class="spinner-border text-primary m-3" role="status">
                                    <span class="sr-only">Loading...</span>
                                  </div>
                                  <span class="position-absolute" style="top:50%; transform: translateY(-50%);">
                                      Cargando...
                                  </span>
                            </div>
                        </center> 
                    `;
    
                    //console.log("desactivar boton0");
            
                    $.ajax({
                      url: "controlador/mesapartes.php",
                      type: "POST",
                      datatype:"json",    
                      data:  {dato:numrecibo,opcion:opcion},
                    }).done(function(resp){
                        var boton_enviar = document.getElementById("submit_formulario");
                        boton_enviar.disabled = false;
                        var estado_env = document.getElementById("estado_envio");
                        estado_env.innerHTML = `
                               <div class="alert alert-primary mb-0" role="alert">
                                    &nbsp Por enviar
                                </div> 
                        `;
                      if(resp==1){
                          alert("El número de recibo ya esta registrado");
                      }else if(resp==0){
                              var opcion="nuevo";
          var inputFileimage=document.getElementById('archivo');
          var file=inputFileimage.files[0];
          var myForm = $ ("#form1") [0]
          var data= new FormData(myForm);
          data.append('opcion',opcion);
            
            
            var boton_enviar = document.getElementById("submit_formulario");
            boton_enviar.disabled = true;
            var estado_env = document.getElementById("estado_envio");
            estado_env.innerHTML = `
                         <center>
                            <div class="alert alert-warning mb-0 pr-5">
                                  <div class="spinner-border text-primary m-3" role="status">
                                    <span class="sr-only">Loading...</span>
                                  </div>
                                  <span class="position-absolute" style="top:50%; transform: translateY(-50%);">
                                      Cargando...
                                  </span>
                            </div>
                        </center>  
            `;
    
            //console.log("desactivar boton1");
            
            $.ajax({
              url: "controlador/mesapartes.php",
              type: "POST",
              datatype:"json",    
              data:  {data,opcion:opcion},
              contentType:false,
              data :data,
              processData:false,
              cache:false    
        }).done(function(resp){
            var boton_enviar = document.getElementById("submit_formulario");
            boton_enviar.disabled = false;
            var estado_env = document.getElementById("estado_envio");
            estado_env.innerHTML = `
                   <div class="alert alert-primary mb-0" role="alert">
                    &nbsp Por enviar
                </div>
            `;
           var n=(JSON.parse(resp));
           fecha=n['fecha'];
           tipodoc=n['td_tipos_id'];
           exp=n['exp'];
           asu=n['asunto'];
           unidad=n['onombre'];
           folios=n['nfolios'];
           Soli=n['firma'];
           cooreo=n['obs'];
           id=n['id'];

           cadena=fecha.substr(0,4);
           
           

           codigodebarras=tipodoc + id +cadena;
           
            JsBarcode("#barcode", codigodebarras, {
              format: "codabar",
              lineColor: "#000",
              width: 2,
              height: 40,
              fontSize : 20,
              background : "#ccffff",
              displayValue: true
            });
            $('#nexp').text(codigodebarras);
            $('#asuntodescripcio').text(asu);
            $('#unidad').text(unidad);
            $('#folio').text(folios);
            $('#solicitante').text(firma);
            $('#correo').text(cooreo);
            $('#datosexpedientess').modal('show'); 
            $("#form1").trigger("reset");
           
        }); 
                      }
                    });
                  }
              }else{
                var opcion="nuevo";
          var inputFileimage=document.getElementById('archivo');
          var file=inputFileimage.files[0];
          var myForm = $ ("#form1") [0]
          var data= new FormData(myForm);
          data.append('opcion',opcion);
            
            var boton_enviar = document.getElementById("submit_formulario");
            boton_enviar.disabled = true;
            var estado_env = document.getElementById("estado_envio");
            estado_env.innerHTML = `
                         <center>
                            <div class="alert alert-warning mb-0 pr-5">
                                  <div class="spinner-border text-primary m-3" role="status">
                                    <span class="sr-only">Loading...</span>
                                  </div>
                                  <span class="position-absolute" style="top:50%; transform: translateY(-50%);">
                                      Cargando...
                                  </span>
                            </div>
                        </center> 
            `;
            //console.log("desactivar boton2");
            
            $.ajax({
              url: "controlador/mesapartes.php",
              type: "POST",
              datatype:"json",    
              data:  {data,opcion:opcion},
              contentType:false,
              data :data,
              processData:false,
              cache:false    
        }).done(function(resp){
            var boton_enviar = document.getElementById("submit_formulario");
            boton_enviar.disabled = false;
            var estado_env = document.getElementById("estado_envio");
            estado_env.innerHTML = `
                   <div class="alert alert-primary mb-0" role="alert">
                    &nbsp Por enviar
                </div>  
            `;
           var n=(JSON.parse(resp));
           fecha=n['fecha'];
           tipodoc=n['td_tipos_id'];
           exp=n['exp'];
           asu=n['asunto'];
           unidad=n['onombre'];
           folios=n['nfolios'];
           Soli=n['firma'];
           cooreo=n['obs'];
           id=n['id'];

           cadena=fecha.substr(0,4);
           
           

           codigodebarras=tipodoc + id +cadena;
           
            JsBarcode("#barcode", codigodebarras, {
              format: "codabar",
              lineColor: "#000",
              width: 2,
              height: 40,
              fontSize : 20,
              background : "#ccffff",
              displayValue: true
            });
            $('#nexp').text(codigodebarras);
            $('#asuntodescripcio').text(asu);
            $('#unidad').text(unidad);
            $('#folio').text(folios);
            $('#solicitante').text(firma);
            $('#correo').text(cooreo);
            $('#datosexpedientess').modal('show'); 
            $("#form1").trigger("reset");
           
        }); 

              }
           }
    }
           
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#pago').click(function(){
      if($('#pago').is(':checked')){
        $("#numerorecibo").css("display", "block");

      }else{

        $("#numerorecibo").css("display", "none");
        $("#numerorecibo").val("");
      }
    })
  $('#frmseguimiento').on('submit', function(e){
    
      e.preventDefault();
    idenvio=$.trim($('#idexpedienteseguir').val());
    if(idenvio.length==0){
      alert("No se permiten campos vacios");
    }else if(idenvio.length==7){
      id=idenvio.substr(2,1);
        window.location.href="seguimiento.php?pk="+id;
    }else if(idenvio.length==8){
      id=idenvio.substr(2,2);
        window.location.href="seguimiento.php?pk="+id;
      
    }else if(idenvio.length==9){
      id=idenvio.substr(2,3);
        window.location.href="seguimiento.php?pk="+id;
      
    }else if(idenvio.length==10){
      id=idenvio.substr(2,4);
        window.location.href="seguimiento.php?pk="+id;
      
    }else if(idenvio.length==11){
      id=idenvio.substr(2,5);
        window.location.href="seguimiento.php?pk="+id;
      
    }else if(idenvio.length==12){
      id=idenvio.substr(2,6);
        window.location.href="seguimiento.php?pk="+id;
      
    }else if(idenvio.length==13){
      id=idenvio.substr(2,7);
        window.location.href="seguimiento.php?pk="+id;
      
    }
    else{
      alert("Ingrese un numero de expediente valido");
    }
  });
});
  function limpiarn(){
    $("#frmseguimiento").trigger("reset");
  }
  $(document).ready(function() {
    $("#logaut").trigger("reset");
   
  });
</script>
</body>
</html>
<?php
mysql_free_result($rs1);

mysql_free_result($rs2);



mysql_free_result($rs3);
}else{
  header('Location: validar/index.html');
}
?>