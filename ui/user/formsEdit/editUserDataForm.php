<?php
$r_tipo_cliente = $db->select("select cli_act_grp_nm from client_activity where cli_act_cd='".$row['cli_act_cd']."' and cli_act_lang='SP'");
$row_tipo_cliente=$db->get_row($r_tipo_cliente, 'MYSQL_ASSOC');

$tipo_cliente=$row_tipo_cliente[cli_act_grp_nm];

if(trim($tipo_cliente)=='Profesional'){
	//echo "<br>Profesional<br>";	

	$lastnames=explode(" ",$row[cli_lastname]);
	$lastname1=$lastnames[0];
	$lastname2=$lastnames[1];
	
	$_sql="SELECT sex_treatment FROM sex WHERE sex_cd='".$row[cli_sex_cd]."' and sex_lang='".$_SESSION[idm]."'";	
	$rp = $db->select($_sql);
	$row_0=$db->get_row($rp, 'MYSQL_ASSOC');
	
	$_sql="SELECT geo_country_cd,geo_country FROM geography WHERE geo_country_cd='".$row[cli_country_cd]."'";
	$rz = $db->select($_sql);
		
	$row_21=$db->get_row($rz, 'MYSQL_ASSOC');
	
	$_sex_sql="SELECT sex_treatment,sex_cd FROM sex WHERE sex_lang='".$_SESSION[idm]."'";
	
	$_sql_countries="SELECT geo_country_cd,geo_country FROM geography GROUP BY geo_country,geo_country_cd";
	
	include_once('editUserDataProfesional.php');



}elseif(trim($tipo_cliente)=='Particular'){
	//echo "<br>Particular<br>";
	
	$lastnames=explode(" ",$row[cli_lastname]);
	$lastname1=$lastnames[0];
	$lastname2=$lastnames[1];
	$_sql="SELECT sex_treatment FROM sex WHERE sex_cd='".$row[cli_sex_cd]."' and sex_lang='".$_SESSION[idm]."'";	
	$rp = $db->select($_sql);
	$row_0=$db->get_row($rp, 'MYSQL_ASSOC');

	$_sql="SELECT ident_type_nm FROM identification_doc_type WHERE ident_type_cd='".$row[cli_ident_type_cd]."' and ident_type_country='".$_SESSION[idm]."'";
	$rw = $db->select($_sql);
	$row_1=$db->get_row($rw, 'MYSQL_ASSOC');
	
	$_sql="SELECT geo_country_cd,geo_country FROM geography WHERE geo_country_cd='".$row[cli_country_cd]."'";
	$rz = $db->select($_sql);
		
	$row_21=$db->get_row($rz, 'MYSQL_ASSOC');
	
	$_sex_sql="SELECT sex_treatment,sex_cd FROM sex WHERE sex_lang='".$_SESSION[idm]."'";

	$_sql_ident_doc_type="SELECT ident_type_nm,ident_type_cd FROM identification_doc_type WHERE ident_type_cd!='VAT' AND ident_type_country='".$_SESSION[idm]."'";
	
	$_sql_countries="SELECT geo_country_cd,geo_country FROM geography GROUP BY geo_country,geo_country_cd";
	
	include_once('editUserDataParticular.php');
}
?>