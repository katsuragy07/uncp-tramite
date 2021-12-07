<div class="mainContainer"><div class="maincl"></div><ul class="ribbon"><li><ul class="orb"><li><a href="javascript:void(0);" id="orbButton" class="orbButton">&nbsp;</a><span>Menu</span></li></ul></li>            
<li>
<ul class="menu">



<?php if(drib($vrs1,$vrs2,1)){?>
<li><a><span>Gesti&oacute;n documentaria</span></a>
	<ul>
	<?php if(dribbut($vrs1,$vrs3)){?>
	<li>
		<h2>Mesa de partes</h2>
		<div class="rbbtn" id="td_nuevo"><span class="icon ico_big" style="background-position:-31px -31px"></span>Nuevo</div>
		<div class="ribbon-list">
		<div class="rbbtn" id="td_folios"><em class="icon ico_small" style="background-position:-80px -79px;margin-right:5px;"></em>Recientes</div>
		<div class="rbbtn" id="tdmesa_resumen"><em class="icon ico_small" style="background-position:-80px -79px;margin-right:5px;"></em>Resumen</div>
		<div class="rbbtn" id="reqs"><em class="icon ico_small" style="background-position:-80px -79px;margin-right:5px;"></em>Requisitos</div>
		</div>
	</li>
	<?php } ?>
   <li>
		<h2>Expedientes de internos</h2>
		<div class="rbbtn" id="tdin_nuevo"><span class="icon ico_big" style="background-position:-224px 0"></span>Nuevo</div>
		<div class="rbbtn" id="tdin_recibidos"><span class="icon ico_big" style="background-position:-224px -31px"></span>Por recibir</div>
		<div class="rbbtn" id="tdin_recibidosya"><span class="icon ico_big" style="background-position:-224px -62px"></span>Recibidos</div>
		<div class="rbbtn" id="tdin_folemtd"><span class="icon ico_big" style="background-position:-256px 0"></span>Emitidos</div>
		<div class="ribbon-list">
		<div class="rbbtn" id="tdin_folarchv"><em class="icon ico_small" style="background-position:-80px -79px;margin-right:5px;"></em>Archivados</div>
		<div class="rbbtn" id="tdin_reenv"><em class="icon ico_small" style="background-position:-80px -79px;margin-right:5px;"></em>Derivados</div>
		<div class="rbbtn" id="tdin_resumen"><em class="icon ico_small" style="background-position:-80px -79px;margin-right:5px;"></em>Resumen</div>
		</div>
	</li>
	<li>
		<h2>Expedientes de externos</h2>
		<div class="rbbtn" id="td_recibidos"><span class="icon ico_big" style="background-position:-128px -31px"></span>Por recibir</div>
		<div class="rbbtn" id="td_recibidosya"><span class="icon ico_big" style="background-position:-96px -31px"></span>Recibidos</div>
		<div class="ribbon-list">
		<div class="rbbtn" id="td_folarchv"><em class="icon ico_small" style="background-position:-80px -79px;margin-right:5px;"></em>Archivados</div>
		<div class="rbbtn" id="td_reenv"><em class="icon ico_small" style="background-position:-80px -79px;margin-right:5px;"></em>Derivados</div>		
		</div>		
	</li>
	<?php if(drib($vrs1,$vrs2,3)){?>
	<li>
		<h2>Administrador</h2>
		<div class="ribbon-list">
		<div class="rbbtn" id="tdin_admall"><em class="icon ico_small" style="background-position:-80px -79px;margin-right:5px;"></em>Exp. Internos</div>
		<div class="rbbtn" id="td_admall"><em class="icon ico_small" style="background-position:-80px -79px;margin-right:5px;"></em>Exp. Externos</div>
		<div class="rbbtn" id="mlocal"><em class="icon ico_small" style="background-position:-80px -79px;margin-right:5px;"></em>Oficinas</div>
		</div>		
	</li>
	<?php } ?>
	</ul>
</li>
<?php } ?>

<?php if(drib($vrs1,$vrs2,2)){?>
<li><a><span>Intranet</span></a>
	<ul>
    
    <li>
		<h2>Red interna</h2>
        <div class="rbbtn" id="../urstream/index"><span class="icon ico_big" style="background-position:-256px -62px"></span>Noticias de la intranet</div>
		
	</li>
    
    <li>
		<h2>Organizaci&oacute;n</h2>

        <div class="rbbtn" id="acu_list"><span class="icon ico_big" style="background-position:-288px -62px"></span>Acuerdos</div>
        </li>	
	</ul>
</li>
<?php } ?>


<?php if(drib($vrs1,$vrs2,3)){?>
<li><a><span>Administrador</span></a>
	<ul>
	<li>
		<h2>Organizaci&oacute;n</h2>
		<div class="rbbtn" id="perso"><span class="icon ico_big" style="background-position:-64px -62px"></span>Empleados</div>
		<div class="rbbtn" id="mlocal"><span class="icon ico_big" style="background-position:-96px -62px"></span>Oficinas</div>
	</li>	
	<li>
		<h2><span>Tr&aacute;mite Documentario</span></h2>
		<div class="rbbtn" id="doc_list"><span class="icon ico_big" style="background-position:-32px -62px"></span>Tipos de doc.</div>
		<div class="rbbtn" id="plant_list"><span class="icon ico_big" style="background-position:0px 0px"></span>Plantillas</div>
	</li>
	<li>
		<h2><span>Data</span></h2>
		<div class="rbbtn" id="backup"><span class="icon ico_big" style="background-position:-288px 0"></span>Backups</div>		
	</li>
	<li>
		<h2>Logs del sistema</h2>
		<div class="rbbtn" id="log_access"><span class="icon ico_big" style="background-position:-128px -62px;"></span>Accesos</div>
		<div class="rbbtn" id="log_msg"><span class="icon ico_big" style="background-position:-160px -62px;"></span>Mensajes</div>
	</li>
	<li>
		<h2>Activar cuentas</h2>
		<div class="rbbtn" id="log_access">
		    <a href="http://www.gestionuncp.edu.pe/tramite/vecinos/validar/cuenta.html" target="_blank"><span class="icon ico_big" style="background-position:-128px -62px;"></span>Formulario</a>
		</div>
	</li>
	</ul>
</li>
<?php } ?>
</ul></li></ul>

</div>