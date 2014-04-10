<?php
include_once('../../includes/session.inc');

include_once('../../control/user/querySearch.php');
if($_sql==''){
	$_sql="SELECT cli_lastname,cli_firstname,user_login,user_status_nm " .
			" FROM client, users, user_profile, user_status
	   WHERE users.id_client=client.id_client
	   AND users.user_current_flag=1 
	   AND client.cli_current_flag=1
	   AND users.user_prof_cd=user_profile.user_prof_cd
	   AND user_profile.user_prof_group_cd='E'
	   AND users.user_status_cd=user_status.user_status_cd
	   AND user_status.user_status_lang='".$_SESSION[idm]."'
	   GROUP BY cli_firstname, cli_lastname, user_login,user_status_nm
	   ORDER BY cli_lastname asc";
}
//echo $_sql;
/*****************************************/
$con = mysql_connect("localhost","sms","qmmF85Nv") or die (mysql_error());
mysql_select_db("sms",$con) or die (mysql_error());

//Sentencia sql (sin limit)
$_pagi_sql =$_sql;

//cantidad de resultados por p�gina (opcional, por defecto 20)
$_pagi_cuantos = 20;//Eleg� un n�mero peque�o para que se generen varias p�ginas

//cantidad de enlaces que se mostrar�n como m�ximo en la barra de navegaci�n
$_pagi_nav_num_enlaces = 3;//Eleg� un n�mero peque�o para que se note el resultado

//Decidimos si queremos que se muesten los errores de mysql
$_pagi_mostrar_errores = true;//recomendado true s�lo en tiempo de desarrollo.

//Si tenemos una consulta compleja que hace que el Paginator no funcione correctamente,
//realizamos el conteo alternativo.
$_pagi_conteo_alternativo = true;//recomendado false.

//Definimos qu� estilo CSS se utilizar� para los enlaces de paginaci�n.
//El estilo debe estar definido previamente
$_pagi_nav_estilo = "forget";

//definimos qu� ir� en el enlace a la p�gina anterior
$_pagi_nav_anterior = "&lt;";// podr�a ir un tag <img> o lo que sea

//definimos qu� ir� en el enlace a la p�gina siguiente
$_pagi_nav_siguiente = "&gt;";// podr�a ir un tag <img> o lo que sea
/*
while($row = mysql_fetch_array($_pagi_result)){
echo $row['cli_lastname']."<br />";
}
*/
//Incluimos el script de paginaci�n. �ste ya ejecuta la consulta autom�ticamente
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
		echo '<td colspan="3" class="titulo"><b>'.strtoupper(substr($actual['cli_lastname'],0,1)).'</b></td>';
		echo '</tr>';

		echo '<tr>';
		echo '<td class="label">'.$actual['cli_lastname'].' '.$actual['cli_firstname'].'</td>';
		echo '<td >(<a href="../../control/user/searchUser.php?usuario='.$actual['user_login'].'&par=1&status='.substr($actual[user_status_nm],0,1).'" style="color:##FF0000">'.$actual['user_login'].'</a>)</td>';
		echo '<td class="label">'.$actual['user_status_nm'].'</td>';
		echo '</tr>';

		while($siguiente){
			if(substr($actual['cli_lastname'],0,1)!=substr($siguiente['cli_lastname'],0,1)){
				echo '<tr>';
				echo '<td colspan="3" class="titulo"><b>'.strtoupper(substr($siguiente['cli_lastname'],0,1)).'</b></td>';
				echo '</tr>';
			}
			$actual=$siguiente;
			echo '<tr>';
			echo '<td class="label">'.$actual['cli_lastname'].' '.$actual['cli_firstname'].'</td>';
			echo '<td >(<a href="../../control/user/searchUser.php?usuario='.$actual['user_login'].'&par=1&status='.substr($actual[user_status_nm],0,1).'" style="color:##FF0000">'.$actual['user_login'].'</a>)</td>';
			echo '<td class="label">'.$actual['user_status_nm'].'</td>';
			echo '</tr>';

			$siguiente=mysql_fetch_array($_pagi_result);

		}
	}else{
		echo '
			<tr>
				<td><b>No se encontr� ninguna conincidencia.</b></td>
			</tr>';
	}
	?>				
</table>	

<br><br><br><br><br><br><br><br><br>

<?php
include_once('searchUser.php');
//Incluimos la barra de navegaci�n
echo"<p>".$_pagi_navegacion."</p>";

//Incluimos la informaci�n de la p�gina actual
echo"<p>Mostrando Clientes ".$_pagi_info."</p>";
/******************************************/
echo $obj->getFooter();
?>