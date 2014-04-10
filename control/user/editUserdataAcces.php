<?php

/**
 * editUserdataAcces.php
 * 
 * Control Agregar Usuarios.
 * @author Victor Manuel Vallecilla Mira<vallecilla@gmail.com> 
 * @version 1.0
 * @package user
 * @creacion: 20/05/2007
 * @license: GNU/GPL	
*/
/********************************HEADER************************************************/
include_once ('../../includes/simplepage.class.php');
include_once ('../../includes/session.inc');
$obj = new simplepage();
$obj->setTitle("Edición datos de acceso");
$obj->setCSS("../../includes/style/style.css");
echo $obj->getHeader();
$img_dir = "../../images";

require_once ('../../data/db.class.php');
$db = new db_class;

if (!$db->connect()) {
	$db->print_last_error(false);
}

$r = $db->select("SELECT cli_firstname,cli_lastname,user_login,users.id_client as id_client FROM users, client WHERE user_login='" . trim($_POST['user_login']) . "' AND users.id_client=client.id_client");
$row = $db->get_row($r, 'MYSQL_ASSOC');
if (!isset ($_POST[cli_phone_num1])) {
	if ($db->row_count > 0) {
		if ($row[id_client] != $id_client) {
?>			
	<form action="<?php echo $_GET[from_page].'?par='.$_GET[par].'&usuario='.$_GET[usuario];?>" method="POST" id="errorData" name"errorData">								
		<br><br><br><br><br>
		<table align="center">
			<tr>
				<td class="titulo">El usuario <b><?php echo $row[user_login];?></b> ya existe por favor seleccione otro usuario.<br><br></td>
			</tr>
			<tr>					
				<td><input type="submit" class="cssbutton" value="Volver"></td>					
			</tr>									
			<input type="hidden" id="user_loginE" name="user_loginE" value="<?php echo $login;?>">									
			<input type="hidden" id="user_passE" name="user_passE" value="<?php echo $password;?>">																	
		</table>
	</form>				
<?php

		}
	}
}
if ($_POST[user_prof_group_cd] == 'E') {
	if (isset ($_POST[cli_birthdate])) {
		include_once ('../../control/user/editUserParticular.php');
	} else {
		include_once ('../../control/user/editUserProfesional.php');
	}
}else{
	include_once ('../../control/user/editUserInternal.php');
}
?>

