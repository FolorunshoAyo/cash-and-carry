<?php
    require(dirname(dirname(dirname(dirname(__DIR__)))) . '/auth-library/resources.php');
     
    if(isset($_POST['submit'])){
        $wid = $db->real_escape_string($_POST['wid']);
        $html = "";

        if(empty($wid)){
            echo json_encode(array('success' => 0, 'error_title' => "Fetch Wallet", 'error_msg' => 'One or more fields are empty'));
        }else{
            $sql_get_wallet_history = $db->query("SELECT * FROM debtor_savings WHERE wallet_id='$wid'");

            $count = 1;
            while($savings_details = $sql_get_wallet_history->fetch_assoc()){
                $html .= "<tr><td>$count</td><td>NGN ".number_format($savings_details['amount'])."</td><td>".$savings_details['savings_days']."</td><td>".date("d M, Y", strtotime($savings_details['start_date']))." - ".date("d M, Y", strtotime($savings_details['end_date']))."</td><td>".date("d M, Y", strtotime($savings_details['deposited_at']))."<br>".date("H:i a", strtotime($savings_details['deposited_at']))."</td></tr>";
                $count++;
            }

            echo json_encode(array( 'success' => 1, 'data' => $html));
        }
    }else{
        echo json_encode(array('success' => 0, 'error_title' => 'Fatal', 'error_msg' => 'Unable to fetch wallet detailss'));
    }
?>