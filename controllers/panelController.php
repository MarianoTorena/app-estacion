<?php 

	$tpl = new EngineTpl('views/panelView.html');

	//Si no esta logueado redirige a login
	if(isset($_SESSION[APP_NAME]['user_name'])){
		$tpl->assignVar("LOGOUT", 'Cerrar Sesion');
	}else{
		$tpl->assignVar("LOGOUT", '');
	}

	$tpl->assignVar("USERIP", $_SERVER["REMOTE_ADDR"]);

	$tpl->printToScreen();

	

 ?>