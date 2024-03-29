<?php

// Procesar email con PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Creo objeto clase PHPMailer
$mail = new PHPMailer(true);

// En caso de error lanza Exception
try { 

    // Configuración juego caracteres
    $mail->CharSet = "UTF-8";
    $mail->Encoding = "quoted-printable";

    // Credenciales SMPT gmail
    $mail->Username = 'jonyleoncanto@gmail.com';
    $mail->Password = 'nesu neft moww xfyy';

    // Configuración SMPT gmail
    $mail->SMTPDebug = 2;                                       //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication                             //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // tls Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Cabecera del emial
    $destinatario = 'jonyleoncanto@gmail.com';
    $remitente    = 'jonyleoncanto@gmail.com';
    $asunto       = "Email con PHPMailer";
    $mensaje      = "
    <h1>Lorem ipsum dolor sit amet</h1>
    <b>Cádiz</b> consectetur adipiscing elit. 
    Curabitur pellentesque metus sit amet tellus placerat, quis interdum nibh fermentum. 
    Aenean porttitor arcu sit amet orci placerat aliquet. Sed in ex sed tellus volutpat 
    finibus ac sed nibh. Mauris vitae magna nunc. Vivamus ornare massa imperdiet purus 
    rhoncus, quis ultrices odio faucibus. Duis efficitur id urna nec semper. 
    Vivamus rutrum ac felis id egestas. Duis consequat, eros vel luctus eleifend, 
    ligula nibh hendrerit nibh, eget ultrices sapien eros ut ipsum. 
    Donec vel sollicitudin elit, ut elementum diam.
    ";

    $mail->setFrom($remitente, 'Jonathan León');
    $mail->addAddress($destinatario, 'Jony');
    $mail->addReplyTo($remitente, 'Jonathan León Canto');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $asunto;
    $mail->Body    = $mensaje;
    
    // Enviamos el mensaje
    $mail->send();

    echo 'Message has been sent';

} catch (Exception $e) {

    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}