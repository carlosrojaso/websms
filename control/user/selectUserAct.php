<?php
/**
 * addUser.php
 * 
 * Determinar que tipo de formulario mostrar según la actividad
 * @author Victor Manuel Vallecilla Mira<vallecilla@gmail.com> 
 * @version 1.0
 * @package user
 * @creacion: 20/05/2007
 * @license: GNU/GPL	
*/
require_once('../../data/db.class.php');
include_once('../../includes/session.inc');
include_once('../../includes/simplepage.class.php');
$obj = new simplepage();
$obj->setTitle("Seleccion actividad");
$obj->setCSS("../../include/style.css");
echo $obj->getHeader();
$db = new db_class;
if (!$db->connect()) 
   $db->print_last_error(false);
$r = $db->select("SELECT cli_act_grp_nm,cli_act_grp_cd FROM client_activity WHERE cli_act_lang='SP' AND cli_act_cd='".$_POST['cli_act_nm']."'");
$row=$db->get_row($r, 'MYSQL_ASSOC');

if(trim($row[cli_act_grp_nm])=='Profesional'){		
	echo '<form method="post" id="user_profile" name="user_profile" action="../../ui/user/addUserPro.php?lang='.$_POST[lang].'" >
			<input id="profile_cd" name="profile_cd" type="hidden" value="'.$_POST['cli_act_nm'].'">				
		</form>';	
	echo '<script language="javascript">document.user_profile.submit();</script>';
		
}else{		
	echo '<form method="post" id="user_profile" name="user_profile" action="../../ui/user/addUserPar.php?lang='.$_POST[lang].'" >
			<input id="profile_cd" name="profile_cd" type="hidden" value="'.$_POST['cli_act_nm'].'">				
		</form>';	
	echo '<script language="javascript">document.user_profile.submit();</script>';
}
echo $obj->getFooter();
?>