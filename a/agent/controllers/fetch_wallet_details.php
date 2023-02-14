<?php
    require(dirname(dirname(dirname(__DIR__))) . '/auth-library/resources.php');
     
    if(isset($_POST['submit'])){
        $wid = $db->real_escape_string($_POST['wid']);

        if(empty($wid)){
            echo json_encode(array('success' => 0, 'error_title' => "Fetch Wallet", 'error_msg' => 'One or more fields are empty'));
        }else{
            $sql_get_wallet_details = $db->query("SELECT agent_wallets.total_amount, products.name, product_meta.daily_payment FROM agent_wallets INNER JOIN products ON agent_wallets.product_id = products.product_id INNER JOIN product_meta ON agent_wallets.product_id = product_meta.product_id WHERE wallet_id='$wid'");

            $wallet_details = $sql_get_wallet_details->fetch_assoc();

            echo json_encode(array('success' => 1, 'balance' => strval(intval($wallet_details['total_amount'])), 'name' => $wallet_details['name'], 'daily_payment' => strval(number_format($wallet_details['daily_payment']))));
        }
    }else{
        echo json_encode(array('success' => 0, 'error_title' => 'Fatal', 'error_msg' => 'Unable to fetch wallet detailss'));
    }
?>