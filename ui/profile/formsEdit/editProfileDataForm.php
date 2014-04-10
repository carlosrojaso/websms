<?php


/**
 * editProfileDataFom.php
 * 
 * Interfaz modificar un perfil
 * @author Victor Manuel Vallecilla Mira<vallecilla@gmail.com> 
 * 		   Carlos A. Rojas<carlkant@gmail.com> 
 * @version 1.0
 * @package control
 * @creacion: 22/09/2007
 * @license: GNU/GPL	
*/
//Comprobar la session

$_sql = "SELECT user_prof_group_nm,user_prof_group_cd FROM user_profile WHERE user_prof_lang='" . $_SESSION[idm] . "' GROUP BY user_prof_group_nm,user_prof_group_cd";
?>
<br><br>
<form name='forma' id='forma' method='post' action='../../control/profile/addProfile.php' >
	<table width="50%" border="0" align="center" cellpadding="0" cellspacing="1" id="addUserInternal">
		<tr>
			<td colspan="2" class="subtitulo">INFORMACI&Oacute;N DEL PERFIL</td>
 		</tr>
		<tr>
			<td nowrap id="title_user_prof_nm_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;Por favor informe el nombre</td>			  	
		</tr>
		<tr>
			<td id="label_user_prof_nm_underline" class="label"><span style="color:#FF0000; ">*</span>Nombre del perfil&nbsp;<div id="required_user_prof_nm" style="display:none;">*</div></td>
			<td id="input_user_prof_nm_underline"><input name="user_prof_nm" type="text" id="user_prof_nm" size="20" value="<?php if(isset($_POST[user_prof_nmE])){echo $_POST[user_prof_nmE];}else{echo $row[user_prof_nm];} ?>" ></td>
		</tr>			 
		<tr>
			<td nowrap id="title_user_prof_group_cd_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;Seleccione el grupo de usuarios para el perfil</td>			  	
		</tr>
		<tr>
			<td id="label_user_prof_group_cd_underline" class="label"><span style="color:#FF0000; ">*</span>Grupo de usuarios&nbsp;<div id="required_user_prof_group_cd" style="display:none;">*</div></td>
			<td id="input_user_prof_group_cd_underline">
				<select name="user_prof_group_cd" id="user_prof_group_cd" >
					<option value ="-1">Grupo de usuarios</option>'		
					<?php
						$r = $db->select($_sql);
						while ($row_grupo = $db->get_row($r, 'MYSQL_ASSOC')) {
							if (isset ($_POST[user_prof_group_cdE]) && $_POST[user_prof_group_cdE] == $row_grupo[user_prof_group_cd] || $row_grupo[user_prof_group_cd] == $row[user_prof_group_cd]) {
								echo '<option value ="' . $row_grupo['user_prof_group_cd'] .'" selected>' . $row_grupo['user_prof_group_cd'] . '</option>';
							} else {
								echo '<option value ="' . $row_grupo['user_prof_group_cd'] .'">' . $row_grupo['user_prof_group_cd'] . '</option>';
							}
						}
					?>       
				</select>
			</td>
		</tr>
		<tr>
			<td nowrap id="title_module_selection_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;Por favor seleccione los modulos para el perfil</td>			  	
		</tr>			  
		<tr>
			<td id="label_module_selection_underline" class="label"><span style="color:#FF0000; ">*</span>Seleccione los modulos para el nuevo perfil<div id="required_module_selection" style="display:none;">*</div></td>
		</tr>	
		<tr>
			<td id="input_module_selection_underline" colspan="2">
			<?php
				$_sql = "	
				SELECT 
					m.name,
					m.mname,
					m.module_cd,
					CASE n.user_prof_cd WHEN '" . $_GET[perfil] . "' THEN 'CHECKED' ELSE '' END AS 'CHECK'
				FROM
					(SELECT 
						module.module_option_nm as name,
						module.module_nm as mname,
						module.module_cd as module_cd
					FROM 
						module WHERE module.module_lang='SP' 
					GROUP BY 
						module.module_url,
						module.module_option_nm,
						module.module_nm,
						module.module_cd
					ORDER BY 
						module_ord) AS m
				LEFT JOIN
					(SELECT 	
						module.module_cd AS module_cd,
						user_profile.user_prof_cd AS user_prof_cd
												
					FROM 
						rel_prof_module 
							LEFT JOIN module AS module ON rel_prof_module.module_cd=module.module_cd 
							LEFT JOIN user_profile ON rel_prof_module.user_prof_cd=user_profile.user_prof_cd
					WHERE 
						user_profile.user_prof_cd='" . $_GET[perfil] . "' AND
						user_profile.user_prof_current_flag=1 AND
						rel_prof_module.prof_mod_current_flag=1
						
					GROUP BY 		
						user_profile.user_prof_cd,
						module.module_cd
					ORDER BY 
						module_ord) AS n
				ON m.module_cd=n.module_cd";
				//echo $_sql;
				$modules = $db->select($_sql);
				
				$actual = $rmodules = $db->get_row($modules, 'MYSQL_ASSOC');
				$siguiente = $rmodules = $db->get_row($modules, 'MYSQL_ASSOC');
				
				$i = 0;
				
				if ($actual) {
					$tab[] = array (
						"id" => 0,
						"text" => "Modulos",
						"id_father" => -1
					);
					$tab[] = array (
						"id" => $father = ++ $i,
						"text" => $actual[mname],
						"id_father" => 0
					);
					$tab[] = array (
						"id" => ++ $i,
						"text" => strtolower($actual[name]
					) .
					'&' . $actual[module_cd] .
					'&' . $actual[CHECK], "id_father" => $father);
					while ($siguiente) {
						if ($actual[mname] != $siguiente[mname]) {
							$tab[] = array (
								"id" => $father = ++ $i,
								"text" => $siguiente[mname],
								"id_father" => 0
							);
						}
						$actual = $siguiente;
				
						$tab[] = array (
							"id" => ++ $i,
							"text" => strtolower($actual[name]
						) .
						'&' . $actual[module_cd] .
						'&' . $actual[CHECK], "id_father" => $father);
				
						$siguiente = $rmodules = $db->get_row($modules, 'MYSQL_ASSOC');
				
					}
				}
				
				// tree in text mode
				$tree = new tree($tab, "id", "text", "id_father", "../../includes/tree/img", "graphic");
				
				// transform the linear tab to the tab ordered in tree order
				$tree->transform($tree->get_idroot());
				
				if ($target_id != -1) { // expand tree to $expand_id node id if $expand_id is "set"
					if ($_GET[node] == 'expand') { //abrir
						$tree->expand($target_id);
					}
					elseif ($_GET[node] == 'collapse') { //cerrar
						$tree->collapse($target_id);
					}
				}
				
				echo "<table border='0' cellspacing='0' cellpadding='0' id='module_selection'>\n";
				for ($y = 0; $y < $tree->height(); $y = $tree->get_next_line_tree($y)) {
					echo "  <tr>\n";
					echo "    <td height=16><font size=2>\n      ";
					// the $a part is the static part of tree
					// the $b part is the last part of the tree, the part which looks like + or - in windows looking tree
					// the $c part is the text of the node
					// the $d part is the id of the node
					list ($a, $b, $c, $d) = $tree->get_line_display($y);
					$text_all = explode('&', $c);
				
					$text = $text_all[0];
				
					$module_cd = $text_all[1];
				
					$checked = $text_all[2];
				
					$user_pof_cd = $text_all[3];
				
					echo $a;
				
					if ($tree->tree_tab[$y]["symbol"] == "plus") // if node is "+" => expand it						
						echo "$b";
					else
						if ($tree->tree_tab[$y]["symbol"] == "moins") // if node is "-" => expand to father							
							echo "$b";
						else // else the node have static tree
							echo $b;
					echo $text;
					if ($tree->get_idroot() != $y) {
				
						if (count($tree->get_list_children($y)) > 0) {
							if (isset ($_POST[$module_cd])) {
								echo '<input id="module_' . $y . '" name="module_' . $y . '" type="checkbox" checked value="' . $module_cd . '" onclick="selectAllChildren(' . count($tree->get_list_children($y)) . ',' . $y . ')" >';
							} else {
								echo '<input id="module_' . $y . '" name="module_' . $y . '" type="checkbox" value="' . $module_cd . '" onclick="selectAllChildren(' . count($tree->get_list_children($y)) . ',' . $y . ')" >';
							}
						} else {
							if (isset ($_POST[$module_cd]) or $checked == 'CHECKED') {
								echo '<input id="module_' . $y . '" name="module_' . $y . '" type="checkbox" checked value="' . $module_cd . '" >';
							} else {
								echo '<input id="module_' . $y . '" name="module_' . $y . '" type="checkbox" value="' . $module_cd . '" >';
							}
						}
					}
				
					echo "\n    </font></td>\n";
					echo "  </tr>\n";
				}
				
				echo "</table>\n";
				echo '<input type="hidden" value="' . ($tree->height() - 1) . '" id="check_size" name="check_size">';
			?>
			</td>
		</tr>		 			  		  			 			
		<?php
			$valid_arr = split(' ', $row[inicio_val]);
			$valid_since = $valid_arr[0];
			//echo date('Y-m-d').' '.$valid_since;
			$fromdate = new DateCK($valid_since, "-");
			$todate = new DateCK(date('Y-m-d'), "-");
			$compareStatus = $fromdate->comparedates($todate);
			if ($compareStatus == -1 || $row[user_prof_status]=='D') {
		?>	
	<tr>
		<td nowrap id="title_user_prof_date_in_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;Por favor informe la fecha de inicio de validez del usuario(Superior a la del dia de hoy)</td>			  	
	</tr>		
	<tr>	
		<td nowrap id="label_user_prof_date_in_underline" class="label"><span style="color:#FF0000; ">*</span>Fecha de inicio de validez&nbsp;<div id="required_user_prof_date_in" style="display:none;">*</div></td>
		<?php
			if (isset ($_POST[user_prof_date_inE])) {
				$d_in = $_POST[user_prof_date_inE];
			} else {
				$d_in = str_replace("-", "/", substr($row[inicio_val], 0, 10));
			}
		?>		
		<td id="input_user_prof_date_in_underline"><?php echo escribe_formulario_fecha_vacio('user_prof_date_in','forma',$d_in,'');?></td>
	</tr>
	<?php }?>			 
	<tr>
		<td nowrap id="title_user_prof_date_out_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;La fecha de fin de validez debe ser superior a la fecha de inicio.</td>			  	
	</tr>		
	<tr>
		<td nowrap id="label_user_prof_date_out_underline" class="label">Fecha fin de validez&nbsp;<div id="required_user_prof_date_out" style="display:none;">*</div></td>
		<?php
			if (isset ($_POST[user_date_outE])) {
				$d_out = $_POST[user_date_outE];
			} else {
				$d_out = str_replace("-", "/", substr($row[fin_val], 0, 10));
			}
		?>
		<td id="input_user_prof_date_out_underline"><?php echo escribe_formulario_fecha_vacio('user_prof_date_out','forma',$d_out,'');?> </td>
	 </tr>	 
	</table>
	<br>
	<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>			
			<input name="user_prof_cd" type="hidden" id="user_prof_cd" value="<?php echo $row['user_prof_cd']; ?>">
			<input name="user_prof_cre" type="hidden" id="user_prof_cre" value="<?php echo $row['creado_por']; ?>">
			<input name="user_prof_status" type="hidden" id="user_prof_status" value="<?php echo $row['user_prof_status']; ?>">
			<?php if ($compareStatus != -1 || $row[user_prof_status]!='D') {?>
			<input name="user_prof_date_in" type="hidden" id="user_prof_date_in" value="<?php echo $row['inicio_val']; ?>">
			<?php }?>
	  		<td align="right"><input class="cssbutton" type="button" value="Modificar" onclick="return validateMandatoryFields();"></td>	  		
	  	</tr>
	</table>
</form>
<br><br><br>
<?php

?>
