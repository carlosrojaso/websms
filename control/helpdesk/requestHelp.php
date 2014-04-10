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
/********************************HEADER************************************************/
include_once('../../includes/simplepage.class.php');
include_once('../../includes/session.inc');
$obj = new simplepage();
$obj->setTitle("Ingreso usuario - Particular");
$obj->setCSS("../../includes/style/style.css");
echo $obj->getHeader();
$img_dir = "../../images";

require_once('../../data/db.class.php');
$db = new db_class;
if (!$db->connect()){
	$db->print_last_error(false);
}
/********Datos de la solicitud*******************/

if($_SESSION['auth']!=yes){
	$id_client='null';
	$frm_req_cli_nm=trim($_POST['frm_req_cli_nm']);
	$frm_req_mail=trim($_POST['frm_req_mail']);
}else{
	$r = $db->select("SELECT client.id_client as id_client, cli_firstname, cli_lastname, cli_e_mail FROM client,users WHERE user_login='".$_SESSION[nombre_usuario]."' AND users.id_client=client.id_client AND users.user_current_flag=1 AND client.cli_current_flag=1");
	$row=$db->get_row($r, 'MYSQL_ASSOC');
	$id_client=$row['id_client'];
	$frm_req_cli_nm=$row['cli_firstname'].' '.$row['cli_lastname'];
	$frm_req_mail=$row['cli_e_mail'];
}

$frm_req_reason_cd   = trim($_POST['frm_req_reason_cd']);
$frm_req_cmnt = trim($_POST['frm_req_cmnt']);

$r = $db->select('SELECT CURDATE() as hoy');
$row=$db->get_row($r, 'MYSQL_ASSOC');
$fecha_hoy=$row[hoy];
$r = $db->select('SELECT CURTIME() as hoy');
$row=$db->get_row($r, 'MYSQL_ASSOC');
$hora_hoy=$row[hoy];

$r = $db->select('SELECT MAX(id_frm_req) as id_frm_req FROM form_request');
$row=$db->get_row($r, 'MYSQL_ASSOC');
$id_frm_req_new=($row[id_frm_req]+1);

$data = array(
'id_frm_req'=> $id_frm_req_new,
'id_client' => $id_client,
'frm_req_cli_nm' => $frm_req_cli_nm,
'frm_req_mail' => $frm_req_mail,
'frm_req_reason_cd' => $frm_req_reason_cd,
'frm_req_cmnt'=>$frm_req_cmnt,
'frm_req_status_cd' => 'N',
'frm_req_date_in' => $fecha_hoy.' '.$hora_hoy,
);

$user_id1 = $db->insert_array('form_request', $data);

if (!$user_id1){
	$debug1.= "Ocurri&oacute; un error ingresando los datos de la solicitud.<br>".$db->last_error;
	echo '<br>'.$debug1.'<br>';
	return;
}

$r = $db->select('SELECT COUNT(id_client) as id_client FROM users');





?>

<br><br><br>
<table width="596" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td rowspan="3" height="74" width="68"><img src="<?php echo $img_dir;?>/oksendrequest.png"></img></td>
    <td width="528" class="tituloatencioncliente">Tu consulta ha sido envida correctamente </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="contenidoatencioncliente">Gracias por tu solicitud. En breve, un agente de nuestro Centro de Atenci&oacute;n al cliente responder&aacute; a tu consulta enviandote un correo electr&oacute;nico.</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<?php if($_SESSION[auth]=='yes'){?>
		<td><input type="button" class="cssbutton" onclick="location.href='../../ui/core/body.php'" value="Volver"></td>
	<?php }else{?>	
		<td><input type="button" class="cssbutton" onclick="location.href='../../index.php'" value="Volver"></td>
	<?php }?>
	</tr>	
</table>
<br><br><br><br><br><br><br>

<?php
echo $obj->getFooter();
?>
