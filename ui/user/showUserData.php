<?php
include_once ('../../includes/session.inc');
check_login();

/**Generador de Tooltip*/
// include the JavaScript tooltip generator class
require_once ('../../includes/tooltips/class.tooltips.php');

// instantiate the class
$tt = new tooltips();

/**Fin generador de Tooltip*/

include_once ('../../includes/calendario/calendario.php');
include_once ('../../includes/simplepage.class.php');

$obj = new simplepage();
$obj->setTitle("Editar Cliente");
$obj->setCSS("../../includes/style/style.css");
$obj->setJS("../../includes/calendario/javascripts.js");
$obj->setJS("../../includes/validate/user/validate_editClientPro.js");
$obj->setJS("../../includes/validate/user/validate_editClientPar.js");

echo $obj->getHeader();
$img_dir = "../../images";

// set some properties for the tooltip
// THIS MUST BE DONE BEFORE CALLING THE init() METHOD!

// tell the tooltips to start fading in only after it have waited for 100 milliseconds
$tt->fadeInDelay = 50;
// tell the tooltips to start fading out only after 3 seconds
// this is to show how more than just one tooltip can be visible on the screen at the same time!
$tt->fadeOutDelay = 200;

$tt->offsetX = 0;

$tt->offsetY = 0;
// see the manual for what other properties can be set!

// notice that we init the tooltips in the <BODY> !
$tt->init();

require_once ('../../data/db.class.php');
$db = new db_class;
if (!$db->connect()) {
	$db->print_last_error(false);
}

if (trim($_SESSION[nombre_usuario])) {
	$_sql = "	SELECT 	client.id_client as 'id_client'," .
	"cli_cd," .
	"cli_firstname," .
	"cli_lastname,
							cli_town," .
	"cli_sex_cd," .
	"cli_birthdate," .
	"cli_company_nm," .
	"cli_ident_type_cd,
							cli_ident_num," .
	"cli_act_cd," .
	"cli_phone_num1," .
	"cli_phone_num2,
							cli_fax_num," .
	"cli_cell_phone," .
	"cli_e_mail," .
	"cli_address,
							cli_postal_cd," .
	"cli_country_cd," .
	"user_login," .
	"user_pass," .
	"id_user," .
	"user_date_in," .
	"user_info_cre," .
	"user_info_upd," .
	"user_date_req
							FROM 
								users, client
							WHERE 
								user_login = '" . $_SESSION[nombre_usuario] . "'
								AND users.id_client=client.id_client
								AND client.cli_current_flag=1
								AND users.user_current_flag=1";
}
//echo 'Consulta:<br> '.$_sql;
$r = $db->select($_sql);
$row = $db->get_row($r, 'MYSQL_ASSOC');

$r_tipo_cliente = $db->select("select cli_act_grp_nm from client_activity where cli_act_cd='" . $row['cli_act_cd'] . "' and cli_act_lang='SP'");
$row_tipo_cliente = $db->get_row($r_tipo_cliente, 'MYSQL_ASSOC');
$tipo_cliente = $row_tipo_cliente[cli_act_grp_nm];
if (trim($tipo_cliente) == 'Profesional') {
	/*****************INTERNACIONALIZACION *************/
	include_once ('../../lang/user/ui/addUserPro.php');
	include_once ('../../lang/user/ui/errorMessage.php');
	/***************************************************/
	$lastnames = explode(" ", $row[cli_lastname]);
	$lastname1 = $lastnames[0];
	$lastname2 = $lastnames[1];
	$_sql = "SELECT sex_treatment FROM sex WHERE sex_cd='" . $row[cli_sex_cd] . "' and sex_lang='" . $_SESSION[idm] . "'";
	$rp = $db->select($_sql);
	$row_0 = $db->get_row($rp, 'MYSQL_ASSOC');

	$_sql = "SELECT geo_country_cd,geo_country FROM geography WHERE geo_country_cd='" . $row[cli_country_cd] . "'";
	$rz = $db->select($_sql);
	$row_21 = $db->get_row($rz, 'MYSQL_ASSOC');

	$_sex_sql = "SELECT sex_treatment,sex_cd FROM sex WHERE sex_lang='" . $_SESSION[idm] . "'";

	$_sql_countries = "SELECT geo_country_cd,geo_country FROM geography GROUP BY geo_country,geo_country_cd";
?>
<br><br>		
<form name='forma' id='forma' method='post' action='../../control/user/editUserProfesional.php?from_page=../../ui/user/showUserData.php'>
	<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" id="editUserPro">	 
		  <tr>
			<td colspan="2" class="subtitulo"><?php echo $title3;?></td>
		  </tr>			  
		  <tr>
		  	<td nowrap id="title_cli_sex_cd_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $tratamiento;?></td>			  	
		  </tr>
		  <tr>
			<td id="label_cli_sex_cd_underline" class="label"><span style="color:#FF0000; ">*</span><?php echo $msg1;?>&nbsp;<div id="required_cli_sex_cd" style="display:none;">*</div></td>
			<td id="input_cli_sex_cd_underline">
				<select name="cli_sex_cd" id="cli_sex_cd" onclick="show_submitForm(true)">
				<option value ="-1"></option>'		
				<?php

	$r = $db->select($_sex_sql);
	while ($row_2 = $db->get_row($r, 'MYSQL_ASSOC')) {
		if (trim($row_0[sex_treatment]) == trim($row_2[sex_treatment]) || $_POST[cli_sex_cdE] == $row_2[sex_cd]) {
			echo "<option value ='" . $row_2['sex_cd'] . "' selected>" . $row_2['sex_treatment'] . "</option>";
		} else {
			echo '<option value ="' . $row_2['sex_cd'] . '">' . $row_2['sex_treatment'] . '</option>';
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
			<td id="input_cli_firstname_underline"><input name="cli_firstname" type="text" id="cli_firstname" size="20" value="<?php if(isset($_POST[cli_firstnameE])){echo $_POST[cli_firstnameE];}else{echo $row[cli_firstname];} ?>" onclick="show_submitForm(true)"></td>
		  </tr>
		  <tr>
		  	<td nowrap id="title_cli_lastname_1_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $apellido;?></td>			  	
		  </tr>
		  <tr>
			<td id="label_cli_lastname_1_underline" class="label"><span style="color:#FF0000; ">*</span><?php echo $msg3;?>&nbsp;<div id="required_cli_lastname_1" style="display:none;">*</div></td>
			<td id="input_cli_lastname_1_underline"><input name="cli_lastname_1" type="text" id="cli_lastname_1" size="20" value="<?php if(isset($_POST[cli_lastname_1E])){echo $_POST[cli_lastname_1E];}else{echo $lastname1;} ?>" onclick="show_submitForm(true)"></td>
		  </tr>
		  <tr>
			<td class="label"> <?php echo $msg4;?></td>
			<td><input type="text" id="cli_lastname_2" name="cli_lastname_2" size="20" value="<?php if(isset($_POST[cli_lastname_2E])){echo $_POST[cli_lastname_2E];}else{echo $lastname2;} ?>" onfocus="show_submitForm(true)" ></td>
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
			<td id="input_cli_company_nm_underline"><input name="cli_company_nm" type="text" id="cli_company_nm" size="30" value="<?php if(isset($_POST[cli_company_nmE])){echo $_POST[cli_company_nmE];}else{echo $row[cli_company_nm];} ?>" onfocus="show_submitForm(true);"></td>
		  </tr>
		  <tr>
			<td class="label"> <?php echo $msg6;?></td>
			<td>
				<input name="cli_phone_num1" type="text" id="cli_phone_num1" size="20" value="<?php if(isset($_POST[cli_phone_num1E])){echo $_POST[cli_phone_num1E];}else{echo $row[cli_phone_num1];} ?>" onfocus="show_submitForm(true);">					
				<img width="15" height="15" name="help" src="<?php echo $img_dir;?>/help.png"  onmousemove="<?=$tt->show("<b>Por que necesitamos su Teléfono Fijo?</b><br><br>Necesitamos su teléfono fijo para contactarlo.")?>">
			</td>												
		  </tr>
		  <tr>
			<td nowrap class="label"> <?php echo $msg7;?></td>
			<td><input name="cli_phone_num2" type="text" id="cli_phone_num2" size="20" value="<?php if(isset($_POST[cli_phone_num2E])){echo $_POST[cli_phone_num2E];}else{echo $row[cli_phone_num2];} ?>" onfocus="show_submitForm(true);"></td>
		  </tr>
		  <tr>
			<td class="label"> <?php echo $msg8;?></td>
			<td><input name="cli_cell_phone" type="text" id="cli_cell_phone" size="20" value="<?php if(isset($_POST[cli_cell_phoneE])){echo $_POST[cli_cell_phoneE];}else{echo $row[cli_cell_phone];} ?>" onfocus="show_submitForm(true);"></td>
		  </tr>
		  <tr>
			<td class="label"> <?php echo $msg9;?></td>
			<td><input name="cli_fax_num" type="text" id="cli_fax_num" size="20" value="<?php if(isset($_POST[cli_fax_numE])){echo $_POST[cli_fax_numE];}else{echo $row[cli_fax_num];} ?>" onfocus="show_submitForm(true);"></td>
		  </tr>
		  <tr>
		  	<td nowrap id="title_cli_e_mail_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $email;?></td>			  	
		  </tr>
		  <tr>
			<td id="label_cli_e_mail_underline" class="label"><span style="color:#FF0000; ">*</span><?php echo $msg10;?>&nbsp;<div id="required_cli_e_mail" style="display:none;">*</div></td>
			<td id="input_cli_e_mail_underline">
				<input name="cli_e_mail" type="text" id="cli_e_mail" size="20" value="<?php if(isset($_POST[cli_e_mailE])){echo $_POST[cli_e_mailE];}else{echo $row[cli_e_mail];} ?>" onfocus="show_submitForm(true);">										
				<img name="help" src="<?php echo $img_dir;?>/help.png"  onmousemove="<?=$tt->show("<b>Por que necesitamos su Email?</b><br><br>Necesitamos su email para contactarlo.")?>">
			</td>	
		  </tr>
		  <tr>
		  	<td nowrap id="title_cli_country_cd_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;Por favor seleccione el pais</td>			  	
		  </tr>
		  <tr>
			<td id="label_cli_country_cd_underline" class="label"><span style="color:#FF0000; ">*</span>Pais&nbsp;<div id="required_cli_country_cd" style="display:none;">*</div></td>
			<td id="input_cli_country_cd_underline">
				<select name="cli_country_cd" id="cli_country_cd" onfocus="show_submitForm(true);">
				<option value ="-1"></option>'		
				<?php

	$r = $db->select($_sql_countries);
	while ($row4 = $db->get_row($r, 'MYSQL_ASSOC')) {
		if ($row_21[geo_country_cd] == $row4[geo_country_cd] || $_POST[geo_country_cdE] == $row4[geo_country_cd]) {
			echo '<option value ="' . $row4['geo_country_cd'] . '" selected>' . $row4['geo_country'] . '</option>';
		} else {
			echo '<option value ="' . $row4['geo_country_cd'] . '">' . $row4['geo_country'] . '</option>';
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
			<td id="input_cli_address_underline"><input name="cli_address" type="text" id="cli_address" size="30" value="<?php if(isset($_POST[cli_addressE])){echo $_POST[cli_addressE];}else{echo $row[cli_address];} ?>" onfocus="show_submitForm(true);"></td>
		  </tr>
		  <tr>
		  	<td nowrap id="title_cli_postal_cd_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $zip;?></td>			  	
		  </tr>
		  <tr>
			<td id="label_cli_postal_cd_underline" class="label"><span style="color:#FF0000; ">*</span><?php echo $msg12;?>&nbsp;<div id="required_cli_postal_cd" style="display:none;">*</div></td>
			<td id="input_cli_postal_cd_underline"><input name="cli_postal_cd" type="text" id="cli_postal_cd" size="10" value="<?php if(isset($_POST[cli_postal_cdE])){echo $_POST[cli_postal_cdE];}else{echo $row[cli_postal_cd];} ?>" onfocus="show_submitForm(true);"></td>
		  </tr>
		  <tr>
			<td class="label"> <?php echo $msg13;?></td>
			<td><input name="cli_town" type="text" id="cli_town" size="20" value="<?php if(isset($_POST[cli_townE])){echo $_POST[cli_townE];}else{echo $row[cli_town];} ?>" onfocus="show_submitForm(true);"></td>
		  </tr>
		  <tr>
		  	<td nowrap id="title_cli_ident_num_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $cif;?></td>			  	
		  </tr>
		  <tr>
			<td id="label_cli_ident_num_underline" class="label" ><span style="color:#FF0000; ">*</span><?php echo $msg14;?>&nbsp;<div id="required_cli_ident_num" style="display:none;">*</div></td>
			<td id="input_cli_ident_num_underline">
				<input name="cli_ident_num" type="text" id="cli_ident_num" size="20" value="<?php if(isset($_POST[cli_ident_numE])){echo $_POST[cli_ident_numE];}else{echo $row[cli_ident_num];} ?>" onfocus="show_submitForm(true);">					
				<img name="help" src="<?php echo $img_dir;?>/help.png"  onmousemove="<?=$tt->show("<b>Por que necesitamos su CIF?</b><br><br> Necesitamos su CIF para poder generar sus facturas.")?>">
			</td>
		  </tr>			  			  
		  <input name="user_login" type="hidden" id="user_login" size="30" value="<?php if(isset($_POST[user_loginE])){echo $_POST[user_loginE];}else{echo $row[user_login];} ?>">
		  <input name="user_pass" type="hidden" id="user_pass" size="20" value="<?php if(isset($_POST[user_passE])){echo $_POST[user_passE];}else{echo $row[user_pass];} ?>">
		</table>
		</td>		
	</table>	
	<table width="450" border="0" align="center" cellpadding="0" cellspacing="3">			  				
		<tr>
			<td>&nbsp;</td>			
			<td colspan="2" align="right"><input type="button" class="cssbutton" value="Registrar" style="display:none;" id="submitForm" onclick="edit_Profesional_validateMandatoryFields()"></td>
		</tr>
		<tr>
			<td ><input name="user_prof_cd" type="hidden" id="user_prof_cd" value="<?php echo $row['cli_act_cd']; ?>"></td>
			<td ><input name="id_client" type="hidden" id="id_client" value="<?php echo $row['id_client']; ?>"></td>
			<td ><input name="cli_cd" type="hidden" id="cli_cd" value="<?php echo $row['cli_cd']; ?>"></td>
			<td ><input name="id_user" type="hidden" id="id_user" value="<?php echo $row['id_user']; ?>"></td>
			<td ><input type="hidden" id="user_date_in" name="user_date_in" value="<?php echo $row['user_date_in'];?>"></td>								
			<td ><input type="hidden" id="user_date_req" name="user_date_req" value="<?php echo $row['user_date_req'];?>"></td>
			<td ><input type="hidden" id="user_date_out" name="user_date_out" value="<?php echo $row[user_date_out];?>"></td>							
			<td ><input type="hidden" id="user_info_cre" name="user_info_cre" value="<?php echo $row[user_info_cre];?>"></td>
			<td ><input type="hidden" id="user_login" name="user_login" value="<?php echo $row[user_login];?>"></td>									
			<td ><input type="hidden" id="user_pass" name="user_pass" value="<?php echo $row[user_pass];?>"></td>
			<td ><input name="edit_client" type="hidden" id="edit_client" value="true"></td>
			<td ><input name="edit_user" type="hidden" id="edit_user" value=""></td>																					
		</tr>  	
	</table>							
</form>
<?php

}
elseif (trim($tipo_cliente) == 'Particular' || trim($tipo_cliente) == '') {
	$lastnames = explode(" ", $row[cli_lastname]);
	$lastname1 = $lastnames[0];
	$lastname2 = $lastnames[1];
	$_sql = "SELECT sex_treatment FROM sex WHERE sex_cd='" . $row[cli_sex_cd] . "' and sex_lang='" . $_SESSION[idm] . "'";
	$rp = $db->select($_sql);
	$row_0 = $db->get_row($rp, 'MYSQL_ASSOC');

	$_sql = "SELECT ident_type_nm FROM identification_doc_type WHERE ident_type_cd='" . $row[cli_ident_type_cd] . "' and ident_type_country='" . $_SESSION[idm] . "'";
	$rw = $db->select($_sql);
	$row_1 = $db->get_row($rw, 'MYSQL_ASSOC');

	$_sql = "SELECT geo_country_cd,geo_country FROM geography WHERE geo_country_cd='" . $row[cli_country_cd] . "'";
	$rz = $db->select($_sql);
	$row_21 = $db->get_row($rz, 'MYSQL_ASSOC');

	$_sex_sql = "SELECT sex_treatment,sex_cd FROM sex WHERE sex_lang='" . $_SESSION[idm] . "'";

	$_sql_ident_doc_type = "SELECT ident_type_nm,ident_type_cd FROM identification_doc_type WHERE ident_type_cd!='VAT' AND ident_type_country='" . $_SESSION[idm] . "'";

	$_sql_countries = "SELECT geo_country_cd,geo_country FROM geography GROUP BY geo_country,geo_country_cd";

	/***********INTERNACIONALIZACION *********/
	include_once ('../../lang/user/ui/addUserPar.php');
	include_once ('../../lang/user/ui/errorMessage.php');
	/******************************/
?>		

<br>			
<form name='forma' id='forma' method='post' action='../../control/user/editUserParticular.php?from_page=../../ui/user/showUserData.php'>
	<table width="450" border="0" align="center" cellpadding="0" cellspacing="0" id="addUser_particular">		
		<tr>
			<td colspan="2" class="subtitulo"><?php echo $title3;?></td>
		</tr>
		<tr>
	  		<td nowrap id="title_cli_sex_cd_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $tratamiento;?></td>			  	
	  	</tr>
		<tr>
			<td id="label_cli_sex_cd_underline" class="label"><span style="color:#FF0000; ">*</span><?php echo $msg1;?>&nbsp;<div id="required_cli_sex_cd" style="display:none;">*</div></td>
			<td id="input_cli_sex_cd_underline">
				<select name="cli_sex_cd" id="cli_sex_cd" onclick="show_submitForm(true)">
				<option value ="-1"><?php echo $msg21;?></option>'		
				<?php

	$r = $db->select($_sex_sql);
	while ($row_2 = $db->get_row($r, 'MYSQL_ASSOC')) {
		if (trim($row_0[sex_treatment]) == trim($row_2[sex_treatment]) || $_POST[cli_sex_cdE] == $row_2[sex_cd]) {
			echo "<option value ='" . $row_2['sex_cd'] . "' selected>" . $row_2['sex_treatment'] . "</option>";
		} else {
			echo '<option value ="' . $row_2['sex_cd'] . '">' . $row_2['sex_treatment'] . '</option>';
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
		<td id="input_cli_firstname_underline"><input name="cli_firstname" type="text" id="cli_firstname" size="20" value="<?php if(isset($_POST[cli_firstnameE])){echo $_POST[cli_firstnameE];}else{echo $row[cli_firstname];} ?>" onclick="show_submitForm(true)"></td>
	  </tr>
	  <tr>
	  	<td nowrap id="title_cli_lastname_1_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $apellido;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_cli_lastname_1_underline" class="label"><span style="color:#FF0000; ">*</span><?php echo $msg3;?>&nbsp;<div id="required_cli_lastname_1" style="display:none;">*</div></td>
		<td id="input_cli_lastname_1_underline"><input name="cli_lastname_1" type="text" id="cli_lastname_1" size="20" value="<?php if(isset($_POST[cli_lastname_1E])){echo $_POST[cli_lastname_1E];}else{echo $lastname1;} ?>" onclick="show_submitForm(true)"></td>
	  </tr>
	  <tr>
		<td class="label"> <?php echo $msg4;?></td>
		<td><input type="text" id="cli_lastname_2" name="cli_lastname_2" size="20" value="<?php if(isset($_POST[cli_lastname_2E])){echo $_POST[cli_lastname_2E];}else{echo $lastname2;} ?>" onfocus="show_submitForm(true)" ></td>
	  </tr>
	  <tr>
	  	<td nowrap id="title_cli_ident_type_cd_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $identificaicon_tipo;?></td>			  	
	  </tr>
	  <tr>
		<td nowrap id="label_cli_ident_type_cd_underline" class="label"><span style="color:#FF0000; ">*</span><?php echo $msg5;?>&nbsp;<div id="required_cli_ident_type_cd" style="display:none;">*</div></td>
		<td id="input_cli_ident_type_cd_underline">
			<select name="cli_ident_type_cd" id="cli_ident_type_cd" onclick="show_submitForm(true)">
			<option value ="-1"><?php echo $msg22;?></option>'	
			<?php

	$r = $db->select($_sql_ident_doc_type);
	while ($row_3 = $db->get_row($r, 'MYSQL_ASSOC')) {
		if ($row_1['ident_type_nm'] == $row_3['ident_type_nm'] || $_POST[cli_ident_type_cdE] == $row_3[ident_type_cd]) {
			echo '<option value ="' . $row_3['ident_type_cd'] . '" selected>' . $row_3['ident_type_nm'] . '</option>';
		} else {
			echo '<option value ="' . $row_3['ident_type_cd'] . '">' . $row_3['ident_type_nm'] . '</option>';
		}
	}
?>     
			</select>
		</td>
	  </tr>			   
	<tr>
	  	<td nowrap id="title_cli_ident_num_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $identificaicon_num;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_cli_ident_num_underline" class="label" ><span style="color:#FF0000; ">*</span><?php echo $msg6;?>&nbsp;<div id="required_cli_ident_num" style="display:none;">*</div></td>
		<td id="input_cli_ident_num_underline"><input name="cli_ident_num" type="text" id="cli_ident_num" size="20" value="<?php if(isset($_POST[cli_ident_numE])){echo $_POST[cli_ident_numE];}else{echo $row[cli_ident_num];} ?>" onfocus="show_submitForm(true);"></td>
	  </tr>	
	  <tr>
	  	<td nowrap id="title_birthday_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $nacimiento;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_birthday_underline" class="label"><span style="color:#FF0000; ">*</span><?php echo $msg7;?>&nbsp;<div id="required_birthday" style="display:none;">*</div></td>
		<?php

	$birhtday = '';
	if (isset ($_POST[birthdayE])) {
		$birhtday = $_POST[birthdayE];
	} else {
		$birhtday = $row[cli_birthdate];
	}
?>
		<td id="input_birthday_underline"><?php echo escribe_formulario_fecha_vacio2('birthday','forma',$birhtday,'');?></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td colspan="2" class="subtitulo"><?php echo $title4;?></td>
	  </tr>			 
	  <tr>
		<td class="label"> <?php echo $msg8;?></td>
		<td><input name="cli_phone_num1" type="text" id="cli_phone_num1" size="20" value="<?php if(isset($_POST[cli_phone_num1E])){echo $_POST[cli_phone_num1E];}else{echo $row[cli_phone_num1];} ?>" onfocus="show_submitForm(true);">  <div id="required_cli_phone_num1" class="requridoerror">*</div></td>
	  </tr>
	  <tr>
		<td class="label"> <?php echo $msg9;?></td>
		<td><input name="cli_cell_phone" type="text" id="cli_cell_phone" size="20" value="<?php if(isset($_POST[cli_cell_phoneE])){echo $_POST[cli_cell_phoneE];}else{echo $row[cli_cell_phone];} ?>" onfocus="show_submitForm(true);"></td>
	  </tr>
	  <tr>
	  	<td nowrap id="title_cli_e_mail_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $email;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_cli_e_mail_underline" class="label"><span style="color:#FF0000; ">*</span><?php echo $msg10;?>&nbsp;<div id="required_cli_e_mail" style="display:none;">*</div></td>
		<td id="input_cli_e_mail_underline">
			<input name="cli_e_mail" type="text" id="cli_e_mail" size="20" value="<?php if(isset($_POST[cli_e_mailE])){echo $_POST[cli_e_mailE];}else{echo $row[cli_e_mail];} ?>" onfocus="show_submitForm(true);">										
			<img name="help" src="<?php echo $img_dir;?>/help.png"  onmousemove="<?=$tt->show("<b>Por que necesitamos su Email?</b><br><br>Necesitamos su email para contactarlo.")?>">
		</td>	
	  </tr>
	  <tr>
	  	<td nowrap id="title_cli_country_cd_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;Por favor seleccione el pais</td>			  	
	  </tr>
	  <tr>
		<td id="label_cli_country_cd_underline" class="label"><span style="color:#FF0000; ">*</span>Pais&nbsp;<div id="required_cli_country_cd" style="display:none;">*</div></td>
		<td id="input_cli_country_cd_underline">
			<select name="cli_country_cd" id="cli_country_cd" onfocus="show_submitForm(true);">
			<option value ="-1">Pais</option>'		
			<?php

	$r = $db->select($_sql_countries);
	while ($row4 = $db->get_row($r, 'MYSQL_ASSOC')) {
		if ($row_21[geo_country_cd] == $row4[geo_country_cd] || $_POST[geo_country_cdE] == $row4[geo_country_cd]) {
			echo '<option value ="' . $row4['geo_country_cd'] . '" selected>' . $row4['geo_country'] . '</option>';
		} else {
			echo '<option value ="' . $row4['geo_country_cd'] . '">' . $row4['geo_country'] . '</option>';
		}
	}
?>       
			</select>
		</td>
	  </tr>	  	
	  <tr>
		<td class="label"> <?php echo $msg11;?></td>
		<td><input name="cli_address" type="text" id="cli_address" size="30" value="<?php if(isset($_POST[cli_addressE])){echo $_POST[cli_addressE];}else{echo $row[cli_address];} ?>" onfocus="show_submitForm(true);"> </td>
	  </tr>
	  <tr>
	  	<td nowrap id="title_cli_postal_cd_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $zip;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_cli_postal_cd_underline" class="label"><span style="color:#FF0000; ">*</span><?php echo $msg12;?>&nbsp;<div id="required_cli_postal_cd" style="display:none;">*</div></td>
		<td id="input_cli_postal_cd_underline"><input name="cli_postal_cd" type="text" id="cli_postal_cd" size="10" value="<?php if(isset($_POST[cli_postal_cdE])){echo $_POST[cli_postal_cdE];}else{echo $row[cli_postal_cd];} ?>" onfocus="show_submitForm(true);"></td>
	  </tr>
	  <tr>
		<td class="label"> <?php echo $msg13;?></td>
		<td><input name="cli_town" type="text" id="cli_town" size="20" value="<?php if(isset($_POST[cli_townE])){echo $_POST[cli_townE];}else{echo $row[cli_town];} ?>" onfocus="show_submitForm(true);"></td>
	  </tr>			 			  			  
	  <input name="user_login" type="hidden" id="user_login" size="30" value="<?php if(isset($_POST[user_loginE])){echo $_POST[user_loginE];}else{echo $row[user_login];} ?>" readonly>			  
	  <input name="user_pass"  type="hidden" id="user_pass" size="20" value="<?php if(isset($_POST[user_passE])){echo $_POST[user_passE];}else{echo $row[user_pass];} ?>">		
	</table>		
	<table width="450" border="0" align="center" cellpadding="0" cellspacing="3">			  		
		<tr>
			<td colspan="2" >&nbsp;</td>
			<td colspan="2" align="right"><input type="button" class="cssbutton" value="Registrar" style="display:none;" id="submitForm" onclick="edit_Particular_validateMandatoryFields()"></td>
		</tr>		
		<tr>
			<td ><input name="user_prof_cd" type="hidden" id="user_prof_cd" value="<?php echo $row['cli_act_cd']; ?>"></td>
			<td ><input name="id_client" type="hidden" id="id_client" value="<?php echo $row['id_client']; ?>"></td>
			<td ><input name="cli_cd" type="hidden" id="cli_cd" value="<?php echo $row['cli_cd']; ?>"></td>
			<td ><input name="id_user" type="hidden" id="id_user" value="<?php echo $row['id_user']; ?>"></td>				
			<td ><input type="hidden" id="user_date_in" name="user_date_in" value="<?php echo $row['user_date_in'];?>"></td>								
			<td ><input type="hidden" id="user_date_req" name="user_date_req" value="<?php echo $row['user_date_req'];?>"></td>
			<td ><input type="hidden" id="user_date_out" name="user_date_out" value="<?php echo $row[user_date_out];?>"></td>							
			<td ><input type="hidden" id="user_info_cre" name="user_info_cre" value="<?php echo $row[user_info_cre];?>"></td>
			<td ><input type="hidden" id="user_login" name="user_login" value="<?php echo $row[user_login];?>"></td>									
			<td ><input type="hidden" id="user_pass" name="user_pass" value="<?php echo $row[user_pass];?>"></td>
			<td ><input name="edit_client" type="hidden" id="edit_client" value="true"></td>
			<td ><input name="edit_user" type="hidden" id="edit_user" value=""></td>																								
		</tr>  		 
	</table>	
</form>
<?php } ?>
<br><br><br>
<?php echo $obj->getFooter();?>