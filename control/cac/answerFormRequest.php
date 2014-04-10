<?php


/*
 * Created on 15/10/2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
include_once ('../../includes/session.inc');
check_login();
include_once ('../../includes/simplepage.class.php');
$obj = new simplepage();
$obj->setTitle("Consultar peticiones Centro de Atención al Cliente");
$obj->setCSS("../../includes/style/style.css");
echo $obj->getHeader();
if (!isset ($_GET[send_mail])) {
?>
<script>
function sendMail(){
	page='../../control/cac/answerFormRequest.php?id_frm_req=<?php echo $_GET[id_frm_req];?>&send_mail=TRUE&frm_req_mail=<?php echo $_GET[frm_req_mail];?>&frm_req_answer='+document.info_form_req_mail.frm_req_answer.value;
	//alert(page);
	location.href=page;
	
}
</script>
<form name="info_form_req_mail" method="POST" id="info_form_req_mail">						
	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
		<th colspan="2">Responder a la solicitud</th>
		<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
		<tr>
			<td class="label" valign="top">Respuesta:</td>
			<td><textarea name="frm_req_answer" id="frm_req_answer"></textarea></td>
		</tr>
		<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
		<tr>
			<td><input type="button" class="cssbutton" value="Enviar" onclick="sendMail()"></td>
		</tr>
	</table>
</form>
<?php


} else {
	include ("../../includes/email/email.class.php");	
	$email = new emailNormal(); // Se crea el objeto

	$email->asunto("Respuesta CAC Onspot"); // Definimos el asunto	
	$email->para($_GET[frm_req_mail]); // Agregamos uno más que se nos olvidó....
	//$email->copia_oculta_a ("vallecilla@gmail.com");					// Envia una copia oculta
	$email->responder_a("vallecilla@gmail.com"); // A quién se esponderá el mensaje
	$email->de("vallecilla@gmail.com", "Admin"); // Remitente
	$email->enHTML(true); // Envía el mensaje en formato HTML	
	$msg = 'Saludos de Onspot.<br>
					<b>Respuesta a tu consulta:</b>
				  <br>
				  ' . $_GET[frm_req_answer] . '<br>';
	$email->mensaje($msg); // Define el cuerpo del mensaje
	$email->enviar(); // Enviamos el mensaje

	require_once ('../../data/db.class.php');
	$db = new db_class();
	if (!$db->connect())
		$db->print_last_error(false);

	/******************Actualizar el la respuesta a la solicitud y colocar el tipo de finalizacion en respuesta por correo****************/
	$data_update = array (
		'frm_req_end_cd' => 'E',
		'frm_req_answer' => $_GET[frm_req_answer]
	);

	$user_id3 = $db->update_array('form_request', $data_update, 'id_frm_req=' . $_GET[id_frm_req]);
	if (!$user_id3) {
		$debug3 .= "Ocurri&oacute; un error actualizando los datos del de la forma de atencion al cliente.<br>" . $db->last_error;
		echo '<br>' . $debug3 . '<br>';
		return;
	}
		echo "<input type='button' value='Cerrar' onclick='window.close();'><br>";
	/********************************************************************************/
}
?>