
<br><br><br>
<form name="infor_user" method="POST" action="../../control/user/deleteUser.php?back_page=showUsersInternals" id="infor_user">		
	<table align="center" cellpadding="0" cellspacing="0" border="0" width="60%">			
		<?php

		echo '<tr>';
		echo '<td bgcolor="#FFFFFF" class="titulo" colspan="2"><b>DATOS PERSONALES</b></td>';
		echo '</tr>';
		echo '<tr>';
		echo '<tr>';
		echo '<td bgcolor="#DBEAF5" class="label">Nombre:</td>';
		echo '<td bgcolor="#DBEAF5" class="label">'.$row[cli_firstname].'</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td bgcolor="#DBEAF5" class="label">Apellido:</td>';
		echo '<td bgcolor="#DBEAF5" class="label">'.$row[cli_lastname].'</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td bgcolor="#FFFFFF" class="titulo" colspan="2"><b>DATOS DE ACCESO</b></td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td bgcolor="#DBEAF5" class="label">Fecha de creación:</td>';
		echo '<td bgcolor="#DBEAF5" class="label">'.$row[user_date_req].'</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td bgcolor="#DBEAF5" class="label">Creado por:</td>';
		echo '<td bgcolor="#DBEAF5" class="label">'.$row[user_info_cre].'</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td bgcolor="#DBEAF5" class="label">Fecha de inicio de validez:</td>';
		echo '<td bgcolor="#DBEAF5" class="label">'.$row[user_date_in].'</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td bgcolor="#DBEAF5" class="label">Fecha de fin de validez:</td>';
		echo '<td bgcolor="#DBEAF5" class="label">'.$row[user_date_out].'</td>';
		echo '<tr>';
		echo '<td bgcolor="#DBEAF5" class="label">Fecha de ultima modificación:</td>';
		if($row[LAST_MODIFICATION]=='USUARIO'){$_mod=$row[user_date_mod];}else{$_mod=$row[cli_date_mod];}
		echo '<td bgcolor="#DBEAF5" class="label">'.$_mod.'</td>';
		echo '</tr>';	
		echo '<tr>';
		echo '<td bgcolor="#DBEAF5" class="label">Modificado por:</td>';
		echo '<td bgcolor="#DBEAF5" class="label">'.$row[user_info_upd].'</td>';
		echo '</tr>';	
		echo '<tr>';
		echo '<td bgcolor="#DBEAF5" class="label">Perfil:</td>';
		echo '<td bgcolor="#DBEAF5" class="label">'.$row[user_prof_nm].'</td>';
		echo '</tr>';		
		echo '<tr>';
		echo '<td bgcolor="#DBEAF5" class="label">Login:</td>';
		echo '<td bgcolor="#DBEAF5" class="label">'.$row[user_login].'</td>';
		echo '</tr>';		
	?>
	</table><br>
	<table width="60%" align="center">
		<!--Bono activado-->
		<tr aling="right">
		<td>
		<input type="button" value="Modificar" class="cssbutton" onclick="location.href='../../control/user/searchUserInternals.php?usuario=<?php echo $row[user_login];?>&par=2'">
		<?php 

		if($row[user_date_out]!='Indefinida'){
			$valid_arr = split(' ',$row[user_date_out]);
			$valid_up = $valid_arr[0];
			//echo $valid_up."<br>";
			$fromdate = new DateCK($valid_up,"-");
			$todate = new DateCK(date('Y-m-d'),"-");
			$compareStatus = $fromdate->comparedates($todate);
			//echo 'Compare status: '.$compareStatus.'<br>';
		}else{$compareStatus=-1;}
		if(trim($status)=='A'){
		?>	
		<input name="id_user" type="hidden" id="id_user" value="<?php echo $row['id_user']; ?>">
		<input name="id_client" type="hidden" id="id_client" value="<?php echo $row['id_client']; ?>">
		<input name="status" type="hidden" id="status" value="D">
		<input type="button" value="Desactivar" class="cssbutton" onclick="if(confirm('¿Está seguro que desea desactivar ese usuario?')){document.infor_user.submit();}else{history.back();}">
		
		<?php 
		}elseif(trim($status)=='D' && $compareStatus==-1){
		?>
		<input name="id_user" type="hidden" id="id_user" value="<?php echo $row['id_user']; ?>">
		<input name="id_client" type="hidden" id="id_client" value="<?php echo $row['id_client']; ?>">
		<input name="status" type="hidden" id="status" value="A">
		<input type="button" value="Activar" class="cssbutton" onclick="document.infor_user.submit()">
		<?php }?>
		<input type="button" value="Volver" class="cssbutton" onclick="history.back()">
		</td>
		</tr>		
	</table>
</form>	
<br><br><br>

