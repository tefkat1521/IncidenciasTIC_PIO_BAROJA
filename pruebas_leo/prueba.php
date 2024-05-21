<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/phpmailer/src/Exception.php';
require '../vendor/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/src/SMTP.php';



$mail = new PHPMailer(true);

try {
    // Configuración del servidor SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'dmarchenad123@gmail.com'; // Tu correo de Gmail
    $mail->Password = 'tycu sayo hjza tcbt'; // Tu contraseña de Gmail o App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Remitente y destinatarios
    $mail->setFrom('piobaroja@gmail.com', 'Tu Nombre');
    $mail->addAddress('dmarchenad123@gmail.com', 'Destinatario'); // Correo y nombre del destinatario

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'Este mensaje es de prueba';
    $mail->Body    = '
    <html> 
    <head> 
       <title>Prueba de correo</title> 
    </head> 
    <body> 
    <h1>Hola amigos!</h1> 
    <p> 
    <b>Bienvenidos a mi correo electrónico de prueba</b>. Estoy encantado de tener tantos lectores. Este cuerpo del mensaje es del artículo de envío de mails por PHP. Habría que cambiarlo para poner tu propio cuerpo. Por cierto, cambia también las cabeceras del mensaje. 
    </p> 
    </body> 
    </html>
    ';
    $mail->AltBody = 'Bienvenidos a mi correo electrónico de prueba. Estoy encantado de tener tantos lectores.';

    $mail->send();
    echo 'Correo enviado con éxito.';
} catch (Exception $e) {
    echo "Error al enviar el correo: {$mail->ErrorInfo}";
}
?>