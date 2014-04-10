/*
*Construido por: Victor Manuel Vallecilla
*Nombre:validate_selectAlertType.js
*Validacion de la forma de seleccion de tipo de alertas para las prescripciones
*Fecha: 29/12/2007
*
**/

//Validacion de los campos obligatorios
function validateMandatoryFields(){	
	cant=document.getElementById('alert_type_cant').value;
	var checked=0;
	for(i=0;i<cant;i++){
		name='alert_type_' + i;		
		if(document.getElementById(name).checked){
			checked=1;
		}
	}
	if(checked!=0){
		document.forma.submit();
	}else{
		alert("Por favor seleccione una alerta");
	}	
}

function cancelPrescription(){
	if(confirm("¿Desea cancelar esa prescripción?")){
		location.href="../../ui/core/body.php";
	}else{
		
	}
}