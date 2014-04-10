<?php
/**
 * editUserdataAcces.php
 * 
 * Control Desactivar/Finalizar Bono.
 * @author Victor Manuel Vallecilla Mira<vallecilla@gmail.com> 
 * @version 1.0
 * @package user
 * @creacion: 08/01/2008
 * @license: GNU/GPL	
*/
/********************************HEADER************************************************/
include_once('../../includes/session.inc');
check_login();

/********Datos del bono*******************/
$id_credit   = trim($_POST['id_credit']);
$credit_status_cd=trim($_POST['credit_status_cd']);
$credit_mod_user_id=$_SESSION[usuario_identificacion_sesion];
$credit_date_mod=date("Y-m-d h:i:s");

require_once('../../data/db.class.php');
$db = new db_class;

if (!$db->connect()) {
	$db->print_last_error(false);
}

/******************Actualizar el flag de los registros anteriores****************/
$data_update= array('credit_status_cd' => $credit_status_cd,
					'credit_mod_user_id'=>$credit_mod_user_id,
					'credit_date_mod'=>$credit_date_mod);
$user_id1 = $db->update_array('credit', $data_update,'id_credit='.$id_credit);
if (!$user_id1){
	echo "Ocurri&oacute; un error actualizando los datos del Bono.<br>".$db->last_error;
}

?>
	<br><br><br>
	<table align="center">
		<tr>
			<td class="titulo">
				El bono ha sido <?php switch($credit_status_cd){ case 'C': echo 'Desactivado'; case 'A': echo'Activado'; case 'F': echo 'Finalizado';}?>				
			</td>
		</tr>
		<tr>
			<td><input type="button" onclick="location.href='../../ui/credit/showBonus.php'" value="Ok"></td>
		</tr>	
	</table>
	<br><br><br>
