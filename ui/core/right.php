<?php
/*
* Created on 01/02/2008
* Created by Victor Manuel Vallecilla -- Carlos A. Rojas
* Name of File: showCredit.php
*
*/
//Comprobar la session
include_once('../../includes/session.inc');
check_login();
/***INTERNACIONALIZACION****/
include_once('../../lang/core/ui/right.php');
/***************************/


// Conectamos con la DB
require_once('../../data/db.class.php');
$db = new db_class;
if (!$db->connect()){
	$db->print_last_error(false);
}

$_sql = "SELECT IFNULL(not_consumed_credit,0) AS not_consumed_credit, IFNULL(planned_credit,0) AS planned_credit, IFNULL(free_credit,0) AS free_credit FROM actual_planned_credit WHERE id_client="."$_SESSION[usuario_identificacion_sesion]";
$r = $db->select($_sql);

include_once('../../includes/simplepage.class.php');

$obj = new simplepage();
$obj->setTitle($title);
$obj->setCSS("../../includes/style/style.css");
$obj->setCSS("../../includes/style/menu.css");

echo $obj->getHeader();
$img_dir = "../../images";
?>
		<table width="113px"  border="0" cellspacing="1" align="left">
			<tr>
				<td class="btnhead" colspan="2"><?php echo $title;?></td>
			</tr>
			<?php			
				$credit=$db->get_row($r, 'MYSQL_ASSOC');
				echo '<tr>' .
				'<td class="btncont"><a href="">'.$cont_0.'</a></td>' .
				'<td class="btncont">'.$credit[planned_credit].'</td>' .
				'</tr>';
				echo '<tr>' .
				'<td class="btncont"><a href="">'.$cont_1.'</a></td>' .
				'<td class="btncont">'.$credit[free_credit].'</td>' .
				'</tr>';
				echo '<tr>' .
				'<td class="btncont"><a href="">'.$cont_2.'</a></td>' .
				'<td class="btncont">'.$credit[not_consumed_credit].'</td>' .
				'</tr>';			//
			?>
			<tr>
				<td colspan="2"><img width="113px" height="425px" src="../../images/banner.jpg"/></td>
			</tr>
		</table>
	</body>
</html>
