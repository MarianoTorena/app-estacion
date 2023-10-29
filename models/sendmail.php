<?php

/*  Requiere por metodo post:

    send: valor "mail"
    destinatario: email del receptor
    motivo: motivo del mensaje que verá el receptor
    contenido: mensaje que verá el receptor, acepta etiquetas html
*/

include_once '../env.php';
include_once '../Mailer/src/PHPMailer.php';
include_once '../Mailer/src/SMTP.php';
include_once '../Mailer/src/Exception.php';

$mail = new PHPMailer\PHPMailer\PHPMailer();

if(isset($_POST["send"])){

    if($_POST["send"]=="mail"){

        $mail->isSMTP();
        $mail->SMTPDebug = 0 ;
        $mail->Host = MAIL_HOST;
        $mail->Port = MAIL_PORT;
        $mail->SMTPAuth = MAIL_SMTP_AUTH; 
        $mail->SMTPSecure = MAIL_SMTP_SECURE;
        $mail->Username = MAIL_REMITENTE;
        $mail->Password = MAIL_PASSWORD;

        $mail->setFrom(MAIL_REMITENTE, MAIL_NOMBRE);
        $mail->addAddress($_POST["destinatario"]);

        $mail->isHTML(true);

        $mail->Subject = utf8_decode($_POST["motivo"]);
        $mail->Body = utf8_decode($_POST["contenido"]);

        if(!$mail->send()){
            error_log("Mailer no se pudo enviar el correo!" );
			$body = array("errno" => 1, "error" => "No se pudo enviar.");
        }else{
			$body = array("errno" => 0, "error" => "Enviado con exito.");
		}   
    }else{
		$body= array("errno" => 2, "error" => "falta accion mail");
	}
}else{

	$body = array("errno" => 3, "error" => "falta variable send");
}

header("Content-Type: application/json");

echo json_encode($body);
 
?>
