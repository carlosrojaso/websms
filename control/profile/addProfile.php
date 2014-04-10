<?php
/**
 * addUserInternal.php
 * 
 * Control Agregar Usuarios Internos.
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
$obj->setTitle("Ingreso perfil");
$obj->setCSS("../../includes/style/style.css");
echo $obj->getHeader();
$img_dir = "../../images";

/********Datos del cliente*******************/
$nombre_perfil= trim($_GET['user_prof_nm']);
$codigo_perfil=strtoupper(substr($nombre_perfil,0,4));
$idioma_perfil=$_SESSION[idm];

$codigos=explode(',',$_GET[user_prof_group_cd]);
$codigo_grupo_perfil=$codigos[0];
$nombre_grupo_perfil=$codigos[1];

$user_prof_date_in=trim($_GET['user_prof_date_in']);
$user_prof_date_out=trim($_GET['user_prof_date_out']);
/*
echo '<br>'.$nombre_perfil.'<br>';
echo '<br>'.$codigo_perfil.'<br>';
echo '<br>'.$idioma_perfil.'<br>';
echo '<br>'.$codigo_grupo_perfil.'<br>';
echo '<br>'.$nombre_grupo_perfil.'<br>';
echo '<br>'.$user_prof_date_in.'<br>';
echo '<br>'.$user_prof_date_out.'<br>';
*/
require_once('../../data/db.class.php');
$db = new db_class;
if (!$db->connect()){
	$db->print_last_error(false);
}

/*validar el nombre del perfil no repetido**/
$_err_sql="SELECT user_prof_cd,user_prof_lang FROM user_profile WHERE user_prof_cd='$codigo_perfil' AND user_prof_lang='$idioma_perfil'";

$r = $db->select($_err_sql);
$row=$db->get_row($r, 'MYSQL_ASSOC');
if($db->row_count != 0){
	echo
	'
	<form action="../../ui/profile/addProfile.php" method="POST" id="errorData" name"errorData">				
		<br><br><br><br><br>
		<table align="center">
			<tr>
				<td class="titulo">El perfil con el nombre <b>'.$nombre_perfil.'</b> ya existe por favor seleccione otro nombre para el perfil.<br><br></td>
			</tr>';
?>
			<tr>
				<td><input type="submit" class="cssbutton" value="Volver"></td>
			</tr>
				<input type="hidden" id="user_prof_nmE"  name="user_prof_nmE" value="<?php echo $nombre_perfil;?>">							
				<input type="hidden" id="user_prof_group_cdE" name="user_prof_group_cdE" value="<?php echo $codigo_grupo_perfil;?>">								
				<input type="hidden" id="user_prof_date_inE" name="user_prof_date_inE" value="<?php echo $user_prof_date_in;?>">								
				<input type="hidden" id="user_prof_date_outE" name="user_prof_date_outE" value="<?php echo $user_prof_date_out;?>">							
				<?php 
				$codigos_modulos=explode(',',$_GET[modules]);
				$i=0;
				foreach ($codigos_modulos as $codigo_modulo){
					echo '<input type="hidden" id="'.$codigo_modulo.'" name="'.$codigo_modulo.'" value="1">';
					$i+=1;
				}
				?>
		</table>				
	</form>
	<?php	
	return;
}
else{
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

	if($user_prof_date_out==''){
		/*Arreglo de datos que se guardan para un cliente(Interno)**/
		$data = array(
		'user_prof_cd'=> $codigo_perfil,
		'user_prof_lang' => $idioma_perfil,
		'user_prof_nm' => $nombre_perfil,
		'user_prof_group_cd' => $codigo_grupo_perfil,
		'user_prof_group_nm' => $nombre_grupo_perfil,
		'user_prof_status'=>'A',
		'user_prof_current_flag'=>1,
		'user_prof_date_in' => $user_prof_date_in.' '.$hora_hoy,
		'user_prof_cre'=>$_SESSION[nombre_usuario]
		
		);
	}else{
		/*Arreglo de datos que se guardan para un cliente(Interno)**/
		$data = array(
		'user_prof_cd'=> $codigo_perfil,
		'user_prof_lang' => $idioma_perfil,
		'user_prof_nm' => $nombre_perfil,
		'user_prof_group_cd' => $codigo_grupo_perfil,
		'user_prof_group_nm' => $nombre_grupo_perfil,
		'user_prof_status'=>'A',
		'user_prof_current_flag'=>1,
		'user_prof_date_in' => $user_prof_date_in.' '.$hora_hoy,
		'user_prof_date_out' => $user_prof_date_out.' '.$hora_hoy,
		'user_prof_cre'=>$_SESSION[nombre_usuario]
		);
	}

	/*Insertar los datos del perfil**/
	$user_id1 = $db->insert_array('user_profile', $data);

	/*Revisar si el proceso de insercion se llevo a cabo de manera correcta**/
	if (!$user_id1){
		$debug1.= "Ocurri&oacute; un error ingresando los datos del cliente.<br>".$db->last_error;
		echo '<br>'.$debug1.'<br>';
		return;
	}

	/*sacar los codigos de los modulos seleccionados para insertarlos en la tabla rel_prof_mod*/
	$codigos_modulos=explode(',',$_GET[modules]);
	foreach ($codigos_modulos as $codigo_modulo){
		$data1[]=array(
		'user_prof_cd'=>$codigo_perfil,
		'module_cd'=>$codigo_modulo,		
		'prof_mod_curren_flag'=>1
		);
	}
	/*
	foreach ($data1 as $conten){
	echo '<br>'.$conten[user_prof_cd].'--'.$conten[module_cd].'--'.$conten[prof_mod_date_in].'<br>';
	}
	*/
	/*Insertar los datos de la relacion entre el modulo y el perfil**/
	foreach ($data1 as $conten){
		$user_id1 = $db->insert_array('rel_prof_module', $conten);
	}
	/*Revisar si el proceso de insercion se llevo a cabo de manera correcta**/
	if (!$user_id1){
		$debug1.= "Ocurri&oacute; un error ingresando los datos de la relación entre el perfil y los modulos.<br>".$db->last_error;
		echo '<br>'.$debug1.'<br>';
		return;
	}

?>

<br><br><br>
<table align="center">
	<tr>
		<td class="titulo">El perfil <?php echo $nombre_perfil;?> ha sido activado.</td>
	</tr>
	<tr>
		<td><input type="button" class="cssbutton" onclick="location.href='../../ui/core/body.php'" value="Ok"></td>	
	</tr>	
</table>
<br><br><br><br><br><br><br><br><br>

<?php echo $obj->getFooter(); } ?>
