/*
*Construido por: Victor Manuel Vallecilla
*Nombre:validate_userLogin.js
*Validacion del ingreso al area privada del portal
*Fecha: 03/10/2007
*
**/

function validate_privateAreaAcces(){
	document.getElementById('login_user_login').style.background='#FFFFFF';
	document.getElementById('login_user_pass').style.background='#FFFFFF';

	login_user_login=document.getElementById('login_user_login').value;
	login_user_pass=document.getElementById('login_user_pass').value;

	if (login_user_login.replace(/ /g, '') == '' && login_user_pass.replace(/ /g, '') == '') {
		document.getElementById('login_user_login').style.background='#FFFFCC';
		document.getElementById('login_user_pass').style.background='#FFFFCC';
		alert('Por favor informe el usuario y contraseña');
		document.getElementById('login_user_login').focus();
		return;
	}

	if (login_user_login.replace(/ /g, '') == '') {
		document.getElementById('login_user_login').style.background='#FFFFCC';
		alert('Por favor informe el usuario');
		document.getElementById('login_user_login').focus();
		return;
	}

	if (login_user_pass.replace(/ /g, '') == '') {
		document.getElementById('login_user_pass').style.background='#FFFFCC';
		alert('Por favor informe la contraseña');
		document.getElementById('login_user_pass').focus();
		return;
	}

	document.forma.submit();
}
