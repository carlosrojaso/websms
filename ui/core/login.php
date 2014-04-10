<?php
/*
* Created on 20/08/2007
* Created by Carlos A. Rojas
* Name of File: login.php
* Description: Es la interfaz de inicio de session de la aplicacion.
*
* CHANGELOG
* 06/09/2007:
* - Se agrego los mensajes en Ingles.
* - Se coloco una interfaz simple.
*
* 15/09/2007:
* - Los mensajes se colocaron en el archivo ../../lang/ui.core.login.php
*/
include_once('../../includes/simplepage.class.php'); // archivo que contiene partes comunes de las interfaces

/*****INTERNACIONALIZACION******/
include_once('../../lang/core/ui/login.php'); 
/*******************************/

$obj = new simplepage();

$obj->setCSS("../../includes/style/style.css");
$obj->setJS("../../includes/validate/core/validate_userLogin.js");


echo $obj->getHeader();
$img_dir = "../../images";

if($_GET[deact]==true){
	echo
	'
	<table align="center">
		<tr>
			<td><h3>
				<h3>Su cuenta Onspot ha sido desactivada. Onspot le agradece por….(por definir???</h3>
				</h3>
			</td>
		</tr>		
	</table>
	';
}
?>
<br><br><br>
<br><br><br>

<form action="../../control/core/login.php" method="post" name="forma" id="forma">
	<table cellpadding="0" cellspacing="0" border="0" width="300" align="center" id="addUser_professional">
		<tr>
		  <td align="left" class="head" colspan="3" ><?php echo $head;?></td>
		</tr> 
		<tr>
			<td align="left" class="celdas1" colspan="3" ><?php echo $maintxt;?></td>
		</tr>
		<tr>
			<td class="celdas1">&nbsp;<?php echo $txt1;?></td>
			<td class="celdas1"><input type="text" name="login_user_login" id="login_user_login" title="<?php echo $msg1;?>" class="required formas" alt="<?php echo $exclam1;?>" size="20" maxlength="15"></td>
		</tr>
		<tr>
			<td class="celdas1">&nbsp;<?php echo $txt2;?><br/><br/></td>
			<td class="celdas1"><input type="password" name="login_user_pass" id="login_user_pass" title="<?php echo $msg2;?>" class="required formas" alt="<?php echo $exclam2; ?>" size="20" maxlength="10"><br/><br/></td>
		</tr>
		<tr>
			<td align="center" class="celdas1" colspan="2"><input type="button" value="<?php echo $button;?>" onclick="validate_privateAreaAcces()"><br/><br/></td>
		</tr>
		<tr>
			<td align="center" class="celdas2" colspan="2"><?php echo $forget;?></td>
		</tr>
    </table>
</form>
<br>
<div align="center">
	<?php echo $register; ?>
</div>
<br><br><br>
<?php echo $obj->getFooter();?>