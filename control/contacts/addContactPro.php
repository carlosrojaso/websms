<?php
/**
 * addContactPro.php
 * 
 * Control para el ingreso de contactos profesionales.
 * 
 * @author Carlos A. Rojas <carlkant@gmail.com>
 * @version 1.0
 * @package 
 * @creacion: 01/08/2007
 * @license: 	
*/

include_once('../../includes/session.inc');

$nombre   = trim($_POST['cont_firstname']);
//echo $nombre."<br/>";
$apellido = trim($_POST['cont_lastname']);
//echo $apellido."<br/>";
$naci   = trim($_POST['cont_birthdate'])==""?NULL:trim($_POST['cont_birthdate']);
//echo $naci."<br/>";
$tel_1   = trim($_POST['cont_phone']);
//echo $tel_1."<br/>";
$cell   = trim($_POST['cont_cell_phone']);
//echo $cell."<br/>";
$email   = trim($_POST['cont_e_mail']);
//echo $email."<br/>";
$dir   = trim($_POST['cont_address']);
//echo $dir."<br/>";
$codigo_postal   = trim($_POST['cont_postal_cd']);
//echo $codigo_postal."<br/>";
$poblacion   = trim($_POST['cont_town']);
//echo $poblacion."<br/>";
$sexo   = trim($_POST['cont_sex_cd']);
//echo $sexo."<br/>";

if($_POST['info'] =  "on")
{
$info =  1;
}
else{
$info =  0;
}


//echo $info;
	
require_once('../../data/db.class.php');
$db = new db_class;
if (!$db->connect()){
	$db->print_last_error(false);
}
	/*Revisar el codigo postal y la ciudad**/
	$_zip_sql='SELECT geo_country_cd,geo_town FROM geography WHERE geo_postal_cd='.$codigo_postal;

	$r = $db->select($_zip_sql);
	$row=$db->get_row($r, 'MYSQL_ASSOC');

	/*Obtener el codigo de region**/
	$cli_country_cd=$row['geo_country_cd'];

	/*Comparar la ciudad devuelta por la consulta segun el codigo ingresado por el usuario con la
	ingresada en el campo poblcion.**/
	if (strcasecmp($row[geo_town],$poblacion)!=0){
		
			}
	/*Revisar si el codigo postal ingresado existe**/
	if($cli_country_cd==''){
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
	$_id_contact_sql='SELECT MAX(id_contact) as id_contact FROM contact';
	
	$r = $db->select($_id_contact_sql);
	$row=$db->get_row($r, 'MYSQL_ASSOC');
	$id_contact_new=($row[id_contact]+1);
	
	
	/*Arreglo de datos que se guardan para un contacto**/
	$data = array(
	'id_contact'=> $id_contact_new,	
	'id_client' => $_SESSION[cliente_identificacion_sesion],
	'cont_firstname' => $nombre,
	'cont_lastname' => $apellido,
	'cont_address' => $dir,
	'cont_postal_cd'=>$codigo_postal,
	'cont_town' => $poblacion,
	'cont_country_cd' => $cli_country_cd,
	'cont_cell_phone' => $cell,
	'cont_email' => $email,
	'cont_sex_cd' => $sexo,
	'cont_birthdate' => $naci,	
	'cont_prof_info' => $info,
	'cont_current_flag' => 1,
	'cont_date_in' => $fecha_hoy." ".$hora_hoy,
	'cont_date_mod' => $fecha_hoy." ".$hora_hoy
	);
	
	/*Insertar los datos del cliente**/
	$cont_id1 = $db->insert_array('contact', $data);
	
	/*Revisar si el proceso de insercion se llevo a cabo de manera correcta**/
	if (!$cont_id1){
		$debug1.= "Ocurri&oacute; un error ingresando los datos del cliente.<br>".$db->last_error;
		echo '<br>'.$debug1.'<br>';
		exit;
	}
	
?>
<br><br><br><br><br>
<table align="center">
	<tr>
		<td class="titulo">
			Su nuevo contacto ha sido a&ntilde;adido con exito.			
		</td>
	</tr>
	<tr>	
		<td><input type="button" class="cssbutton" onclick="location.href='../../ui/contacts/showContacts.php'" value="Volver"></td>	
	</tr>	
</table>