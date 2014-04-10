<?php
/**
 * addUser.php
 * 
 * Control Agregar Usuarios.
 * @author Victor Manuel Vallecilla Mira<vallecilla@gmail.com> 
 * @version 1.0
 * @package user
 * @creacion: 20/05/2007
 * @license: GNU/GPL	
*/
include_once('../../data/db.class.php');
include_once('../../includes/simplepage.class.php');
$obj = new simplepage();
$obj->setTitle("OnSpot.es - Recupere sus datos de acceso al portal");
$obj->setCSS("../../includes/style/style.css");
echo $obj->getHeader();


$db = new db_class;
if (!$db->connect()){
	$db->print_last_error(false);
}
$r = $db->select("SELECT client.id_client as id_client, cli_e_mail, user_login, user_pass FROM client, users WHERE client.id_client=users.id_client AND cli_e_mail='".$_POST[recupera_email]."' AND cli_current_flag=1 AND user_current_flag=1");
$row=$db->get_row($r, 'MYSQL_ASSOC');
//echo $db->last_query;

if($db->row_count==1){
	$r1 = $db->select('SELECT CURDATE() as hoy');
	$row1=$db->get_row($r1, 'MYSQL_ASSOC');
	$fecha_hoy=$row1[hoy];
	
	$r = $db->select('SELECT CURTIME() as hoy');
	$row2=$db->get_row($r, 'MYSQL_ASSOC');
	$hora_hoy=$row2[hoy];
	
	$data = array(	
	'id_client' => $row[id_client],
	'reg_lost_acc_date' =>$fecha_hoy.' '.$hora_hoy
	);
	
	$user_id1 = $db->insert_array('lost_account_registry', $data);

	if (!$user_id1){
		$debug1.= "Ocurri&oacute; un error ingresando los datos de la solicitud.<br>".$db->last_error;
		echo $debug1;
		return;
	}
	
	include("../../includes/email/email.class.php");
		
	$email = new emailNormal();		// Se crea el objeto

	$email-> asunto    	 ("Recuperar Datos de acceso");	  	// Definimos el asunto	
	$email-> para        ($row[cli_e_mail]);						// Agregamos uno más que se nos olvidó....
	//$email->copia_oculta_a ("vallecilla@gmail.com");					// Envia una copia oculta
	$email->responder_a    ("vallecilla@gmail.com");		// A quién se esponderá el mensaje
	$email-> de  		 ("vallecilla@gmail.com", "Admin" );	  	// Remitente
	$email->enHTML(true);// Envía el mensaje en formato HTML	
	$msg='Hemos recibido una solicitud para enviarle su contraseña por correo electrónico.<br>
			<b>Encuentre a continuación su usuario y contraseña para acceder a su área privada en <a href="websms.adminnova.com/onspot">Onspot.es.</a></b>
		  <br>
		  <b>Usuario:</b>'.$row[user_login].'<br>'.
		  '<b>Contraseña:</b>'.$row[user_pass].
		  '<br>' .
		  '¡Gracias por confiar en Onspot!<br>' .
		  'Este correo es informativo, por favor no responda.<br><br>' .
		  '<a href="www.onspot.es">www.onspot.es</a>';
	$email->mensaje($msg);	// Define el cuerpo del mensaje
	$email->enviar();  		// Enviamos el mensaje
	echo '
		<br><br><br>
		<table align="center">
			<tr>
				<td class="titulo">
					Sus datos de acceso han sido enviados a la dirección e-mail que especificó al momento de darse de alta como usuario.					
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>						
				<td><a href="../../index.php">Volver</a></td>
			</tr>
		</table>';		

}else{


	echo '<script type="text/javascript">
			location.href="../../ui/datarecovery/recoveryuserAccessData.php?email='.$_POST[recupera_email].'";						
		  </script>
	';

}
echo '<br><br><br><br>';
echo $obj->getFooter();
?>