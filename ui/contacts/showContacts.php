<?php
include_once('../../includes/session.inc');

include_once('../../includes/simplepage.class.php');

$obj = new simplepage();

$obj->setCSS("../../includes/style/style.css" );
$obj->setJS("../../includes/calendario/javascripts.js");

echo $obj->getHeader();

if($_sql==''){
	$_sql = "
			SELECT * FROM contact WHERE cont_current_flag = 1 AND id_client=".$_SESSION[cliente_identificacion_sesion]."
			GROUP BY cont_firstname,  cont_lastname
			ORDER BY cont_lastname asc
			";
}
//echo $_sql;
/*****************************************/
$con = mysql_connect("localhost","sms","qmmF85Nv") or die (mysql_error());
mysql_select_db("sms",$con) or die (mysql_error());

//Sentencia sql (sin limit)
$_pagi_sql =$_sql;

//cantidad de resultados por página (opcional, por defecto 20)
$_pagi_cuantos = 20;//Elegí un número pequeño para que se generen varias páginas

//cantidad de enlaces que se mostrarán como máximo en la barra de navegación
$_pagi_nav_num_enlaces = 3;//Elegí un número pequeño para que se note el resultado

//Decidimos si queremos que se muesten los errores de mysql
$_pagi_mostrar_errores = true;//recomendado true sólo en tiempo de desarrollo.

//Si tenemos una consulta compleja que hace que el Paginator no funcione correctamente,
//realizamos el conteo alternativo.
$_pagi_conteo_alternativo = true;//recomendado false.

//Definimos qué estilo CSS se utilizará para los enlaces de paginación.
//El estilo debe estar definido previamente
$_pagi_nav_estilo = "forget";

//definimos qué irá en el enlace a la página anterior
$_pagi_nav_anterior = "&lt;";// podría ir un tag <img> o lo que sea

//definimos qué irá en el enlace a la página siguiente
$_pagi_nav_siguiente = "&gt;";// podría ir un tag <img> o lo que sea
/*
while($row = mysql_fetch_array($_pagi_result)){
echo $row['cli_lastname']."<br />";
}
*/
//Incluimos el script de paginación. Éste ya ejecuta la consulta automáticamente
include("../../includes/paginador/paginator.inc.php");

?>
<br>			
<table cellpadding="2" cellspacing="0" border="0" width="50%" >						
	<?php
	$actual=mysql_fetch_array($_pagi_result);
	$siguiente=mysql_fetch_array($_pagi_result);
	if($actual){
		echo '<tr>';
		echo '<td colspan="3" class="titulo"><b>'.strtoupper(substr($actual['cont_lastname'],0,1)).'</b></td>';
		echo '</tr>';

		echo '<tr>';
		echo '<td class="label">'.$actual['cont_lastname'].' '.$actual['cont_firstname'].'</td>';
		echo '<td >(<a href="../../control/contacts/searchContact.php?id='.$actual['id_contact'].'&par=1&status='.substr($actual[cont_current_flag],0,1).'" style="color:##FF0000">'.$actual['cont_firstname'].'</a>)</td>';
		//echo '<td class="label">'.$actual['cont_current_flag'].'</td>';
		echo '</tr>';

		while($siguiente){
			if(substr($actual['cont_lastname'],0,1)!=substr($siguiente['cont_lastname'],0,1)){
				echo '<tr>';
				echo '<td colspan="3" class="titulo"><b>'.strtoupper(substr($siguiente['cont_lastname'],0,1)).'</b></td>';
				echo '</tr>';
			}
			$actual=$siguiente;
			echo '<tr>';
			echo '<td class="label">'.$actual['cont_lastname'].' '.$actual['cont_firstname'].'</td>';
			echo '<td >(<a href="../../control/contacts/searchContact.php?id='.$actual['id_contact'].'&par=1&status='.substr($actual[cont_current_flag],0,1).'" style="color:##FF0000">'.$actual['cont_firstname'].'</a>)</td>';
			//echo '<td class="label">'.$actual['cont_current_flag'].'</td>';
			echo '</tr>';

			$siguiente=mysql_fetch_array($_pagi_result);

		}
	}else{
		echo '
			<tr>
				<td><b>No se encontró ninguna conincidencia.</b></td>
			</tr>';
	}
	?>				
</table>	

<br><br><br><br><br><br><br><br><br>

<?php
//Incluimos la barra de navegación
echo"<p>".$_pagi_navegacion."</p>";

//Incluimos la información de la página actual
echo"<p>Mostrando Contactos ".$_pagi_info."</p>";
/******************************************/
echo $obj->getFooter();
?>