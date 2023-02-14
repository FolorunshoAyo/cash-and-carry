<?php
    require(dirname(__DIR__) . '/auth-library/resources.php');

    if(isset($_POST['submit'])){
        $pid = $db->real_escape_string($_POST['pid']);
        $pname = $db->real_escape_string($_POST['pname']);
        $qty = $db->real_escape_string($_POST['qty']);
        $price = $db->real_escape_string($_POST['price']);
        $image = $db->real_escape_string($_POST['image']);
        
        if(empty($pid) || empty($pname) || empty($qty) || empty($price) || empty($image)){
            echo json_encode(array('success' => 0, 'error_title' => "Purchase Error", 'error_msg' => "One or more field(s) were not provided"));
            exit();
        }else{
            // STORE PRODUCT DETAILS IN SESSION
            $_SESSION['ordered_product_info'] = array('pid' => $pid, 'name' => $pname, 'quantity' => $qty, 'price' => $price, 'image' => $image);
            
            echo json_encode(array('success' => 1));
            exit();
        }
    }else{
        echo json_encode(array('success' => 0, 'error_title' => "Purchase Error", 'error_msg' => "Unable to process order."));
        exit();
    }
?>