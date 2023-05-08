<?php
require(dirname(dirname(__DIR__)) . '/auth-library/resources.php');
Auth::User("login");
$user_id = $_SESSION['user_id'];

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

		$savings_history_id = $_SESSION['savings_history_id'];
		$wallet_no = $_SESSION['wallet_no'];
		$period_to_pay = $_SESSION['period_to_pay'];

		$sql_wallet = $db->query("SELECT store_wallets.*, savings_requests.installment_type as installment_type, savings_requests.duration_of_savings as duration_of_savings, savings_requests.installment_amount as installment_amount, savings_requests.target_amount as target_amount, savings_requests.type_of_savings as type_of_savings FROM store_wallets INNER JOIN savings_requests ON savings_requests.savings_id = store_wallets.wallet_no WHERE wallet_no ={$wallet_no}");

		$wallet_details = $sql_wallet->fetch_assoc();

    $user_id = $wallet_details['user_id'];
		$get_user_details = $db->query("SELECT * FROM users WHERE user_id=$user_id");
		$user_details = $get_user_details->fetch_assoc();

    $agent_id = $wallet_details['agent_id'];
		$get_agent_details = $db->query("SELECT * FROM agents WHERE agent_id = $agent_id");
		$agent_details = $get_agent_details->fetch_assoc();

		$sql_deposit = $db->query("UPDATE deposits SET deposit_status=1, deposit_amount={$api_amount} WHERE transaction_ref='{$api_tranx_ref}'");
		$sql_savings = $db->query("UPDATE savings_history SET payment_status=1 WHERE payment_status=0 AND id={$savings_history_id}");
		// $sql_add_to_logs = $db->query("INSERT INTO logs(student_id, log_message) VALUES({$student_id}, 'Deposited $api_amount NGN')");

		$wallet_amount = $wallet_details["amount"];
		$paid_for = $wallet_details['paid_for'];
		$target_amount = $_SESSION['target_amount'];
		$amount_credited = $wallet_amount + $api_amount;

		$savings_type = $wallet_details['type_of_savings'];
		$installment_type = $wallet_details['installment_type'];
    $installment_amount = $wallet_details['installment_amount'];
    $installment_duration = $wallet_details['duration_of_savings'];

		$installment_type_in_words = $installment_type === "1" ? "day(s)" : ($installment_type === "2" ? "week(s)" : "month(s)");
		$amount_paid = ($period_to_pay * $wallet_details['installment_amount']); // AMOUNT TO BE PAID
		$paid_for = $wallet_details['paid_for'] + $period_to_pay; // PERIOD PAID FOR e.g 5 days || weeks || months
		$savings_products = "";

		$get_savings_products = $db->query("SELECT * FROM savings_products INNER JOIN products ON savings_products.product_id = products.product_id WHERE savings_id = {$wallet_no}");

		while ($product_details = $get_savings_products->fetch_assoc()) {
			$picture = explode(",", $product_details['pictures'])[0];

			$savings_products .= '<div style="border: 1px solid #ff5c00;
				border-bottom: 5px solid #ff5c00; margin-bottom: 40px;">
				<div style="height: 80px;
				text-align: center;
				border-bottom: 1px solid #ff5c00;" >
					<img src="https://halfcarry.com.ng/assets/product-images/' . $picture .  '" style=" height: 100%;
					width: 80px;" />
				</div>
				<div style="display: table; border-collapse: collapse; width: 100%;">
					<p style="display: table-row; border-bottom: 1px solid #ff5c00;">
					<span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Item </span>
					<span style="display: table-cell;"></span>
					<span style="display: table-cell;  padding: 10px; font-size: 15px; text-align: right; width: 100%;" >' . $product_details['product_name'] . '</span>
					</p>
					<p style="display: table-row; border-bottom: 1px solid #ff5c00;">
					<span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Quantity </span>
					<span style="display: table-cell;  padding: 10px;"></span>
					<span style="display: table-cell;  padding: 10px; font-size: 15px; text-align: right;">' . $product_details['product_quantity'] . '</span>
					</p>
					<p style="display: table-row; border-bottom: 1px solid #ff5c00;">
					<span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Price </span>
					<span style="display: table-cell;  padding: 10px;"></span>
					<span style="display: table-cell;  padding: 10px; font-size: 15px; text-align: right;">₦ ' . number_format($product_details['product_price'], 2) . '</span>
					</p>
				</div>
				</div>';
		}

		// UPDATE AMOUNT IN WALLET
		if (!$wallet_details["amount"]) {
			$sql_wallet = $db->query("UPDATE store_wallets SET amount={$api_amount}, paid_for = {$period_to_pay} WHERE wallet_no={$wallet_no}");
		} else {
			$sql_wallet = $db->query("UPDATE store_wallets SET amount={$amount_credited}, paid_for = {$paid_for} + {$period_to_pay} WHERE wallet_no={$wallet_no}");
		}

		// CHECKING FOR COMPLETE SAVINGS
		if (round($amount_credited) >= round($target_amount)) {
			$set_wallet_to_completed = $db->query("UPDATE store_wallets SET completed = 1 WHERE wallet_no = {$wallet_no}");
		}

		if ($sql_deposit == true && $sql_savings == true) {
			if ($set_wallet_to_completed) {
				// SEND MAIL FOR WALLET COMPLETION
				$user_message_html = '<!DOCTYPE html>
            <html>
            <head>
                <link rel="stylesheet" href="' . $url . 'assets/fonts/fonts.css" />
            </head>
            <body style="font-family: "Inter", sans-serif !important">
            
                <header style="margin: 50px 0; text-align: center;">
                <img src="https://halfcarry.com.ng/assets/images/halfcarry-logo.jpeg" style="width: 150px; height: 80px;"/>
                </header>
                <main>
                <section style="margin: 50px 10px; font-size: 14px;">
                    <p style="margin-bottom: 10px; line-height: 1.5;">Dear ' . $user_details['first_name'] . ',</p>
            
                    <p style="margin-bottom: 10px; line-height: 1.5; text-align: justify;">
                    Thank You for choosing <b>HalfCarry</b> as your preferred choice for
                    shopping quality products.
                    </p>
                    <p style="margin-bottom: 10px; line-height: 1.5; text-align: justify;">
                    Your savings  - <b>#' . $wallet_no . '</b> has been
                    completed.
                    </p>
                </section>

                <section style="margin: 50px 10px; font-size: 14px;">
                    <p style=" font-size: 16px; margin-bottom: 10px;"><strong>You ordered for</strong></p>

                    ' . $savings_products . '
                </section>
                <section style="margin: 50px 10px;">
                    <div style="display: table; border-collapse: collapse; width: 100%; border: 1px solid #ff5c00;
                    border-bottom: 5px solid #ff5c00; margin-bottom: 40px;">
                    <div style="display: table-row; border-bottom: 1px solid #ff5c00;">
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Savings Type </span>
                        <span style="display: table-cell;"></span>
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;">' . $type_of_savings . '</span>
                    </div>
                    <div style="display: table-row; border-bottom: 1px solid #ff5c00;">
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Duration </span>
                        <span style="display: table-cell;"></span>
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;">' . $wallet_details['duration_of_savings'] . ' ' . $installment_type_plural . ' (NGN ' . number_format($installment_amount, 2) . '/' . $installment_type . ') </span>
                    </div>
                    <div style="display: table-row; border-bottom: 1px solid #ff5c00;">
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;">  Type of payment </span>
                        <span style="display: table-cell;"></span>
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;">' . $installment_type_adjective . '</span>
                    </div>
                    <div style="display: table-row; border-bottom: 1px solid #ff5c00;">
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Amount to save </span>
                        <span style="display: table-cell;"></span>
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;"> NGN ' . number_format($wallet_details['target_amount'], 2) . '</span>
                    </div>
                    <div style="display: table-row; border-bottom: 1px solid #ff5c00;">
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Agent </span>
                        <span style="display: table-cell;"></span>
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;">' . $agent_details['last_name'] . ' ' . $agent_details['first_name'] . '</span>
                    </div>
                    <div style="display: table-row; border-bottom: 1px solid #ff5c00;">
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Agent Email </span>
                        <span style="display: table-cell;"></span>
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;">' . $agent_details['email'] .  '</span>
                    </div>
                    <div style="display: table-row; border-bottom: 1px solid #ff5c00;">
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Agent Phone </span>
                        <span style="display: table-cell;"></span>
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;">' . $agent_details['phone_no'] . '</span>
                    </div>
                    </div>
                </section>
                </main>
            </body>
            </html>
                ';

				$agent_message_html = '
        <!DOCTYPE html>
            <html>
            <head>
                <link rel="stylesheet" href="' . $url . 'assets/fonts/fonts.css" />
            </head>
            <body style="font-family: "Inter", sans-serif !important">
            
                <header style="margin: 50px 0; text-align: center;">
                <img src="https://halfcarry.com.ng/assets/images/halfcarry-logo.jpeg" style="width: 150px; height: 80px;"/>
                </header>
                <main>
                <section style="margin: 50px 10px; font-size: 14px; text-align: justify;">
                    <p style="margin-bottom: 10px; line-height: 1.5;">Dear ' . $agent_details['first_name'] . ',</p>
            
                    <p style="margin-bottom: 10px; text-align: justify;">
                    You are recieving this mail to confirm the sompletion of savings in wallet <b>' . $wallet_no . '</b> 
                    </p>

                </section>
                <section style="margin: 50px 10px; font-size: 14px;">
                    <p style=" font-size: 16px; margin-bottom: 10px;"><strong>User ordered for</strong></p>

                    ' . $savings_products . '

                </section>
                <section style="margin: 50px 10px;">
                    <div style="display: table; border-collapse: collapse; width: 100%; border: 1px solid #ff5c00;
                    border-bottom: 5px solid #ff5c00; margin-bottom: 40px;">
                    <div style="display: table-row; border-bottom: 1px solid #ff5c00;">
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Savings Type </span>
                        <span style="display: table-cell;"></span>
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;">' . $savings_type . '</span>
                    </div>
                    <div style="display: table-row; border-bottom: 1px solid #ff5c00;">
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Duration </span>
                        <span style="display: table-cell;"></span>
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;">' . $installment_duration . ' ' . $installment_type_plural . ' (NGN ' . number_format($installment_amount, 2) . '/' . $installment_type . ') </span>
                    </div>
                    <div style="display: table-row; border-bottom: 1px solid #ff5c00;">
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;">  Type of payment </span>
                        <span style="display: table-cell;"></span>
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;">' . $installment_type_adjective . '</span>
                    </div>
                    <div style="display: table-row; border-bottom: 1px solid #ff5c00;">
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Amount to save </span>
                        <span style="display: table-cell;"></span>
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;"> NGN ' . number_format($wallet_details['target_amount'], 2) . '</span>
                    </div>
                    <div style="display: table-row; border-bottom: 1px solid #ff5c00;">
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Agent </span>
                        <span style="display: table-cell;"></span>
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;">' . $user_details['last_name'] . ' ' . $user_details['first_name'] . '</span>
                    </div>
                    <div style="display: table-row; border-bottom: 1px solid #ff5c00;">
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Agent Email </span>
                        <span style="display: table-cell;"></span>
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;">' . $user_details['email'] .  '</span>
                    </div>
                    <div style="display: table-row; border-bottom: 1px solid #ff5c00;">
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Agent Phone </span>
                        <span style="display: table-cell;"></span>
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;">' . $user_details['phone_no'] . '</span>
                    </div>
                    </div>
                </section>
                </main>
            </body>
            </html>
            ';
				// PREPARING AGENT AND USER SUBJECT
				$user_subject = "Your Halfcarry Savings - $wallet_no has been completed";
				$agent_subject = "Savings Completion Alert";

				// send_custom_mail($user_details['email'], $user_subject, $user_message_html);
				// send_custom_mail($agent_details['email'], $agent_subject, $agent_message_html);

				unset($_SESSION['period_to_pay']);
				unset($_SESSION['installment_type']);
				unset($_SESSION['amount_to_pay']);
				unset($_SESSION['start_period']);
				unset($_SESSION['end_period']);
				unset($_SESSION['duration_of_savings']);

				$_SESSION['completed_payment'] = 1;
			} else {
				// SEND MAIL FOR WALLET CREDIT
				$user_message_html = '<!DOCTYPE html>
            <html>
            <head>
                <link rel="stylesheet" href="' . $url . 'assets/fonts/fonts.css" />
            </head>
            <body style="font-family: "Inter", sans-serif !important">
            
                <header style="margin: 50px 0; text-align: center;">
                <img src="https://halfcarry.com.ng/assets/images/halfcarry-logo.jpeg" style="width: 150px; height: 80px;"/>
                </header>
                <main>
                <section style="margin: 50px 10px; font-size: 14px;">
                    <p style="margin-bottom: 10px; line-height: 1.5;">Dear ' . $user_details['first_name'] . ',</p>
            
                    <p style="margin-bottom: 10px; line-height: 1.5; text-align: justify;">
                    Thank You for choosing <b>HalfCarry</b> as your preferred choice for
                    shopping quality products.
                    </p>
                    <p style="margin-bottom: 10px; line-height: 1.5; text-align: justify;">
                    Your savings  - <b>#' . $wallet_no . '</b> has been
                    credited with NGN ' . $amount_credited . '.
                    </p>
                </section>
                <section style="margin: 50px 10px;">
                        <p style="margin-bottom: 10px;">Transaction Summary</p>

                          <div style="display: table;  border-spacing: 10px; width: 100%;">
                            <div style="display: table-row; height: 100px;">
                              <div style="display: table-cell;">
                                <div style="border: 1px solid #ff5c00;">
                                  <h3 style="margin: 0px; padding: 10px 20px; background-color: #ff5c00; color: white; font-size: 15px;">
                                    Amount deposited
                                  </h3>
                                  <p style="font-size: 15px; padding: 10px;">
                                    ' . number_format($amount_paid, 2) . '
                                  </p>
                                </div>
                              </div>  
                              <div style="display: table-cell;">
                                <div style="border: 1px solid #ff5c00;">
                                  <h3 style="margin: 0px; padding: 10px 20px; background-color: #ff5c00; color: white; font-size: 15px;">
                                    ' . $installment_type_plural . ' settled
                                  </h3>
                                  <p style="font-size: 15px; padding: 10px;">
                                    '  . $period_to_pay . '
                                  </p>
                                </div>
                              </div>  
                            </div>
                            <div style="display: table-row; height: 100px;">
                              <div style="display: table-cell;">
                                <div style="border: 1px solid #ff5c00;">
                                  <h3 style="margin: 0px; padding: 10px 20px; background-color: #ff5c00; color: white; font-size: 15px;">
                                    Depoosited By
                                  </h3>
                                  <p style="font-size: 15px; padding: 10px;">
                                    Agent
                                  </p>
                                </div>
                              </div>  
                            </div>
                          </div>
                </section>
                        
                <section style="margin: 50px 10px; font-size: 14px;">
                    <p style=" font-size: 16px; margin-bottom: 10px;"><strong>You ordered for</strong></p>

                    ' . $savings_products . '
                </section>
                <section style="margin: 50px 10px;">
                    <div style="display: table; border-collapse: collapse; width: 100%; border: 1px solid #ff5c00;
                    border-bottom: 5px solid #ff5c00; margin-bottom: 40px;">
                    <div style="display: table-row; border-bottom: 1px solid #ff5c00;">
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Savings Type </span>
                        <span style="display: table-cell;"></span>
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;">' . $type_of_savings . '</span>
                    </div>
                    <div style="display: table-row; border-bottom: 1px solid #ff5c00;">
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Duration </span>
                        <span style="display: table-cell;"></span>
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;">' . $wallet_details['duration_of_savings'] . ' ' . $installment_type_plural . ' (NGN ' . number_format($installment_amount, 2) . '/' . $installment_type . ') </span>
                    </div>
                    <div style="display: table-row; border-bottom: 1px solid #ff5c00;">
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;">  Type of payment </span>
                        <span style="display: table-cell;"></span>
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;">' . $installment_type_adjective . '</span>
                    </div>
                    <div style="display: table-row; border-bottom: 1px solid #ff5c00;">
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Amount to save </span>
                        <span style="display: table-cell;"></span>
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;"> NGN ' . number_format($wallet_details['target_amount'], 2) . '</span>
                    </div>
                    <div style="display: table-row; border-bottom: 1px solid #ff5c00;">
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Agent </span>
                        <span style="display: table-cell;"></span>
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;">' . $agent_details['last_name'] . ' ' . $agent_details['first_name'] . '</span>
                    </div>
                    <div style="display: table-row; border-bottom: 1px solid #ff5c00;">
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Agent Email </span>
                        <span style="display: table-cell;"></span>
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;">' . $agent_details['email'] .  '</span>
                    </div>
                    <div style="display: table-row; border-bottom: 1px solid #ff5c00;">
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Agent Phone </span>
                        <span style="display: table-cell;"></span>
                        <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;">' . $agent_details['phone_no'] . '</span>
                    </div>
                    </div>
                </section>
                </main>
            </body>
            </html>
                ';

				$agent_message_html = '
        <!DOCTYPE html>
    <html>
      <head>
        <link rel="stylesheet" href="' . $url . 'assets/fonts/fonts.css" />
      </head>
      <body style="font-family: "Inter", sans-serif !important">
    
        <header style="margin: 50px 0; text-align: center;">
          <img src="https://halfcarry.com.ng/assets/images/halfcarry-logo.jpeg" style="width: 150px; height: 80px;"/>
        </header>
        <main>
          <section style="margin: 50px 10px; font-size: 14px; text-align: justify;">
            <p style="margin-bottom: 10px; line-height: 1.5;">Dear ' . $agent_details['first_name'] . ',</p>
    
            <p style="margin-bottom: 10px; text-align: justify;">
              You are recieving this mail to confirm the deposit of NGN ' . number_format($amount_paid, 2) . ' to wallet <b>' . $wallet_no . '</b> 
            </p>

          </section>
          <section style="margin: 50px 10px; font-size: 14px;">
            <p style=" font-size: 16px; margin-bottom: 10px;"><strong>User ordered for</strong></p>

            ' . $savings_products . '

          </section>
          <section style="margin: 50px 10px;">
            <div style="display: table; border-collapse: collapse; width: 100%; border: 1px solid #ff5c00;
            border-bottom: 5px solid #ff5c00; margin-bottom: 40px;">
              <div style="display: table-row; border-bottom: 1px solid #ff5c00;">
                <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Savings Type </span>
                <span style="display: table-cell;"></span>
                <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;">' . $savings_type . '</span>
              </div>
              <div style="display: table-row; border-bottom: 1px solid #ff5c00;">
                <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Duration </span>
                <span style="display: table-cell;"></span>
                <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;">' . $installment_duration . ' ' . $installment_type_plural . ' (NGN ' . number_format($installment_amount, 2) . '/' . $installment_type . ') </span>
              </div>
              <div style="display: table-row; border-bottom: 1px solid #ff5c00;">
                <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;">  Type of payment </span>
                <span style="display: table-cell;"></span>
                <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;">' . $installment_type_adjective . '</span>
              </div>
              <div style="display: table-row; border-bottom: 1px solid #ff5c00;">
                <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Amount to save </span>
                <span style="display: table-cell;"></span>
                <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;"> NGN ' . number_format($wallet_details['target_amount'], 2) . '</span>
              </div>
              <div style="display: table-row; border-bottom: 1px solid #ff5c00;">
                <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Agent </span>
                <span style="display: table-cell;"></span>
                <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;">' . $user_details['last_name'] . ' ' . $user_details['first_name'] . '</span>
              </div>
              <div style="display: table-row; border-bottom: 1px solid #ff5c00;">
                <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Agent Email </span>
                <span style="display: table-cell;"></span>
                <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;">' . $user_details['email'] .  '</span>
              </div>
              <div style="display: table-row; border-bottom: 1px solid #ff5c00;">
                <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Agent Phone </span>
                <span style="display: table-cell;"></span>
                <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;">' . $user_details['phone_no'] . '</span>
              </div>
            </div>
          </section>
        </main>
      </body>
    </html>
        ';

				// PREPARING AGENT AND USER SUBJECT
				$user_subject = "Your Halfcarry Savings Wallet - ($wallet_no) has been credited";
				$agent_subject = "You have a Deposit Alert";

				// send_custom_mail($user_details['email'], $user_subject, $user_message_html);
				// send_custom_mail($agent_details['email'], $agent_subject, $agent_message_html);
				
				unset($_SESSION['amount_to_pay']);
				unset($_SESSION['start_period']);
				unset($_SESSION['end_period']);
			}

			$_SESSION['payment_success'] = 1;

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
