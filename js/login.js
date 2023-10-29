main__form.addEventListener('submit',async e=>{
	e.preventDefault();
	// Se ejecuta la consulta a la api con la info del form
	let data = new FormData(main__form);
	let response = await fetch('https://mattprofe.com.ar/alumno/3882/ACTIVIDADES/app-estacion/api/user/login',{
		method:'post',
		body: data
	});
	var info = await response.json();
	// console.log(info);
	// Se logueo correctamente
	if(info.errno == 200){
		// Se arma el mail
		error__text.style.color = "green" ;
		let destinatario = main__form.querySelector('#txt_email').value
		let motivo = 'Inicio de Sesion'
		document.querySelector("#mail_url").setAttribute('href', document.getElementById("mail_url").href+info.token)
		let contenido = document.querySelector("#txtContenido").innerHTML
		// Se envia el mail
		sendMail(destinatario, motivo, contenido).then( resultado => {
			let chipId = document.querySelector("#chipId").textContent;
			if (chipId != ''){
				// Se redirige a detalle
				window.location.href = `https://mattprofe.com.ar/alumno/3882/ACTIVIDADES/app-estacion/detalle/${chipId}`;
			}else{
				// Se redirige a detalle
				window.location.href = `https://mattprofe.com.ar/alumno/3882/ACTIVIDADES/app-estacion/panel`;
			}
			
		})		
	}
	error__text.textContent = info.error;
	
})

// Función asíncrona para el envio de email
async function sendMail(destinatario, motivo, contenido){

	let form = new FormData()

	form.append("destinatario", destinatario)
	form.append("motivo", motivo)
	form.append("contenido", contenido)
	form.append("send", "mail")

	options = {method: 'POST',
				body: form}

	const response = await fetch("https://mattprofe.com.ar/alumno/3882/ACTIVIDADES/app-estacion/models/sendmail.php", options)
	const data = await response.json()

	return data
}