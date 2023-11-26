<?php 
	
	//Si no esta logueado redirige a login
	if(!isset($_SESSION[APP_NAME]['admin'])){
		header('Location: https://mattprofe.com.ar/alumno/3882/ACTIVIDADES/app-estacion/panel');
	}

	$tpl = new EngineTpl('views/mapView.html');

	$tpl->printToScreen();

 ?>