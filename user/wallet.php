<?php
require(dirname(__DIR__) . '/auth-library/resources.php');
Auth::User("login");

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

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

if (isset($_SESSION['amount_to_pay']) && isset($_SESSION['start_period']) && isset($_SESSION['end_period']) && isset($_SESSION['period_to_pay']) && isset($_SESSION['wallet_no'])) {
    // UNSETS AND DELETES ALL ENTRIES OF SET TRANSACTIOIN DETAILS
    unset($_SESSION['amount_to_pay']);
    unset($_SESSION['start_period']);
    unset($_SESSION['end_period']);
    unset($_SESSION['installment_type']);
    unset($_SESSION['period_to_pay']);
    unset($_SESSION['wallet_no']);
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
    <!-- CUSTOM FORMS CSS -->
    <link rel="stylesheet" href="../assets/css/form.css" />
    <!-- CUSTOM PAGINATE CSS -->
    <link rel="stylesheet" href="../assets/css/custom-paginate.css">
    <!-- DASHBOARD MENU CSS -->
    <link rel="stylesheet" href="../assets/css/dashboard/user-dash-menu.css" />
    <!-- USER DASHBOARD STYLESHEET -->
    <link rel="stylesheet" href="../assets/css/dashboard/user-dash/index.css" />
    <!-- SAVINGS REQUEST CSS  -->
    <link rel="stylesheet" href="../assets/css/dashboard/user-dash/wallet.css" />
    <!-- DASHHBOARD MEDIA QUERIES -->
    <link rel="stylesheet" href="../assets/css/media-queries/user-dash-mediaqueries.css" />
    <title> Wallet (#<?= $savings_id ?>) - Halfcarry</title>
</head>

<body>
    <!-- SPINNER -->
    <div class="spinner-wrapper">
        <div class="spinner-container">
            <img src="../assets/images/halfcarry-logo.jpeg" alt="Halfcarry Logo">
            <div class="spinner"></div>
        </div>
    </div>
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
                        <li>
                            <All class="dropdown-item" href="../all-products/">All products</a>
                        </li>
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
                                <ul class="savings-history <?= $get_savings_history->num_rows > 20? "paginated" : ""?>">
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
                </div>
            </div>
        </div>
    </main>
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
                                <input type="number" name="amount" id="amount" class="form-input" placeholder=" " value="<?= $to_pay ?>" disabled/>
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
    <script src="../assets/js/jquery/jquery-3.6.min.js"></script>
    <!-- JQUERY MIGRATE SCRIPT (FOR OLDER JQUERY PACKAGES SUPPORT)-->
    <script src="../assets/js/jquery/jquery-migrate-1.4.1.min.js"></script>
    <!-- JAVASCRIPT BUNDLER WITH POPPER -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <!-- JQUERY PAGINATE -->
    <script src="../assets/js/jquery.paginate.js"></script>
    <!-- CUSTOM DASHBOARD SCRIPT -->
    <script src="../assets/js/user-dash.js"></script>
    <!-- JUST VALIDATE LIBRARY -->
    <script src="../assets/js/just-validate/just-validate.js"></script>
    <script>
        const validation = new JustValidate("#credit-wallet-form", {
            errorFieldCssClass: "is-invalid",
        });

        validation
            .addField("#amount", [{
                rule: "required",
                errorMessage: "Field is required",
            }])
            .onSuccess((event) => {
                const savingsForm = document.querySelector("#credit-wallet-form");
                const formData = new FormData(savingsForm);


                formData.append("submit", true);
                formData.append("wid", <?= $request_details['wallet_no']?>)
                <?php
                    echo $to_pay_half? "formData.set('amount', $to_pay)" : "";
                ?>

                // PROCESS SAVINGS  
                $.ajax({
                    url: "controllers/process-savings.php",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $(".spinner-wrapper").addClass("active");
                        $(".credit-wallet-modal .credit-wallet-container .action-btn button").html("<i class='fa fa-spinner rotate'></i>")
                    },
                    success: function(response) {
                        response = JSON.parse(response);

                        if (response.success == 1) {
                            location.href = "./savings-preview";
                        } else {
                            $(".spinner-wrapper").removeClass("active");
                            $(".credit-wallet-modal .credit-wallet-container .action-btn button").html("Proceed to Pay");

                            Swal.fire({
                                title: "Savings Deposit",
                                icon: "error",
                                text: "Unable to process savings",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                            });
                        }
                    }
                });
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

        $(".savings-history-container .savings-history.paginated").paginate({
            scope: $(".savings-history-container .savings-history li"),
            paginatePosition: ['bottom'],
            perPage: 20
        });
    </script>
</body>

</html>