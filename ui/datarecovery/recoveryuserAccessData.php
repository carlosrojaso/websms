<?php
/**
 * recoveryuserAccessData.php
 * 
 * Interfaz recuperar datos de acceso
 * @author Victor Manuel Vallecilla Mira<vallecilla@gmail.com> 
 * @version 1.0
 * @package datarecovery
 * @creacion: 21/05/2007
 * @license: GNU/GPL	
*/
$title = "OnSpot.es - Recupere sus datos de acceso al portal";



include_once('../../includes/simplepage.class.php');
$obj = new simplepage();
$obj->setTitle($title);
$obj->setCSS("../../includes/style/style.css");
$obj->setJS("../../includes/validate/datarecovery/validate_recoveryuserAccessData.js");
echo $obj->getHeader();
$img_dir = "../../images";
require_once('../../data/db.class.php');
$db = new db_class();
if (!$db->connect())
$db->print_last_error(true);
?>

<br><br>
<form name="forma" method="post" action="../../control/datarecovery/recoveryuserAccessData.php" >	
	<table width="430" border="0" align="center" cellpadding="0" cellspacing="0">
		  <tr>
			<td colspan="3"><span class="titulorecuperadatos">Recupere sus datos de acceso</span><br><br></td>
		  </tr>
		  <tr>
			<td colspan="3"><div align="justify"><span class="contenido1recuperadatos">Para </span><span class="contenido2recuperadatos">recuperar sus datos de acceso</span> <span class="contenido1recuperadatos">debe tener en cuenta que</span> <span class="contenido3recuperadatos">la direcci&oacute;n E-mail que le solicitamos debe corresponder con la que indic&oacute; al momento de darse de alta como usuario.</span><br><br><br></div></td>
		  </tr>
		  <tr>
			<td colspan="3"><span class="contenido4recuperadatos">Le enviaremos sus datos de acceso a la direcci&oacute;n e-mail que especific&oacute; al momento de darse de alta como usuario.</span><br><br><br></td>
		  </tr>
		  <tr>
			<td colspan="2" background="<?php echo $img_dir;?>/titulorecupera.png">&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td colspan="2"><hr></td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td width="143"><span class="labelrecuperadatos">Direcci&oacute;n E-mail </span></td>
			<td width="143"><input type="text" name="recupera_email" id="recupera_email"></td>
			<td width="144">&nbsp;</td>
		  </tr>
		  <tr>
			<td colspan="2"><hr></td>
			<td>&nbsp;</td>
		  </tr>
		  <tr align="right">
			<td colspan="2"><input type="submit" class="cssbutton" value="Solicitar"  onclick="return isEmailAddress(recupera_email,'recupera_email');"></td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td colspan="2">&nbsp;</td>
		  </tr>
		  <?php if($_GET[email]!=''){?>
			  <tr >		  	
				<td colspan="3"><div id="errorrecupera" style="display:inline;"><span class="mensajerecuperadatos">No existe la cuenta <?php echo $_GET[email];?>.</span><br><span class="labelrecuperadatos">Vuelve a intentarlo o pongase en contacto con nuestro</span><br> <a href="../../ui/helpdesk/addHelp.php" class="condiciones">Centro de Atenci&oacute;n al cliente.</a></div></td>
			  </tr>
		  <?php }?>
	</table>
</form>
<br><br><br><br><br><br>
<?php
echo $obj->getFooter();
?>