<?php
require(dirname(dirname(__DIR__)) . '/auth-library/resources.php');
Auth::User("login");
$student_id = $_SESSION['student_id'];

if (isset($_GET["transaction_id"]) && isset($_GET["status"]) && isset($_GET["tx_ref"])) {
	$trans_id = $_GET['transaction_id'];
	$trans_status = $_GET['status'];
	$trans_ref = $_GET['tx_ref'];

	$url = "https://api.flutterwave.com/v3/transactions/" . $trans_id . "/verify";
	//Create cURL session
	$curl = curl_init($url);
	//Turn off SSL checker
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	//Decide the request that you want
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
	//Set the API headers
	curl_setopt($curl, CURLOPT_HTTPHEADER, [
		// "Authorization: Bearer FLWSECK-39743e6c4b313849e1a091fb9e47b322-X",
		"Authorization: Bearer FLWSECK_TEST-a2811a821fc0113cb78c03ca07632980-X",
		"Content-Type: Application/json"
	]);
	//Run cURL
	$run = curl_exec($curl);
	//Check for erros
	$error = curl_error($curl);
	if ($error) {
		die("Curl returned some errors: " . $error);
	}
	//echo"<pre>" . $run ."</pre>";
	//Convert to json obj
	$result = json_decode($run);	// 		print_r($result);

	if ($result->data->status == "successful") {
		$status = $result->data->status;
		$api_tranx_ref = $result->data->tx_ref;
		$api_amount = $result->data->amount;
		$api_charged_amount = $result->data->charged_amount;

		$savings_history_id = $_SESSION['savings_history__id'];
		$wallet_no = $_SESSION['wallet_no'];

		$sql_wallet = $db->query("SELECT amount FROM store_wallets WHERE wallet_no ={$wallet_no}");

		$current_balance = $sql_wallet->fetch_assoc();

		$sql_deposit = $db->query("UPDATE deposits SET deposit_status=1, deposit_amount={$api_amount} WHERE transaction_ref='{$api_tranx_ref}'");
		$sql_savings = $db->query("UPDATE savings SET savings_status=1 WHERE savings_status=0 AND id={$savings_history_id}");
		// $sql_add_to_logs = $db->query("INSERT INTO logs(student_id, log_message) VALUES({$student_id}, 'Deposited $api_amount NGN')");

		// UPDATE AMOUNT IN WALLET
		if (!$current_balance["amount"]) {
			$sql_wallet = $db->query("UPDATE wallets SET total_amount={$api_amount} WHERE student_id={$student_id}");
		} else {
			$total_amount = $current_balance["amount"];
			$sql_wallet = $db->query("UPDATE store_wallets SET amount={$total_amount} + {$api_amount} WHERE wallet_no={$wallet_no}");
		}

		if ($sql_deposit == true && $sql_savings == true) {
			unset($_SESSION['amount_to_pay']);
			unset($_SESSION['start_period']);
			unset($_SESSION['end_period']);
			unset($_SESSION['wallet_no']);

			header("location: ../successful-payment");
		} else {
			header("location: ../failed-payment");
		}
	} else {
		header("location: ../failed-payment");
	}

	curl_close($curl);
} else {
	header("location: ../z");
}
