<?php
/**
 * addUserPro.php
 * 
 * Interfaz Ingresar Cliente Profesional
 * 
 * @author Victor Manuel Vallecilla Mira<vallecilla@gmail.com> 
 * @version 1.0
 * @package ui
 * @creacion: 22/09/2007
 * @license: GNU/GPL	
*/
include_once('../../includes/session.inc');
//check_login();

/**Generador de Tooltip*/
// include the JavaScript tooltip generator class
require_once('../../includes/tooltips/class.tooltips.php');

// instantiate the class
$tt = new tooltips();

/**Fin generador de Tooltip*/

/*****************INTERNACIONALIZACION *************/
include_once('../../lang/user/ui/addUserPro.php');
include_once('../../lang/user/ui/errorMessage.php');
/***************************************************/

//Determinar el idioma en el cual se muestra la pagina
if($_SESSION[idm]){
	$lang=$_SESSION[idm];
	switch($_SESSION[idm]){
		case 'UK':
			$title=$title_en;
			$title2=$title2_en;
			$title3=$title3_en;
			$title4=$title4_en;
			$title5=$title5_en;

			$msg1=$msg1_en;
			$msg2=$msg2_en;
			$msg3=$msg3_en;
			$msg4=$msg4_en;
			$msg5=$msg5_en;
			$msg6=$msg6_en;
			$msg7=$msg7_en;
			$msg8=$msg8_en;
			$msg9=$msg9_en;
			$msg10=$msg10_en;
			$msg11=$msg11_en;
			$msg12=$msg12_en;
			$msg13=$msg13_en;
			$msg14=$msg14_en;
			$msg15=$msg15_en;
			$msg16=$msg16_en;
			$msg17=$msg17_en;
			$msg18=$msg18_en;
			$msg19=$msg19_en;
			$msg20=$msg20_en;
			$msg21=$msg21_en;
			$msg22=$msg22_en;
			$msg23=$msg23_en;

			$btnlabel=$btnlabel_en;

			$nombre=$nombre_en;
			$apellido=$apellido_en;
			$id=$id_en;
			$email=$email_en;
			$direccion=$direccion_en;
			$zip=$zip_en;
			$compania=$compania_en;
			$cif=$cif_en;
			$ciudad=$ciudad_en;
			$contrasena=$contrasena_en;
			$tel_fijo1=$tel_fijo1_en;
			$tel_fijo2=$tel_fijo2_en;
			$cel=$cel_en;
			$fax=$fax_en;

			$validateUserLogin=$validateUserLogin_en;
			$validateUserPassword=$validateUserPassword_en;
			$validateUserConfPassword=$validateUserConfPassword_en;
			$validateRequestEmail=$validateRequestEmail_en;
			$checkFields=$checkFields_en;
			$cancelModule=$cancelModule_en;
			$isEmailAddress1=$isEmailAddress1_en;
			$isEmailAddress2=$isEmailAddress2_en;
			$validateDelete=$validateDelete_en;
			$validateUserConfPassword_modif=$validateUserConfPassword_modif_en;

			break;
	}
}else{
	$lang=$_GET[lang];
}


include_once('../../includes/simplepage.class.php');

$obj = new simplepage();
$obj->setTitle($title);

$obj->setCSS("../../includes/style/style.css");
$obj->setJS("../../includes/validate/user/validate_addUserPro.js");
//Tratamiento
$_sql="SELECT sex_cd,sex_treatment FROM sex WHERE sex_lang='".$lang."'";
//Pais
$_sql4="SELECT geo_country_cd,geo_country FROM geography GROUP BY geo_country,geo_country_cd";
echo $obj->getHeader();
$img_dir = "../../images";
require_once('../../data/db.class.php');
$db = new db_class();
if (!$db->connect()){
	$db->print_last_error(false);
}

// set some properties for the tooltip
// THIS MUST BE DONE BEFORE CALLING THE init() METHOD!

// tell the tooltips to start fading in only after it have waited for 100 milliseconds
$tt->fadeInDelay = 50;
// tell the tooltips to start fading out only after 3 seconds
// this is to show how more than just one tooltip can be visible on the screen at the same time!
$tt->fadeOutDelay = 200;

$tt->offsetX=0;

$tt->offsetY=0;
// see the manual for what other properties can be set!

// notice that we init the tooltips in the <BODY> !
$tt->init();

?>
<br><br>
<form action='../../control/user/addUserProfesional.php' method="post" name="forma" id="forma">
	<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" id="addUserPro">	  
	  <tr>
		<td colspan="2" class="subtitulo"><?php echo $title3;?></td>
	  </tr>			  
	  <tr>
		<td nowrap id="title_cli_sex_cd_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $tratamiento;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_cli_sex_cd_underline" class="label"><span style="color:#FF0000; ">*</span><?php echo $msg1;?>&nbsp;<div id="required_cli_sex_cd" style="display:none;">*</div></td>
		<td id="input_cli_sex_cd_underline">
		<select name="cli_sex_cd" id="cli_sex_cd" >
		<option value ="-1"></option>'		
		<?php
			$r = $db->select($_sql);
			while ($row=$db->get_row($r, 'MYSQL_ASSOC')) {
			if(isset($_POST[cli_sex_cdE]) && $_POST[cli_sex_cdE]==$row[sex_cd]){
				echo '<option value ="'.$row['sex_cd'].'" selected>'.$row['sex_treatment'].'</option>';
			}else{
				echo '<option value ="'.$row['sex_cd'].'">'.$row['sex_treatment'].'</option>';
				}
			}
		?>       
		</select>
		</td>
	  </tr>
	  <tr>
		<td nowrap id="title_cli_firstname_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $nombre;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_cli_firstname_underline" class="label"><span style="color:#FF0000; ">*</span><?php echo $msg2;?>&nbsp;<div id="required_cli_firstname" style="display:none;">*</div></td>
		<td id="input_cli_firstname_underline"><input name="cli_firstname" type="text" id="cli_firstname" size="20" value="<?php if(isset($_POST[cli_firstnameE])){echo $_POST[cli_firstnameE];}?>"></td>
	  </tr>
	  <tr>
		<td nowrap id="title_cli_lastname_1_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $apellido;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_cli_lastname_1_underline" class="label"><span style="color:#FF0000; ">*</span><?php echo $msg3;?>&nbsp;<div id="required_cli_lastname_1" style="display:none;">*</div></td>
		<td id="input_cli_lastname_1_underline"><input name="cli_lastname_1" type="text" id="cli_lastname_1" size="20" value="<?php if(isset($_POST[cli_lastname_1E])){echo $_POST[cli_lastname_1E];}?>"></td>
	  </tr>
	  <tr>
		<td class="label"> <?php echo $msg4;?></td>
		<td><input type="text" id="cli_lastname_2" name="cli_lastname_2" size="20" value="<?php if(isset($_POST[cli_lastname_2E])){echo $_POST[cli_lastname_2E];}?>"></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td colspan="2" class="subtitulo"><?php echo $title4;?></td>
	  </tr>			  			  
	  <tr>
		<td nowrap id="title_cli_company_nm_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $compania;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_cli_company_nm_underline" class="label"><span style="color:#FF0000; ">*</span><?php echo $msg5;?>&nbsp;<div id="required_cli_company_nm" style="display:none;">*</div></td>
		<td id="input_cli_company_nm_underline"><input name="cli_company_nm" type="text" id="cli_company_nm" size="30" value="<?php if(isset($_POST[cli_company_nmE])){echo $_POST[cli_company_nmE];}?>"></td>
	  </tr>
	  <tr>
		<td class="label"> <?php echo $msg6;?></td>
		<td>
		<input name="cli_phone_num1" type="text" id="cli_phone_num1" size="20" value="<?php if(isset($_POST[cli_phone_num1E])){echo $_POST[cli_phone_num1E];}?>">					
		<img width="15" height="15" name="help" src="<?php echo $img_dir;?>/help.png"  onmousemove="<?=$tt->show("<b>Por que necesitamos su Teléfono Fijo?</b><br><br>Necesitamos su teléfono fijo para contactarlo.")?>">
		</td>												
	  </tr>
	  <tr>
		<td nowrap class="label"> <?php echo $msg7;?></td>
		<td><input name="cli_phone_num2" type="text" id="cli_phone_num2" size="20" value="<?php if(isset($_POST[cli_phone_num2E])){echo $_POST[cli_phone_num2E];}?>"></td>
	  </tr>
	  <tr>
		<td class="label"> <?php echo $msg8;?></td>
		<td><input name="cli_cell_phone" type="text" id="cli_cell_phone" size="20" value="<?php if(isset($_POST[cli_cell_phoneE])){echo $_POST[cli_cell_phoneE];}?>"></td>
	  </tr>
	  <tr>
		<td class="label"> <?php echo $msg9;?></td>
		<td><input name="cli_fax_num" type="text" id="cli_fax_num" size="20" value="<?php if(isset($_POST[cli_fax_numE])){echo $_POST[cli_fax_numE];}?>"></td>
	  </tr>
	  <tr>
		<td nowrap id="title_cli_e_mail_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $email;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_cli_e_mail_underline" class="label"><span style="color:#FF0000; ">*</span><?php echo $msg10;?>&nbsp;<div id="required_cli_e_mail" style="display:none;">*</div></td>
		<td id="input_cli_e_mail_underline">
		<input name="cli_e_mail" type="text" id="cli_e_mail" size="20" value="<?php if(isset($_POST[cli_e_mailE])){echo $_POST[cli_e_mailE];}?>">										
		<img name="help" src="<?php echo $img_dir;?>/help.png"  onmousemove="<?=$tt->show("<b>Por que necesitamos su Email?</b><br><br>Necesitamos su email para contactarlo.")?>">
		</td>	
	  </tr>
	  <tr>
		<td nowrap id="title_cli_country_cd_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;Por favor seleccione el pais</td>			  	
	  </tr>
	  <tr>
		<td id="label_cli_country_cd_underline" class="label"><span style="color:#FF0000; ">*</span>Pais&nbsp;<div id="required_cli_country_cd" style="display:none;">*</div></td>
		<td id="input_cli_country_cd_underline">
		<select name="cli_country_cd" id="cli_country_cd" >
		<option value ="-1"></option>'		
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
		<td nowrap id="title_cli_address_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $direccion;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_cli_address_underline" class="label"><span style="color:#FF0000; ">*</span><?php echo $msg11;?>&nbsp;<div id="required_cli_address" style="display:none;">*</div></td>
		<td id="input_cli_address_underline"><input name="cli_address" type="text" id="cli_address" size="30" value="<?php if(isset($_POST[cli_addressE])){echo $_POST[cli_addressE];}?>"></td>
	  </tr>
	  <tr>
		<td nowrap id="title_cli_postal_cd_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $zip;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_cli_postal_cd_underline" class="label"><span style="color:#FF0000; ">*</span><?php echo $msg12;?>&nbsp;<div id="required_cli_postal_cd" style="display:none;">*</div></td>
		<td id="input_cli_postal_cd_underline"><input name="cli_postal_cd" type="text" id="cli_postal_cd" size="10" value="<?php if(isset($_POST[cli_postal_cdE])){echo $_POST[cli_postal_cdE];}?>"></td>
	  </tr>
	  <tr>
		<td class="label"> <?php echo $msg13;?></td>
		<td><input name="cli_town" type="text" id="cli_town" size="20" value="<?php if(isset($_POST[cli_townE])){echo $_POST[cli_townE];}?>"></td>
	  </tr>
	  <tr>
		<td nowrap id="title_cli_ident_num_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $cif;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_cli_ident_num_underline" class="label" ><span style="color:#FF0000; ">*</span><?php echo $msg14;?>&nbsp;<div id="required_cli_ident_num" style="display:none;">*</div></td>
		<td id="input_cli_ident_num_underline">
		<input name="cli_ident_num" type="text" id="cli_ident_num" size="20" value="<?php if(isset($_POST[cli_ident_numE])){echo $_POST[cli_ident_numE];}?>">					
		<img name="help" src="<?php echo $img_dir;?>/help.png"  onmousemove="<?=$tt->show("<b>Por que necesitamos su CIF?</b><br><br> Necesitamos su CIF para poder generar sus facturas.")?>">
		</td>
	  </tr>			  			  
	  <tr>
		<td colspan="2"><hr></td>
	  </tr>
	  <tr>
		<td colspan="2" class="subtitulo"><?php echo $title5;?></td>
	  </tr>			  			  
	  <tr>
		<td nowrap id="title_user_login_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $log;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_user_login_underline" class="label"><span style="color:#FF0000; ">*</span><?php echo $msg17;?>&nbsp;<div id="required_user_login" style="display:none;">*</div></td>
		<td id="input_user_login_underline"><input class='required' name="user_login" type="text" id="user_login" size="30" value="<?php if(isset($_POST[user_loginE])){echo $_POST[user_loginE];}?>"></td>
	  </tr>
	  <tr>
		<td nowrap id="title_user_pass_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $contrasena;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_user_pass_underline" class="label"><span style="color:#FF0000; ">*</span><?php echo $msg18;?>&nbsp;<div id="required_user_pass" style="display:none;">*</div></td>
		<td id="input_user_pass_underline"><input class='password' name="user_pass" type="password" id="user_pass" size="20" value="<?php if(isset($_POST[user_passE])){echo $_POST[user_passE];}?>"> <span class="nota"> M&iacute;nimo 6 caracteres</span></td>
	  </tr>	
	  <tr>
		<td nowrap id="title_conf_user_pass_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $rep_contrasena;?></td>			  	
	  </tr>		  
	  <tr>
		<td id="label_conf_user_pass_underline" class="label"><span style="color:#FF0000; ">*</span><?php echo $msg19;?>&nbsp;<div id="required_conf_user_pass" style="display:none;">*</div></td>
		<td id="input_conf_user_pass_underline"><input name="conf_user_pass" type="password" id="conf_user_pass" size="20" value="<?php if(isset($_POST[user_passE])){echo $_POST[user_passE];}?>"></td>
	  </tr>									 	 	
	</table>
	<table width="50%" border="0" align="center" cellpadding="0" cellspacing="3">		  
	  <tr>
		<td colspan="2" id="notaerror" class="notaerror" style="display:none; "><br><?php echo $msg20;?><br></td>
	  </tr>
	  <tr>
		<td><a target="_blank" href="../../includes/terms/condiciones.html" title="<?php echo $msg21;?>" class="condiciones"><?php echo $msg21;?></a></td>
	  </tr>
	  <tr>
		<td class="aceptacondicion"><?php echo $msg22;?><input name="terms_of_use" type="checkbox" id="terms_of_use" value="checkbox" onClick="showLayer(true,'submitForm','block');" ></td>
		<td colspan="2"><input type="button" class="cssbutton" value="<?php echo $btnlabel;?>" style="display:none;" id="submitForm" onclick="validateMandatoryFields()"></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>			
	  </tr>
	  <tr>
		<td><input type="button" value="Volver" onclick="location.href='../../ui/user/selectUserAct.php?lang=SP'" class="cssbutton"></td>			
	  </tr>
	  <tr>
		<td><input name="user_prof_cd" type="hidden" id="user_prof_cd" value="<?php if(isset($_POST[user_prof_cdE])){echo $_POST[user_prof_cdE];}else{echo $_POST[profile_cd];} ?>"></td>			
	  </tr>
	</table> 
</form>
<br><br><br>
<?php echo $obj->getFooter();?>
