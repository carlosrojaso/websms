<?php 
echo
'
<script>
	if(confirm("�Usted desea darse de baja?")){
		if(confirm("Le recordamos que al darse de baja, se desactivar� su cuenta y que no tendr� m�s acceso a los servicios de Onspot.\n" +
		 		   "Necesitar� volver a crear una nueva cuenta en el caso���.(por definir???). �Usted desea realmente darse de baja?")){
			location.href="../../control/user/userDown.php";
		}else{
			//window.parent.location.href="../../ui/core/home.php";
		}
	}else{
		window.parent.location.href="../../ui/core/home.php";
	}
</script>
';
?>