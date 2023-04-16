<?php
    require(dirname(dirname(dirname(dirname(__DIR__)))) . '/auth-library/resources.php');

    $agent_id = $_SESSION['agent_id'];

    if(isset($_POST['submit'])){
        $request_id = $db->real_escape_string($_POST['rid']);
        $status = $db->real_escape_string($_POST['status']);
        $user_id = $db->real_escape_string($_POST['user_id']);
        $savings_type = $db->real_escape_string($_POST['type_of_savings']);

        $get_savings_request_details = $db->query("SELECT savings_id FROM savings_requests WHERE id = {$request_id}");

        $request_details = $get_savings_request_details->fetch_assoc();

        // GRANTED SAVINGS PROCESS
        if($status === "2"){
            $sql_new_wallet = $db->query("INSERT INTO store_wallets (wallet_no, user_id, agent_id) VALUES ({$request_details['savings_id']}, {$user_id}, {$agent_id})");
        }
        
        $sql_update_savings_request = $db->query("UPDATE savings_requests SET status = {$status} WHERE id = {$request_id}");

        
        if($sql_update_savings_request){
            echo json_encode(array('success' => 1));
        }else{
            echo json_encode(array('success' => 0, 'error_title' => "Update Request Error", 'error_message' => "There was an error updating the request"));
        }
    }
?>