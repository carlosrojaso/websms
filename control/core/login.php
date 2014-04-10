<?php
/*
* Created on 20/08/2007
* Created by Carlos A. Rojas, Victor Vallecilla
* Name of File: login.php
*
* Realiza la verificacion del acceso de los usuarios al sistema.
*
* CHANGELOG
* 15/09/2007:
* - Los mensajes se colocaron en el archivo ../../lang/control.core.login.php
*/

include_once('../../includes/session.inc');
require_once('../../data/user.php');
include_once('../../includes/simplepage.class.php');
/*INTERNACIONALIZACION*/
include_once('../../lang/core/control/login.php');
/**/



$obj = new simplepage();
$obj->setTitle($form_title);
$obj->setCSS("../../includes/style/style.css");
echo $obj->getHeader();

$user = new user($_POST[login_user_login]);

if($user -> getID() == -1){ // no se encontro el usuario.
	echo '<script type="text/JavaScript" >location.href="../../ui/core/uiErrorAccess.php"</script>';
}
else // encontrado
{
	if($user -> getPass() == $_POST['login_user_pass'])
	{

		if($user->getStatus()=='A'){
			$_SESSION[auth] = "yes";
			$_SESSION[nombre_usuario]=$user->getLogin();
			$_SESSION[usuario_identificacion_sesion]=$user->getId();
			$_SESSION[cliente_identificacion_sesion]=$user->getClient_id();
			$_SESSION[idm]="SP";

			//Registrar el acceso en el archivo de logs
			$time = date("M j G:i:s Y");
			$ip = getenv('REMOTE_ADDR');
			$userAgent = getenv('HTTP_USER_AGENT');
			$referrer = getenv('HTTP_REFERER');
			$query = getenv('QUERY_STRING');
			$msg = "IP: " . $ip . " TIME: " . $time . " REFERRER: " . $referrer . " SEARCHSTRING: " . $query . " USERAGENT: " . $userAgent."\n";
			writeLog('log_ini.txt',$msg);						
			echo '<script type="text/JavaScript" >location.href="../../ui/core/home.php"</script>';
		}elseif ($user->getStatus()=='D'){
			echo '
				<br><br><br>
				<table align="center">
					<tr>
						<td class="titulo">'.$msg1.'
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>						
						<td><a href="../../index.php" class="forget">Volver</a></td>
					</tr>
				</table>';			
		}elseif ($user->getStatus()=='C'){
			require_once("../../data/db.class.php");
			$db = new db_class;
			if (!$db->connect()) {
				$db->print_last_error(false);
			}

			$_sql="SELECT user_date_out from users WHERE user_login='".$user->getLogin()."' AND user_current_flag=1";
			//echo $_sql;	
			$r = $db->select($_sql);
			$row=$db->get_row($r, 'MYSQL_ASSOC');
			echo '
			<br><br><br>
				<table align="center">
					<tr>
						<td class="titulo">
							'.$msg2_1.$row[user_date_out].$msg2_2.'										
						</td>
					</tr>
					<tr>
						<td><a href="../../index.php" class="forget">Volver</a></td>
					</tr>
				</table>';			
		}

	}
	else{
		echo '<script type="text/JavaScript" >location.href="../../ui/core/uiErrorAccess.php"</script>';
	}
}
echo '<br><br><br><br>';
echo $obj->getFooter();

function writeLog($logfile,$logMessage){
	$dir = 'logs';
	$saveLocation=$dir . '/' . $logfile;

	if(!is_dir($dir))
	{
		mkdir($dir,"0755");
	}

	if (!$handle = fopen($saveLocation, "a"))
	{
		echo "No se puede abrir el archivo ($logfile)";
		exit;
	}
	else
	{
		if(fwrite($handle,$logMessage.'\r\n')===FALSE)
		{
			echo "No se puede escribir en el archivo ($logfile)";
			exit;
		}

		fclose($handle);
	}
}
?>
