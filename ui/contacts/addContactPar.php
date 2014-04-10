<?php
/**
 * addContactPar.php
 * 
 * UI agrega contacto particular.
 * 
 * @author Carlos A. Rojas <carlkant@gmail.com>
 * @version 1.0
 * @package 
 * @creacion: 01/08/2007
 * @license: 	
*/
include_once('../../includes/session.inc');
//check_login();

/**Generador de Tooltip*/
// include the JavaScript tooltip generator class
require_once('../../includes/tooltips/class.tooltips.php');

// instantiate the class
$tt = new tooltips();

/**Fin generador de Tooltip*/

/***********INTERNACIONALIZACION *********/
include_once('../../lang/contact/ui/addContactPar.php');
include_once('../../lang/contact/ui/addContactPar_errorMessage.php');
/******************************/

include_once('../../includes/calendario/calendario.php');
include_once('../../includes/simplepage.class.php');

$obj = new simplepage();
$obj->setTitle($title);
$obj->setCSS("../../includes/style/style.css");
$obj->setJS("../../includes/validate/contacts/addContactPar.js");
$obj->setJS("../../includes/calendario/javascripts.js");



$_sql1="SELECT sex_cd , sex_nm FROM  sex WHERE sex_lang ='".$_SESSION[idm]."'";

echo $obj->getHeader();
$img_dir = "../../images";
require_once('../../data/db.class.php');
$db = new db_class();
if (!$db->connect())
$db->print_last_error(false);





$tt->fadeInDelay = 50;
$tt->fadeOutDelay = 200;
$tt->offsetX=0;
$tt->offsetY=0;
$tt->init();

?>
<br><br>
<form name='forma' id='forma' method='post' action='../../control/contacts/addContactPar.php' >
	<table width="50%" border="0" align="center" cellpadding="0" cellspacing="1" id="addContact">	  			 
	  <tr>
		<td colspan="2" class="subtitulo"><?php echo $title;?></td>
	  </tr>			  
	  
	  <tr>
	  	<td nowrap id="title_cont_firstname_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $nombre;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_cont_firstname_underline" class="label"><span style="color:#FF0000; ">*</span><?php echo $msg1;?>&nbsp;<div id="required_cont_firstname" style="display:none;">*</div></td>
		<td id="input_cont_firstname_underline"><input name="cont_firstname" type="text" id="cont_firstname" size="20" value="<?php if(isset($_POST[cont_firstnameE])){echo $_POST[cont_firstnameE];}?>"></td>
	  </tr>			  			  
	  <tr>
	  	<td nowrap id="title_cont_lastname_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $apellido;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_cont_lastname_underline" class="label"><span style="color:#FF0000; ">*</span><?php echo $msg2;?>&nbsp;<div id="required_cont_lastname" style="display:none;">*</div></td>
		<td id="input_cont_lastname_underline"><input name="cont_lastname" type="text" id="cont_lastname" size="20" value="<?php if(isset($_POST[cont_lastnameE])){echo $_POST[cont_lastnameE];}?>"></td>
	  </tr>			  			   
	  <tr>
		<td id="label_cont_birthdate_underline" class="label"><?php echo $msg10;?></td>
		<?php 
		$birhtdate='';
		if(isset($_POST[cont_birthdateE])){
			$birhtdate=$_POST[cont_birthdateE];
		}else{
			$birhtdate='';
		}
		?>
		<td id="input_birthday_underline"><?php echo escribe_formulario_fecha_vacio('cont_birthdate','forma',$birhtdate);?></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
	  </tr>		 
	  <tr>
	  	<td nowrap id="title_cont_phone_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $tel_fijo;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_cont_phone_underline" class="label"><?php echo $msg6;?>&nbsp;<div id="required_cont_phone" style="display:none;">*</div></td>
		<td id="input_cont_phone_underline"><input name="cont_phone" type="text" id="cont_phone" size="20" value="<?php if(isset($_POST[cont_phoneE])){echo $_POST[cont_phoneE];}?>"></td>
	  </tr>
	   <tr>
	  	<td nowrap id="title_cont_cell_phone_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $tel_movil;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_cont_cell_phone_underline" class="label"><?php echo $msg7;?>&nbsp;<div id="required_cont_cell_phone" style="display:none;">*</div></td>
		<td id="input_cont_cell_phone_underline"><input name="cont_cell_phone" type="text" id="cont_cell_phone" size="20" value="<?php if(isset($_POST[cont_cell_phoneE])){echo $_POST[cont_cell_phoneE];}?>"></td>
	  </tr>
	  <tr>
	  	<td nowrap id="title_cont_e_mail_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $email;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_cont_e_mail_underline" class="label"><?php echo $msg8;?>&nbsp;<div id="required_cont_e_mail" style="display:none;">*</div></td>
		<td id="input_cont_e_mail_underline">
			<input name="cont_e_mail" type="text" id="cont_e_mail" size="20" value="<?php if(isset($_POST[cont_e_mailE])){echo $_POST[cont_e_mailE];}?>">										
			<img name="help" src="<?php echo $img_dir;?>/help.png"  onmousemove="<?=$tt->show("<b>Por que necesitamos su Email?</b><br><br>Necesitamos su email para contactarlo.")?>">
		</td>	
	  </tr>
	  <tr>
		<td class="label"> <?php echo $msg3;?></td>
		<td><input name="cont_address" type="text" id="cont_address" size="30" value="<?php if(isset($_POST[cont_addressE])){echo $_POST[cont_addressE];}?>"> <div id="required_cont_address" class="requridoerror">*</div></td>
	  </tr>
	  <tr>
	  	<td nowrap id="title_cont_postal_cd_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $zip;?></td>			  	
	  </tr>
	  <tr>
		<td id="label_cont_postal_cd_underline" class="label"><span style="color:#FF0000; ">*</span><?php echo $msg4;?>&nbsp;<div id="required_cont_postal_cd" style="display:none;">*</div></td>
		<td id="input_cont_postal_cd_underline"><input name="cont_postal_cd" type="text" id="cont_postal_cd" size="10" value="<?php if(isset($_POST[cont_postal_cdE])){echo $_POST[cont_postal_cdE];}?>"></td>
	  </tr>
	  <tr>
		<td class="label"> <?php echo $msg5;?></td>
		<td><input name="cont_town" type="text" id="cont_town" size="20" value="<?php if(isset($_POST[cont_townE])){echo $_POST[cont_townE];}?>"> <div id="required_cont_town" class="requridoerror">*</div></td>
	  </tr>	
	 <tr>
	  	<td nowrap id="title_cont_sex_cd_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $sexo;?></td>			  	
	  </tr>
	 <tr>
		<td id="label_cont_sex_cd_underline" class="label"><span style="color:#FF0000; ">*</span><?php echo $msg9;?>&nbsp;<div id="required_cont_sex_cd" style="display:none;">*</div></td>
		<td id="input_cont_sex_cd_underline">
			<select name="cont_sex_cd" id="cont_sex_cd" >
			<option value ="-1"></option>'		
			<?php
			$r = $db->select($_sql1);
			while ($row=$db->get_row($r, 'MYSQL_ASSOC')) {
				if(isset($_POST[cli_sex_cdE]) && $_POST[cli_sex_cdE]==$row[sex_cd]){
					echo '<option value ="'.$row['sex_cd'].'" selected>'.$row['sex_nm'].'</option>';
				}else{
					echo '<option value ="'.$row['sex_cd'].'">'.$row['sex_nm'].'</option>';
				}
			}
				?>       
			</select>
		</td>
	  </tr>			  		 			 
	  <tr>
		<td colspan="2"><hr></td>
	  </tr>
	  <tr>
		<td><input name="rec" type="button" class="cssbutton" value="<?php echo $btnlabel;?>" onclick="validateMandatoryFields()"/></td>
	  </tr>			  		
	</table> 
</form>
<br><br><br>
<?php echo $obj->getFooter(); ?>

