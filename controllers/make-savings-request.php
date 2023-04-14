<?php
require(dirname(__DIR__) . '/auth-library/resources.php');

function generateUniqueCode()
{
    global $db;

    $savings_id = rand(0000000000, 9999999999);

    $check_savings_request_code = $db->query("SELECT * FROM savings_requests WHERE savings_id = {$savings_id}");

    while ($check_savings_request_code->num_rows === 1) {
        $savings_id = rand(0000000000, 9999999999);
    }

    return $savings_id;
}

if (isset($_POST['submit'])) {
    $savings_type = $db->real_escape_string($_POST['type']);
    $agent_id = $db->real_escape_string($_POST['agent_id']);
    $user_id = $_SESSION['user_id'];

    if ($savings_type === "1") {
        // NORMAL SAVINGS
        $product_id = $db->real_escape_string($_POST['product_id']);
        $quantity = $db->real_escape_string($_POST['quantity']);
        $selected_plan = $db->real_escape_string($_POST['payment-plan']);

        $get_product_details = $db->query("SELECT * FROM products WHERE product_id = {$product_id}");

        $product_details = $get_product_details->fetch_assoc();

        $product_price = $product_details['price'];
        $product_savings_duration = $product_details['duration_of_payment'];

        $total_price_with_interest = (((20 / 100) * $product_price) + $product_price) * $quantity;

        $daysWeeksMonths = getDaysWeeks($product_savings_duration);

        $savings_id = generateUniqueCode();

        if ($selected_plan === "1") {
            // DAILY SAVINGS
            $installment_amount = $total_price_with_interest / $daysWeeksMonths['days'];

            // INSERT SAVINGS REQUEST
            $insert_savings_request = $db->query("INSERT INTO savings_requests (savings_id, user_id, agent_id, type_of_savings, installment_type, duration_of_savings, installment_amount, target_amount) VALUES({$savings_id}, {$user_id}, {$agent_id}, '1', '1', {$daysWeeksMonths['days']}, {$installment_amount}, {$total_price_with_interest})");
        } elseif ($selected_plan === "2") {
            // WEEKLY SAVINGS
            $installment_amount = $total_price_with_interest / $daysWeeksMonths['weeks'];

            // INSERT SAVINGS REQUEST
             // INSERT SAVINGS REQUEST
             $insert_savings_request = $db->query("INSERT INTO savings_requests (savings_id, user_id, agent_id, type_of_savings, installment_type, duration_of_savings, installment_amount, target_amount) VALUES({$savings_id}, {$user_id}, {$agent_id}, '1', '2', {$daysWeeksMonths['weeks']}, {$installment_amount}, {$total_price_with_interest})");
        } else {
            // MONTHLY SAVINGS
            $installment_amount = $total_price_with_interest / $daysWeeksMonths['months'];

            // INSERT SAVINGS REQUEST
             // INSERT SAVINGS REQUEST
             $insert_savings_request = $db->query("INSERT INTO savings_requests (savings_id, user_id, agent_id, type_of_savings, installment_type, duration_of_savings, installment_amount, target_amount) VALUES({$savings_id}, {$user_id}, {$agent_id}, '1', '3', {$daysWeeksMonths['months']}, {$installment_amount}, {$total_price_with_interest})");
        }

        // STORE SAVINGS PRODUCTS
        $db->query("INSERT INTO wallets_products (savings_id, product_id, quantity) VALUES ({$savings_id}, {$product_id}, {$quantity})");

        if($insert_savings_request){
            echo json_encode(array('success' => 1, 'savings_id' => $savings_id));
        }else{
            echo json_encode(array('success' => 0));
        }
    }
}
