<?php
/*
* Created on 01/02/2008
* Created by Victor Manuel Vallecilla
* Name of File: showCredit.php
*
*/
//Comprobar la session
include_once('../../includes/session.inc');
check_login();
/***INTERNACIONALIZACION****/
include_once('../../lang/credit/ui/showCredit.php');
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

$_sql = "SELECT not_consumed_credit, planned_credit, free_credit FROM actual_planned_credit WHERE id_client="."$_SESSION[cliente_identificacion_sesion]";
$r = $db->select($_sql);

?>	
<br><br><br>
<table width="70%"  border="0" cellspacing="1" align="center">	
	<tr>
		<td class="titulo"><b><?php echo $title;?></b></td>		
	</tr>
	<?php
	//while($credit=$db->get_row($r, 'MYSQL_ASSOC')){		
		$credit=$db->get_row($r, 'MYSQL_ASSOC');
		echo '<tr>' .
			'<td ><a href="">'.$cont_0.'</a></td>' .
			'<td >'.$credit[planned_credit].'</td>' .						
		'</tr>';
		echo '<tr>' .
			'<td ><a href="">'.$cont_1.'</a></td>' .
			'<td >'.$credit[free_credit].'</td>' .
		'</tr>';
		echo '<tr>' .
			'<td ><a href="">'.$cont_2.'</a></td>' .
			'<td >'.$credit[not_consumed_credit].'</td>' .
		'</tr>';		
	//}
	?>			
</table>