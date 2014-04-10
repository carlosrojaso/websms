<?php
/**
 * addUserInternal.php
 * 
 * Interfaz Ingresar Usuario Interno
 * @author Victor Manuel Vallecilla Mira<vallecilla@gmail.com> 
 * 		   Carlos A. Rojas<carlkant@gmail.com> 
 * @version 1.0
 * @package ui
 * @creacion: 22/09/2007
 * @license: GNU/GPL	
*/
/*****************Includes******************/
//Sesion
include_once('../../includes/session.inc');
//Internacionalizacion
include_once('../../lang/user/ui/addUserInternal.php');
include_once('../../lang/user/ui/addUserInternal_errorMessage.php');
//Calendario
include_once('../../includes/calendario/calendario.php');
//Pagina HTML
include_once('../../includes/simplepage.class.php');
/******************Require********************/
//Tooltips
require_once('../../includes/tooltips/class.tooltips.php');
//Base de datos
require_once('../../data/db.class.php');
/*********************************************/

check_login();

$_sql3 = "SELECT user_prof_cd,user_prof_nm FROM  user_profile WHERE user_prof_lang='".$_SESSION[idm]."' AND user_prof_group_cd='I' AND user_prof_current_flag=1";
$_sql4="SELECT geo_country_cd,geo_country FROM geography GROUP BY geo_country,geo_country_cd";

$obj = new simplepage();

$obj->setCSS("../../includes/style/style.css");
$obj->setJS("../../includes/calendario/javascripts.js");
$obj->setJS("../../includes/validate/user/validate_addUserInternal.js");
$img_dir = "../../images";

$db = new db_class();
if (!$db->connect()){
	$db->print_last_error(false);
}
echo $obj->getHeader();

$tt = new tooltips();
$tt->fadeInDelay = 50;
$tt->fadeOutDelay = 200;
$tt->offsetX=0;
$tt->offsetY=0;
$tt->init();

?>
<br><br>
<form name='forma' id='forma' method='post' action='../../control/user/addUserInternal.php' >
	<table width="50%" border="0" align="center" cellpadding="0" cellspacing="1" id="addUserInternal">	  			
	  <tr>
		<td colspan="2" class="subtitulo"><?php echo $title1;?></td>
	  </tr>
	   <tr>
	  	<td nowrap id="title_cli_firstname_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $nombre;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_cli_firstname_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg1;?>&nbsp;<div id="required_cli_firstname" style="display:none;">*</div></td>
		<td id="input_cli_firstname_underline"><input name="cli_firstname" type="text" id="cli_firstname" size="20" value="<?php if(isset($_POST[cli_firstnameE])){echo $_POST[cli_firstnameE];}?>"></td>
	  </tr>
	  <tr>
	  	<td nowrap id="title_cli_lastname_1_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $apellido;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_cli_lastname_1_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg2;?>&nbsp;<div id="required_cli_lastname_1" style="display:none;">*</div></td>
		<td id="input_cli_lastname_1_underline"><input name="cli_lastname_1" type="text" id="cli_lastname_1" size="20" value="<?php if(isset($_POST[cli_lastname_1E])){echo $_POST[cli_lastname_1E];}?>"></td>
	  </tr>
	  <tr>
		<td class="label"> <?php echo $msg3;?></td>
		<td><input class='empty' name="cli_lastname_2" type="text" id="cli_lastname_2" size="20" value="<?php if(isset($_POST[cli_lastname_2E])){echo $_POST[cli_lastname_2E];}?>"></td>
	  </tr>			  		
	 <tr>
	  	<td nowrap id="title_cli_e_mail_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $email;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_cli_e_mail_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg4;?>&nbsp;<div id="required_cli_e_mail" style="display:none;">*</div></td>
		<td id="input_cli_e_mail_underline">
			<input name="cli_e_mail" type="text" id="cli_e_mail" size="20" value="<?php if(isset($_POST[cli_e_mailE])){echo $_POST[cli_e_mailE];}?>">										
			<img name="help" src="<?php echo $img_dir;?>/help.png"  onmousemove="<?=$tt->show("<b>Por que necesitamos su Email?</b><br><br>Necesitamos su email para contactarlo.")?>">
		</td>	
	  </tr>
	  <tr>
	  	<td nowrap id="title_cli_country_cd_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;Por favor seleccione el pais</td>			  	
	  </tr>
	  <tr>
		<td id="label_cli_country_cd_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg5;?>&nbsp;<div id="required_cli_country_cd" style="display:none;">*</div></td>
		<td id="input_cli_country_cd_underline">
			<select name="cli_country_cd" id="cli_country_cd" >
			<option value ="-1"> </option>'		
			<?php
			$r = $db->select($_sql4);
			while ($row=$db->get_row($r, 'MYSQL_ASSOC')) {
				if(isset($_POST[cli_country_cdE]) && $_POST[cli_country_cdE]==$row[geo_country_cd]){
					echo '<option value ="'.$row['geo_country_cd'].'" selected>'.$row['geo_country'].'</option>';
				}else{
					echo '<option value ="'.$row['geo_country_cd'].'">'.$row['geo_country'].'</option>';
				}
			}
				?>       
			</select>
		</td>
	  </tr>	  	 			  
	  <tr>
		<td colspan="2" class="label"><hr></td>
		</tr>
	  <tr>
		<td colspan="2" class="subtitulo"><?php echo $title2;?></td>
	  </tr>
	  <tr>
	  	<td nowrap id="title_user_prof_cd_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $perfil;?></td>			  	
	  </tr>			 
	  <tr>
		<td id="label_user_prof_cd_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg6;?>&nbsp;<div id="required_user_prof_cd" style="display:none;">*</div></td>
		<td id="input_user_prof_cd_underline">
			<select name="user_prof_cd" id="user_prof_cd">		
				<option value ="-1"></option>'					
				<?php
				$r = $db->select($_sql3);
				while ($row=$db->get_row($r, 'MYSQL_ASSOC')) {
					if(isset($_POST[user_prof_cdE]) && $_POST[user_prof_cdE]==$row[user_prof_cd]){
						echo '<option value ="'.$row['user_prof_cd'].'" selected>'.$row['user_prof_nm'].'</option>';
					}else{
						echo '<option value ="'.$row['user_prof_cd'].'">'.$row['user_prof_nm'].'</option>';
					}
				}
				?>        
			</select>
		</td>
	  </tr>
	  <tr>
	  	<td nowrap id="title_user_login_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $log;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_user_login_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg7;?>&nbsp;<div id="required_user_login" style="display:none;">*</div></td>
		<td id="input_user_login_underline"><input class='required' alt="<?php echo $contrasena;?>" name="user_login" type="text" id="user_login" size="30" value="<?php if(isset($_POST[user_loginE])){echo $_POST[user_loginE];}?>"></td>
	  </tr>
	  <tr>
	  	<td nowrap id="title_user_pass_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $contrasena;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_user_pass_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg8;?>&nbsp;<div id="required_user_pass" style="display:none;">*</div></td>
		<td id="input_user_pass_underline"><input class='password' alt="<?php echo $contrasena;?>" name="user_pass" type="password" id="user_pass" size="20" value="<?php if(isset($_POST[user_passE])){echo $_POST[user_passE];}?>"> <span class="nota"> M&iacute;nimo 6 caracteres</span></td>
	  </tr>	
	  <tr>
	  	<td nowrap id="title_conf_user_pass_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $rep_contrasena;?></td>			  	
	  </tr>		  
	  <tr>
		<td id="label_conf_user_pass_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg9;?>&nbsp;<div id="required_conf_user_pass" style="display:none;">*</div></td>
		<td id="input_conf_user_pass_underline"><input name="conf_user_pass" type="password" id="conf_user_pass" size="20" value="<?php if(isset($_POST[user_passE])){echo $_POST[user_passE];}?>"></td>
	  </tr>	
	  <tr>
		<td>&nbsp;</td>
	  </tr>	
	  <tr>
	  	<td nowrap id="title_user_date_in_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $fecha_entrada;?></td>			  	
	  </tr>		
	  <tr>
		<td nowrap id="label_user_date_in_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg10;?>&nbsp;<div id="required_user_date_in" style="display:none;">*</div></td>
		<?php 
		$user_date_in='';
		if(isset($_POST[user_date_in])){
			$user_date_in=$_POST[user_date_in];
		}else{
			$user_date_in=date('Y/m/d');
		}
		?>
		<td id="input_user_date_in_underline"><?php echo escribe_formulario_fecha_vacio2('user_date_in','forma',$user_date_in,'');?></td>
	  </tr>
	  <tr>
	  	<td nowrap id="title_user_date_out_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $fecha_salida;?></td>			  	
	  </tr>		
	  <tr>
		<td nowrap id="label_user_date_out_underline" class="label"><?php echo $msg11;?>&nbsp;<div id="required_user_date_out" style="display:none;">*</div></td>
		<?php 
		$user_date_out='';
		if(isset($_POST[user_date_out])){
			$user_date_out=$_POST[user_date_out];
		}else{
			$user_date_out='';
		}
		?>
		<td id="input_user_date_out_underline"><?php echo escribe_formulario_fecha_vacio2('user_date_out','forma',$user_date_out,'');?> <div id="required_cli_date_out" class="requridoerror">*</div></td>
	  </tr>		
	</table>
	<br>
	<table width="75%" border="0" cellpadding="0" cellspacing="3">
	  <tr>
		<td colspan="2"><div id="notaerror" class="notaerror" style="display:none; "><?php echo $msg20;?></div></td>
	  </tr>	  
	  <tr>	
	  	<td>&nbsp;</td>	
		<td colspan="2" align="right"><input type="button" class="cssbutton" value="<?php echo $btnlabel;?>" id="submitForm" onclick="validateMandatoryFields()"></td>
	  </tr>
	  <tr>		
	  </tr>
	</table> 
</form>
<br><br><br>
<?php echo $obj->getFooter(); ?>