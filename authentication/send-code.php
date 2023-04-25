<?php
require(dirname(__DIR__) . '/auth-library/resources.php');
// Auth::Route("student/");
$url = strval($url);

if ((isset($_GET['a']) && $_GET['a'] == "send") && isset($_SESSION['email'])) {
	$email = $_SESSION['email'];
	$first_name = $_SESSION['first_name'];
	$subject = "HalfCarry Email Verification";
	$otp = rand(100000, 999999);
	$_SESSION['otp_code'] = $otp;

	$message = "<div class='container'>
				  <div class='image-container'>
				  	<img src='" . $url . "/assets/images/halfcarry-logo.jpeg' alt='logo'/>
				  </div>
                  <div class='box'>
                    <h2>". greeting() . "!</h2>
                    <p>Your verification code is <b>" . $otp . "<b></p>                              
                  </div>
                </div>";

	$message = '<!DOCTYPE html>
    <html>
      <head>
        <link rel="stylesheet" href="../assets/fonts/fonts.css" />
      </head>
      <body style="font-family: "Inter", sans-serif !important">
    
        <header style="margin: 50px 0; text-align: center;">
          <img src="https://halfcarry.com.ng/assets/images/halfcarry-logo.jpeg" style="width: 150px; height: 80px;"/>
        </header>
        <main>
          <section style="margin: 50px 10px; font-size: 14px;">
            <p style="margin-bottom: 10px; line-height: 1.5;">' . greeting() . $first_name . ',</p>
    
            <p style="margin-bottom: 10px; line-height: 1.5; text-align: justify;">
              Thank You for choosing <b>HalfCarry</b> as your preferred choice for
              shopping quality products. Your verification code is <b>' . $otp . '</b> has been
              processed.
            </p>
          </section>
        </main>
      </body>
    </html>';

	$_SESSION['verify'] = 1;
	$redirect_url = "";

	// send_custom_mail($email, $subject, $message);
	header("location: ".$url."verify");
}else {
	header("location: " . $url);
}
?>