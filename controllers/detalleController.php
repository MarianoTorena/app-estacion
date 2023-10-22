
<?php 

	$tpl = new EngineTpl('views/detalleView.html');

	$tpl->assignVar("CHIP_ID", $_ROUTE[1] );

	$tpl->printToScreen();

 ?>