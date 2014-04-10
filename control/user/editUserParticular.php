<?php

/**
 * editUserParticular.php
 * 
 * Control Editar Usuarios Particulares.
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
$obj->setTitle("Edición de datos personales - Particular");
$obj->setCSS("../../includes/style/style.css");
echo $obj->getHeader();
$img_dir = "../../images";

/********Datos del cliente**********************************************************/
$id_client = ($_POST['id_client']);
$nombre = trim($_POST['cli_firstname']);
$apellido = trim($_POST['cli_lastname_1']) . ' ' . trim($_POST['cli_lastname_2']);
$sexo = trim($_POST['cli_sex_cd']);
$id_tipo = trim($_POST['cli_ident_type_cd']);
$id_num = trim($_POST['cli_ident_num']);
$naci = trim($_POST['birthday']);
$tel_1 = trim($_POST['cli_phone_num1']);
$cell = trim($_POST['cli_cell_phone']);
$email = trim($_POST['cli_e_mail']);
$dir = trim($_POST['cli_address']);
$codigo_postal = trim($_POST['cli_postal_cd']);
$poblacion = trim($_POST['cli_town']);
$cli_country_cd = trim($_POST['cli_country_cd']);

/********************************************************************************/
/******Datos del usuario*********************************************************/
$id_user = $_POST[id_user];
$login = trim($_POST['user_login']);
$password = trim($_POST['user_pass']);
$user_date_req = trim($_POST['user_date_req']);
$user_date_in = trim($_POST['user_date_in']);
$user_date_out = trim($_POST['user_date_out']);
$user_info_cre = trim($_POST['user_info_cre']);
$user_prof_cd = trim($_POST['user_prof_cd']);
/************************************************************************************/
/*
echo '$id_client'.$id_client.'<br>';
echo '$nombre'.$nombre.'<br>';
echo '$apellido'.$apellido.'<br>';
echo '$sexo'.$sexo.'<br>';
echo '$id_tipo'.$id_tipo.'<br>';
echo '$id_num'.$id_num.'<br>';
echo '$naci'.$naci.'<br>';
echo '$tel_1'.$tel_1.'<br>';
echo '$cell'.$cell.'<br>';
echo '$email'.$email.'<br>';
echo '$dir'.$dir.'<br>';
echo '$codigo_postal'.$codigo_postal.'<br>';
echo '$poblacion'.$poblacion.'<br>';
echo '$user_prof_cd'.$user_prof_cd.'<br>';
echo '$id_user'.$id_user.'<br>';
echo '$login'.$login.'<br>';
echo '$password'.$password.'<br>';
echo '$user_prof_cd'.$user_prof_cd.'<br>';
echo '$user_date_in'.$user_date_in.'<br>';
echo '$user_date_out'.$user_date_out.'<br>';
*/

require_once ('../../data/db.class.php');
$db = new db_class;

if (!$db->connect()) {
	$db->print_last_error(false);
}
/*Revisar el codigo postal y la ciudad**/
$_zip_sql = 'SELECT geo_country_cd,geo_town FROM geography WHERE geo_postal_cd=' . $codigo_postal;

$r = $db->select($_zip_sql);
$row = $db->get_row($r, 'MYSQL_ASSOC');

/*Obtener el codigo de region**/
//$cli_country_cd=$row['geo_country_cd'];

/*Comparar la ciudad devuelta por la consulta segun el codigo ingresado por el usuario con la
ingresada en el campo poblcion.**/

if (strcasecmp($row[geo_town], $poblacion) != 0) {
	echo '
		<form action="' .
	$_GET[from_page] . '?par=' . $_GET[par] . '&usuario=' . $_GET[usuario] . '" method="POST" id="errorData" name"errorData">				
				<br><br><br><br><br>	
				<table align="center">
					<tr>
						<td class="titulo">
							El código postal <b>' . $codigo_postal . '</b> no corresponde a la población <b>' . $poblacion . '</b> por favor ingrese un codigo postal valido.<br>			  			
						</td>
					</tr>';
?>
				<tr>
					<td><input type="submit" class="cssbutton" value="Volver"></td>					
				</tr>
				<input type="hidden" id="cli_firstnameE"  name="cli_firstnameE" value="<?php echo $nombre;?>">
				<input type="hidden" id="cli_lastname_1E" name="cli_lastname_1E" value="<?php echo trim($_POST['cli_lastname_1']);?>">
				<input type="hidden" id="cli_lastname_2E" name="cli_lastname_2E" value="<?php echo trim($_POST['cli_lastname_2']);?>">
				<input type="hidden" id="cli_sex_cdE" name="cli_sex_cdE" value="<?php echo $sexo;?>">
				<input type="hidden" id="cli_ident_type_cdE" name="cli_ident_type_cdE" value="<?php echo $id_tipo;?>">
				<input type="hidden" id="cli_ident_numE" name="cli_ident_numE" value="<?php echo $id_num;?>">
				<input type="hidden" id="birthdayE" name="birthdayE" value="<?php echo $naci;?>">
				<input type="hidden" id="cli_phone_num1E" name="cli_phone_num1E" value="<?php echo $tel_1;?>">
				<input type="hidden" id="cli_cell_phoneE" name="cli_cell_phoneE" value="<?php echo $cell;?>">
				<input type="hidden" id="cli_e_mailE" name="cli_e_mailE" value="<?php echo $email;?>">	
				<input type="hidden" id="cli_addressE" name="cli_addressE" value="<?php echo $dir;?>">
				<input type="hidden" id="cli_postal_cdE" name="cli_postal_cdE" value="<?php echo $codigo_postal;?>">
				<input type="hidden" id="cli_townE" name="cli_townE" value="<?php echo $poblacion;?>">				
				<input type="hidden" id="user_prof_cdE" name="user_prof_cdE" value="<?php echo $user_prof_cd;?>">				
				<input type="hidden" id="id_userE"  name="id_userE" value="<?php echo $id_user;?>">							
				<input type="hidden" id="id_clientE" name="id_clientE" value="<?php echo $id_client;?>">							
				<input type="hidden" id="user_date_inE" name="user_date_inE" value="<?php echo $user_date_in;?>">								
				<input type="hidden" id="user_date_outE" name="user_date_outE" value="<?php echo $user_date_out;?>">							
				<input type="hidden" id="user_loginE" name="user_loginE" value="<?php echo $login;?>">									
				<input type="hidden" id="user_passE" name="user_passE" value="<?php echo $password;?>">
				<input type="hidden" id="cli_country_cdE" name="cli_country_cdE" value="<?php echo $cli_country_cd;?>">												
			</table>
		</form>		
		<?php

	return;
}
if ($cli_country_cd == '') {
	echo '
		<form action="' .
	$_GET[from_page] . '?par=' . $_GET[par] . '&usuario=' . $_GET[usuario] . '" method="POST" id="errorData" name"errorData">				
				<br><br><br><br><br>
				<table align="center">
					<tr>
						<td class="titulo">
							El código postal <b>' . $codigo_postal . '</b> no existe por favor ingrese un codigo postal valido.<br>			  			
						</td>
					</tr>';
?>
			<tr>
				<td><input type="submit" class="cssbutton" value="Volver"></td>				
			</tr>
			<input type="hidden" id="cli_firstnameE"  name="cli_firstnameE" value="<?php echo $nombre;?>">
			<input type="hidden" id="cli_lastname_1E" name="cli_lastname_1E" value="<?php echo trim($_POST['cli_lastname_1']);?>">
			<input type="hidden" id="cli_lastname_2E" name="cli_lastname_2E" value="<?php echo trim($_POST['cli_lastname_2']);?>">
			<input type="hidden" id="cli_sex_cdE" name="cli_sex_cdE" value="<?php echo $sexo;?>">
			<input type="hidden" id="cli_ident_type_cdE" name="cli_ident_type_cdE" value="<?php echo $id_tipo;?>">
			<input type="hidden" id="cli_ident_numE" name="cli_ident_numE" value="<?php echo $id_num;?>">
			<input type="hidden" id="birthdayE" name="birthdayE" value="<?php echo $naci;?>">
			<input type="hidden" id="cli_phone_num1E" name="cli_phone_num1E" value="<?php echo $tel_1;?>">
			<input type="hidden" id="cli_cell_phoneE" name="cli_cell_phoneE" value="<?php echo $cell;?>">
			<input type="hidden" id="cli_e_mailE" name="cli_e_mailE" value="<?php echo $email;?>">	
			<input type="hidden" id="cli_addressE" name="cli_addressE" value="<?php echo $dir;?>">
			<input type="hidden" id="cli_postal_cdE" name="cli_postal_cdE" value="<?php echo $codigo_postal;?>">
			<input type="hidden" id="cli_townE" name="cli_townE" value="<?php echo $poblacion;?>">				
			<input type="hidden" id="user_prof_cdE" name="user_prof_cdE" value="<?php echo $user_prof_cd;?>">
			<input type="hidden" id="user_prof_cdE" name="user_prof_cdE" value="<?php echo $user_prof_cd;?>">										
			<input type="hidden" id="id_userE"  name="id_userE" value="<?php echo $id_user;?>">							
			<input type="hidden" id="id_clientE" name="id_clientE" value="<?php echo $id_client;?>">							
			<input type="hidden" id="user_date_inE" name="user_date_inE" value="<?php echo $user_date_in;?>">								
			<input type="hidden" id="user_date_outE" name="user_date_outE" value="<?php echo $user_date_out;?>">							
			<input type="hidden" id="user_loginE" name="user_loginE" value="<?php echo $login;?>">									
			<input type="hidden" id="user_passE" name="user_passE" value="<?php echo $password;?>">								
			<input type="hidden" id="user_prof_cdE" name="user_prof_cdE" value="<?php echo $user_prof_cd;?>">
			<input type="hidden" id="cli_country_cdE" name="cli_country_cdE" value="<?php echo $cli_country_cd;?>">							
			<td>			
		</table>	
	</form>
	<?php

	return;
}
//Obtener la fecha del sistema del servidor de base de datos.
$r = $db->select('SELECT CURDATE() as hoy');
$row = $db->get_row($r, 'MYSQL_ASSOC');
$fecha_hoy = $row[hoy];
$r = $db->select('SELECT CURTIME() as hoy');
$row = $db->get_row($r, 'MYSQL_ASSOC');
$hora_hoy = $row[hoy];
if ($_POST[edit_client] == 'true') {
	/******************Actualizar el flag de los registros anteriores***************/
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
	/***************Ingresar el registro del nuevo Cliente (modificado)**************/
	$data = array (
		'id_client' => $id_client,
		'cli_cd' => $cli_country_cd . str_pad($id_client,5,'0',STR_PAD_LEFT), 
		'cli_firstname' => $nombre, 
		'cli_lastname' => $apellido, 
		'cli_sex_cd' => $sexo, 
		'cli_birthdate' => $naci, 
		'cli_ident_type_cd' => $id_tipo, 
		'cli_ident_num' => $id_num, 
		'cli_act_cd' => $user_prof_cd, 
		'cli_phone_num1' => $tel_1, 
		'cli_cell_phone' => $cell, 
		'cli_e_mail' => $email, 
		'cli_address' => $dir, 
		'cli_postal_cd' => $codigo_postal, 
		'cli_town' => $poblacion, 
		'cli_country_cd' => $cli_country_cd, 
		'cli_current_flag' => 1, 
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
		$debug1.= "Ocurri&oacute; un error actualizando los datos del Cliente.<br>".$db->last_error;
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
	if ($user_date_out != '' && $user_date_in != '') {
		$data = array (
			'id_user' => $id_user,
			'id_client' => $id_client,
			'user_prof_cd' => $user_prof_cd,
			'user_prefer_lang' => (isset ($_SESSION[idm]) ? $_SESSION[idm] : 'SP'),
			'user_login' => $login, 
			'user_pass' => $password, 
			'user_info_cre' => $user_info_cre, 
			'user_info_upd' => $_SESSION[nombre_usuario], 
			'user_status_cd' => 'A', 
			'user_date_req' => $user_date_req, 
			'user_current_flag' => 1, 
			'user_date_in' => $user_date_in, 
			'user_date_out' => $user_date_out . ' ' . $hora_hoy, 
			'user_date_mod' => $fecha_hoy . ' ' . $hora_hoy);
	}
	elseif ($user_date_out != '' && $user_date_in == '') {
		$data = array (
			'id_user' => $id_user,
			'id_client' => $id_client,
			'user_prof_cd' => $user_prof_cd,
			'user_prefer_lang' => (isset ($_SESSION[idm]) ? $_SESSION[idm] : 'SP'), 
			'user_login' => $login, 'user_pass' => $password, 
			'user_info_cre' => $user_info_cre,
			'user_info_upd' => $_SESSION[nombre_usuario],
			'user_status_cd' => 'A', 
			'user_date_req' => $user_date_req, 
			'user_current_flag' => 1, 
			'user_date_in' => $user_date_in, 
			'user_date_mod' => $fecha_hoy . ' ' . $hora_hoy, 
			'user_date_out' => $user_date_out . ' ' . $hora_hoy,);
	} else {
		$data = array (
			'id_user' => $id_user,
			'id_client' => $id_client,
			'user_prof_cd' => $user_prof_cd,
			'user_prefer_lang' => (isset ($_SESSION[idm]) ? $_SESSION[idm] : 'SP'), 
			'user_login' => $login, 
			'user_pass' => $password, 
			'user_info_cre' => $user_info_cre, 
			'user_info_upd' => $_SESSION[nombre_usuario], 
			'user_status_cd' => 'A', 
			'user_date_req' => $user_date_req, 
			'user_current_flag' => 1, 
			'user_date_in' => $user_date_in, 
			'user_date_mod' => $fecha_hoy . ' ' . $hora_hoy);
	}

	$user_id4 = $db->insert_array('users', $data);

	if (!$user_id4) {
		$debug4 .= "Ocurri&oacute; un error ingresando los datos del usuario.<br>" . $db->last_error;
		echo '<br>' . $debug4 . '<br>';
		return;
	}
	/************************************************************************/
}
?>
<br><br><br>
<table align="center">
	<tr>
		<td class="titulo">Sus datos personales han sido modificados satisfactoriamente</td>
	</tr>
	<tr>
	<?php

if ($_SESSION[auth] == 'yes') {
	if (isset ($_GET[par])) {
?>
		<td><input type="button" class="cssbutton" onclick="location.href='../../ui/user/showUsers.php'" value="Volver"></td>
	<?php

	} else {
?>
		<td><input type="button" class="cssbutton" onclick="location.href='../../ui/core/body.php'" value="Volver"></td>
	<?php

	}
} else {
?>	
		<td><input type="button" class="cssbutton" onclick="location.href='../../index.php'" value="Volver"></td>
	<?php

}
?>
	</tr>
</table>
<br><br><br>
<?php echo $obj->getFooter();?>
