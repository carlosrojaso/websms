<?php
/**
 * editUserdataAcces.php
 * 
 * Control Agregar Usuarios.
 * @author Victor Manuel Vallecilla Mira<vallecilla@gmail.com> 
 * @version 1.0
 * @package user
 * @creacion: 20/05/2007
 * @license: GNU/GPL	
*/
/********************************HEADER************************************************/
include_once('../../includes/simplepage.class.php');
include_once('../../includes/session.inc');
check_login();
$obj = new simplepage();
$obj->setTitle("Desactivar Usuario");
$obj->setCSS("../../includes/style/style.css");
echo $obj->getHeader();
$img_dir = "../../images";

/******Datos del usuario******************/
$id_user=$_POST[id_user];
/******Datos del cliente******************/
$id_client=$_POST[id_client];

/*
echo 'id_user: '.$id_user;
echo 'id_client: '.$id_client;
*/

require_once('../../data/db.class.php');
$db = new db_class;

if (!$db->connect()) {
	$db->print_last_error(false);
}

//Obtener la fecha del sistema del servidor de base de datos.
$r = $db->select('SELECT CURDATE() as hoy');
$row=$db->get_row($r, 'MYSQL_ASSOC');
$fecha_hoy=$row[hoy];
$r = $db->select('SELECT CURTIME() as hoy');
$row=$db->get_row($r, 'MYSQL_ASSOC');
$hora_hoy=$row[hoy];

/******************Actualizar el flag de los registros anteriores****************/
$data_update= array('user_status_cd' => $_POST[status]);
$user_id1 = $db->update_array('users', $data_update,'id_user='.$id_user.' AND user_current_flag=1');
if (!$user_id1){
	$debug1.= "Ocurri&oacute; un error actualizando los datos del usuario.<br>".$db->last_error;
}
/*******************************************************************************/
if($_POST[status]=='C'){	
	/**********************Actualizar la fecha de salida del usuario****************/
	$data_update= array('user_date_out' => $fecha_hoy.' '.$hora_hoy,
						'user_info_upd'=>$_SESSION[nombre_usuario],
						'user_status_cd'=>'C');
	$user_id1 = $db->update_array('users', $data_update,'id_client='.$id_client.' AND user_current_flag=1');
	if (!$user_id1){
		$debug1.= "Ocurri&oacute; un error actualizando los datos del cliente.<br>".$db->last_error;
	}
}
if($_POST[status]=='D'){
	/**********************Actualizar la fecha de salida del usuario****************/
	$data_update= array('user_date_mod' => $fecha_hoy.' '.$hora_hoy,
						'user_info_upd'=>$_SESSION[nombre_usuario],
						'user_status_cd'=>'D');
	$user_id1 = $db->update_array('users', $data_update,'id_client='.$id_client.' AND user_current_flag=1');
	if (!$user_id1){
		$debug1.= "Ocurri&oacute; un error actualizando los datos del cliente.<br>".$db->last_error;
	}
}
if($_POST[status]=='A'){
	/**********************Actualizar la fecha de salida del usuario****************/
	$data_update= array('user_date_mod' => $fecha_hoy.' '.$hora_hoy,
						'user_info_upd'=>$_SESSION[nombre_usuario],
						'user_status_cd'=>'A');
	$user_id1 = $db->update_array('users', $data_update,'id_client='.$id_client.' AND user_current_flag=1');
	if (!$user_id1){
		$debug1.= "Ocurri&oacute; un error actualizando los datos del cliente.<br>".$db->last_error;
	}
}
/*******************************************************************************/
if(!$user_id1){
	echo '
		<table align="center">
			<tr>
				<td><h3>
					'.$debug1.'
					</h3>
				</td>
			</tr>			
		</table>';
}else{
	if(!$_POST[from_page]){
		$r = $db->select('SELECT user_login from users WHERE id_user='.$id_user.' AND user_current_flag=1' );
		$row=$db->get_row($r, 'MYSQL_ASSOC');
?>
	<br><br><br>
	<table align="center">
		<tr>
			<td class="titulo">
				El usuario <?php echo $row[user_login]?> ha sido <?php echo($_POST[status]=='D'?'Desactivado':'Activado');?>				
			</td>
		</tr>
		<tr>
			<td><input type="button" class="cssbutton" onclick="location.href='../../ui/user/<?php echo $_GET[back_page];?>.php'" value="Ok"></td>
		</tr>	
	</table>
	<br><br><br>
<?php
	}else{
		echo
		'
		<script language="javascript">
			window.parent.location.href="../../control/core/logout.php?deact=true";			
		</script>
		';
	?>	
<?php }
}
echo $obj->getFooter();
?>