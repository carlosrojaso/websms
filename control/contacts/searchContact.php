<?php
/**
 * searchUser.php
 * 
 * Datos del Usuario
 * @author Carlos A. Rojas <carlkant@gmail.com> 
 * @version 1.0
 * @package contacts
 * @creacion: 20/05/2007
 * @license: GNU/GPL	
*/


include_once('../../includes/session.inc');
//check_login();



// include the JavaScript tooltip generator class
require_once('../../includes/tooltips/class.tooltips.php');

// instantiate the class
$tt = new tooltips();

/*TOOLTIP*/
// set some properties for the tooltip
// THIS MUST BE DONE BEFORE CALLING THE init() METHOD!

// tell the tooltips to start fading in only after it have waited for 100 milliseconds
$tt->fadeInDelay = 50;
// tell the tooltips to start fading out only after 3 seconds
// this is to show how more than just one tooltip can be visible on the screen at the same time!
$tt->fadeOutDelay = 200;

$tt->offsetX=0;

$tt->offsetY=0;
// see the manual for what other properties can be set!

// notice that we init the tooltips in the <BODY> !
$tt->init();


/**Fin generador de Tooltip*/



/***********INTERNACIONALIZACION *********/
include_once('../../lang/contact/ui/addContactPar.php');
include_once('../../lang/contact/ui/addContactPro.php');
include_once('../../lang/contact/ui/addContactPar_errorMessage.php');
include_once('../../lang/contact/ui/addContactPro_errorMessage.php');
/******************************/


include_once('../../includes/simplepage.class.php');
require_once('../../data/db.class.php');
$obj = new simplepage();
$obj->setTitle("Editar Cliente");
$obj->setCSS("../../includes/style/style.css");
$obj->setJS("../../includes/calendario/javascripts.js");
$obj->setJS("../../includes/validate/contacts/addContactPro.js");
$obj->setJS("../../includes/validate/contacts/addContactPar.js");

echo $obj->getHeader();
$img_dir = "../../images";


include_once('../../includes/calendario/calendario.php');
include_once('../../includes/simplepage.class.php');

$obj = new simplepage();
$obj->setTitle($title);
$obj->setCSS("../../../includes/style.css");
$obj->setJS("../../../includes/validator/contacts/addContactPar.js");
$obj->setJS("../../../includes/calendario/javascripts.js");





$lastname1;
$lastname2;
$criterio =''; // Criterio de Busqueda
$parametro = 1; // Busqueda Normal

/*******
* parametro.
* 1: busqueda
* 2: modificacion
*/


if($_GET[par])
{
	$parametro = $_GET[par];
	$id = $_GET['id'];
}




$db = new db_class;
if (!$db->connect()) {
	$db->print_last_error(false);
}
//echo 'usuario'.$usuario.'<br>';
if(trim($id)<>''){
	$_sql = "	SELECT 	*
						FROM 
							contact
						WHERE 
							id_contact = $id
							AND cont_current_flag=1";
}


//echo 'Consulta:<br> '.$_sql;
$r = $db->select($_sql);
$row=$db->get_row($r, 'MYSQL_ASSOC');

$status=$_GET[status];

if($db -> row_count)
{
	switch($parametro)
	{
		case 1: //busqueda normal
		include_once('../../ui/contacts/formsEdit/showContactDataForm.php');
		break;
		case 2: // modificar usuario
		include_once('../../ui/contacts/formsEdit/showContactEditForm.php');
		break;
	}
}
// NO SE ENCONTRO
else{?>
	<script language="javascript">
	alert("No se encontraron coincidencias")
	location.href="../../ui/core/body.php"
	</script>
<?php
}
echo $obj->getFooter();
?>
