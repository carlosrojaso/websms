<?php
$_sql='';
if($_GET[search]=='true'){
	$name=$_POST['name'];
	$lastname=$_POST['lastname'];
	$login=$_POST['login'];
	$criteria=$_POST['criteria'];
	//echo 'criteria: '.$criteria.' login: '.$login.' lastname: '.$lastname.' name: '.$name;

	if(trim($login)==1){
		$_sql = "	SELECT 	client.id_client as 'id_client',
	  							cli_cd,cli_firstname,cli_town,cli_sex_cd,
								cli_lastname,cli_birthdate,cli_company_nm,
								cli_ident_type_cd,cli_ident_num,
								cli_act_cd,cli_phone_num1,
								cli_phone_num2,cli_fax_num,
								cli_cell_phone,cli_e_mail,cli_address,
								cli_postal_cd,user_login,user_pass,cli_act_cd,user_info_upd,user_info_cre
						FROM 
							users, client, user_profile
						WHERE 
							user_login LIKE '%".$criteria."%'
							AND users.id_client=client.id_client
							AND client.cli_current_flag=1
							AND users.user_current_flag=1
		 					AND users.user_prof_cd=user_profile.user_prof_cd
	   						AND user_profile.user_prof_group_cd='E'
	   						AND user_profile.user_prof_lang='SP'";
	}
	if(trim($name)==1){
		$_sql = "SELECT client.id_client as 'id_client',
	  							cli_cd,cli_firstname,
								cli_town,cli_sex_cd,cli_lastname,					
								cli_birthdate,cli_company_nm,
								cli_ident_type_cd,cli_ident_num,
								cli_act_cd,cli_phone_num1,cli_phone_num2,
								cli_fax_num,cli_cell_phone,cli_e_mail,cli_address,
								cli_postal_cd,user_login,user_pass,cli_act_cd,user_info_upd,user_info_cre								
							FROM 
								users, client, user_profile 
							WHERE 
								cli_firstname LIKE'%".$criteria."%' 
								AND users.id_client=client.id_client
								AND client.cli_current_flag=1
								AND users.user_current_flag=1
		 						AND users.user_prof_cd=user_profile.user_prof_cd
	   							AND user_profile.user_prof_group_cd='E'
	   							AND user_profile.user_prof_lang='SP'";
	}
	if(trim($lastname)==1){
		$_sql = "SELECT client.id_client as 'id_client',
	  								cli_cd,cli_firstname,cli_town,
									cli_sex_cd,cli_lastname,					
									cli_birthdate,cli_company_nm,cli_ident_type_cd,
									cli_ident_num,cli_act_cd,cli_phone_num1,cli_phone_num2,
									cli_fax_num,cli_cell_phone,cli_e_mail,cli_address,
									cli_postal_cd,user_login,user_pass,cli_act_cd,user_info_upd,user_info_cre
								FROM 
									users, client, user_profile  
								WHERE 
									cli_lastname  LIKE '%".$criteria."%' 
									AND users.id_client=client.id_client
									AND client.cli_current_flag=1
									AND users.user_current_flag=1
						 			AND users.user_prof_cd=user_profile.user_prof_cd
					   				AND user_profile.user_prof_group_cd='E'
					   				AND user_profile.user_prof_lang='SP'";
	}
}

?>