<?php
  require(dirname(__DIR__) . '/auth-library/resources.php');
  Auth::User("./login");

  $user_id = $_SESSION['user_id'];
  $user_name = $_SESSION['user_name'];

  if(isset($_GET['oid']) && !empty($_GET['oid'])){
    $oid = $_GET['oid'];

    $sql_order = $db->query("SELECT *
    FROM orders INNER JOIN products ON 
    orders.product_id = products.product_id WHERE user_id={$user_id} AND order_id={$oid}");

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
        $html = "<span class='product-status shipped'>shipped</span>";
      break;
      case "3":
        $html = "<span class='product-status awaiting-shipment'>awaiting shipment</span>";
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
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous" />
  <!-- Custom Fonts (Inter) -->
  <link rel="stylesheet" href="../assets/fonts/fonts.css" />
  <!-- BASE CSS -->
  <link rel="stylesheet" href="../assets/css/base.css" />
  <!-- DASHBOARD MENU CSS -->
  <link rel="stylesheet" href="../assets/css/dashboard/user-dash-menu.css" />
  <!-- ORDER DETAILS STYLESHEET -->
  <link rel="stylesheet" href="../assets/css/dashboard/user-dash/order-details.css" />
  <!-- DASHHBOARD MEDIA QUERIES -->
  <link rel="stylesheet" href="../assets/css/media-queries/user-dash-mediaqueries.css" />
  <title>Order Details - CDS
  </title>
</head>

<body>
  <div class="mobile-backdrop"></div>
  <aside class="mobile-menu">
    <div class="cross-icon-wrapper">
      <div class="cross-icon-container">
        <i class="fa fa-times"></i>
      </div>
    </div>
    <div class="nav-link-container">
      <ul class="nav-links">
        <li class="nav-link-item">
          <a href="./" class="nav-link"> Dashboard </a>
        </li>
        <li class="nav-link-item">
          <a href="javascript:void(0)" class="nav-link"> Savings products </a>
        </li>
        <li class="nav-link-item active">
          <a href="./orders" class="nav-link">Orders</a>
        </li>
        <li class="nav-link-item">
          <a href="./addresses" class="nav-link"> Addresses </a>
        </li>
        <li class="nav-link-item">
          <a href="./profile" class="nav-link"> My profile </a>
        </li>
        <li class="nav-link-item">
          <a href="../logout" class="nav-link logout"> Logout </a>
        </li>
      </ul>
    </div>
  </aside>
  <header>
    <div class="dash-header-container">
      <div class="menu-icon-container">
        <i class="fa fa-bars"></i>
      </div>
      <div class="header-navigation-container">
        <div class="dropdown">
          <a href="#" class="btn btn-secondary-outline dropdown-toggle header-link" type="button"
            data-bs-toggle="dropdown" aria-expanded="false">
            Browse
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </div>
        <div>
          <a class="header-link" href="../">Homepage</a>
        </div>
        <div>
          <a class="header-link" href="#">Help</a>
        </div>
      </div>
    </div>
  </header>
  <main>
    <div class="main-container">
      <div class="dashboard-links-wrapper">
        <div class="dashboard-links">
          <ul class="dashboard-nav-links">
            <li class="title">My Profile</li>
            <li class="dashboard-nav-link">
              <a href="./">Dashboard</a>
            </li>
            <li class="dashboard-nav-link">
              <a href="javascript:void(0)">Savings products</a>
            </li>
            <li class="dashboard-nav-link active">
              <a href="./orders">Orders</a>
            </li>
            <li class="dashboard-nav-link">
              <a href="./addresses">Addresses</a>
            </li>
            <li class="dashboard-nav-link">
              <a href="./profile">My profile</a>
            </li>
            <li class="dashboard-nav-link logout">
              <a href="../logout">Logout</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="dashboard-main-section">
        <div class="dashboard-main-container">
          <h1 class="dashboard-main-title">Order Details</h1>

          <p class="dashboard-main-text">
            Information about your order is contained below:
          </p>

          <div class="order-details-container">
            <div class="order-meta">
              <h2 class="order-no">Order n<sup>o</sup> <?php echo $order_details['order_no'] ?> </h2>
              <div class="order-product-details">
                <span class="product-quantity">1 item(s)</span>
                <span class="order-date">Placed on <?php echo explode(" ",$order_details['ord_date'])[0] ?> </span>
                <span class="product-price">₦ <?php echo number_format(intval($order_details['purch_amt'])) ?></span>
              </div>
            </div>

            <h2 class="order-details-title">Item(s) Ordered</h2>

            <div class="order-item">
              <?php echo showStatus($order_details['status']) ?>
              <span class="product-status completed">non-returnable</span>

              <div class="product-info">
                <div class="product-image-container">
                  <?php
                    $product_image = explode(",", $order_details['pictures'])[0];
                  ?>
                  <img src="../a/admin/images/<?php echo $product_image ?>" alt="Product picture">
                </div>
                <div class="product-details">
                  <span class="product-name"><?php echo $order_details['name'] ?></span>
                  <span class="product-qty">Qty: <?php echo $order_details['amount'] ?></span>
                  <span class="product-price">₦ <?php echo number_format(intval($order_details['purch_amt'])) ?></span>
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
      </div>
    </div>
  </main>

  <!-- FONT AWESOME JIT SCRIPT-->
  <script src="https://kit.fontawesome.com/3ae896f9ec.js" crossorigin="anonymous"></script>
  <!-- JQUERY SCRIPT -->
  <script src="../assets/js/jquery/jquery-3.6.min.js"></script>
  <!-- JQUERY MIGRATE SCRIPT (FOR OLDER JQUERY PACKAGES SUPPORT)-->
  <script src="../assets/js/jquery/jquery-migrate-1.4.1.min.js"></script>
  <!-- JAVASCRIPT BUNDLER WITH POPPER -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8"
    crossorigin="anonymous"></script>
  <!-- CUSTOM DASHBOARD SCRIPT -->
  <script src="../assets/js/user-dash.js"></script>
</body>

</html>