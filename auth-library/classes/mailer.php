<?php
include(dirname(__DIR__)."/call.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
require dirname(__DIR__).'/PHPMailer/autoload.php';

require dirname(__DIR__).'/PHPMailer/PHPMailer/src/Exception.php';
require dirname(__DIR__).'/PHPMailer/PHPMailer/src/PHPMailer.php';
require dirname(__DIR__).'/PHPMailer/PHPMailer/src/SMTP.php';

$url = strval($url);

//Function to send otp to the user
function send_mail($email, $subject, $msg, $gurl)
{
    //Create a new PHPMailer instance
    $mail = new PHPMailer;

    //Set who the message is to be sent from
    $mail->setFrom('no-reply@'.$_ENV['EMAIL_DOMAIN'], $_ENV['APP_ENV']);
    //Set an alternative reply-to address
    $mail->addReplyTo($email);
    //Set who the message is to be sent to
    $mail->addAddress($email);
    //Set the subject line
    $mail->isHTML(true);
    $mail->Subject = $subject;

    $message = "<!DOCTYPE html>
				   <html>
					   <head>
					   	   <link rel='stylesheet'  href='" . $url . "assets/fonts/fonts.css' type='text/css' />
						   <style>               
						   .container{
							   background-color: #fff;
							   padding: 10px;
							   font-family: 'Inter', sans-serif;
							   border-radius: 5px;
							   border: 5px solid #1270B0;
						   }

						   .img-container{
							text-align: center;
							margin-bottom: 10px
						   }

						   .img-container img{
								height: 80px;
								width: 80px;
						   }

						   .box {
							   padding: 30px;
							   text-align: center;
						   }
						   
						   p{
							   font-size: 15px;
						   }
						   </style>
					   </head>
					   <body>
                            $msg
					   </body>
					   </html>";

    $mail->Body = $message;
    $mail->AltBody = $message;

    //send the message, check for errors
    if (!$mail->send()) {
		alert_back("error","Unable to send email, Kindly confirm your entered email and try again!");
	}else {
	    $redirect_url = $_ENV['URL'].$gurl;
	    alert_msg_url("success","Email Sent Successfully!","Check your mailbox or spam folder for your reset link", $redirect_url);	
    }
}

function send_raw_mail($email, $subject, $msg)
{
    //Create a new PHPMailer instance
    $mail = new PHPMailer;

    //Set who the message is to be sent from
    $mail->setFrom('no-reply@'.$_ENV['EMAIL_DOMAIN'], $_ENV['APP_ENV']);
    //Set an alternative reply-to address
    $mail->addReplyTo($email);
    //Set who the message is to be sent to
    $mail->addAddress($email);
    //Set the subject line
    $mail->isHTML(true);
    $mail->Subject = $subject;

    $message = "<!DOCTYPE html>
				   <html>
					   <head>
						   <style>               
						   .container{
							   background-color:rgb(234, 232, 232);
							   padding: 10px;
							   font-family: arial, calibri;
						   }
   
						   .box {
							   padding: 30px;
							   background-color: white;
							   margin:auto;
							   border-radius: 10px;
							   font-size: 20px;
							   font-family: arial, calibri;
							   text-align: center;
						   }
						   
						   p{
							   font-size:15px;
							   font-family: arial, calibri;
						   }
						   </style>
					   </head>
					   <body>
                            $msg
					   </body>
					   </html>";

    $mail->Body = $message;
    $mail->AltBody = $message;

    //send the message, check for errors
    if (!$mail->send()) {
        echo "error";
		// alert_back("error","Unable to send email!");
	}
}



?>