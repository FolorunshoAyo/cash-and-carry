<?php
    require(dirname(dirname(dirname(dirname(__DIR__)))) . '/auth-library/resources.php');

    $agent_id = $_SESSION['agent_id'];

    if(isset($_POST['submit'])){
        $requestID = $db->real_escape_string($_POST['rid']);
        $status = $db->real_escape_string($_POST['status']);
        $userID = $db->real_escape_string($_POST['user_id']);
        $savingsType = $db->real_escape_string($_POST['type_of_savings']);


        if(empty($requestID) || empty($status) || empty($userID) || empty($savingsType)){
            echo json_encode(array('success' => 0, "error_message" => "All fields are required"));
        }else{

            if($status === "3"){
                // REQUEST CANCELLED 
                $sql_update_request = $db->query("UPDATE savings_request SET status = '3' WHERE id='$requestID'");

                if($sql_update_request){
                    echo json_encode(array('success' => 1));
                }

            }else{
                // EXTRACT products and quantities
                $sql_get_request_details =  $db->query("SELECT *, product_id(s) as products, quantity(ies) as quantities FROM savings_requests WHERE id = {$requestID}");

                $request_details = $sql_get_request_details->fetch_assoc();

                $seperated_comma_product_ids = $request_details['products'];
                $seperated_comma_quantities = $request_details['quantities'];

                
                $products_id_array = explode(",", $seperated_comma_product_ids);
                $quantities_array = explode(",", $seperated_comma_quantities);

                // [{"product_id", "quantity"}, {"product_id", "quantity"}];

                $combined_products_array = array();

                foreach($products_id_array as $keys => $values){
                    $products_id_array = array($values);
                    array_push($combined_products_array, $product_id_array);
                }

                foreach($products_id_array as $keys => $values){
                    $combined_products_array[$keys][1] = $values;
                }

                // GRANTED SAVINGS REQUEST
                if($savingsType === "1"){
                    // HALFSAVINGS REQUEST GRANTED
                    $sql_update_request = $db->query("UPDATE savings_request SET status = '2' WHERE id='$requestID'");

                    // CREATE NEW HALF SAVINGS WALLET
                    $sql_create_half_savings_wallet = $db->query("INSERT INTO store_wallet (user_id, agent_id, target_amount, type, duration) VALUES ({$userID}, {$agent_id}, {$request_details['amount']}, {$request_details['duration_of_savings']})");

                    //FETCH WALLET ID 
                    $created_wallet_id = $db->insert_id;

                    // POPULATE PRODUCTS AND THEIR QUANTITIES IN wallets_products lookup
                    foreach($combined_products_array as $saved_product_details){
                        $sql_insert_wallet_products_and_quantities = $db->query("INSERT INTO wallets_products(wallet_id, product_id, quantity) VALUES ({$created_wallet_id}, {$saved_product_details[0]}, {$savingsType}, {$saved_product_details[1]})");
                    }
                }

                if($savingsType === "2"){
                    // NORMAL SAVINGS REQUEST GRANTED
                    $sql_update_request = $db->query("UPDATE savings_request SET status = '2' WHERE id='$requestID'");

                    // CREATE NEW NORMAL SAVINGS WALLET
                    $sql_create_half_savings_wallet = $db->query("INSERT INTO store_wallet (user_id, agent_id, target_amount, type, duration) VALUES ({$userID}, {$agent_id}, {$request_details['amount']}, {$savingsType}, {$request_details['duration_of_savings']})");

                    //FETCH WALLET ID 
                    $created_wallet_id = $db->insert_id;

                    // POPULATE PRODUCTS AND THEIR QUANTITIES IN wallets_products lookup
                    foreach($combined_products_array as $saved_product_details){
                        $sql_insert_wallet_products_and_quantities = $db->query("INSERT INTO wallets_products(wallet_id, product_id, quantity) VALUES ({$created_wallet_id}, {$saved_product_details[0]}, {$saved_product_details[1]})");
                    }

                }
            }
        }
    }
