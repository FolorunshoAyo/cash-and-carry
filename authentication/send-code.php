<?php
require(dirname(__DIR__) . '/auth-library/resources.php');
// Auth::Route("student/");
$url = strval($url);

if ((isset($_GET['a']) && $_GET['a'] == "send") && isset($_SESSION['email'])) {
	$email = $_SESSION['email'];
	$subject = "CDS Email Verification";
	$otp = rand(100000, 999999);
	$_SESSION['otp_code'] = $otp;

	$message = "<div class='container'>
				  <div class='image-container'>
				  	<img src='" . $url . "/assets/images/logo-small.png' alt='logo'/>
				  </div>
                  <div class='box'>
                    <h2>". greeting() . "!</h2>
                    <p>Your verification code is <b>" . $otp . "<b></p>                              
                  </div>
                </div>";

	$_SESSION['verify'] = 1;
	$redirect_url = "";
	send_raw_mail($email, $subject, $message);
	header("location: ".$url."verify");
}else {
	header("location: " . $url);
}
?>