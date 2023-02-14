<?php
    require(dirname(dirname(dirname(__DIR__))) . '/auth-library/resources.php');
     
    if(isset($_POST['submit'])){
        $cid = $db->real_escape_string($_POST['cid']);
        $aid = $_SESSION['agent_id'];

        if(empty($cid)){
            echo json_encode(array('success' => 0, 'error_title' => "Edit Customer", 'error_msg' => 'One or more fields are empty'));
        }else{
            $sql_check_existing_wallets = $db->query("SELECT * FROM agent_wallets WHERE agent_customer_id='$cid' AND agent_id='$aid'");

            if($sql_check_existing_wallets->num_rows > 0){
                $sql_delete_customer_wallets = $db->query("DELETE FROM agent_wallets WHERE agent_customer_id='$cid' AND agent_id='$aid'");
            }

            $sql_delete_customer_details = $db->query("DELETE FROM agent_customers WHERE agent_customer_id='$cid' AND agent_id='$aid'");

            if($sql_delete_customer_details){
                echo json_encode(array('success' => 1))
            }
        }
    }else{
        echo json_encode(array('success' => 0, 'error_title' => 'Edit Customer', 'error_msg' => 'Unable to create agent'));
    }
?>