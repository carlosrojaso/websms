/*
*Construido por: Victor Manuel Vallecilla
*Nombre:validate_addBonus.js
*Validacion de la forma de ingreso de nuevos bonos
*Fecha: 04/01/2008
*
**/

var errMsg = new Array();
var errCount=0;
var firstErr=null;
var field='';

function editClient(){}

function editUser(){}

function validateMandatoryFields(){
	errMsg = new Array();
	errCount=0;

	//Colocar en el estado inicial al campo resaltado
	resetFields(field);
	firstErr=null;

	//Llamado a las funciones de validacion de los campos
	validate_code();
	validate_name();
	validate_description();
	validate_credit_number();
	validate_credit_price();
	validate_credit_number();
	validate_credit_price();
	validate_credit_begin_date();
	validate_credit_cli_act_cd();
	validate_credit_max_cli();

	

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

	document.getElementById('required_credit_cd').style.display='none';
	document.getElementById('required_credit_nm').style.display='none';
	document.getElementById('required_credit_dsc').style.display='none';
	document.getElementById('required_credit_num').style.display='none';	
	document.getElementById('required_credit_price').style.display='none';
	document.getElementById('required_credit_begin_date').style.display='none';
	document.getElementById('required_credit_end_date').style.display='none';
	document.getElementById('required_credit_cli_act_cd').style.display='none';
	//document.getElementById('required_credit_max_cli').style.display='none';
}

function validate_code(){//Validar el ingreso del codigo
	credit_cd=document.getElementById('credit_cd').value;
	if (credit_cd.replace(/ /g, '') == '') {
		if(firstErr==null){
			firstErr=document.getElementById('credit_cd');
		}

		document.getElementById('required_credit_cd').style.display='inline';
		document.getElementById('required_credit_cd').style.color='#FF0000';

		errMsg[errCount]='Hay que crear un código para el bono';
		errCount++;
	}
}

function validate_name(){
	credit_nm=document.getElementById('credit_nm').value;
	if (credit_nm.replace(/ /g, '') == '') {
		if(firstErr==null){
			firstErr=document.getElementById('credit_nm');
		}

		document.getElementById('required_credit_nm').style.display='inline';
		document.getElementById('required_credit_nm').style.color='#FF0000';

		errMsg[errCount]='Hay que dar un nombre al bono';
		errCount++;
	}
}

function validate_description(){
	credit_dsc=document.getElementById('credit_dsc').value;
	if (credit_dsc.replace(/ /g, '') == '') {
		if(firstErr==null){
			firstErr=document.getElementById('credit_dsc');
		}

		document.getElementById('required_credit_dsc').style.display='inline';
		document.getElementById('required_credit_dsc').style.color='#FF0000';

		errMsg[errCount]='Hay que poner una descripción al bono';
		errCount++;
	}
}

function validate_credit_number(){
	credit_num=document.getElementById('credit_num').value;
	if (credit_num.replace(/ /g, '') == '') {
		if(firstErr==null){
			firstErr=document.getElementById('credit_num');
		}

		document.getElementById('required_credit_num').style.display='inline';
		document.getElementById('required_credit_num').style.color='#FF0000';

		errMsg[errCount]='Hay que especificar el número de créditos del bono';
		errCount++;
	}
}

function validate_credit_price(){
	credit_price=document.getElementById('credit_price').value;
	if (credit_price.replace(/ /g, '') == '') {
		if(firstErr==null){
			firstErr=document.getElementById('credit_price');
		}

		document.getElementById('required_credit_price').style.display='inline';
		document.getElementById('required_credit_price').style.color='#FF0000';

		errMsg[errCount]='Hay que especificar el valor del bono';
		errCount++;
	}
}

function validate_credit_begin_date(){
	var arr_date_in;
	var cmp_date_in;
	
	if(document.forma.credit_begin_date.value!=''){
		arr_date_in = document.forma.credit_begin_date.value.split("/");
		var td = new Date();
		var cmp_date_today = new Date(td.getFullYear(),td.getMonth(),td.getDate());
		cmp_date_in = new Date(arr_date_in[0], (arr_date_in[1]-1), arr_date_in[2]);

		if(cmp_date_in < cmp_date_today){
			if(firstErr==null){
				firstErr=document.getElementById('credit_begin_date');
			}

			document.getElementById('required_credit_begin_date').style.display='inline';
			document.getElementById('required_credit_begin_date').style.color='#FF0000';

			errMsg[errCount]='La fecha de inicio de validez tiene que ser superior o igual al día de hoy';

			errCount++;

		}
		validate_credit_end_date(cmp_date_in);
	}else{
		if(firstErr==null){
			firstErr=document.getElementById('credit_begin_date');
		}

		document.getElementById('required_credit_begin_date').style.display='inline';
		document.getElementById('required_credit_begin_date').style.color='#FF0000';

		errMsg[errCount]='Por favor informe la fecha de inicio.';

		errCount++;
	}
}

function validate_credit_end_date(cmp_date_in){
	var cmp_date_out;
	var arr_date_out;
	
	if(document.forma.credit_end_date.value!=''){
		arr_date_out = document.forma.credit_end_date.value.split("/");
		cmp_date_out = new Date(arr_date_out[0], (arr_date_out[1]-1), arr_date_out[2]);
		if(cmp_date_out < cmp_date_in){
			if(firstErr==null){
				firstErr=document.getElementById('credit_end_date');
			}

			document.getElementById('required_credit_end_date').style.display='inline';
			document.getElementById('required_credit_end_date').style.color='#FF0000';

			errMsg[errCount]='La fecha de fin de validez tiene que ser superior a la fecha de inicio de validez o sin especificar';

			errCount++;
		}
	}
}

function validate_credit_cli_act_cd(){//Validar la seleccion del tratamiento
	credit_cli_act_cd=document.getElementById('credit_cli_act_cd').value;
	if(credit_cli_act_cd==-1){
		if(firstErr==null){
			firstErr=document.getElementById('credit_cli_act_cd');
		}

		document.getElementById('required_credit_cli_act_cd').style.display='inline';
		document.getElementById('required_credit_cli_act_cd').style.color='#FF0000';

		errMsg[errCount]='Hay que especificar el tipo de usuario que tiene acceso al bono';
		errCount++;
	}
}

function validate_credit_max_cli(){
	if(document.getElementById("cre_max_cli").checked){
		credit_max_cli=document.getElementById('credit_max_cli').value;
		if (credit_max_cli.replace(/ /g, '') == '' || credit_max_cli<=0) {
			if(firstErr==null){
				firstErr=document.getElementById('credit_max_cli');
			}
	
			document.getElementById('required_credit_max_cli').style.display='inline';
			document.getElementById('required_credit_max_cli').style.color='#FF0000';
	
			errMsg[errCount]='El número máximo de clientes tiene que ser superior a 0';
			errCount++;
		}
	}
}

//Mostrar o no <show=true | false> una capa <layer> en un modo determinado <disply_mode>
function showLayer(show,layer,display_mode){
	if(show.checked){		
		document.getElementById(layer).style.display=display_mode;		
	}else{
		document.getElementById(layer).style.display='none';
	}
}

function setFreeBonus(flag){
	if(flag.value==1){
		document.getElementById('credit_free_flag').value=1;
	}else{
		document.getElementById('credit_free_flag').value=0;
	}
}