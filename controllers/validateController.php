<?php 

	//Si esta logueado redirige a panel
	if(isset($_SESSION[APP_NAME]['user_name'])){
		header('Location: '.URL_APP.'/panel');
	}
	// $tpl = new EngineTpl('views/registerView.html');

	// $tpl->printToScreen();

	if(isset($_ROUTE[1]) && $_ROUTE[1] != ""){
		$usuario = new Usuario();
		$response = $usuario->validateUser($_ROUTE[1]);
		if ($response['errno'] == 200){
			header('Location: '.URL_APP.'/login');
		}else{
			echo($response['error']);
		}
	}else{
		header('Location: '.URL_APP.'/panel');
	}

 ?>