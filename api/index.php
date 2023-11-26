<?php 

	session_start();

// Cabeceras para hacer que la API sea pública
	header("Access-Control-Allow-Origin: *");
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');

	header("Content-Type: application/json");

	$_ROUTE = explode("/", $_GET["seccion"]);

	$response = array();

	include_once  ('../models/dbAbstract.php');
	include_once ('../env.php');

	if ($_ROUTE[0] == 'list-clients-location'){
		include_once "../models/usuarioModel.php";
		$object = new Usuario;
		$response = $object->listClientsLocation();
	}else{
		if(!file_exists("../models/".$_ROUTE[0].'Model.php')){
			echo json_encode(array("errno" => 404, "error" => "No existe el modelo"));
			exit();
		}else{
			include_once "../models/".$_ROUTE[0].'Model.php';
		}
	}

	$class = ucfirst($_ROUTE[0]);

	if ($_ROUTE[0] == 'user'){
		$object = new $class($_POST['txt_email']);

		if(!method_exists($object, $_ROUTE[1])){
			echo json_encode(array("errno" => 404, "error" => "No existe el metodo en la clase"));
			exit();	
		}

		$metodo = $_ROUTE[1]; // capturo el metodo

		$response = $object->$metodo($_POST['txt_pass']);

		if($response['errno'] == 200 && $_ROUTE[1] == 'login'){
			$_SESSION[APP_NAME]['user_name'] = $response['user'];
		}else if($response['errno'] == 201){
			$_SESSION[APP_NAME]['admin'] = 'online';
		}


	}else if($_ROUTE[0] == 'usuario'){
		$object = new $class;

		if(!method_exists($object, $_ROUTE[1])){
			echo json_encode(array("errno" => 404, "error" => "No existe el metodo en la clase"));
			exit();
		}
		$metodo = $_ROUTE[1]; // capturo el metodo
		if ($metodo == 'resetPass') {
			$response = $object->$metodo($_POST['txt_email'],$_POST['txt_pass']);
		}else{
			$response = $object->$metodo($_POST['txt_email']);
		}
	}else if ($_ROUTE[0] != 'list-clients-location'){
		$object = new $class();

		if(!method_exists($object, $_ROUTE[1])){
			echo json_encode(array("errno" => 404, "error" => "No existe el metodo en la clase"));
			exit();	
		}

		$metodo = $_ROUTE[1]; // capturo el metodo
		
		$response = $object->$metodo();
	}

	echo json_encode($response);
 ?>