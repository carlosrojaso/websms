<?php
/*
* Created on 20/08/2007
* Created by Carlos A. Rojas
* Name of File: logout.php
*
*/
include_once('../../includes/session.inc');
session_destroy();
$_SESSION['auth']="no";
$_SESSION['nombre_usuario']='';
$_SESSION[usuario_identificacion_sesion]="";
$_SESSION['idm']="";
if($_GET[deact]){
	header('location:../../ui/core/login.php?lang=SP&deact='.$_GET[deact]);
}else{
	header('location:../../ui/core/login.php?lang=SP');
}
?>
