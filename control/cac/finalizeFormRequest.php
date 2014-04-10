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

$_sql = "SELECT form_request.frm_req_end_cd AS frm_req_end_cd FROM form_request WHERE form_request.id_frm_req=" . $_GET[id_frm_req];
//echo $_sql;
$_pagi_result = $db->select($_sql);
$row = mysql_fetch_array($_pagi_result);

if ($row[frm_req_end_cd] == 'E') {
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
		'frm_req_status_cd' => 'C',
		'frm_req_date_out' => $fecha_hoy . ' ' . $hora_hoy
	);

	$user_id3 = $db->update_array('form_request', $data_update, 'id_frm_req=' . $_GET[id_frm_req]);
	if (!$user_id3) {
		$debug3 .= "Ocurri&oacute; un error actualizando los datos del de la forma de atencion al cliente.<br>" . $db->last_error;
		echo '<br>' . $debug3 . '<br>';
		return;
	}
	echo '<script>location.href="../../ui/cac/queryFormRequest.php";</script>';
} else {
?>
			<br><br><br><br>
			<form name="finalize_reason" id="finalize_reason" method="POST" action="../../control/cac/setFinalizeType.php?id_frm_req=<?php echo $_GET[id_frm_req];?>">	
			  <table aling="center" width="70%">	  
			    <tr>
			      <td colspan="2" class="titulo">Por favor seleccione el motivo de la finalizaci&oacute;n</td>
			    </tr>
			    <tr>
			      <td class="label">Motivo de la finalizaci&oacute;n</td>
			      <td>
					  <select name="frm_req_end_cd" id="frm_req_end_cd">
<?php

	$_sql = "SELECT frm_req_end_cd,frm_req_end_nm FROM form_request_end WHERE frm_req_end_cd!='E'";
	//echo $_sql;
	$_pagi_result = $db->select($_sql);
	while ($row = mysql_fetch_array($_pagi_result)) {
		echo '<option value="' . $row[frm_req_end_cd] . '">' . $row[frm_req_end_nm] . '</option>';
	}
?>			    			  
					  </select>
		  		  </td>
			    </tr>
			    <tr>
			      <td colspan="2">
			      	<input class="cssbutton" type="submit" name="Enviar" value="Enviar" />&nbsp;
			      	<input class="cssbutton" type="button" name="Regresar" value="Regresar" onclick="history.back();"/>
			      </td>     		      
			    </tr>    
			  </table>    
			</form>		
<?php
}
?>
