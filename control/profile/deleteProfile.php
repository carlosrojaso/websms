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
include_once('../../includes/simplepage.class.php');
include_once('../../includes/session.inc');
check_login();
$obj = new simplepage();
$obj->setTitle("Edición datos de acceso");
$obj->setCSS("../../includes/style/style.css");
echo $obj->getHeader();
$img_dir = "../../images";

/******Datos del usuario******************/
$user_prof_cd=$_POST[user_prof_cd];
//echo '$user_prof_cd: '.$user_prof_cd;


require_once('../../data/db.class.php');
$db = new db_class;

if (!$db->connect()) {
	$db->print_last_error(false);
}

//Obtener la fecha del sistema del servidor de base de datos.
$r = $db->select('SELECT CURDATE() as hoy');
$row=$db->get_row($r, 'MYSQL_ASSOC');
$fecha_hoy=$row[hoy];
$r = $db->select('SELECT CURTIME() as hoy');
$row=$db->get_row($r, 'MYSQL_ASSOC');
$hora_hoy=$row[hoy];

/******************Actualizar el flag de los registros anteriores****************/
$data_update= array('user_prof_status' => $_POST[status]);
$user_id1 = $db->update_array('user_profile', $data_update,'user_prof_cd="'.$user_prof_cd.'"');
if (!$user_id1){
	$debug1.= "Ocurri&oacute; un error actualizando los datos del perfil.<br>".$db->last_error;
}

if(!$user_id1){
	echo '
		<table align="center">
			<tr>
				<td><h3>
					'.$debug1.'
					</h3>
				</td>
			</tr>			
		</table>';
}else{
	if(!$_POST[from_page]){
		$r = $db->select('SELECT user_prof_nm,user_prof_status FROM user_profile WHERE user_prof_cd="'.$user_prof_cd.'"');
		$row=$db->get_row($r, 'MYSQL_ASSOC');
		//echo $db->last_query;
?>
	<br><br><br>
	<table align="center">
		<tr>
			<td class="titulo">
				El perfil <?php echo $row[user_prof_nm]?> ha sido <?php echo($row[user_prof_status]=='A'?'Activado':'Desactivado');?>			
			</td>
		</tr>
		<tr>
			<td><input type="button" class="cssbutton" onclick="location.href='../../ui/profile/<?php echo $_GET[back_page];?>.php'" value="Ok"></td>
		</tr>	
	</table>
	<br><br><br>	
<?php }
}
echo $obj->getFooter();
?>