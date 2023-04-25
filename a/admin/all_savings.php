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
            $html = "<span class='dot completed-dot'></span> granted";
            break;
        case "3":
            $html = "<span class='dot cancelled-dot'></span> rejected";
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
    <title>Savings - Halfcarry Admin</title>
</head>

<body style="background-color: #fafafa">
    <div class="dash-wrapper">
        <?php
        include("includes/admin-sidebar.php");
        ?>
        <section class="page-wrapper">
            <div class="table-wrapper">
                <div class="tabs-container">
                    <div class="tabs">
                        <div class="tab active" data-tab="1">
                            Active
                        </div>
                        <div class="tab" data-tab="2">
                            Requests
                        </div>
                    </div>
                </div>

                <div class="table-container tab-content tab-1 active">
                    <table class="savings-table main-table">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <!-- <th>
                                    No. of products
                                </th> -->
                                <th>
                                    Type of savings
                                </th>
                                <th>
                                    Duration of Savings
                                </th>
                                <th>
                                    Installment Amount
                                </th>
                                <th>
                                    Current Amount
                                </th>
                                <th>
                                    Target Amount
                                </th>
                                <th>
                                    Ass. Agent
                                </th>
                                <th>

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_active_wallets = $db->query("SELECT store_wallets.*, savings_requests.installment_type as installment_type, savings_requests.duration_of_savings as duration_of_savings,
                            savings_requests.installment_amount as installment_amount, savings_requests.target_amount as target_amount, savings_requests.type_of_savings as type_of_savings, agents.first_name as agent_first_name,
                            agents.last_name as agent_last_name
                           FROM ((store_wallets INNER JOIN savings_requests ON store_wallets.wallet_no = savings_requests.savings_id) INNER JOIN agents ON store_wallets.agent_id=agents.agent_id)
                           WHERE savings_requests.status = 2 ORDER BY store_wallets.wallet_id DESC");

                            $wallets_count = 2;
                            while ($wallet_details = $sql_active_wallets->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td>
                                        <?= $wallet_details['wallet_no'] ?>
                                    </td>
                                    <!-- <td>
                                        <?php
                                        // $get_products_in_request = $db->query("SELECT COUNT(*) as num_of_products FROM savings_products WHERE savings_id={$wallet_details['wallet_no']}");

                                        // $number_of_products = $get_products_in_request->fetch_assoc()['num_of_products'];

                                        ?>
                                        <?php // $number_of_products 
                                        ?>
                                    </td> -->
                                    <td>
                                        <?= $wallet_details['type_of_savings'] === "1" ? "Normal Savings" : "Half Savings" ?>
                                    </td>
                                    <td>
                                        <?php
                                        $period_suffix = $wallet_details['installment_type'] === "1" ? "day(s)" : ($wallet_details['installment_type'] === "2" ? "week(s)" : "month(s)");

                                        echo $wallet_details['duration_of_savings'] . " " . $period_suffix;
                                        ?>
                                    </td>
                                    <td>
                                        ₦ <?= number_format($wallet_details['installment_amount'], 2) ?>
                                    </td>
                                    <td>
                                        ₦ <?= number_format($wallet_details['amount'], 2) ?>
                                    </td>
                                    <td>
                                        ₦ <?= number_format($wallet_details['target_amount'], 2) ?>
                                    </td>
                                    <td>
                                        Agt. <?= $wallet_details['agent_last_name'] . " " . $wallet_details['agent_first_name'] ?>
                                    </td>
                                    <td>
                                        <div class="dropdown" style="font-size: 10px;">
                                            <button class="dropdown-toggle" data-dd-target="<?php echo $wallets_count ?>" aria-label="Dropdown Menu">
                                                o<br>o<br>o
                                            </button>
                                            <div class="dropdown-menu" data-dd-path="<?php echo $wallets_count ?>">
                                                <a class="dropdown-menu__link" href="wallet?id=<?= $wallet_details['wallet_no'] ?>">View Wallet</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                                $wallets_count += 2;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="table-container tab-2 tab-content">
                    <table class="savings-table main-table">
                        <thead>
                            <tr>
                                <!-- <th>
                                    Product(s)
                                </th> -->
                                <th>
                                    ID
                                </th>
                                <th>
                                    Date
                                </th>
                                <th>
                                    Customer
                                </th>
                                <th>
                                    status
                                </th>
                                <th>
                                    Installment Amount
                                </th>
                                <th>
                                    Target Amount
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_all_savings_requests = $db->query("SELECT * FROM savings_requests INNER JOIN users ON savings_requests.user_id = users.user_id ORDER BY id DESC");

                            $count = 1;
                            while ($request_details = $sql_all_savings_requests->fetch_assoc()) {
                            ?>
                                <tr>
                                    <!-- <td>
                                    <div class="product-details-container">
                                        <div class="product-img-container">
                                            <img src="images/iphone13-green.jpg" alt="Product Image" />
                                        </div>
                                        <div class="product-details">
                                            <span class="product-title">Iphone 13 green</span>
                                            <span class="product-span">Category: Phone</span>
                                        </div>
                                    </div>
                                </td> -->
                                    <td>
                                        #<?php echo $request_details['savings_id'] ?>
                                    </td>
                                    <td>
                                        <?php echo date("F j, Y", strtotime($request_details['requested_at'])) ?>
                                    </td>
                                    <td>
                                        <?php
                                        $name = ucfirst($request_details['last_name'])  . " " . ucfirst($request_details['first_name']);
                                        echo $name;
                                        ?>
                                    </td>
                                    <td class="status-cell-<?php echo $request_details['savings_id'] ?>">
                                        <?php echo showStatus($request_details['status']) ?>
                                    </td>
                                    <td>
                                        NGN <?php echo number_format($request_details['installment_amount'], 2) ?>
                                    </td>
                                    <td>
                                        NGN <?php echo number_format($request_details['target_amount'], 2) ?>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="dropdown-toggle" data-dd-target="<?php echo $count ?>" aria-label="Dropdown Menu">
                                                o<br>o<br>o
                                            </button>
                                            <div style="font-size: 1rem;" class="dropdown-menu" data-dd-path="<?php echo $count ?>">
                                                <a class="dropdown-menu__link" href="request_details?sid=<?php echo $request_details['savings_id'] ?>">View request</a>
                                                <!-- <a class="dropdown-menu__link deleteEl" href="javascript:void(0)" data-productId="1"></a> -->
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                                $count += 2;
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
        $(function() {
            $(".savings-table").each(function() {
                $(this).DataTable({
                    "pageLength": 50
                });
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

                    $(`.tab-${selectedTabNo}`).addClass("active");
                });
            });
        });
    </script>
</body>

</html>