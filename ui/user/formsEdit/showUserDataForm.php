<?php

$r_tipo_cliente = $db->select("select cli_act_grp_nm from client_activity where cli_act_cd='".$row['cli_act_cd']."' and cli_act_lang='SP'");
//echo $db->last_query."<br>";
$row_tipo_cliente=$db->get_row($r_tipo_cliente, 'MYSQL_ASSOC');
$tipo_cliente=$row_tipo_cliente[cli_act_grp_nm];
?>				
<br><br><br>
<form name="infor_user" method="POST" action="../../control/user/deleteUser.php?back_page=showUsers" id="infor_user">						
	<table cellpadding="0" cellspacing="0" border="0" width="60%" align="center">																
		<?php		
		$lastnames=explode(" ",$row[cli_lastname]);
		$lastname1=$lastnames[0];
		$lastname2=$lastnames[1];
		$_sql="SELECT sex_treatment FROM sex WHERE sex_cd='".$row[cli_sex_cd]."'";
		
		$rp = $db->select($_sql);
		$row_0=$db->get_row($rp, 'MYSQL_ASSOC');
		if(trim($tipo_cliente)=='Professional' or trim($tipo_cliente)=='Profesional'){
			echo '<tr>';
			echo '<td bgcolor="#FFFFFF" class="titulo" colspan="2" ><b>DATOS DEL TITULAR</b></td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td bgcolor="#DBEAF5" class="label">Tratamiento:</td>';
			echo '<td bgcolor="#DBEAF5" class="label">'.$row_0[sex_treatment].'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td bgcolor="#DBEAF5" class="label">Nombre:</td>';
			echo '<td bgcolor="#DBEAF5" class="label">'.$row[cli_firstname].'</td>';
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
			echo '<td bgcolor="#FFFFFF" class="titulo" colspan="2"><b>DATOS DE LA EMPRESA</b></td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td bgcolor="#DBEAF5" class="label">Raz&oacute;n Social:</td>';
			echo '<td bgcolor="#DBEAF5" class="label">'.$row[cli_company_nm].'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td bgcolor="#DBEAF5" class="label">Tel&eacute;fono Fijo Principal:</td>';
			echo '<td bgcolor="#DBEAF5" class="label">'.$row[cli_phone_num1].'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td bgcolor="#DBEAF5" class="label">Tel&eacute;fono Fijo Secundario:</td>';
			echo '<td bgcolor="#DBEAF5" class="label">'.$row[cli_phone_num2].'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td bgcolor="#DBEAF5" class="label">Tel&eacute;fono M&oacute;vil:</td>';
			echo '<td bgcolor="#DBEAF5" class="label">'.$row[cli_cell_phone].'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td bgcolor="#DBEAF5" class="label">Email:</td>';
			echo '<td bgcolor="#DBEAF5" class="label">'.$row[cli_e_mail].'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td bgcolor="#DBEAF5" class="label">Direcci&oacute;n:</td>';
			echo '<td bgcolor="#DBEAF5" class="label">'.$row[cli_address].'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td bgcolor="#DBEAF5" class="label">C&oacute;digo postal:</td>';
			echo '<td bgcolor="#DBEAF5" class="label">'.$row[cli_postal_cd].'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td bgcolor="#DBEAF5" class="label">Poblaci&oacute;n:</td>';
			echo '<td bgcolor="#DBEAF5" class="label">'.$row[cli_town].'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td bgcolor="#DBEAF5" class="label">CIF:</td>';
			echo '<td bgcolor="#DBEAF5" class="label">'.$row[cli_ident_num].'</td>';
			echo '</tr>';

		}elseif (trim($tipo_cliente)=='Particular'){
			$_sql="SELECT ident_type_nm FROM identification_doc_type WHERE ident_type_cd='".$row[cli_ident_type_cd]."' and ident_type_country='SP'";
			$rw = $db->select($_sql);
			$row_1=$db->get_row($rw, 'MYSQL_ASSOC');
			echo '<tr>';
			echo '<td bgcolor="#FFFFFF" class="titulo" colspan="2"><b>DATOS PERSONALES</b></td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td bgcolor="#DBEAF5" class="label">Tratamiento:</td>';
			echo '<td bgcolor="#DBEAF5" class="label">'.$row_0[sex_treatment].'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td bgcolor="#DBEAF5" class="label">Nombre:</td>';
			echo '<td bgcolor="#DBEAF5" class="label">'.$row[cli_firstname].'</td>';
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
			echo '<td bgcolor="#DBEAF5" class="label">Tipo identificaci&oacute;n:</td>';
			echo '<td bgcolor="#DBEAF5" class="label">'.$row_1[ident_type_nm].'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td bgcolor="#DBEAF5" class="label">N&uacute;mero del documento:</td>';
			echo '<td bgcolor="#DBEAF5" class="label">'.$row[cli_ident_num].'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td bgcolor="#DBEAF5" class="label">Fecha de nacimiento:</td>';
			echo '<td bgcolor="#DBEAF5" class="label">'.$row[cli_birthdate].'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td bgcolor="#FFFFFF" class="titulo" colspan="2"><b>DATOS DE CONTACTO</b></td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td bgcolor="#DBEAF5" class="label">Tel&eacute;fono Fijo:</td>';
			echo '<td bgcolor="#DBEAF5" class="label">'.$row[cli_phone_num1].'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td bgcolor="#DBEAF5" class="label">Tel&eacute;fono M&oacute;vil:</td>';
			echo '<td bgcolor="#DBEAF5" class="label">'.$row[cli_cell_phone].'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td bgcolor="#DBEAF5" class="label">Email:</td>';
			echo '<td bgcolor="#DBEAF5" class="label">'.$row[cli_e_mail].'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td bgcolor="#DBEAF5" class="label">Direcci&oacute;n:</td>';
			echo '<td bgcolor="#DBEAF5" class="label">'.$row[cli_address].'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td bgcolor="#DBEAF5" class="label">C&oacute;digo postal:</td>';
			echo '<td bgcolor="#DBEAF5" class="label">'.$row[cli_postal_cd].'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td bgcolor="#DBEAF5" class="label">Poblaci&oacute;n:</td>';
			echo '<td bgcolor="#DBEAF5" class="label">'.$row[cli_town].'</td>';
			echo '</tr>';

		}
		echo '<tr>';
		echo '<td bgcolor="#FFFFFF" class="titulo" colspan="2"><b>DATOS DE ACCESO</b></td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td bgcolor="#DBEAF5" class="label">Login:</td>';
		echo '<td bgcolor="#DBEAF5" class="label">'.$row[user_login].'</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td bgcolor="#FFFFFF" class="titulo" colspan="2"><b>DATOS ACTUALIZACI&Oacute;N</b></td>';
		echo '</tr>';
		echo '<tr>';		
		echo '<td bgcolor="#DBEAF5" class="label">Creado por:</td>';
		echo '<td bgcolor="#DBEAF5" class="label">'.$row[user_info_cre].'</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td bgcolor="#DBEAF5" class="label">Modificado por:</td>';
		echo '<td bgcolor="#DBEAF5" class="label">'.$row[user_info_upd].'</td>';
            echo '</tr>';
            echo '<tr>';
		echo '<td bgcolor="#DBEAF5" class="label">Fecha de ultima modificación:</td>';
		if($row[LAST_MODIFICATION]=='USUARIO'){$_mod=$row[user_date_mod];}else{$_mod=$row[cli_date_mod];}
		echo '<td bgcolor="#DBEAF5" class="label">'.$_mod.'</td>';
		echo '</tr>';	
		?>																											
</table><br>
	<table width="60%" align="center">
		<!--Bono activado-->
		<tr aling="right">
		<td>
		<input type="button" value="Modificar" class="cssbutton" onclick="location.href='../../control/user/searchUser.php?usuario=<?php echo $row[user_login];?>&par=2'">
		<?php 		
		if(trim($status)=='A' ){			
		?>	
		<input name="id_user" type="hidden" id="id_user" value="<?php echo $row['id_user']; ?>">
		<input name="id_client" type="hidden" id="id_client" value="<?php echo $row['id_client']; ?>">
		<input name="status" type="hidden" id="status" value="D">
		<input type="button" value="Desactivar" class="cssbutton" onclick="if(confirm('¿Está seguro que desea desactivar ese usuario?')){document.infor_user.submit();}else{history.back();}">
		
		<?php 
		}else{
		?>
		<input name="id_user" type="hidden" id="id_user" value="<?php echo $row['id_user']; ?>">
		<input name="id_client" type="hidden" id="id_client" value="<?php echo $row['id_client']; ?>">
		<input name="status" type="hidden" id="status" value="A">
		<input type="button" value="Activar" class="cssbutton" onclick="document.infor_user.submit()">
		<?php 
		}?>
		<input type="button" value="Volver" class="cssbutton" onclick="history.back()">	
		</td>
		</tr>		
	</table>		
</form>														
<br><br><br>
