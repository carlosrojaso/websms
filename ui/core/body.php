<?php
/*
* Created on 20/08/2007
* Created by Carlos A. Rojas
* Name of File: body.php
*
*/
/***************Includes********************/
//Comprobacion de session
include_once('../../includes/session.inc');
check_login();
//Internacionalizacion
include_once('../../lang/core/ui/body.php');
////Pagina HTML
include_once('../../includes/simplepage.class.php');
/*******************************************/

$obj = new simplepage();
$obj->setCSS("../../includes/style/style.css");
$obj->setCSS("../../includes/menu.css");
echo $obj->getHeader();

?>

<br><br><br><br><br>
<span class="tituloatencioncliente"><?php echo $title;?></span>
<br><br>
<span class="contenidoatencioncliente"><?php echo $msg;?></span>
<br><br><br><br><br><br><br><br><br><br>
<?php echo $obj->getFooter();?>