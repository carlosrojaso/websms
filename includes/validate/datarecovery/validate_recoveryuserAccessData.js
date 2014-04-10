/*
*Construido por: Victor Manuel Vallecilla
*Nombre:validate_recoveryUserAccessData.js
*Validacion de la forma para recuperacion de datos de acceso
*Fecha: 30/12/2007
*
**/

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