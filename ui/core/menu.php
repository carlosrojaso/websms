<?php
/*
* Created on 20/08/2007
* Created by Carlos A. Rojas
* Name of File: menu.php
*
* Menu de la aplicacion.
*
*/
//Comprobacion de session
include_once('../../includes/session.inc');
check_login();


/******INTERNACIONALIZACION****/
include_once('../../lang/core/ui/menu.php');
/******************************/
/*
echo 'Autenticado:'.$_SESSION[auth].'<br>';
echo 'Idioma:'.$_SESSION[idm].'<br>';
echo 'Login:'.$_SESSION[nombre_usuario].'<br>';
*/

switch($_SESSION[idm]){
	case 'UK':
		$title=$title_en;
		$title2=$title2_en;
		$button=$button_en;		
		break;
}

include_once('../../includes/simplepage.class.php');

$obj = new simplepage();
$obj->setTitle($title);
$obj->setCSS("../../includes/style/style.css");
$obj->setCSS("../../includes/style/menu.css");

// Conectamos con la DB
require_once('../../data/db.class.php');
$db = new db_class;
if (!$db->connect()){
	$db->print_last_error(false);
}
$_sql = "
SELECT 
 module.module_url as url,
 module.module_option_nm as name,
 module.module_nm as mname 
FROM 
 rel_prof_module JOIN module ON rel_prof_module.module_cd=module.module_cd
                 JOIN user_profile ON rel_prof_module.user_prof_cd=user_profile.user_prof_cd
		 		 JOIN users ON rel_prof_module.user_prof_cd=users.user_prof_cd
WHERE 
 users.user_login='".$_SESSION[nombre_usuario]."' AND 
 users.user_current_flag=1 AND
 user_profile.user_prof_current_flag=1 AND 
 rel_prof_module.prof_mod_current_flag=1 AND
 user_profile.user_prof_status='A' AND 
 module.module_lang='".$_SESSION[idm]."' 
GROUP BY 
 url,name,mname
ORDER BY 
 module_ord 
"; 
// sql para el menu
//echo '<br>'.$_sql.'<br>';
$modules = $db->select($_sql);

// caracteristica de idiomas
$_sql = "SELECT language_cd,language_sp FROM language"; // sql para los idiomas
$r = $db->select($_sql);
$logo_dir = "../../images/logo.jpg";

echo $obj->getHeader();
$img_dir = "../../images";
?>
	
	<table width="95%" border="0" align="left">
			<tr>
				<td align="center" bgcolor="#339900" ><img width="170" height="65" src="<?php echo $logo_dir;?>" ><br></td>
			</tr>
			<?php

			$actual=$rmodules=$db->get_row($modules, 'MYSQL_ASSOC');
			$siguiente=$rmodules=$db->get_row($modules, 'MYSQL_ASSOC');
			if($actual){
				echo '<tr>';
				echo '<td class="btnhead"><b>'.strtoupper($actual[mname]).'</b></td>';
				echo '</tr>';

				echo '<tr>';
				echo '<td class="btncont"><a href="'.$actual[url].'" target="centro">'.$actual[name].'</a></td>';
				echo '</tr>';

				while($siguiente){
					if($actual[mname]!=$siguiente[mname]){
						echo '<tr>';
						echo '<td colspan="3" class="btnhead"><b>'.strtoupper($siguiente[mname]).'</b></td>';
						echo '</tr>';
					}
					$actual=$siguiente;
					echo '<tr>';
					echo '<td class="btncont"><a href="'.$actual[url].'" target="centro">'.$actual[name].'</a></td>';
					echo '</tr>';

					$siguiente=$rmodules=$db->get_row($modules, 'MYSQL_ASSOC');

				}
			}else{
				echo '
			<tr>
				<td><b>El usuario '.$_SESSION[nombre_usuario].' no posee acceso a ning&uacute;n modulo o el perfil del usuario ha sido dado de baja.</b></td>
			</tr>';
			}
			echo '<tr>';
			echo '<td class="btnhead"><b>SESI&Oacute;N</b></td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td class="btncont"><a href="body.php" target="centro">INICIO</a></td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td class="btncont"><a href="../../control/core/logout.php" target="_parent">SALIR</a></td>';
			echo '</tr>';


?>	
			<tr>
				<td class="btnhead"><?php echo $title2;?></td>
			</tr>			
			<tr>
				<td class="btncont">
					<select name="lang" class="formas" id="lang"  onchange="location.href='../../control/core/reload_pages.php?lang='+document.getElementById('lang').value">
						<?php 
						if($db->row_count){ // Se encontraron idiomas
							while($row=$db->get_row($r, 'MYSQL_ASSOC'))
							{
								if($row[language_cd]==$_SESSION[idm]){
									echo '<option value="'.$row[language_cd].'" selected>'.$row[language_sp].'</option>';
								}else{
									echo '<option value="'.$row[language_cd].'">'.$row[language_sp].'</option>';
								}
							}
						}
						mysql_close($db);
						?>
					</select>
				</td>				
			</tr>							
		</table>
	</body>
</html>

    	
