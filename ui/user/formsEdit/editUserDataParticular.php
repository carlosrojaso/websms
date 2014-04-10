<?php

/***********INTERNACIONALIZACION *********/
include_once('../../lang//user/ui/addUserPar.php');
include_once('../../lang/user/ui/addUserPar_errorMessage.php');
/******************************/
?>
<br>			
<form name='forma' id='forma' method='post' action='../../control/user/editUserParticular.php?from_page=../../control/user/searchUser.php&par=2&usuario=<?php echo $row[user_login];?>'>
	<table width="50%" border="0" align="center" cellpadding="0" cellspacing="1" id="editUserDataParticular">		
		<tr>
			<td colspan="2" class="subtitulo"><?php echo $title1;?></td>
		</tr>
		<tr>
			<td nowrap id="title_cli_sex_cd_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $tratamiento;?></td>			  	
		</tr>
		<tr>
			<td id="label_cli_sex_cd_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg1;?>&nbsp;<div id="required_cli_sex_cd" style="display:none;">*</div></td>
			<td id="input_cli_sex_cd_underline">
				<select name="cli_sex_cd" id="cli_sex_cd" onclick="show_submitForm(true)" onchange="editClient()">
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
			<td id="label_cli_firstname_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg2;?>&nbsp;<div id="required_cli_firstname" style="display:none;">*</div></td>
			<td id="input_cli_firstname_underline"><input name="cli_firstname" type="text" id="cli_firstname" size="20" value="<?php if(isset($_POST[cli_firstnameE])){echo $_POST[cli_firstnameE];}else{echo $row[cli_firstname];} ?>" onclick="show_submitForm(true)" onchange="editClient()"></td>
		</tr>
		<tr>
			<td nowrap id="title_cli_lastname_1_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $apellido;?></td>			  	
		</tr>
		<tr>
			<td id="label_cli_lastname_1_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg3;?>&nbsp;<div id="required_cli_lastname_1" style="display:none;">*</div></td>
			<td id="input_cli_lastname_1_underline"><input name="cli_lastname_1" type="text" id="cli_lastname_1" size="20" value="<?php if(isset($_POST[cli_lastname_1E])){echo $_POST[cli_lastname_1E];}else{echo $lastname1;} ?>" onclick="show_submitForm(true)" onchange="editClient()"></td>
		</tr>
		<tr>
			<td class="label"> <?php echo $msg4;?></td>
			<td><input type="text" id="cli_lastname_2" name="cli_lastname_2" size="20" value="<?php if(isset($_POST[cli_lastname_2E])){echo $_POST[cli_lastname_2E];}else{echo $lastname2;} ?>" onfocus="show_submitForm(true)" onchange="editClient()"></td>
		</tr>
		<tr>
			<td nowrap id="title_cli_ident_type_cd_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $identificaicon_tipo;?></td>			  	
		</tr>
		<tr>
			<td nowrap id="label_cli_ident_type_cd_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg5;?>&nbsp;<div id="required_cli_ident_type_cd" style="display:none;">*</div></td>
			<td id="input_cli_ident_type_cd_underline">
				<select name="cli_ident_type_cd" id="cli_ident_type_cd" onfocus="show_submitForm(true)" onchange="editClient()">
					<option value ="-1"></option>'	
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
			<td id="label_cli_ident_num_underline" class="label" ><span style="color:#FF0000;">*</span><?php echo $msg6;?>&nbsp;<div id="required_cli_ident_num" style="display:none;">*</div></td>
			<td id="input_cli_ident_num_underline"><input name="cli_ident_num" type="text" id="cli_ident_num" size="20" value="<?php if(isset($_POST[cli_ident_numE])){echo $_POST[cli_ident_numE];}else{echo $row[cli_ident_num];} ?>" onfocus="show_submitForm(true);" onchange="editClient()"></td>
		</tr>	
		<tr>
			<td nowrap id="title_birthday_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $nacimiento;?></td>			  	
		</tr>
		<tr>
			<td id="label_birthday_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg7;?>&nbsp;<div id="required_birthday" style="display:none;">*</div></td>
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
			<td colspan="2">&nbsp;</td>			
		</tr>
		<tr>
			<td colspan="2" class="subtitulo"><?php echo $title2;?></td>
		</tr>			 
		<tr>
			<td class="label"> <?php echo $msg8;?></td>
			<td><input name="cli_phone_num1" type="text" id="cli_phone_num1" size="20" value="<?php if(isset($_POST[cli_phone_num1E])){echo $_POST[cli_phone_num1E];}else{echo $row[cli_phone_num1];} ?>" onfocus="show_submitForm(true);">  <div id="required_cli_phone_num1" class="requridoerror">*</div></td>
		</tr>
		<tr>
			<td class="label"> <?php echo $msg9;?></td>
			<td><input name="cli_cell_phone" type="text" id="cli_cell_phone" size="20" value="<?php if(isset($_POST[cli_cell_phoneE])){echo $_POST[cli_cell_phoneE];}else{echo $row[cli_cell_phone];} ?>" onfocus="show_submitForm(true);" onchange="editClient()"></td>
		</tr>
		<tr>
			<td nowrap id="title_cli_e_mail_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $email;?></td>			  	
		</tr>
		<tr>
			<td id="label_cli_e_mail_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg10;?>&nbsp;<div id="required_cli_e_mail" style="display:none;">*</div></td>
			<td id="input_cli_e_mail_underline">
			<input name="cli_e_mail" type="text" id="cli_e_mail" size="20" value="<?php if(isset($_POST[cli_e_mailE])){echo $_POST[cli_e_mailE];}else{echo $row[cli_e_mail];} ?>" onfocus="show_submitForm(true);" onchange="editClient()">										
			<img name="help" src="<?php echo $img_dir;?>/help.png"  onmousemove="<?=$tt->show($tooltip_email)?>">
			</td>	
		</tr>			  
		<tr>
			<td class="label"> <?php echo $msg11;?></td>
			<td><input name="cli_address" type="text" id="cli_address" size="30" value="<?php if(isset($_POST[cli_addressE])){echo $_POST[cli_addressE];}else{echo $row[cli_address];} ?>" onfocus="show_submitForm(true);" onchange="editClient()"> </td>
		</tr>
		<tr>
			<td nowrap id="title_cli_country_cd_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;Por favor seleccione el pais</td>			  	
		</tr>
		<tr>
			<td id="label_cli_country_cd_underline" class="label"><span style="color:#FF0000;">*</span>Pais&nbsp;<div id="required_cli_country_cd" style="display:none;">*</div></td>
			<td id="input_cli_country_cd_underline">
			<select name="cli_country_cd" id="cli_country_cd" onfocus="show_submitForm(true);" onchange="editClient()">
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
			<td nowrap id="title_cli_postal_cd_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $zip;?></td>			  	
		</tr>
		<tr>
			<td id="label_cli_postal_cd_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg12;?>&nbsp;<div id="required_cli_postal_cd" style="display:none;">*</div></td>
			<td id="input_cli_postal_cd_underline"><input name="cli_postal_cd" type="text" id="cli_postal_cd" size="10" value="<?php if(isset($_POST[cli_postal_cdE])){echo $_POST[cli_postal_cdE];}else{echo $row[cli_postal_cd];} ?>" onfocus="show_submitForm(true);" onchange="editClient()"></td>
		</tr>
		<tr>
			<td class="label"> <?php echo $msg13;?></td>
			<td><input name="cli_town" type="text" id="cli_town" size="20" value="<?php if(isset($_POST[cli_townE])){echo $_POST[cli_townE];}else{echo $row[cli_town];} ?>" onfocus="show_submitForm(true);" onchange="editClient()"></td>
		  </tr>			 			  
		<tr>
			<td colspan="2"><hr></td>
		</tr>
		<tr>
			<td colspan="2" class="subtitulo"><?php echo $title3;?></td>
		</tr>			  
		<tr>
			<td nowrap id="title_user_login_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $log;?></td>			  	
		</tr>
		<tr>
			<td id="label_user_login_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg14;?>&nbsp;<div id="required_user_login" style="display:none;">*</div></td>
			<td id="input_user_login_underline"><input name="user_login" type="text" id="user_login" size="30" value="<?php if(isset($_POST[user_loginE])){echo $_POST[user_loginE];}else{echo $row[user_login];} ?>" readonly></td>
		</tr>
		<tr>
			<td nowrap id="title_user_pass_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $contrasena;?></td>			  	
		</tr>
		<tr>
			<td id="label_user_pass_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg15;?>&nbsp;<div id="required_user_pass" style="display:none;">*</div></td>
			<td id="input_user_pass_underline"><input name="user_pass" type="password" id="user_pass" size="20" value="<?php if(isset($_POST[user_passE])){echo $_POST[user_passE];}else{echo $row[user_pass];} ?>" onfocus="document.getElementById('submitForm').style.display='inline'; document.forma.conf_user_pass.value='';" onchange="editUser()"> <span class="nota"><?php echo $msg19;?></span></td>
		</tr>	
		<tr>
			<td nowrap id="title_conf_user_pass_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $rep_contrasena;?></td>			  	
		</tr>		  
		<tr>
			<td id="label_conf_user_pass_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg16;?>&nbsp;<div id="required_conf_user_pass" style="display:none;">*</div></td>
			<td id="input_conf_user_pass_underline"><input name="conf_user_pass" type="password" id="conf_user_pass" size="20" value="<?php if(isset($_POST[user_passE])){echo $_POST[user_passE];}else{echo $row[user_pass];} ?>"></td>
		</tr>			
	</table>
	<br>
	<table width="75%" border="0" cellpadding="0" cellspacing="1">			  		
		<tr>						
			<td align="right"><input type="button" class="cssbutton" value="Registrar" style="display:none;" id="submitForm" onclick="edit_Particular_validateMandatoryFields()"></td>			
		</tr>				
	</table>		
	<input name="user_prof_cd" type="hidden" id="user_prof_cd" value="<?php echo $row['cli_act_cd']; ?>">
	<input name="id_client" type="hidden" id="id_client" value="<?php echo $row['id_client']; ?>">
	<input name="cli_cd" type="hidden" id="cli_cd" value="<?php echo $row['cli_cd']; ?>">
	<input name="id_user" type="hidden" id="id_user" value="<?php echo $row['id_user']; ?>">
	<input name="user_date_in" type="hidden" id="user_date_in" value="<?php echo $row['user_date_in']; ?>">				
	<input name="user_info_cre" type="hidden" id="user_info_cre" value="<?php echo $row['user_info_cre']; ?>">
	<input name="user_date_req" type="hidden" id="user_date_req" value="<?php echo $row['user_date_req']; ?>">
	<input name="edit_client" type="hidden" id="edit_client" value="">
	<input name="edit_user" type="hidden" id="edit_user" value="">		
</form>

<br><br><br>
<?php echo $obj->getFooter(); ?>
