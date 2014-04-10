<?php 
include_once('../../includes/session.inc');
check_login();
//Determinar el idioma en el cual se muestra las paginas

$_SESSION[idm]=$_GET[lang];
/*
echo 'Autenticado:'.$_SESSION[auth].'<br>';
echo 'Idioma:'.$_SESSION[idm].'<br>';
echo 'Login:'.$_SESSION[nombre_usuario].'<br>';
*/
echo '<script type="text/JavaScript" >setTimeout("window.parent.location.reload();",1000);</script>';
?>