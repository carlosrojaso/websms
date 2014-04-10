								
<br><br><br>
<form name="infor_user" method="POST" action="../../control/profile/deleteProfile.php?back_page=showProfiles" id="infor_profile">						
	<table cellpadding="0" cellspacing="0" border="0" width="60%" align="center">																
		<?php				
				echo '<tr>';
				echo '<td bgcolor="#FFFFFF" class="titulo" colspan="2" ><b>DATOS DEL PERFIL</b></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td bgcolor="#DBEAF5" class="label">Fecha de creación:</td>';
				echo '<td bgcolor="#DBEAF5" class="label">' . $row[fecha_cre] . '</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td bgcolor="#DBEAF5" class="label">Creado por:</td>';
				echo '<td bgcolor="#DBEAF5" class="label">' . $row[creado_por] . '</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td bgcolor="#DBEAF5" class="label">Fecha de inicio de validez:</td>';
				echo '<td bgcolor="#DBEAF5" class="label">' . $row[inicio_val] . '</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td bgcolor="#DBEAF5" class="label">Fecha de fin de validez:</td>';
				echo '<td bgcolor="#DBEAF5" class="label">' . $row[fin_val] . '</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td bgcolor="#DBEAF5" class="label">Fecha de última modificación:</td>';
				echo '<td bgcolor="#DBEAF5" class="label">' . $row[ult_mod] . '</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td bgcolor="#DBEAF5" class="label">Modificado por:</td>';
				echo '<td bgcolor="#DBEAF5" class="label">' . $row[modif_por] . '</td>';
				echo '</tr>';

				echo '<tr>';
				echo '<td bgcolor="#FFFFFF" class="titulo" colspan="2"><b>Listado de usuarios que tienen el perfil</b></td>';
				echo '</tr>';
				echo '<tr>';
				while ($row_list_usr = $db->get_row($r1, 'MYSQL_ASSOC')) {
					echo '<tr>';
					echo '<td bgcolor="#DBEAF5" class="label">' . $row_list_usr[nombre] . '</td>';
					echo '<td bgcolor="#DBEAF5" class="label">' . $row_list_usr[user_login] . '</td>';
					echo '</tr>';
				}
?>																											
</table><br>
	<table width="60%" align="center">
		<!--Bono activado-->
		<tr aling="right">
		<td>
		<input type="button" value="Modificar" class="cssbutton" onclick="location.href='../../control/profile/searchProfile.php?perfil=<?php echo $perfil;?>&par=2'">
		<?php				
				

				if ($row[fin_val] != 'Indefinida') {
					$valid_arr = split(' ', $row[fin_val]);
					$valid_up = $valid_arr[0];
					//echo date('Y-m-d').' '.$valid_since;
					$fromdate = new DateCK($valid_up, "-");
					$todate = new DateCK(date('Y-m-d'), "-");
					//echo $valid_up . 'compare' . date('Y-m-d');
					$compareStatus = $fromdate->comparedates($todate);
					//echo 'Compare status: '.$compareStatus.'<br>';
				} else {
					$compareStatus = -1;
				}
				//echo $status . ' =' . $compareStatus;
				if (trim($status) == 'A') {
?>	
		<input name="user_prof_cd" type="hidden" id="user_prof_cd" value="<?php echo $row['user_prof_cd']; ?>">	
		<input name="status" type="hidden" id="status" value="D">
		<input type="button" value="Desactivar" class="cssbutton" onclick="if(confirm('¿Está seguro que desea desactivar ese usuario?')){document.infor_user.submit();}else{history.back();}">
		
		<?php				
				
				}
				elseif (trim($status) == 'D' && $compareStatus == -1) {
?>
		<input name="user_prof_cd" type="hidden" id="user_prof_cd" value="<?php echo $row['user_prof_cd']; ?>">		
		<input name="status" type="hidden" id="status" value="A">
		<input type="button" value="Activar" class="cssbutton" onclick="document.infor_user.submit()">
		<?php }?>
		
		<input type="button" value="Volver" class="cssbutton" onclick="history.back()">	
		</td>
		</tr>		
	</table>	
</form>														
<br><br><br>
				