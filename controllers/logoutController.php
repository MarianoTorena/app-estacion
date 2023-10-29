<?php 

	session_unset();
	session_destroy();

	header("Location: ".URL_APP);

 ?>