<?php
include_once ('../../includes/session.inc');

if ($_sql == '') {
	$_sql = "SELECT " .
	"user_prof_nm," .
	"CASE user_prof_status WHEN 'A' THEN \"Activo\" WHEN 'D' THEN \"Desactivado\" END AS state," .
	"user_prof_cd " .
	" FROM user_profile 
	   WHERE 	   
	   		user_prof_lang='SP' AND
	   		user_prof_current_flag=1
	   GROUP BY user_prof_nm, state, user_prof_cd
	   ORDER BY user_prof_nm asc";
}
//echo $_sql;
/*****************************************/
$con = mysql_connect("localhost", "sms", "qmmF85Nv") or die(mysql_error());
mysql_select_db("sms", $con) or die(mysql_error());

//Sentencia sql (sin limit)
$_pagi_sql = $_sql;

//cantidad de resultados por p�gina (opcional, por defecto 20)
$_pagi_cuantos = 20; //Eleg� un n�mero peque�o para que se generen varias p�ginas

//cantidad de enlaces que se mostrar�n como m�ximo en la barra de navegaci�n
$_pagi_nav_num_enlaces = 3; //Eleg� un n�mero peque�o para que se note el resultado

//Decidimos si queremos que se muesten los errores de mysql
$_pagi_mostrar_errores = true; //recomendado true s�lo en tiempo de desarrollo.

//Si tenemos una consulta compleja que hace que el Paginator no funcione correctamente,
//realizamos el conteo alternativo.
$_pagi_conteo_alternativo = true; //recomendado false.

//Definimos qu� estilo CSS se utilizar� para los enlaces de paginaci�n.
//El estilo debe estar definido previamente
$_pagi_nav_estilo = "forget";

//definimos qu� ir� en el enlace a la p�gina anterior
$_pagi_nav_anterior = "&lt;"; // podr�a ir un tag <img> o lo que sea

//definimos qu� ir� en el enlace a la p�gina siguiente
$_pagi_nav_siguiente = "&gt;"; // podr�a ir un tag <img> o lo que sea
/*
while($row = mysql_fetch_array($_pagi_result)){
echo $row['cli_lastname']."<br />";
}
*/
//Incluimos el script de paginaci�n. �ste ya ejecuta la consulta autom�ticamente
include ("../../includes/paginador/paginator.inc.php");
include_once('../../includes/simplepage.class.php');
$obj = new simplepage();
$obj->setTitle($title);
$obj->setCSS("../../includes/style/style.css");
echo $obj->getHeader();
$img_dir = "../../images";

?>
<br>			
<table cellpadding="2" cellspacing="0" border="0" width="50%" >						
	
	<?php

$actual = mysql_fetch_array($_pagi_result);
$siguiente = mysql_fetch_array($_pagi_result);
if ($actual) {
	echo '<tr>';
	echo '<td colspan="3" class="titulo"><b>' . strtoupper(substr($actual['user_prof_nm'], 0, 1)) . '</b></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td ><a href="../../control/profile/searchProfile.php?perfil=' . $actual['user_prof_cd'] . '&par=1&status=' . substr($actual[state], 0, 1) . '" style="color:##FF0000">' . $actual['user_prof_nm'] . '</a></td>';
	echo '<td class="label">' . $actual['state'] . '</td>';
	echo '</tr>';

	while ($siguiente) {
		if (substr($actual['user_prof_nm'], 0, 1) != substr($siguiente['user_prof_nm'], 0, 1)) {
			echo '<tr>';
			echo '<td colspan="3" class="titulo"><b>' . strtoupper(substr($siguiente['user_prof_nm'], 0, 1)) . '</b></td>';
			echo '</tr>';
		}
		$actual = $siguiente;
		echo '<tr>';
		echo '<td ><a href="../../control/profile/searchProfile.php?perfil=' . $actual['user_prof_cd'] . '&par=1&status=' . substr($actual[state], 0, 1) . '" style="color:##FF0000">' . $actual['user_prof_nm'] . '</a></td>';
		echo '<td class="label">' . $actual['state'] . '</td>';

		echo '</tr>';

		$siguiente = mysql_fetch_array($_pagi_result);

	}
} else {
	echo '
				<tr>
					<td><b>No se encontr� ninguna conincidencia.</b></td>
				</tr>';
}
?>				
</table>	

<br><br><br><br><br><br><br><br><br>

<?php


//Incluimos la barra de navegaci�n
echo "<p>" . $_pagi_navegacion . "</p>";

//Incluimos la informaci�n de la p�gina actual
echo "<p>Mostrando Perfiles " . $_pagi_info . "</p>";
/******************************************/
echo $obj->getFooter();
?>