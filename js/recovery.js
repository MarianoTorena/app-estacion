main__form.addEventListener('submit',async e=>{
	e.preventDefault()
	let data = new FormData(main__form);
	let response = await fetch('https://mattprofe.com.ar/alumno/3882/ACTIVIDADES/app-estacion/api/usuario/recovery',{
		method:'post',
		body: data
	});
	var info = await response.json();
	if (info.errno == 200){
		// Se arma el mail
		let destinatario = info.email
		let motivo = 'Restablecimiento de Contrasenia'
		document.querySelector('#msj_register').style.display = 'none';
		document.querySelector("#mail_url").setAttribute('href', document.getElementById("mail_url").href+info.token_action)
		let contenido = document.querySelector("#txtContenido").innerHTML

		sendMail(destinatario, motivo, contenido).then( resultado => {
			
		})	
	}else{
		document.querySelector('#msj_register').style.display = '';
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