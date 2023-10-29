<?php 
	
	//Si esta logueado redirige a panel
	if(isset($_SESSION[APP_NAME]['user_name'])){
		header('Location: '.URL_APP.'/panel');
	}

	$tpl = new EngineTpl('views/resetView.html');

	// MAIL
	$strExplode = explode(' (', $_SERVER["HTTP_USER_AGENT"]);

	$token = "";
	$ip_disp = $_SERVER["REMOTE_ADDR"];
	$sis_operativo = explode(') ', $strExplode[1])[0];
	$navegador = $strExplode[0];

	$tpl->assignVar('ip_disp', $ip_disp);
	$tpl->assignVar('sis_operativo', $sis_operativo);
	$tpl->assignVar('navegador', $navegador);

	// FUNCION
	if(isset($_ROUTE[1]) && $_ROUTE[1] != ""){
		$usuario = new Usuario();
		$response = $usuario->getByToken($_ROUTE[1]);
		if ($response != false) {
			$tpl->assignVar("token_action", $_ROUTE[1] );
			$tpl->assignVar("email", $response['email'] );
		}else{
			$tpl->assignVar("token_action", '' );
		}
	}else{
		// no existe token action en url
		header('Location: '.URL_APP.'/panel');
	}

	$tpl->printToScreen();

 ?>