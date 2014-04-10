<?php 
include_once('../../includes/session.inc');
check_login();
//Revisar si el credito consumido esta igual a cero
require_once('../../data/db.class.php');
$db = new db_class;

if (!$db->connect()) {
	$db->print_last_error(false);
}

$_sql="SELECT not_consumed_credit from actual_planned_credit WHERE id_client=".$_SESSION[usuario_identificacion_sesion]."";

$r = $db->select($_sql);
$row=$db->get_row($r, 'MYSQL_ASSOC');

$_sql1="SELECT id_client from users WHERE id_user=".$_SESSION[usuario_identificacion_sesion]." AND user_current_flag=1";

$r1 = $db->select($_sql1);
$row1=$db->get_row($r1, 'MYSQL_ASSOC');


echo
'
<form action="../../control/user/deleteUser.php" method="post" name="userDown" id="userDown">
	<input type="text" id="id_user" name="id_user" value="'.$_SESSION[usuario_identificacion_sesion].'">
	<input type="hidden" id="id_client" name="id_client" value="'.$row1[id_client].'">
	<input type="hidden" id="status" name="status" value="C">
	<input type="hidden" id="from_page" name="from_page" value="userDown">		
</form>
';

if($row[not_consumed_credit]>0){
	echo
	'<script>
		if(confirm("Le informamos que tiene todavía crédito no consumido.\n"+
					"Al darse de baja ahora perderá todo su crédito ya que Onspot no hace devoluciones de crédito.\n"+
					"(Ver Condiciones generales del servicio)\n"+ 
					"¿Desea darse de baja ahora?)")
		{
			document.userDown.submit();				
		}else{
			window.parent.location.href="../../ui/core/home.php";
		}
	</script>
		';
}else{
	echo
	'<script>
		document.userDown.submit();					
	</script>
	';
}
?>
