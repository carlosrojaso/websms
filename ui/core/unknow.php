<?php
/*
 * Created on 08/09/2007
 * Created by Carlos A. Rojas
 * Name of File: unknow.php
 *
 */
 
/*****INTERNACIONALIZACION******/
include_once('../../lang/core/ui/unknow.php');
/***********/

include_once('../../includes/simplepage.class.php');
$obj = new simplepage();
$obj->setTitle($title);
$obj->setCSS("../../includes/style/style.css");
echo $obj->getHeader();
$img_dir = "../../images";

// Conectamos con la DB

require_once('../../data/db.class.php');
$db = new db_class;
if (!$db->connect()){
	$db->print_last_error(false);
}

$_sql = "SELECT language_cd,language_sp FROM language"; // sql para los idiomas

$r = $db->select($_sql);
	

?>
<br><br><br>

<br><br><br>
<form action="../../ui/core/login.php" method="get" name="frmAccess">
	<table cellpadding="0" cellspacing="0" border="0" width="300" align="center" id="addUser_professional">
		<tr>
		  <td align="left" class="head" colspan="3" ><?php echo $head;?></td>
		</tr> 
		<tr>
			<td class="celdas1">&nbsp;<?php echo $txt1;?></td>
			<td class="celdas1">
			<select name="lang" class="formas">
			<?if($db->row_count){ // Se encontraron idiomas
				while($row=$db->get_row($r, 'MYSQL_ASSOC'))
				{
				echo '<option value="'.$row[language_cd].'">'.$row[language_sp].'</option>';	
				}
				}?>
			</select><br/><br/>
			</td>
		</tr>
		<tr>
			<td align="center" class="celdas1" colspan="2"><input type="submit" value="<?php echo $button;?>"><br/></td>
		</tr>
    </table>
</form>
<br><br><br>

<?php
mysql_close($db); // cerramos la conexion
echo $obj->getFooter();
?>

