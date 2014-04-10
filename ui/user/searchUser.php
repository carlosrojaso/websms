<?php
/**
 * searchUser.php
 * 
 * Interfaz buscar Cliente
 * @author Carlos A. Rojas <carlkant@gmail.com> 
 * @version 1.0
 * @package package_name
 * @creacion: 21/05/2007
 * @license: GNU/GPL	
*/
include_once('../../includes/session.inc');
//check_login();

/******INTERNACIONALIZACION*******/
include_once('../../lang/user/ui/searchUser.php');
/*************/

//Determinar el idioma en el cual se muestra la pagina

switch($_SESSION[idm]){
	case 'UK':
		$title=$title_en;
		$title2=$title2_en;		

		$msg1=$msg1_en;
		$msg2=$msg2_en;
		$msg3=$msg3_en;
		$msg4=$msg4_en;
		
		break;
}



?>
<script>
function searchOption(field,nofield1,nofield2){

	document.getElementById(field).value=1;
	document.getElementById(nofield1).checked=false;
	document.getElementById(nofield2).checked=false;
	
}
</script>

<form name="form1" method="post" action="../../ui/user/showUsers.php?search=true">
	<div class="titulo"><?php echo $title2;?></div>	
	<table width="100%" border="0" cellpadding="0" cellspacing="5">							
		<tr>
		  <td class="label" rowspan="3">
		  	<label><input type="radio" value="-1" id="login"    name="login" onclick="searchOption('login','name','lastname')"><?php echo $msg1;?><br></label>
		  	<label><input type="radio" value="-1" id="name"     name="name" onclick="searchOption('name','login','lastname')"><?php echo $msg2;?><br></label>
		  	<label><input type="radio" value="-1" id="lastname" name="lastname" onclick="searchOption('lastname','login','name')"><?php echo $msg3;?></label>
		  </td>	  
		</tr>	
		<tr>	 
		  <td><input name="criteria" type="text" size="20" value=""></td>	  
		</tr>			
		<tr>
			<td><input name="search" type="submit" id="search" value="<?php echo $msg4;?>" class="cssbutton"></td>
		</tr>
	</table>		
	<input type="hidden" name="par" value="1">
</form>	

