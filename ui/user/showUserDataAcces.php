<?php
include_once ('../../includes/session.inc');
check_login();

/***********INTERNACIONALIZACION *********/
include_once ('../../lang/user/ui/showUserDataAcces.php');
include_once ('../../lang/user/ui/errorMessage.php');
/******************************/

include_once ('../../includes/calendario/calendario.php');
include_once ('../../includes/simplepage.class.php');

$obj = new simplepage();
$obj->setTitle("Editar datos de acceso Cliente");
$obj->setCSS("../../includes/style/style.css");
$obj->setJS("../../includes/calendario/javascripts.js");
$obj->setJS("../../includes/validate/user/validate_editDataAccess.js");

echo $obj->getHeader();
$img_dir = "../../images";

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
						"user_date_req," .
						"user_prof_cd," .
						"IFNULL(user_date_out,'Indefinido') user_date_out
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

$lastnames = explode(" ", $row[cli_lastname]);
$lastname1 = $lastnames[0];
$lastname2 = $lastnames[1];
?>
<br><br>
<form name='forma' id='forma' method='post' action='../../control/user/editUserdataAcces.php?from_page=showUserDataAccess.php'>
	<table width="50%" border="0" align="center" cellpadding="0" cellspacing="1" id="showUserDataAcces">	 			
		  <tr>
			<td colspan="2" class="subtitulo"><?php echo $title1;?></td>
		  </tr>			  			  
		  <tr>
		  	<td nowrap id="title_user_login_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $log;?></td>			  	
		  </tr>
		  <tr>
			<td id="label_user_login_underline" class="label"><span style="color:#FF0000; ">*</span><?php echo $msg1;?>&nbsp;<div id="required_user_login" style="display:none;">*</div></td>
			<td id="input_user_login_underline"><input name="user_login" type="text" id="user_login" size="30" value="<?php if(isset($_POST[user_loginE])){echo $_POST[user_loginE];}else{echo $row[user_login];} ?>" readonly></td>
		  </tr>
		  <tr>
		  	<td nowrap id="title_user_pass_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $contrasena;?></td>			  	
		  </tr>
		  <tr>
			<td id="label_user_pass_underline" class="label"><span style="color:#FF0000; ">*</span><?php echo $msg2;?>&nbsp;<div id="required_user_pass" style="display:none;">*</div></td>
			<td id="input_user_pass_underline"><input name="user_pass" type="password" id="user_pass" size="20" value="<?php if(isset($_POST[user_passE])){echo $_POST[user_passE];}else{echo $row[user_pass];} ?>" onfocus="document.getElementById('submitForm').style.display='inline'; document.forma.conf_user_pass.value='';"> <span class="nota"><?php echo $msg4;?></span></td>
		  </tr>	
		  <tr>
		  	<td nowrap id="title_conf_user_pass_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $rep_contrasena;?></td>			  	
		  </tr>		  
		  <tr>
			<td id="label_conf_user_pass_underline" class="label"><span style="color:#FF0000; ">*</span><?php echo $msg3;?>&nbsp;<div id="required_conf_user_pass" style="display:none;">*</div></td>
			<td id="input_conf_user_pass_underline"><input name="conf_user_pass" type="password" id="conf_user_pass" size="20" value="<?php if(isset($_POST[user_passE])){echo $_POST[user_passE];}else{echo $row[user_pass];} ?>"></td>
		  </tr>									 		
	</table>
	<table width="450" border="0" align="center" cellpadding="0" cellspacing="3">			  				
		<tr>			
			<td colspan="2" align="right"><input type="button" class="cssbutton" value="Registrar" style="display:none;" id="submitForm" onclick="validateMandatoryFields()"></td>
		</tr>
		<tr>			
			<input type="hidden" 	value="<?php echo $row[id_user];?>" 			id="id_user" 			name="id_user" >
			<input type="hidden" 	value="<?php echo $row[user_prof_cd];?>"			id="user_prof_cd" 		name="user_prof_cd" >
			<input type="hidden" 	value="<?php echo $row[id_client];?>" 			id="id_client" 			name="id_client" >
			<input type="hidden" 	value="<?php echo $row[cli_sex_cd];?>" 			id="cli_sex_cd" 		name="cli_sex_cd" >
			<input type="hidden" 	value="<?php echo $row[cli_firstname];?>"		id="cli_firstname" 		name="cli_firstname" >
			<input type="hidden"	value="<?php echo $lastname1; ?>" 				id="cli_lastname_1" 	name="cli_lastname_1">
			<input type="hidden"  	value="<?php echo $lastname2; ?>" 				id="cli_lastname_2" 	name="cli_lastname_2">
			<input type="hidden"  	value="<?php echo $row[cli_company_nm]; ?>" 	id="cli_company_nm" 	name="cli_company_nm">
			<input type="hidden" 	value="<?php echo $row[cli_phone_num1]; ?>" 	id="cli_phone_num1" 	name="cli_phone_num1">
			<input type="hidden"  	value="<?php echo $row[cli_country_cd]; ?>" 	id="cli_country_cd" 	name="cli_country_cd">
			<input type="hidden"  	value="<?php echo $row[cli_phone_num2]; ?>" 	id="cli_phone_num2" 	name="cli_phone_num2">
			<input type="hidden" 	value="<?php echo $row[cli_cell_phone]; ?>" 	id="cli_cell_phone" 	name="cli_cell_phone">
			<input type="hidden" 	value="<?php echo $row[cli_fax_num]; ?>" 		id="cli_fax_num" 		name="cli_fax_num" >
			<input type="hidden" 	value="<?php echo $row[cli_e_mail]; ?>" 		id="cli_e_mail" 		name="cli_e_mail">
			<input type="hidden" 	value="<?php echo $row[cli_address]; ?>" 		id="cli_address" 		name="cli_address">
			<input type="hidden" 	value="<?php echo $row[cli_postal_cd]; ?>" 		id="cli_postal_cd"  	name="cli_postal_cd">
			<input type="hidden"  	value="<?php echo $row[cli_town]; ?>" 			id="cli_town" 			name="cli_town">
			<input type="hidden" 	value="<?php echo $row['cli_ident_type_cd'];?>" id="cli_ident_type_cd" 	name="cli_ident_type_cd" >		  
			<input type="hidden" 	value="<?php echo $row[cli_ident_num]; ?>" 		id="cli_ident_num" 		name="cli_ident_num">
			<input type="hidden"  	value="<?php echo $row[cli_birthdate]; ?>" 		id="birthday" 			name="birthday">
			<input type="hidden" 	value="<?php echo $row['user_date_in'];?>" 		id="user_date_in" 		name="user_date_in">								
			<input type="hidden" 	value="<?php echo $row['user_date_req'];?>"		id="user_date_req" 		name="user_date_req" >
			<input type="hidden" 	value="<?php echo $row[user_date_out];?>"		id="user_date_out" 		name="user_date_out" >							
			<input type="hidden" 	value="<?php echo $row[user_info_cre];?>"		id="user_info_cre" 		name="user_info_cre" >																	
			<input type="hidden" 	value="<?php echo $row[cli_date_in];?>"			id="cli_date_in" 		name="cli_date_in">
			<input type="hidden"   	value="<?php echo $row[cli_company_nm]; ?>" 	id="cli_company_nm" 	name="cli_company_nm">
			<?php
			$r1 = $db->select("SELECT user_prof_group_cd FROM user_profile WHERE user_prof_cd='".$row[user_prof_cd]."' AND user_prof_lang='SP'");
			$row1 = $db->get_row($r1, 'MYSQL_ASSOC');			
			?>
			<input type="hidden"   	value="<?php echo $row1[user_prof_group_cd]; ?>" id="user_prof_group_cd" name="user_prof_group_cd">
			<td ><input name="edit_client" type="hidden" id="edit_client" value=""></td>
			<td ><input name="edit_user" type="hidden" id="edit_user" value="true"></td>	
		</tr>  	
	</table>		
</form>
<br><br><br>
<?php echo $obj->getFooter();?>
