<?php
require(dirname(__DIR__) . '/auth-library/resources.php');

function generateUniqueCode()
{
  $savings_random_id = rand(0000000000, 9999999999);

  function checkIfSavingsIdExists($savings_random_id)
  {
    global $db;
    $check_savings_request_code = $db->query("SELECT * FROM savings_requests WHERE savings_id = {$savings_random_id}");

    return $check_savings_request_code->num_rows === 1;
  }

  while (checkIfSavingsIdExists($savings_random_id)) {
    $savings_random_id = rand(0000000000, 9999999999);
  }

  return $savings_random_id;
}

if (isset($_POST['submit'])) {
  $savings_type = $db->real_escape_string($_POST['type']);
  $agent_id = $db->real_escape_string($_POST['agent_id']);
  $user_id = $_SESSION['user_id'];

  $get_user_details = $db->query("SELECT last_name, first_name, phone_no, email FROM users WHERE user_id = {$user_id}");
  $get_agent_details = $db->query("SELECT last_name, first_name, phone_no, email FROM agents WHERE agent_id = {$agent_id}");

  $user_details = $get_user_details->fetch_assoc();
  $agent_details = $get_agent_details->fetch_assoc();



  if ($savings_type === "1") {
    // NORMAL SAVINGS
    $product_id = $db->real_escape_string($_POST['product_id']);
    $quantity = $db->real_escape_string($_POST['quantity']);
    $selected_plan = $db->real_escape_string($_POST['payment-plan']);

    $get_product_details = $db->query("SELECT * FROM products WHERE product_id = {$product_id}");

    $product_details = $get_product_details->fetch_assoc();

    if($product_details['in_stock'] < $quantity){
      echo json_encode(array('success' => 0, 'error_msg' => "Item only has " . $product_details['in_stock'] . "in stock"));
      exit();
    }

    $product_image = explode(",", $product_details['pictures'])[0];
    $product_price = $product_details['price'];
    $product_savings_duration = $product_details['duration_of_payment'];

    $total_price_with_interest = (((20 / 100) * $product_price) + $product_price) * $quantity;
    $normal_price = $product_details['price'] * $quantity;

    $daysWeeksMonths = getDaysWeeks($product_savings_duration);

    $savings_id = generateUniqueCode();

    if ($selected_plan === "1") {
      $installment_type = "day";
      $installment_duration = $daysWeeksMonths['days'];
      // DAILY SAVINGS
      $installment_amount = $total_price_with_interest / $daysWeeksMonths['days'];

      // INSERT SAVINGS REQUEST
      $insert_savings_request = $db->query("INSERT INTO savings_requests (savings_id, user_id, agent_id, type_of_savings, installment_type, duration_of_savings, installment_amount, target_amount) VALUES({$savings_id}, {$user_id}, {$agent_id}, '1', '1', {$installment_duration}, {$installment_amount}, {$total_price_with_interest})");
    } elseif ($selected_plan === "2") {
      $installment_type = "week";
      $installment_duration = $daysWeeksMonths['weeks'];
      // WEEKLY SAVINGS
      $installment_amount = $total_price_with_interest / $daysWeeksMonths['weeks'];

      // INSERT SAVINGS REQUEST
      $insert_savings_request = $db->query("INSERT INTO savings_requests (savings_id, user_id, agent_id, type_of_savings, installment_type, duration_of_savings, installment_amount, target_amount) VALUES({$savings_id}, {$user_id}, {$agent_id}, '1', '2', {$installment_duration}, {$installment_amount}, {$total_price_with_interest})");
    } else {
      $installment_type = "month";
      $installment_duration = $daysWeeksMonths['months'];
      // MONTHLY SAVINGS
      $installment_amount = $total_price_with_interest / $daysWeeksMonths['months'];

      // INSERT SAVINGS REQUEST
      $insert_savings_request = $db->query("INSERT INTO savings_requests (savings_id, user_id, agent_id, type_of_savings, installment_type, duration_of_savings, installment_amount, target_amount) VALUES({$savings_id}, {$user_id}, {$agent_id}, '1', '3', {$installment_duration}, {$installment_amount}, {$total_price_with_interest})");
    }

    // STORE SAVINGS PRODUCTS
    $db->query("INSERT INTO savings_products (savings_id, product_id, quantity) VALUES ({$savings_id}, {$product_id}, {$quantity})");

    $type_of_savings = $savings_type === "1"? "Normal Savings" : "Half Savings";
    $installment_type_plural = $installment_type === "day" ? 'Days' : ($installment_type === "week" ? 'Weeks' : 'Months');
    $installment_type_adjective = ($installment_type === "day" ? 'Daily' : ($installment_type === "week" ? 'Weekly' : 'Monthly'));

    $savings_product = '<div style="border: 1px solid #ff5c00;
            border-bottom: 5px solid #ff5c00; margin-bottom: 40px;">
              <div style="height: 80px;
              text-align: center;
              border-bottom: 1px solid #ff5c00;" >
                <img src="' . $url . "a/admin/images/" . $product_image . '" style=" height: 100%;
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
                  <span style="display: table-cell;  padding: 10px; font-size: 15px; text-align: right;">' . $quantity . '</span>
                </p>
                <p style="display: table-row; border-bottom: 1px solid #ff5c00;">
                  <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Price </span>
                  <span style="display: table-cell;  padding: 10px;"></span>
                  <span style="display: table-cell;  padding: 10px; font-size: 15px; text-align: right;">₦ ' . number_format($normal_price, 2) . '</span>
                </p>
              </div>
            </div>';

    $user_message_html = '
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
          <section style="margin: 50px 10px; font-size: 14px;">
            <p style="margin-bottom: 10px; line-height: 1.5;">Dear ' . $user_details['first_name'] . ',</p>
    
            <p style="margin-bottom: 10px; line-height: 1.5; text-align: justify;">
              Thank You for choosing <b>HalfCarry</b> as your preferred choice for
              shopping quality products.
            </p>
            <p style="margin-bottom: 10px; line-height: 1.5; text-align: justify;">
              Your savings request - <b>' . $savings_id . '</b> has been
              processed.
            </p>
          </section>
          <section style="margin: 50px 10px; font-size: 14px;">
            <p style=" font-size: 16px; margin-bottom: 10px;"><strong>You ordered for</strong></p>

            ' . $savings_product . '
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
                <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;"> NGN ' . number_format($total_price_with_interest, 2) . '</span>
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
              A savings request <b>' . $savings_id . '</b> has been
              placed.
            </p>

            <p style="margin-bottom: 10px; text-align: justify;">
             Please respond to the request by <a href="https://halfcarry.com.ng/a/login" style="color: #ff5c00">logging</a> into your dashboard
            </p>
          </section>
          <section style="margin: 50px 10px; font-size: 14px;">
            <p style=" font-size: 16px; margin-bottom: 10px;"><strong>User ordered for</strong></p>

            ' . $savings_product . '

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
                <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;"> NGN ' . number_format($total_price_with_interest, 2) . '</span>
              </div>
              <div style="display: table-row; border-bottom: 1px solid #ff5c00;">
                <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> User </span>
                <span style="display: table-cell;"></span>
                <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;">' . $user_details['last_name'] . ' ' . $user_details['first_name'] . '</span>
              </div>
              <div style="display: table-row; border-bottom: 1px solid #ff5c00;">
                <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> User Email </span>
                <span style="display: table-cell;"></span>
                <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;">' . $user_details['email'] .  '</span>
              </div>
              <div style="display: table-row; border-bottom: 1px solid #ff5c00;">
                <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> User Phone </span>
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
    $user_subject = "Your Halfcarry Savings Request - ($savings_id) has been placed";
    $agent_subject = "Hello! Agent. " . $agent_details['first_name'] . ", You have a new Savings Request - $savings_id";

    // DELIVER MAILS TO BOTH CHOSEN WALLET AND USER VIA PHP MAILER
    // send_custom_mail($user_details['email'], $user_subject, $user_message_html);
    // send_custom_mail($agent_details['email'], $agent_subject, $agent_message_html);

    if ($insert_savings_request) {
      echo json_encode(array('success' => 1, 'savings_id' => $savings_id));
    } else {
      echo json_encode(array('success' => 0, 'error_msg' => "Unable to place savings request. Please try again."));
    }
  } else {
    // HALF SAVINGS
    $selected_plan = $db->real_escape_string($_POST['payment-plan']);

    //GATHER PRODUCT SAVINGS DURATION AND PRICES
    $productMonths = array();
    $productPrices = array();

    // GATHER PRODUCT NAME AND IN STOCK
    $products_stock_error_details = array();

    foreach ($_SESSION['shopping_cart'] as $key => $values) {
      $product_id = $values['product_id'];

      $sql_get_product_savings_duration = $db->query("SELECT price,duration_of_payment,name,in_stock FROM products WHERE product_id = {$product_id}");

      // SAVINGS DURATION OF EACH PRODUCT
      $product_details = $sql_get_product_savings_duration->fetch_assoc();
      $product_savings_duration = intval($product_details['duration_of_payment']);
      $product_price = $product_details['price'];

      array_push($productMonths, $product_savings_duration);
      array_push($productPrices, ($product_price * $values['product_quantity']));

      if($product_details['in_stock'] < $values['product_quantity']){
        // STOCK ERROR
        array_push($products_stock_error_details, array('product_name' => $values['product_name'], 'product_stock' => $product_details['in_stock']));
      }
    }

    // CHECK FOR STOCK ERROR

    if(count($products_stock_error_details) > 0){
      $error_message = "Unable to make request. ";

      foreach($products_stock_error_details as $key => $values){
        if(($key + 1) === count($products_stock_error_details)){
          $error_message .= $values['product_name'];
        }else{
          $error_message .= $values['product_name'] . ", ";
        }
      }

      $error_message .= " has only ";

      foreach($products_stock_error_details as $key => $values){
        if(($key + 1) === count($products_stock_error_details)){
          $error_message .= $values['product_stock'];
        }else{
          $error_message .= $values['product_stock'] . ", ";
        }
      }

      $error_message .= " in stock";

      echo json_encode(array('success' => 0, 'error_msg' => $error_message));
      exit();
    }

    // DETERMINING MAXIMUM SAVINGS PERIOD AND TOTAL PRODUCT PRICES PLUS INTTEREST
    $max_month = max($productMonths);
    $total_price = 0;

    foreach ($productPrices as $price) {
      $total_price += $price;
    }

    // CALCUALTING INTEREST
    $total_price_with_interest = (20 / 100) * $total_price + $total_price;

    $daysWeeksMonths = getDaysWeeks($max_month);

    $savings_id = generateUniqueCode();

    if ($selected_plan === "1") {
      $installment_type = "day";
      // DAILY SAVINGS
      $installment_amount = $total_price_with_interest / $daysWeeksMonths['days'];

      $installment_duration = $daysWeeksMonths['days'];
      // INSERT SAVINGS REQUEST
      $insert_savings_request = $db->query("INSERT INTO savings_requests (savings_id, user_id, agent_id, type_of_savings, installment_type, duration_of_savings, installment_amount, target_amount) VALUES({$savings_id}, {$user_id}, {$agent_id}, '2', '1', {$installment_duration}, {$installment_amount}, {$total_price_with_interest})");
    } elseif ($selected_plan === "2") {
      $installment_type = "week";
      // WEEKLY SAVINGS
      $installment_amount = $total_price_with_interest / $daysWeeksMonths['weeks'];
      $installment_duration = $daysWeeksMonths['weeks'];

      // INSERT SAVINGS REQUEST
      $insert_savings_request = $db->query("INSERT INTO savings_requests (savings_id, user_id, agent_id, type_of_savings, installment_type, duration_of_savings, installment_amount, target_amount) VALUES({$savings_id}, {$user_id}, {$agent_id}, '2', '2', {$installment_duration}, {$installment_amount}, {$total_price_with_interest})");
    } else {
      $installment_type = "month";
      // MONTHLY SAVINGS
      $installment_amount = $total_price_with_interest / $daysWeeksMonths['months'];
      $installment_duration = $daysWeeksMonths['months'];

      // INSERT SAVINGS REQUEST
      $insert_savings_request = $db->query("INSERT INTO savings_requests (savings_id, user_id, agent_id, type_of_savings, installment_type, duration_of_savings, installment_amount, target_amount) VALUES({$savings_id}, {$user_id}, {$agent_id}, '2', '3', {$daysWeeksMonths['months']}, {$installment_duration}, {$total_price_with_interest})");
    }

    $type_of_savings = $savings_type === "1"? "Normal Savings" : "Half Savings";
    $installment_type_plural = $installment_type === "day" ? 'Days' : ($installment_type === "week" ? 'Weeks' : 'Months');
    $installment_type_adjective = ($installment_type === "day" ? 'Daily' : ($installment_type === "week" ? 'Weekly' : 'Monthly'));

    foreach ($_SESSION['shopping_cart'] as $key => $values) {
      // STORE SAVINGS PRODUCTS
      $db->query("INSERT INTO savings_products (savings_id, product_id, quantity) VALUES ({$savings_id}, {$values['product_id']}, {$values['product_quantity']})");

      // CONSTRUCT SAVINGS PRODUCTS FOR EMAIL

      $savings_product = "";

      $price_plus_interest = ((20 / 100) * $values['product_price']) + $values['product_price'];

      $savings_product .= '<div style="border: 1px solid #ff5c00;
            border-bottom: 5px solid #ff5c00; margin-bottom: 40px;">
              <div style="height: 80px;
              text-align: center;
              border-bottom: 1px solid #ff5c00;" >
                <img src="' . $values['product_image'] .  '" style=" height: 100%;
                width: 80px;" />
              </div>
              <div style="display: table; border-collapse: collapse; width: 100%;">
                <p style="display: table-row; border-bottom: 1px solid #ff5c00;">
                  <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Item </span>
                  <span style="display: table-cell;"></span>
                  <span style="display: table-cell;  padding: 10px; font-size: 15px; text-align: right; width: 100%;" >' . $values['product_name'] . '</span>
                </p>
                <p style="display: table-row; border-bottom: 1px solid #ff5c00;">
                  <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Quantity </span>
                  <span style="display: table-cell;  padding: 10px;"></span>
                  <span style="display: table-cell;  padding: 10px; font-size: 15px; text-align: right;">' . $values['product_quantity'] . '</span>
                </p>
                <p style="display: table-row; border-bottom: 1px solid #ff5c00;">
                  <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Price </span>
                  <span style="display: table-cell;  padding: 10px;"></span>
                  <span style="display: table-cell;  padding: 10px; font-size: 15px; text-align: right;">₦ ' . number_format($price_plus_interest, 2) . '</span>
                </p>
              </div>
            </div>';
    }

    $user_message_html = '
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
          <section style="margin: 50px 10px; font-size: 14px;">
            <p style="margin-bottom: 10px; line-height: 1.5;">Dear ' . $user_details['first_name'] . ',</p>
    
            <p style="margin-bottom: 10px; line-height: 1.5; text-align: justify;">
              Thank You for choosing <b>HalfCarry</b> as your preferred choice for
              shopping quality products.
            </p>
            <p style="margin-bottom: 10px; line-height: 1.5; text-align: justify;">
              Your savings request - <b>' . $savings_id . '</b> has been
              processed.
            </p>
          </section>
          <section style="margin: 50px 10px; font-size: 14px;">
            <p style=" font-size: 16px; margin-bottom: 10px;"><strong>You ordered for</strong></p>

            ' . $savings_product . '
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
                <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;"> NGN ' . number_format($total_price_with_interest, 2) . '</span>
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
              A savings request <b>' . $savings_id . '</b> has been
              placed.
            </p>

            <p style="margin-bottom: 10px; text-align: justify;">
             Please respond to the request by <a href="https://halfcarry/a/login" style="color: #ff5c00">logging</a> into your dashboard
            </p>
          </section>
          <section style="margin: 50px 10px; font-size: 14px;">
            <p style=" font-size: 16px; margin-bottom: 10px;"><strong>User ordered for</strong></p>

            ' . $savings_product . '

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
                <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;"> NGN ' . number_format($total_price_with_interest, 2) . '</span>
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
    $user_subject = "Your Halfcarry Savings Request - ($savings_id) has been placed";
    $agent_subject = "Hello! Agent. " . $agent_details['first_name'] . ", You have a new Savings Request - $savings_id";

    // DELIVER MAILS TO BOTH CHOSEN WALLET AND USER VIA PHP MAILER
    // send_custom_mail($user_details['email'], $user_subject, $user_message_html);
    // send_custom_mail($agent_details['email'], $agent_subject, $agent_message_html);

    if ($insert_savings_request) {
      echo json_encode(array('success' => 1, 'savings_id' => $savings_id));
    } else {
      echo json_encode(array('success' => 0, 'error_msg' => "Unable to place savings request. Please try again."));
    }
  }
}
