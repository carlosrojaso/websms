<?php
/**
 * addBonus.php
 * 
 * Control Editar Bonos.
 * @author Victor Manuel Vallecilla Mira<vallecilla@gmail.com> 
 * @version 1.0
 * @package user
 * @creacion: 08/01/2008
 * @license: GNU/GPL	
*/
/********************************HEADER************************************************/
include_once('../../includes/session.inc');
check_login();
include_once ('../../includes/comparedate/DateAdd.class.php');

/********Datos del bono*******************/
$credit_cd   = trim($_POST['credit_cd']);
$credit_nm = trim($_POST['credit_nm']);
$credit_dsc   = trim($_POST['credit_dsc']);
$credit_num=trim($_POST['credit_num']);
$credit_price=trim($_POST['credit_price']);
$credit_begin_date=trim($_POST['credit_begin_date']);
$credit_end_date=trim($_POST['credit_end_date'])=="Indefinida"?NULL:trim($_POST['credit_end_date']);
$credit_cli_act_cd=trim($_POST['credit_cli_act_cd']);
$credit_free_flag=trim($_POST['credit_free_flag']);
$credit_max_cli=trim($_POST['credit_max_cli'])==""?NULL:trim($_POST['credit_max_cli']);
$credit_publish_flag=trim($_POST['credit_publish_flag']);
$credit_status_cd=trim($_POST['credit_status_cd']);
$credit_cre_user_id=trim($_POST['credit_cre_user_id']);
$credit_mod_user_id=$_SESSION[usuario_identificacion_sesion];
$credit_date_in=trim($_POST['credit_date_in']);
$credit_date_mod=date("Y-m-d h:i:s");
$credit_date_out=NULL;

require_once('../../data/db.class.php');
$db = new db_class;
if (!$db->connect()){
	$db->print_last_error(false);
} 
	
	/*Arreglo de datos que se guardan para el bono**/
	$data = array(
	'credit_cd'=> $credit_cd,	
	'credit_nm' => $credit_nm,
	'credit_dsc' => $credit_dsc,
	'credit_num' => $credit_num,
	'credit_price' => $credit_price,
	'credit_begin_date' => $credit_begin_date,
	'credit_end_date' => $credit_end_date,
	'credit_cli_act_cd' =>$credit_cli_act_cd,
	'credit_free_flag' => $credit_free_flag,
	'credit_max_cli' => $credit_max_cli,
	'credit_publish_flag' =>$credit_publish_flag,
	'credit_status_cd' => $credit_status_cd,
	'credit_cre_user_id' => $credit_cre_user_id,
	'credit_mod_user_id' => $credit_mod_user_id,
	'credit_date_in' => $credit_date_in,
	'credit_date_mod' => $credit_date_mod,
	'credit_date_out' => $credit_date_out	
	);
	
	/*Insertar los datos del cliente**/
	$credit = $db->update_array('credit', $data,"id_credit=".$_POST[id_credit]);

	/*Revisar si el proceso de insercion se llevo a cabo de manera correcta**/
	if (!$credit){
		$debug1.= "Ocurri&oacute; un error actualizando los datos del bono.<br>".$db->last_error;
		echo '<br>'.$debug1.'<br>';
		return;
	}

?>
<br><br>
<table align="center">
	<tr>
		<td class="titulo">El bono <?php echo $credit_nm;?> ha sido actualizado.</td>
	</tr>
	<tr>
		<td><input type="button" class="cssbutton" onclick="location.href='../../ui/core/body.php'" value="Volver"></td>	
	</tr>	
</table>

