	<?php 

	session_start();
	include ('Mailer/src/PHPMailer.php');
	include ('Mailer/src/SMTP.php');
	include ('Mailer/src/Exception.php');
	include ('lib/enginetpl.php');
	include ('env.php');
	include ('models/dbAbstract.php');
	include ('models/userModel.php');
	include ('models/usuarioModel.php');

	if(!isset($_SESSION[APP_NAME])){
		$_SESSION[APP_NAME] = array();
	}
	// var_dump($_SESSION);

	// Divide las rutas y las guarda en el array ROUTE
	$_ROUTE = explode("/", $_GET["seccion"]);
	//var_dump($_ROUTE);

	// Router

	// Verifica si existe el controlador de la ruta
	if($_ROUTE[0]!=""){
		$section = $_ROUTE[0];

		if(!file_exists("controllers/{$section}Controller.php")){
			$section = "404";
		}

	}else{
		$section = "landing";
	}

	//var_dump($section);

	include "controllers/{$section}Controller.php";

 ?>