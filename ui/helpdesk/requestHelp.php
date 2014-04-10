<?php
/**
 * requestHelp.php
 * 
 * Interfaz Ingresar Solicitud centro de ayuda
 * @author Victor Manuel Vallecilla Mira<vallecilla@gmail.com> 
 * @version 1.0
 * @package ui
 * @creacion: 21/05/2007
 * @license: GNU/GPL	
*/
include_once('../../includes/session.inc');
//check_login();
include_once('../../includes/calendario/calendario.php');
include_once('../../includes/simplepage.class.php');
$obj = new simplepage();
$obj->setTitle("OnSpot.es - Solicitud de ayuda");
$obj->setCSS("../../includes/style/style.css");
$obj->setJS("../../includes/validate/helpdesk/validate_requestHelp.js");

echo $obj->getHeader();
$img_dir = "../../images";
require_once('../../data/db.class.php');
$db = new db_class();
if (!$db->connect())
$db->print_last_error(false);
?>
<br>
<form name="forma" id="forma" method="post" action="../../control/helpdesk/requestHelp.php">
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2" class="tituloatencioncliente">Bienvenido al Centro de Atenci&oacute;n al Cliente<br>
      <br></td>
    </tr>
    <tr>
      <td colspan="2" class="contenidoatencioncliente">Si tiene cualquier consulta, rellene el siguiente formulario e ind&iacute;canos el motivo de tu pregunta para que podamos responderte en el menor tiempo posible.<br>
      <br></td>
    </tr>
    <tr>
      <td colspan="2" class="contenidoatencioncliente">Gracias por contactar con Onspot.com<br>
      <br></td>
    </tr>
    <tr>
      <td colspan="2"><hr></td>
    </tr>    
	<?php if($_SESSION['auth']!='yes'){?>
	    <tr>	      
		  <td colspan="2" class="contenidoatencioncliente">Nombre y Apellidos</td>
	    </tr>	
	    <tr>
	      <td colspan="2"><input name="frm_req_cli_nm" type="text" id="frm_req_cli_nm" size="60"><br><br></td>
	    </tr>
	    <tr>
	      <td ><div class="contenidoviñetaatencioncliente"  id="cat_frm_req_mail_1" style="display:inline; ">Email</div></td>
	      <td ><div class="contenidoatencioncliente"  id="cat_frm_req_mail_rep_1" style="display:inline; ">Repetir Email</div></td>
	    </tr>
	    <tr>
	      <td><input name="frm_req_mail" type="text" id="frm_req_mail"><br><br></td>
	      <td><input type="text" name="frm_req_mail_conf" id="frm_req_mail_conf" ><br><br></td>
	    </tr>
    <?php }?>
    <tr>
      <td colspan="2" class="contenidoatencioncliente">Motivo de tu pregunta </td>
    </tr>
    <tr>
      <td colspan="2">
      	<select name="frm_req_reason_cd" id="frm_req_reason_cd">
        	<option value="-1" selected ></option>
        	<?php
				 $r = $db->select("SELECT frm_req_reason_cd,frm_req_reason_nm FROM form_request_reason WHERE frm_req_reason_lang='SP'");
				 while ($row=$db->get_row($r, 'MYSQL_ASSOC')) {
					echo '<option value ="'.$row['frm_req_reason_cd'].'">'.$row['frm_req_reason_nm'].'</option>';
				 }
			?>       
      	</select><br><br>
      </td>
    </tr>
    <tr>
      <td colspan="2" class="contenidoatencioncliente">Comentarios. Por favor ind&iacute;canos detalladamente lo que deseas realizar. </td>
    </tr>
    <tr>
      <td colspan="2"><textarea name="frm_req_cmnt" cols="50" rows="10" id="frm_req_cmnt" class="required" ></textarea>
      <br><br></td>
    </tr>
    <tr>
      <td colspan="2"><input type="button" class="cssbutton" value="Registrar" onclick="return validateMandatoryFields()"><br><input name="id_client" type="hidden" id="id_client"></td>
    </tr>
    <tr>
      <td colspan="2"><a href="#" class="forget">Protección de datos </a></td>
    </tr>
  </table>
</form>
<br>
<?php	
echo $obj->getFooter();
?>

