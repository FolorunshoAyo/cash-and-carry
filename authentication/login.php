<?php
require(dirname(__DIR__) . '/auth-library/resources.php');
// Auth::Route("student/");

if (isset($_POST['login'])) {
	$email = $db->real_escape_string($_POST['email']);
	$password = $db->real_escape_string($_POST['pwd']);

	if (empty($email) || empty($password)) {
		echo json_encode(array('success' => 0, 'error_title' => "both fields are required"));
	}else {
		$sql = $db->query("SELECT * FROM users WHERE email='{$email}'");
		if ($sql->num_rows == 1) {
			$row = $sql->fetch_assoc();
			$passcode = $row['passkey'];
			// if (password_verify($password, $passcode)) {
			if ($password === $passcode) {
				if($row['is_email_verified'] == 0) {
					//Redirect to authentication/send-code?a=send
					echo json_encode(array('success' => 1, 'redirect' => 'email-auth'));
				}elseif ($row['is_email_verified'] == 1 || $row['account_status'] == 1) {
					$_SESSION['user_id'] = $row['user_id'];
					$_SESSION['user_name'] = $row['first_name']." ".$row['last_name'];
					echo json_encode(array('success' => 1, 'redirect' => 'home-page'));
				}elseif ($row['account_status'] == 2) {
					//Alert the user that his/her account has been suspended
					echo json_encode(array('success' => 0, "error_title" => "suspended"));
				}
			}else {
				//Error incorrect password
				echo json_encode(array('success' => 0, "error_title" => "incorrect password"));
			}
		}else {
		//Error incorrect credentials
		echo json_encode(array('success' => 0, "error_title" => "incorrect details"));
		}
	}
}else {
	//Error if not isset
	echo json_encode(array('success' => 0, "error_title" => "fatal"));
}
?>