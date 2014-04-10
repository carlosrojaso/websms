<?php
/**
 * addUserInternal.php
 * 
 * Interfaz Ingresar posologia
 * @author Victor Manuel Vallecilla Mira<vallecilla@gmail.com> 
 * 		   Carlos A. Rojas<carlkant@gmail.com> 
 * @version 1.0
 * @package ui
 * @creacion: 22/09/2007
 * @license: GNU/GPL	
*/
//Comprobar la session
include_once('../../includes/session.inc');
check_login();

/*****************INTERNACIONALIZACION *************/
include_once('../../lang/prescription/ui/addPosology.php');

/***************************************************/

//Determinar el idioma en el cual se muestra la pagina

switch($_SESSION[idm]){
	case 'UK':
		$title=$title_en;
		$title2=$title2_en;
		$title3=$title3_en;		

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
		
		$btnlabel=$btnlabel_en;
		$btnlabel2=$btnlabel2_en;

		break;
}


include_once('../../includes/calendario/calendario.php');
include_once('../../includes/simplepage.class.php');

$obj = new simplepage();
$obj->setTitle($title);
$obj->setCSS("../../includes/style/style.css");
$obj->setJS("../../includes/calendario/javascripts.js");
$obj->setJS("../../includes/validate/prescription/validate_addPosology.js");

$_sql3="SELECT mea_med_tak_cd,mea_med_tak_nm FROM  measure_med_taking WHERE mea_med_tak_lang='".$_SESSION[idm]."'";
$_sql4="SELECT cod_moment,moment_nm, moment_def_hour FROM moment WHERE moment_lang='".$_SESSION[idm]."'";

echo $obj->getHeader();
$img_dir = "../../images";
require_once('../../data/db.class.php');
$db = new db_class();
if (!$db->connect()){
	$db->print_last_error(false);
}





?>
<br><br>

<form id="forma" action="" method="post" enctype="text/plain" name="forma" >
<table border="0" align="center" cellpadding="0" cellspacing="2" id="posology">
  
    <td valign="top"><table  border="0" cellpadding="0" cellspacing="1">
      <tr>
        <td><span class="label">Nombre del medicamento</span></td>
        <td colspan="2"><input name="textfield" type="text" size="20"></td>
      </tr>
      <tr>
      	<?php 
				$med_date_in='';
				if(isset($_POST[med_date_in])){
					$med_date_in=$_POST[med_date_in];
				}else{
					$med_date_in=date('Y/m/d');
				}
		?>
        <td class="label">Fecha de inicio</td>
        <td colspan="2"><?php echo escribe_formulario_fecha_vacio2('med_begin_date','forma',$med_date_in,'');?></td>
      </tr>
      <tr>
      	<?php 
				$med_date_out='';
				if(isset($_POST[med_date_out])){
					$med_date_out=$_POST[med_date_out];
				}else{
					$med_date_out=date('Y/m/d');
				}
		?>
        <td class="label">Fecha de fin</td>
        <td colspan="2"><?php echo escribe_formulario_fecha_vacio2('med_end_date','forma',$med_date_out,'');?></td>
      </tr>
      <tr>
        <td colspan="3" class="subtitulo">DIAS DE LA SEMANA</td>
      </tr>
      <tr>
        <td colspan="3" class="label">
          <table width="100%">
            <tr>
              <td><input name="all" type="checkbox" id="all" value="0" onClick="checkDays();" checked><?php echo $msg4;?></td>
			  <td><input name="day3" type="checkbox" id="day3" value="0" onClick="selectWeekDays(this);"><?php echo $msg5;?></td>
            </tr>
            <tr>
              <td><input name="day0" type="checkbox" id="day0" value="0" onClick="selectWeekDays(this);"><?php echo $msg6;?></td>
			  <td><input name="day4" type="checkbox" id="day4" value="0" onClick="selectWeekDays(this);"><?php echo $msg7;?></td>
            </tr>
            <tr>
              <td><input name="day1" type="checkbox" id="day1" value="0" onClick="selectWeekDays(this);"><?php echo $msg8;?></td>
			  <td><input name="day5" type="checkbox" id="day5" value="0" onClick="selectWeekDays(this);"><?php echo $msg9;?></td>
            </tr>
            <tr>
              <td><input name="day2" type="checkbox" id="day2" value="0" onClick="selectWeekDays(this);"><?php echo $msg10;?></td>                       
              <td><input name="day6" type="checkbox" id="day6" value="0" onClick="selectWeekDays(this);"><?php echo $msg11;?></td>
            </tr>
          </table>                      
        </tr>
        <tr>
              <td>&nbsp;</td>                       
              <td>&nbsp;</td>
            </tr>
      <tr>
        <td class="label">Tipo de toma del medicamento</td>
        <td colspan="2">
        	<select name="mea_med_tak_cd" id="mea_med_tak_cd">
        	<option value="-1"></option>
			<?php
			$r = $db->select($_sql3);
			while ($row=$db->get_row($r, 'MYSQL_ASSOC')) {
				echo '<option value ="'.$row['mea_med_tak_cd'].'">'.$row['mea_med_tak_nm'].'</option>';
			}?>
        	</select>
        </td>
	  </tr>		    
		<?php
		$r = $db->select($_sql4);
		while ($row=$db->get_row($r, 'MYSQL_ASSOC')) {			
		echo '<tr>
              <td>&nbsp;</td>                       
              <td>&nbsp;</td>
            </tr>';
		echo '
	      <tr>
	        <td class="label">Momento del dia</td>
	        <td colspan="2">'.$row['moment_nm'].'</td>
		  </tr>
	      <tr>
	        <td class="label">Cantidad</td>
	        <td colspan="2"><input name="" type="text" id="" value="0" size="20"></td>
	      </tr>
	      <tr>
	        <td class="label">Hora del dia</td>
	        <td><input name="" type="text" id="" size="20" value="'.$row['moment_def_hour'].'"></td>        
	      </tr>';
      echo '<tr>
              <td>&nbsp;</td>                       
              <td>&nbsp;</td>
            </tr>';
      }?>
    </td>
    </tr>
    <tr>
        <td class="label">&nbsp;</td>
        <td>&nbsp;</td>        
      </tr>    
    <tr>
    <td>
      <input name="next"   type="button" class="cssbutton" id="next" value="<?php echo $btnlabel;?>" onClick="return validate_MandatoryFields();">
      <input name="cancel"  type="button" class="cssbutton" id="cancel" value="<?php echo $btnlabel2;?>" onClick="cancelPrescription();">
    </td>
  </tr>  
	<input type="hidden" name="temp_id_contact" id="temp_id_contact" value="3" />
	<input type="hidden" name="temp_alert_type_cd" id="temp_alert_type_cd" value="<?php echo $_POST[alert_type_cd];?>" />
</table>
</form>
<br><br><br>

