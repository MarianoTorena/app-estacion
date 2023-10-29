<?php 

	session_unset();
	session_destroy();
	if(isset($_ROUTE[1]) && $_ROUTE[1] != ""){
		$usuario = new Usuario();
		$response = $usuario->blockUser($_ROUTE[1]);
		if ($response['errno'] == 200){
			$tpl = new EngineTpl('views/blockUser.html');

			$tpl->assignVar('token_action', $response['token_action']);
			$tpl->assignVar('emailUser', $response['email']);
			$tpl->assignVar('userState', 'blocked');
			
			$tpl->printToScreen();
		}else{
			echo($response['error']);
		}
	}else{
		header('Location: '.URL_APP.'/panel');
	}

	
 ?>