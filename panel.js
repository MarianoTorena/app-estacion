// Evento que se ejecuta cuando se carga completamente la pÃ¡gina
document.addEventListener("DOMContentLoaded", () => {

	// pedimos las estaciones
	loadEstaciones().then( data => {

		// recorremos el listado de estaciones
		data.forEach(function(element, index){

			// creamos los botones de estaciones
			addBtnEstacion(element)
		})
	})
})

// PeticiÃ³n asincrona de la lista de estaciones
async function loadEstaciones(){
	const response = await fetch("https://mattprofe.com.ar/proyectos/app-estacion/datos.php?mode=list-stations")
	const data = await response.json()

	return data
}

// Crea un nuevo botÃ³n con los datos de info
function addBtnEstacion(info){

	let tpl = document.querySelector("#tpl-btn-estacion")
	let clon = tpl.content.cloneNode(true)

	// cargamos los datos del botÃ³n clonado
	clon.querySelector(".btn-estacion").setAttribute("href", "./detalle.php?chipid="+info.chipid)
	clon.querySelector(".estacion-ubicacion").innerHTML= '<span class="material-symbols-outlined">location_on</span>'+info.ubicacion
	clon.querySelector(".estacion-visitas").innerHTML = info.visitas+'<span class="material-symbols-outlined">visibility</span>'
	clon.querySelector(".estacion-apodo").innerHTML = info.apodo
	
	// Agrega un nuevo botÃ³n de estaciÃ³n
	document.querySelector("#list-estacion").appendChild(clon)
}