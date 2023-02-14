<?php
    require(dirname(dirname(dirname(__DIR__))) . '/auth-library/resources.php');
     
    if(isset($_POST['submit'])){
        $cid = $db->real_escape_string($_POST['cid']);
        $fname = $db->real_escape_string($_POST['fname']);
        $lname = $db->real_escape_string($_POST['lname']);
        $email = $db->real_escape_string($_POST['email']);
        $phoneno = $db->real_escape_string($_POST['phoneno']);
        $address = $db->real_escape_string($_POST['address']);

        if(empty($fname) || empty($lname) || empty($phoneno)){
            echo json_encode(array('success' => 0, 'error_title' => "Edit Customer", 'error_msg' => 'One or more fields are empty'));
        }else{
            $sql_edit_customer = $db->query("UPDATE agent_customers SET first_name='$fname', last_name='$lname', email='$email', phone_no='$phoneno', address='$address' WHERE agent_customer_id='$cid'");

            if($sql_edit_customer){
                echo json_encode(array('success' => 1));
            }
        }
    }else{
        echo json_encode(array('success' => 0, 'error_title' => 'Edit Customer', 'error_msg' => 'Unable to create agent'));
    }
?>