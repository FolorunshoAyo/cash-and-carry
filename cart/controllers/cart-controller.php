<?php

//action.php

session_start();

if (isset($_POST["action"])) {
    if ($_POST["action"] == 'remove') {
        foreach ($_SESSION["shopping_cart"] as $keys => $values) {
            if ($values["product_id"] == $_POST["product_id"]) {
                unset($_SESSION["shopping_cart"][$keys]);
            }
        }
    }
    
    if($_POST['action'] == 'update'){
        foreach($_POST['product_details'] as $client_keys => $client_values){
            foreach($_SESSION['shopping_cart'] as $keys => $values){
                if ($client_values["product_id"] == $values['product_id']) {
                    $_SESSION["shopping_cart"][$keys]['product_quantity'] = $client_values['product_quantity'];
                }
            }
        }
    }

    if ($_POST["action"] == 'empty') {
        unset($_SESSION["shopping_cart"]);
    }
}

?>