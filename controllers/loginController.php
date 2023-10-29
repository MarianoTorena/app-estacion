<?php 
	
	//Si esta logueado redirige a panel
	if(isset($_SESSION[APP_NAME]['user_name'])){
		header('Location: '.URL_APP.'/panel');
	}

	$tpl = new EngineTpl('views/loginView.html');

	$response = array("errno" => 0, "error" => "");

	$strExplode = explode(' (', $_SERVER["HTTP_USER_AGENT"]);

	$token = "";
	$ip_disp = $_SERVER["REMOTE_ADDR"];
	$sis_operativo = explode(') ', $strExplode[1])[0];
	$navegador = $strExplode[0];

	if (isset($_ROUTE[1])) {
		$tpl->assignVar('CHIP_ID', $_ROUTE[1]);
	}else {
		$tpl->assignVar('CHIP_ID', '');
	}

	$tpl->assignVar('ip_disp', $ip_disp);
	$tpl->assignVar('sis_operativo', $sis_operativo);
	$tpl->assignVar('navegador', $navegador);

	$tpl->printToScreen();

 ?>