<?php
require(dirname(__DIR__) . '/auth-library/resources.php');
Auth::User("login");

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

function getWalletIntallmentType($installment_type)
{
  $output = "";

  if ($installment_type === "1") {
    $output = "day(s)";
  } elseif ($installment_type === "2") {
    $output = "week(s)";
  } else {
    $output = "month(s)";
  }

  return $output;
}

function generateStatus($status)
{
  $html = "";

  switch ($status) {
    case "1":
      $html = '<span class="dot pending"> </span> pending';
      break;
    case "2":
      $html = '<span class="dot granted"> </span> granted';
      break;
    case "3":
      $html = '<span class="dot rejected"> </span> rejected';
      break;
    default:
      $html = 'Unable to generate status';
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
            <li><a class="dropdown-item" href="../all-products/">All products</a></li>
            <li><a class="dropdown-item" href="savings?active">Active Wallets</a></li>
            <li><a class="dropdown-item" href="savings?requests">Savings Request</a></li>
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
          <?php
          if (isset($_GET['requests']) || isset($_GET['active'])) {
            $selectedTab = isset($_GET['active']) ? "1" : "2";
          }
          ?>
          <div class="tabs-container">
            <div class="tab-link-container" data-tab="1">
              <a href="javascript:void(0)" <?= isset($selectedTab) ? ($selectedTab == "1" ? "class='active'" : "") : "class='active'" ?>>Active</a>
            </div>
            <div class="tab-link-container" data-tab="2">
              <a href="javascript:void(0)" <?= isset($selectedTab) ? ($selectedTab == "2" ? "class='active'" : "") : "" ?>>Requests</a>
            </div>
          </div>
          <div class="tab-container <?= isset($selectedTab) ? ($selectedTab == "1" ? "active" : "") : "active" ?>" id="tab-1">
            <?php
            $get_active_wallets = $db->query("SELECT store_wallets.*, savings_requests.duration_of_savings, savings_requests.type_of_savings, savings_requests.target_amount, savings_requests.installment_type FROM store_wallets INNER JOIN savings_requests ON store_wallets.wallet_no=savings_requests.savings_id WHERE store_wallets.user_id = {$user_id} ORDER BY store_wallets.wallet_id DESC");

            $number_of_wallets = $get_active_wallets->num_rows;

            if ($number_of_wallets === 0) {
            ?>
              <p>No active wallets</p>
            <?php
            } else {

            ?>
              <div class="list-items-container active-wallets<?= ($number_of_wallets > 20) ? "__paginated" : "" ?>">
                <?php
                while ($wallet_details = $get_active_wallets->fetch_assoc()) {
                ?>
                  <div class="savings-card">
                    <div class="savings-icon-container">
                      <i class="fa fa-archive"></i>
                    </div>
                    <div class="savings-info-wrapper">
                      <div class="savings-info-container">
                        <a href="wallet?id=<?= $wallet_details['wallet_no'] ?>" class="savings-request-id">#<?= $wallet_details['wallet_no'] ?></a>
                        <?php
                        $period_left = $wallet_details['duration_of_savings'] - $wallet_details['paid_for'];
                        ?>
                        <span class="savings-days"><?= $period_left . " " . getWalletIntallmentType($wallet_details['installment_type']) ?> left</span>
                        <span class="savings-request-type"><span style="color: var(--primary-color)">Type:</span> <?= $wallet_details['type_of_savings'] === "1" ? "Normal Savings" : "Half Savings" ?></span>
                      </div>
                      <span class="savings-amount">
                        NGN <?= number_format($wallet_details['target_amount'], 2) ?>
                      </span>
                      <div class="savings-progress-thumb">
                        <?php
                        $percentage_of_savings = (($wallet_details['target_amount'] - $wallet_details['current_amount']) / $wallet_details['target_amount']) * 100;
                        ?>
                        <div class="progress-pill" style="width: <?= $percentage_of_savings ?>%;"></div>
                      </div>
                    </div>
                  </div>
                <?php
                }
                ?>
              </div>
            <?php
            }
            ?>
          </div>
          <div class="tab-container <?= isset($selectedTab) ? ($selectedTab == "2" ? "active" : "") : "" ?>" id="tab-2">
            <?php
            $get_savings_requests = $db->query("SELECT savings_id, type_of_savings, target_amount, status FROM savings_requests WHERE user_id = {$user_id} ORDER BY requested_at DESC");

            $number_of_requests = $get_savings_requests->num_rows;

            if ($number_of_requests === 0) {
            ?>
              <p>No active requests</p>
            <?php
            } else {
            ?>
              <div class="list-items-container savings-requests<?= $number_of_requests > 20 ? "__paginated" : "" ?>">
                <?php
                while ($request_details = $get_savings_requests->fetch_assoc()) {
                ?>
                  <div class="savings-card">
                    <div class="savings-icon-container">
                      <i class="fa fa-handshake-o"></i>
                    </div>
                    <div class="savings-request-info-container">
                      <a href="savings-request?id=<?= $request_details['savings_id'] ?>" class="savings-request-id">#<?= $request_details['savings_id'] ?></a>
                      <span class="savings-request-type"><span style="color: var(--primary-color)">Type:</span> <?= $request_details['type_of_savings'] === "1" ? "Normal Savings" : "Half Savings" ?> </span>
                      <span class="savings-request-status"> <?= generateStatus($request_details['status']) ?> </span>
                    </div>
                    <div class="savings-target-price">
                      NGN <?= number_format($request_details['target_amount'], 2) ?>
                    </div>
                  </div>
                <?php
                }
                ?>
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