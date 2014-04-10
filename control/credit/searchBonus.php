<?php
/**
 * searchBonus.php
 * 
 * Datos del Bono
 * @author Victor Manuel Vallecilla Mira <vallecilla@gmail.com>
 * @version 1.0
 * @package user
 * @creacion: 05/01/2008
 * @license: GNU/GPL	
*/
/********INTERNACIONALIZACION******/
include_once('../../lang/credit/ui/editBonus.php');
include_once('../../lang/credit/ui/errorMessage.php');
/***************************************************/
include_once('../../includes/calendario/calendario.php');
include_once('../../includes/session.inc');
check_login();

include_once('../../includes/simplepage.class.php');
include_once('../../includes/comparedate/DateAdd.class.php');
require_once('../../data/db.class.php');
$obj = new simplepage();
$obj->setTitle("Editar Cliente");
$obj->setCSS("../../includes/style/style.css");
$obj->setJS("../../includes/calendario/javascripts.js");
$obj->setJS("../../includes/validate/credit/validate_editBonus.js");

echo $obj->getHeader();
$img_dir = "../../images";

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
	$credito=$_GET['credito'];
}




$db = new db_class;
if (!$db->connect()) {
	$db->print_last_error(false);
}
//echo 'credito'.$credito.'<br>';
if(trim($credito)<>''){
	$_sql = "	SELECT 	id_credit," .
						"credit_cd," .
						"credit_nm," .
						"credit_dsc,
						credit_num," .
						"credit_price," .
						"credit_begin_date," .
						"IFNULL(credit_end_date,'Indefinida') AS credit_end_date," .
						"credit_cli_act_cd,
						credit_free_flag," .
						"credit_max_cli," .
						"credit_publish_flag," .
						"credit_status_cd,
						credit_cre_user_id," .
						"credit_mod_user_id," .
						"credit_date_in," .
						"credit_date_mod,
						credit_date_out," .
						"credit_cre_user_id" .						
						"
						FROM 
							credit
						WHERE 
							id_credit = ".$credito."							
							";
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
		include_once('../../ui/credit/formsEdit/showBonusDataForm.php');
		break;	
		case 2: // modificar usuario
		include_once('../../ui/credit/formsEdit/editBonusDataForm.php');			
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
