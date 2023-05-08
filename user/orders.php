<?php
require(dirname(__DIR__) . '/auth-library/resources.php');
Auth::User("./login");

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

$sql_user_orders = $db->query("SELECT *
  FROM orders WHERE user_id={$user_id} AND placed_successfully = 1");

function showStatus($status)
{
  $html = "";
  switch ($status) {
    case "1":
      $html = "<span class='status-badge pending'>pending</span>";
      break;
    case "2":
      $html = "<span class='status-badge awaiting-shipment'>awaiting shipment</span>";
      break;
    case "3":
      $html = "<span class='status-badge shipped'>shipped</span>";
      break;
    case "4":
      $html = "<span class='status-badge completed'>completed</span>";
      break;
    case "5":
      $html = "<span class='status-badge cancelled'>cancelled</span>";
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous" />
  <!-- PAGINATE CSS -->
  <link rel="stylesheet" href="../assets/css/jquery.paginate.css">
  <!-- Custom Fonts (Inter) -->
  <link rel="stylesheet" href="../assets/fonts/fonts.css" />
  <!-- BASE CSS -->
  <link rel="stylesheet" href="../assets/css/base.css" />
  <!-- DASHBOARD MENU CSS -->
  <link rel="stylesheet" href="../assets/css/dashboard/user-dash-menu.css" />
  <!-- ITEMS PAGE STYLESHEET -->
  <link rel="stylesheet" href="../assets/css/dashboard/user-dash/orders.css">
  <!-- DASHHBOARD MEDIA QUERIES -->
  <link rel="stylesheet" href="../assets/css/media-queries/user-dash-mediaqueries.css" />
  <title>User Orders - Halfcarry</title>
</head>

<body>
  <?php
  include("includes/mobile-sidebar.php");
  ?>
  <header>
    <div class="dash-header-container">
      <div class="menu-icon-container">
        <i class="fa fa-bars"></i>
      </div>
      <div class="header-navigation-container">
        <div class="dropdown">
          <a href="#" class="btn btn-secondary-outline dropdown-toggle header-link" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Browse
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../all-products/">All products</a></li>
            <li><a class="dropdown-item" href="savings?active">Active Wallets</a></li>
            <li><a class="dropdown-item" href="savings?requests">Savings Request</a></li>
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
      <?php
      include("includes/dashboard-navigation.php");
      ?>
      <div class="dashboard-main-section">
        <div class="dashboard-main-container">
          <h1 class="dashboard-main-title">All Orders</h1>
          <?php
          if ($sql_user_orders->num_rows == 0) {
          ?>
            <div style="text-align: center; font-size: 15px;">
              <p>No orders yet</p>
            </div>
          <?php
          }
          ?>
          <ul class="user-orders">
            <?php
            while ($row_order = $sql_user_orders->fetch_assoc()) {
              $get_order_products = $db->query("SELECT product_id FROM orders_products WHERE order_no={$row_order['order_no']}")
            ?>
              <li class="order-container">
                <div class="product-images-container">
                  <?php
                  $total_products_count = $get_order_products->num_rows;
                  $remaining_count = $total_products_count - 2;

                  $loop_product_count = 1;
                  while ($order_products = $get_order_products->fetch_assoc()) {
                    $get_product_picture = $db->query("SELECT name, pictures FROM products WHERE product_id = {$order_products['product_id']}");

                    $product_details = $get_product_picture->fetch_assoc();

                    $picture = explode(",", $product_details['pictures'])[0];

                    if ($loop_product_count > 2) {
                      break;
                    }
                  ?>
                    <img src="../assets/product-images/<?= $picture ?>" alt="<?= $product_details['name'] ?>" style="width: <?= $total_products_count > 1 ? "48%" : "100%" ?>" />
                  <?php
                    $loop_product_count++;
                  }
                  ?>
                  <?php
                  if ($remaining_count > 0) {
                  ?>
                    <div class="additional-products-count">
                      <?= $remaining_count ?> +
                    </div>
                  <?php
                  }
                  ?>
                </div>
                <div class="product-info">
                  <a class="order-id" href="./order-details?oid=<?= $row_order['order_no'] ?>">Order #<?= $row_order['order_no'] ?></a>
                  <div class="order-meta-details">
                    <?php echo showStatus($row_order['status'])
                    ?>
                    <span class="order-date">On <?php echo explode(" ", $row_order['ordered_at'])[0] ?> </span>
                  </div>
                </div>
                <div class="order-price-container">
                  NGN <?= number_format($row_order['amount'], 2) ?>
                </div>
              </li>
            <?php
            }
            ?>
          </ul>
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  <!-- JQUERY PAGINATE -->
  <script src="../assets/js/jquery.paginate.js"></script>
  <!-- CUSTOM DASHBOARD SCRIPT -->
  <script src="../assets/js/user-dash.js"></script>
  <script>
    $("#user-orders").paginate({
      scope: $(".order-container"),
      paginatePosition: ['bottom'],
      itemsPerPage: 4
    });
  </script>
</body>

</html>