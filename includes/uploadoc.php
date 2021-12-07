<div><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablanone">
              <tr>
                <td valign="top"><table width="97%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><h3 style="margin:0;">Subir archivos al servidor</h3></td>
                  </tr>
                  <tr>
                    <td class="cel_3">Los archivos que suba al servidor tienen que tener la optimización adecuada, de lo contrario la subida y descarga será muy lenta.                      <br /></td>
                  </tr>
                  <tr id="subir" name="subir">
                    <td><span>Seleccione el archivo que desea adjuntar, puede ser en los formatos: <strong>PDF, DOC, XLS, PPT, MP3, ZIP, RAR, JPG,  etc. </strong></span><br />
<div id="upload" ><span>Seleccionar<span></div>
<span class="ti4b" id="status" ></span></td>
                  </tr>
                </table></td>
                <td width="200" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center"><ul id="files" >
                    </ul><div id="cam">
                    <?php 
						  $duurl="../images/".$up_val;
						  $dexrl=extension_archivo($duurl);
						  $dexrl=dtarchivo($dexrl);
						  if($up_val!=""){ ?>
                    <img src="../images/<?php echo $dexrl; ?>?nocache=123" alt="" class="img_uplo"/><br />
                    <span class="rojo"><a href="javascript:quita();">[x] Quitar el archivo</a></span>
                    <?php } ?>                    
                    </div></td>
                  </tr>
                </table></td>
              </tr>
</table>
</div>
<?php if($up_val!=""){ ?>
<script type="text/javascript">$("#subir").hide();</script>
<?php } ?>