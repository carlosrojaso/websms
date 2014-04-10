<?php

/**
 * searchUser.php
 * 
 * Busqueda del Usuario
 * @author Carlos A. Rojas <carlkant@gmail.com> 
 * @version 1.0
 * @package user
 * @creacion: 20/05/2007
 * @license: GNU/GPL	
*/
include_once ('../../includes/calendario/calendario.php');
include_once ('../../includes/session.inc');
check_login();

/**Generador de Tooltip*/
// include the JavaScript tooltip generator class
require_once ('../../includes/tooltips/class.tooltips.php');

// instantiate the class
$tt = new tooltips();

/**Fin generador de Tooltip*/
include_once ('../../includes/simplepage.class.php');
include_once ('../../includes/comparedate/DateAdd.class.php');
require_once ('../../data/db.class.php');
$obj = new simplepage();
$obj->setTitle("Editar Cliente");
$obj->setCSS("../../includes/style/style.css");
$obj->setJS("../../includes/calendario/javascripts.js");
$obj->setJS("../../includes/validate/user/validate_editUserInternal.js");

echo $obj->getHeader();
$img_dir = "../../images";

// set some properties for the tooltip
// THIS MUST BE DONE BEFORE CALLING THE init() METHOD!

// tell the tooltips to start fading in only after it have waited for 100 milliseconds
$tt->fadeInDelay = 50;
// tell the tooltips to start fading out only after 3 seconds
// this is to show how more than just one tooltip can be visible on the screen at the same time!
$tt->fadeOutDelay = 200;

$tt->offsetX = 0;

$tt->offsetY = 0;
// see the manual for what other properties can be set!

// notice that we init the tooltips in the <BODY> !
$tt->init();

$lastname1;
$lastname2;
$criterio = ''; // Criterio de Busqueda
$parametro = 1; // Busqueda Normal

/*******
* parametro.
* 1: busqueda
* 2: modificacion
* 3: eliminacion
*/

if ($_GET[par]) {
	$parametro = $_GET[par];
	$usuario = $_GET['usuario'];
}

//echo '$_SESSION[nombre_usuario]'.$_SESSION[nombre_usuario].'<br>';

$db = new db_class;
if (!$db->connect()) {
	$db->print_last_error(false);
}

$_sql = "	SELECT cli_firstname, 
				   cli_lastname, 					
				   cli_sex_cd,
				   cli_ident_type_cd,
				   cli_ident_num,
				   cli_address,
				   cli_birthdate,
				   cli_e_mail,
				   cli_postal_cd,
				   cli_town,
				   users.id_user as id_user,
				   client.id_client as id_client,
				   cli_act_cd,
				   cli_date_mod,				   
				   IFNULL((SELECT CASE cli_date_mod
					WHEN cli_date_mod
					THEN 'CLIENTE'
					END FROM users
					JOIN client ON users.id_client = client.id_client
					WHERE users.user_login = '$usuario'
					AND cli_current_flag =1
					AND user_current_flag =1
					AND cli_date_mod >= user_date_mod),'USUARIO' ) AS LAST_MODIFICATION,
				   cli_country_cd,
				   user_info_upd,
				   user_info_cre,
				   user_date_req,
				   user_date_in, 
				   IFNULL(user_date_out,'Indefinida') user_date_out,
				   user_date_mod, 
				   user_prof_nm, 
				   user_login, 
				   user_pass,						   
				   users.user_status_cd AS user_status_cd				   
			FROM client, users JOIN user_profile ON users.user_prof_cd=user_profile.user_prof_cd
							   JOIN user_status ON users.user_status_cd=user_status.user_status_cd
			WHERE client.id_client=users.id_client 
			AND users.user_login LIKE '%" . $usuario . "%'			
			AND user_status.user_status_lang='SP'
			AND user_profile.user_prof_lang='SP'
			AND client.cli_current_flag=1
			AND users.user_current_flag=1
			AND user_profile.user_prof_group_cd='I'";

//echo 'Consulta:<br> '.$_sql;
$r = $db->select($_sql);
$row = $db->get_row($r, 'MYSQL_ASSOC');

$status = $_GET[status];

if ($db->row_count) {
	switch ($parametro) {
		case 1 : //busqueda normal
			include_once ('../../ui/user/formsEdit/showUserInternalDataForm.php');
			break;
		case 2 : // modificar usuario
			include_once ('../../ui/user/formsEdit/editUserInternalDataForm.php');
			break;
	}
}
// NO SE ENCONTRO
else {
?>
		<br><br><br>
		<table width="450" border="0" align="center" cellpadding="0" cellspacing="0" id="addUser_particular">		  
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td >No se encontraron coincidencias.</td>
			</tr>				
		</table>								
		<br><br><br>
	<?php
}
?>
