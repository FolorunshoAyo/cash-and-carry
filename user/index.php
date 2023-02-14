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
    <!-- DASHHBOARD MEDIA QUERIES -->
    <link
      rel="stylesheet"
      href="../assets/css/media-queries/user-dash-mediaqueries.css"
    />
    <title>Welcome <?php echo($user_name) ?> - CDS</title>
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
            <a href="./" class="nav-link active"> Dashboard </a>
          </li>
          <li class="nav-link-item">
            <a href="#" class="nav-link"> Savings products </a>
          </li>
          <li class="nav-item-link">
            <a href="./orders">Orders</a>
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
              <li class="dashboard-nav-link active">
                <a href="./">Dashboard</a>
              </li>
              <li class="dashboard-nav-link">
                <a href="#">Savings products</a>
              </li>
              <li class="dashboard-nav-link">
                <a href="./orders">Orders</a>
              </li>
              <li class="dashboard-nav-link">
                <a href="./addresses">Address</a>
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
            <h1 class="dashboard-main-title">Dashboard</h1>

            <p class="dashboard-main-text">
              Dashboard From your account dashboard you can view your recent
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
              <a href="./address" class="dashboard-action-group">
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
