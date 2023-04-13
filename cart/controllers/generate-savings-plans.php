<?php
require(dirname(dirname(__DIR__)) . '/auth-library/resources.php');

$url = strval($url);

if (isset($_POST['submit'])) {
    $products = "";
    $savingsPrices = array();

    if (isset($_SESSION['shopping_cart']) && !empty($_SESSION['shopping_cart'])) {
        // IF CART EXISTS

        //GATHER PRODUCT SAVINGS DURATION AND PRICES
        $productMonths = array();
        $productPrices = array();

        if (count($_SESSION['shopping_cart']) > 1) {
            $products .= '<div class="controls-container">
                                <button data-direction="prev" disabled><i class="fa fa-arrow-left"></i></button>
                                <button data-direction="next"><i class="fa fa-arrow-right"></i></button>
                            </div><div class="products-container">';
        }

        // LOOPING THROUGH EACH PRODUCT
        foreach ($_SESSION['shopping_cart'] as $key => $values) {
            $product_id = $values['product_id'];

            $sql_get_product_savings_duration = $db->query("SELECT price,duration_of_payment FROM products WHERE product_id = {$product_id}");

            // SAVINGS DURATION OF EACH PRODUCT
             $product_details = $sql_get_product_savings_duration->fetch_assoc();
             $product_savings_duration = intval($product_details['duration_of_payment']);
             $product_price = $product_details['price'];

            array_push($productMonths, $product_savings_duration);
            array_push($productPrices, ($product_price * $values['product_quantity']));

            if ($key == 0) {
                $products .= '<div class="savings-product active">
                <div class="savings-product-image-container">
                    <img src="' . $values['product_image'] . '" alt="' . $values['product_name'] . '">
                </div>
                <div class="savings-product-details">
                    <span class="savings-product-name">' . $values['product_name'] . '</span>
                    <span class="savings-product-qty">Qty: ' . $values['product_quantity'] . '</span>
                </div>
            </div>';
            } else {
                $products .= '<div class="savings-product">
                <div class="savings-product-image-container">
                    <img src="' . $values['product_image'] . '" alt="' . $values['product_name'] . '">
                </div>
                <div class="savings-product-details">
                    <span class="savings-product-name">' . $values['product_name'] . '</span>
                    <span class="savings-product-qty">Qty: ' . $values['product_quantity'] . '</span>
                </div>
            </div>';
            }
        }

        // DETERMINING MAXIMUM SAVINGS PERIOD AND TOTAL PRODUCT PRICES PLUS INTTEREST
        $max_month = max($productMonths);
        $total_price = 0;

        foreach ($productPrices as $price) {
            $total_price += $price;
        }

        // CALCUALTING INTEREST
        $final_price = (20 / 100) * $total_price + $total_price;

        $daysWeeksMonths = getDaysWeeks($max_month);

        $agent_html = "";

        $sql_get_all_agents = $db->query("SELECT * FROM agents");

        while ($agent_details = $sql_get_all_agents->fetch_assoc()) {
            $agent_html .= "<option value=" . $agent_details['agent_id'] . ">" . $agent_details['last_name'] . " " . $agent_details['first_name'] . "</option>";
        }

        $savingsPrices[0] = number_format(($final_price / $daysWeeksMonths['days']), 2);
        $savingsPrices[1] = number_format(($final_price / $daysWeeksMonths['weeks']), 2);
        $savingsPrices[2] = number_format(($final_price / $daysWeeksMonths['months']), 2);
    }

    echo  json_encode(array('products' => $products, 'savings_prices' => $savingsPrices, 'total_amount' => number_format($final_price)));
}
