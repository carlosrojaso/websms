<?php
$_sql='';
if($_GET[search]=='true'){
	$name=$_POST['name'];
	$lastname=$_POST['lastname'];
	$login=$_POST['login'];
	$criteria=$_POST['criteria'];
	//echo 'criteria: '.$criteria.' login: '.$login.' lastname: '.$lastname.' name: '.$name;

	if(trim($login)==1){
		$_sql = "	SELECT user_prof_nm,cli_firstname, cli_lastname, user_login, user_status_nm,cli_country_cd, user_info_upd,user_info_cre
			FROM client, users, user_profile, user_status
			WHERE client.id_client=users.id_client 
			AND users.user_login LIKE '%".$criteria."%'
			AND users.user_prof_cd=user_profile.user_prof_cd 
			AND users.user_status_cd=user_status.user_status_cd
			AND user_status.user_status_lang='SP'
			AND user_profile.user_prof_lang='SP'
			AND client.cli_current_flag=1
			AND users.user_current_flag=1
			AND user_profile.user_prof_group_cd='I'
			GROUP BY user_prof_nm, user_status.user_status_nm,cli_firstname, cli_lastname, user_login, user_status_nm 
			ORDER BY user_prof_nm asc";
	}
	if(trim($name)==1){
		$_sql = "SELECT user_prof_nm,cli_firstname, cli_lastname, user_login, user_status_nm,cli_country_cd, user_info_upd,user_info_cre
			FROM client, users, user_profile, user_status
			WHERE client.id_client=users.id_client 
			AND client.cli_firstname LIKE '%".$criteria."%'
			AND users.user_prof_cd=user_profile.user_prof_cd 
			AND users.user_status_cd=user_status.user_status_cd
			AND user_status.user_status_lang='SP'
			AND user_profile.user_prof_lang='SP'
			AND client.cli_current_flag=1
			AND users.user_current_flag=1
			AND user_profile.user_prof_group_cd='I'
			GROUP BY user_prof_nm, user_status.user_status_nm,cli_firstname, cli_lastname, user_login, user_status_nm 
			ORDER BY user_prof_nm asc";
	}

	if(trim($lastname)==1){
		$_sql = "SELECT user_prof_nm,cli_firstname, cli_lastname, user_login, user_status_nm,cli_country_cd, user_info_upd,user_info_cre
			FROM client, users, user_profile, user_status
			WHERE client.id_client=users.id_client 
			AND client.cli_lastname LIKE '%".$criteria."%'
			AND users.user_prof_cd=user_profile.user_prof_cd 
			AND users.user_status_cd=user_status.user_status_cd
			AND user_status.user_status_lang='SP'
			AND user_profile.user_prof_lang='SP'
			AND client.cli_current_flag=1
			AND users.user_current_flag=1
			AND user_profile.user_prof_group_cd='I'
			GROUP BY user_prof_nm, user_status.user_status_nm,cli_firstname, cli_lastname, user_login, user_status_nm 
			ORDER BY user_prof_nm asc";
	}

}
?>