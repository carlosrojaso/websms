<br><br><br>
	
<form name="infor_bonus" method="POST" action="../../control/credit/deleteBonus.php?back_page=showBonus" id="infor_bonus">		
	<table align="center" cellpadding="0" cellspacing="0" border="0" width="60%">			
		<?php

		echo '<tr>';
		echo '<td bgcolor="#FFFFFF" class="titulo" colspan="2"><b>DATOS DEL BONO</b></td>';
		echo '</tr>';
		echo '<tr>';
		echo '<tr>';
		echo '<td bgcolor="#DBEAF5" class="label">C&oacute;digo:</td>';
		echo '<td bgcolor="#DBEAF5" class="label">'.$row[credit_cd].'</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td bgcolor="#DBEAF5" class="label">Nombre:</td>';
		echo '<td bgcolor="#DBEAF5" class="label">'.$row[credit_nm].'</td>';
		echo '</tr>';		
		echo '<tr>';
		echo '<td bgcolor="#DBEAF5" class="label">Descripci&oacute;n:</td>';
		echo '<td bgcolor="#DBEAF5" class="label">'.$row[credit_dsc].'</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td bgcolor="#DBEAF5" class="label">Fecha de creaci&oacute;n:</td>';
		echo '<td bgcolor="#DBEAF5" class="label">'.$row[credit_date_in].'</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td bgcolor="#DBEAF5" class="label">Creado por:</td>';
		$_user_mod="SELECT CONCAT(cli_firstname,' ',cli_lastname) AS name FROM client JOIN users ON client.id_client=users.id_client WHERE users.id_client=".$row[credit_cre_user_id];				
		$_f=$db->select($_user_mod);
		$fila=$db->get_row($_f, 'MYSQL_ASSOC');
		echo '<td bgcolor="#DBEAF5" class="label">'.$fila[name].'</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td bgcolor="#DBEAF5" class="label">Fecha de inicio de validez:</td>';
		echo '<td bgcolor="#DBEAF5" class="label">'.$row[credit_begin_date].'</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td bgcolor="#DBEAF5" class="label">Fecha de fin de validez:</td>';
		echo '<td bgcolor="#DBEAF5" class="label">'.$row[credit_end_date].'</td>';
		echo '<tr>';
		echo '<td bgcolor="#DBEAF5" class="label">Fecha de ultima modificación:</td>';		
		echo '<td bgcolor="#DBEAF5" class="label">'.$row[credit_date_mod].'</td>';
		echo '</tr>';	
		echo '<tr>';
		echo '<td bgcolor="#DBEAF5" class="label">Modificado por:</td>';		
		$_user_mod="SELECT CONCAT(cli_firstname,' ',cli_lastname) AS name FROM client JOIN users ON client.id_client=users.id_client WHERE users.id_client=".$row[credit_mod_user_id];				
		$_f=$db->select($_user_mod);
		$fila=$db->get_row($_f, 'MYSQL_ASSOC');
		echo '<td bgcolor="#DBEAF5" class="label">'.$fila[name].'</td>';
		echo '</tr>';	
		echo '<tr>';
		echo '<td bgcolor="#DBEAF5" class="label">N&uacute;mero de cr&eacute;ditos:</td>';
		echo '<td bgcolor="#DBEAF5" class="label">'.$row[credit_num].'</td>';
		echo '</tr>';		
		echo '<tr>';
		echo '<td bgcolor="#DBEAF5" class="label">Valor:</td>';
		echo '<td bgcolor="#DBEAF5" class="label">'.$row[credit_price].'</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td bgcolor="#DBEAF5" class="label">Tipo de usuario:</td>';
		$_cli_act="SELECT cli_act_nm FROM client_activity WHERE cli_act_cd='".$row[credit_cli_act_cd]."'";						
		$_f=$db->select($_cli_act);
		$fila=$db->get_row($_f, 'MYSQL_ASSOC');
		echo '<td bgcolor="#DBEAF5" class="label">'.$fila[cli_act_nm].'</td>';
		echo '</tr>';	
		echo '<tr>';
		echo '<td bgcolor="#DBEAF5" class="label">Gratuito para cada nuevo usuario:</td>';
		echo '<td bgcolor="#DBEAF5" class="label">'.($row[credit_free_flag]==1?"Si":"No").'</td>';
		echo '<tr>';
		echo '<td bgcolor="#DBEAF5" class="label">N&uacute;mero m&aacute;ximo de clientes para el bono:</td>';
		echo '<td bgcolor="#DBEAF5" class="label">'.$row[credit_max_cli].'</td>';
		echo '</tr>';	
		echo '</tr>';			
	?>
	
	</table><br>
	<table width="60%" align="center">
		<!--Bono activado-->
		<tr aling="right">
		<td>
		<?php 
			$valid_arr = split(' ',$row[credit_begin_date]);
			$valid_up = $valid_arr[0];
			
			$_begin_date = new DateCK($valid_up,"-");
			$_actual_date = new DateCK(date('Y-m-d'),"-");
			//echo $valid_up."<br>".date('Y-m-d');
			$compareStatus = $_begin_date->comparedates($_actual_date);
			//echo $compareStatus."<br>";
			if($compareStatus>=0  && $status=="A"){		
				echo '<input type="button" value="Modificar" class="cssbutton" onclick="location.href=\'../../control/credit/searchBonus.php?credito='.$row[id_credit].'&par=2&status=A\'">';
		 	}elseif($compareStatus==-1 && $status=="P"){
		 		echo '<input type="button" value="Modificar"  class="cssbutton" onclick="location.href=\'../../control/credit/searchBonus.php?credito='.$row[id_credit].'&par=2&status=P\'">';
		 		echo '<input type="button" value="Desactivar" class="cssbutton" onclick="document.getElementById(\'credit_status_cd\').value=\'C\'; if(confirm(\'¿Está seguro que desea desactivar ese bono?\')){document.infor_bonus.submit();}">';
		 		echo '<input type="button" value="Suprimir"   class="cssbutton" onclick="document.getElementById(\'credit_status_cd\').value=\'F\'; if(confirm(\'¿Está seguro que desea suprimir ese bono?\')){document.infor_bonus.submit();}">';
		 		echo '<input type="hidden" value="'.$row[id_credit].'" name="id_credit" id="id_credit">';
		 		echo '<input type="hidden" value="" name="credit_status_cd" id="credit_status_cd">';
		 	}elseif($status=="C"){
		 		echo '<input type="button" value="Modificar"  class="cssbutton" onclick="location.href=\'../../control/credit/searchBonus.php?credito='.$row[id_credit].'&par=2&status=C\'">';
		 		echo '<input type="button" value="Activar" class="cssbutton" onclick="document.infor_bonus.submit();">';
		 		echo '<input type="hidden" value="'.$row[id_credit].'" name="id_credit" id="id_credit">';
		 		echo '<input type="hidden" value="A" name="credit_status_cd" id="credit_status_cd">';		 	
		 	}
		 ?>			
		<input type="button" value="Volver" class="cssbutton" onclick="history.back()">
		</td>
		</tr>		
	</table>
</form>	
<br><br><br>

