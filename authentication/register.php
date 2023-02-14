<?php
require(dirname(__DIR__) . '/auth-library/resources.php');
// Auth::User("");

if (isset($_POST['submit'])) {
	// PERSONAL INFO
	$first_name = $db->real_escape_string($_POST['fname']);
	$last_name = $db->real_escape_string($_POST['lname']);
	$email = $db->real_escape_string($_POST['email']);
	$phone_no = $db->real_escape_string($_POST['mobileno']);
	$password = $db->real_escape_string($_POST['pwd']);
	$confirm_password = $db->real_escape_string($_POST['cpwd']);

	//Check if all fields are empty
	if(empty($first_name) || empty($last_name) || empty($email) || empty($phone_no) || empty($password) || empty($confirm_password)) {
        echo json_encode(array('success' => 0, 'error_title' => "Form error", 'error_message' => "All fields are required"));
        exit();
	} else {	
		if($password != $confirm_password) {
			echo json_encode(array('success' => 0, 'error_title' => "Form error", 'error_message' => "Your password does not match"));
            exit();
		} else {
			//Check if the email and phoneno already exists
			$sql_email = $db->query("SELECT * FROM users WHERE email='{$email}'");
			$sql_phone = $db->query("SELECT * FROM users WHERE phone_no='{$phone_no}'");
			if($sql_email->num_rows == 1) {
			    echo json_encode(array('success' => 0, 'error_title' => "Error", 'error_message' => "An account with your email already exists"));
                exit();
			}elseif($sql_phone->num_rows == 1){
				echo json_encode(array('success' => 0, 'error_title' => "Error", 'error_message' => "An account with your phone number already exists"));
                exit();
			}else{
				//Proceed to register if the email and phoneno does not exists
			    $hash_pass = password_hash($confirm_password, PASSWORD_DEFAULT);
			    //Save student information
			    $statement_personal = $db->prepare("INSERT INTO users(first_name, last_name, email, phone_no, passkey) VALUES(?,?,?,?,?,?,?)");
				$statement_personal->bind_param("sssss", $first_name, $last_name, $email, $phone_no, $hash_pass);
					if($statement_personal->execute()){
					    $_SESSION['email'] = $email;
					    echo json_encode(array('success' => 1));
					}
			}		
		}
	}
	
}else {
	echo json_encode(array('success' => 0, 'error_title' => "Fatal", 'error_message' => "Unable to register user"));
}
?>