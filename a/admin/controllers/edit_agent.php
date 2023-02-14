<?php
    require(dirname(dirname(dirname(__DIR__))) . '/auth-library/resources.php');
     
    if(isset($_POST['submit'])){
        $agent_id = $db->real_escape_string($_POST['aid']);
        $fname = $db->real_escape_string($_POST['fname']);
        $lname = $db->real_escape_string($_POST['lname']);
        $oname = $db->real_escape_string($_POST['oname']);
        $phoneno = $db->real_escape_string($_POST['phoneno']);
        $account_status = isset($_POST['active'])? $db->real_escape_string($_POST['active']) : "2";

        if(empty($fname) || empty($lname) || empty($oname) || empty($phoneno) || empty($account_status)){
            echo json_encode(array('success' => 0, 'error_title' => "Create Agent", 'error_msg' => 'One or more fields are empty'));
        }else{
           // UODATE AGENT
            $sql_update_agent = $db->query("UPDATE agents SET first_name='$fname', last_name='$lname', other_name='$oname', account_status='$account_status', phone_no='$phoneno' WHERE agent_id='$agent_id'");

            if($sql_update_agent){
                echo json_encode(array('success' => 1));
            }
        }
    }else{
        echo json_encode(array('success' => 0, 'error_title' => 'fatal', 'error_msg' => 'Unable to create agent'));
    }
?>