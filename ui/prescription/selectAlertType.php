<?php
/**
 * selectAlertType.php
 * 
 * Seleccion de tipo de alerta
 * @author Victor Manuel Vallecilla Mira<vallecilla@gmail.com> 
 * @version 1.0
 * @package ui
 * @creacion: 21/05/2007
 * @license: GNU/GPL	
*/
//Comprobar la session
include_once('../../includes/session.inc');
//check_login();

/*****************INTERNACIONALIZACION *************/
include_once('../../lang/prescription/ui/selectAlertType.php');
/***************************************************/

//Determinar el idioma en el cual se muestra la pagina
if($_SESSION[idm]){
	$lang=$_SESSION[idm];
	switch($_SESSION[idm]){
		case 'UK':
			$title=$title_en;
			$title2=$title2_en;
			$title3=$title3_en;

			$btnlabel=$btnlabel_en;		
			
			break;

	}
}else{
	$lang=$_GET[lang];
}

include_once('../../includes/simplepage.class.php');

$obj = new simplepage();
$obj->setTitle($title);
$obj->setCSS("../../includes/style/style.css");
$obj->setJS("../../includes/validate/prescription/validate_selectAlertType.js");

$_sql="SELECT alert_type_cd,alert_type_nm FROM alert_type WHERE alert_type_lang='".$lang."'";
//echo $_sql;
echo $obj->getHeader();
$img_dir = "../../images";
require_once('../../data/db.class.php');
$db = new db_class();
if (!$db->connect()){
	$db->print_last_error(false);
}

?>
<br><br><br><br>
<form name="forma" method="post" action="../../ui/prescription/addPosology.php">	
	<table width="300" border="0" align="center" cellpadding="0" cellspacing="0" id="selectAlertType">  		  													
		<tr>
			<td class="titulo"><b><?php echo $title3;?></b></td>
			<td>&nbsp;</td>  
		</tr>	
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>  
		</tr>																	
			<?php
			$r = $db->select($_sql);
			$i=0;
			while ($row=$db->get_row($r, 'MYSQL_ASSOC')) {
				echo '<tr>';					
					echo '<td>';
						echo '<input id="alert_type_'.$i.'" name="alert_type_'.$i.'" type="checkbox" value ="'.$row['alert_type_cd'].'">'.$row['alert_type_nm'];
					echo '</td>';
				echo '</tr>';
				$i++;
			}?>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>  
		</tr>																	
		<tr>			
			<td>
				<input id="next" name="next" type="button" class="cssbutton" value="<?php echo $btnlabel;?>" onclick="return validateMandatoryFields()">						 
				<input id="cancel" name="cancel" type="button" class="cssbutton" value="<?php echo $btnlabel2;?>" onclick="cancelPrescription()">
			</td>
		</tr>													  		  		 
	</table>	 
	<input type="hidden" name="temp_id_contact" id="temp_id_contact" value="3" />  
	<input type="hidden" name="alert_type_cant" id="alert_type_cant" value="<?php echo $i;?>" />   
</form>