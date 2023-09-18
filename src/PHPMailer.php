<?php

namespace App;

use PHPMailer\PHPMailer\PHPMailer;

require '/vendor/autoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer(true);
//Set who the message is to be sent from
$mail->setFrom('benjamin.baroche@free.fr', 'Home24');
//Set an alternative reply-to address
$mail->addReplyTo('clients@home24.fr', 'Team Home24');
//Set who the message is to be sent to
$mail->addAddress('whoto@example.com', 'John Doe');
//Set the subject line
$mail->Subject = 'Confirmation d\'inscription';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
//Replace the plain text body with one created manually
$mail->AltBody = 'Bonne nouvelle à l\horizon !';
//Attach an image file
$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message sent!';
}
