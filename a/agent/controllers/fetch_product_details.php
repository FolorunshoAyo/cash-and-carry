<?php
    require(dirname(dirname(dirname(__DIR__))) . '/auth-library/resources.php');
     
    if(isset($_POST['submit'])){
        $pid = $db->real_escape_string($_POST['productId']);

        if(empty($pid)){
            echo json_encode(array('success' => 0, 'error_title' => "Edit Customer", 'error_msg' => 'One or more fields are empty'));
        }else{
            $sql_get_product = $db->query("SELECT * FROM products WHERE product_id='$pid'");
            $sql_get_meta_details = $db->query("SELECT * FROM product_meta WHERE product_id='$pid'");

            $product_details = $sql_get_product->fetch_assoc();
            $product_meta_details = $sql_get_meta_details->fetch_assoc();
            
            if($sql_get_product && $sql_get_meta_details){
                echo json_encode(array('success' => 1, 'name' => $product_details['name'], 'pid' => $product_details['product_id'], 'image' => explode(",", $product_details['pictures'])[0], 'pid' => $product_details['product_id'], 'price' => intval($product_details['price']), 'duration_in_months' => $product_meta_details['duration_in_months'], 'daily_payment' => $product_meta_details['daily_payment'], 'product_status' => $product_details['active'] === "0"? 0 : 1 ));
            }
        }
    }else{
        echo json_encode(array('success' => 0, 'error_title' => 'Fatal', 'error_msg' => 'Unable to fetch product details'));
    }
?>