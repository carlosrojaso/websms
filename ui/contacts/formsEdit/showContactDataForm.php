<?php

//$r_tipo_cliente = $db->select("select cli_act_grp_nm from client_activity where cli_act_cd='".$row['cli_act_cd']."' and cli_act_lang='SP'");
//$row_tipo_cliente=$db->get_row($r_tipo_cliente, 'MYSQL_ASSOC');
//$tipo_cliente=$row_tipo_cliente[cli_act_grp_nm];
?>				
<br><br><br>
<form name="infor_user" method="POST" action="../../control/user/deleteUser.php?back_page=showUsers" id="infor_user">						
	<table cellpadding="0" cellspacing="0" border="0" width="50%" align="center">																
		<?php		
		$lastnames=explode(" ",$row[cont_lastname]);
		$lastname1=$lastnames[0];
		$lastname2=$lastnames[1];
		
			echo '<tr>';
			echo '<td bgcolor="#FFFFFF" class="titulo" colspan="2" ><b>DATOS DEL CONTACTO</b></td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td bgcolor="#DBEAF5" class="label">Nombre:</td>';
			echo '<td bgcolor="#DBEAF5" class="label">'.$row[cont_firstname].'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td bgcolor="#DBEAF5" class="label">Primer Apellido:</td>';
			echo '<td bgcolor="#DBEAF5" class="label">'.$lastname1.'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td bgcolor="#DBEAF5" class="label">Segundo Apellido:</td>';
			echo '<td bgcolor="#DBEAF5" class="label">'.$lastname2.'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td bgcolor="#DBEAF5" class="label">Tel&eacute;fono Fijo:</td>';
			echo '<td bgcolor="#DBEAF5" class="label">'.$row[cont_phone].'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td bgcolor="#DBEAF5" class="label">Tel&eacute;fono M&oacute;vil:</td>';
			echo '<td bgcolor="#DBEAF5" class="label">'.$row[cont_cell_phone].'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td bgcolor="#DBEAF5" class="label">Email:</td>';
			echo '<td bgcolor="#DBEAF5" class="label">'.$row[cont_email].'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td bgcolor="#DBEAF5" class="label">Direcci&oacute;n:</td>';
			echo '<td bgcolor="#DBEAF5" class="label">'.$row[cont_address].'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td bgcolor="#DBEAF5" class="label">C&oacute;digo postal:</td>';
			echo '<td bgcolor="#DBEAF5" class="label">'.$row[cont_postal_cd].'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td bgcolor="#DBEAF5" class="label">Poblaci&oacute;n:</td>';
			echo '<td bgcolor="#DBEAF5" class="label">'.$row[cont_town].'</td>';
			echo '</tr>';
			
			//Sexo
			if($row[cont_sex_cd] == 'M'){
				$sexo = "HOMBRE";
			}
			else{
				$sexo = "MUJER";
			}
			
			echo '<tr>';
			echo '<td bgcolor="#DBEAF5" class="label">Sexo:</td>';
			echo '<td bgcolor="#DBEAF5" class="label">'.$sexo.'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td bgcolor="#DBEAF5" class="label">Fecha de Nacimiento:</td>';
			echo '<td bgcolor="#DBEAF5" class="label">'.$row[cont_birthdate].'</td>';
			echo '</tr>';
	
		?>																											
</table><br>
	<table width="50%" align="center">
		<td>
		<input type="button" value="Modificar" class="cssbutton" onclick="location.href='../../control/contacts/searchContact.php?id=<?php echo $row[id_contact];?>&par=2&edit=1'">
		<input type="button" value="Eliminar" class="cssbutton" onclick="location.href='../../control/contacts/delContact.php?id=<?php echo $row[id_contact];?>">	
		<input type="button" value="Volver" class="cssbutton" onclick="history.back()">
		</td>	
	</table>		
</form>														
<br><br><br>
