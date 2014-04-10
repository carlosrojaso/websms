/*
*Construido por: Victor Manuel Vallecilla
*Nombre:validate_requestHelp.js
*Validacion de la forma de centro de atencion al cliente
*Fecha: 30/12/2007
*
**/

var errCount=0;

//Validacion de los campos obligatorios
function validateMandatoryFields(){		
	validate_Names();
	validate_E_mail();
	validate_RequestEmail();	
	validate_Motivation();	
	validate_Comments();
	if(errCount>0){			
		return false;
	}else{
		document.forma.submit();
	}
}

//Validar los campos email y repetir email en el formulario de atencion al cliente
function validate_RequestEmail(){
	if(document.getElementById('frm_req_mail')!=undefined){		
		if(document.getElementById('frm_req_mail').value != document.getElementById('frm_req_mail_conf').value){
			alert('Repetir E-mail vacío o diferente de E-mail');
			errCount++;			
		}
	}
}
function validate_Motivation(){
	if(document.getElementById('frm_req_reason_cd').value==-1){
		alert("Por favor seleccione el motivo de su pregunta");
		errCount++;		
	}
}

function validate_Names(){
	if(document.getElementById('frm_req_cli_nm')!=undefined){	
		name=document.getElementById('frm_req_cli_nm').value;
		if (name.replace(/ /g, '') == '') {
			alert('Por favor indique Nombre y Apellidos');
			errCount++;			
		}
	}
}

function validate_E_mail(){//Validar el ingreso de la direccion de correo electronico
	if(document.getElementById('frm_req_mail')!=undefined){
		cli_e_mail=document.getElementById('frm_req_mail').value;
		var filter=/^([a-zA-Z0-9_.+-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,6})+$/;
		if (cli_e_mail.replace(/ /g, '') == '' || !filter.test(cli_e_mail)) {
			alert('El E-mail de contacto no es valido.');
			errCount++;			
		}
	}
}

function validate_Comments(){	
	comments=document.getElementById('frm_req_cmnt').value
	if (comments.replace(/ /g, '') == '') {
		alert('Por favor escriba sus comentarios');
		errCount++;		
	}
}
