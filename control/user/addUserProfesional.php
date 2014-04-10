<?php
/**
 * addUserProfesional.php
 * 
 * Control Agregar Usuarios Externos (Profesionales).
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
$obj->setTitle("Ingreso usuario - Profesional");
$obj->setCSS("../../includes/style/style.css");
echo $obj->getHeader();
$img_dir = "../../images";

/********Datos del cliente*******************/

$nombre   = trim($_POST['cli_firstname']);
$apellido = trim($_POST['cli_lastname_1']).' '.trim($_POST['cli_lastname_2']);
$sexo   = trim($_POST['cli_sex_cd']);
$nombre_comp   = trim($_POST['cli_company_nm']);
$tel_1   = trim($_POST['cli_phone_num1']);
$tel_2   = trim($_POST['cli_phone_num2']);
$cell   = trim($_POST['cli_cell_phone']);
$fax   = trim($_POST['cli_fax_num']);
$email   = trim($_POST['cli_e_mail']);
$dir   = trim($_POST['cli_address']);
$codigo_postal   = trim($_POST['cli_postal_cd']);
$poblacion   = trim($_POST['cli_town']);
$cif   = trim($_POST['cli_ident_num']);
$cli_country_cd=trim($_POST['cli_country_cd']);

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
	<form action="../../ui/user/addUserPro.php?lang=SP" method="POST" id="errorData" name"errorData">					
		<br><br><br><br><br>	
		<table align="center">
				<tr>
					<td class="titulo">
						El cliente con el usuario <b>'.$row[user_login].'</b> ya existe por favor seleccione otro usuario.<br><br>
					</td>
				</tr>';

				if($_SESSION[auth]=='yes'){?>
					<tr>
						<td><input type="submit" class="cssbutton" value="Volver"></td>
					</tr>
					<input type="hidden" id="cli_firstnameE"  name="cli_firstnameE" value="<?php echo $nombre;?>">							
					<input type="hidden" id="cli_lastname_1E" name="cli_lastname_1E" value="<?php echo trim($_POST['cli_lastname_1']);?>">				
					<input type="hidden" id="cli_lastname_2E" name="cli_lastname_2E" value="<?php echo trim($_POST['cli_lastname_2']);?>">						
					<input type="hidden" id="cli_sex_cdE" name="cli_sex_cdE" value="<?php echo $sexo;?>">								
					<input type="hidden" id="cli_company_nmE" name="cli_company_nmE" value="<?php echo $nombre_comp;?>">								
					<input type="hidden" id="cli_ident_numE" name="cli_ident_numE" value="<?php echo $id_num;?>">												
					<input type="hidden" id="cli_phone_num1E" name="cli_phone_num1E" value="<?php echo $tel_1;?>">								
					<input type="hidden" id="cli_phone_num2E" name="cli_phone_num2E" value="<?php echo $tel_2;?>">								
					<input type="hidden" id="cli_cell_phoneE" name="cli_cell_phoneE" value="<?php echo $cell;?>">	
					<input type="hidden" id="cli_fax_numE" name="cli_fax_numE" value="<?php echo $fax;?>">	
					<input type="hidden" id="cli_e_mailE" name="cli_e_mailE" value="<?php echo $email;?>">									
					<input type="hidden" id="cli_addressE" name="cli_addressE" value="<?php echo $dir;?>">											
					<input type="hidden" id="cli_postal_cdE" name="cli_postal_cdE" value="<?php echo $codigo_postal;?>">						
					<input type="hidden" id="cli_townE" name="cli_townE" value="<?php echo $poblacion;?>">						
					<input type="hidden" id="cli_ident_numE" name="cli_ident_numE" value="<?php echo $cif;?>">						
					<input type="hidden" id="user_loginE" name="user_loginE" value="<?php echo $login;?>">						
					<input type="hidden" id="user_passE" name="user_passE" value="<?php echo $password;?>">						
					<input type="hidden" id="user_prof_cdE" name="user_prof_cdE" value="<?php echo $user_prof_cd;?>">
					<input type="hidden" id="cli_country_cdE" name="cli_country_cdE" value="<?php echo $cli_country_cd;?>">									
				<?php }?>
			</table>
		</form>				
	<?php	
}else{

	/*Revisar el codigo postal y la ciudad**/
	$_zip_sql='SELECT geo_country_cd,geo_town FROM geography WHERE geo_postal_cd='.$codigo_postal;

	$r = $db->select($_zip_sql);
	$row=$db->get_row($r, 'MYSQL_ASSOC');

	/*Obtener el codigo de region**/
	//$cli_country_cd=$row['geo_country_cd'];

	/*Comparar la ciudad devuelta por la consulta segun el codigo ingresado por el usuario con la
	ingresada en el campo poblcion.**/
	if (strcasecmp($row[geo_town],$poblacion)!=0){
		echo
		'
		<form action="../../ui/user/addUserPro.php?lang=SP" method="POST" id="errorData" name"errorData">				
			<br><br><br><br><br>
			<table align="center">
				<tr>
					<td class="titulo">
						El código postal <b>'.$codigo_postal.'</b> no corresponde a la población <b>'.$poblacion.'</b> por favor ingrese un codigo postal valido.<br>			  			
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
				<input type="hidden" id="cli_company_nmE" name="cli_company_nmE" value="<?php echo $nombre_comp;?>">								
				<input type="hidden" id="cli_ident_numE" name="cli_ident_numE" value="<?php echo $id_num;?>">												
				<input type="hidden" id="cli_phone_num1E" name="cli_phone_num1E" value="<?php echo $tel_1;?>">								
				<input type="hidden" id="cli_phone_num2E" name="cli_phone_num2E" value="<?php echo $tel_2;?>">								
				<input type="hidden" id="cli_cell_phoneE" name="cli_cell_phoneE" value="<?php echo $cell;?>">	
				<input type="hidden" id="cli_fax_numE" name="cli_fax_numE" value="<?php echo $fax;?>">	
				<input type="hidden" id="cli_e_mailE" name="cli_e_mailE" value="<?php echo $email;?>">									
				<input type="hidden" id="cli_addressE" name="cli_addressE" value="<?php echo $dir;?>">											
				<input type="hidden" id="cli_postal_cdE" name="cli_postal_cdE" value="<?php echo $codigo_postal;?>">						
				<input type="hidden" id="cli_townE" name="cli_townE" value="<?php echo $poblacion;?>">						
				<input type="hidden" id="cli_ident_numE" name="cli_ident_numE" value="<?php echo $cif;?>">						
				<input type="hidden" id="user_loginE" name="user_loginE" value="<?php echo $login;?>">						
				<input type="hidden" id="user_passE" name="user_passE" value="<?php echo $password;?>">						
				<input type="hidden" id="user_prof_cdE" name="user_prof_cdE" value="<?php echo $user_prof_cd;?>">
				<input type="hidden" id="$cli_country_cdE" name="$cli_country_cdE" value="<?php echo $cli_country_cd;?>">												
			</table>	
		</form>			
	<?php	
	return;
	}
	/*Revisar si el codigo postal ingresado existe**/
	if($cli_country_cd==''){
		echo
		'
		<form action="../../ui/user/addUserPro.php?lang=SP" method="POST" id="errorData" name"errorData">				
			<br><br><br><br><br>
			<table align="center">
				<tr>
					<td class="titulo">
						El código postal <b>'.$codigo_postal.'</b> no existe por favor ingrese un codigo postal valido.<br>			  			
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
				<input type="hidden" id="cli_company_nmE" name="cli_company_nmE" value="<?php echo $nombre_comp;?>">								
				<input type="hidden" id="cli_ident_numE" name="cli_ident_numE" value="<?php echo $id_num;?>">												
				<input type="hidden" id="cli_phone_num1E" name="cli_phone_num1E" value="<?php echo $tel_1;?>">								
				<input type="hidden" id="cli_phone_num2E" name="cli_phone_num2E" value="<?php echo $tel_2;?>">								
				<input type="hidden" id="cli_cell_phoneE" name="cli_cell_phoneE" value="<?php echo $cell;?>">	
				<input type="hidden" id="cli_fax_numE" name="cli_fax_numE" value="<?php echo $fax;?>">	
				<input type="hidden" id="cli_e_mailE" name="cli_e_mailE" value="<?php echo $email;?>">									
				<input type="hidden" id="cli_addressE" name="cli_addressE" value="<?php echo $dir;?>">											
				<input type="hidden" id="cli_postal_cdE" name="cli_postal_cdE" value="<?php echo $codigo_postal;?>">						
				<input type="hidden" id="cli_townE" name="cli_townE" value="<?php echo $poblacion;?>">						
				<input type="hidden" id="cli_ident_numE" name="cli_ident_numE" value="<?php echo $cif;?>">						
				<input type="hidden" id="user_loginE" name="user_loginE" value="<?php echo $login;?>">						
				<input type="hidden" id="user_passE" name="user_passE" value="<?php echo $password;?>">						
				<input type="hidden" id="user_prof_cdE" name="user_prof_cdE" value="<?php echo $user_prof_cd;?>">	
				<input type="hidden" id="$cli_country_cdE" name="$cli_country_cdE" value="<?php echo $cli_country_cd;?>">								
			</table>	
		</form>			
	<?php		
	return;
	}
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
	
	/*Arreglo de datos que se guardan para un cliente(Externo)**/
	$data = array(
	'id_client'=> $id_client_new,
	'cli_cd' => $cli_country_cd.str_pad($id_client_new,5,'0',STR_PAD_LEFT),	
	'cli_firstname' => $nombre,
	'cli_lastname' => $apellido,
	'cli_sex_cd' => $sexo,
	'cli_company_nm' => $nombre_comp,
	'cli_act_cd' => $user_prof_cd,
	'cli_phone_num1' => $tel_1,
	'cli_phone_num2' => $tel_2,
	'cli_fax_num' => $fax,
	'cli_cell_phone' => $cell,
	'cli_e_mail' => $email,
	'cli_address' => $dir,
	'cli_postal_cd' => $codigo_postal,
	'cli_town' => $poblacion,
	'cli_country_cd' => $cli_country_cd,
	'cli_current_flag' => 1,
	'cli_date_mod' => $fecha_hoy.' '.$hora_hoy,
	'cli_ident_type_cd' => 'VAT',
	'cli_ident_num' => $cif,

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

	/*Arreglo de datos que se guardan en users(Externo)**/
	$data = array(
	'id_user'=> $id_user_new,
	'id_client' => $id_client_new,
	'user_prof_cd' => $user_prof_cd,
	'user_prefer_lang' => $_SESSION[idm],
	'user_login' => $login,
	'user_pass' => $password,
	'user_info_cre' =>isset($_SESSION[nombre_usuario])?$_SESSION[nombre_usuario]:$login,
	'user_info_upd' =>isset($_SESSION[nombre_usuario])?$_SESSION[nombre_usuario]:$login,
	'user_status_cd' => 'A',
	'user_date_req' => $fecha_hoy.' '.$hora_hoy,
	'user_current_flag' => 1,
	'user_date_in' => $fecha_hoy.' '.$hora_hoy,
	'user_date_mod' => $fecha_hoy.' '.$hora_hoy
	);
	
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
		<td class="titulo">
			El proceso de creaci&oacute;n de su cuenta de usuario finaliz&oacute; con &eacute;xito.<br>
			Puede acceder a su cuenta desde ya y empezar a disfrutar de los
			servicios que le ofrece Onspot.<br> Gracias por su confianza.			
		</td>
	</tr>
	<tr>
	<?php if($_SESSION[auth]=='yes'){?>
		<td><input type="button" class="cssbutton" onclick="location.href='../../ui/user/showUsers.php'" value="Volver"></td>
	<?php }else{?>	
		<td><input type="button" class="cssbutton" onclick="location.href='../../index.php'" value="Volver"></td>
	<?php }?>
	</tr>	
</table>
<br><br><br><br><br><br>
<?php
echo $obj->getFooter();
}
?>
