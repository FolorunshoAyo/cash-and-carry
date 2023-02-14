<?php
    require(dirname(dirname(dirname(__DIR__))) . '/auth-library/resources.php');
     
    if(isset($_POST['submit'])){
        $agent_id = $_SESSION['agent_id'];
        $fname = $db->real_escape_string($_POST['fname']);
        $lname = $db->real_escape_string($_POST['lname']);
        $email = $db->real_escape_string($_POST['email']);
        $phoneno = $db->real_escape_string($_POST['phoneno']);
        $address = $db->real_escape_string($_POST['address']);

        if(empty($fname) || empty($lname) || empty($phoneno)){
            echo json_encode(array('success' => 0, 'error_title' => "Create Customer", 'error_msg' => 'One or more fields are empty'));
        }else{
            $sql_add_customer = $db->query("INSERT INTO agent_customers (agent_id, first_name, last_name, email, phone_no, address) VALUES('$agent_id', '$fname', '$lname', '$email','$phoneno', '$address')");

            if($sql_add_customer){
                echo json_encode(array('success' => 1));
            }
        }
    }else{
        echo json_encode(array('success' => 0, 'error_title' => 'Create Customer', 'error_msg' => 'Unable to create agent'));
    }
?>