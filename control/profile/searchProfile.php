<?php
/**
 * searchUser.php
 * 
 * Datos del Perfil
 * @author Carlos A. Rojas <carlkant@gmail.com> 
 * @version 1.0
 * @package user
 * @creacion: 20/05/2007
 * @license: GNU/GPL	
*/
include_once('../../includes/calendario/calendario.php');
include_once('../../includes/session.inc');
check_login();
include_once ('../../includes/tree/tree_structure.inc.php');
include_once ('../../includes/calendario/calendario.php');
include_once('../../includes/comparedate/DateAdd.class.php');
include_once('../../includes/simplepage.class.php');
require_once('../../data/db.class.php');
$obj = new simplepage();
$obj->setTitle("Editar Cliente");
$obj->setCSS("../../includes/style/style.css");
$obj->setJS("../../includes/calendario/javascripts.js");
$obj->setJS("../../includes/validate/profile/validate_editProfile.js");

echo $obj->getHeader();
$img_dir = "../../images";

/*******
* parametro.
* 1: busqueda
* 2: modificacion
*/


if($_GET[par])
{
	$parametro = $_GET[par];
	$perfil=$_GET['perfil'];
}




$db = new db_class;
if (!$db->connect()) {
	$db->print_last_error(false);
}

if(trim($perfil)<>''){
	$_sql1 = "	SELECT 
					user_prof_date_in AS fecha_cre,
					user_prof_cre AS creado_por,
					user_prof_date_in AS inicio_val,
					IFNULL(user_prof_date_out,'Indefinida') AS fin_val,
					user_prof_date_mod AS ult_mod,
					user_prof_upd AS modif_por,
					user_prof_cd,
					user_prof_nm,
					user_prof_group_cd,
					user_prof_status														
				FROM 
					user_profile
				WHERE user_prof_cd='".$perfil."' AND
				user_prof_current_flag=1
				AND user_prof_lang='SP'";
}


//echo 'Consulta:<br> '.$_sql1;
$r = $db->select($_sql1);
$row=$db->get_row($r, 'MYSQL_ASSOC');

$filas=$db -> row_count;

if(trim($perfil)<>''){
	$_sql2 = "	SELECT 
					CONCAT(cli_firstname,' ',cli_lastname) AS nombre,					
					user_login 
				FROM 
					users 
						JOIN user_profile ON users.user_prof_cd=user_profile.user_prof_cd 
						JOIN client ON users.id_client=client.id_client
				WHERE 
					user_profile.user_prof_cd='".$perfil."'
					AND cli_current_flag=1
					AND user_current_flag=1
				GROUP BY user_login";
}


//echo 'Consulta:<br> '.$_sql2;
$r1 = $db->select($_sql2);



$status=$_GET[status];

if($filas)
{
	switch($parametro)
	{
		case 1: //busqueda normal
		include_once('../../ui/profile/formsEdit/showProfileDataForm.php');
		break;
		case 2: // modificar usuario
		include_once('../../ui/profile/formsEdit/editProfileDataForm.php');			
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
	<?php
}
echo $obj->getFooter();
?>
