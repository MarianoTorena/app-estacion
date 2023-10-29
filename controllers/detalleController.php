
<?php 
	//Si no esta logueado redirige a login
	if(!isset($_SESSION[APP_NAME]['user_name'])){
		header('Location: '.URL_APP.'/login/'.$_ROUTE[1]);
	}

	$tpl = new EngineTpl('views/detalleView.html');

	$tpl->assignVar("LOGOUT", 'Cerrar Sesion');
	$tpl->assignVar("CHIP_ID", $_ROUTE[1] );

	$tpl->printToScreen();

 ?>