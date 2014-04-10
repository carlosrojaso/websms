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
include_once('../../includes/simplepage.class.php');
include_once('../../includes/session.inc');
$obj = new simplepage();
$obj->setTitle("Ingreso usuario - Interno");
$obj->setCSS("../../includes/style/style.css");
echo $obj->getHeader();
$img_dir = "../../images";

/********Datos del cliente*******************/
$nombre   = trim($_POST['cli_firstname']);
$apellido = trim($_POST['cli_lastname_1']).' '.trim($_POST['cli_lastname_2']);
$email   = trim($_POST['cli_e_mail']);
$cli_country_cd=trim($_POST['cli_country_cd']);
$user_date_in=trim($_POST['user_date_in']);
$user_date_out=trim($_POST['user_date_out']);

/******Datos del usuario******************/
$login   = trim($_POST['user_login']);
$password   = trim($_POST['user_pass']);
$user_prof_cd= trim($_POST['user_prof_cd']);


require_once('../../data/db.class.php');
$db = new db_class;
if (!$db->connect()){
	$db->print_last_error(false);
}

/*validar login no repetido**/
$_err_sql="SELECT user_login FROM users WHERE user_login='$login'";

$r = $db->select($_err_sql);
$row=$db->get_row($r, 'MYSQL_ASSOC');
if($db->row_count != 0){
	echo
	'
	<form action="../../ui/user/addUserInternal.php" method="POST" id="errorData" name"errorData">				
		<br><br><br><br><br>
		<table align="center">
			<tr>
				<td class="titulo">El usuario con el login <b>'.$row[user_login].'</b> ya existe por favor seleccione otro usuario.<br><br></td>
			</tr>';
?>
			<tr>
				<td><input type="submit" class="cssbutton" value="Volver"></td>
			</tr>
				<input type="hidden" id="cli_firstnameE"  name="cli_firstnameE" value="<?php echo $nombre;?>">							
				<input type="hidden" id="cli_lastname_1E" name="cli_lastname_1E" value="<?php echo trim($_POST['cli_lastname_1']);?>">				
				<input type="hidden" id="cli_lastname_2E" name="cli_lastname_2E" value="<?php echo trim($_POST['cli_lastname_2']);?>">						
				<input type="hidden" id="cli_e_mailE" name="cli_e_mailE" value="<?php echo $email;?>">	
				<input type="hidden" id="cli_country_cdE" name="cli_country_cdE" value="<?php echo $cli_country_cd;?>">							
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
else{
	/*Obtener la fecha del servidor**/
	$_date_sql='SELECT CURDATE() as hoy';

	$r = $db->select($_date_sql);
	$row=$db->get_row($r, 'MYSQL_ASSOC');
	$fecha_hoy=$row[hoy];

	/*Obtener la hora del servidor**/
	$_time_sql='SELECT CURTIME() as hoy';

	$r = $db->select($_time_sql);
	$row=$db->get_row($r, 'MYSQL_ASSOC');
	$hora_hoy=$row[hoy];

	/*Obtener un id para el cliente (se cuentan el numero de filas y se inserta el siguiente)**/
	$_id_client_sql='SELECT MAX(id_client) as id_client FROM client';

	$r = $db->select($_id_client_sql);
	$row=$db->get_row($r, 'MYSQL_ASSOC');
	$id_client_new=($row[id_client]+1);		
	    
	/*Arreglo de datos que se guardan para un cliente(Interno)**/
	$data = array(
	'id_client'=> $id_client_new,	
	'cli_cd' => $cli_country_cd.str_pad($id_client_new,5,'0',STR_PAD_LEFT),
	'cli_firstname' => $nombre,
	'cli_lastname' => $apellido,
	'cli_e_mail' => $email,
	'cli_country_cd' => $cli_country_cd,
	'cli_current_flag' => 1,
	'cli_date_mod' =>$fecha_hoy.' '.$hora_hoy

	);

	/*Insertar los datos del cliente**/
	$user_id1 = $db->insert_array('client', $data);

	/*Revisar si el proceso de insercion se llevo a cabo de manera correcta**/
	if (!$user_id1){
		$debug1.= "Ocurri&oacute; un error ingresando los datos del cliente.<br>".$db->last_error;
		echo '<br>'.$debug1.'<br>';
		return;
	}

	/*Obtener un id para el usuario (se cuentan el numero de filas y se inserta el siguiente)**/
	$_id_user_sql='SELECT MAX(id_user) as id_user FROM users';

	$r = $db->select($_id_user_sql);
	$row=$db->get_row($r, 'MYSQL_ASSOC');
	$id_user_new=($row[id_user]+1);

	/**Segun sea el caso se ingresan la fecha de entrada, salida y modificacion.*/
	if($user_date_out){
		//echo 'se ingresa date out '.$user_date_out;
		$data = array(
		'id_user'=> $id_user_new,
		'id_client' => $id_client_new,
		'user_prof_cd' => $user_prof_cd,
		'user_prefer_lang' => $_SESSION[idm],
		'user_login' => $login,		
		'user_pass' => $password,
		'user_info_cre' =>$_SESSION[nombre_usuario],
		'user_info_upd' =>$_SESSION[nombre_usuario],
		'user_status_cd' => 'A',
		'user_date_req' => $fecha_hoy.' '.$hora_hoy,
		'user_current_flag' => 1,
		'user_date_in' => $user_date_in.' '.$hora_hoy,
		'user_date_out' =>$user_date_out.' '.$hora_hoy,
		'user_date_mod' =>$fecha_hoy.' '.$hora_hoy
		);
	}else{
		//echo 'NO se ingresa date out';
		$data = array(
		'id_user'=> $id_user_new,
		'id_client' => $id_client_new,
		'user_prof_cd' => $user_prof_cd,
		'user_prefer_lang' => $_SESSION[idm],
		'user_login' => $login,
		'user_pass' => $password,
		'user_info_cre' =>$_SESSION[nombre_usuario],
		'user_info_upd' =>$_SESSION[nombre_usuario],
		'user_status_cd' => 'A',
		'user_date_req' => $fecha_hoy.' '.$hora_hoy,
		'user_current_flag' => 1,
		'user_date_in' => $user_date_in.' '.$hora_hoy,
		'user_date_mod' =>$fecha_hoy.' '.$hora_hoy
		);
	}

	/*Insertar los datos del usuario**/
	$user_id2 = $db->insert_array('users', $data);

	/*Revisar si el proceso de insercion se llevo a cabo de manera correcta**/
	if (!$user_id2){
		$debug2.= "Ocurri&oacute; un error ingresando los datos del usuario.<br>".$db->last_error;
		echo '<br>'.$debug2.'<br>';
		return;
	}


?>

<br><br><br>
<table align="center">
	<tr>
		<td class="titulo">El usuario <?php echo $login;?> ha sido activado.</td>
	</tr>
	<tr>
		<td><input type="button" class="cssbutton" onclick="location.href='../../ui/user/showUsersInternals.php'" value="Volver"></td>	
	</tr>	
</table>
<br><br><br><br><br><br><br><br><br>

<?php echo $obj->getFooter(); } ?>
