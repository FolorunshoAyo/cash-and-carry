<?php 
  require(dirname(dirname(__DIR__)) . '/auth-library/resources.php');
  AdminAuth::User("a/login");
  $admin_id = $_SESSION['admin_id'];

  // NUMBER FORMATTER
  // $human_readable = new \NumberFormatter(
  //   'en_US', 
  //   \NumberFormatter::PADDING_POSITION
  // );

  //==================================================================
  //Check users last saving date

  // $date_time = $db->query("SELECT NOW() AS nowdate");
  // $row = $date_time->fetch_assoc();
  // $dated = $row['nowdate'];
  // $now = strtotime($dated);
  // $time = date("M d Y, h:i A", $now);

  $current_date = date('Y-m-d');
  $str_current_date = strtotime(date('Y-m-d'));

  $admin_sql = $db->query("SELECT * FROM admin WHERE admin_id={$admin_id}");
  if($admin_sql->num_rows == 1){
      $row_admin = $admin_sql->fetch_assoc();
  }else{
      header("Location: ../login");
  }

  function showStatus($status){
    $html = "";
    switch($status){
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
  <title>Admin Dashboard: CDS ADMIN</title>
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
        <li title="dashboard" class="nav-item active">
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
        <li title="orders" class="nav-item">
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
        <h1 class="welcome-message">Welcome
          <?php echo(ucfirst($row_admin['first_name'])); ?>,
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

              $sql_number_of_easybuy_wallets = $db->query("SELECT COUNT(wallet_id) as no_easybuy_wallets FROM easybuy_agent_wallets WHERE created_at LIKE '%$current_date%'");
              $sql_number_of_agent_wallets = $db->query("SELECT COUNT(wallet_id) as no_agent_wallets FROM agent_wallets WHERE created_at LIKE '%$current_date%'");
              $sql_number_of_debtor_wallets = $db->query("SELECT COUNT(wallet_id) as no_debtor_wallets FROM debtor_wallets WHERE created_at LIKE '%$current_date%'");
              // $sql_number_of_user_wallets = $db->query("SELECT COUNT(wallet_id) as no_user_wallets FROM user_wallets");

              $wallets_created = array(
                $sql_number_of_easybuy_wallets->fetch_assoc()['no_easybuy_wallets'],
                $sql_number_of_agent_wallets->fetch_assoc()['no_agent_wallets'],
                $sql_number_of_debtor_wallets->fetch_assoc()['no_debtor_wallets']
              );

              $total_wallets_created = 0;

              foreach($wallets_created as $wallet_created){
                $total_wallets_created += intval($wallet_created); // $total_wallets_created = $total_wallets_created + intval($wallet_created);
              }

              $sql_total_amount_easybuy_wallets = $db->query("SELECT SUM(amount) as daily_revenue FROM easybuy_agent_savings WHERE deposited_at LIKE '%$current_date%'");
              $sql_total_amount_agent_wallets = $db->query("SELECT SUM(amount) as daily_revenue FROM agent_savings WHERE deposited_at LIKE '%$current_date%'");
              $sql_total_amount_debtor_wallets = $db->query("SELECT SUM(amount) as daily_revenue FROM debtor_savings WHERE deposited_at LIKE '%$current_date%'");
              // $sql_total_amount_user_wallets = $db->query("SELECT SUM(amount) as total_amount FROM user_wallets WHERE deposited_at LIKE '%$current_date%'");

              $total_amounts = array(
                $sql_total_amount_easybuy_wallets->fetch_assoc()['daily_revenue'],
                $sql_total_amount_agent_wallets->fetch_assoc()['daily_revenue'],
                $sql_total_amount_debtor_wallets->fetch_assoc()['daily_revenue']
              );

              $total_payments = 0;

              foreach($total_amounts as $total_amount){
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
            <span class="card-more-info"><?php echo $total_wallets_created?> wallet(s) has been created today</span>
          </div>
          <div class="card-graph">
            <!-- GRAPH HERE -->
            GRAPH HERE
          </div>
        </div>
        <div class="card today-card">
          <div class="card-details">
            <?php

              $sql_weekly_number_of_easybuy_wallets = $db->query("SELECT COUNT(wallet_id) as weekly_easybuy_wallets FROM easybuy_agent_wallets WHERE YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)");
              $sql_weekly_number_of_agent_wallets = $db->query("SELECT COUNT(wallet_id) as weekly_agent_wallets FROM agent_wallets WHERE YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)");
              $sql_weekly_number_of_debtor_wallets = $db->query("SELECT COUNT(wallet_id) as weekly_debtor_wallets FROM debtor_wallets WHERE YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)");
              // $sql_number_of_user_wallets = $db->query("SELECT COUNT(wallet_id) as no_user_wallets FROM user_wallets");

              $wallets_created = array(
                $sql_weekly_number_of_easybuy_wallets->fetch_assoc()['weekly_easybuy_wallets'],
                $sql_weekly_number_of_agent_wallets->fetch_assoc()['weekly_agent_wallets'],
                $sql_weekly_number_of_debtor_wallets->fetch_assoc()['weekly_debtor_wallets']
              );

              $total_weekly_wallets_created = 0;

              foreach($wallets_created as $wallet_created){
                $total_weekly_wallets_created += intval($wallet_created);
              }

              $sql_total_amount_weekly_easybuy_wallets = $db->query("SELECT SUM(amount) as weekly_revenue FROM easybuy_agent_savings WHERE YEARWEEK(deposited_at, 1) = YEARWEEK(CURDATE(), 1)");
              $sql_total_amount_weekly_agent_wallets = $db->query("SELECT SUM(amount) as weekly_revenue FROM agent_savings WHERE YEARWEEK(deposited_at, 1) = YEARWEEK(CURDATE(), 1)");
              $sql_total_amount_weekly_debtor_wallets = $db->query("SELECT SUM(amount) as weekly_revenue FROM debtor_savings WHERE YEARWEEK(deposited_at, 1) = YEARWEEK(CURDATE(), 1)");
              // $sql_total_amount_user_wallets = $db->query("SELECT SUM(amount) as total_amount FROM user_wallets WHERE deposited_at LIKE '%$current_date%'");

              $total_amounts = array(
                $sql_total_amount_weekly_easybuy_wallets->fetch_assoc()['weekly_revenue'],
                $sql_total_amount_weekly_agent_wallets->fetch_assoc()['weekly_revenue'],
                $sql_total_amount_weekly_debtor_wallets->fetch_assoc()['weekly_revenue']
              );

              $total_weekly_payments = 0;

              foreach($total_amounts as $total_amount){
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
            <span class="card-more-info"><?php echo $total_weekly_wallets_created?> wallet(s) has been created this week</span>
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

            $sql_monthly_number_of_easybuy_wallets = $db->query("SELECT COUNT(wallet_id) as weekly_easybuy_wallets FROM easybuy_agent_wallets WHERE created_at LIKE '%$this_month%'");
            $sql_monthly_number_of_agent_wallets = $db->query("SELECT COUNT(wallet_id) as weekly_agent_wallets FROM agent_wallets WHERE created_at LIKE '%$this_month%'");
            $sql_monthly_number_of_debtor_wallets = $db->query("SELECT COUNT(wallet_id) as weekly_debtor_wallets FROM debtor_wallets WHERE created_at LIKE '%$this_month%'");
            // $sql_number_of_user_wallets = $db->query("SELECT COUNT(wallet_id) as no_user_wallets FROM user_wallets");

            $wallets_created = array(
              $sql_monthly_number_of_easybuy_wallets->fetch_assoc()['weekly_easybuy_wallets'],
              $sql_monthly_number_of_agent_wallets->fetch_assoc()['weekly_agent_wallets'],
              $sql_monthly_number_of_debtor_wallets->fetch_assoc()['weekly_debtor_wallets']
            );

            $total_monthly_wallets_created = 0;

            foreach($wallets_created as $wallet_created){
              $total_monthly_wallets_created += intval($wallet_created);
            }

            $sql_total_amount_monthly_easybuy_wallets = $db->query("SELECT SUM(amount) as monthly_revenue FROM easybuy_agent_savings WHERE deposited_at LIKE '%$this_month%'");
            $sql_total_amount_monthly_agent_wallets = $db->query("SELECT SUM(amount) as monthly_revenue FROM agent_savings WHERE deposited_at LIKE '%$this_month%'");
            $sql_total_amount_monthly_debtor_wallets = $db->query("SELECT SUM(amount) as monthly_revenue FROM debtor_savings WHERE deposited_at LIKE '%$this_month%'");
            // $sql_total_amount_user_wallets = $db->query("SELECT SUM(amount) as total_amount FROM user_wallets WHERE deposited_at LIKE '%$current_date%'");

            $total_amounts = array(
              $sql_total_amount_monthly_easybuy_wallets->fetch_assoc()['monthly_revenue'],
              $sql_total_amount_monthly_agent_wallets->fetch_assoc()['monthly_revenue'],
              $sql_total_amount_monthly_debtor_wallets->fetch_assoc()['monthly_revenue']
            );

            $total_monthly_payments = 0;

            foreach($total_amounts as $total_amount){
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
            <span class="card-more-info"><?php echo $total_monthly_wallets_created?> wallet(s) has been created this month</span>
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
              $sql_this_month_revenue_easybuy = $db->query("select SUM(total_amount) as month_revenue from easybuy_agent_wallets where created_at LIKE '%$this_month%'");
              $sql_last_month_revenue_easybuy = $db->query("select SUM(total_amount) as month_revenue from easybuy_agent_wallets where created_at LIKE '%$last_month%'");
            
              // REVENUE FROM AGENT WALLETS
              $sql_this_month_revenue_agents = $db->query("select SUM(total_amount) as month_revenue from agent_wallets where created_at LIKE '%$this_month%'");
              $sql_last_month_revenue_agents = $db->query("select SUM(total_amount) as month_revenue from agent_wallets where created_at LIKE '%$last_month%'");

              // REVENUE FROM AGENT WALLETS
              $sql_this_month_revenue_debtors = $db->query("select SUM(total_amount) as month_revenue from debtor_wallets where created_at LIKE '%$this_month%'");
              $sql_last_month_revenue_debtors = $db->query("select SUM(total_amount) as month_revenue from debtor_wallets where created_at LIKE '%$last_month%'");

              //REVENUE FROM USER WALLETS
              // $sql_this_month_revenue_users = $db->query("select SUM(total_amount) as monthly_revenue from user_wallets where monthname(created_at)='$this_month'");
              // $sql_last_month_revenue_users = $db->query("select SUM(total_amount) as monthly_revenue from user_wallets where monthname(created_at)='$last_month'");

              $last_month_total = 0;
              $this_month_total = 0;

              $last_month_revenues = array($sql_last_month_revenue_agents->fetch_assoc()['month_revenue'], $sql_last_month_revenue_easybuy->fetch_assoc()['month_revenue'], $sql_last_month_revenue_debtors->fetch_assoc()['month_revenue']);
              $this_month_revenues = array($sql_this_month_revenue_agents->fetch_assoc()['month_revenue'], $sql_this_month_revenue_easybuy->fetch_assoc()['month_revenue'], $sql_this_month_revenue_debtors->fetch_assoc()['month_revenue']);

              foreach($this_month_revenues as $this_month_revenue){
                $this_month_total += intval($this_month_revenue);
              }

              foreach($last_month_revenues as $last_month_revenue){
                $last_month_total += intval($last_month_revenue);
              }

              // CALCULATE PERCENTAGE CHANGE
              $percent_change = round(($last_month_total - $this_month_total) / $last_month_total * 100);
            ?>
            <span class="card-figure">
              NGN
              <?php 
                // echo($human_readable->format($this_month_total)) 
                echo number_format($this_month_total);
              ?>
            </span>
            <?php
              if($percent_change < 0){
            ?>
              <span class="comparison-factor success">
                  <i class="fa fa-arrow-up"></i>
                  <?php echo abs($percent_change) ?>% than last month
                </span>
            <?php 
              }else{
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
        <h2 class="title">All agents</h2>
        <div class="all-agents-container">
          <table>
            <thead>
              <tr>
                <th>S/N</th>
                <th>Name</th>
                <th>Total DS savings</th>
                <th>No. of DS customers</th>
                <th>Total EB savings</th>
                <th>No. of EB customers</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $sql_all_agents = $db->query("SELECT * FROM agents");

                $count = 1;
                while($agent_details = $sql_all_agents->fetch_assoc()){
                  $aid = $agent_details['agent_id'];

                  $sql_easybuy_customers = $db->query("SELECT COUNT(agent_customer_id) as no_of_easybuy_customers FROM easybuy_agent_customers WHERE agent_id = '$aid'");
                  $sql_savings_customers = $db->query("SELECT COUNT(agent_customer_id) as no_of_savings_customers FROM agent_customers WHERE agent_id = '$aid'");

                  $all_agent_customers = array(
                    $sql_easybuy_customers->fetch_assoc()['no_of_easybuy_customers'],
                    $sql_savings_customers->fetch_assoc()['no_of_savings_customers']
                  );

                  $sql_total_agent_easybuy_savings = $db->query("SELECT SUM(total_amount) as total_easybuy_savings FROM easybuy_agent_wallets WHERE agent_id = '$aid'");
                  $sql_total_agent_normal_savings = $db->query("SELECT SUM(total_amount) as total_normal_savings FROM agent_wallets WHERE agent_id = '$aid'");

                  $all_agent_savings = array(
                    $sql_total_agent_easybuy_savings->fetch_assoc()['total_easybuy_savings'],
                    $sql_total_agent_normal_savings->fetch_assoc()['total_normal_savings']
                  );

                  $total_easybuy_customers = intval($all_agent_customers[0]);
                  $total_normal_customers = intval($all_agent_customers[1]);
                  $total_easybuy_savings = intval($all_agent_savings[0]);
                  $total_normal_savings = intval($all_agent_savings[1]);
                ?>
              <tr>
                <td>#<?php echo $count ?></td>
                <td><?php echo $agent_details['last_name'] . " " . $agent_details['first_name']?></td>
                <td>NGN <?php echo  number_format($total_normal_savings) ?></td>
                <td><?php echo $total_normal_customers ?></td>
                <td>NGN <?php echo number_format($total_easybuy_savings) ?></td>
                <td><?php echo $total_easybuy_customers ?></td>
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
            <div class="tab" data-tab="2">
              Agent Savings
            </div>
            <div class="tab" data-tab="3">
              User Savings
            </div>
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
                   while($order = $sql_all_orders->fetch_assoc()){
                ?>
                <tr>
                  <td>
                    #<?= $order['order_no'] ?>
                  </td>
                  <td>
                    <?php
                      echo date("d M, Y", strtotime($order['ord_date']));
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
                    NGN <?= number_format($order['purch_amt']) ?>
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
        <div class="tab-content tab-2">
          <h2 class="title">Agent Savings</h2>
          <div class="payment-table-container">
            <h3 class="title">Normal Savings</h3>
            <table>
              <thead>
                <tr>
                  <th>S/N</th>
                  <th>Agent Name</th>
                  <th>Customer Name</th>
                  <th>Product</th>
                  <th>Amount paid</th>
                  <th>Days saved</th>
                  <th>Period covered</th>
                  <th>Deposited at</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $sql_normal_savings_query = $db->query("SELECT agents.last_name as agent_last_name, agents.first_name as agent_first_name, agent_customers.first_name as customer_first_name, agent_customers.last_name as customer_last_name, products.name, agent_savings.savings_days, agent_savings.amount, agent_savings.start_date, agent_savings.end_date, agent_savings.deposited_at
                  FROM ((((agent_wallets
                  INNER JOIN agents ON agent_wallets.agent_id = agents.agent_id)
                  INNER JOIN agent_customers ON agent_wallets.agent_customer_id = agent_customers.agent_customer_id)
                  INNER JOIN products ON agent_wallets.product_id = products.product_id)
                  INNER JOIN agent_savings ON agent_wallets.wallet_id = agent_savings.wallet_id) LIMIT 10");

                  $count = 1;

                  while($normal_savings_detais = $sql_normal_savings_query->fetch_assoc()){
                ?>
                <tr>
                  <td>
                    #<?php echo $count ?>
                  </td>
                  <td>
                    <?php echo $normal_savings_detais['agent_last_name'] . " " . $normal_savings_detais['agent_first_name'] ?>
                  </td>
                  <td>
                    <?php echo $normal_savings_detais['customer_last_name'] . " " . $normal_savings_detais['customer_first_name'] ?>
                  </td>
                  <td>
                    <?php echo $normal_savings_detais['name'] ?>
                  </td>
                  <td>
                    NGN <?php echo $normal_savings_detais['amount'] ?>
                  </td>
                  <td>
                    <?php echo $normal_savings_detais['savings_days'] ?> days
                  </td>
                  <td>
                    <?php echo date("d M, Y", strtotime($normal_savings_detais['start_date'])) . " - " . date("d M, Y", strtotime($normal_savings_detais['end_date'])) ?>
                  </td>
                  <td>
                    <?php echo date("d M, Y", strtotime($normal_savings_detais['deposited_at'])) . "<br>" . date("H:i a", strtotime($normal_savings_detais['deposited_at']))?>
                  </td>
                </tr>
                <?php
                  $count++;
                  }
                ?>
              </tbody>
            </table>
          </div>
          <div class="payment-table-container">
            <h3 class="title">Easy Buy Savings</h3>
            <table>
              <thead>
                <tr>
                  <th>S/N</th>
                  <th>Agent Name</th>
                  <th>Customer Name</th>
                  <th>Product</th>
                  <th>Amount paid</th>
                  <th>Days saved</th>
                  <th>Period covered</th>
                  <th>Deposited at</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $sql_easybuy_savings_query = $db->query("SELECT agents.last_name as agent_last_name, agents.first_name as agent_first_name, easybuy_agent_customers.first_name as customer_first_name, easybuy_agent_customers.last_name as customer_last_name, products.name, easybuy_agent_savings.savings_days, easybuy_agent_savings.amount, easybuy_agent_savings.start_date, easybuy_agent_savings.end_date, easybuy_agent_savings.deposited_at
                  FROM ((((easybuy_agent_wallets
                  INNER JOIN agents ON easybuy_agent_wallets.agent_id = agents.agent_id)
                  INNER JOIN easybuy_agent_customers ON easybuy_agent_wallets.agent_customer_id = easybuy_agent_customers.agent_customer_id)
                  INNER JOIN products ON easybuy_agent_wallets.product_id = products.product_id)
                  INNER JOIN easybuy_agent_savings ON easybuy_agent_wallets.wallet_id = easybuy_agent_savings.wallet_id) LIMIT 10");

                  $count = 1;

                  while($easybuy_savings_detais = $sql_easybuy_savings_query->fetch_assoc()){
                ?>
                <tr>
                  <td>
                    #<?php echo $count ?>
                  </td>
                  <td>
                    <?php echo $easybuy_savings_detais['agent_last_name'] . " " . $easybuy_savings_detais['agent_first_name'] ?>
                  </td>
                  <td>
                    <?php echo $easybuy_savings_detais['customer_last_name'] . " " . $easybuy_savings_detais['customer_first_name'] ?>
                  </td>
                  <td>
                    <?php echo $easybuy_savings_detais['name'] ?>
                  </td>
                  <td>
                    NGN <?php echo $easybuy_savings_detais['amount'] ?>
                  </td>
                  <td>
                    <?php echo $easybuy_savings_detais['savings_days'] ?> days
                  </td>
                  <td>
                    <?php echo date("d M, Y", strtotime($easybuy_savings_detais['start_date'])) . " - " . date("d M, Y", strtotime($easybuy_savings_detais['end_date'])) ?>
                  </td>
                  <td>
                    <?php echo date("d M, Y", strtotime($easybuy_savings_detais['deposited_at'])) . "<br>" . date("H:i a", strtotime($easybuy_savings_detais['deposited_at']))?>
                  </td>
                </tr>
                <?php
                  $count++;
                  }
                ?>
              </tbody>
            </table>
          </div>
          <div class="view-orders-container">
            <a href="./all_savings" class="view-orders">View all savings</a>
          </div>
        </div>
        <div class="tab-content tab-3">
          <h2 class="title">User Savings</h2>
          <div class="payment-table-container">
            <p style="text-align: center; font-size: 1.5rem; margin: 2rem 0;font-weight: bold;">Coming Soon</p>
            <!-- <table>
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
                <tr>
                  <td>
                    #112234
                  </td>
                  <td>
                    Sept 9, 2022
                  </td>
                  <td>
                    Shodiya Folorunsho
                  </td>
                  <td>
                    <span class="dot pending-dot"></span>
                    pending
                  </td>
                  <td>
                    NGN6000
                  </td>
                  <td>
                    <a href="order-details">View Order</a>
                  </td>
                </tr>
              </tbody>
            </table>
            <div class="view-orders-container">
              <a href="./orders" class="view-orders">View all orders</a>
            </div> -->
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

    progressThumbs.each(function () {
      const dataPercent = $(this).attr("data-percent");

      $(this).css("width", dataPercent);
    });

    // TAB FUNCTIONALITY
    $(".tab").each(function(){
      $(this).on("click", function(){
        const selectedTabNo = $(this).attr("data-tab");

        $(".tab").each(function(){
          $(this).removeClass("active");
        })

        $(this).addClass("active");

        $(".tab-content").each(function(){
          $(this).removeClass("active");
        });

        $(`.tab-${selectedTabNo}`).addClass("active")
      });
    });
  </script>
</body>

</html>