/*
*Construido por: Victor Manuel Vallecilla
*Nombre:validate_addUserPar.js
*Validacion de la forma de edicion para Clientes Proefesionales
*Fecha: 03/10/2007
*
**/

var errMsg = new Array();
var errCount=0;
var firstErr=null;
var field='';

function editClient(){
	//alert("edita cliente");
	if(document.getElementById('edit_client')!=undefined)
		document.getElementById('edit_client').value='true';
}

function editUser(){
	//alert("edita usuario");
	if(document.getElementById('edit_user')!=undefined)
		document.getElementById('edit_user').value='true';
}

//Validacion de los campos obligatorios
function edit_Particular_validateMandatoryFields(){
	errMsg = new Array();
	errCount=0;

	//Colocar en el estado inicial al campo resaltado
	resetFields(field);
	firstErr=null;

	//Llamado a las funciones de validacion de los campos
	validate_treatment();
	validate_name();
	validate_lastname();	
	validate_cli_ident_type_cd();
	validate_cli_ident_num();
	validate_birthday();
	validate_cli_e_mail();	
	validate_cli_country_cd();
	validate_cli_postal_cd();	
	validate_user_login();
	validate_user_pass();
	validate_conf_user_pass();	
	


	if(errCount>0){
		for(i=0;i<1;i++){
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
	
	document.getElementById('required_cli_sex_cd').style.display='none';
	document.getElementById('required_cli_firstname').style.display='none';
	document.getElementById('required_cli_lastname_1').style.display='none';	
	document.getElementById('required_cli_ident_type_cd').style.display='none';
	document.getElementById('required_birthday').style.display='none';
	document.getElementById('required_cli_e_mail').style.display='none';
	document.getElementById('required_cli_country_cd').style.display='none';	
	document.getElementById('required_cli_postal_cd').style.display='none';
	document.getElementById('required_cli_ident_num').style.display='none';
	document.getElementById('required_user_login').style.display='none';
	document.getElementById('required_user_pass').style.display='none';
	document.getElementById('required_conf_user_pass').style.display='none';
}

//Validacion de cada uno de los campos obligatorios del formulario.

function validate_treatment(){//Validar la seleccion del tratamiento
	treatment=document.getElementById('cli_sex_cd').value;
	if(treatment==-1){
		if(firstErr==null){
			firstErr=document.getElementById('cli_sex_cd');
		}				
		
		document.getElementById('required_cli_sex_cd').style.display='inline';
		document.getElementById('required_cli_sex_cd').style.color='#FF0000';
		
		errMsg[errCount]='Por favor seleccione el tratamiento';
		errCount++;
	}
}

function validate_name(){//Validar el ingreso del nombre
	cli_firstname=document.getElementById('cli_firstname').value;
	if (cli_firstname.replace(/ /g, '') == '') {
		if(firstErr==null){
			firstErr=document.getElementById('cli_firstname');
		}
		
		document.getElementById('required_cli_firstname').style.display='inline';
		document.getElementById('required_cli_firstname').style.color='#FF0000';
		
		errMsg[errCount]='Por favor informe el nombre';
		errCount++;
	}
}

function validate_lastname(){//Validar el ingreso del apellido
	lastname=document.getElementById('cli_lastname_1').value;
	if (lastname.replace(/ /g, '') == '') {
		if(firstErr==null){
			firstErr=document.getElementById('cli_lastname_1');
		}
		
		document.getElementById('required_cli_lastname_1').style.display='inline';
		document.getElementById('required_cli_lastname_1').style.color='#FF0000';
		
		errMsg[errCount]='Por favor informe el apellido';
		errCount++;
		return;
	}
}

function validate_cli_ident_type_cd(){//Validar la seleccion del tipo de identificacion
	cli_ident_type_cd=document.getElementById('cli_ident_type_cd').value;
	if(cli_ident_type_cd==-1){
		if(firstErr==null){
			firstErr=document.getElementById('cli_ident_type_cd');
		}				
		
		document.getElementById('required_cli_ident_type_cd').style.display='inline';
		document.getElementById('required_cli_ident_type_cd').style.color='#FF0000';
		
		errMsg[errCount]='Por favor seleccione el tipo de documento de identificaci�n';
		errCount++;
	}
}


function validate_cli_ident_num(){//Validar el ingreso del CIF de la empresa
	cli_ident_num=document.getElementById('cli_ident_num').value;
	if (cli_ident_num.replace(/ /g, '') == '') {
		if(firstErr==null){
			firstErr=document.getElementById('cli_ident_num');
		}
		
		document.getElementById('required_cli_ident_num').style.display='inline';
		document.getElementById('required_cli_ident_num').style.color='#FF0000';
		
		errMsg[errCount]='Por favor informe el n�mero del documento de identificaci�n';
		errCount++;
	}
}

function validate_birthday(){//Validar el ingreso del CIF de la empresa
	birthday=document.getElementById('birthday').value;
	if (birthday.replace(/ /g, '') == '') {
		if(firstErr==null){
			firstErr=document.getElementById('birthday');
		}
		
		document.getElementById('required_birthday').style.display='inline';
		document.getElementById('required_birthday').style.color='#FF0000';
		
		errMsg[errCount]='Por favor informe la fecha de nacimiento';
		errCount++;
	}
}


function validate_cli_e_mail(){//Validar el ingreso de la direccion de correo electronico
	cli_e_mail=document.getElementById('cli_e_mail').value;
	var filter=/^([a-zA-Z0-9_.+-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,6})+$/;
	if (cli_e_mail.replace(/ /g, '') == '' || !filter.test(cli_e_mail)) {
		if(firstErr==null){
			firstErr=document.getElementById('cli_e_mail');
		}
		
		document.getElementById('required_cli_e_mail').style.display='inline';
		document.getElementById('required_cli_e_mail').style.color='#FF0000';
		
		errMsg[errCount]='La direcci�n e-mail no es valida.';
		errCount++;
	}
}

function validate_cli_country_cd(){//Validar la seleccion del pais
	cli_country_cd=document.getElementById('cli_country_cd').value;
	if(cli_country_cd==-1){
		if(firstErr==null){
			firstErr=document.getElementById('cli_country_cd');
		}

		document.getElementById('required_cli_country_cd').style.display='inline';
		document.getElementById('required_cli_country_cd').style.color='#FF0000';

		errMsg[errCount]='Por favor seleccione el pais';
		errCount++;
	}
}

function validate_cli_postal_cd(){//Validar el ingreso del c�digo postal
	cli_postal_cd=document.getElementById('cli_postal_cd').value;
	if (cli_postal_cd.replace(/ /g, '') == '') {
		if(firstErr==null){
			firstErr=document.getElementById('cli_postal_cd');
		}
		
		document.getElementById('required_cli_postal_cd').style.display='inline';
		document.getElementById('required_cli_postal_cd').style.color='#FF0000';
		
		errMsg[errCount]='Por favor informe el c�digo postal';
		errCount++;
	}
}


function validate_user_login(){//Validar el login del usuario
	user_login=document.getElementById('user_login').value;
	var filter= /^[A-Za-z0-9]{6,10}$/;
	if (user_login.replace(/ /g, '') == '' || !filter.test(user_login)) {
		if(firstErr==null){
			firstErr=document.getElementById('user_login');
		}
		
		document.getElementById('required_user_login').style.display='inline';
		document.getElementById('required_user_login').style.color='#FF0000';
		
		errMsg[errCount]='Su usuario debe tener entre 6 y 10 caracteres.(Solo caracteres no simbolos)';
		errCount++;
	}
}

function validate_user_pass(){//Validar el ingreso de la contrase�a del usuario
	user_pass=document.getElementById('user_pass').value;
	var filter= /^[A-Za-z0-9]{6,10}$/;
	if (user_pass.replace(/ /g, '') == '' || !filter.test(user_pass)) {
		if(firstErr==null){
			firstErr=document.getElementById('user_pass');
		}
		
		document.getElementById('required_user_pass').style.display='inline';
		document.getElementById('required_user_pass').style.color='#FF0000';
		
		errMsg[errCount]='Su contrase�a debe tener un m�nimo de 6 caracteres.(Solo caracteres no simbolos)';
		errCount++;
	}
}

function validate_conf_user_pass(){//Validar que los campos contrase�a y repetir contrase�a coincidan
	user_pass=document.getElementById('user_pass').value;
	conf_user_pass=document.getElementById('conf_user_pass').value;
	if (user_pass.replace(/ /g, '') == '' || conf_user_pass.replace(/ /g, '') == '' || user_pass != conf_user_pass) {
		if(firstErr==null){
			firstErr=document.getElementById('conf_user_pass');
		}
		
		document.getElementById('required_conf_user_pass').style.display='inline';
		document.getElementById('required_conf_user_pass').style.color='#FF0000';
		
		errMsg[errCount]='Los campos Contrase�a y Repetir Contrase�a deben coincidir.';
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