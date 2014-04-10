/*
*Construido por: Victor Manuel Vallecilla
*Nombre:validate_selectAlertType.js
*Validacion de la forma de seleccion de tipo de alertas para las prescripciones
*Fecha: 29/12/2007
*
**/

function editClient(){

}

function editUser(){

}

//Validar los campos obligatorios
function validate_MandatoryFields(){

}

function checkDays(){
	if(document.getElementById('all').checked){		
		for(i=0;i<7;i++){
			document.getElementById('day'+i).checked=false;
		}
		document.getElementById("all").value=1;
	}
}

function cancelPrescription(){
	if(confirm("¿Desea cancelar esa prescripción?")){
		location.href="../../ui/core/body.php";
	}else{
		
	}
}

function selectWeekDays(day){
	//alert(day.id);
	document.getElementById("all").checked=false;
	document.getElementById(day.id).value=1;
}