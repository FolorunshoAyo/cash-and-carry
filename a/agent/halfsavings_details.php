<?php
require(dirname(dirname(__DIR__)) . '/auth-library/resources.php');
AgentAuth::User("a/login");

if (isset($_GET['rid']) && !empty($_GET['rid'])) {
    $rid = $_GET['rid'];

    $sql_fetch_request = $db->query("SELECT *
    FROM savings_request 
    INNER JOIN users ON savings_request.user_id=users.user_id
    WHERE savings_id={$rid}");

    $request_details = $sql_fetch_request->fetch_assoc();
} else {
    header("Location: ./requests/halfsavings_requests");
}

function showStatus($status)
{
    $html = "";
    switch ($status) {
        case "1":
            $html = "<span class='product-status pending'>pending</span>";
            break;
        case "2":
            $html = "<span class='product-status completed'>granted</span>";
            break;
        case "3":
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
    <title>Request Details (#<?= $request_details['savings_id'] ?>) - HalfCarry Agent</title>
</head>

<body style="background-color: #fafafa">
    <div class="dash-wrapper">
        <?php
        include("includes/agent-sidebar.php");
        ?>
        <section class="page-wrapper">
            <header class="dash-header">
                <a href="./requests/halfsavings_requests.php" class="back-link">
                    <i class="fa fa-arrow-left"></i>
                </a>
            </header>
            <div class="order-details-wrapper">
                <h2 class="order-title"><?php echo ucfirst($order_details['last_name']) . " " . ucfirst($order_details['first_name']) ?>'s Order Details</h2>

                <div class="order-details-container">
                    <div class="order-meta">
                        <h2 class="order-no">Order n<sup>o</sup> <?php echo $order_details['savings_id'] ?></h2>
                        <div class="order-product-details">
                            <?php
                            $products_count = count(explode(",", $request_details['product_id(s)']));
                            ?>
                            <span class="product-quantity"><?= $products_count ?> item(s)</span>
                            <span class="order-date">Placed on <?php echo explode(" ", $order_details['ord_date'])[0] ?></span>
                            <span class="product-price">₦<?php echo number_format(intval($order_details['amount'])) ?></span>
                        </div>
                    </div>

                    <h2 class="order-details-title">Item(s) Ordered</h2>

                    <div class="order-item">
                        <?php echo showStatus($order_details['status']) ?>
                        <span class="product-status completes">non-returnable</span>

                        <div class="switch-controls">
                            <button><i class="fa fa-arrow-left"></i></button>
                            <button><i class="fa fa-arrow-right"></i></button>
                        </div>
                        <div class="product-infos-container">
                            <div class="product-info">
                                <div class="product-image-container">
                                    <?php
                                    $product_image = explode(",", $order_details['pictures'])[0]
                                    ?>
                                    <img src="images/<?php echo $product_image ?>" alt="Product picture">
                                </div>
                                <div class="product-details">
                                    <span class="product-name"><?php echo $order_details['name'] ?> </span>
                                    <span class="product-qty">Qty: <?php echo $order_details['amount'] ?></span>
                                    <span class="product-price">₦<?php echo number_format(intval($order_details['purch_amt'])) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="order-info-cards">
                        <div class="order-info-card">
                            <h2 class="order-card-title">
                                Payment Information
                            </h2>
                            <div class="order-card-body">
                                <div class="order-card-body-group">
                                    <h3>Payment Method</h3>
                                    <p>Cash on Delivery</p>
                                </div>

                                <div class="order-card-body-group">
                                    <h3> Payment Details </h3>
                                    <p>Item total: ₦ <?php echo number_format(intval($order_details['purch_amt'])) ?></p>
                                    <p>Shipping Fee: none</p>
                                    <!-- <p>Promotional Discount: ₦ 5,600</p> -->
                                    <p>Total: ₦ <?php echo number_format(intval($order_details['purch_amt'])) ?> </p>
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
</body>

</html>