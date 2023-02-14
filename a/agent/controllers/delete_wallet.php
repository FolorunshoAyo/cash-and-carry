<?php
    require(dirname(dirname(dirname(__DIR__))) . '/auth-library/resources.php');
     
    if(isset($_POST['submit'])){
        $wid = $db->real_escape_string($_POST['wid']);

        if(empty($wid)){
            echo json_encode(array('success' => 0, 'error_title' => "Delete Wallet", 'error_msg' => 'One or more fields are empty'));
        }else{
            $sql_delete_wallet = $db->query("DELETE FROM agent_wallets WHERE wallet_id='$wid'");

            if($sql_delete_wallet){
                echo json_encode(array('success' => 1));
            }
        }
    }else{
        echo json_encode(array('success' => 0, 'error_title' => 'Delete Wallet', 'error_msg' => 'Unable to delete wallet'));
    }
?>