<?php
require(dirname(dirname(__DIR__)) . '/auth-library/resources.php');
AdminAuth::User("a/login");
$admin_id = $_SESSION['admin_id'];

if (isset($_GET['sid']) && !empty($_GET['sid'])) {
    $rid = $_GET['sid'];

    $products = array();

    $get_request_details = $db->query("SELECT savings_requests.*, agents.first_name as agent_first_name, agents.last_name as agent_last_name, agents.phone_no as agent_phone_no, agents.email as agent_email, users.first_name as users_first_name, users.last_name as users_last_name FROM 
    ((savings_requests INNER JOIN agents ON savings_requests.agent_id=agents.agent_id) INNER JOIN users ON savings_requests.user_id = users.user_id) WHERE savings_id = {$rid}");

    $get_products = $db->query("SELECT savings_products.*, products.pictures as product_pictures, products.name as product_name FROM savings_products INNER JOIN products ON savings_products.product_id = products.product_id WHERE savings_id={$rid}");

    while ($product = $get_products->fetch_assoc()) {
        $product_picture = explode(",", $product['product_pictures'])[0];
        $product_object = array("product_name" => $product['product_name'], "product_picture" => $product_picture, "product_quantity" => $product['quantity']);

        array_push($products, $product_object);
    }

    $request_details = $get_request_details->fetch_assoc();
} else {
    header("Location: ./all_savings");
}

function generateStatus($status)
{
    $html = "";

    switch ($status) {
        case "1":
            $html = '<span class="dot pending"> </span> pending';
            break;
        case "2":
            $html = '<span class="dot approved"> </span> granted';
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
    <!-- DROP DOWN MENU CSS -->
    <link rel="stylesheet" href="../../assets/css/dropdown.css" />
    <!-- Custom Fonts (Inter) -->
    <link rel="stylesheet" href="../../assets/fonts/fonts.css" />
    <!-- BASE CSS -->
    <link rel="stylesheet" href="../../assets/css/base.css" />
    <!-- ADMIN DASHBOARD MENU CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash-menu.css" />
    <!-- SAVINGS REQUEST DETAILS CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash/savings-request.css">
    <!-- DASHHBOARD MEDIA QUERIES -->
    <link rel="stylesheet" href="../../assets/css/media-queries/admin-dash-mediaqueries.css" />
    <title>Agent - Halfcarry Admin</title>
</head>

<body style="background-color: #fafafa">
    <div class="dash-wrapper">
        <?php
        include("includes/admin-sidebar.php");
        ?>
        <section class="page-wrapper">
            <header class="dash-header">
                <a href="./all_savings" class="back-link">
                    <i class="fa fa-arrow-left"></i>
                </a>
            </header>
            <div class="request-details-wrapper">
                <span class="request-id">
                    <i class="fa fa-handshake-o"></i>
                    #<?= $request_details['savings_id'] ?>
                </span>

                <h2 class="title"><?php echo ucfirst($request_details['users_last_name']) . " " . ucfirst($request_details['users_first_name']) ?>'s Request Details</h2>

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
                            Status:
                        </span>
                        <span class="savings-value">
                            <?= generateStatus($request_details['status']) ?>
                        </span>
                    </li>
                </ul>
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
    <!-- DROP DOWN JS -->
    <script type="text/javascript" src="../../assets/js/dropdown/dropdown.min.js"></script>
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
        });
    </script>
</body>

</html>