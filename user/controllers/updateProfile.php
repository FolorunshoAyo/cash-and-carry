<?php
require(dirname(dirname(__DIR__)) . "/auth-library/resources.php");

if(isset($_POST['submit'])){
    $userID = $db->real_escape_string($_POST['user_id']);
    $first_name = $db->real_escape_string($_POST['fname']);
    $last_name = $db->real_escape_string($_POST['lname']);
    $mobile_no = $db->real_escape_string($_POST['mobileno']);


    // Check if the fields are empty
    if(empty($first_name) || empty($last_name) || empty($mobile_no)){
        echo json_encode(array('success' => 0, 'error_title' => "Profile Update", 'error_message' => "Some fields are empty"));
    }

    $update_profile_sql = $db->query("UPDATE users SET first_name={$first_name}, last_name={$last_name}, phone_no={$mobile_no}");

    if($update_profile_sql){
        echo json_encode(array('success' => 1));
    }else{
        echo json_encode(array('success' => 0, 'error_title' => "Profile Update", 'error_message' => "Unable to update profile"));
    }

}else{
    echo json_encode(array('success' => 0, 'error_title' => "Profile Update", 'error_message' => "Unable to update profile"));
}

?>