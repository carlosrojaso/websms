<?php
/*
 * Created on 20/08/2007
 * Created by Carlos A. Rojas
 * Name of File: test_user.php
 *
 */
 
 require_once('../data/user.php');
 
 	$user = new user('lcastro');
 	echo $user -> getID().'<br/>';
 	echo $user -> getClient_id().'<br/>';
 	echo $user -> getProfile().'<br/>';
 	echo $user -> getLogin().'<br/>';
 	echo $user -> getPass().'<br/>';
 	echo $user -> getStatus().'<br/>';
 	echo $user -> getDate_req().'<br/>';
 	echo $user -> getFlag().'<br/>';
 	echo $user -> getDate_in().'<br/>';
 	echo $user -> getDate_mod().'<br/>';
 	echo $user -> getDate_out().'<br/>';
 	echo $user -> getOut_reason().'<br/>';
?>
