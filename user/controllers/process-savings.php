<?php
    require(dirname(dirname(__DIR__)) . '/auth-library/resources.php');
    

    if(isset($_POST['submit'])){
        $user_id = $_SESSION['user_id'];
        $amount = $db->real_escape_string($_POST['amount']);
        $wallet_id = $db->real_escape_string($_POST['wid']);

        // STORING WEEK RANGE AND TOTAL AMOUNT TO PAY
        $get_wallet_details = $db->query("SELECT store_wallets.*, savings_requests.installment_amount as installment_amount, savings_requests.installment_type as installment_type, savings_requests.duration_of_savings as duration_of_savings, savings_requests.target_amount as target_amount FROM store_wallets INNER JOIN savings_requests ON store_wallets.wallet_no = savings_requests.savings_id WHERE wallet_no={$wallet_id}");

        $wallet_details = $get_wallet_details->fetch_assoc();

        $start_period = $wallet_details['paid_for'] + 1;
        $end_period = ($start_period + $amount) - 1;
        $installment_type = $wallet_details['installment_type'];
        $amount_to_pay = $wallet_details['installment_amount'] * $amount;
        $amount_credited = $amount_to_pay + $wallet_details['amount'];

        $_SESSION['start_period'] = $start_period;
        $_SESSION['end_period'] = $end_period;
        $_SESSION['amount_to_pay'] = $amount_to_pay;
        $_SESSION['installment_type'] = $installment_type;
        $_SESSION['period_to_pay'] = $amount; 
        $_SESSION['wallet_no'] = $wallet_details['wallet_no'];
        $_SESSION['target_amount'] = $wallet_details['target_amount'];
        $_SESSION['duration_of_savings'] = $wallet_details['duration_of_savings'];

        // CHECK IF COMPLETED
        if(round($amount_credited)  > $wallet_details['target_amount']){
            echo json_encode(array('success' => 0, 'error_msg' => "This savings has been completed"));
            exit();
        }

        echo json_encode(array('success' => 1));
    }
?>