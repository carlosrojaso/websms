<?php
/**
 * editBonusDataForm.php
 * 
 * Interfaz Editar Bono
 * @author Victor Manuel Vallecilla Mira<vallecilla@gmail.com> 
 * 		   Carlos A. Rojas<carlkant@gmail.com> 
 * @version 1.0
 * @package ui
 * @creacion: 02/01/2008
 * @license: GNU/GPL	
*/

//$_sql="SELECT cli_act_grp_nm,cli_act_grp_cd FROM client_activity WHERE cli_act_lang='".$_SESSION[idm]."' GROUP BY cli_act_grp_nm,cli_act_grp_cd";
$_sql="SELECT cli_act_nm,cli_act_cd FROM client_activity WHERE cli_act_lang='".$_SESSION[idm]."' GROUP BY cli_act_nm,cli_act_cd";
//echo $_sql;
?>
<br><br>

<form name='forma' id='forma' method='post' action='../../control/credit/editBonus.php' >
	<table width="50%" border="0" align="center" cellpadding="0" cellspacing="1" id="editBonus">	  
			  <tr>
				<td class="subtitulo"><?php echo $title3;?></td>
			  </tr>
			   <tr>
			  	<td nowrap id="title_credit_cd_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $codigo;?></td>			  	
			  </tr>
			  <tr>
				<td id="label_credit_cd_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg1;?>&nbsp;<div id="required_credit_cd" style="display:none;">*</div></td>
				<td id="input_credit_cd_underline"><input name="credit_cd" type="text" id="credit_cd" size="20" value="<?php if(isset($_POST[credit_cdE])){echo $_POST[credit_cdE];}else{echo $row[credit_cd];}?>" <?php if($status=='A'){echo "READONLY";}?>></td>
			  </tr>
			  <tr>
			  	<td nowrap id="title_credit_nm_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $nombre;?></td>			  	
			  </tr>
			  <tr>
				<td id="label_credit_nm_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg2;?>&nbsp;<div id="required_credit_nm" style="display:none;">*</div></td>
				<td id="input_credit_nm_underline"><input name="credit_nm" type="text" id="credit_nm" size="20" value="<?php if(isset($_POST[credit_nmE])){echo $_POST[credit_nmE];}else{echo $row[credit_nm];}?>" <?php if($status=='A'){echo "READONLY";}?>></td>
			  </tr>			  	  	
			 <tr>
			  	<td nowrap id="title_credit_dsc_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $descripcion;?></td>			  	
			  </tr>
			  <tr>
				<td id="label_credit_dsc_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg3;?>&nbsp;<div id="required_credit_dsc" style="display:none;">*</div></td>
				<td id="input_credit_dsc_underline">
					<input name="credit_dsc" type="text" id="credit_dsc" size="20" value="<?php if(isset($_POST[credit_dscE])){echo $_POST[credit_dscE];}else{echo $row[credit_dsc];}?>" <?php if($status=='A'){echo "READONLY";}?>>															
				</td>	
			  </tr>
			  <tr>
			  	<td nowrap id="title_credit_num_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $numero_creditos;?></td>			  	
			  </tr>
			  <tr>
				<td id="label_credit_num_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg4;?>&nbsp;<div id="required_credit_num" style="display:none;">*</div></td>
				<td id="input_credit_num_underline">
					<input name="credit_num" type="text" id="credit_num" size="20" value="<?php if(isset($_POST[credit_numE])){echo $_POST[credit_numE];}else{echo $row[credit_num];}?>" <?php if($status=='A'){echo "READONLY";}?>>
				</td>
			  </tr>	
			  <tr>
			  	<td nowrap id="title_credit_price_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $precio;?></td>			  	
			  </tr>
			  <tr>
				<td id="label_credit_price_underline" class="label"><span style="color:#FF0000;">*</span><?php echo $msg5;?>&nbsp;<div id="required_credit_price" style="display:none;">*</div></td>
				<td id="input_credit_price">
					<input name="credit_price" type="text" id="credit_price" size="20" value="<?php if(isset($_POST[credit_priceE])){echo $_POST[credit_priceE];}else{echo $row[credit_price];}?>" <?php if($status=='A'){echo "READONLY";}?>>
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
					$credit_begin_date=str_replace("-", "/", substr($row[credit_begin_date], 0, 10));
				}
				?>
				<td id="input_credit_begin_date_underline"><?php if($status=='A'){echo escribe_formulario_fecha_vacio4('credit_begin_date','forma',$credit_begin_date,'');}else{echo escribe_formulario_fecha_vacio2('credit_begin_date','forma',$credit_begin_date,'');}?></td>
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
					$credit_end_date=str_replace("-", "/", substr($row[credit_end_date], 0, 10));;
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
					<?php if($status=='A'){
						echo '<input type="hidden" value ="'.$row['credit_cli_act_cd'].'" id="credit_cli_act_cd" name="credit_cli_act_cd" >';
						$r = $db->select($_sql);
						while ($row1=$db->get_row($r, 'MYSQL_ASSOC')) {
							if($_POST[credit_cli_act_cdE]==$row1[cli_act_cd] || $row[credit_cli_act_cd]==$row1[cli_act_cd]){
								echo '<input type="text" value ="'.$row1['cli_act_nm'].'" id="credit_cli_act_cd_tx" name="credit_cli_act_cd_tx" READONLY>';								
							}
						}
						
					}else{ ?>
					<select name="credit_cli_act_cd" id="credit_cli_act_cd" >		
						<option value ="-1"></option>											
						<?php
						$r = $db->select($_sql);
						while ($row1=$db->get_row($r, 'MYSQL_ASSOC')) {
							if($_POST[credit_cli_act_cdE]==$row1[cli_act_cd] || $row[credit_cli_act_cd]==$row1[cli_act_cd]){
								echo '<option value ="'.$row1['cli_act_cd'].'" selected>'.$row1['cli_act_nm'].'</option>';
							}else{
								echo '<option value ="'.$row1['cli_act_cd'].'">'.$row1['cli_act_nm'].'</option>';
							}
						}
					}
					echo "</select>";
						?>        
					
				</td>
			  </tr>			   
			  <tr>
				<td class="label"><span style="color:#FF0000;">*</span><?php echo $msg9;?></td>
				<td>
				<?php if($status=='A'){ ?>
					<input type="text"  name="credit_free_flag_" id="credit_free_flag_" onclick="setFreeBonus(this)"  <?php if($row[credit_free_flag]==0)echo "value=\"No\"";else echo "value=\"Si\"";?> READONLY>					
				<?php }else{?>
					<input class='required'  name="credit_free_flag_" type="radio" id="credit_free_flag_" onclick="setFreeBonus(this)" value="0" <?php if($row[credit_free_flag]==0)echo "checked";?> >No
					&nbsp;
					<input class='required'  name="credit_free_flag_" type="radio" id="credit_free_flag_" onclick="setFreeBonus(this)" value="1" <?php if($row[credit_free_flag]==1)echo "checked";?>>Si
				<?php }?>
				</td>
			  </tr>
			  <tr>
			  	<td nowrap id="title_credit_max_cli_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;<?php echo $maximo_clientes;?></td>			  	
			  </tr>	
			  <tr>
			  	<td id="label_credit_max_cli_underline" class="label"><?php echo $msg10;?>&nbsp;<input type="checkbox" name="cre_max_cli" id="cre_max_cli" onclick="showLayer(this,'credit_max_cli','block')" <?php if($row[credit_max_cli]>0) echo "checked";?>/><div id="required_credit_max_cli" style="display:none;">*</div></td></td>
			  	<td id="input_credit_max_cli_underline"><input style="display:<?php if($row[credit_max_cli]>0) echo "block"; else echo "none";?>;" type="text" name="credit_max_cli" id="credit_max_cli" value="<?php echo $row[credit_max_cli];?>" size="20" <?php if($status=='A'){echo "READONLY";}?>></td>
			  </tr>						  			  			  			  			  	
		
		</td>		
	  <tr>		  	
		<td colspan="2" align="right"><br><input type="button" class="cssbutton" value="<?php echo $btnlabel;?>" id="submitForm" onclick="validateMandatoryFields()"></td>		
	  </tr>
	</table>
	<input type="hidden" id="credit_free_flag" name="credit_free_flag" <?php if($row[credit_free_flag]==0)echo "value=\"0\"";else echo "value=\"1\"";?>>	
	<input type="hidden" id="credit_date_in" name="credit_date_in" value="<?php echo $row[credit_date_in];?>">
	<input type="hidden" id="credit_publish_flag" name="credit_publish_flag" value="<?php echo $row[credit_publish_flag];?>">
	<input type="hidden" id="credit_status_cd" name="credit_status_cd" value="<?php echo $row[credit_status_cd];?>">
	<input type="hidden" id="credit_cre_user_id" name="credit_cre_user_id" value="<?php echo $row[credit_cre_user_id];?>">
	<input type="hidden" id="id_credit" name="id_credit" value="<?php echo $row[id_credit];?>">
</form>
<br><br>
<?php echo $obj->getFooter();?>