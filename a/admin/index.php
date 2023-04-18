<?php
require(dirname(dirname(__DIR__)) . '/auth-library/resources.php');
AdminAuth::User("a/login");
$admin_id = $_SESSION['admin_id'];

// NUMBER FORMATTER
// $human_readable = new \NumberFormatter(
//   'en_US', 
//   \NumberFormatter::PADDING_POSITION
// );

$current_date = date('Y-m-d');
$str_current_date = strtotime(date('Y-m-d'));

$admin_sql = $db->query("SELECT * FROM admin WHERE admin_id={$admin_id}");
if ($admin_sql->num_rows == 1) {
  $row_admin = $admin_sql->fetch_assoc();
} else {
  header("Location: ../login");
}

function showStatus($status)
{
  $html = "";
  switch ($status) {
    case "1":
      $html = "<span class='dot pending-dot'></span> pending";
      break;
    case "2":
      $html = "<span class='dot awaiting-shipment-dot'></span> awaiting shipment";
      break;
    case "3":
      $html = "<span class='dot shipped-dot'></span> shipped";
      break;
    case "4":
      $html = "<span class='dot completed-dot'></span> completed";
      break;
    case "5":
      $html = "<span class='dot cancelled-dot'></span> cancelled";
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
  <!-- ADMIN DASHBOARD STYLESHEET -->
  <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash/index.css" />
  <!-- DASHHBOARD MEDIA QUERIES -->
  <link rel="stylesheet" href="../../assets/css/media-queries/admin-dash-mediaqueries.css" />
  <title>Dashboard - Halfcarry Admin</title>
</head>

<body style="background-color: #fafafa">
  <div class="dash-wrapper">
    <?php 
      include("includes/admin-sidebar.php");
    ?>
    <section class="page-wrapper">
      <header class="dash-header">
        <h1 class="welcome-message">Welcome
          <?php echo (ucfirst($row_admin['first_name'])); ?>,
        </h1>
        <!-- <div class="select-container">
          <form id="selected-date-form" action="#" method="GET">
            <select id="selected-date" name="selected-date">
              <option>29 Sept, 2022</option>
            </select>
          </form>
        </div> -->
      </header>
      <section class="card-widgets">
        <div class="card today-card">
          <div class="card-details">
            <?php

            $sql_number_of_store_wallets = $db->query("SELECT COUNT(wallet_id) as no_store_wallets FROM store_wallets WHERE created_at LIKE '%$current_date%'");
            // $sql_number_of_agent_wallets = $db->query("SELECT COUNT(wallet_id) as no_agent_wallets FROM agent_wallets WHERE created_at LIKE '%$current_date%'");
            // $sql_number_of_debtor_wallets = $db->query("SELECT COUNT(wallet_id) as no_debtor_wallets FROM debtor_wallets WHERE created_at LIKE '%$current_date%'");
            // $sql_number_of_user_wallets = $db->query("SELECT COUNT(wallet_id) as no_user_wallets FROM user_wallets");

            $wallets_created = array(
              $sql_number_of_store_wallets->fetch_assoc()['no_store_wallets'],
              // $sql_number_of_agent_wallets->fetch_assoc()['no_agent_wallets'],
              // $sql_number_of_debtor_wallets->fetch_assoc()['no_debtor_wallets']
            );

            $total_wallets_created = 0;

            foreach ($wallets_created as $wallet_created) {
              $total_wallets_created += intval($wallet_created); // $total_wallets_created = $total_wallets_created + intval($wallet_created);
            }

            $sql_total_amount_store_wallets = $db->query("SELECT SUM(amount) as daily_revenue FROM savings_history WHERE deposited_at LIKE '%$current_date%'");
            // $sql_total_amount_agent_wallets = $db->query("SELECT SUM(amount) as daily_revenue FROM agent_savings WHERE deposited_at LIKE '%$current_date%'");
            // $sql_total_amount_debtor_wallets = $db->query("SELECT SUM(amount) as daily_revenue FROM debtor_savings WHERE deposited_at LIKE '%$current_date%'");
            // $sql_total_amount_user_wallets = $db->query("SELECT SUM(amount) as total_amount FROM user_wallets WHERE deposited_at LIKE '%$current_date%'");

            $total_amounts = array(
              $sql_total_amount_store_wallets->fetch_assoc()['daily_revenue'],
              // $sql_total_amount_agent_wallets->fetch_assoc()['daily_revenue'],
              // $sql_total_amount_debtor_wallets->fetch_assoc()['daily_revenue']
            );

            $total_payments = 0;

            foreach ($total_amounts as $total_amount) {
              $total_payments += intval($total_amount);
            }
            ?>
            <h2 class="title">Today's payments</h2>
            <span class="card-figure">NGN
              <?php
              // echo($human_readable->format($total_payments)) 
              echo number_format($total_payments);
              ?>
            </span>
            <span class="card-more-info"><?php echo $total_wallets_created ?> wallet(s) has been created today</span>
          </div>
          <div class="card-graph">
            <!-- GRAPH HERE -->
            GRAPH HERE
          </div>
        </div>
        <div class="card today-card">
          <div class="card-details">
            <?php

            $sql_weekly_number_of_store_wallets = $db->query("SELECT COUNT(wallet_id) as weekly_store_wallets FROM store_wallets WHERE YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)");
            // $sql_weekly_number_of_agent_wallets = $db->query("SELECT COUNT(wallet_id) as weekly_agent_wallets FROM agent_wallets WHERE YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)");
            // $sql_weekly_number_of_debtor_wallets = $db->query("SELECT COUNT(wallet_id) as weekly_debtor_wallets FROM debtor_wallets WHERE YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)");
            // $sql_number_of_user_wallets = $db->query("SELECT COUNT(wallet_id) as no_user_wallets FROM user_wallets");

            $wallets_created = array(
              $sql_weekly_number_of_store_wallets->fetch_assoc()['weekly_store_wallets'],
              // $sql_weekly_number_of_agent_wallets->fetch_assoc()['weekly_agent_wallets'],
              // $sql_weekly_number_of_debtor_wallets->fetch_assoc()['weekly_debtor_wallets']
            );

            $total_weekly_wallets_created = 0;

            foreach ($wallets_created as $wallet_created) {
              $total_weekly_wallets_created += intval($wallet_created);
            }

            $sql_total_amount_weekly_store_wallets = $db->query("SELECT SUM(amount) as weekly_revenue FROM savings_history WHERE YEARWEEK(deposited_at, 1) = YEARWEEK(CURDATE(), 1)");
            // $sql_total_amount_weekly_agent_wallets = $db->query("SELECT SUM(amount) as weekly_revenue FROM agent_savings WHERE YEARWEEK(deposited_at, 1) = YEARWEEK(CURDATE(), 1)");
            // $sql_total_amount_weekly_debtor_wallets = $db->query("SELECT SUM(amount) as weekly_revenue FROM debtor_savings WHERE YEARWEEK(deposited_at, 1) = YEARWEEK(CURDATE(), 1)");
            // $sql_total_amount_user_wallets = $db->query("SELECT SUM(amount) as total_amount FROM user_wallets WHERE deposited_at LIKE '%$current_date%'");

            $total_amounts = array(
              $sql_total_amount_weekly_store_wallets->fetch_assoc()['weekly_revenue'],
              // $sql_total_amount_weekly_agent_wallets->fetch_assoc()['weekly_revenue'],
              // $sql_total_amount_weekly_debtor_wallets->fetch_assoc()['weekly_revenue']
            );

            $total_weekly_payments = 0;

            foreach ($total_amounts as $total_amount) {
              $total_weekly_payments += intval($total_amount);
            }
            ?>
            <h2 class="title">This week's payment</h2>
            <span class="card-figure">NGN
              <?php
              // echo($human_readable->format($total_payments)) 
              echo number_format($total_weekly_payments);
              ?>
            </span>
            <span class="card-more-info"><?php echo $total_weekly_wallets_created ?> wallet(s) has been created this week</span>
          </div>
          <div class="card-graph">
            <!-- GRAPH HERE -->
            GRAPH HERE
          </div>
        </div>
        <div class="card today-card">
          <?php
          // GETTING THIS MONTH
          $this_month = date("Y-m");

          $sql_monthly_number_of_store_wallets = $db->query("SELECT COUNT(wallet_id) as weekly_store_wallets FROM store_wallets WHERE created_at LIKE '%$this_month%'");
          // $sql_monthly_number_of_agent_wallets = $db->query("SELECT COUNT(wallet_id) as weekly_agent_wallets FROM agent_wallets WHERE created_at LIKE '%$this_month%'");
          // $sql_monthly_number_of_debtor_wallets = $db->query("SELECT COUNT(wallet_id) as weekly_debtor_wallets FROM debtor_wallets WHERE created_at LIKE '%$this_month%'");
          // $sql_number_of_user_wallets = $db->query("SELECT COUNT(wallet_id) as no_user_wallets FROM user_wallets");

          $wallets_created = array(
            $sql_monthly_number_of_store_wallets->fetch_assoc()['weekly_store_wallets'],
            // $sql_monthly_number_of_agent_wallets->fetch_assoc()['weekly_agent_wallets'],
            // $sql_monthly_number_of_debtor_wallets->fetch_assoc()['weekly_debtor_wallets']
          );

          $total_monthly_wallets_created = 0;

          foreach ($wallets_created as $wallet_created) {
            $total_monthly_wallets_created += intval($wallet_created);
          }

          $sql_total_amount_monthly_store_wallets = $db->query("SELECT SUM(amount) as monthly_revenue FROM savings_history WHERE deposited_at LIKE '%$this_month%'");
          // $sql_total_amount_monthly_agent_wallets = $db->query("SELECT SUM(amount) as monthly_revenue FROM agent_savings WHERE deposited_at LIKE '%$this_month%'");
          // $sql_total_amount_monthly_debtor_wallets = $db->query("SELECT SUM(amount) as monthly_revenue FROM debtor_savings WHERE deposited_at LIKE '%$this_month%'");
          // $sql_total_amount_user_wallets = $db->query("SELECT SUM(amount) as total_amount FROM user_wallets WHERE deposited_at LIKE '%$current_date%'");

          $total_amounts = array(
            $sql_total_amount_monthly_store_wallets->fetch_assoc()['monthly_revenue'],
            // $sql_total_amount_monthly_agent_wallets->fetch_assoc()['monthly_revenue'],
            // $sql_total_amount_monthly_debtor_wallets->fetch_assoc()['monthly_revenue']
          );

          $total_monthly_payments = 0;

          foreach ($total_amounts as $total_amount) {
            $total_monthly_payments += intval($total_amount);
          }
          ?>
          <div class="card-details">
            <h2 class="title">This month's payment</h2>
            <span class="card-figure">NGN
              <?php
              // echo($human_readable->format($total_payments)) 
              echo number_format($total_monthly_payments);
              ?>
            </span>
            <span class="card-more-info"><?php echo $total_monthly_wallets_created ?> wallet(s) has been created this month</span>
          </div>
          <div class="card-graph">
            <!-- GRAPH HERE -->
            GRAPH HERE
          </div>
        </div>
      </section>
      <section class="card-widgets">
        <div class="card total-revenue-card">
          <div class="title-and-keys-container">
            <div class="title-container">
              <h2 class="title">Total Revenue</h2>
            </div>
            <div class="keys-container">
              <div class="key key-1">
                <span class="key-dot blue"></span>
                Profit
              </div>
              <div class="key key-1">
                <span class="key-dot grey"></span>
                Loss
              </div>
            </div>
          </div>
          <div class="card-figure-container">
            <?php
            $this_month = lcfirst(date("Y-m"));
            $last_month = lcfirst(date("Y-m", strtotime("last month")));
            // REVENUE FROM EASY BUY
            $sql_this_month_revenue_installment_payments = $db->query("select SUM(amount) as month_revenue from savings_history where deposited_at LIKE '%$this_month%'");
            $sql_last_month_revenue_installment_payments = $db->query("select SUM(amount) as month_revenue from savings_history where deposited_at LIKE '%$last_month%'");


            // REVENUE FROM AGENT WALLETS
            // $sql_this_month_revenue_agents = $db->query("select SUM(total_amount) as month_revenue from agent_wallets where created_at LIKE '%$this_month%'");
            // $sql_last_month_revenue_agents = $db->query("select SUM(total_amount) as month_revenue from agent_wallets where created_at LIKE '%$last_month%'");

            // REVENUE FROM AGENT WALLETS
            // $sql_this_month_revenue_debtors = $db->query("select SUM(total_amount) as month_revenue from debtor_wallets where created_at LIKE '%$this_month%'");
            // $sql_last_month_revenue_debtors = $db->query("select SUM(total_amount) as month_revenue from debtor_wallets where created_at LIKE '%$last_month%'");

            //REVENUE FROM USER WALLETS
            // $sql_this_month_revenue_users = $db->query("select SUM(total_amount) as monthly_revenue from user_wallets where monthname(created_at)='$this_month'");
            // $sql_last_month_revenue_users = $db->query("select SUM(total_amount) as monthly_revenue from user_wallets where monthname(created_at)='$last_month'");

            $last_month_total = 0;
            $this_month_total = 0;

            $last_month_revenues = array(
              $sql_last_month_revenue_installment_payments->fetch_assoc()['month_revenue'], 
              // $sql_last_month_revenue_easybuy->fetch_assoc()['month_revenue'], 
              // $sql_last_month_revenue_debtors->fetch_assoc()['month_revenue']
            );

            $this_month_revenues = array(
              $sql_this_month_revenue_installment_payments->fetch_assoc()['month_revenue'], 
              // $sql_this_month_revenue_easybuy->fetch_assoc()['month_revenue'], 
              // $sql_this_month_revenue_debtors->fetch_assoc()['month_revenue']
            );

            foreach ($this_month_revenues as $this_month_revenue) {
              $this_month_total += intval($this_month_revenue);
            }

            foreach ($last_month_revenues as $last_month_revenue) {
              $last_month_total += intval($last_month_revenue);
            }

            // CALCULATE PERCENTAGE CHANGE
            $percent_change = round(($last_month_total - $this_month_total) / ($last_month_total == 0? 1 : $last_month_total) * 100);
            ?>
            <span class="card-figure">
              NGN
              <?php
              // echo($human_readable->format($this_month_total)) 
              echo number_format($this_month_total);
              ?>
            </span>
            <?php
            if ($percent_change < 0) {
            ?>
              <span class="comparison-factor success">
                <i class="fa fa-arrow-up"></i>
                <?php echo abs($percent_change) ?>% than last month
              </span>
            <?php
            } else {
            ?>
              <span class="comparison-factor danger">
                <i class="fa fa-arrow-down"></i>
                <?php echo $percent_change ?>% than last month
              </span>
            <?php
            }
            ?>
          </div>
          <div class="graph-container">
            <!-- GRAPH HERE -->
            GRAPH HERE
          </div>
        </div>
        <div class="card top-categories-card">
          <h2 class="title">Top Selling Categories</h2>
          <div class="top-categories-container">
            <div class="top-categories-group">
              <div class="top-categories-details">
                <span class="top-categories-label"> Package Offers </span>
                <span class="top-categories-value"> 70% </span>
              </div>
              <div class="top-categories-progress">
                <div class="progress-body">
                  <div class="progress-thumb" data-percent="70%"></div>
                </div>
              </div>
            </div>
            <div class="top-categories-group">
              <div class="top-categories-details">
                <span class="top-categories-label"> Phones </span>
                <span class="top-categories-value"> 40% </span>
              </div>
              <div class="top-categories-progress">
                <div class="progress-body">
                  <div class="progress-thumb" data-percent="40%"></div>
                </div>
              </div>
            </div>
            <div class="top-categories-group">
              <div class="top-categories-details">
                <span class="top-categories-label"> Laptops </span>
                <span class="top-categories-value"> 60% </span>
              </div>
              <div class="top-categories-progress">
                <div class="progress-body">
                  <div class="progress-thumb" data-percent="60%"></div>
                </div>
              </div>
            </div>
            <div class="top-categories-group">
              <div class="top-categories-details">
                <span class="top-categories-label"> Cars </span>
                <span class="top-categories-value">
                  80%
                </span>
              </div>
              <div class="top-categories-progress">
                <div class="progress-body">
                  <div class="progress-thumb" data-percent="80%"></div>
                </div>
              </div>
            </div>
            <div class="top-categories-group">
              <div class="top-categories-details">
                <span class="top-categories-label"> Home appliances </span>
                <span class="top-categories-value"> 20% </span>
              </div>
              <div class="top-categories-progress">
                <div class="progress-body">
                  <div class="progress-thumb" data-percent="20%"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="card payment-table-section all-agents-card">
        <h2 class="title">Active store wallets</h2>
        <div class="all-agents-container">
          <table>
            <thead>
              <tr>
                <th>S/N</th>
                <th>Name</th>
                <th>Current amount</th>
                <th>Target Amount</th>
                <th>Type of wallet</th>
                <th>Last deposit</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql_all_store_wallets = $db->query("SELECT * FROM 
              store_wallets INNER JOIN users ON store_wallets.user_id=users.user_id WHERE store_wallets.completed = 0");

              function getWalletType($type){
                $output = "";
                switch($type){
                  case "1":
                    $output = "daily";
                  break;
                  case "2":
                    $output = "weekly";
                  break;
                  case "3":
                    $output = "monthly";
                  break;
                  default: 
                    $output = "unable to detect type of wallet";
                  break;
                }

                return $output;
              }

              $count = 1;
              while ($wallet_details = $sql_all_store_wallets->fetch_assoc()) {
                
              ?>
                <tr>
                  <td>#<?php echo $count ?></td>
                  <td><?php echo $wallet_details['last_name'] . " " . $wallet_details['first_name'] ?></td>
                  <td>NGN <?php echo  number_format($wallet_details['current_amount']) ?></td>
                  <td>NGN <?php echo  number_format($wallet_details['target_amount']) ?></td>
                  <td><?php echo getWalletType($wallet_details['type']) ?></td>
                  <td>
                    <?php 
                      $wallet_id = $wallet_details['wallet_id'];
                      $sql_check_last_deposit = $db->query("SELECT deposited_at FROM intallment_payments WHERE wallet_id={$wallet_id} ORDER BY payment_id DESC LIMIT 1");
                      
                      $last_deposit = $sql_check_last_deposit->fetch_assoc()['deposited_at'];

                      echo $last_deposit === ""? "No recorded deposit" : $last_deposit; 
                    ?>
                  </td>
                </tr>
              <?php
                $count++;
              }
              ?>
            </tbody>
          </table>
        </div>
      </section>
      <section class="payment-table-section card">
        <div class="tabs-container">
          <div class="tabs">
            <div class="tab active" data-tab="1">
              User Orders
            </div>
            <!-- <div class="tab" data-tab="2">
              Agent Savings
            </div>
            <div class="tab" data-tab="3">
              User Savings
            </div> -->
          </div>
        </div>
        <div class="tab-content tab-1 active">
          <h2 class="title">User Orders</h2>
          <div class="payment-table-container">
            <table>
              <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Date</th>
                  <th>Customer</th>
                  <th>Status</th>
                  <th>Total</th>
                  <th>Confirm</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sql_all_orders = $db->query("SELECT orders.*, users.last_name, users.first_name FROM orders INNER JOIN users ON orders.user_id=users.user_id");

                $count = 1;
                while ($order = $sql_all_orders->fetch_assoc()) {
                ?>
                  <tr>
                    <td>
                      #<?= $order['order_no'] ?>
                    </td>
                    <td>
                      <?php
                      echo date("d M, Y", strtotime($order['date']));
                      ?>
                    </td>
                    <td>
                      <?php
                      echo $order['last_name'] . " " . $order['first_name'];
                      ?>
                    </td>
                    <td>
                      <?php
                      echo showStatus($order['status'])
                      ?>
                    </td>
                    <td>
                      NGN <?= number_format($order['amount']) ?>
                    </td>
                    <td>
                      <!-- Link to flutterwave -->
                      <a href="order-details?oid=<?= $order['order_id'] ?>">View Order</a>
                    </td>
                  </tr>
                <?php
                  $count++;
                }
                ?>
              </tbody>
            </table>
            <div class="view-orders-container">
              <a href="./orders" class="view-orders">View all orders</a>
            </div>
          </div>
        </div>
      </section>
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
    //PROGRESS LOADERS FOR TOP SELLING CATEGORIES
    const progressThumbs = $(".progress-thumb");

    progressThumbs.each(function() {
      const dataPercent = $(this).attr("data-percent");

      $(this).css("width", dataPercent);
    });

    // TAB FUNCTIONALITY
    $(".tab").each(function() {
      $(this).on("click", function() {
        const selectedTabNo = $(this).attr("data-tab");

        $(".tab").each(function() {
          $(this).removeClass("active");
        })

        $(this).addClass("active");

        $(".tab-content").each(function() {
          $(this).removeClass("active");
        });

        $(`.tab-${selectedTabNo}`).addClass("active")
      });
    });
  </script>
</body>

</html>