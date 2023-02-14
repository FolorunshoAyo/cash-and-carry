<?php
    require(dirname(__DIR__) . '/auth-library/resources.php');

    if(isset($_POST['submit'])){
        $pid = $db->real_escape_string($_POST['pid']);
        $uid = $db->real_escape_string($_POST['uid']);
        $total = $db->real_escape_string($_POST['total']);
        $amount = $db->real_escape_string($_POST['amount']);
        $order_no = rand(1000000000, 9999999999);
        
        if(empty($pid) || empty($uid) || empty($total) || empty($amount)){
            echo json_encode(array('success' => 0, 'error_title' => "Order Error", 'error_message' => "One or more field(s) were not provided"));
            exit();
        }else{
            // GET DEFAULT ADDRESS
            $sql_address = $db->query("SELECT * FROM user_addresses WHERE user_id={$uid} AND active=1");
            $address_id = $sql_address->fetch_assoc()['address_id'];

            $sql_address_details = $db->query("SELECT * FROM addresses WHERE address_id={$address_id}");

            $default_address_details = $sql_address_details->fetch_assoc();

            $shipping_address = $default_address_details['recipient_name'] . "%" . $default_address_details['delivery_address'] . ", " . $default_address_details['city_name'] . ". " . $default_address_details['address_state'] . "." .  " (" . $default_address_details['address_postalcode'] . ") " . $default_address_details['recipient_phone_no'];

            if($default_address_details['additional_info']){
                $shipping_address .= "<br>" . $default_address_details['additional_info']; 
            }

            // INSERT ORDER INTO DATABASE
            $sql_insert_order = $db->query("INSERT INTO orders (order_no, user_id, product_id, amount, purch_amt, shipping_address) VALUES ('$order_no', '$uid', '$pid', '$amount', '$total', '$shipping_address')");
            if($sql_insert_order){
                $_SESSION['order_no'] = $order_no;
                echo json_encode(array('success' => 1));
                exit();
            }else{
                echo json_encode(array('success' => 0, 'error_title' => "Order Error", 'error_message' => "Unable to process order."));
            }
        }
    }else{
        echo json_encode(array('success' => 0, 'error_title' => "Order Error", 'error_message' => "Unable to process order."));
        exit();
    }
?>