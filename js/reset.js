// Carga la pagina
document.addEventListener("DOMContentLoaded", async function (event){
  //busca el token_action
  tokenAction = document.querySelector("#token_action").innerHTML;
  if (tokenAction != '') {
  	console.log('hola')
  	document.querySelector("#main__form").style.display = '';
  }else{
  	error__text.textContent = "El token_action no es válido";
  }
})

// Presiona el submit
main__form.addEventListener('submit',async e=>{
	e.preventDefault();
	// Comprueba que las password sean iguales
	if (e.target.querySelector('#txt_pass').value == e.target.querySelector('#txt_pass2').value){
		email = document.querySelector("#email").innerHTML;
		// Se ejecuta la consulta a la api con la info del form
		let data = new FormData(main__form);
		data.append("txt_email", email);

		let response = await fetch('https://mattprofe.com.ar/alumno/3882/ACTIVIDADES/app-estacion/api/usuario/resetPass',{
			method:'post',
			body: data
		});
		var info = await response.json();
		// console.log(info);
		// Se logueo correctamente
		if(info.errno == 200 ){
			error__text.style.color = "green" ;
			// Se arma el mail
			let destinatario = email;
			let motivo = 'Restablecimiento de contrasenia'
			document.querySelector("#mail_url").setAttribute('href', document.getElementById("mail_url").href+info.token)
			let contenido = document.querySelector("#txtContenido").innerHTML
			// Se envia el mail
			sendMail(destinatario, motivo, contenido).then( resultado => {
				// Se redirige a panel
			 window.location.href = `https://mattprofe.com.ar/alumno/3882/ACTIVIDADES/app-estacion/login`;
			})
		}
	}else{
		var info = {errno: 411, error: "Contrasenias ingresadas diferentes"}
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