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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous" />
  <!-- PAGINATE CSS -->
  <link rel="stylesheet" href="../assets/css/jquery.paginate.css">
  <!-- Custom Fonts (Inter) -->
  <link rel="stylesheet" href="../assets/fonts/fonts.css" />
  <!-- BASE CSS -->
  <link rel="stylesheet" href="../assets/css/base.css" />
  <!-- CUSTOM PAGINATE CSS -->
  <link rel="stylesheet" href="../assets/css/custom-paginate.css">
  <!-- DASHBOARD MENU CSS -->
  <link rel="stylesheet" href="../assets/css/dashboard/user-dash-menu.css" />
  <!-- ITEMS PAGE STYLESHEET -->
  <link rel="stylesheet" href="../assets/css/dashboard/user-dash/savings.css">
  <!-- DASHHBOARD MEDIA QUERIES -->
  <link rel="stylesheet" href="../assets/css/media-queries/user-dash-mediaqueries.css" />
  <title>Savings - Halfcarry</title>
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
      <?php
      include("includes/dashboard-navigation.php");
      ?>
      <div class="dashboard-main-section">
        <div class="dashboard-main-container">
          <h1 class="dashboard-main-title">Savings</h1>

          <div class="tabs-container">
            <div class="tab-link-container" data-tab="1">
              <a href="javascript:void(0)" class="active">Active</a>
            </div>
            <div class="tab-link-container" data-tab="2">
              <a href="javascript:void(0)">Requests</a>
            </div>
          </div>
          <div class="tab-container active" id="tab-1">
            <!-- <p>No active wallets</p> -->
            <div class="list-items-container active-wallets">
              <div class="savings-card">
                <div class="savings-icon-container">
                  <i class="fa fa-archive"></i>
                </div>
                <div class="savings-info-wrapper">
                  <div class="savings-info-container">
                    <a href="#" class="savings-request-id">#23456789</a>
                    <span class="savings-days">13 days left</span>
                    <span class="savings-request-type"><span style="color: var(--primary-color)">Type:</span> Normal Savings</span>
                  </div>
                  <span class="savings-amount">
                    NGN 400,000
                  </span>
                  <div class="savings-progress-thumb">
                    <div class="progress-pill" style="width: 33.33%;"></div>
                  </div>
                </div>
              </div>
              <div class="savings-card">
                <div class="savings-icon-container">
                  <i class="fa fa-archive"></i>
                </div>
                <div class="savings-info-wrapper">
                  <div class="savings-info-container">
                    <a href="#" class="savings-request-id">#23456789</a>
                    <span class="savings-days">13 days left</span>
                    <span class="savings-request-type"><span style="color: var(--primary-color)">Type:</span> Normal Savings</span>
                  </div>
                  <span class="savings-amount">
                    NGN 400,000
                  </span>
                  <div class="savings-progress-thumb">
                    <div class="progress-pill" style="width: 33.33%;"></div>
                  </div>
                </div>
              </div>
              <div class="savings-card">
                <div class="savings-icon-container">
                  <i class="fa fa-archive"></i>
                </div>
                <div class="savings-info-wrapper">
                  <div class="savings-info-container">
                    <a href="#" class="savings-request-id">#23456789</a>
                    <span class="savings-days">13 days left</span>
                    <span class="savings-request-type"><span style="color: var(--primary-color)">Type:</span> Normal Savings</span>
                  </div>
                  <span class="savings-amount">
                    NGN 400,000
                  </span>
                  <div class="savings-progress-thumb">
                    <div class="progress-pill" style="width: 33.33%;"></div>
                  </div>
                </div>
              </div>
              <div class="savings-card">
                <div class="savings-icon-container">
                  <i class="fa fa-archive"></i>
                </div>
                <div class="savings-info-wrapper">
                  <div class="savings-info-container">
                    <a href="#" class="savings-request-id">#23456789</a>
                    <span class="savings-days">13 days left</span>
                    <span class="savings-request-type"><span style="color: var(--primary-color)">Type:</span> Normal Savings</span>
                  </div>
                  <span class="savings-amount">
                    NGN 400,000
                  </span>
                  <div class="savings-progress-thumb">
                    <div class="progress-pill" style="width: 33.33%;"></div>
                  </div>
                </div>
              </div>
              <div class="savings-card">
                <div class="savings-icon-container">
                  <i class="fa fa-archive"></i>
                </div>
                <div class="savings-info-wrapper">
                  <div class="savings-info-container">
                    <a href="#" class="savings-request-id">#23456789</a>
                    <span class="savings-days">13 days left</span>
                    <span class="savings-request-type"><span style="color: var(--primary-color)">Type:</span> Normal Savings</span>
                  </div>
                  <span class="savings-amount">
                    NGN 400,000
                  </span>
                  <div class="savings-progress-thumb">
                    <div class="progress-pill" style="width: 33.33%;"></div>
                  </div>
                </div>
              </div>
              <div class="savings-card">
                <div class="savings-icon-container">
                  <i class="fa fa-archive"></i>
                </div>
                <div class="savings-info-wrapper">
                  <div class="savings-info-container">
                    <a href="#" class="savings-request-id">#23456789</a>
                    <span class="savings-days">13 days left</span>
                    <span class="savings-request-type"><span style="color: var(--primary-color)">Type:</span> Normal Savings</span>
                  </div>
                  <span class="savings-amount">
                    NGN 400,000
                  </span>
                  <div class="savings-progress-thumb">
                    <div class="progress-pill" style="width: 33.33%;"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-container" id="tab-2">
            <!-- <p>No active requests</p> -->
            <div class="list-items-container savings-requests__paginated">
              <!-- REQUESTS HERE -->
              <div class="savings-card">
                <div class="savings-icon-container">
                  <i class="fa fa-handshake-o"></i>
                </div>
                <div class="savings-request-info-container">
                  <a href="#" class="savings-request-id">#23456789</a>
                  <span class="savings-request-type"><span style="color: var(--primary-color)">Type:</span> Normal Savings</span>
                  <span class="savings-request-status"><span class="dot pending-dot"></span> pending</span>
                </div>
                <div class="savings-target-price">
                  NGN 2,300,000
                </div>
              </div>
              <div class="savings-card">
                <div class="savings-icon-container">
                  <i class="fa fa-handshake-o"></i>
                </div>
                <div class="savings-request-info-container">
                  <a href="#" class="savings-request-id">#23456789</a>
                  <span class="savings-request-type"><span style="color: var(--primary-color)">Type:</span> Normal Savings</span>
                  <span class="savings-request-status"><span class="dot pending-dot"></span> pending</span>
                </div>
                <div class="savings-target-price">
                  NGN 2,300,000
                </div>
              </div>
              <div class="savings-card">
                <div class="savings-icon-container">
                  <i class="fa fa-handshake-o"></i>
                </div>
                <div class="savings-request-info-container">
                  <a href="#" class="savings-request-id">#23456789</a>
                  <span class="savings-request-type"><span style="color: var(--primary-color)">Type:</span> Normal Savings</span>
                  <span class="savings-request-status"><span class="dot pending-dot"></span> pending</span>
                </div>
                <div class="savings-target-price">
                  NGN 2,300,000
                </div>
              </div>
              <div class="savings-card">
                <div class="savings-icon-container">
                  <i class="fa fa-handshake-o"></i>
                </div>
                <div class="savings-request-info-container">
                  <a href="#" class="savings-request-id">#23456789</a>
                  <span class="savings-request-type"><span style="color: var(--primary-color)">Type:</span> Normal Savings</span>
                  <span class="savings-request-status"><span class="dot pending-dot"></span> pending</span>
                </div>
                <div class="savings-target-price">
                  NGN 2,300,000
                </div>
              </div>
              <div class="savings-card">
                <div class="savings-icon-container">
                  <i class="fa fa-handshake-o"></i>
                </div>
                <div class="savings-request-info-container">
                  <a href="#" class="savings-request-id">#23456789</a>
                  <span class="savings-request-type"><span style="color: var(--primary-color)">Type:</span> Normal Savings</span>
                  <span class="savings-request-status"><span class="dot pending-dot"></span> pending</span>
                </div>
                <div class="savings-target-price">
                  NGN 2,300,000
                </div>
              </div>
              <div class="savings-card">
                <div class="savings-icon-container">
                  <i class="fa fa-handshake-o"></i>
                </div>
                <div class="savings-request-info-container">
                  <a href="#" class="savings-request-id">#23456789</a>
                  <span class="savings-request-type"><span style="color: var(--primary-color)">Type:</span> Normal Savings</span>
                  <span class="savings-request-status"><span class="dot pending-dot"></span> pending</span>
                </div>
                <div class="savings-target-price">
                  NGN 2,300,000
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  <!-- JQUERY PAGINATE -->
  <script src="../assets/js/jquery.paginate.js"></script>
  <!-- CUSTOM DASHBOARD SCRIPT -->
  <script src="../assets/js/user-dash.js"></script>
  <script>
    $(function() {

      $(".list-items-container.active-wallets__paginated").paginate({
        scope: $(".savings-card"),
        paginatePosition: ['bottom'],
        perPage: 10
      });

      $(".list-items-container.savings-requests__paginated").paginate({
        scope: $(".savings-card"),
        paginatePosition: ['bottom'],
        perPage: 10
      });

      $(document).on("click", ".tab-link-container", function() {
        $(this).on("click", function() {
          const tabNo = $(this).attr("data-tab");

          // REMOVE ALL ACTIVE TABS
          $(".tab-link-container a").each(function() {
            $(this).removeClass("active");
          });

          $(".tab-container").each(function() {
            $(this).removeClass("active");
          });

          $(`.tab-link-container[data-tab="${tabNo}"] a`).addClass("active");
          $(`#tab-${tabNo}`).addClass("active");

        });
      });
    });
  </script>
</body>

</html>