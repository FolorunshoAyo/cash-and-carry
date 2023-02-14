<?php 
  require(dirname(dirname(__DIR__)) . '/auth-library/resources.php');
  AdminAuth::User("a/login");
  $admin_id = $_SESSION['admin_id'];

//   $date_time = $db->query("SELECT NOW() AS nowdate");
//   $row = $date_time->fetch_assoc();
//   $dated = $row['nowdate'];
//   $now = strtotime($dated);
  // $time = date("M d Y, h:i A", $now);

  $current_date = date('Y-m-d');
  $str_current_date = strtotime(date('Y-m-d'));

  $admin_sql = $db->query("SELECT * FROM admin WHERE admin_id={$admin_id}");
  if($admin_sql->num_rows == 1){
      $row_admin = $admin_sql->fetch_assoc();
  }else{
      header("Location: ../login");
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- JQUERY DATATABLES CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <!-- DROP DOWN MENU CSS -->
    <link rel="stylesheet" href="../../assets/css/dropdown.css" />
    <!-- Custom Fonts (Inter) -->
    <link rel="stylesheet" href="../../assets/fonts/fonts.css" />
    <!-- BASE CSS -->
    <link rel="stylesheet" href="../../assets/css/base.css" />
    <!-- ADMIN FORM CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash/admin-form.css" />
    <!-- ADMIN DASHBOARD MENU CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash-menu.css" />
    <!-- ADMIN TABLE CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash/admin-table.css">
    <!-- ADMIN ALL SAVINGS CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash/all-savings.css">
    <!-- DASHHBOARD MEDIA QUERIES -->
    <link rel="stylesheet" href="../../assets/css/media-queries/admin-dash-mediaqueries.css" />
    <title>Products - CDS</title>
</head>

<body style="background-color: #fafafa">
    <div class="full-loader">
        <div class="spinner"></div>
    </div>
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
                <li class="nav-item">
                    <a href="./">
                        <i class="fa fa-tachometer"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0">
                        <i class="fa fa-signal"></i>
                        <span>Statistics</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./orders">
                        <i class="fa fa-usd"></i>
                        <span>Orders</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0">
                        <i class="fa fa-recycle"></i>
                        <span>Shipping</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./products">
                        <i class="fa fa-shopping-bag"></i>
                        <span>Products</span>
                    </a>
                </li>
                <li class="nav-item active">
                    <a href="./agents">
                        <i class="fa fa-users"></i>
                        <span>Agents</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0">
                        <i class="fa fa-commenting-o"></i>
                        <span>Messages</span>
                    </a>
                </li>
            </ul>

            <ul class="side-menu-bottom">
                <li class="nav-tem">
                    <a href="javascript:void(0)">
                        <i class="fa fa-gear"></i>
                        <span>Settings</span>
                    </a>
                </li>
                <li class="nav-item logout">
                    <a href="../logout">
                        <i class="fa fa-sign-out"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </aside>
        <section class="page-wrapper">
            <div class="table-wrapper">
                <div class="tabs-container">
                    <div class="tabs">
                        <div class="tab active" data-tab="1">
                            DS Savings
                        </div>
                        <div class="tab" data-tab="2">
                            EB Savings
                        </div>
                    </div>
                </div>

                <div class="table-container tab-content tab-1 active">
                    <table class="savings-table main-table">
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
                                $sql_agent_savings = $db->query("SELECT agents.last_name as agent_last_name, agents.first_name as agent_first_name, agent_customers.first_name as customer_first_name, agent_customers.last_name as customer_last_name, products.name, agent_savings.savings_days, agent_savings.amount, agent_savings.start_date, agent_savings.end_date, agent_savings.deposited_at
                                FROM ((((agent_wallets
                                INNER JOIN agents ON agent_wallets.agent_id = agents.agent_id)
                                INNER JOIN agent_customers ON agent_wallets.agent_customer_id = agent_customers.agent_customer_id)
                                INNER JOIN products ON agent_wallets.product_id = products.product_id)
                                INNER JOIN agent_savings ON agent_wallets.wallet_id = agent_savings.wallet_id)");

                                $savings_count = 1;
                                while($savings_details = $sql_agent_savings->fetch_assoc()){
                            ?>
                            <tr>
                                <td>
                                    #<?php echo $savings_count ?>
                                </td>
                                <td>
                                    <?php echo $savings_details['agent_last_name'] . " " . $savings_details['agent_first_name'] ?>
                                </td>
                                <td>
                                    <?php echo $savings_details['customer_last_name'] . " " . $savings_details['customer_first_name'] ?>
                                </td>
                                <td>
                                    <?php echo $savings_details['name'] ?>
                                </td>
                                <td>
                                    NGN <?php echo $savings_details['amount'] ?>
                                </td>
                                <td>
                                    <?php echo $savings_details['savings_days'] ?> days
                                </td>
                                <td>
                                    <?php echo date("d M, Y", strtotime($savings_details['start_date'])) . " - " . date("d M, Y", strtotime($savings_details['end_date'])) ?>
                                </td>
                                <td>
                                    <?php echo date("d M, Y", strtotime($savings_details['deposited_at'])) . "<br>" . date("H:i a", strtotime($savings_details['deposited_at']))?>
                                </td>
                            </tr>
                            <?php
                                    $savings_count++;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="table-container tab-2 tab-content">
                    <table class="savings-table main-table">
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

                                $savings_count = 1;
                                while($easybuy_savings_details = $sql_easybuy_savings_query->fetch_assoc()){
                            ?>
                            <tr>
                                <td>
                                    #<?php echo $savings_count ?>
                                </td>
                                <td>
                                    <?php echo $easybuy_savings_details['agent_last_name'] . " " . $easybuy_savings_details['agent_first_name'] ?>
                                </td>
                                <td>
                                    <?php echo $easybuy_savings_details['customer_last_name'] . " " . $easybuy_savings_details['customer_first_name'] ?>
                                </td>
                                <td>
                                    <?php echo $easybuy_savings_details['name'] ?>
                                </td>
                                <td>
                                    NGN <?php echo $easybuy_savings_details['amount'] ?>
                                </td>
                                <td>
                                    <?php echo $easybuy_savings_details['savings_days'] ?> days
                                </td>
                                <td>
                                    <?php echo date("d M, Y", strtotime($easybuy_savings_details['start_date'])) . " - " . date("d M, Y", strtotime($easybuy_savings_details['end_date'])) ?>
                                </td>
                                <td>
                                    <?php echo date("d M, Y", strtotime($easybuy_savings_details['deposited_at'])) . "<br>" . date("H:i a", strtotime($easybuy_savings_details['deposited_at']))?>
                                </td>
                            </tr>
                            <?php
                                    $savings_count++;
                                }
                            ?>
                        </tbody>
                    </table>
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
    <!-- Sweet Alert JS -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- JQUERY DATATABLE SCRIPT -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <!-- SWEET ALERT PLUGIN -->
    <script src="../../auth-library/vendor/dist/sweetalert2.all.min.js"></script>
    <!-- DROP DOWN JS -->
    <script type="text/javascript" src="../../assets/js/dropdown/dropdown.min.js"></script>
    <!-- DASHBOARD SCRIPT -->
    <script src="../../assets/js/admin-dash.js"></script>
    <script>
        $(function () {
            $(".savings-table").each(function (){
                $(this).DataTable({
                    "pageLength": 50
                });
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

                    $(`.tab-${selectedTabNo}`).addClass("active");
                });
            });
        });
    </script>
</body>

</html>