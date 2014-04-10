/*
*Construido por: Victor Manuel Vallecilla
*Nombre:validate_userDataAccess.js
*Validacion de la forma de ingreso para Clientes Profesionales
*Fecha: 03/10/2007
*
**/

var errMsg=new Array();
var errCount;
var firstErr=null;
var field='';

//Validacion de los campos obligatorios
function validateMandatoryFields(){
	errMsg = new Array();
	errCount=0;

	//Colocar en el estado inicial al campo resaltado
	resetFields(field);
	firstErr=null;

	//Llamado a las funciones de validacion de los campos	
	validate_user_pass();
	validate_conf_user_pass();	
	


	if(errCount>0){
		for(i=0;i<errMsg.length;i++){
			alert(errMsg[i]);
		}
		field=firstErr.id;
		//Resaltar el primer campo donde existe un error
		document.getElementById('title_'+firstErr.id+'_underline').style.display='block';
		document.getElementById('label_'+firstErr.id+'_underline').style.background='#FFFFCC';
		document.getElementById('input_'+firstErr.id+'_underline').style.background='#FFFFCC';

		//Fijar el foco en el campo en el que se presenta el primer error
		firstErr.focus();
		document.getElementById('title_'+firstErr.id+'_underline').scrollIntoView(true);

		//Mostrar la nota al pie aclarando el mensaje de error
		document.getElementById('notaerror').style.display='inline';

		
	}else{

		document.forma.submit();
	}
}

//Regresar al estado incial los campos que se resaltaron
function resetFields(field){	
	if(field!=""){
		document.getElementById('title_'+field+'_underline').style.display='none';
		document.getElementById('label_'+field+'_underline').style.background='#FFFFFF';
		document.getElementById('input_'+field+'_underline').style.background='#FFFFFF';
		field='';
	}
	
	document.getElementById('required_user_pass').style.display='none';
	document.getElementById('required_conf_user_pass').style.display='none';
}

function validate_user_pass(){//Validar el ingreso de la contraseña del usuario
	user_pass=document.getElementById('user_pass').value;
	var filter= /^[A-Za-z0-9]{6,10}$/;
	if (user_pass.replace(/ /g, '') == '' || !filter.test(user_pass)) {
		if(firstErr==null){
			firstErr=document.getElementById('user_pass');
		}
		
		document.getElementById('required_user_pass').style.display='inline';
		document.getElementById('required_user_pass').style.color='#FF0000';
		
		errMsg[errCount]='Su contraseña debe tener un mínimo de 6 caracteres.(Solo caracteres no simbolos)';
		errCount++;
	}
}

function validate_conf_user_pass(){//Validar que los campos contraseña y repetir contraseña coincidan
	user_pass=document.getElementById('user_pass').value;
	conf_user_pass=document.getElementById('conf_user_pass').value;
	if (user_pass.replace(/ /g, '') == '' || conf_user_pass.replace(/ /g, '') == '' || user_pass != conf_user_pass) {
		if(firstErr==null){
			firstErr=document.getElementById('conf_user_pass');
		}
		
		document.getElementById('required_conf_user_pass').style.display='inline';
		document.getElementById('required_conf_user_pass').style.color='#FF0000';
		
		errMsg[errCount]='Los campos Contraseña y Repetir Contraseña deben coincidir.';
		errCount++;
	}
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