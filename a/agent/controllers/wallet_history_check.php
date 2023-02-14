<?php
    require(dirname(dirname(dirname(__DIR__))) . '/auth-library/resources.php');
     
    if(isset($_GET['wid'])){
        $wid = $db->real_escape_string($_GET['wid']);

        if(empty($wid)){
            echo json_encode(array('success' => 0, 'error_title' => "Fetch Wallet", 'error_msg' => 'One or more fields are empty'));
        }else{
            $sql_get_wallet_history = $db->query("SELECT * FROM agent_savings WHERE wallet_id='$wid'");

            if($sql_get_wallet_history->num_rows === 0){
                echo json_encode(array( 'success' => 1, 'containsInfo' => 0));
            }else{
                echo json_encode(array( 'success' => 1, 'containsInfo' => 1));
            }
        }
    }else{
        echo json_encode(array('success' => 0, 'error_title' => 'Fatal', 'error_msg' => 'Unable to fetch wallet detailss'));
    }
?>