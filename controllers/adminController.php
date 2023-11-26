<?php 
	
	//Si no esta logueado redirige a login
	if(!isset($_SESSION[APP_NAME]['admin'])){
		header('Location: https://mattprofe.com.ar/alumno/3882/ACTIVIDADES/app-estacion');
	}

	$tpl = new EngineTpl('views/adminView.html');
	$tpl->assignVar("LOGOUT", 'Cerrar Sesion');
	$tpl->printToScreen();

 ?>