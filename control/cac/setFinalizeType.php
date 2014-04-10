<?php


/*
 * Created on 15/10/2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
require_once ('../../data/db.class.php');
$db = new db_class();
if (!$db->connect())
	$db->print_last_error(false);
if (isset ($_POST[frm_req_end_cd])) {
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
		'frm_req_end_cd' => $_POST[frm_req_end_cd],
		'frm_req_date_out' => $fecha_hoy . ' ' . $hora_hoy
	);
	echo 'frm_req_end_cd'.$_POST[frm_req_end_cd];
	echo 'id_frm_req'.$_GET[id_frm_req];
	$user_id3 = $db->update_array('form_request', $data_update, 'id_frm_req=' . $_GET[id_frm_req]);
	if (!$user_id3) {
		$debug3 .= "Ocurri&oacute; un error actualizando los datos del de la forma de atencion al cliente.<br>" . $db->last_error;
		echo '<br>' . $debug3 . '<br>';
		return;
	}
	echo '<script>location.href="../../ui/cac/queryFormRequest.php";</script>';
}
?>
