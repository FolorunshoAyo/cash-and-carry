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
    <!-- Custom Fonts (Inter) -->
    <link rel="stylesheet" href="../assets/fonts/fonts.css" />
    <!-- BASE CSS -->
    <link rel="stylesheet" href="../assets/css/base.css" />
    <!-- DASHBOARD MENU CSS -->
    <link rel="stylesheet" href="../assets/css/dashboard/user-dash-menu.css" />
    <!-- USER DASHBOARD STYLESHEET -->
    <link rel="stylesheet" href="../assets/css/dashboard/user-dash/index.css" />
    <!-- SAVINGS REQUEST CSS  -->
    <link rel="stylesheet" href="../assets/css/dashboard/user-dash/savings-request.css" />
    <!-- DASHHBOARD MEDIA QUERIES -->
    <link rel="stylesheet" href="../assets/css/media-queries/user-dash-mediaqueries.css" />
    <title> Savings Request (#123456) - Halfcarry</title>
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
                    <h1 class="dashboard-main-title" style="font-size: 3rem;">Savings Request <span style="color: var(--primary-color);">(#123456)</span></h1>

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
                    <ul class="savings-info">
                        <li class="savings-info-block">
                            <span class="savings-label">
                                Savings type:
                            </span>
                            <span class="savings-value">
                                Normal Savings
                            </span>
                        </li>
                        <li class="savings-info-block">
                            <span class="savings-label">
                                Duration:
                            </span>
                            <span class="savings-value">
                                3 Months
                            </span>
                        </li>
                        <li class="savings-info-block">
                            <span class="savings-label">
                                Type of payment:
                            </span>
                            <span class="savings-value">
                                Daily
                            </span>
                        </li>
                        <li class="savings-info-block">
                            <span class="savings-label">
                                Amount to save:
                            </span>
                            <span class="savings-value">
                                NGN 30,000.00
                            </span>
                        </li>
                        <li class="savings-info-block">
                            <span class="savings-label">
                                Agent:
                            </span>
                            <span class="savings-value">
                                Shodiya Folorunsho
                            </span>
                        </li>
                        <li class="savings-info-block">
                            <span class="savings-label">
                                Agent Mobilel No:
                            </span>
                            <span class="savings-value">
                                07087857141
                            </span>
                        </li>
                        <li class="savings-info-block">
                            <span class="savings-label">
                                Agent Email:
                            </span>
                            <span class="savings-value">
                                folushoayomide11@gmail.com
                            </span>
                        </li>
                        <li class="savings-info-block">
                            <span class="savings-label">
                                Status:
                            </span>
                            <span class="savings-value">
                                <span class="dot pending"> </span> pending
                            </span>
                        </li>
                    </ul>
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
    <!-- CUSTOM DASHBOARD SCRIPT -->
    <script src="../assets/js/user-dash.js"></script>
    <script>
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
    </script>
</body>

</html>