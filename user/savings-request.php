<?php
require(dirname(__DIR__) . '/auth-library/resources.php');
Auth::User("login");

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $savings_id = $_GET['id'];
    $products = array();

    $get_request_details = $db->query("SELECT savings_requests.*, agents.first_name as agent_first_name, agents.last_name as agent_last_name, agents.phone_no as agent_phone_no, agents.email as agent_email FROM 
    (savings_requests INNER JOIN agents ON savings_requests.agent_id=agents.agent_id) WHERE savings_id = {$savings_id}");

    $get_products = $db->query("SELECT savings_products.*, products.pictures as product_pictures, products.name as product_name FROM savings_products INNER JOIN products ON savings_products.product_id = products.product_id WHERE savings_id={$savings_id}");

    while ($product = $get_products->fetch_assoc()) {
        $product_picture = explode(",", $product['product_pictures'])[0];
        $product_object = array("product_name" => $product['product_name'], "product_picture" => $product_picture, "product_quantity" => $product['quantity']);

        array_push($products, $product_object);
    }

    $request_details = $get_request_details->fetch_assoc();
} else {
    header("location: ./");
}

function generateStatus($status)
{
    $html = "";

    switch ($status) {
        case "1":
            $html = '<span class="dot pending"> </span> pending';
            break;
        case "2":
            $html = '<span class="dot approved"> </span> approved';
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
    <!-- DASHBOARD MENU CSS -->
    <link rel="stylesheet" href="../assets/css/dashboard/user-dash-menu.css" />
    <!-- USER DASHBOARD STYLESHEET -->
    <link rel="stylesheet" href="../assets/css/dashboard/user-dash/index.css" />
    <!-- SAVINGS REQUEST CSS  -->
    <link rel="stylesheet" href="../assets/css/dashboard/user-dash/savings-request.css" />
    <!-- DASHHBOARD MEDIA QUERIES -->
    <link rel="stylesheet" href="../assets/css/media-queries/user-dash-mediaqueries.css" />
    <title> Savings Request (#<?= $savings_id ?>) - Halfcarry</title>
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
                    <h1 class="dashboard-main-title" style="font-size: 3rem;">Savings Request <span style="color: var(--primary-color);">(#<?= $savings_id ?>)</span></h1>

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
                    <ul class="savings-info">
                        <li class="savings-info-block">
                            <span class="savings-label">
                                Savings type:
                            </span>
                            <span class="savings-value">
                                <?= $request_details['type_of_savings'] === "1" ? "Normal Savings" : "Half savings" ?>
                            </span>
                        </li>
                        <li class="savings-info-block">
                            <span class="savings-label">
                                Duration:
                            </span>
                            <span class="savings-value">
                                <?php
                                $installment_type = $request_details['installment_type'];

                                if ($installment_type == "1") {
                                    echo $request_details['duration_of_savings'] . " days (NGN " . number_format($request_details['installment_amount'], 2) . "/day)";
                                } elseif ($installment_type == "2") {
                                    echo $request_details['duration_of_savings'] . " weeks (NGN " . number_format($request_details['installment_amount'], 2) . "/week)";
                                } else {
                                    echo $request_details['duration_of_savings'] . " months (NGN " . number_format($request_details['installment_amount'], 2) . "/month)";
                                }
                                ?>
                            </span>
                        </li>
                        <li class="savings-info-block">
                            <span class="savings-label">
                                Type of payment:
                            </span>
                            <span class="savings-value">
                                <?php
                                $installment_type = $request_details['installment_type'];

                                if ($installment_type == "1") {
                                    echo "Daily";
                                } elseif ($installment_type == "2") {
                                    echo "Weekly";
                                } else {
                                    echo "Monthly";
                                }
                                ?>
                            </span>
                        </li>
                        <li class="savings-info-block">
                            <span class="savings-label">
                                Amount to save:
                            </span>
                            <span class="savings-value">
                                NGN <?= number_format($request_details['target_amount'], 2) ?>
                            </span>
                        </li>
                        <li class="savings-info-block">
                            <span class="savings-label">
                                Agent:
                            </span>
                            <span class="savings-value">
                                <?= $request_details['agent_last_name'] . " " . $request_details['agent_first_name'] ?>
                            </span>
                        </li>
                        <li class="savings-info-block">
                            <span class="savings-label">
                                Agent Mobile No:
                            </span>
                            <span class="savings-value">
                                <?= $request_details['agent_phone_no'] ?>
                            </span>
                        </li>
                        <li class="savings-info-block">
                            <span class="savings-label">
                                Agent Email:
                            </span>
                            <span class="savings-value">
                                <?= $request_details['agent_email'] ?>
                            </span>
                        </li>
                        <li class="savings-info-block">
                            <span class="savings-label">
                                Status:
                            </span>
                            <span class="savings-value">
                                <?= generateStatus($request_details['status']) ?>
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