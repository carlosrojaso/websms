<?php
/**
 * addUserInternal.php
 * 
 * Interfaz Ingresar Bono
 * @author Victor Manuel Vallecilla Mira<vallecilla@gmail.com> 
 * 		   Carlos A. Rojas<carlkant@gmail.com> 
 * @version 1.0
 * @package ui
 * @creacion: 02/01/2008
 * @license: GNU/GPL	
*/
//Comprobar la session
include_once('../../includes/session.inc');
check_login();

/*****************INTERNACIONALIZACION *************/
include_once('../../lang/credit/ui/addBonus.php');
include_once('../../lang/credit/ui/errorMessage.php');
/***************************************************/

//Determinar el idioma en el cual se muestra la pagina

include_once('../../includes/calendario/calendario.php');
include_once('../../includes/simplepage.class.php');

$obj = new simplepage();
$obj->setTitle($title);
$obj->setCSS("../../includes/style/style.css");
$obj->setJS("../../includes/calendario/javascripts.js");
$obj->setJS("../../includes/validate/credit/validate_addBonus.js");

echo $obj->getHeader();
$img_dir = "../../images";
require_once('../../data/db.class.php');
$db = new db_class();
if (!$db->connect()){
	$db->print_last_error(false);
}

//$_sql="SELECT cli_act_grp_nm,cli_act_grp_cd FROM client_activity WHERE cli_act_lang='".$_SESSION[idm]."' GROUP BY cli_act_grp_nm,cli_act_grp_cd";
$_sql="SELECT cli_act_nm,cli_act_cd FROM client_activity WHERE cli_act_lang='".$_SESSION[idm]."' GROUP BY cli_act_nm,cli_act_cd";
//echo $_sql;
?>
<br><br>

<form name='forma' id='forma' method='post' action='../../control/credit/addBonus.php' >
	<table width="50%" border="0" align="center" cellpadding="0" cellspacing="1" id="addBonus">	  
			  <tr>
				<td class="subtitulo"><?php echo $title3;?></td>
			  </tr>
			   <tr>
			  	<td nowrap id="title_credit_cd_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $codigo;?></td>			  	
			  </tr>
			  <tr>
				<td id="label_credit_cd_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg1;?>&nbsp;<div id="required_credit_cd" style="display:none;">*</div></td>
				<td id="input_credit_cd_underline"><input name="credit_cd" type="text" id="credit_cd" size="20" value="<?php if(isset($_POST[credit_cdE])){echo $_POST[credit_cdE];}?>"></td>
			  </tr>
			  <tr>
			  	<td nowrap id="title_credit_nm_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $nombre;?></td>			  	
			  </tr>
			  <tr>
				<td id="label_credit_nm_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg2;?>&nbsp;<div id="required_credit_nm" style="display:none;">*</div></td>
				<td id="input_credit_nm_underline"><input name="credit_nm" type="text" id="credit_nm" size="20" value="<?php if(isset($_POST[credit_nmE])){echo $_POST[credit_nmE];}?>"></td>
			  </tr>			  	  	
			 <tr>
			  	<td nowrap id="title_credit_dsc_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $descripcion;?></td>			  	
			  </tr>
			  <tr>
				<td id="label_credit_dsc_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg3;?>&nbsp;<div id="required_credit_dsc" style="display:none;">*</div></td>
				<td id="input_credit_dsc_underline">
					<input name="credit_dsc" type="text" id="credit_dsc" size="20" value="<?php if(isset($_POST[credit_dscE])){echo $_POST[credit_dscE];}?>">															
				</td>	
			  </tr>
			  <tr>
			  	<td nowrap id="title_credit_num_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $numero_creditos;?></td>			  	
			  </tr>
			  <tr>
				<td id="label_credit_num_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg4;?>&nbsp;<div id="required_credit_num" style="display:none;">*</div></td>
				<td id="input_credit_num_underline">
					<input name="credit_num" type="text" id="credit_num" size="20" value="<?php if(isset($_POST[credit_numE])){echo $_POST[credit_numE];}?>">
				</td>
			  </tr>	
			  <tr>
			  	<td nowrap id="title_credit_price_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $precio;?></td>			  	
			  </tr>
			  <tr>
				<td id="label_credit_price_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg5;?>&nbsp;<div id="required_credit_price" style="display:none;">*</div></td>
				<td id="input_credit_price">
					<input name="credit_price" type="text" id="credit_price" size="20" value="<?php if(isset($_POST[credit_priceE])){echo $_POST[credit_priceE];}?>">
				</td>
			  </tr>	  	   	 			  			  
			   <tr>
			  	<td nowrap id="title_credit_begin_date_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $fecha_inicio;?></td>			  	
			  </tr>		
			  <tr>
				<td nowrap id="label_credit_begin_date_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg6;?>&nbsp;<div id="required_credit_begin_date" style="display:none;">*</div></td>
				<?php 
				$credit_begin_date='';
				if(isset($_POST[credit_begin_date])){
					$credit_begin_date=$_POST[credit_begin_date];
				}else{
					$credit_begin_date=date('Y/m/d');
				}
				?>
				<td id="input_credit_begin_date_underline"><?php echo escribe_formulario_fecha_vacio2('credit_begin_date','forma',$credit_begin_date,'');?></td>
			  </tr>
			   <tr>
			  	<td nowrap id="title_credit_end_date_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $fecha_fin;?></td>			  	
			  </tr>		
			  <tr>
				<td nowrap id="label_credit_end_date_underline" class="label"><?php echo $msg7;?>&nbsp;<div id="required_credit_end_date" style="display:none;">*</div></td>
				<?php 
				$credit_end_date='';
				if(isset($_POST[credit_end_date])){
					$credit_end_date=$_POST[credit_end_date];
				}else{
					$credit_end_date='';
				}
				?>
				<td id="input_credit_end_date_underline"><?php echo escribe_formulario_fecha_vacio2('credit_end_date','forma',$credit_end_date,'');?> <div id="required_credit_end_date" class="requridoerror">*</div></td>
			  </tr>
			  <tr>
			  	<td nowrap id="title_credit_cli_act_cd_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $tipo_usuario;?></td>			  	
			  </tr>			 
			  <tr>
				<td id="label_credit_cli_act_cd_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg8;?>&nbsp;<div id="required_credit_cli_act_cd" style="display:none;">*</div></td>
				<td id="input_credit_cli_act_cd_underline">
					<select name="credit_cli_act_cd" id="credit_cli_act_cd">		
						<option value ="-1"></option>'											
						<?php
						$r = $db->select($_sql);
						while ($row=$db->get_row($r, 'MYSQL_ASSOC')) {
							if(isset($_POST[credit_cli_act_cdE]) && $_POST[credit_cli_act_cdE]==$row[cli_act_cd]){
								echo '<option value ="'.$row['cli_act_cd'].'" selected>'.$row['cli_act_nm'].'</option>';
							}else{
								echo '<option value ="'.$row['cli_act_cd'].'">'.$row['cli_act_nm'].'</option>';
							}
						}
						?>        
					</select>
				</td>
			  </tr>			   
			  <tr>
				<td class="label"><span style="color:#FF0000;">*</span><?php echo $msg9;?></td>
				<td>
					<input class='required'  name="credit_free_flag_" type="radio" id="credit_free_flag_" onclick="setFreeBonus(this)" value="0" checked >No
					&nbsp;
					<input class='required'  name="credit_free_flag_" type="radio" id="credit_free_flag_" onclick="setFreeBonus(this)" value="1" >Si
				</td>
			  </tr>
			  <tr>
			  	<td nowrap id="title_credit_max_cli_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $maximo_clientes;?></td>			  	
			  </tr>	
			  <tr>
			  	<td id="label_credit_max_cli_underline" class="label"><?php echo $msg10;?>&nbsp;<input type="checkbox" name="cre_max_cli" id="cre_max_cli" onclick="showLayer(this,'credit_max_cli','block')"/><div id="required_credit_max_cli" style="display:none;">*</div></td></td>
			  	<td id="input_credit_max_cli_underline"><input style="display:none;" type="text" name="credit_max_cli" id="credit_max_cli" value="" size="20"></td>
			  </tr>						  			  			  			  			  	
		
		</td>		
	  <tr>		  	
		<td colspan="2" align="right"><br><input type="button" class="cssbutton" value="<?php echo $btnlabel;?>" id="submitForm" onclick="validateMandatoryFields()"></td>		
	  </tr>
	</table>
	<input type="hidden" id="credit_free_flag" name="credit_free_flag" value="0">	
</form>
<br><br>
<?php echo $obj->getFooter();?>