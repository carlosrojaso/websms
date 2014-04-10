<?php
/*
 * Created on 08/10/2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

include_once('../../includes/session.inc');
//check_login();
require_once('../../data/db.class.php');
$db = new db_class;
if (!$db->connect()){
	$db->print_last_error(false);
}



$usuario = $_SESSION[usuario_identificacion_sesion];

$_sql = "SELECT client.cli_act_cd as activity FROM client, users WHERE users.id_client= client.id_client AND users.user_current_flag = 1 AND client.id_client = $usuario AND client.cli_current_flag = 1 ";


$r = $db->select($_sql);
$row=$db->get_row($r, 'MYSQL_ASSOC');



		if($row[activity] == 'PAR')
		{
			echo '<script type="text/JavaScript" >location.href="../../ui/contacts/addContactPar.php"</script>';
			exit;
		}
		else
		{
			echo '<script type="text/JavaScript" >location.href="../../ui/contacts/addContactPro.php"</script>';
			exit;
		}
		
		
		

?>
