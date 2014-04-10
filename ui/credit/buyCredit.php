<?php
/*
* Created on 01/02/2008
* Created by Victor Manuel Vallecilla
* Name of File: buyCredit.php
*
*/
//Comprobar la session
include_once('../../includes/session.inc');
check_login();
/***INTERNACIONALIZACION****/
include_once('../../lang/credit/ui/buyCredit.php');
/***************************/

include_once('../../includes/simplepage.class.php');

$obj = new simplepage();
$obj->setTitle($title);
$obj->setCSS("../../includes/style/style.css");
$obj->setCSS("../../includes/menu.css");

//Determinar el idioma en el cual se muestra la pagina
switch($_SESSION[idm]){
	case 'UK':
		$title=$title_en;		
		$cont_0=$cont_0_en;
		$cont_1=$cont_1_en;		
		$cont_2=$cont_2_en;				
		break;
}
// Conectamos con la DB
require_once('../../data/db.class.php');
$db = new db_class;
if (!$db->connect()){
	$db->print_last_error(false);
}
//numero de clientes por bono segun la actividad
$_sql_0="SELECT COUNT(p.id_client) FROM client c JOIN purchase p ON p.id_client=c.id_client JOIN users u ON u.id_client=c.id_client WHERE cli_current_flag=1 AND user_current_flag=1 AND user_status_cd='A' and cli_act_cd=(SELECT cli_act_cd FROM client WHERE id_client=".$_SESSION[usuario_identificacion_sesion]." AND cli_current_flag=1) GROUP BY cli_act_cd";
//echo "<br>".$_sql_0."<br>";

$_sql = "SELECT  id_credit, credit_nm, credit_price FROM credit WHERE credit_begin_date <= NOW() AND NOW() <= IFNULL(credit_end_date,NOW()) AND credit_status_cd='A' AND credit_cli_act_cd=(SELECT cli_act_cd FROM client WHERE id_client=".$_SESSION[cliente_identificacion_sesion]." AND cli_current_flag=1) AND credit_publish_flag=1 AND IFNULL((".$_sql_0."),0) < IFNULL(credit_max_cli,99999999999999)";

$_sql_1 = "SELECT id_credit, credit_nm, credit_price FROM credit WHERE credit_begin_date <= NOW() AND NOW() <= IFNULL(credit_end_date,NOW())  AND credit_status_cd='A' AND credit_cli_act_cd='ALL' AND credit_publish_flag=1";
//echo "<br>".$_sql." UNION ".$_sql_1."<br>";

$r = $db->select($_sql." UNION ".$_sql_1);

echo $obj->getHeader();
?>	
<br><br><br>
<table width="70%"  border="0" cellspacing="1" align="center">
	<tr>
		<td colspan="3" align="center" class="subtitulo"><b><?php echo $head_title;?></b></td>		
	</tr>
	<tr>
		<td colspan="3" align="center" class="titulo">&nbsp;</td>		
	</tr>
	<tr>
		<td class="titulo"><b><?php echo $title;?></b></td>
		<td class="titulo"><b><?php echo $title2;?></b></td>
		<td class="titulo"><b>&nbsp;</b></td>
	</tr>
	<?php	
	while($credit=$db->get_row($r, 'MYSQL_ASSOC')){		
		echo '<tr>';					
			echo '<td>';
				echo $credit['credit_nm'];
			echo '</td>';			
			echo '<td>';
				echo $credit['credit_price'];
			echo '</td>';
			echo '<td>';
				echo '<input name="credit" id="credit" type="radio" value ="'.$credit['id_credit'].'" onclick="">';
			echo '</td>';
		echo '</tr>';		
	}
	?>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>		
		<td><input type="submit" value="<?php echo $btnlabel;?>" class="cssbutton"></td>		
	</tr>		
</table>
<br><br><br>
<?php echo $obj->getFooter();?>
