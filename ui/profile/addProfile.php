<?php 
/**
 * addProfile.php
 * 
 * Interfaz Ingresar Perfil
 * @author Victor Manuel Vallecilla Mira<vallecilla@gmail.com> 
 * 		   Carlos A. Rojas<carlkant@gmail.com> 
 * @version 1.0
 * @package ui
 * @creacion: 22/09/2007
 * @license: GNU/GPL	
*/
//Comprobar la session
include_once('../../includes/session.inc');
check_login();

include_once('../../includes/tree/tree_structure.inc.php');
include_once('../../includes/simplepage.class.php');
include_once('../../includes/calendario/calendario.php');

$obj = new simplepage();
$obj->setTitle('Creacion de perfiles');
$obj->setCSS("../../includes/style/style.css");
$obj->setJS("../../includes/calendario/javascripts.js");
$obj->setJS("../../includes/validate/profile/validate_addProfile.js");

echo $obj->getHeader();

$img_dir = "../../images";
require_once('../../data/db.class.php');
$db = new db_class();
if (!$db->connect()){
	$db->print_last_error(false);
}

$_sql="SELECT user_prof_group_nm,user_prof_group_cd FROM user_profile WHERE user_prof_lang='".$_SESSION[idm]."' GROUP BY user_prof_group_nm,user_prof_group_cd";
//echo $_sql."<br>";
?>
<br><br>
<form name='forma' id='forma' method='post' action='../../control/profile/addProfile.php' >
	<table width="50%" border="0" align="center" cellpadding="0" cellspacing="1" id="addUserInternal">	  
			  <tr>
				<td colspan="2" class="subtitulo">INFORMACI&Oacute;N DEL PERFIL</td>
			  </tr>
			  <tr>
			  	<td nowrap id="title_user_prof_nm_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;Por favor informe el nombre</td>			  	
			  </tr>
			  <tr>
				<td id="label_user_prof_nm_underline" class="label"><span style="color:#FF0000; ">*</span>Nombre del perfil&nbsp;<div id="required_user_prof_nm" style="display:none;">*</div></td>
				<td id="input_user_prof_nm_underline"><input name="user_prof_nm" type="text" id="user_prof_nm" size="20" value="<?php if(isset($_POST[user_prof_nmE])){echo $_POST[user_prof_nmE];}?>"></td>
			  </tr>			 
			  <tr>
			  	<td nowrap id="title_user_prof_group_cd_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;Seleccione el grupo de usuarios para el perfil</td>			  	
			  </tr>
			  <tr>
				<td id="label_user_prof_group_cd_underline" class="label"><span style="color:#FF0000; ">*</span>Grupo de usuarios&nbsp;<div id="required_user_prof_group_cd" style="display:none;">*</div></td>
				<td id="input_user_prof_group_cd_underline">
					<select name="user_prof_group_cd" id="user_prof_group_cd" >
					<option value ="-1"></option>'		
					<?php
					$r = $db->select($_sql);
					while ($row=$db->get_row($r, 'MYSQL_ASSOC')) {
						if(isset($_POST[user_prof_group_cdE]) && $_POST[user_prof_group_cdE]==$row[user_prof_group_cd]){
							echo '<option value ="'.$row['user_prof_group_cd'].'" selected>'.$row['user_prof_group_cd'].'</option>';
						}else{
							echo '<option value ="'.$row['user_prof_group_cd'].'">'.$row['user_prof_group_cd'].'</option>';
						}
					}
						?>       
					</select>
				</td>
			  </tr>
			  <tr>
			  	<td nowrap id="title_module_selection_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;Por favor seleccione los modulos para el perfil</td>			  	
			  </tr>			  
			  <tr>
			 	<td id="label_module_selection_underline" class="label"><span style="color:#FF0000; ">*</span>Seleccione los modulos para el nuevo perfil<div id="required_module_selection" style="display:none;">*</div></td>
			 </tr>	
			 <tr>
			 	<td id="input_module_selection_underline" colspan="2">
				  <?php 

				  $self="../../ui/profile/addProfile.php";

				  $target_id=(isset($HTTP_GET_VARS['target_id']))?$HTTP_GET_VARS['target_id']:-1;

				  $_sql = "SELECT module.module_option_nm as name, module.module_nm as mname, module.module_cd as module_cd
							FROM
								module
							WHERE																							
								module.module_lang='".$_SESSION[idm]."' 
								GROUP BY module.module_url,module.module_option_nm, module.module_nm, module.module_cd
								ORDER BY module_ord";
				  //echo $_sql;
				  $modules = $db->select($_sql);

				  $actual=$rmodules=$db->get_row($modules, 'MYSQL_ASSOC');
				  $siguiente=$rmodules=$db->get_row($modules, 'MYSQL_ASSOC');

				  $i=0;

				  if($actual){
				  	$tab[]=array("id"=>0,"text"=>"Modulos","id_father"=>-1);
				  	$tab[]=array("id"=>$father=++$i,"text"=>$actual[mname],"id_father"=>0);
				  	$tab[]=array("id"=>++$i,"text"=>strtolower($actual[name]).'&'.$actual[module_cd],"id_father"=>$father);
				  	while($siguiente){
				  		if($actual[mname]!=$siguiente[mname]){
				  			$tab[]=array("id"=>$father=++$i,"text"=>$siguiente[mname],"id_father"=>0);
				  		}
				  		$actual=$siguiente;

				  		$tab[]=array("id"=>++$i,"text"=>strtolower($actual[name]).'&'.$actual[module_cd],"id_father"=>$father);

				  		$siguiente=$rmodules=$db->get_row($modules, 'MYSQL_ASSOC');

				  	}
				  }
				  /*
				  for($k=0;$k<count($tab);$k++){
				  echo '<br><b>ID:</b>'.$tab[$k]["id"].' <b>TEXT:</b>'.$tab[$k][text].' <b>ID_FATHER:</b>'.$tab[$k][id_father].'<br>';
				  }
				  */

				  // tree in text mode
				  $tree=new tree($tab,"id","text","id_father","../../includes/tree/img","graphic");

				  // transform the linear tab to the tab ordered in tree order
				  $tree->transform($tree->get_idroot());


				  if ($target_id!=-1){ // expand tree to $expand_id node id if $expand_id is "set"
				  	if($_GET[node]=='expand'){	//abrir
				  		$tree->expand($target_id);
				  	}elseif($_GET[node]=='collapse'){ //cerrar
				  		$tree->collapse($target_id);
				  	}
				  }

				  echo "<table border='0' cellspacing='0' cellpadding='0' id='module_selection'>\n";
				  for ($y=0;$y<$tree->height();$y=$tree->get_next_line_tree($y)) {
				  	echo "  <tr>\n";
				  	echo "    <td height=16><font size=2>\n      ";
				  	// the $a part is the static part of tree
				  	// the $b part is the last part of the tree, the part which looks like + or - in windows looking tree
				  	// the $c part is the text of the node
				  	// the $d part is the id of the node
				  	list($a,$b,$c,$d)=$tree->get_line_display($y);
				  	$text_all=explode('&',$c);

				  	$text=$text_all[0];

				  	$module_cd=$text_all[1];

				  	echo $a;
				  	if ($tree->tree_tab[$y]["symbol"]=="plus") // if node is "+" => expand it
				  	//echo "<a href=$self?target_id=$d&node=expand>$b</a>";
				  	echo "$b";
				  	else
				  	if ($tree->tree_tab[$y]["symbol"]=="moins") // if node is "-" => expand to father
				  	//echo "<a href=$self?target_id=".$tree->tree_tab[$y]["id_father"],"&node=collapse>$b</a>";
				  	//echo "<a href=$self?target_id=$d&node=collapse>$b</a>";
				  	echo "$b";
				  	else // else the node have static tree
				  	echo $b;
				  	echo $text;
				  	if($tree->get_idroot()!=$y){

				  		if(count($tree->get_list_children($y))>0){
				  			if(isset($_POST[$module_cd])){
				  				echo '<input id="module_'.$y.'" name="module_'.$y.'" type="checkbox" checked value="'.$module_cd.'" onclick="selectAllChildren('.count($tree->get_list_children($y)).','.$y.')" >';
				  			}else{
				  				echo '<input id="module_'.$y.'" name="module_'.$y.'" type="checkbox" value="'.$module_cd.'" onclick="selectAllChildren('.count($tree->get_list_children($y)).','.$y.')" >';
				  			}
				  		}else{
				  			if(isset($_POST[$module_cd])){
				  				echo '<input id="module_'.$y.'" name="module_'.$y.'" type="checkbox" checked value="'.$module_cd.'" >';
				  			}else{
				  				echo '<input id="module_'.$y.'" name="module_'.$y.'" type="checkbox" value="'.$module_cd.'" >';
				  			}
				  		}
				  	}

				  	echo "\n    </font></td>\n";
				  	echo "  </tr>\n";
				  }

				  echo "</table>\n";
				  echo '<input type="hidden" value="'.($tree->height()-1).'" id="check_size" name="check_size">';
				  ?>
				  </td>
			  </tr>		 			  		  			 			
			  <tr>
			  	<td nowrap id="title_user_prof_date_in_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;Por favor informe la fecha de inicio de validez del usuario(Superior a la del dia de hoy)</td>			  	
			  </tr>		
			  <tr>
				<td nowrap id="label_user_prof_date_in_underline" class="label"><span style="color:#FF0000; ">*</span>Fecha de inicio de validez&nbsp;<div id="required_user_prof_date_in" style="display:none;">*</div></td>
				<?php 
				$user_prof_date_in='';
				if(isset($_POST[user_prof_date_in])){
					$user_prof_date_in=$_POST[user_prof_date_in];
				}else{
					$user_prof_date_in=date('Y/m/d');
				}
				?>
				<td id="input_user_prof_date_in_underline"><?php echo escribe_formulario_fecha_vacio('user_prof_date_in','forma',$user_prof_date_in,'');?></td>
			  </tr>
			  <tr>
			  	<td nowrap id="title_user_prof_date_out_underline" bgcolor="Red" colspan="2" class="resaltarError" style="display:none;">&nbsp;<img width="10px" height="10px" src="<?php echo $img_dir;?>/error_alert.png">&nbsp;&nbsp;La fecha de fin de validez debe ser superior a la fecha de inicio.</td>			  	
			  </tr>		
			  <tr>
				<td nowrap id="label_user_prof_date_out_underline" class="label">Fecha fin de validez&nbsp;<div id="required_user_prof_date_out" style="display:none;">*</div></td>
				<?php 
				$user_prof_date_out='';
				if(isset($_POST[user_prof_date_out])){
					$user_prof_date_out=$_POST[user_prof_date_out];
				}else{
					$user_prof_date_out='';
				}
				?>
				<td id="input_user_prof_date_out_underline"><?php echo escribe_formulario_fecha_vacio('user_prof_date_out','forma',$user_prof_date_out,'');?> </td>
			  </tr>
			 </table>			
	<br>
	<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
	  		<td align="right"><input class="cssbutton" type="button" value="Activar" onclick="return validateMandatoryFields();"></td>
	  	</tr>
	</table>
</form>
<br><br><br>
<?php echo $obj->getFooter(); ?>