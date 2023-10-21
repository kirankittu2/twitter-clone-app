<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

function sendCode($email , $subject , $code){

    try {
        global $mail;
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                     
        $mail->isSMTP();                                           
        $mail->Host       = 'smtp.gmail.com';                       
        $mail->SMTPAuth   = true;                                  
        $mail->Username   = 'gestolimited@gmail.com';                    
        $mail->Password   = 'arkwvxzpnnedfxyc';                           
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;          
        $mail->Port       = 465;                                    

        //Recipients
        $mail->setFrom('gestolimited@gmail.com', 'Gesto');
        $mail->addAddress($email);              

        //Content
        $mail->isHTML(true);                              
        $mail->Subject = $subject;
        $mail->Body    = 'Your Verification Code is: <b>'. $code .'</b> ';

        $mail->send();
        echo "Message has been sent";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

}