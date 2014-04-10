/*
*Construido por: Victor Manuel Vallecilla
*Nombre:validate_editProfile
*Validacion de la forma de modificacion para Perfiles
*Fecha: 03/10/2007
*
**/

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
	validate_user_prof_group_cd();
	validate_module_selection();
	if(document.forma.user_prof_date_in!=undefined && document.forma.user_prof_date_in.type!='hidden'){
		validate_user_prof_date_in();
	}else{
		var td = new Date();
		validate_user_prof_date_out(new Date(td.getFullYear(),td.getMonth(),td.getDate()));
	}


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
		modules='';
		page='../../control/profile/editProfile.php?user_prof_nm='+document.forma.user_prof_nm.value+'&modules=';
		for(i=1;i<=document.forma.check_size.value;i++){			
			if(document.getElementById('module_'+i).checked==true){				
				if(document.getElementById('module_'+i).value!=''){				
					modules+= (document.getElementById('module_'+i).value)+',';
				}				
			}
		}		
		modules=modules.substring(0,(modules.length-1));
		page+=modules;	
		if(document.forma.user_prof_date_in!=undefined){
			page+='&user_prof_date_in='+document.forma.user_prof_date_in.value;
		}		
		page+='&user_prof_group_cd=' + document.forma.user_prof_group_cd.value;
		page+='&user_prof_cd='+ document.forma.user_prof_cd.value;
		page+='&user_prof_cre='+ document.forma.user_prof_cre.value;
		page+='&user_prof_status='+ document.forma.user_prof_status.value;		
		
		if(document.forma.user_prof_date_out.value!='Indefinida'){
			page+='&user_prof_date_out='+document.forma.user_prof_date_out.value;
		}

		location.href=page;
		//document.forma.submit();
		//alert(page);

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

	document.getElementById('required_user_prof_nm').style.display='none';
	document.getElementById('required_user_prof_group_cd').style.display='none';
	document.getElementById('required_module_selection').style.display='none';
	if(document.forma.user_prof_date_in!=undefined && document.forma.user_prof_date_in.type!='hidden'){		
		document.getElementById('required_user_prof_date_in').style.display='none';
	}
}

//Validacion de cada uno de los campos obligatorios del formulario.

function validate_name(){//Validar el ingreso del nombre
	user_prof_nm=document.getElementById('user_prof_nm').value;
	if (user_prof_nm.replace(/ /g, '') == '') {
		if(firstErr==null){
			firstErr=document.getElementById('user_prof_nm');
		}

		document.getElementById('required_user_prof_nm').style.display='inline';
		document.getElementById('required_user_prof_nm').style.color='#FF0000';

		errMsg[errCount]='Hay que poner un nombre al perfil';
		errCount++;
	}
}

function validate_user_prof_group_cd(){
	user_prof_group_cd=document.getElementById('user_prof_group_cd').value;
	if(user_prof_group_cd==-1){
		if(firstErr==null){
			firstErr=document.getElementById('user_prof_group_cd');
		}

		document.getElementById('required_user_prof_group_cd').style.display='inline';
		document.getElementById('required_user_prof_group_cd').style.color='#FF0000';

		errMsg[errCount]='Por favor seleccione el grupo de usuarios';
		errCount++;
	}
}

function validate_module_selection(){//Validar la seleccion de uno de los modulos
	for(i=1;i<=document.forma.check_size.value;i++){
		if(document.getElementById('module_'+i).checked==true){
			return;
		}
	}
	if(firstErr==null){
		firstErr=document.getElementById('module_selection');
	}
	errMsg[errCount]='Hay que seleccionar por lo menos un modulo del sitio web';
	errCount++;
}

function validate_user_prof_date_in(){
	var arr_date_in;
	var cmp_date_in;

	if(document.forma.user_prof_date_in.value!=''){
		arr_date_in = document.forma.user_prof_date_in.value.split("/");
		var td = new Date();
		var cmp_date_today = new Date(td.getFullYear(),td.getMonth(),td.getDate());
		cmp_date_in = new Date(arr_date_in[0], (arr_date_in[1]-1), arr_date_in[2]);

		if(cmp_date_in < cmp_date_today){
			if(firstErr==null){
				firstErr=document.getElementById('user_prof_date_in');
			}

			document.getElementById('required_user_prof_date_in').style.display='inline';
			document.getElementById('required_user_prof_date_in').style.color='#FF0000';

			errMsg[errCount]='La fecha de inicio de validez tiene que ser superior o igual al día de hoy';

			errCount++;

		}
		validate_user_prof_date_out(cmp_date_in);
	}else{
		if(firstErr==null){
			firstErr=document.getElementById('user_prof_date_in');
		}

		document.getElementById('required_user_prof_date_in').style.display='inline';
		document.getElementById('required_user_prof_date_in').style.color='#FF0000';

		errMsg[errCount]='Por favor informe la fecha de inicio.';

		errCount++;
	}
}

function validate_user_prof_date_out(cmp_date_in){
	var cmp_date_out;
	var arr_date_out;

	if(document.forma.user_prof_date_out.value!=''){
		arr_date_out = document.forma.user_prof_date_out.value.split("/");
		cmp_date_out = new Date(arr_date_out[0], (arr_date_out[1]-1), arr_date_out[2]);
		if(cmp_date_out < cmp_date_in){
			if(firstErr==null){
				firstErr=document.getElementById('user_prof_date_out');
			}

			document.getElementById('required_user_prof_date_out').style.display='inline';
			document.getElementById('required_user_prof_date_out').style.color='#FF0000';

			errMsg[errCount]='La fecha de fin de validez tiene que ser superior a la fecha de inicio de validez o sin especificar';

			errCount++;
		}
	}
}

function selectAllChildren(numberOfChildren,father){
	if(document.getElementById('module_'+father).checked==true){
		for(i=1;i<=document.forma.check_size.value;i++){
			if(i==father){
				for(j=i;j<=(i+numberOfChildren);j++){
					document.getElementById('module_'+j).checked=true;
				}
			}
		}
	}else{
		for(i=1;i<=document.forma.check_size.value;i++){
			if(i==father){
				for(j=i;j<=(i+numberOfChildren);j++){
					document.getElementById('module_'+j).checked=false;
				}
			}
		}
	}
}

