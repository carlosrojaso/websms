<?php


/**
 * addUserInternal.php
 * 
 * Control Agregar Usuarios Internos.
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
$obj->setTitle("Ingreso perfil");
$obj->setCSS("../../includes/style/style.css");
echo $obj->getHeader();
$img_dir = "../../images";

/********Datos del cliente*******************/
$nombre_perfil = trim($_GET['user_prof_nm']);
$codigo_perfil = trim($_GET['user_prof_cd']);
$user_prof_cre = trim($_GET['user_prof_cre']);
$user_prof_status = trim($_GET['user_prof_status']);

$idioma_perfil = $_SESSION[idm];
$codigos = explode(',', $_GET[user_prof_group_cd]);
$codigo_grupo_perfil = $codigos[0];
$nombre_grupo_perfil = $codigos[1];

$user_prof_date_in = trim($_GET['user_prof_date_in']);
$user_prof_date_out = trim($_GET['user_prof_date_out']);
/*
echo '<br>'.$nombre_perfil.'<br>';
echo '<br>'.$codigo_perfil.'<br>';
echo '<br>'.$idioma_perfil.'<br>';
echo '<br>'.$codigo_grupo_perfil.'<br>';
echo '<br>'.$nombre_grupo_perfil.'<br>';
echo '<br>'.$user_prof_date_in.'<br>';
echo '<br>'.$user_prof_date_out.'<br>';
echo '<br>'.$_SESSION[nombre_usuario].'<br>';
*/
require_once ('../../data/db.class.php');
$db = new db_class;
if (!$db->connect()) {
	$db->print_last_error(false);
}


/*Obtener la fecha del servidor**/
$_date_sql = 'SELECT CURDATE() as hoy';

$r = $db->select($_date_sql);
$row = $db->get_row($r, 'MYSQL_ASSOC');
$fecha_hoy = $row[hoy];

/*Obtener la hora del servidor**/
$_time_sql = 'SELECT CURTIME() as hoy';

$r = $db->select($_time_sql);
$row = $db->get_row($r, 'MYSQL_ASSOC');
$hora_hoy = $row[hoy];
/******************Actualizar el flag de los registros anteriores****************/
$data_update = array (
	'user_prof_current_flag' => 0
);
$user_id1 = $db->update_array('user_profile', $data_update, 'user_prof_cd="' . $codigo_perfil . '"');
if (!$user_id1) {
	$debug1 .= "Ocurri&oacute; un error actualizando los datos del perfil.<br>" . $db->last_error;	
}

if (!$user_id1) {
	echo '
					<table align="center">
						<tr>
							<td><h3>
								' . $debug1 . '
								</h3>
							</td>
						</tr>			
					</table>';
} else {	
	
	if ($user_prof_date_out == '') {
		/*Arreglo de datos que se guardan para un cliente(Interno)**/
		$data = array (
			'user_prof_cd' => $codigo_perfil,
			'user_prof_lang' => $idioma_perfil,
			'user_prof_nm' => $nombre_perfil,
			'user_prof_group_cd' => $codigo_grupo_perfil,
			'user_prof_group_nm' => $nombre_grupo_perfil,
			'user_prof_date_in' => $user_prof_date_in,
			'user_prof_date_mod' => $fecha. ' ' . $hora_hoy,
			'user_prof_current_flag' => 1,
			'user_prof_status'=>$user_prof_status,
			'user_prof_cre' => $user_prof_cre,
			'user_prof_upd' => $_SESSION[nombre_usuario]
		);
	} else {
		/*Arreglo de datos que se guardan para un cliente(Interno)**/
		$data = array (
			'user_prof_cd' => $codigo_perfil,
			'user_prof_lang' => $idioma_perfil,
			'user_prof_nm' => $nombre_perfil,
			'user_prof_group_cd' => $codigo_grupo_perfil,
			'user_prof_group_nm' => $nombre_grupo_perfil,
			'user_prof_date_in' => $user_prof_date_in,
			'user_prof_date_out' => $user_prof_date_out . ' ' . $hora_hoy,
			'user_prof_date_mod' => $fecha. ' ' . $hora_hoy,
			'user_prof_current_flag' => 1,
			'user_prof_status'=>$user_prof_status,
			'user_prof_cre' => $user_prof_cre,
			'user_prof_upd' => $_SESSION[nombre_usuario]
		);
	}

	/*Insertar los datos del perfil**/
	$user_id1 = $db->insert_array('user_profile', $data);

	/*Revisar si el proceso de insercion se llevo a cabo de manera correcta**/
	if (!$user_id1) {
		$debug1 .= "Ocurri&oacute; un error modificando los datos del perfil.<br>" . $db->last_error;
		echo '<br>' . $debug1 . '<br>';
		return;
	}
	/*****Actualizar el flag para los registros anteriores******/
	$codigos_modulos = explode(',', $_GET[modules]);
	foreach ($codigos_modulos as $codigo_modulo) {
		$update_data1[] = array (
			'prof_mod_current_flag' => 0
		);
	}
	foreach ($update_data1 as $conten) {
		$user_id2 = $db->update_array('rel_prof_module', $conten, 'user_prof_cd="' . $codigo_perfil . '"');
	}
	if (!$user_id2) {
		$debug1 .= "Ocurri&oacute; un error actualizando los datos del perfil.<br>" . $db->last_error;
	}

	if (!$user_id2) {
		echo '
					<table align="center">
						<tr>
							<td><h3>
								' . $debug1 . '
								</h3>
							</td>
						</tr>			
					</table>';
	} else {
		
		/*sacar los codigos de los modulos seleccionados para insertarlos en la tabla rel_prof_mod*/
		$codigos_modulos = explode(',', $_GET[modules]);
		foreach ($codigos_modulos as $codigo_modulo) {
			$data1[] = array (
				'user_prof_cd' => $codigo_perfil,
				'module_cd' => $codigo_modulo,
				'prof_mod_current_flag' => 1,				
				'prof_mod_date_mod' => $fecha_hoy . ' ' . $hora_hoy
			);
		}
		/*
		foreach ($data1 as $conten){
		echo '<br>'.$conten[user_prof_cd].'--'.$conten[module_cd].'--'.$conten[prof_mod_date_in].'<br>';
		}
		*/
		/*Insertar los datos de la relacion entre el modulo y el perfil**/
		foreach ($data1 as $conten) {
			$user_id1 = $db->insert_array('rel_prof_module', $conten);
		}
		/*Revisar si el proceso de insercion se llevo a cabo de manera correcta**/
		if (!$user_id1) {
			$debug1 .= "Ocurri&oacute; un error ingresando los datos de la relación entre el perfil y los modulos.<br>" . $db->last_error;
			echo '<br>' . $debug1 . '<br>';
			return;
		}
	}
}
?>

<br><br><br>
<table align="center">
	<tr>
		<td class="titulo">El perfil <?php echo $nombre_perfil;?> ha sido modificado exitosamente.</td>
	</tr>
	<tr>
		<td><input type="button" class="cssbutton" onclick="location.href='../../ui/core/body.php'" value="Ok"></td>	
	</tr>	
</table>
<br><br><br><br><br><br><br><br><br>

<?php


echo $obj->getFooter();
?>


