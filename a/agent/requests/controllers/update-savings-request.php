<?php
require(dirname(dirname(dirname(dirname(__DIR__)))) . '/auth-library/resources.php');

$agent_id = $_SESSION['agent_id'];

if (isset($_POST['submit'])) {
  $request_id = $db->real_escape_string($_POST['rid']);
  $status = $db->real_escape_string($_POST['status']);
  $user_id = $db->real_escape_string($_POST['user_id']);
  $savings_type = $db->real_escape_string($_POST['type_of_savings']);

  $get_savings_request_details = $db->query("SELECT * FROM savings_requests WHERE id = {$request_id}");
  $get_user_details = $db->query("SELECT * FROM users WHERE user_id = {$user_id}");

  $request_details = $get_savings_request_details->fetch_assoc();
  $savings_id = $request_details['savings_id'];
  $get_savings_products = $db->query("SELECT * FROM savings_products WHERE savings_id = {$savings_id}");

  $user_details = $get_user_details->fetch_assoc();

  $get_agent_details = $db->query("SELECT * FROM agents WHERE agent_id = {$agent_id}");

  $agent_details = $get_agent_details->fetch_assoc();

  $savings_type = $request_details['type_of_savings'];
  $installment_type = $request_details['installment_type'];

  $type_of_savings = $savings_type === "1"? "Normal Savings" : "Half Savings";
  $installment_type_plural = $installment_type === "1" ? 'Days' : ($installment_type === "2" ? 'Weeks' : 'Months');
  $installment_type_adjective = ($installment_type === "1" ? 'Daily' : ($installment_type === "2" ? 'Weekly' : 'Monthly'));

  // GRANTED SAVINGS PROCESS
  if ($status === "2") {
    $mail_info = '
            <p style="margin-bottom: 10px; line-height: 1.5; text-align: justify;">
            Your savings request - <b>' . $savings_id . '</b> has been
            granted.
            </p>
            ';

    $sql_new_wallet = $db->query("INSERT INTO store_wallets (wallet_no, user_id, agent_id) VALUES ({$savings_id}, {$user_id}, {$agent_id})");
  }

  if ($status === "3") {
    $mail_info = '
            <p style="margin-bottom: 10px; line-height: 1.5; text-align: justify;">
            Your savings request - <b>' . $savings_id . '</b> was rejected.
            </p>

            <p style="margin-bottom: 10px; line-height: 1.5; text-align: justify;">
            This could have happened because:
            </p>

            <ul>
            <li>You did not come to an agreement with your chosen agent</li>
            <li>You mistakenly placed this request</li>
            </ul>
            ';
  }

  $sql_update_savings_request = $db->query("UPDATE savings_requests SET status = {$status} WHERE id = {$request_id}");

  $savings_product_html = "";

  while ($saving_product = $get_savings_products->fetch_assoc()) {
    $get_product_details = $db->query("SELECT * FROM products WHERE product_id = {$saving_product['product_id']}");

    $product_details = $get_product_details->fetch_assoc();

    $picture = explode(",", $product_details['pictures'])[0];

    $price_plus_interest = ((20 / 100) * $product_details['price']) + $product_details['price'];

    $savings_product_html .= 'div style="border: 1px solid #ff5c00;
            border-bottom: 5px solid #ff5c00; margin-bottom: 40px;">
              <div style="height: 80px;
              text-align: center;
              border-bottom: 1px solid #ff5c00;" >
                <img src="https://halfcarry/a/admin/images' . $picture .  '" style=" height: 100%;
                width: 80px;" />
              </div>
              <div style="display: table; border-collapse: collapse; width: 100%;">
                <p style="display: table-row; border-bottom: 1px solid #ff5c00;">
                  <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Item </span>
                  <span style="display: table-cell;"></span>
                  <span style="display: table-cell;  padding: 10px; font-size: 15px; text-align: right; width: 100%;" >' . $product_details['name'] . '</span>
                </p>
                <p style="display: table-row; border-bottom: 1px solid #ff5c00;">
                  <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Quantity </span>
                  <span style="display: table-cell;  padding: 10px;"></span>
                  <span style="display: table-cell;  padding: 10px; font-size: 15px; text-align: right;">' . $saving_product['quantity'] . '</span>
                </p>
                <p style="display: table-row; border-bottom: 1px solid #ff5c00;">
                  <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Price </span>
                  <span style="display: table-cell;  padding: 10px;"></span>
                  <span style="display: table-cell;  padding: 10px; font-size: 15px; text-align: right;">₦ ' . number_format($price_plus_interest, 2) . '</span>
                </p>
              </div>
            </div>';
  }

  $user_message = '<!DOCTYPE html>
        <html>
          <head>
            <link rel="stylesheet" href="../assets/fonts/fonts.css" />
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

                '. $mail_info .'
              </section>
              <section style="margin: 50px 10px; font-size: 14px;">
                <p style=" font-size: 16px; margin-bottom: 10px;"><strong>You ordered for</strong></p>
    
                ' . $savings_product_html . '
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
                    <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;">' . $request_details['duration_of_savings'] . $installment_type_plural  . ' (NGN ' . number_format($installment_amount, 2) . "/" . $installment_type . ') </span>
                  </div>
                  <div style="display: table-row; border-bottom: 1px solid #ff5c00;">
                    <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;">  Type of payment </span>
                    <span style="display: table-cell;"></span>
                    <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;">' . $installment_type_adjective . '</span>
                  </div>
                  <div style="display: table-row; border-bottom: 1px solid #ff5c00;">
                    <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Amount to save </span>
                    <span style="display: table-cell;"></span>
                    <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;"> NGN ' . number_format($request_details['target_amount'], 2) . '</span>
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

    send_custom_mail($user_details['email'], "Your Halfcarry Savings Request - ($savings_id) has been " . (($status === "2")? "granted" : "rejected"), $user_message);

  if ($sql_update_savings_request) {
    echo json_encode(array('success' => 1));
  } else {
    echo json_encode(array('success' => 0, 'error_title' => "Update Request Error", 'error_message' => "There was an error updating the request"));
  }
}
