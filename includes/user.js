//Mostrar o no <show=true | false> una capa <layer> en un modo determinado <disply_mode>
function showLayer(show,layer,display_mode){
	if(show){
		if(document.forma.terms_of_use!=undefined){
			if(document.forma.terms_of_use.checked)
			document.getElementById(layer).style.display=display_mode;
			else
			document.getElementById(layer).style.display='none';
		}else{
			document.getElementById(layer).style.display=display_mode;
		}
	}else{
		document.getElementById(layer).style.display='none';
	}
}
//Validar el login del usuario (logintud debe estar entre 6 y 10 caracteres)
function validateUserLogin(user_login){
	if(user_login.length<6 || user_login.length>10){
		return 'Su usuario debe tener entre 6 y 10 caracteres.';
	}
}
//Validar el password del usuario (minimo 6 caracteres)
function validateUserPassword(user_pass){
	if(user_pass.length<6){
		return 'Su contraseña debe tener un mínimo de 6 caracteres.';
	}
}
//Validar que el login y la contraseña coincidan
function validateUserConfPassword(user_pass,conf_user_pass){
	if(user_pass=='' || conf_user_pass=='' || user_pass!=conf_user_pass){
		return 'Los campos Contraseña y Repetir Contraseña deben coincidir.';
	}
}

//Validar los campos email y repetir email en el formulario de atencion al cliente
function validateRequestEmail(email,email_conf){
	if(email!=email_conf){
		return 'El campo E-mail y Repetir E-mail deben ser iguales.';
	}
}
//Validar que se escoja al menos una de las opciones al momento de crear la prescripción
function checkFields(){
	var phone=document.forma.cont_phone.value;
	var cell=document.forma.cont_cell_phone.value;
	var email=document.forma.cont_email.value;
	if(phone=='' && cell=='' && email==''){
		alert('Debes informar al menos uno (teléfono, teléfono móvil o email)');
	}
}
//Revisar que al momento de seleccionar el envio de las alertas todos los dias
//se deseleccionen los demas dias escogidos y viceversa
function checkDays(){
	if(document.getElementById('all').checked){
		for(i=0;i<7;i++){
			document.getElementById('day'+i).checked=false;
		}
	}
}
//Cuando se hace clic en cancelar el modulo en cualquier paso de la creacion de la prescripción
function cancelModule(){
	if(confirm('¿Desea cancelar esa prescripción?')){
		location.href="../../ui/core/home.php";
	}
}

function checkSendType(){
	if(document.getElementById('input_save').checked){
		document.getElementById('input_sendSMS').disabled=true;
		document.getElementById('input_sendSMS').checked=false;
		document.getElementById('input_sendEMAIL').disabled=true;
		document.getElementById('input_sendEMAIL').checked=false;
	}else{
		document.getElementById('input_sendSMS').disabled=false;
		document.getElementById('input_sendEMAIL').disabled=false;
	}
}
//Calcular el costo del mensaje segun la cantidad de caracteres
function calcCost(count,chars,cost){
	obser=document.getElementById(count).value.length;
	if(obser>480){
		document.getElementById(count).value=document.getElementById(count).value.substring(0,479);
	}

	if(obser<=160){
		document.getElementById(cost).value=1;
	}
	if(obser>160 && obser<=320){
		document.getElementById(cost).value=2;
	}
	if(obser>320 && obser<=480){
		document.getElementById(cost).value=3;
	}
	if(obser==0){
		document.getElementById(chars).value=0;
		document.getElementById(cost).value=0;
	}
	else{
		document.getElementById(chars).value=obser+1;
	}
}
//Cuando se hace clic en dar de alta un nuevo usuario
function selectUser(){
	location.href="../user/selectUserAct.php";
}

//Mostrar el boton de submit en los formularios
//showSubmi=true se muestra el elemento con nombre submitForm
//showSubmi=false no se muestra el elemento con nombre submitForm
function show_submitForm(showSubmit){
	if(showSubmit){
		document.getElementById('submitForm').style.display = 'inline';
	}else{
		document.getElementById('submitForm').style.display = 'none';
	}
}

//Borrar el campo de repetir password al momento de hacer foco sobre el campo password
function resetRepetirPWD(){
	document.forma.conf_user_pass.value='';
}

//Verificar que theElement es una direccion de email valida (cuando se recuperan los datos de acceso)
function isEmailAddress(theElement, nombre_del_elemento ){

	var s = theElement.value;
	var filter=/^([a-zA-Z0-9_.+-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,6})+$/;
	if (s.length == 0 ) {
		alert('Por favor ingrese su dirección email de contacto');
		theElement.focus();
		return false;
	}
	if (!filter.test(s)){
		alert('Por favor ingrese una dirección de email válida');
		return false;
	}

	return true;
}
//Validar al momento de desactivar un usuario
function validateDelete(){
	if(confirm('¿Está seguro que desea desactivar ese usuario?')){
		document.infor_user.submit();
	}else{
		history.back();
	}
}

//Validar que el login y la contraseña coincidan (cuando se modifican datos)
function validateUserConfPassword_modif(user_pass,conf_user_pass){
	//alert(user_pass.length + ' ' + conf_user_pass);
	if(user_pass=='' || conf_user_pass=='' || user_pass!=conf_user_pass){
		alert ('Los campos Contraseña y Repetir Contraseña deben coincidir.');		
		document.forma2.conf_user_pass.style.background='#FFFFCC';	
		document.forma2.conf_user_pass.focus();
		return false;
	}	
	if(user_pass.length<6){
		alert ('La contraseña debe tener una logitud minima de 6 caracteres.');
		document.forma2.user_pass.style.background='#FFFFCC';	
		document.forma2.user_pass.focus();
		return false;
	}
	if(document.forma2.user_date_in!=undefined){
		return compareDates(document.forma2.user_date_in.value,document.forma2.user_date_out.value);		
	}else if(document.forma2.user_out_in!=undefined){
		return compareDates_modif(document.forma2.user_date_out.value);		
	}

}
