<?php
  require(dirname(dirname(__DIR__)) . '/auth-library/resources.php');
  AdminAuth::User("a/");

  if(isset($_GET['oid']) && !empty($_GET['oid'])){
    $oid = $_GET['oid'];

    $sql_order = $db->query("SELECT *
    FROM orders INNER JOIN products ON 
    orders.product_id = products.product_id 
    INNER JOIN users ON orders.user_id=users.user_id
    WHERE order_id={$oid}");

    $order_details = $sql_order->fetch_assoc();
  }else{
    header("Location: ./orders");
  }

  function showStatus($status){
    $html = "";
    switch($status){
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
    <title>Order Details (#14214) - CDS</title>
</head>

<body style="background-color: #fafafa">
    <div class="dash-wrapper">
        <div class="mobile-backdrop"></div>
        <aside class="dash-menu">
            <div class="logo">
                <div class="menu-icon">
                <i class="fa fa-bars"></i>
                <i class="fa fa-times"></i>
                </div>
                <a href="./" class="logo">
                <i class="fa fa-home"></i>
                <span> CDS ADMIN </span>
                </a>
            </div>
            <ul class="side-menu" id="side-menu">
                <li title="dashboard" class="nav-item">
                <a href="./">
                    <i class="fa fa-tachometer"></i>
                    <span>Dashboard</span>
                </a>
                </li>
                <li title="statistics" class="nav-item">
                <a href="javascript:void(0">
                    <i class="fa fa-signal"></i>
                    <span>Statistics</span>
                </a>
                </li>
                <li title="orders" class="nav-item active">
                <a href="./orders">
                    <i class="fa fa-usd"></i>
                    <span>Orders</span>
                </a>
                </li>
                <li title="shipping" class="nav-item">
                <a href="javascript:void(0">
                    <i class="fa fa-recycle"></i>
                    <span>Shipping</span>
                </a>
                </li>
                <li title="products" class="nav-item">
                <a href="./products">
                    <i class="fa fa-shopping-bag"></i>
                    <span>Products</span>
                </a>
                </li>
                <li title="agents" class="nav-item">
                    <a href="./agents">
                        <i class="fa fa-users"></i>
                        <span>Agents</span>
                    </a>
                </li>
                <li title="debtors" class="nav-item">
                    <a href="./debtors">
                        <i class="fa fa-info-circle"></i>
                        <span>Debtors</span>
                    </a>
                </li>
                <li title="messages" class="nav-item">
                    <a href="javascript:void(0">
                        <i class="fa fa-commenting-o"></i>
                        <span>Messages</span>
                    </a>
                </li>
            </ul>

            <ul title="settings" class="side-menu-bottom">
                <li class="nav-tem">
                <a href="javascript:void(0)">
                    <i class="fa fa-gear"></i>
                    <span>Settings</span>
                </a>
                </li>
                <li title="logout" class="nav-item logout">
                <a href="../logout">
                    <i class="fa fa-sign-out"></i>
                    <span>Logout</span>
                </a>
                </li>
            </ul>
        </aside>
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
                        <h2 class="order-no">Order n<sup>o</sup> <?php echo $order_details['order_no'] ?></h2>
                        <div class="order-product-details">
                            <span class="product-quantity">1 item(s)</span>
                            <span class="order-date">Placed on <?php echo explode(" ", $order_details['ord_date'])[0] ?></span>
                            <span class="product-price">₦<?php echo number_format(intval($order_details['purch_amt'])) ?></span>
                        </div>
                    </div>

                    <h2 class="order-details-title">Item(s) Ordered</h2>

                    <div class="order-item">
                        <?php echo showStatus($order_details['status']) ?>
                        <span class="product-status completes">non-returnable</span>

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