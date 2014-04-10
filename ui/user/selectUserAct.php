<?php
/**
 * selectUserAct.php
 * 
 * Seleccion de actividad
 * @author Victor Manuel Vallecilla Mira<vallecilla@gmail.com> 
 * @version 1.0
 * @package ui
 * @creacion: 21/05/2007
 * @license: GNU/GPL	
*/
//Comprobar la session
include_once('../../includes/session.inc');
//check_login();

/*****************INTERNACIONALIZACION *************/
include_once('../../lang/user/ui/selectUserAct.php');
/***************************************************/

//Determinar el idioma en el cual se muestra la pagina
if($_SESSION[idm]){
	$lang=$_SESSION[idm];
	switch($_SESSION[idm]){
		case 'UK':
			$title=$title_en;
			$title2=$title2_en;
			$title3=$title3_en;

			$btnlabel=$btnlabel_en;		
			
			break;

	}
}else{
	$lang=$_GET[lang];
}

include_once('../../includes/simplepage.class.php');

$obj = new simplepage();
$obj->setTitle($title);
$obj->setCSS("../../includes/style/style.css");

$_sql="SELECT cli_act_cd,cli_act_nm FROM client_activity WHERE cli_act_lang='".$lang."' AND cli_act_cd<>'ALL'";
//echo $_sql;
echo $obj->getHeader();
$img_dir = "../../images";
require_once('../../data/db.class.php');
$db = new db_class();
if (!$db->connect()){
	$db->print_last_error(false);
}

?>
<br><br><br><br>
<form name="forma" method="post" action="../../control/user/selectUserAct.php">	
	<table width="300" border="0" align="center" cellpadding="0" cellspacing="0" id="selectUserAct">
  		  <tr>
			<td height="20">&nbsp;</td>
			<td height="20" colspan="2" class="titulo"><b><?php echo $title2;?></b></td>
			<td height="20">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="20" >&nbsp;</td>			
			<td colspan="2">
				<table width="100%" cellspacing="0" border="0" cellpadding="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td
					</tr>
					<tr>
						<td class="label"><?php echo $title3;?></td>  
						<td>
							<select name="cli_act_nm" class="label" id="cli_act_nm">
								<?php
								$r = $db->select($_sql);
								while ($row=$db->get_row($r, 'MYSQL_ASSOC')) {
									echo '<option value ="'.$row['cli_act_cd'].'">'.$row['cli_act_nm'].'</option>';
								}?>
							</select>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td
					</tr>
					<tr>						
						<td><input id="next" name="next" type="submit" class="cssbutton" value="<?php echo $btnlabel;?>">						 
					</tr>
					<tr>
						<td><input type="hidden" name="lang" id="lang" value="<?php echo $lang;?>"></td>
					</tr>
				</table>
			</td>
			<td width="20" >&nbsp;</td>
		  </tr>		  		  
		  <tr>
			<td width="20" height="20" >&nbsp;</td>
			<td height="20" colspan="2" align="center" >&nbsp;</td>
			<td width="20" height="20" >&nbsp;</td>
		  </tr>
	</table>
</form>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php
echo $obj->getFooter();
?>