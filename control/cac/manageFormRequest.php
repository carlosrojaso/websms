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
$obj->setTitle("Gestionar peticiones Centro de Atención al Cliente");
$obj->setCSS("../../includes/style/style.css");
echo $obj->getHeader();

require_once ('../../data/db.class.php');
$db = new db_class();
if (!$db->connect())
	$db->print_last_error(false);

/******************Actualizar el estado de la solicitud y asignarle un operador****************/
/*Obtener la fecha del servidor**/
$_date_sql = 'SELECT CURDATE() as hoy';

$r = $db->select($_date_sql);
$row1 = $db->get_row($r, 'MYSQL_ASSOC');
$fecha_hoy = $row1[hoy];

/*Obtener la hora del servidor**/
$_time_sql = 'SELECT CURTIME() as hoy';

$r = $db->select($_time_sql);
$row2 = $db->get_row($r, 'MYSQL_ASSOC');
$hora_hoy = $row2[hoy];
$data_update = array (
	'frm_req_status_cd' => 'P',
	'frm_req_date_admin' => $fecha_hoy . ' ' . $hora_hoy,
	'frm_req_id_operator' => $_SESSION[usuario_identificacion_sesion]
);

$user_id3 = $db->update_array('form_request', $data_update, 'id_frm_req=' . $_GET[id_frm_req]);
if (!$user_id3) {
	$debug3 .= "Ocurri&oacute; un error actualizando los datos del de la forma de atencion al cliente.<br>" . $db->last_error;
	echo '<br>' . $debug3 . '<br>';
	return;
}
/********************************************************************************/

$_sql = "SELECT 
		form_request.frm_req_cli_nm AS frm_req_cli_nm,
		form_request.frm_req_mail AS frm_req_mail,
		form_request_reason.frm_req_reason_nm AS frm_req_reason_nm,
		form_request.frm_req_cmnt AS frm_req_cmnt,
		form_request.frm_req_date_in AS frm_req_date_in,
		form_request.frm_req_cmt_operator AS frm_req_cmt_operator,
		IFNULL(form_request.frm_req_date_admin,'Solicitud no atendida previamente') AS frm_req_date_admin
		FROM 
		form_request,
		form_request_reason
		WHERE
		form_request.id_frm_req=" . $_GET[id_frm_req] . " AND
		form_request_reason.frm_req_reason_cd='" . $_GET[frm_req_reason_cd] . "'";
$_pagi_result = $db->select($_sql);
$row = mysql_fetch_array($_pagi_result);
?>
<br><br><br>
<script> 

function closeFormRequest(){
	page='../../control/cac/closeFormRequest.php?id_frm_req=<?php echo $_GET[id_frm_req];?>&frm_req_cmt_operator='+document.info_form_req.frm_req_cmt_operator.value;
	location.href=page;
}
function answerFormRequest(){			
	newwindow=window.open("../../control/cac/answerFormRequest.php?id_frm_req=<?php echo $_GET[id_frm_req];?>&frm_req_mail=<?php echo $row[frm_req_mail];?>","","toolbar=no, menubar=no, scrollbars=no,width=300,height=150");
	if (window.focus) {		
		newwindow.focus()
	}
			
}
function finalizeFormRequest(){	
	location.href='../../control/cac/finalizeFormRequest.php?id_frm_req=<?php echo $_GET[id_frm_req];?>';
}
</script>
<form name="info_form_req" method="POST" id="info_form_req">						
	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
<?php


echo '<tr>';
echo '<td bgcolor="#FFFFFF" class="titulo" colspan="2" ><b>Datos de la solicitud</b></td>';
echo '</tr>';
echo '<tr>';
echo '<td bgcolor="#DBEAF5" class="label">Nombre del Cliente:</td>';
echo '<td bgcolor="#DBEAF5" class="label">' . $row[frm_req_cli_nm] . '</td>';
echo '</tr>';
echo '<tr>';
echo '<td bgcolor="#DBEAF5" class="label">Direcci&oacute;n Email:</td>';
echo '<td bgcolor="#DBEAF5" class="label">' . $row[frm_req_mail] . '</td>';
echo '</tr>';
echo '<tr>';
echo '<td bgcolor="#DBEAF5" class="label">Motivo de la solicitud:</td>';
echo '<td bgcolor="#DBEAF5" class="label">' . $row[frm_req_reason_nm] . '</td>';
echo '</tr>';
echo '<tr>';
echo '<td bgcolor="#DBEAF5" class="label">Comentarios del Cliente:</td>';
echo '<td bgcolor="#DBEAF5" class="label">' . $row[frm_req_cmnt] . '</td>';
echo '</tr>';
echo '<tr>';
echo '<td bgcolor="#DBEAF5" class="label">Fecha de creaci&oacute;n de la Solicitud:</td>';
echo '<td bgcolor="#DBEAF5" class="label">' . $row[frm_req_date_in] . '</td>';
echo '</tr>';
echo '<tr>';
echo '<td bgcolor="#DBEAF5" class="label">Fecha de la primera atenci&oacute; de la Solicitud:</td>';
echo '<td bgcolor="#DBEAF5" class="label">' . $row[frm_req_date_admin] . '</td>';
echo '</tr>';
echo '<tr>';
?>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td class="label" valign="top">Observaciones del operador</td>
	<td><textarea id="frm_req_cmt_operator" name="frm_req_cmt_operator"><?php echo $row[frm_req_cmt_operator];?></textarea></td>
</tr>
<tr>
	<td colspan="2"><hr></td>
</tr>
<tr>
	<td>
		<input type="button" value="Cerrar" class="cssbutton" onclick="closeFormRequest()">&nbsp;
		<input type="button" value="Responder" class="cssbutton" onclick="answerFormRequest()">&nbsp;
		<input type="button" value="Finalizar" class="cssbutton" onclick="finalizeFormRequest()">
	</td>	
</tr>
</table>

</form>
