<?php
include_once ('../../includes/session.inc');
check_login();
/*******INTERNACIONALIZACION***********/
include_once("../../lang/cac/ui/queryFormRequest.php");

/*******************************/
include_once ('../../includes/simplepage.class.php');
$obj = new simplepage();
$obj->setTitle($title);
$obj->setCSS("../../includes/style/style.css");
echo $obj->getHeader();
if (!isset ($_GET[frm_req_reason_cd]) && !isset ($_GET[user_registered])) {
	$_sql = "SELECT
			form_request_reason.frm_req_reason_cd as frm_req_reason_cd,
			form_request_reason.frm_req_reason_nm as frm_req_reason_nm,
			COUNT( form_request_reason.frm_req_reason_cd ) AS NUMB_FORMS_OPENED
			FROM form_request, form_request_reason
			WHERE
			form_request_reason.frm_req_reason_lang = 'SP'
			AND form_request.frm_req_reason_cd = form_request_reason.frm_req_reason_cd
			AND form_request.frm_req_status_cd!='C'
			GROUP BY form_request_reason.frm_req_reason_nm, form_request_reason.frm_req_reason_cd";
} else {
	if (isset ($_GET[frm_req_reason_cd])) {
		$_sql = "SELECT 
							form_request_reason.frm_req_reason_cd AS frm_req_reason_cd,
							form_request_reason.frm_req_reason_nm AS frm_req_reason_nm, 
							IFNULL(COUNT( form_request_reason.frm_req_reason_cd ),0) AS NUMB_FORMS_OPENED
							FROM form_request, form_request_reason
							WHERE 
							form_request.id_client IS NULL
							AND form_request_reason.frm_req_reason_lang = 'SP'
							AND form_request.frm_req_reason_cd = '" . $_GET[frm_req_reason_cd] . "'
							AND form_request.frm_req_status_cd!='C'
							GROUP BY 
							form_request_reason.frm_req_reason_nm, form_request_reason.frm_req_reason_cd";
		$_sql2 = "SELECT 
							form_request_reason.frm_req_reason_cd AS frm_req_reason_cd,
							form_request_reason.frm_req_reason_nm AS frm_req_reason_nm, 
							IFNULL(COUNT( form_request_reason.frm_req_reason_cd ),0) AS NUMB_FORMS_OPENED
							FROM form_request, form_request_reason
							WHERE 
							form_request.id_client IS NOT NULL
							AND form_request_reason.frm_req_reason_lang = 'SP'
							AND form_request.frm_req_reason_cd = '" . $_GET[frm_req_reason_cd] . "'
							AND form_request.frm_req_status_cd!='C'
							GROUP BY 
							form_request_reason.frm_req_reason_nm, form_request_reason.frm_req_reason_cd";
	} else {
		//usuarios no registrados
		if (isset ($_GET[user_registered]) && $_GET[user_registered] == 'NO') {
			$_sql = " SELECT form_request.id_frm_req AS id_frm_req,
											CASE form_request.frm_req_status_cd
											WHEN 'N'
											THEN (SELECT frm_req_status_nm FROM form_request_status WHERE frm_req_status_cd='N' AND frm_req_status_lang='".$_SESSION[idm]."')
											WHEN 'P'
											THEN (SELECT frm_req_status_nm FROM form_request_status WHERE frm_req_status_cd='P' AND frm_req_status_lang='".$_SESSION[idm]."')
											END AS frm_req_status_cd, IFNULL( logins.login, '".$msg4."' ) AS login
											FROM (
											
											SELECT users.user_login AS login, users.id_client AS id_client
											FROM users
											GROUP BY users.user_login, users.id_client
											) AS logins
											RIGHT JOIN form_request ON logins.id_client = form_request.frm_req_id_operator
											WHERE form_request.id_client IS NULL
											AND form_request.frm_req_reason_cd='" . $_GET[frm_req_reason_cd2] . "'
											ORDER BY form_request.frm_req_date_in ASC ";		
		} else {
			$_sql = " SELECT form_request.id_frm_req AS id_frm_req,
											CASE form_request.frm_req_status_cd
											WHEN 'N'
											THEN (SELECT frm_req_status_nm FROM form_request_status WHERE frm_req_status_cd='N' AND frm_req_status_lang='".$_SESSION[idm]."')
											WHEN 'P'
											THEN (SELECT frm_req_status_nm FROM form_request_status WHERE frm_req_status_cd='P' AND frm_req_status_lang='".$_SESSION[idm]."')
											END AS frm_req_status_cd, IFNULL( logins.login, 'Sin operador' ) AS login
											FROM (
											
											SELECT users.user_login AS login, users.id_client AS id_client
											FROM users
											GROUP BY users.user_login, users.id_client
											) AS logins
											RIGHT JOIN form_request ON logins.id_client = form_request.frm_req_id_operator
											WHERE form_request.id_client IS NOT NULL
											AND form_request.frm_req_reason_cd='" . $_GET[frm_req_reason_cd2] . "'
											ORDER BY form_request.frm_req_date_in ASC ";
		}
	}
}
//echo $_sql;
/*****************************************/
require_once ('../../data/db.class.php');
$db = new db_class();
if (!$db->connect())
	$db->print_last_error(false);
?>
<br><br>			
<table aling="center" cellpadding="2" cellspacing="0" border="0" width="50%" >						
<tr>	
  <td align="center" class="titulo" colspan="4"><b><?php echo $title;?></b></td>
</tr>  
<tr>	
  <td >&nbsp;</td>
</tr>   
	<?php


if (!isset ($_GET[frm_req_reason_cd]) && !isset ($_GET[user_registered])) {
	
	$_pagi_result = $db->select($_sql);
	if ($db->row_count==0) {
		echo '<tr>';
		echo '<td class="titulo" colspan="2"><b>'.$msg5.'</b></td>';		
		echo '</tr>';
	} else {
		echo '<tr>';
		echo '<td class="titulo">'.$title2.'</td>';
		echo '<td class="titulo">'.$title3.'</td>';
		echo '</tr>';	
		while ($actual = mysql_fetch_array($_pagi_result)) {
			echo '<tr>';
			echo '<td class="label"><a href="../../ui/cac/queryFormRequest.php?frm_req_reason_cd=' . $actual[frm_req_reason_cd] . '" style="color:##FF0000">' . $actual[frm_req_reason_nm] . '</a></td>';
			echo '<td >(' . $actual[NUMB_FORMS_OPENED] . ')</td>';
			echo '</tr>';

		}
	}
} else {
	if (isset ($_GET[frm_req_reason_cd])) {
		$_pagi_result = $db->select($_sql);
		$_pagi_result2 = $db->select($_sql2);

		echo '<tr>';
		if ($actual = mysql_fetch_array($_pagi_result)) {
			echo '<td class="label"><a href="../../ui/cac/queryFormRequest.php?user_registered=NO&frm_req_reason_cd2=' . $_GET[frm_req_reason_cd] . '" style="color:##FF0000">'.$title5.'</a></td>';
			echo '<td >(' . $actual[NUMB_FORMS_OPENED] . ')</td>';
		} else {
			echo '<td class="label">'.$title5.'</td>';
			echo '<td >(0)</td>';
		}
		if ($siguiente = mysql_fetch_array($_pagi_result2)) {
			echo '<td class="label"><a href="../../ui/cac/queryFormRequest.php?user_registered=YES&frm_req_reason_cd2=' . $_GET[frm_req_reason_cd] . '" style="color:##FF0000">'.$title4.'</a></td>';
			echo '<td >(' . $siguiente[NUMB_FORMS_OPENED] . ')</td>';
		} else {
			echo '<td class="label">'.$title4.'</td>';
			echo '<td >(0)</td>';
		}
		echo '</tr>';
	}

}

if (isset ($_GET[user_registered])) {
	$_pagi_result = $db->select($_sql);
	echo '<tr>';
	echo '<td class="titulo" nowrap bgcolor="cyan" style="border:dotted;"><b>'.$msg.'</b></td>';
	echo '<td class="titulo" nowrap bgcolor="cyan" style="border:dotted;"><b>'.$msg2.'</b></td>';
	echo '<td class="titulo" nowrap bgcolor="cyan" style="border:dotted;"><b>'.$msg3.'</b></td>';
	echo '</tr>';
	while ($actual = mysql_fetch_array($_pagi_result)) {
		echo '<tr>';
		echo '<td class="label" align="center">' . $actual[id_frm_req] . '</td>';
		echo '<td class="label" align="center">' . $actual[frm_req_status_cd] . '</td>';
		echo '<td class="label" align="center">' . $actual[login] . '</td>';
?>
		<td><input type="button" value="Gestionar"class="cssbutton" onclick="location.href='../../control/cac/manageFormRequest.php?id_frm_req=<?php echo $actual[id_frm_req];?>&frm_req_reason_cd=<?php echo $_GET[frm_req_reason_cd2];?>' "></td>
		<?php


		echo '</tr>';

	}
}
?>				
</table>	
<br><br><br>
<?php echo $obj->getFooter(); ?>
