<?php
require(dirname(dirname(__DIR__)) . '/auth-library/resources.php');
// Auth::Route("student/");

if (isset($_POST['login'])) {
	$email = $db->real_escape_string($_POST['email']);
	$password = $db->real_escape_string($_POST['pwd']);
    $admin_type = $db->real_escape_string($_POST['admin_type']);

	if (empty($email) || empty($password)) {
		echo json_encode(array('success' => 0, 'error_title' => "both fields are required"));
	}else{
		if($admin_type === "agent"){
            $sql = $db->query("SELECT * FROM agents WHERE email='{$email}'");
            if ($sql->num_rows == 1) {
                $row = $sql->fetch_assoc();
                $passcode = $row['passkey'];
                // if($password === $passcode){
                if (password_verify($password, $passcode)) {
                    if($row['account_status'] == 0) {
                        echo json_encode(array('success' => 0, 'error_title' => 'Authentication Error', 'error_msg' => 'This account has been suspended, please contact the admin.'));
                    }elseif($row['account_status'] == 2){
                        echo json_encode(array('success' => 0, 'error_title' => 'Authentication Error', 'error_msg' => 'This account has been disabled, please contact the admin.'));
                    }else{
                        $_SESSION['agent_id'] = $row['agent_id'];
                        echo json_encode(array('success' => 1, 'admin_type' => $admin_type));
                    }
                }else {
                    //Error incorrect password
                    echo json_encode(array('success' => 0, 'error_title' => "Incorrect password", 'error_msg' => 'Try again'));
                }
            }else {
                //Error incorrect credentials
                echo json_encode(array('success' => 0, "error_title" => "Incorrect details", 'error_msg' => 'You provided details that do not exist'));
            }
        }else{
            $sql = $db->query("SELECT * FROM admin WHERE email='{$email}'");
            if ($sql->num_rows == 1) {
                $row = $sql->fetch_assoc();
                $passcode = $row['passkey'];
                if (password_verify($password, $passcode)) {
                    if($row['account_status'] == 0) {
                        echo json_encode(array('success' => 0, 'error_title' => 'Authentication Error', 'error_msg' => 'This account has been suspended, please contact the admin.'));
                    }else{
                        $_SESSION['admin_id'] = $row['admin_id'];
                        echo json_encode(array('success' => 1, 'admin_type' => $admin_type));
                    }
                }else {
                    //Error incorrect password
                    echo json_encode(array('success' => 0, 'error_title' => "Incorrect password", 'error_msg' => 'Try again'));
                }
            }else {
                //Error incorrect credentials
                echo json_encode(array('success' => 0, "error_title" => "Incorrect details", 'error_msg' => 'You provided details that do not exist'));
            }
            }
	}
}else {
	//Error if not isset
	echo json_encode(array('success' => 0, "error_title" => "fatal", "error_msg" => "Server Error (500)"));
}
?>