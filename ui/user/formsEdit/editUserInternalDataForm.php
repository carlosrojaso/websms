<?php

/***********INTERNACIONALIZACION *********/
include_once('../../lang/user/ui/addUserInternal.php');
include_once('../../lang/user/ui/addUserInternal_errorMessage.php');

/******************************/

$lastnames = explode(" ", $row[cli_lastname]);
$lastname1 = $lastnames[0];
$lastname2 = $lastnames[1];

$_sql = "SELECT user_prof_nm FROM user_profile WHERE user_prof_nm='" . $row[user_prof_nm] . "' and user_prof_lang='SP'";
$rw = $db->select($_sql);
$row_4 = $db->get_row($rw, 'MYSQL_ASSOC');

$_sql_1 = "SELECT geo_country_cd,geo_country FROM geography WHERE geo_country_cd='" . $row[cli_country_cd] . "' GROUP BY geo_country,geo_country_cd";
$rw_1 = $db->select($_sql_1);
//echo 'sql: '.$_sql_1;
$row_6 = $db->get_row($rw_1, 'MYSQL_ASSOC');
?>
<br><br>
<form name='forma' id='forma' method='post' action='../../control/user/editUserInternal.php?from_page=../../control/user/searchUserInternals.php&par=2&usuario=<?php echo $row[user_login];?>' >
	<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" id="editUserInternal">		
	  <tr>
		<td colspan="2" class="subtitulo"><?php echo $title;?></td>
	  </tr>
	   <tr>
	  	<td nowrap id="title_cli_firstname_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $nombre;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_cli_firstname_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg1;?>&nbsp;<div id="required_cli_firstname" style="display:none;">*</div></td>
		<td id="input_cli_firstname_underline"><input name="cli_firstname" type="text" id="cli_firstname" size="20" value="<?php if(isset($_POST[cli_firstnameE])){echo $_POST[cli_firstnameE];}else{echo $row[cli_firstname];} ?>" onclick="show_submitForm(true)" onchange="editClient()"></td>
	  </tr>
	  <tr>
	  	<td nowrap id="title_cli_lastname_1_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $apellido;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_cli_lastname_1_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg2;?>&nbsp;<div id="required_cli_lastname_1" style="display:none;">*</div></td>
		<td id="input_cli_lastname_1_underline"><input name="cli_lastname_1" type="text" id="cli_lastname_1" size="20" value="<?php if(isset($_POST[cli_lastname_1E])){echo $_POST[cli_lastname_1E];}else{echo $lastname1;} ?>" onclick="show_submitForm(true)" onchange="editClient()"></td>
	  </tr>
	  <tr>
		<td class="label"> <?php echo $msg3;?></td>
		<td><input class='empty' name="cli_lastname_2" type="text" id="cli_lastname_2" size="20" value="<?php if(isset($_POST[cli_lastname_2E])){echo $_POST[cli_lastname_2E];}else{echo $lastname2;} ?>" onfocus="show_submitForm(true)" onchange="editClient()"></td>
	  </tr>			  		
	 <tr>
	  	<td nowrap id="title_cli_e_mail_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $email;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_cli_e_mail_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg4;?>&nbsp;<div id="required_cli_e_mail" style="display:none;">*</div></td>
		<td id="input_cli_e_mail_underline">
			<input name="cli_e_mail" type="text" id="cli_e_mail" size="20" value="<?php if(isset($_POST[cli_e_mailE])){echo $_POST[cli_e_mailE];}else{echo $row[cli_e_mail];} ?>" onfocus="show_submitForm(true);" onchange="editClient()">										
			<img name="help" src="<?php echo $img_dir;?>/help.png"  onmousemove="<?=$tt->show("<b>Por que necesitamos su Email?</b><br><br>Necesitamos su email para contactarlo.")?>">
		</td>	
	  </tr>	  
	  <tr>
	  	<td nowrap id="title_cli_country_cd_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;Por favor seleccione el pais</td>			  	
	  </tr>
	  <tr>
		<td id="label_cli_country_cd_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg5;?>&nbsp;<div id="required_cli_country_cd" style="display:none;">*</div></td>
		<td id="input_cli_country_cd_underline">
			<select name="cli_country_cd" id="cli_country_cd" onfocus="show_submitForm(true);" onchange="editClient()">
			<option value ="-1"></option>'		
			<?php
				$r = $db->select("SELECT geo_country_cd,geo_country FROM geography GROUP BY geo_country,geo_country_cd");
				while ($row_7 = $db->get_row($r, 'MYSQL_ASSOC')) {
				if ($row_6['geo_country_cd'] == $row_7['geo_country_cd'] || $_POST[cli_country_cdE] == $row_7[geo_country_cd]) {
				echo '<option value ="' . $row_7['geo_country_cd'] . '" selected>' . $row_7['geo_country'] . '</option>';
				} else {
					echo '<option value ="' . $row_7['geo_country_cd'] . '">' . $row_7['geo_country'] . '</option>';
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
			<select name="user_prof_cd" id="user_prof_cd" onfocus="show_submitForm(true);" onchange="editUser()">		
				<option value ="-1"></option>'					
				<?php
					$r = $db->select("SELECT user_prof_cd,user_prof_nm FROM  user_profile WHERE user_prof_lang='SP' AND user_prof_group_cd='I' AND user_prof_current_flag=1");
					while ($row_5 = $db->get_row($r, 'MYSQL_ASSOC')) {
					if ($row_4['user_prof_nm'] == $row_5['user_prof_nm'] || $_POST[user_prof_cdE] == $row_5['user_prof_cd']) {
					echo '<option value ="' . $row_5['user_prof_cd'] . '" selected>' . $row_5['user_prof_nm'] . '</option>';
					} else {
						echo '<option value ="' . $row_5['user_prof_cd'] . '">' . $row_5['user_prof_nm'] . '</option>';
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
		<td id="input_user_login_underline"><input name="user_login" type="text" id="user_login" size="30" value="<?php if(isset($_POST[user_loginE])){echo $_POST[user_loginE];}else{echo $row[user_login];} ?>"  READONLY></td>
	  </tr>
	  <tr>
	  	<td nowrap id="title_user_pass_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $contrasena;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_user_pass_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg8;?>&nbsp;<div id="required_user_pass" style="display:none;">*</div></td>
		<td id="input_user_pass_underline"><input name="user_pass" type="password" id="user_pass" size="20" value="<?php if(isset($_POST[user_passE])){echo $_POST[user_passE];}else{echo $row[user_pass];} ?>" onfocus="show_submitForm(true); document.forma.conf_user_pass.value='';" onchange="editUser()"> <span class="nota"> M&iacute;nimo 6 caracteres</span></td>
	  </tr>	
	  <tr>
	  	<td nowrap id="title_conf_user_pass_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $rep_contrasena;?></td>			  	
	  </tr>		  
	  <tr>
		<td id="label_conf_user_pass_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg9;?>&nbsp;<div id="required_conf_user_pass" style="display:none;">*</div></td>
		<td id="input_conf_user_pass_underline"><input name="conf_user_pass" type="password" id="conf_user_pass" size="20" value="<?php if(isset($_POST[user_passE])){echo $_POST[user_passE];}else{echo $row[user_pass];} ?>" onfocus="show_submitForm(true);"></td>
	  </tr>	
	  <tr>
		<td>&nbsp;</td>
	  </tr>	
	  	<?php
			$valid_arr = split(' ', $row[user_date_in]);
			$valid_since = $valid_arr[0];
			//echo date('Y-m-d').' '.$valid_since;
			$fromdate = new DateCK($valid_since, "-");
			$todate = new DateCK(date('Y-m-d'), "-");
			$compareStatus = $fromdate->comparedates($todate);
			if ($compareStatus == -1 || $row[user_status_cd] == 'D') {
		?>	
	  <tr>
	  	<td nowrap id="title_user_date_in_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $fecha_entrada;?></td>			  	
	  </tr>					  
	  <tr>				  				 	
		<td nowrap id="label_user_date_in_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg10;?>&nbsp;<div id="required_user_date_in" style="display:none;">*</div></td>				
		<?php
			if (isset ($_POST[user_date_inE])) {
				$d_in = $_POST[user_date_inE];
			} else {
				$d_in = str_replace("-", "/", substr($row[user_date_in], 0, 10));
			}
		?>
		<td input_user_date_in_underline><?php echo escribe_formulario_fecha_vacio3('user_date_in','forma',$d_in,'');?></td>
	  </tr>
	  <?php }?>
	  <tr>
	  	<td nowrap id="title_user_date_out_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $fecha_salida2;?></td>			  	
	  </tr>		
	  <tr>
		<td nowrap id="label_user_date_out_underline" class="label"> <?php echo $msg11;?>&nbsp;<div id="required_user_date_out" style="display:none;">*</div></td>
		<?php
			if (isset ($_POST[user_date_outE])) {
				$d_out = $_POST[user_date_outE];
			} else {
				$d_out = str_replace("-", "/", substr($row[user_date_out], 0, 10));
				}
		?>
		<td id="input_user_date_out_underline"><?php echo escribe_formulario_fecha_vacio3('user_date_out','forma',$d_out,'');?></td>
	  </tr>			
	</table>	
	<table width="50%" border="0" align="center" cellpadding="0" cellspacing="3">			  
		<tr>
			<td colspan="2" >&nbsp;</td>			
		</tr>
		<tr>				
			<td colspan="2" align="right"><input type="button" class="cssbutton" value="Modificar" style="display:none;" id="submitForm" onclick="validateMandatoryFields()"></td>
		</tr>
		<tr>
			<td><input name="id_client" type="hidden" id="id_client" value="<?php echo $row['id_client']; ?>"></td>			
			<td><input name="id_user" type="hidden" id="id_user" value="<?php echo $row['id_user']; ?>"></td>		
			<?php 
				if($compareStatus != -1 || $row[user_status_cd] != 'D'){				
			?>
			<td><input name="user_date_in" type="hidden" id="user_date_in" value="<?php echo $row['user_date_in']; ?>"></td>
			<?php }?>
			<td ><input name="user_info_cre" type="hidden" id="user_info_cre" value="<?php echo $row['user_info_cre']; ?>"></td>				
			<td ><input name="user_date_req" type="hidden" id="user_date_req" value="<?php echo $row['user_date_req']; ?>"></td>
			<td ><input name="edit_client" type="hidden" id="edit_client" value=""></td>
			<td ><input name="edit_user" type="hidden" id="edit_user" value=""></td>
		</tr>  
	</table>		
</form>
<br><br>
<?php echo $obj->getFooter(); ?>