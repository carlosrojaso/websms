<?php
/*
* Created on 20/08/2007
* Created by Carlos A. Rojas
* Name of File: home.php
*
* Marcos de la aplicacion
*
*/
/**********Includes************************/
/*Comprobamos la session**/
include_once('../../includes/session.inc');
check_login();
//Internacionalizacion
include_once('../../lang/core/ui/home.php');
/*******************************************/

switch($_SESSION[idm]){
	case 'UK':
		$msg_title=$msg_title_en;
		$msg_error=$msg_error_en;
		break;
}

?>
<HEAD>
<TITLE><?php echo $msg_title;?></TITLE>
</HEAD>
 <?php
  require_once('../../data/db.class.php');
  $db = new db_class();
  if (!$db->connect())
  $db->print_last_error(false);
  $_sql="SELECT user_prof_group_cd FROM users u, user_profile up WHERE u.user_prof_cd=up.user_prof_cd AND u.user_login='".$_SESSION[nombre_usuario]."'";
  //echo $_sql.'<br>';
  $r = $db->select($_sql);
  $row=$db->get_row($r,'MYSQL_ASSOC');
  if($row[user_prof_group_cd]=='I'){
   ?>
<FRAMESET cols="20%,80%">
  <frame name="menu" noresize scrolling="AUTO" src="menu.php" marginwidth="0" marginheight="0" frameborder="no">
  <frame name="centro" src="body.php" noresize marginwidth="0" marginheight="0" frameborder="NO">   
</FRAMESET>
<?php }else{?>
<FRAMESET cols="20%,65%,117px">
  <frame name="menu" noresize scrolling="AUTO" src="menu.php" marginwidth="0" marginheight="0" frameborder="no">
  <frame name="centro" src="body.php" noresize marginwidth="0" marginheight="0" frameborder="NO"> 
  <frame name="right" noresize scrolling="AUTO" src="right.php" marginwidth="0" marginheight="0" frameborder="no">  
</FRAMESET>
<?php }?>
<noframes> 
	<body bgcolor="#FFFFFF" text="#000000">
		<?php echo $error;?>
	</body>
</noframes> 
</HTML>
