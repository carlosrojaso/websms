<?php
ini_set('session.use_cookies', 1);
ini_set('session.use_only_cookies', 1);
session_start();

function check_login() {
	if ($_SESSION['auth'] != "yes")
	{
		header('location:../../index.php');
		exit();
	}
}
?>
