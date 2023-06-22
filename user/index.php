<?php
  require(dirname(__DIR__) . '/auth-library/resources.php');
  Auth::User("login");

  $user_id = $_SESSION['user_id'];
  $user_name = $_SESSION['user_name'];
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
    <!-- Custom Fonts (Inter) -->
    <link rel="stylesheet" href="../assets/fonts/fonts.css" />
    <!-- BASE CSS -->
    <link rel="stylesheet" href="../assets/css/base.css" />
    <!-- DASHBOARD MENU CSS -->
    <link rel="stylesheet" href="../assets/css/dashboard/user-dash-menu.css" />
    <!-- USER DASHBOARD STYLESHEET -->
    <link rel="stylesheet" href="../assets/css/dashboard/user-dash/index.css" />
     <!-- Font Awesome -->
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../assets/bootstrap-5/css/bootstrap.min.css">
    <!-- DASHHBOARD MEDIA QUERIES -->
    <link
      rel="stylesheet"
      href="../assets/css/media-queries/user-dash-mediaqueries.css"
    />
    <title>Welcome <?php echo($user_name) ?> - Halfcarry</title>
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
            <h1 class="dashboard-main-title">Dashboard</h1>

            <p class="dashboard-main-text">
              From your account dashboard you can view your recent
              orders, manage your shipping and billing addresses, and edit your
              password and account details.
            </p>

            <div class="dashboard-actions">
              <a href="./orders" class="dashboard-action-group">
                <figure>
                  <i class="fa fa-shopping-bag"></i>
                  <figcaption>Orders</figcaption>
                </figure>
              </a>
              <a href="./addresses" class="dashboard-action-group">
                <figure>
                  <i class="fa fa-map-marker"></i>
                  <figcaption>Address</figcaption>
                </figure>
              </a>
              <a href="./profile" class="dashboard-action-group">
                <figure>
                  <i class="fa fa-user"></i>
                  <figcaption>My profile</figcaption>
                </figure>
              </a>
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
    <!-- CUSTOM DASHBOARD SCRIPT -->
    <script src="../assets/js/user-dash.js"></script>
  </body>
</html>
