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
    <title> Wallet (#123456) - Halfcarry</title>
</head>

<body>
    <!-- SPINNER -->
    <div class="spinner-wrapper">
        <div class="spinner-container">
            <img src="assets/images/halfcarry-logo.jpeg" alt="Halfcarry Logo">
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
                            <All class="dropdown-item" href="#">All products</a>
                        </li>
                        <li><a class="dropdown-item" href="#">Active Wallets</a></li>
                        <li><a class="dropdown-item" href="#">Savings Request</a></li>
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
                            <h1 class="dashboard-main-title" style="font-size: 3rem;">Wallet <span style="color: var(--primary-color);">(#123456)</span></h1>
                            <button class="add-wallet-btn"><i class="fa fa-plus"></i> Add to wallet</button>
                        </div>

                        <div class="controls-container">
                            <button data-direction="prev" disabled><i class="fa fa-arrow-left"></i></button>
                            <button data-direction="next"><i class="fa fa-arrow-right"></i></button>
                        </div>
                        <div class="products-container">
                            <div class="savings-product active">
                                <div class="savings-product-image-container">
                                    <img src="<?= $url ?>assets/images/web-cam-1.jpg" alt="Web cam #1">
                                </div>
                                <div class="savings-product-details">
                                    <span class="savings-product-name">Web cam 2.0</span>
                                    <span class="savings-product-qty">Qty: 3</span>
                                </div>
                            </div>
                            <div class="savings-product">
                                <div class="savings-product-image-container">
                                    <img src="<?= $url ?>assets/images/web-cam-1.jpg" alt="Web cam #1">
                                </div>
                                <div class="savings-product-details">
                                    <span class="savings-product-name">Web cam 2.0</span>
                                    <span class="savings-product-qty">Qty: 5</span>
                                </div>
                            </div>
                        </div>

                        <div class="wallet-card">
                            <header class="wallet-header">
                                <div class="wallet-icon-container">
                                    <i class="fa fa-archive"></i>
                                </div>
                                <div class="wallet-balance-container">
                                    NGN 23,000
                                </div>
                            </header>
                            <div class="wallet-progress">
                                <div class="progress-top">
                                    <span class="days-left">
                                        6 months left
                                    </span>

                                    <span class="target-date">
                                        1 January 2024
                                    </span>
                                </div>
                                <div class="progress-thumb">
                                    <div class="progress-pill" style="width: 45%;"></div>
                                </div>
                                <div class="progress-bottom">
                                    <span class="progress-percent">
                                        <i class="fa fa-bullseye"></i> Your Target (88%)
                                    </span>

                                    <span class="wallet-target-amount">
                                        ₦300,000
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="savings-history-container">
                            <h2 class="title">Savings History</h2>
                            <ul class="savings-history">
                                <li>
                                    <div class="savings-history-icon-container">
                                        <i class="fa fa-plus"></i>
                                    </div>
                                    <div class="savings-history-info">
                                        <span class="saved-for">+ 3 weeks</span>
                                        <span class="paid-date">Wednesday, 1 Dec 22</span>
                                    </div>
                                    <div class="savings-history-price">
                                        + ₦3,000
                                    </div>
                                </li>
                                <li>
                                    <div class="savings-history-icon-container">
                                        <i class="fa fa-plus"></i>
                                    </div>
                                    <div class="savings-history-info">
                                        <span class="saved-for">+ 3 weeks</span>
                                        <span class="paid-date">Wednesday, 1 Dec 22</span>
                                    </div>
                                    <div class="savings-history-price">
                                        + ₦3,000
                                    </div>
                                </li>
                                <li>
                                    <div class="savings-history-icon-container">
                                        <i class="fa fa-plus"></i>
                                    </div>
                                    <div class="savings-history-info">
                                        <span class="saved-for">+ 3 weeks</span>
                                        <span class="paid-date">Wednesday, 1 Dec 22</span>
                                    </div>
                                    <div class="savings-history-price">
                                        + ₦3,000
                                    </div>
                                </li>
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

                <p><span>NGN 2,000</span><sub>/week</sub></p>
            </section>
            <div class="payment-form-container">
                <h2>Enter Transaction Details</h2>
                <form id="credit-wallet-form">
                    <div class="form-group-container">
                        <div class="form-group animate">
                            <input type="number" name="amount" id="amount" class="form-input" placeholder=" " required />
                            <label for="Amount">Number of weeks to save</label>
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

                for (const [key, value] of formData.entries()) {
                    console.log(`${key}: ${value}`);
                }

                // CREATE SAVINGS REQUEST
                $.ajax({
                    url: "../controllers/process-savings.php",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $(".spinner-wrapper").addClass("active");
                        $(".credit-wallet-section .credit-wallet-container .action-btn button").html("<i class='fa fa-spinner rotate'></i>")
                    },
                    success: function(response) {
                        response = JSON.parse(response);

                        if (response.success == 1) {
                            location.href = "./savings-preview";
                        } else {
                            $(".spinner-wrapper").addClass("active");
                            $(".credit-wallet-section .credit-wallet-container .action-btn button").html("<i class='fa fa-spinner rotate'></i>");

                            Swal.fire({
                                title: "Savings Deposit",
                                icon: "error",
                                text: "Unable to place savings request. Please try again.",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                            });
                        }
                    }
                });
            });

        // CREDIT WALLET MODAL FUNCTIONALITY
        // --------------------------------
        $(".add-wallet-btn").on("click", function(){
            $(".credit-wallet-modal").addClass("active");
        });

        $(".credit-wallet-container .close-container").on("click", function(){
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
            perPage: 10
        });
    </script>
</body>

</html>