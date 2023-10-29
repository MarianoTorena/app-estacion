document.addEventListener("DOMContentLoaded", function (event){
	var mensaje = "El token no corresponde a un usuario";
	if(document.querySelector('#userState').textContent == "blocked"){
		// Se arma el mail
		let destinatario = document.querySelector('#txt_email').textContent
		let motivo = 'Bloqueo de Usuario'
		let contenido = document.querySelector("#txtContenido").innerHTML
		// Se envia el mail
		
		sendMail(destinatario, motivo, contenido).then( resultado => {
			// Se redirige al usuario
			console.log('llego');
			// window.location.href = `https://mattprofe.com.ar/alumno/3882/ACTIVIDADES/app-estacion/panel`;
			mensaje = "usuario bloqueado, revise su correo electrónico";
			error__text.textContent = mensaje;
		})
	}else{
		error__text.textContent = mensaje;
	}
		
	
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