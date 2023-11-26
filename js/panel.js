 // Evento que se ejecuta cuando se carga completamente la pÃ¡gina
document.addEventListener("DOMContentLoaded", ()=>{

	if (document.querySelector("#btn_logout").innerHTML == "") {
		document.querySelector("#btn_logout").style.display = 'none';
	}
	// pedimos las estaciones
	loadEstaciones().then( data => {

		// recorremos el listado de estaciones
		data.forEach(function(element, index){

			// creamos los botones de estaciones
			addBtnEstacion(element)
		})
	})

	getDataByIp().then(infoClient => {
		console.log(infoClient)
		addregistro(infoClient).then(request =>{

		})
	})

})

async function addregistro(infoClient){

	let info = {
		country: infoClient.country,
	  	ip: infoClient.ip,
	  	long: infoClient.longitude,
	  	lat: infoClient.latitude
	}
	const response = await fetch("https://mattprofe.com.ar/alumno/3882/ACTIVIDADES/app-estacion/api/tracker/addClientTracker",{
		method:'POST',
		headers: {
		   'Accept': 'application/json',
		   'Content-Type': 'application/json'
		  },
		body: JSON.stringify({'info': info})
	});
	const data = await response.json()

	return data
}

// PeticiÃ³n asincrona de la lista de estaciones
async function loadEstaciones(){
	const response = await fetch("https://mattprofe.com.ar/proyectos/app-estacion/datos.php?mode=list-stations")
	const data = await response.json()

	return data
}

async function getDataByIp(){
	let ip = document.getElementById('ip-user').innerHTML;
	const response = await fetch(`https://ipwho.is/${ip}`)
	const data = await response.json()

	return data;
}

// Crea un nuevo botÃ³n con los datos de info
function addBtnEstacion(info){

	let tpl = document.querySelector("#tpl-btn-estacion")
	let clon = tpl.content.cloneNode(true)

	// cargamos los datos del botÃ³n clonado
	clon.querySelector(".btn-estacion").setAttribute("href", `detalle/${info.chipid}`)
	clon.querySelector(".estacion-ubicacion").innerHTML= '<span class="material-symbols-outlined">location_on</span>'+info.ubicacion
	clon.querySelector(".estacion-visitas").innerHTML = info.visitas+'<span class="material-symbols-outlined">visibility</span>'
	clon.querySelector(".estacion-apodo").innerHTML = info.apodo
	
	// Agrega un nuevo botÃ³n de estaciÃ³n
	document.querySelector("#list-estacion").appendChild(clon)
}

