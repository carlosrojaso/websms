<?php
include_once('../../includes/simplepage.class.php');
include_once('../../includes/session.inc');
$obj = new simplepage();
$obj->setTitle("OnSpot.es - Centro de Atenci&oacute;n al Cliente");
$obj->setCSS("../../includes/style/style.css");
echo $obj->getHeader();
$img_dir = "../../images/";
$try = "http://websms.adminnova.com/websms/ui/core/login.php"; 
$helpdesk = "";
?>
<br/><br/><br/>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="605" class="celdas3"><span class="tituloatencioncliente">Bienvenido al Centro de Atenci&oacute;n al Cliente<br><br></span></td>
  </tr>
  <tr>
    <td class="celdas3"><span class="subtituloatencioncliente">Para resolver sus dudas, solucionar problemas o cualquier otra cuesti&oacute;n, lo puede hacer poniendose en contacto con nosotros de las siguientes formas:</span><br><br></td>
  </tr>
  <tr>
    <td class="celdas3"><span class="viñetaatencioncliente">1. Rellene nuetro formulario:</span> <a href="../../ui/helpdesk/requestHelp.php" class="subtituloatencioncliente">Formulario de Atención al cliente</a><br>
      <span class="contenidoatencioncliente">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Con el fin de poder dar una mejor respuesta a tus sugerencias o solicitudes, puedes entrar en <br>&nbsp;&nbsp;&nbsp;&nbsp; nuestro</span> <a href="../../ui/helpdesk/requestHelp.php" class="contenidoviñetaatencioncliente">Formulario</a> y, en breve, te contestaremos</span>. <br>
    <br></td>
  </tr>
  <tr>
    <td class="celdas3"><span class="viñetaatencioncliente">2. Ll&aacute;manos al Centro de Atenci&oacute;n al Cliente</span>: <span class="subtituloatencioncliente">902 902 902</span> <br>
    &nbsp;&nbsp;&nbsp;<span class="contenidoatencioncliente">Lunes a Viernes de 09:00 a 21:00 horas.<br>
    &nbsp;&nbsp;&nbsp;
    S&aacute;bados de 12:00 a 18:00 horas.</span><br><br> </td>
  </tr>
  <tr>
    <td><span class="viñetaatencioncliente">3. Ll&aacute;manos gratis mediante Skype</span> <br> </td>
  </tr>
</table>
<br/><br/><br/><br/><br/><br/><br/>
<?php
echo $obj->getFooter();
?>
