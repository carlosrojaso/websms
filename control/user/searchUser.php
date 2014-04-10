<?php
/**
 * searchUser.php
 * 
 * Datos del Usuario
 * @author Carlos A. Rojas <carlkant@gmail.com> 
 * @version 1.0
 * @package user
 * @creacion: 20/05/2007
 * @license: GNU/GPL	
*/
include_once('../../includes/calendario/calendario.php');
include_once('../../includes/session.inc');
check_login();

/**Generador de Tooltip*/
// include the JavaScript tooltip generator class
require_once('../../includes/tooltips/class.tooltips.php');

// instantiate the class
$tt = new tooltips();

/**Fin generador de Tooltip*/

include_once('../../includes/simplepage.class.php');
require_once('../../data/db.class.php');
$obj = new simplepage();
$obj->setTitle("Editar Cliente");
$obj->setCSS("../../includes/style/style.css");
$obj->setJS("../../includes/calendario/javascripts.js");
$obj->setJS("../../includes/validate/user/validate_editUserPro.js");
$obj->setJS("../../includes/validate/user/validate_editUserPar.js");

echo $obj->getHeader();
$img_dir = "../../images";


// set some properties for the tooltip
// THIS MUST BE DONE BEFORE CALLING THE init() METHOD!

// tell the tooltips to start fading in only after it have waited for 100 milliseconds
$tt->fadeInDelay = 50;
// tell the tooltips to start fading out only after 3 seconds
// this is to show how more than just one tooltip can be visible on the screen at the same time!
$tt->fadeOutDelay = 200;

$tt->offsetX=0;

$tt->offsetY=0;
// see the manual for what other properties can be set!

// notice that we init the tooltips in the <BODY> !
$tt->init();

$lastname1;
$lastname2;
$criterio =''; // Criterio de Busqueda
$parametro = 1; // Busqueda Normal

/*******
* parametro.
* 1: busqueda
* 2: modificacion
*/


if($_GET[par])
{
	$parametro = $_GET[par];
	$usuario=$_GET['usuario'];
}




$db = new db_class;
if (!$db->connect()) {
	$db->print_last_error(false);
}
//echo 'usuario'.$usuario.'<br>';
if(trim($usuario)<>''){
	$_sql = "	SELECT 	client.id_client as 'id_client'," .
						"cli_cd," .
						"cli_firstname," .
						"cli_lastname,
						cli_town," .
						"cli_sex_cd," .
						"cli_birthdate," .
						"cli_company_nm," .
						"cli_ident_type_cd,
						cli_ident_num," .
						"cli_act_cd," .
						"cli_phone_num1," .
						"cli_phone_num2,
						cli_fax_num," .
						"cli_cell_phone," .
						"cli_e_mail," .
						"cli_address,
						cli_postal_cd," .
						"cli_date_mod," .
						"cli_country_cd," .
 						"IFNULL((SELECT CASE cli_date_mod
						WHEN cli_date_mod
						THEN 'CLIENTE'
						END FROM users
						JOIN client ON users.id_client = client.id_client
						WHERE users.user_login = '$usuario'
						AND cli_current_flag =1
						AND user_current_flag =1
						AND cli_date_mod >= user_date_mod),'USUARIO' ) AS LAST_MODIFICATION, ".
						"user_login," .
						"user_pass," .
						"id_user," .						
						"user_date_in," .					
						"user_info_upd," .
				   		"user_info_cre," .
						"user_date_mod," .
				   		"user_date_req" .				   		
				   		"
						FROM 
							users, client
						WHERE 
							user_login LIKE '%".$usuario."%'
							AND users.id_client=client.id_client
							AND client.cli_current_flag=1
							AND users.user_current_flag=1";
}


//echo 'Consulta:<br> '.$_sql;
$r = $db->select($_sql);
$row=$db->get_row($r, 'MYSQL_ASSOC');

$status=$_GET[status];

if($db -> row_count)
{
	switch($parametro)
	{
		case 1: //busqueda normal
		include_once('../../ui/user/formsEdit/showUserDataForm.php');
		break;
		case 2: // modificar usuario
		include_once('../../ui/user/formsEdit/editUserDataForm.php');			
		break;
	}
}
// NO SE ENCONTRO
else{?>
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
<?php }?>
