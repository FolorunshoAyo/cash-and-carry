<?php
    require(dirname(dirname(dirname(__DIR__))) . '/auth-library/resources.php');
     
    if(isset($_POST['submit'])){
        $user_id = $db->real_escape_string($_POST['uid']);
        $fname = $db->real_escape_string($_POST['fname']);
        $lname = $db->real_escape_string($_POST['lname']);
        $uname = $db->real_escape_string($_POST['uname']);
        $email = $db->real_escape_string($_POST['email']);
        $phoneno = $db->real_escape_string($_POST['phoneno']);
        $account_status = isset($_POST['active'])? $db->real_escape_string($_POST['active']) : "2";

        if(empty($fname) || empty($lname) || empty($phoneno) || empty($account_status)){
            echo json_encode(array('success' => 0, 'error_title' => "Edit User", 'error_msg' => 'One or more fields are empty'));
        }else{
            // UPDATE AGENT
            $sql_update_agent = $db->query("UPDATE users SET first_name='$fname', last_name='$lname', username='$uname', email='$email', account_status='$account_status', phone_no='$phoneno' WHERE user_id='$user_id'");

            if($sql_update_agent){
                echo json_encode(array('success' => 1));
            }
        }
    }else{
        echo json_encode(array('success' => 0, 'error_title' => 'fatal', 'error_msg' => 'Unable to update user'));
    }
?>