<?php
include_once('../../includes/session.inc');
include_once('../../includes/simplepage.class.php');
$obj = new simplepage();
$obj->setTitle("Editar Cliente");
$obj->setCSS("../../includes/style/style.css");
include_once('../../control/user/querySearchInternals.php');
if($_sql==''){
	$_sql="SELECT user_prof_nm,cli_firstname, cli_lastname, user_login, user_status_nm,cli_country_cd, user_info_upd,user_info_cre
			FROM client, users, user_profile, user_status
			WHERE client.id_client=users.id_client 
			AND users.user_prof_cd=user_profile.user_prof_cd 
			AND users.user_status_cd=user_status.user_status_cd
			AND user_status.user_status_lang='".$_SESSION[idm]."'
			AND user_profile.user_prof_lang='".$_SESSION[idm]."'
			AND client.cli_current_flag=1
			AND users.user_current_flag=1
			AND user_profile.user_prof_group_cd='I'
			GROUP BY user_prof_nm, user_status.user_status_nm,cli_firstname, cli_lastname, user_login, user_status_nm 
			ORDER BY user_prof_nm asc";
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
	$actual=mysql_fetch_array($_pagi_result);
	$siguiente=mysql_fetch_array($_pagi_result);
	if($actual){
		echo '<tr>';
		echo '<td colspan="3" class="titulo"><b>'.strtoupper($actual['user_prof_nm']).'</b></td>';
		echo '</tr>';

		echo '<tr>';
		echo '<td class="label">'.$actual['cli_lastname'].' '.$actual['cli_firstname'].'</td>';
		echo '<td >(<a href="../../control/user/searchUserInternals.php?usuario='.$actual['user_login'].'&par=1&status='.substr($actual[user_status_nm],0,1).'" style="color:##FF0000">'.$actual['user_login'].'</a>)</td>';
		echo '<td class="label">'.$actual['user_status_nm'].'</td>';
		echo '</tr>';

		while($siguiente){
			if($actual['user_prof_nm']!=$siguiente['user_prof_nm']){
				echo '<tr>';
				echo '<td colspan="3" class="titulo"><b>'.strtoupper($siguiente['user_prof_nm']).'</b></td>';
				echo '</tr>';
			}
			$actual=$siguiente;
			echo '<tr>';
			echo '<td class="label">'.$actual['cli_lastname'].' '.$actual['cli_firstname'].'</td>';
			echo '<td >(<a href="../../control/user/searchUserInternals.php?usuario='.$actual['user_login'].'&par=1&status='.substr($actual[user_status_nm],0,1).'" style="color:##FF0000">'.$actual['user_login'].'</a>)</td>';
			echo '<td class="label">'.$actual['user_status_nm'].'</td>';
			echo '</tr>';

			$siguiente=mysql_fetch_array($_pagi_result);

		}
	}else {
		echo '
			<tr>
				<td><b>No se encontró ninguna conincidencia.</b></td>
			</tr>';
	}
	?>				
</table>	
<br><br><br>
<?php
include_once('searchInternalUser.php');
//Incluimos la barra de navegación
echo"<p>".$_pagi_navegacion."</p>";

//Incluimos la información de la página actual
echo"<p>Mostrando Usuarios ".$_pagi_info."</p>";
/******************************************/
echo $obj->getFooter();
?>