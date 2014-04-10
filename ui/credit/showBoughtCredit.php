<?php
/*
* Created on 01/02/2008
* Created by Victor Manuel Vallecilla
* Name of File: showBoughtCredit.php
*
*/
//Comprobar la session
include_once('../../includes/session.inc');
check_login();
/***INTERNACIONALIZACION****/
include_once('../../lang/credit/ui/showBoughtCredit.php');
/***************************/

include_once('../../includes/simplepage.class.php');

$obj = new simplepage();
$obj->setTitle($title);
$obj->setCSS("../../includes/style/style.css");
$obj->setCSS("../../includes/menu.css");

// Conectamos con la DB
require_once('../../data/db.class.php');
$db = new db_class;
if (!$db->connect()){
	$db->print_last_error(false);
}

$_sql = "SELECT " .
		"SUBSTRING(purchase_date_in,1,10) AS DAY," .
		"SUBSTRING(purchase_date_in,11,18) AS HOUR," .
		"credit_nm," .
		"credit_price," .
		"bill_pay_mode_nm," .
		"bill_file_path " .
		" FROM " .
		" rel_bill_purchase rbp JOIN purchase p ON p.id_purchase=rbp.id_purchase" .
		" JOIN bill b ON b.id_bill=rbp.id_bill" .
		" JOIN credit c ON p.id_credit=c.id_credit" .
		" JOIN bill_pay_mode bpm ON bpm.bill_pay_mode_cd=b.bill_pay_mode_cd" .
		" WHERE p.id_client="."$_SESSION[cliente_identificacion_sesion] AND bill_pay_mode_lang='".$_SESSION[idm]."'";

//echo $_sql."<br>";
$r = $db->select($_sql);
echo $obj->getHeader();
?>	
<br><br><br>
<table width="100%"  border="0" cellspacing="1" align="center">
	<tr>
		<td colspan="7" align="center" class="subtitulo"><b><?php echo $head_title;?></b></td>
	</tr>
	<tr>
		<td bgcolor="cyan" nowrap class="titulo" align="center"><b><?php echo $title;?></b></td>
		<td bgcolor="cyan" nowrap class="titulo" align="center"><b><?php echo $title2;?></b></td>
		<td bgcolor="cyan" nowrap class="titulo" align="center"><b><?php echo $title3;?></b></td>
		<td bgcolor="cyan" nowrap class="titulo" align="center"><b><?php echo $title4;?></b></td>
		<td bgcolor="cyan" nowrap class="titulo" align="center"><b><?php echo $title5;?></b></td>
		<td bgcolor="cyan" nowrap class="titulo" align="center"><b><?php echo $title6;?></b></td>
		<td bgcolor="cyan" nowrap class="titulo" align="center"><b><?php echo $title7;?></b></td>
	</tr>
	<?php
	while($credit=$db->get_row($r, 'MYSQL_ASSOC')){		
		echo '<tr>' .		
			'<td nowrap class="label">'.$credit[DAY].'</td>' .
			'<td nowrap class="label">'.$credit[HOUR].'</td>' .
			'<td nowrap class="label">'.$credit[credit_nm].'</td>' .
			'<td nowrap class="label">'.$credit[credit_price].'</td>' .			
			'<td nowrap class="label">&nbsp;</td>' .
			'<td nowrap class="label">'.$credit[bill_pay_mode_nm].'</td>' .
			'<td nowrap class="label"><a href="'.$credit[bill_file_path].'" target="blank">'.$credit[bill_file_path].'</td>' .		
		'</tr>';		
	}
	?>			
</table>