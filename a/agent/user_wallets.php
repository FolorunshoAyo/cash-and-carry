<?php
require(dirname(dirname(__DIR__)) . '/auth-library/resources.php');
AgentAuth::User("a/login");

$agent_id = $_SESSION['agent_id'];


$admin_sql = $db->query("SELECT * FROM agents WHERE agent_id={$agent_id}");

if ($admin_sql->num_rows == 1) {
    $row_admin = $admin_sql->fetch_assoc();
} else {
    header("Location: ../login");
}

if (isset($_GET['uid']) && !empty($_GET['uid'])) {
    $uid = $_GET['uid'];

    $sql_agent_customer_details = $db->query("SELECT * FROM users WHERE user_id={$uid}");

    $customer_details = $sql_agent_customer_details->fetch_assoc();
} else {
    header("Location: ./");
}

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
    <!-- JQUERY DATATABLES CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <!-- DROP DOWN MENU CSS -->
    <link rel="stylesheet" href="../../assets/css/dropdown.css" />
    <!-- Custom Fonts (Inter) -->
    <link rel="stylesheet" href="../../assets/fonts/fonts.css" />
    <!-- BASE CSS -->
    <link rel="stylesheet" href="../../assets/css/base.css" />
    <!-- ADMIN DASHBOARD MENU CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash-menu.css" />
    <!-- ADMIN AGENT CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash/user-wallets.css">
    <!-- DASHHBOARD MEDIA QUERIES -->
    <link rel="stylesheet" href="../../assets/css/media-queries/admin-dash-mediaqueries.css" />
    <title>All <?= $customer_details['last_name'] . " " . $customer_details['first_name'] ?> - Halfcarry Agent</title>
</head>

<body style="background-color: #fafafa">
    <div class="dash-wrapper">
        <?php
        include("includes/agent-sidebar.php");
        ?>
        <section class="page-wrapper">
            <div class="list-wrapper">
                <h2 class="list-title">All <?= $customer_details['last_name'] . " " . $customer_details['first_name'] ?> Savings Assigned to you</h2>

                <?php
                $get_active_wallets = $db->query("SELECT store_wallets.*, savings_requests.duration_of_savings, savings_requests.type_of_savings, savings_requests.target_amount, savings_requests.installment_type FROM store_wallets INNER JOIN savings_requests ON store_wallets.wallet_no=savings_requests.savings_id WHERE store_wallets.user_id = {$uid} AND store_wallets.agent_id = {$agent_id} ORDER BY store_wallets.wallet_id DESC");

                $number_of_wallets = $get_active_wallets->num_rows;

                if ($number_of_wallets === 0) {
                ?>
                    <p style="font-size: 2rem; text-align: center; color: var(--primary-color);">No wallets</p>
                <?php
                } else {
                ?>
                    <div class="list-items-container wallets<?= ($number_of_wallets > 20) ? "__paginated" : "" ?>">
                        <?php
                        while ($wallet_details = $get_active_wallets->fetch_assoc()) {
                        ?>
                            <div class="savings-card">
                                <div class="savings-icon-container">
                                    <i class="fa fa-archive"></i>
                                </div>
                                <div class="savings-info-wrapper">
                                    <div class="savings-info-container">
                                        <a href="./wallet?id=<?= $wallet_details['wallet_no'] ?>" class="savings-request-id">#<?= $wallet_details['wallet_no'] ?></a>
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
                    }
                    ?>
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
    <!-- DROP DOWN JS -->
    <script type="text/javascript" src="../../assets/js/dropdown/dropdown.min.js"></script>
    <!-- DASHBOARD SCRIPT -->
    <script src="../../assets/js/admin-dash.js"></script>
    <script>
        $(function() {
            $(".list-items-container.wallets__paginated").paginate({
                scope: $(".savings-card"),
                paginatePosition: ['bottom'],
                perPage: 20
            });

        });
    </script>
</body>

</html>