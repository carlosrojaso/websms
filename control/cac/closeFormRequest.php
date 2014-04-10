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

$comentarios=$_GET[frm_req_cmt_operator];
$identificacion=$_GET[id_frm_req];

echo 'comentarios:'.$comentarios;
/******************Guardar los comentarios del operador y cerrar la solicitud****************/
$data_update= array('frm_req_cmt_operator' => $comentarios);

$user_id3 = $db->update_array('form_request', $data_update,'id_frm_req='.$identificacion);
if (!$user_id3){
	$debug3.= "Ocurri&oacute; un error cerrando los datos del de la forma de atencion al cliente.<br>".$db->last_error;
	echo '<br>'.$debug3.'<br>';
	return;
}
/********************************************************************************/
echo '<script> history.back();</script>';
?>
