<?php
require(dirname(dirname(__DIR__)) . '/auth-library/resources.php');
AdminAuth::User("a/");

if (isset($_GET['oid']) && !empty($_GET['oid'])) {
    $oid = $_GET['oid'];
    $products = array();

    $get_order_details = $db->query("SELECT * FROM orders INNER JOIN users ON orders.user_id = users.user_id WHERE order_no = {$oid} ");

    $get_products = $db->query("SELECT orders_products.*, products.pictures as product_pictures, products.name as product_name, products.price as product_price FROM orders_products INNER JOIN products ON orders_products.product_id = products.product_id WHERE order_no={$oid}");

    while ($product = $get_products->fetch_assoc()) {
        $product_picture = explode(",", $product['product_pictures'])[0];
        $product_object = array("product_name" => $product['product_name'], "product_picture" => $product_picture, "product_quantity" => $product['quantity'], "product_price" => $product['product_price']);

        array_push($products, $product_object);
    }

    $order_details  = $get_order_details->fetch_assoc();

    $get_ordered_products_quantity = $db->query("SELECT COUNT(quantity) as no_of_items FROM orders_products WHERE order_no = {$oid}");

    $no_of_items_ordered = $get_ordered_products_quantity->fetch_assoc()['no_of_items'];
} else {
    header("Location: ./orders");
}

function showStatus($status)
{
    $html = "";
    switch ($status) {
        case "1":
            $html = "<span class='product-status pending'>pending</span>";
            break;
        case "2":
            $html = "<span class='product-status awaiting-shipment'>awaiting shipment</span>";
            break;
        case "3":
            $html = "<span class='product-status shipped'>shipped</span>";
            break;
        case "4":
            $html = "<span class='product-status completed'>completed</span>";
            break;
        case "5":
            $html = "<span class='product-status cancelled'>cancelled</span>";
            break;
        default:
            $html = "Unable to detect status";
            break;
    }

    return $html;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Custom Fonts (Inter) -->
    <link rel="stylesheet" href="../../assets/fonts/fonts.css" />
    <!-- BASE CSS -->
    <link rel="stylesheet" href="../../assets/css/base.css" />
    <!-- ADMIN DASHBOARD MENU CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash-menu.css" />
    <!-- OORDER DETAILS CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash/order-details.css">
    <!-- DASHHBOARD MEDIA QUERIES -->
    <link rel="stylesheet" href="../../assets/css/media-queries/admin-dash-mediaqueries.css" />
    <title>Order Details (#<?= $order_details['order_no'] ?>) - Halfcarry</title>
</head>

<body style="background-color: #fafafa">
    <div class="dash-wrapper">
        <?php
        include("includes/admin-sidebar.php");
        ?>
        <section class="page-wrapper">
            <header class="dash-header">
                <a href="./orders" class="back-link">
                    <i class="fa fa-arrow-left"></i>
                </a>
            </header>
            <div class="order-details-wrapper">
                <h2 class="order-title"><?php echo ucfirst($order_details['last_name']) . " " . ucfirst($order_details['first_name']) ?>'s Order Details</h2>

                <div class="order-details-container">
                    <div class="order-meta">
                        <h2 class="order-no">Order n<sup>o</sup> <?php echo $order_details['order_no'] ?> </h2>
                        <div class="order-product-details">
                            <span class="product-quantity"><?= $no_of_items_ordered ?> item(s)</span>
                            <span class="order-date">Placed on <?php echo explode(" ", $order_details['ordered_at'])[0] ?> </span>
                            <span class="product-price">₦ <?php echo number_format($order_details['amount'], 2) ?></span>
                        </div>
                    </div>

                    <h2 class="order-details-title">Item(s) Ordered</h2>

                    <?php
                    if (count($products) > 1) {
                    ?>
                        <div class="controls-container">
                            <button data-direction="prev" disabled><i class="fa fa-arrow-left"></i></button>
                            <button data-direction="next"><i class="fa fa-arrow-right"></i></button>
                        </div>
                    <?php
                    }
                    ?>

                    <?php
                    foreach ($products as $key => $product) {
                        if ($key == 0) {
                    ?>
                            <div class="order-item active">
                                <?php echo showStatus($order_details['status']) ?>
                                <span class="product-status completed">non-returnable</span>

                                <div class="product-info">
                                    <div class="product-image-container">
                                        <img src="../../assets/product-images/<?= $product['product_picture'] ?>" alt="<?= $product['product_name'] ?>">
                                    </div>
                                    <div class="product-details">
                                        <span class="product-name"><?= $product['product_name'] ?></span>
                                        <span class="product-qty">Qty: <?= $product['product_quantity'] ?></span>
                                        <span class="product-price">₦ <?php echo number_format($product['product_price'], 2) ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="order-item">
                                <?php echo showStatus($order_details['status']) ?>
                                <span class="product-status completed">non-returnable</span>

                                <div class="product-info">
                                    <div class="product-image-container">
                                        <img src="../../assets/product-images/<?= $product['product_picture'] ?>" alt="<?= $product['product_name'] ?>">
                                    </div>
                                    <div class="product-details">
                                        <span class="product-name"><?= $product['product_name'] ?></span>
                                        <span class="product-qty">Qty: <?= $product['product_quantity'] ?></span>
                                        <span class="product-price">₦ <?php echo number_format($product['product_price'], 2) ?></span>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>

                    <div class="order-info-cards">
                        <div class="order-info-card">
                            <h2 class="order-card-title">
                                Payment Information
                            </h2>
                            <div class="order-card-body">
                                <div class="order-card-body-group">
                                    <h3>Payment Method</h3>
                                    <p><?= $order_details['payment_method'] === "1" ? "Paid with cards, ussd or bank transfers" : "Cash on Delivery" ?> </p>
                                </div>

                                <div class="order-card-body-group">
                                    <h3> Payment Details </h3>
                                    <p>Item total: ₦ <?php echo number_format($order_details['amount']) ?></p>
                                    <p>Shipping Fee: none</p>
                                    <!-- <p>Promotional Discount: ₦ 5,600</p> -->
                                    <p>Total: ₦ <?php echo number_format($order_details['amount'], 2) ?> </p>
                                </div>
                            </div>
                        </div>

                        <div class="order-info-card">
                            <h2 class="order-card-title">
                                Delivery Information
                            </h2>
                            <div class="order-card-body">

                                <div class="order-card-body-group">
                                    <h3>Delivery Method</h3>
                                    <p>Door Delivery</p>
                                </div>

                                <div class="order-card-body-group">
                                    <h3>Shipping Address</h3>
                                    <?php
                                    $shipping_address = explode("%", $order_details['shipping_address']);
                                    $recipient_name = $shipping_address[0];
                                    $address = $shipping_address[1];
                                    ?>
                                    <p><?php echo $recipient_name ?></p>
                                    <p>
                                        <?php echo $address ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- FONT AWESOME JIT SCRIPT-->
    <script src="https://kit.fontawesome.com/3ae896f9ec.js" crossorigin="anonymous"></script>
    <!-- JQUERY SCRIPT -->
    <script src="../../assets/js/jquery/jquery-3.6.min.js"></script>
    <!-- JQUERY MIGRATE SCRIPT (FOR OLDER JQUERY PACKAGES SUPPORT)-->
    <script src="../../assets/js/jquery/jquery-migrate-1.4.1.min.js"></script>
    <!-- METIS MENU JS -->
    <script src="../../assets/js/metismenujs/metismenujs.js"></script>
    <!-- DASHBOARD SCRIPT -->
    <script src="../../assets/js/admin-dash.js"></script>
    <script>
        // ACTIVE SAVINGS REQUEST MODAL FUNCTIONALITY 
        let productCount = 1;
        $(document).on("click", ".controls-container button", function() {
            const btnClicked = $(this).attr("data-direction");
            const orderItems = $(".order-item");

            if (btnClicked === "next") {
                orderItems.each(function() {
                    $(this).removeClass("active");
                });

                productCount++;

                ($(orderItems[productCount - 1]).addClass("active"));
            } else {
                orderItems.each(function() {
                    $(this).removeClass("active");
                });

                productCount--;

                ($(orderItems[productCount - 1]).addClass("active"));
            }

            if (productCount === 1) {
                $(".controls-container button[data-direction = 'prev']").attr("disabled", true);
                $(".controls-container button[data-direction = 'next']").attr("disabled", false);
            }

            if (productCount > 1 && productCount < orderItems.length) {
                $(".controls-container button[data-direction = 'prev']").attr("disabled", false);
                $(".controls-container button[data-direction = 'next']").attr("disabled", false);
            }

            if (productCount === orderItems.length) {
                $(".controls-container button[data-direction = 'next']").attr("disabled", true);
                $(".controls-container button[data-direction = 'prev']").attr("disabled", false);
            }
        });
    </script>
</body>

</html>