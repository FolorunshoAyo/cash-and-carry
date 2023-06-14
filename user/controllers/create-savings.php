<?php
require(dirname(dirname(__DIR__)) . '/auth-library/resources.php');

$user_id = $_SESSION['user_id'];

if(isset($_POST['submit'])) {
    $start_period = $_SESSION['start_period'];
    $end_period = $_SESSION['end_period'];
    $amount_to_pay = $_SESSION['amount_to_pay'];
    $installment_type = $_SESSION['installment_type']; 
    $period_to_pay = $_SESSION['period_to_pay']; 

    //EMPTY VARIABLE FOR TRANSACTION REF:
    $transaction_ref = $_POST['tx_ref'];
    $wallet_no = $_POST['wallet_no'];

    $result = $db->query('SELECT NOW() AS nowtime');
    $row = $result->fetch_assoc();
    $now = $row['nowtime'];

    $deposit_type = "2";

    $sql_deposit = $db->prepare("INSERT INTO deposits(user_id, transaction_ref, type, type_no, deposit_amount) VALUES(?,?,?,?,?)");
    $sql_deposit->bind_param("issss", $user_id, $transaction_ref, $deposit_type, $wallet_no, $amount_to_pay);

    $sql_savings = $db->prepare("INSERT INTO savings_history(wallet_no, amount, paid_for) VALUES(?,?,?)");
    $sql_savings->bind_param("sss", $wallet_no, $amount_to_pay, $period_to_pay);

    if($sql_deposit->execute()) {
        if($sql_savings->execute()){
             // ECHO A RESPONSE AND CALL Flutterwave FUNCTION
            $_SESSION['savings_history_id'] = $db->insert_id;

            // echo $_SESSION['savings_history_id'];

            echo json_encode(array("success" => 1, "amount_charged" => $amount_to_pay));
        }else{
            //CONSOLE LOG A RESPONSE
            echo json_encode(array("success" => 0, "error_message" => "Unable to insert deposits values to database"));
        }

    }else{
       //CONSOLE LOG A RESPONSE
       echo json_encode(array("success" => 0, "error_message" => "Unable to insert savings values to database"));
    }
}
?>