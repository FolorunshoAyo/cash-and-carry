<?php
require(dirname(dirname(__DIR__)) . '/auth-library/resources.php');
AgentAuth::User("a/login");

$agent_id = $_SESSION['agent_id'];


$agent_sql = $db->query("SELECT * FROM agents WHERE agent_id={$agent_id}");

if ($agent_sql->num_rows == 1) {
    $row_admin = $agent_sql->fetch_assoc();
} else {
    header("Location: ../login");
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $savings_id = $_GET['id'];
    $products = array();
    $months = array();

    $get_wallet_details = $db->query("SELECT * FROM savings_requests INNER JOIN store_wallets ON savings_requests.savings_id=store_wallets.wallet_no WHERE store_wallets.wallet_no = {$savings_id}");

    $get_products = $db->query("SELECT savings_products.*, products.pictures as product_pictures, products.name as product_name, products.duration_of_payment as duration_of_payment FROM savings_products INNER JOIN products ON savings_products.product_id = products.product_id WHERE savings_id={$savings_id}");

    while ($product = $get_products->fetch_assoc()) {
        $product_picture = explode(",", $product['product_pictures'])[0];
        $product_object = array("product_name" => $product['product_name'], "product_picture" => $product_picture, "product_quantity" => $product['quantity']);

        array_push($products, $product_object);
        array_push($months, $product['duration_of_payment']);
    }

    $savings_month = max($months);

    $request_details = $get_wallet_details->fetch_assoc();
} else {
    header("location: ./");
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
    <!-- Custom Fonts (Inter) -->
    <link rel="stylesheet" href="../../assets/fonts/fonts.css" />
    <!-- BASE CSS -->
    <link rel="stylesheet" href="../../assets/css/base.css" />
    <!-- FORM CSS -->
    <link rel="stylesheet" href="../../assets/css/form.css" />
    <!-- CUSTOM PAGINATE CSS -->
    <link rel="stylesheet" href="../../assets/css/custom-paginate.css">
    <!-- ADMIN DASHBOARD MENU CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash-menu.css" />
    <!-- ADMIN AGENT CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash/user-wallet.css">
    <!-- DASHHBOARD MEDIA QUERIES -->
    <link rel="stylesheet" href="../../assets/css/media-queries/admin-dash-mediaqueries.css" />
    <title>Wallet (#123456) - Halfcarry Agent</title>
</head>

<body style="background-color: #fafafa">
    <div class="dash-wrapper">
        <?php
        include("includes/agent-sidebar.php");
        ?>
        <section class="page-wrapper">
            <div class="wallet-wrapper">
                <div class="wallet-title-container">
                    <h1 class="dashboard-main-title" style="font-size: 3rem;">Wallet <span style="color: var(--primary-color);">(#<?= $savings_id ?>)</span></h1>
                    <button class="add-wallet-btn"><i class="fa fa-plus"></i> Add to wallet</button>
                </div>

                <?php
                if (count($products) > 1) {
                ?>
                    <div class="controls-container">
                        <button data-direction="prev" disabled><i class="fa fa-arrow-left"></i></button>
                        <button data-direction="next"><i class="fa fa-arrow-right"></i></button>
                    </div>
                <?php
                }
                ?>

                <div class="products-container">
                    <?php
                    foreach ($products as $key => $product) {
                        if ($key == 0) {
                    ?>
                            <div class="savings-product active">
                                <div class="savings-product-image-container">
                                    <img src="<?= $url ?>a/admin/images/<?= $product['product_picture'] ?>" alt="Web cam #1">
                                </div>
                                <div class="savings-product-details">
                                    <span class="savings-product-name"><?= $product['product_name'] ?></span>
                                    <span class="savings-product-qty">Qty: <?= $product['product_quantity'] ?></span>
                                </div>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="savings-product">
                                <div class="savings-product-image-container">
                                    <img src="<?= $url ?>a/admin/images/<?= $product['product_picture'] ?>" alt="Web cam #1">
                                </div>
                                <div class="savings-product-details">
                                    <span class="savings-product-name"><?= $product['product_name'] ?></span>
                                    <span class="savings-product-qty">Qty: <?= $product['product_quantity'] ?></span>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
                <div class="wallet-card">
                    <header class="wallet-header">
                        <div class="wallet-icon-container">
                            <i class="fa fa-archive"></i>
                        </div>
                        <div class="wallet-balance-container">
                            NGN <?= number_format($request_details['amount'], 2) ?>
                        </div>
                    </header>
                    <div class="wallet-progress">
                        <div class="progress-top">
                            <span class="days-left">
                                <?php
                                $time_left = $request_details['duration_of_savings'] - $request_details['paid_for'];
                                $installment_type = $request_details['installment_type'];

                                $period_suffix = $installment_type === "1" ? "days" : ($installment_type === "2" ? "weeks" : "months");

                                echo $time_left . " " . $period_suffix;
                                ?>
                                left
                            </span>

                            <span class="target-date">
                                <?php
                                $exp_date_of_completion = date("d F Y", strtotime($request_details['created_at'] . "+ $savings_month months"))
                                ?>
                                Exp. Date of Completion - <?= $exp_date_of_completion ?>
                            </span>
                        </div>
                        <?php
                        $progress_percentage = round(($request_details['amount'] / $request_details['target_amount']) * 100);
                        ?>
                        <div class="progress-thumb">
                            <div class="progress-pill" style="width: <?= $progress_percentage ?>%;"></div>
                        </div>
                        <?php

                        ?>
                        <div class="progress-bottom">
                            <span class="progress-percent">
                                <i class="fa fa-bullseye"></i> Your Target (<?= $progress_percentage ?>%)
                            </span>

                            <span class="wallet-target-amount">
                                ₦ <?= number_format($request_details['target_amount'], 2) ?>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="savings-history-container">
                    <h2 class="title">Savings History</h2>
                    <?php
                    $get_savings_history = $db->query("SELECT * FROM savings_history WHERE wallet_no = {$savings_id} AND payment_status = 1");

                    if ($get_savings_history->num_rows === 0) {
                    ?>
                        <p style="text-align: center; font-size: 1.5rem; color: var(--primary-color);">No savings history recorded</p>
                    <?php
                    } else {
                    ?>
                        <ul class="savings-history <?= $get_savings_history->num_rows > 20 ? "paginated" : "" ?>">
                            <?php
                            while ($savings_history_details = $get_savings_history->fetch_assoc()) {
                            ?>
                                <li>
                                    <div class="savings-history-icon-container">
                                        <i class="fa fa-plus"></i>
                                    </div>
                                    <div class="savings-history-info">
                                        <span class="saved-for">+ <?php echo $savings_history_details['paid_for'] . " " . $installment_type === "1" ? "days" : ($installment_type === "2" ? "weeks" : "months"); ?></span>
                                        <span class="deposited-by">Deposited by: <?= $request_details['deposited_by'] === "1" ? "You" : "Agent" ?></span>
                                        <span class="paid-date"><?= date("F, d Y", strtotime($savings_history_details['deposited_at'])) ?>Wednesday, 1 Dec 22</span>
                                    </div>
                                    <div class="savings-history-price">
                                        + ₦ <?= number_format($savings_history_details['amount'], 2) ?>
                                    </div>
                                </li>
                        <?php
                            }
                        }
                        ?>
                        </ul>
                </div>

                <div class="add-to-wallet-container">
                    <button class="add-wallet-btn"><i class="fa fa-plus"></i> Add to wallet</button>
                </div>
            </div>
        </section>
    </div>
    <div class="credit-wallet-modal">
        <div class="credit-wallet-container">
            <header>
                <h2>Credit Wallet</h2>
                <div class="close-container">
                    <i class="fa fa-times"></i>
                </div>
            </header>
            <section class="wallet-details-section">
                <p>Add to your savings to aquire your selected products by crediting your wallet.</p>

                <p><span>NGN <?= number_format($request_details['installment_amount'], 2) ?></span><sub>/<?= $installment_type === "1" ? "day" : ($installment_type === "2" ? "week" : "month"); ?></sub></p>
            </section>
            <div class="payment-form-container">
                <h2>Enter Transaction Details</h2>
                <form id="credit-wallet-form">
                    <div class="form-group-container">
                        <div class="form-group animate">
                            <?php
                            // AUTO POPULATE WEEKS TO BE CLEARED FOR HALF PAYMENT
                            $to_pay_half = $request_details['type_of_savings'] === "2" && $request_details['amount'] === "0.00";
                            if ($to_pay_half) {
                                $to_pay = round($request_details['duration_of_savings'] / 2);
                            ?>
                                <input type="number" name="amount" id="amount" class="form-input" placeholder=" " value="<?= $to_pay ?>" disabled />
                            <?php
                            } else {
                            ?>
                                <input type="number" name="amount" id="amount" class="form-input" placeholder=" " />
                            <?php
                            }
                            ?>
                            <label for="Amount">Number of <?= $period_suffix ?> to save</label>
                        </div>
                    </div>

                    <div class="action-btn">
                        <button type="submit">Proceed to Pay</button>
                    </div>
                </form>
            </div>
        </div>
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
    <!-- JQUERY PAGINATE -->
    <script src="../../assets/js/jquery.paginate.js"></script>
    <!-- DASHBOARD SCRIPT -->
    <script src="../../assets/js/admin-dash.js"></script>
    <script>
        $(function() {
            // ACTIVE SAVINGS REQUEST MODAL FUNCTIONALITY 
            let productCount = 1;
            $(document).on("click", ".controls-container button", function() {
                const btnClicked = $(this).attr("data-direction");
                const savingsProducts = $(".products-container .savings-product");

                if (btnClicked === "next") {
                    savingsProducts.each(function() {
                        $(this).removeClass("active");
                    });

                    productCount++;

                    ($(savingsProducts[productCount - 1]).addClass("active"));
                } else {
                    savingsProducts.each(function() {
                        $(this).removeClass("active");
                    });

                    productCount--;

                    ($(savingsProducts[productCount - 1]).addClass("active"));
                }

                if (productCount === 1) {
                    $(".controls-container button[data-direction = 'prev']").attr("disabled", true);
                    $(".controls-container button[data-direction = 'next']").attr("disabled", false);
                }

                if (productCount === savingsProducts.length) {
                    $(".controls-container button[data-direction = 'next']").attr("disabled", true);
                    $(".controls-container button[data-direction = 'prev']").attr("disabled", false);
                }
            });

            // CREDIT WALLET MODAL FUNCTIONALITY
            // --------------------------------
            $(".add-wallet-btn").on("click", function() {
                $(".credit-wallet-modal").addClass("active");
            });

            $(".credit-wallet-container .close-container").on("click", function() {
                $(".credit-wallet-modal").removeClass("active");
            });
            // -------------------------------

            $(".savings-history-container .savings-history.paginated").paginate({
                scope: $(".savings-history-container .savings-history li"),
                paginatePosition: ['bottom'],
                perPage: 10
            });
        });
    </script>
</body>

</html>