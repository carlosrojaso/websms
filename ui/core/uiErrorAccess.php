<?php
include_once('../../includes/simplepage.class.php');

/********* INTERNACIONALIZACION **************/
include_once('../../lang/core/ui/uiErrorAccess.php');
/********************************************/

$obj = new simplepage();
$obj->setTitle($title);
$obj->setCSS("../../includes/style/style.css");
$obj->setJS("../../includes/form.scripts.js");
echo $obj->getHeader();
$img_dir = "../../images/";
$try = "login.php"; 
$helpdesk = "../helpdesk/addHelp.php";
?>

<br>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="5">
	<tr>
		<td colspan="2" class="tituloerrorlog"><img src="<?php echo $img_dir;?>alert.png" width="32" height="32"><span class="err1"> <?php echo $title2;?> </span></td>
	</tr>
	<tr>
		<td colspan="2" class="subtituloerrorlog"><img src="<?php echo $img_dir;?>info.png" width="32" height="32"><span class="err2"><?php echo $msg;?> <br></span></td>
	</tr>
	<tr>
		<td colspan="2" class="celdas3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	</tr>
	<tr>
		<td><img src="<?php echo $img_dir;?>blank32.png" width="32" height="32"><span class="subtituloerrorlog"><?php echo $msg2;?></span></td>
	</tr>
	<tr>
		<td class="celdas3">			
			<img src="<?php echo $img_dir;?>blank32.png" width="32" height="32">
			<img src="<?php echo $img_dir;?>list.png" width="8" height="8"> <span class="viñetaerrorlog"><?php echo $msg3;?></span><br>
			<img src="<?php echo $img_dir;?>blank32.png" width="32" height="1">
			<img src="<?php echo $img_dir;?>blank.png" width="8" height="1"> <span class="viñetaerrorlog"><?php echo $msg4;?></span><br>			
			<img src="<?php echo $img_dir;?>blank32.png" width="32" height="32">
			<a href="../user/selectUserAct.php?lang=SP"><?php echo $msg10;?></a>
			<br>			
			<img src="<?php echo $img_dir;?>blank32.png" width="32" height="32">
			<img src="<?php echo $img_dir;?>list.png" width="8" height="8"> <span class="viñetaerrorlog"><?php echo $msg5;?></span><br>
			<img src="<?php echo $img_dir;?>blank32.png" width="32" height="32">
			<img src="<?php echo $img_dir;?>list.png" width="8" height="8"> <span class="viñetaerrorlog"><?php echo $msg6;?><br>
		</td>
	</tr>			
	<tr>
		<td colspan="2"><hr></td>
	</tr>
	<tr>
		<td colspan="2"><span class="subtitulo2errorlog"><?php echo $msg7;?></span><br><br></td>
	</tr>
	<tr>
		<td>
			<a href="<?php echo $try;?>"><?php echo $msg8;?></a>
			&nbsp;
			<a href="<?php echo $helpdesk;?>"><?php echo $msg9;?></a>
		</td>
		<td></td>
	</tr>
</table>
<br/><br/><br/>
<?php echo $obj->getFooter();?>
