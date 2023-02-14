<?php
  require(dirname(__DIR__) . '/auth-library/resources.php');
  Auth::User("./login");

  $user_id = $_SESSION['user_id'];
  $user_name = $_SESSION['user_name'];

  $sql_user_orders = $db->query("SELECT *
  FROM orders INNER JOIN products ON 
  orders.product_id = products.product_id WHERE user_id={$user_id}");

  function showStatus($status){
    $html = "";
    switch($status){
      case "1":
        $html = "<span class='status-badge pending'>pending</span>";
      break;
      case "2":
        $html = "<span class='status-badge shipped'>shipped</span>";
      break;
      case "3":
        $html = "<span class='status-badge awaiting-shipment'>awaiting shipment</span>";
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
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT"
      crossorigin="anonymous"
    />
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
    <link
      rel="stylesheet"
      href="../assets/css/media-queries/user-dash-mediaqueries.css"
    />
    <title>User Orders - CDS</title>
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
            <a href="#" class="nav-link"> Savings products </a>
          </li>
          <li class="nav-item-link active">
            <a href="./orders" class="nav-link">Orders</a>
          </li>
          <li class="nav-link-item">
            <a href="./addresses" class="nav-link"> Addresses </a>
          </li>
          <li class="nav-link-item">
            <a href="./profile" class="nav-link"> My profile </a>
          </li>
          <li class="nav-link-item">
            <a href="#" class="nav-link logout"> Logout </a>
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
            <a
              href="#"
              class="btn btn-secondary-outline dropdown-toggle header-link"
              type="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              Browse
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </div>
          <div>
            <a class="header-link" href="#">Homepage</a>
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
                <a href="#">Savings products</a>
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
                <a href="#">Logout</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="dashboard-main-section">
          <div class="dashboard-main-container">
            <h1 class="dashboard-main-title">Open Orders</h1>

            <div id="user-orders">
              <?php
                while($row_order = $sql_user_orders->fetch_assoc()){
              ?>
              <div class="order-container">
                <div class="product-info-container">
                  <div class="product-image-container">
                    <?php
                      $product_image = explode(",", $row_order['pictures'])[0];
                    ?>
                    <img src="../a/admin/images/<?php echo $product_image ?>" alt="<?php echo $row_order['name'] ?>"/>
                  </div>
                  <div class="product-info">
                    <h3 class="product-name"><?php echo $row_order['name'] ?></h3>
                    <span class="order-no">Order <?php echo $row_order['order_no'] ?></span>
                    <div class="order-meta-details">
                      <?php echo showStatus($row_order['status']) ?>
                      <span class="order-date">On <?php echo explode(" ", $row_order['ord_date'])[0] ?> </span>
                    </div>
                  </div>
                </div>
                <div class="see-details-container">
                  <a href="./order-details?oid=<?php echo $row_order['order_id'] ?>" class="see-details-btn">see details</a>
                </div>
              </div> 
              <?php
                }
              ?>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- FONT AWESOME JIT SCRIPT-->
    <script
      src="https://kit.fontawesome.com/3ae896f9ec.js"
      crossorigin="anonymous"
    ></script>
    <!-- JQUERY SCRIPT -->
    <script src="../assets/js/jquery/jquery-3.6.min.js"></script>
    <!-- JQUERY MIGRATE SCRIPT (FOR OLDER JQUERY PACKAGES SUPPORT)-->
    <script src="../assets/js/jquery/jquery-migrate-1.4.1.min.js"></script>
    <!-- JAVASCRIPT BUNDLER WITH POPPER -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8"
      crossorigin="anonymous"
    ></script>
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
