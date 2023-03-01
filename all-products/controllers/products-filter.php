<?php
require(dirname(dirname(__DIR__)) . '/auth-library/resources.php');

if ($_POST['submit']) {
    if ((isset($_POST['page_no']) || $_POST['page_no'] != "")) {
        $page_no = $_POST['page_no'];
    } else {
        $page_no = $_POST['page_no'];
    }

    $category = $_POST['category'];
    $category_sql = (isset($category) && $category != "") ? "WHERE category = $category" : "";

    $price_sort = $_POST['price_range'];
    $price_sort_sql = (isset($price_sort) && $price_sort != "") ? "ORDER BY price $price_sort" : "";

    $order_sort = $_POST['order'];
    $order_sort_sql = (isset($order_sort) && $order_sort != "") ? "ORDER BY product_id $order_sort" : "";

    $total_records_per_page = $_POST['page_size'];

    $offset = (($page_no - 1) * $total_records_per_page) == "0" ? "" : ", " . ($page_no - 1) * $total_records_per_page;

    $products_filter_sql = $db->query("SELECT * FROM products $category_sql $price_sort_sql $order_sort_sql LIMIT $total_records_per_page $offset");
    $result_count = $db->query("SELECT COUNT(*) as total_records FROM products $category_sql $price_sort_sql $order_sort_sql");

    // echo "SELECT * FROM products $category_sql $price_sort_sql $order_sort_sql LIMIT $total_records_per_page $offset";

    $total_records = $result_count->fetch_assoc()['total_records'];

    $total_no_of_pages = ceil($total_records / $total_records_per_page);
    $productHTML = "";

    while ($product_details = $products_filter_sql->fetch_assoc()) {
        $interest_amount = (30 / 100) * $product_details['price'];

        $installment_price = $product_details['price'] + $interest_amount;

        $calculatedPeriods = getDaysWeeks($product_details['duration_of_payment']);

        $calculatedDays = $calculatedPeriods['days'];
        $calculatedWeeks = $calculatedPeriods['weeks'];
        $calculatedMonths = $calculatedPeriods['months'];

        $product_image_src = explode(",", $product_details['pictures'])[0];

        $productHTML .= "<div class='product-card'>
            <a href='../product/?pid=" . $product_details['product_id'] . "'>
            <figure>
                <img src='../a/admin/images/" . $product_image_src . "'>
                <figcaption>
                    <div class='payment-plans'>
                        <span class='product-badge daily'>₦" . number_format(($installment_price / $calculatedDays), 2) . "/day</span>
                        <span class='product-badge weekly'>₦" . number_format(($installment_price / $calculatedWeeks), 2) . "/week</span>
                        <span class='product-badge month'>₦" . number_format(($installment_price / $calculatedMonths), 2) . "/month</span>
                    </div>
                    <span class='product-desc product-category-name'>" . $product_details['name'] . "</span>
                    <span class='product-desc product-category-price'>
                        ₦ " . number_format($product_details['price'], 2) . "
                    </span>
                </figcaption>
            </figure>
        </a>
        </div>";
    }

    echo json_encode(array('success' => 1, 'curr_page' => $page_no, 'total_page' => $total_no_of_pages, 'total_size' => $total_records, 'data' => $productHTML));
}
