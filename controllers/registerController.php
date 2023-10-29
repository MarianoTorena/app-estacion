<?php 

	//Si esta logueado redirige a panel
	if(isset($_SESSION[APP_NAME]['user_name'])){
		header('Location: '.URL_APP.'/panel');
	}
	$tpl = new EngineTpl('views/registerView.html');

	$tpl->printToScreen();

 ?>