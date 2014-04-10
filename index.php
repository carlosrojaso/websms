<?php
/*
 * Created on 04/09/2007
 * Created by Carlos A. Rojas
 * Name of File: index.php
 *
 * Description:
 * 
 * - Captura la ip y pregunta a i2m.class.php la ubicacion.
 * - Realiza la redireccion hacia ui/core/login.php con el idioma.
 * 
 */
 
require_once('includes/ip2more/i2m.class.php');

		if(isset($_GET['ip']) &&  !empty($_GET['ip'])){
		  $i2m = new ip2more($_GET['ip'], true);  
		} else {
		  $i2m = new ip2more(null, true); 
		}

$country = $i2m->country['iso3']; // capturamos el pais segun el formato ISO3
$ip = $i2m->ip;

	if($country == 'UNK') // No se puede determinar la ubicacion.
	{
	 header('location:ui/core/unknow.php'); // debe elegir el pais
	}
	elseif($country == 'USA') // Ingles - por ahora solo si viene de USA
	{
	 $lang = 'UK';	
	}
	else{// defecto español
	 $lang = 'SP';	
	}
header('location:ui/core/login.php?lang='.$lang);

?>