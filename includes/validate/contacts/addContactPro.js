/**
 * addContactPar.js
 * 
 * Validacion de UI  contacto profesional.
 * 
 * @author Carlos A. Rojas <carlkant@gmail.com>
 * @version 1.0
 * @package 
 * @creacion: 01/08/2007
 * @license: 	
*/

var errMsg = new Array();
var errCount=0;
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
	validate_name();
	validate_lastname();
	checkFields();	
	validate_cont_postal_cd();
	validate_cont_sex_cd();
	
	
	

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

	document.getElementById('required_cont_firstname').style.display='none';
	document.getElementById('required_cont_lastname').style.display='none';
	document.getElementById('required_cont_e_mail').style.display='none';
	document.getElementById('required_cont_postal_cd').style.display='none';	
	document.getElementById('required_cont_sex_cd').style.display='none';
	document.getElementById('required_cont_cell_phone').style.display='none';
	document.getElementById('required_cont_phone').style.display='none';	
	
}

//Validacion de cada uno de los campos obligatorios del formulario.

function validate_name(){//Validar el ingreso del nombre
	cli_firstname=document.getElementById('cont_firstname').value;
	if (cli_firstname.replace(/ /g, '') == '') {
		if(firstErr==null){
			firstErr=document.getElementById('cont_firstname');
		}

		document.getElementById('required_cont_firstname').style.display='inline';
		document.getElementById('required_cont_firstname').style.color='#FF0000';

		errMsg[errCount]='Por favor informe el nombre';
		errCount++;
	}
}

function validate_lastname(){//Validar el ingreso del apellido
	lastname=document.getElementById('cont_lastname').value;
	if (lastname.replace(/ /g, '') == '') {
		if(firstErr==null){
			firstErr=document.getElementById('cont_lastname');
		}

		document.getElementById('required_cont_lastname').style.display='inline';
		document.getElementById('required_cont_lastname').style.color='#FF0000';

		errMsg[errCount]='Por favor informe el apellido';
		errCount++;
		return;
	}
}

function validate_cont_e_mail(){//Validar el ingreso de la direccion de correo electronico
	cli_e_mail=document.getElementById('cont_e_mail').value;
	var filter=/^([a-zA-Z0-9_.+-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,6})+$/;
	if (cli_e_mail.replace(/ /g, '') == '' || !filter.test(cli_e_mail)) {
		if(firstErr==null){
			firstErr=document.getElementById('cont_e_mail');
		}

		document.getElementById('required_cont_e_mail').style.display='inline';
		document.getElementById('required_cont_e_mail').style.color='#FF0000';

		errMsg[errCount]='La dirección e-mail no es valida.';
		errCount++;
	}
}

function validate_cont_sex_cd(){//Validar el sexo del contacto
	cli_country_cd=document.getElementById('cont_sex_cd').value;
	if(cli_country_cd==-1){
		if(firstErr==null){
			firstErr=document.getElementById('cont_sex_cd');
		}

		document.getElementById('required_cont_sex_cd').style.display='inline';
		document.getElementById('required_cont_sex_cd').style.color='#FF0000';

		errMsg[errCount]='Por favor seleccione el sexo';
		errCount++;
	}
}

function validate_cont_postal_cd(){//Validar el codigo postal del contacto
	user_login=document.getElementById('cont_postal_cd').value;	
	if (user_login.replace(/ /g, '') == '') {
		if(firstErr==null){
			firstErr=document.getElementById('cont_postal_cd');
		}

		document.getElementById('required_cont_postal_cd').style.display='inline';
		document.getElementById('required_cont_postal_cd').style.color='#FF0000';

		errMsg[errCount]='Por favor informe el código postal';
		errCount++;
	}
}

//Validar que se escoja al menos una de las opciones al momento de crear la prescripción
function checkFields(){
	var phone=document.getElementById('cont_phone').value;
	var cell=document.getElementById('cont_cell_phone').value;
	var email=document.getElementById('cont_e_mail').value;
	if(phone=='' && cell=='' && email==''){		
		if(firstErr==null){
			firstErr=document.getElementById('cont_phone');
		}
		document.getElementById('required_cont_phone').style.display='inline';
		document.getElementById('required_cont_phone').style.color='#FF0000';
		errMsg[errCount]='Debes informar al menos uno (teléfono, teléfono móvil o email)';
		errCount++;
	}else{
		if(phone!='')
			validate_cont_phone();
		if(cell!='')
			validate_cont_cell_phone();
		if(email!='')
			validate_cont_e_mail();
	}
}

function validate_cont_phone(){//Validar el ingreso de la contraseña del usuario
	user_pass=document.getElementById('cont_phone').value;	
	if (user_pass.replace(/ /g, '') == '' || user_pass.substr(0,1)!='9' || user_pass.lenght<9){
		if(firstErr==null){
			firstErr=document.getElementById('cont_phone');
		}

		document.getElementById('required_cont_phone').style.display='inline';
		document.getElementById('required_cont_phone').style.color='#FF0000';

		errMsg[errCount]='El número de teléfono fijo no es valido';
		errCount++;
	}
}

function validate_cont_cell_phone(){//Validar que los campos contraseña y repetir contraseña coincidan
	user_pass=document.getElementById('cont_cell_phone').value;	
	if (user_pass.replace(/ /g, '') == '' || user_pass.substr(0,1)!='6' || user_pass.lenght<9) {
		if(firstErr==null){
			firstErr=document.getElementById('cont_cell_phone');
		}

		document.getElementById('required_cont_cell_phone').style.display='inline';
		document.getElementById('required_cont_cell_phone').style.color='#FF0000';

		errMsg[errCount]='El número de teléfono móvil no es valido';
		errCount++;
	}
}


