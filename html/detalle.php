<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/detalle.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
	<title>Detalle</title>
</head>
<body>
	<!-- Inicio Seccion de Template -->

		<!-- Inicio Template Temperatura -->
		<template id="tpl__temperatura">
			<tr>
				<td>
					<div class="item-title">
						<span class="material-symbols-outlined icons">device_thermostat</span>
						TEMPERATURA
					</div>
					<div class="important-val-int">
						<p id="temperatura"></p>ºC
					</div>
					<div class="item">
						<div class="item-title">
						<span class="material-symbols-outlined icons">arrow_drop_up</span>Máxima</div>
						<div class="item-value">
							<p id="tempmax"></p>ºC
						</div>
					</div>
					<div class="item">
						<div class="item-title">
							<span class="material-symbols-outlined icons">arrow_drop_down</span>Mínima</div>
						<div class="item-value">
							<p id="tempmin"></p>ºC
						</div>
					</div>
				</td>
				<td>
					<div class="item-title">
						<span class="material-symbols-outlined icons">man_2</span>
						SENSACIÓN
					</div>
					<div class="important-val-int" >
						<p id="sensacion"></p>ºC
					</div>
					<div class="item">
						<div class="item-title"><span class="material-symbols-outlined icons">arrow_drop_up</span>Máxima</div>
						<div class="item-value" >
							<p id="sensamax"></p>ºC
						</div>
					</div>
					<div class="item">
						<div class="item-title"><span class="material-symbols-outlined icons">arrow_drop_down</span>Mínima</div>
						<div class="item-value">
							<p id="sensamin"></p>ºC
						</div>
					</div>
				</td>
			</tr>
		</template>
		<!-- Fin Template Temperatura -->

		<!-- Inicio Template Viento -->
		<template id="tpl__viento">
			<!-- Inicio Viento -->
			<div class="item-title"><span class="material-symbols-outlined icons">air</span>VIENTO</div>
			<div class="panel-col">
				<div class="col-items">
					<div class="col-important">
						<div class="important-val-int" ><p id="viento"></p>Km/H</div>
						<div class="panel-row">
							<div class="item">
								<div class="item-title"><span class="material-symbols-outlined icons">arrow_drop_up</span>Máximo</div>
								<div class="item-value" ><p id="maxviento"></p>Km/H</div>
							</div>
						</div>
					</div>
				</div>
			<!-- Fin Viento  -->
			<!-- Inicio Veleta -->
			<div class="col-items explore">
					<span class="material-symbols-outlined icons">explore</span>
					<div class="item-value" id="veleta"></div>
			</div>
			<!-- Fin Veleta -->
		</template>
		<!-- Fin Template Viento -->

		<!-- Inicio Template Fuego -->
		<template id="tpl__fuego">
			<!-- Inicio Bloque -->
			<div class="item-title"><span class="material-symbols-outlined icons">mode_heat</span>FUEGO</div>
			<div class="panel-col">
				<!-- Columna 1 -->
				<div class="col-items">
					<div class="item">
						<div class="item-title">FFMC</div>
						<div class="item-value" id="ffmc"></div>
					</div>
					<div class="item">
						<div class="item-title">DMC</div>
						<div class="item-value" id="dmc"></div>
					</div>
					<div class="item">
						<div class="item-title">DC</div>
						<div class="item-value" id="dc"></div>
					</div>
				</div>
				<!-- Columna 2 -->
				<div class="col-items">
					<div class="item">
						<div class="item-title">ISI</div>
						<div class="item-value" id="isi"></div>
					</div>
					<div class="item">
						<div class="item-title">BUI</div>
						<div class="item-value" id="bui"></div>
					</div>
					<div class="item">
						<div class="item-title">FWI</div>
						<div class="item-value" id="fwi"></div>
					</div>
				</div>
			</div>
			<!-- Fin Bloque -->
		</template>
		<!-- Fin Template Fuego -->

		<!-- Inicio Template Presion-->
		<template id="tpl__presion">
			<div class="panel-col">
				<div class="col-items">
					<div class="col-important">
						<div class="item-title"><span class="material-symbols-outlined icons">arrow_circle_down</span>PRESION</div>
						<div class="important-val-int" ><p id="presion"></p>hPa</div>						
					</div>
				</div>
			</div>				
		</template>
		<!-- Fin Template Presion -->

		<!-- Inicio Template Humedad-->
		<template id="tpl__humedad">
			<div class="panel-col">
				<div class="col-items">
					<div class="col-important">
						<div class="item-title"><span class="material-symbols-outlined icons">humidity_low</span>HUMEDAD</div>
						<div class="important-val-int" ><p id="humedad"></p>%</div>						
					</div>
				</div>
			</div>				
		</template>
		<!-- Fin Template Humedad -->	

		<!--  Inicio hora y lugar tpl-->
			<template id="tpl__zonetime">
				<div id="hora"></div>
				<div class="dflex ">
					<span class="material-symbols-outlined icons">location_on</span>
					<div id="ubicacion" class='fs18 bold'></div>
				</div>
				
			</template>
		<!-- Fin -->
	<!-- Fin Seccion de Template -->

		<!-- ChipId Oculto -->
		<div id="chipid" style="display: none;"><?php echo $_GET['chipid'] ?></div>

	<!-- Inicio Contenedor -->
		<div class="wrapper">
			<!-- Seccion Informacion -->
			<div class="panel-content">
				<div id="panel-info">
					<div id="topInfo">
						
					</div>
					<table class="table table-hover">
				        <tbody id="main__table">

				        </tbody>
				    </table>

				</div>
				<div id="panel-grafico">
					<canvas id="myChart"></canvas>
				</div>
			</div>
			<!-- Fin Seccion Informacion -->
			<!-- Seccion de Botones -->
			<div class="btn-content">
				<div id="btns">
					<button onclick="refreshView('temperatura')">TEMPERATURA</button>
					<button onclick="refreshView('humedad')">HUMEDAD</button>
					<button onclick="refreshView('viento')">VIENTO</button>
					<button onclick="refreshView('fuego')">FUEGO</button>
					<button onclick="refreshView('presion')">PRESION</button>
				</div>
			</div>
			<!-- Fin Seccion de Botones -->
		</div>
	<!-- Fin Contenedor -->
	
	<!-- Scripts -->
		<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
		<script type="text/javascript" src="../js/detalle.js"></script>
	<!-- FinScripts -->
</body>
</html>
