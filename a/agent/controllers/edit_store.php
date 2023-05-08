<?php
    require(dirname(dirname(dirname(__DIR__))) . '/auth-library/resources.php');
     
    $agent_id = $_SESSION['agent_id'];

    if(isset($_POST['submit'])){
        $sid = $db->real_escape_string($_POST['sid']);
        $sname = $db->real_escape_string($_POST['sname']);
        $fname = $db->real_escape_string($_POST['fname']);
        $lname = $db->real_escape_string($_POST['lname']);
        $semail = $db->real_escape_string($_POST['semail']);
        $phoneno = $db->real_escape_string($_POST['phoneno']);
        $reg_no = $db->real_escape_string($_POST['reg_no']);

        if(empty($sname) || empty($fname) || empty($lname) || empty($semail) || empty($phoneno) || empty($reg_no)){
            echo json_encode(array('success' => 0, 'error_title' => "Create Agent", 'error_msg' => 'One or more fields are empty'));
        }else{
            $owner_name = trim($lname) . " " . trim($fname);
            $sql_update_store = $db->query("UPDATE stores SET name={$sname}, owner_name={$owner_name}, owner_email={$semail}, owner_phoneno={$phoneno}, reg_no={$reg_no} WHERE store_id={$sid}");

            if($sql_update_store){
                echo json_encode(array('success' => 1, 'store_name' => $sname));
            }
        }
    }else{
        echo json_encode(array('success' => 0, 'error_title' => 'Update Store', 'error_msg' => 'Unable to update store'));
    }
?>