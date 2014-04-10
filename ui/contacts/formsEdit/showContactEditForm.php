<?php
/**
 * editContactPar.php
 * 
 * Formulario que ejecuta la edicion de contactos particulares. es agregado del control searchContact
 * 
 * @author Carlos A. Rojas <carlkant@gmail.com>
 * @version 1.0
 * @package 
 * @creacion: 27/12/2007
 * @license: 	
*/




$_sql1="SELECT sex_cd , sex_nm FROM  sex WHERE sex_lang ='".$_SESSION[idm]."'";




?>
<br><br>
<form name='forma' id='forma' method='post' action='../../control/contacts/editContactPar.php' >
	<table width="50%" border="0" align="center" cellpadding="0" cellspacing="1" id="editContact">
	  <tr>
		<td colspan="2" class="subtitulo"><?php echo $title;?></td>
	  </tr>			  	  
	  <tr>
	  	<td nowrap id="title_cont_firstname_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $nombre;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_cont_firstname_underline" class="label"><span style="color:#FF0000; ">*</span><?php echo $msg1;?>&nbsp;<div id="required_cont_firstname" style="display:none;">*</div></td>
		<td id="input_cont_firstname_underline"><input name="cont_firstname" type="text" id="cont_firstname" size="20" value="<?php echo $row['cont_firstname'];?>"></td>
	  </tr>	  	  
	  <tr>
	  	<td nowrap id="title_cont_lastname_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $apellido;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_cont_lastname_underline" class="label"><span style="color:#FF0000; ">*</span><?php echo $msg2;?>&nbsp;<div id="required_cont_lastname" style="display:none;">*</div></td>
		<td id="input_cont_lastname_underline"><input name="cont_lastname" type="text" id="cont_lastname" size="20" value="<?php echo $row['cont_lastname'];?>"></td>
	  </tr>
	  <tr>
		<td id="label_cont_birthday_underline" class="label"><span style="color:#FF0000; ">*</span><?php echo $msg10;?>&nbsp;<div id="required_cont_birthday" style="display:none;">*</div></td>
		<?php 
		$birhtday='';
		if(isset($_POST[birthdayE])){
			$birthdate=$_POST[birthdayE];
		}
		elseif($row['cont_birthdate']){
			$birthdate=$row['cont_birthdate'];
		}
		else{
			$birthdate='';
		}
		?>
		<td id="input_cont_birthday_underline" value=""><?php echo escribe_formulario_fecha_vacio('cont_birthdate','forma',$birthdate);?></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
	  </tr>		 
	  <tr>
	  	<td nowrap id="title_cont_phone_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $tel_fijo;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_cont_phone_underline" class="label"><?php echo $msg6;?>&nbsp;<div id="required_cont_phone" style="display:none;">*</div></td>
		<td id="input_cont_phone_underline"><input name="cont_phone" type="text" id="cont_phone" size="20" value="<?php echo $row[cont_phone];?>"></td>
	  </tr>
	   <tr>
	  	<td nowrap id="title_cont_cell_phone_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $tel_movil;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_cont_cell_phone_underline" class="label"><?php echo $msg7;?>&nbsp;<div id="required_cont_cell_phone" style="display:none;">*</div></td>
		<td id="input_cont_cell_phone_underline"><input name="cont_cell_phone" type="text" id="cont_cell_phone" size="20" value="<?php echo $row[cont_cell_phone];?>"></td>
	  </tr>
	  <tr>
	  	<td nowrap id="title_cont_e_mail_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $email;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_cont_e_mail_underline" class="label"><span style="color:#FF0000; ">*</span><?php echo $msg8;?>&nbsp;<div id="required_cont_e_mail" style="display:none;">*</div></td>
		<td id="input_cont_e_mail_underline">
			<input name="cont_e_mail" type="text" id="cont_e_mail" size="20" value="<?php echo $row['cont_email'];?>">										
			<img name="help" src="<?php echo $img_dir;?>/help.png"  onmousemove="<?=$tt->show("<b>Por que necesitamos su Email?</b><br><br>Necesitamos su email para contactarlo.")?>">
		</td>	
	  </tr>
	  <tr>
		<td class="label"> <?php echo $msg3;?></td>
		<td><input name="cont_address" type="text" id="cont_address" size="30" value="<?php echo $row['cont_address'];?>"> <div id="required_cont_address" class="requridoerror">*</div></td>
	  </tr>
	  <tr>
	  	<td nowrap id="title_cont_postal_cd_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $zip;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_cont_postal_cd_underline" class="label"><span style="color:#FF0000; ">*</span><?php echo $msg4;?>&nbsp;<div id="required_cont_postal_cd" style="display:none;">*</div></td>
		<td id="input_cont_postal_cd_underline"><input name="cont_postal_cd" type="text" id="cont_postal_cd" size="10" value="<?php echo $row['cont_postal_cd'];?>"></td>
	  </tr>
	  <tr>
		<td class="label"> <?php echo $msg5;?></td>
		<td><input name="cont_town" type="text" id="cont_town" size="20" value="<?php echo $row['cont_town'];?>"> <div id="required_cont_town" class="requridoerror">*</div></td>
	  </tr>	
	 
	 <tr>
		<td id="label_cont_sex_cd_underline" class="label"><span style="color:#FF0000; ">*</span><?php echo $msg9;?>&nbsp;<div id="required_cont_sex_cd" style="display:none;">*</div></td>
		<td id="input_cont_sex_cd_underline">
			<select name="cont_sex_cd" id="cont_sex_cd" >
			<option value ="-1"><?php echo $msg23;?></option>'		
			<?php
			$r = $db->select($_sql1);
			while ($row1=$db->get_row($r, 'MYSQL_ASSOC')) {
				if($row1['sex_cd'] == $row['cont_sex_cd']){
					echo '<option value ="'.$row1['sex_cd'].'" selected>'.$row1['sex_nm'].'</option>';
				}else{
					echo '<option value ="'.$row1['sex_cd'].'">'.$row1['sex_nm'].'</option>';
				}
			}
				?>       
			</select>
		</td>
	  </tr>
	  
	 <!-- Checkbox Solo profesionales-->
	 <?php
	 $valor = $row['cont_prof_info'];
	 $usuario = $_SESSION[usuario_identificacion_sesion];

	 $_sql_x = "SELECT client.cli_act_cd as activity FROM client, users WHERE users.id_client= client.id_client AND users.user_current_flag = 1 AND client.id_client = $usuario AND client.cli_current_flag = 1 ";


	 $x = $db->select($_sql_x);
	 $row=$db->get_row($x, 'MYSQL_ASSOC');
	 
	 if($row[activity] != 'PAR')
	 {
	 	
	 	if($valor)
	 	{
	 		$checked = "checked";
	 	}
	 	else
	 	{
	 		$checked = "";
	 	}
	 ?>
	  <tr>
		<td class="subtitulo" colspan="2"><input name="info" type="checkbox" <?php echo $checked;?>/><?php echo $link;?></td>
	 </tr>
	 <?php
	 }
	 ?>
	 <!-- Fin Checkbox -->			  		 			 
	  <tr>
		<td colspan="2" align="left"><input name="edit" class="cssbutton" type="button" value="<?php echo "Editar";?>" onclick="validateMandatoryFields()"/></td>
	  </tr>			  
	</table>
</form>
<br><br><br>


