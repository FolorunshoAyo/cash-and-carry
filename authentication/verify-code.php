<?php
require(dirname(__DIR__).'/auth-library/resources.php');
// Auth::Route("user/");
$url = strval($url);

if(isset($_POST['verify'])) {
	$otp_code = trim($db->real_escape_string($_POST['otp']));
	$email = $_SESSION['email'];

	if($_SESSION['otp_code'] == $otp_code) {
		$sql = $db->query("UPDATE users SET is_email_verified=1 WHERE email='{$email}'");
		if($sql) {
			unset($_SESSION['email']);
			unset($_SESSION['otp_code']);
			header("location: ".$url."success");
		}else{
			$_SESSION['isverified'] = false;
		}
	}else{
		$_SESSION['isverified'] = false;
	}
}else{
	header("location: ".$url."login");
}
?>