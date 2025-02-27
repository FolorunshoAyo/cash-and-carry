<?php
require(dirname(dirname(__DIR__)) . "/auth-library/resources.php");

if(isset($_POST['submit'])){
    $user_id = $db->real_escape_string($_POST['user_id']);
    $first_name = $db->real_escape_string($_POST['fname']);
    $last_name = $db->real_escape_string($_POST['lname']);
    $user_name = $db->real_escape_string($_POST['username']);
    $email = $db->real_escape_string($_POST['email']);
    $mobile_no = $db->real_escape_string($_POST['mobileno']);


    // Check if the fields are empty
    if(empty($first_name) || empty($last_name) || empty($mobile_no) || empty($user_name)){
        echo json_encode(array('success' => 0, 'error_title' => "Profile Update", 'error_message' => "Some fields are empty"));
    }

    if(!empty($email)){
        $sql_check_existing_user = $db->query("SELECT * FROM users WHERE email = '{$email}'");

        if ($sql_check_existing_user->num_rows == 1) {
            echo json_encode(array('success' => 0, 'error_title' => 'Update Profile', 'error_message' => 'A user with this email already exist'));
            exit();
        }
    }else{
        $email = "";
    }

    $update_profile_sql = $db->query("UPDATE users SET first_name='{$first_name}', last_name='{$last_name}', username = '{$user_name}', email = '{$email}', phone_no = '{$mobile_no}' WHERE user_id = '{$user_id}'");

    if($update_profile_sql){
        echo json_encode(array('success' => 1));
    }else{
        echo json_encode(array('success' => 0, 'error_title' => "Profile Update", 'error_message' => "Unable to update profile"));
    }

}else{
    echo json_encode(array('success' => 0, 'error_title' => "Profile Update", 'error_message' => "Unable to update profile"));
}

?>