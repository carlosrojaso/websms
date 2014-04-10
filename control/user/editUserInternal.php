<?php


/**
 * editUserParticular.php
 * 
 * Control Agregar Usuarios.
 * @author Victor Manuel Vallecilla Mira<vallecilla@gmail.com> 
 * @version 1.0
 * @package user
 * @creacion: 20/05/2007
 * @license: GNU/GPL	
*/
/********************************HEADER************************************************/
include_once ('../../includes/simplepage.class.php');
include_once ('../../includes/session.inc');
$obj = new simplepage();
$obj->setTitle("Edición datos personales - Particular");
$obj->setCSS("../../includes/style/style.css");
echo $obj->getHeader();
$img_dir = "../../images";

/******Datos del usuario interno*************************************************/
$id_client = ($_POST['id_client']);
$nombre = trim($_POST['cli_firstname']);
$apellido = trim($_POST['cli_lastname_1']) . ' ' . trim($_POST['cli_lastname_2']);
$email = trim($_POST['cli_e_mail']);
$cli_country_cd = trim($_POST['cli_country_cd']);

/********************************************************************************/
/******Datos del usuario*********************************************************/
$id_user = $_POST[id_user];
$login = trim($_POST['user_login']);
$password = trim($_POST['user_pass']);
$user_date_in = trim($_POST['user_date_in']);
$user_date_req = trim($_POST['user_date_req']);
$user_date_out = trim($_POST['user_date_out']);
$user_prof_cd = trim($_POST['user_prof_cd']);
$user_info_cre = trim($_POST['user_info_cre']);
/************************************************************************************/

if ($user_date_out == 'Indefinida') {
	$user_date_out = '';
}

require_once ('../../data/db.class.php');
$db = new db_class;

if (!$db->connect()) {
	$db->print_last_error(false);
}

$r = $db->select("SELECT cli_firstname,cli_lastname,user_login,users.id_client as id_client FROM users, client WHERE user_login='$login' AND users.id_client=client.id_client");
$row = $db->get_row($r, 'MYSQL_ASSOC');

if ($db->row_count > 0) {
	if ($row[id_client] != $id_client) {
?>			
	<form action="<?php echo $_GET[from_page].'?par='.$_GET[par].'&usuario='.$_GET[usuario];?>" method="POST" id="errorData" name"errorData">								
		<br><br><br><br><br>
		<table align="center">
			<tr>
				<td class="titulo">El usuario <b><?php echo $row[user_login];?></b> ya existe por favor seleccione otro usuario.<br><br></td>
			</tr>
			<tr>					
				<td><input type="submit" class="cssbutton" value="Volver"></td>					
			</tr>
			<input type="hidden" id="cli_firstnameE"  name="cli_firstnameE" value="<?php echo $nombre;?>">							
			<input type="hidden" id="cli_lastname_1E" name="cli_lastname_1E" value="<?php echo trim($_POST['cli_lastname_1']);?>">				
			<input type="hidden" id="cli_lastname_2E" name="cli_lastname_2E" value="<?php echo trim($_POST['cli_lastname_2']);?>">						
			<input type="hidden" id="cli_e_mailE" name="cli_e_mailE" value="<?php echo $email;?>">
			<input type="hidden" id="cli_country_cdE" name="cli_country_cdE" value="<?php echo $cli_country_cd;?>">											
			<input type="hidden" id="id_userE"  name="id_userE" value="<?php echo $id_user;?>">							
			<input type="hidden" id="id_clientE" name="id_clientE" value="<?php echo $id_client;?>">										
			<input type="hidden" id="user_date_inE" name="user_date_inE" value="<?php echo $user_date_in;?>">											
			<input type="hidden" id="user_date_outE" name="user_date_outE" value="<?php echo $user_date_out;?>">							
			<input type="hidden" id="user_loginE" name="user_loginE" value="<?php echo $login;?>">									
			<input type="hidden" id="user_passE" name="user_passE" value="<?php echo $password;?>">								
			<input type="hidden" id="user_prof_cdE" name="user_prof_cdE" value="<?php echo $user_prof_cd;?>">							
		</table>
	</form>				
	<?php


		return;
	}
}

//Obtener la fecha del sistema del servidor de base de datos.
$r = $db->select('SELECT CURDATE() as hoy');
$row = $db->get_row($r, 'MYSQL_ASSOC');
$fecha_hoy = $row[hoy];
$r = $db->select('SELECT CURTIME() as hoy');
$row = $db->get_row($r, 'MYSQL_ASSOC');
$hora_hoy = $row[hoy];
if ($_POST[edit_client] == 'true') {
	/******************Actualizar el flag de los registros anteriores****************/
	$data_update = array (
		'cli_current_flag' => 0
	);
	$user_id1 = $db->update_array('client', $data_update, 'id_client=' . $id_client);
	if (!$user_id1) {
		$debug1 .= "Ocurri&oacute; un error actualizando los datos del cliente.<br>" . $db->last_error;
		echo '<br>' . $debug1 . '<br>';
		return;
	}
	/********************************************************************************/

	//Ingresar el nuevo registro
	$data = array (
		'id_client' => $id_client,
		'cli_cd' => $cli_country_cd . str_pad($id_client,5,'0',STR_PAD_LEFT), 
		'cli_firstname' => $nombre, 
		'cli_lastname' => $apellido, 
		'cli_e_mail' => $email, 
		'cli_current_flag' => 1, 
		'cli_country_cd' => $cli_country_cd, 
		'cli_date_mod' => $fecha_hoy . ' ' . $hora_hoy);

	$user_id2 = $db->insert_array('client', $data);
	if (!$user_id2) {
		$debug1 .= "Ocurri&oacute; un error ingresando los datos del cliente.<br>" . $db->last_error;
		echo '<br>' . $debug1 . '<br>';
		return;
	}
	/**********************Actualizar la ultima fecha de modificacion y el usuario que actualiza****************/
	$data_update2= array('user_date_mod' => $fecha_hoy.' '.$hora_hoy,
						'user_info_upd'=>$_SESSION[nombre_usuario]);
	$user_id_upd = $db->update_array('users', $data_update2,'id_client='.$id_client.' AND user_current_flag=1');
	if (!$user_id_upd ){
		$debug1.= "Ocurri&oacute; un error actualizando los datos del Usuario.<br>".$db->last_error;
	}

}
/***********************************************************************************/
//Obtener la fecha del sistema del servidor de base de datos.
$r = $db->select('SELECT CURDATE() as hoy');
$row = $db->get_row($r, 'MYSQL_ASSOC');
$fecha_hoy = $row[hoy];
$r = $db->select('SELECT CURTIME() as hoy');
$row = $db->get_row($r, 'MYSQL_ASSOC');
$hora_hoy = $row[hoy];

if ($_POST[edit_user] == 'true') {
	/******************Actualizar el flag de los registros anteriores****************/
	$data_update = array (
		'user_current_flag' => 0
	);

	$user_id3 = $db->update_array('users', $data_update, 'id_user=' . $id_user);
	if (!$user_id3) {
		$debug3 .= "Ocurri&oacute; un error actualizando los datos del usuario.<br>" . $db->last_error;
		echo '<br>' . $debug3 . '<br>';
		return;
	}
	/********************************************************************************/
	/***************Ingresar el registro del nuevo usuario(modificado)****************/
	if ($user_date_out != 'Indefinido' && $user_date_in) {
		//echo 'ingresa user date out y user date in';
		$data = array (
			'id_user' => $id_user,
			'id_client' => $id_client,
			'user_prof_cd' => $user_prof_cd,
			'user_prefer_lang' => $_SESSION[idm],
			'user_login' => $login,
			'user_pass' => $password,
			'user_info_cre' => $user_info_cre,
			'user_info_upd' => $_SESSION[nombre_usuario],
			'user_status_cd' => 'A',
			'user_date_req' => $user_date_req,
			'user_current_flag' => 1,
			'user_date_in' => $user_date_in,
			'user_date_out' => $user_date_out . ' ' . $hora_hoy,
			'user_date_mod' => $fecha_hoy . ' ' . $hora_hoy
		);
	}
	elseif ($user_date_out != 'Indefinido') {
		//echo 'ingresa user date out '.$user_date_out;
		$data = array (
			'id_user' => $id_user,
			'id_client' => $id_client,
			'user_prof_cd' => $user_prof_cd,
			'user_prefer_lang' => $_SESSION[idm],
			'user_login' => $login,
			'user_pass' => $password,
			'user_info_cre' => $user_info_cre,
			'user_info_upd' => $_SESSION[nombre_usuario],
			'user_status_cd' => 'A',
			'user_date_req' => $user_date_req,
			'user_current_flag' => 1,
			'user_date_in' => $user_date_in,
			'user_date_mod' => $fecha_hoy . ' ' . $hora_hoy,
			'user_date_out' => $user_date_out . ' ' . $hora_hoy,

			
		);
	} else {
		//echo 'no se ingresa ninguno';
		$data = array (
			'id_user' => $id_user,
			'id_client' => $id_client,
			'user_prof_cd' => $user_prof_cd,
			'user_prefer_lang' => $_SESSION[idm],
			'user_login' => $login,
			'user_pass' => $password,
			'user_info_cre' => $user_info_cre,
			'user_info_upd' => $_SESSION[nombre_usuario],
			'user_status_cd' => 'A',
			'user_date_req' => $user_date_req,
			'user_current_flag' => 1,
			'user_date_in' => $user_date_in,
			'user_date_mod' => $fecha_hoy . ' ' . $hora_hoy
		);
	}

	$user_id4 = $db->insert_array('users', $data);

	if (!$user_id4) {
		$debug4 .= "Ocurri&oacute; un error ingresando los datos del usuario.<br>" . $db->last_error;
		echo '<br>' . $debug4 . '<br>';
		return;
	}
}
/************************************************************************/
?>
<br><br><br>
<table align="center">
	<tr>
		<td class="titulo">Sus datos personales han sido modificados satisfactoriamente</td>
	</tr>
	<tr>
		<td><input type="button" class="cssbutton" onclick="location.href='../../ui/user/showUsersInternals.php'" value="Volver"></td>	
	</tr>		
</table>
<br><br><br>
<?php


echo $obj->getFooter();
?>
