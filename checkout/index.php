<?php
require(dirname(__DIR__) . '/auth-library/resources.php');
Auth::User("login");

$userID = $_SESSION['user_id'];

if (isset($_SESSION['shopping_cart']) && !empty($_SESSION['shopping_cart'])) {
    $shopping_cart = $_SESSION['shopping_cart'];

    $sql_user_address = $db->query("SELECT *
    FROM addresses INNER JOIN users_addresses ON 
    addresses.address_id = users_addresses.address_id WHERE user_id={$userID} AND active=1");

    $sql_user_email_sql = $db->query("SELECT email FROM users WHERE user_id={$userID}");

    $email = $sql_user_email_sql->fetch_assoc()['email'];

    $_SESSION['email'] = $email;
} else {
    header("location: ../cart");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Custom Fonts (Inter) -->
    <link rel="stylesheet" href="../assets/fonts/fonts.css">
    <!-- BASE CSS -->
    <link rel="stylesheet" href="../assets/css/base.css">
    <!-- CUSTOM FORMS CSS -->
    <link rel="stylesheet" href="../assets/css/form.css" />
    <!-- CUSTOM CSS (HOME) -->
    <link rel="stylesheet" href="../assets/css/index.css" type="text/css" />
    <!-- CONFIRMATION CSS -->
    <link rel="stylesheet" href="../assets/css/checkout.css">
    <!-- MEDIA QUERIES -->
    <link rel="stylesheet" href="../assets/css/media-queries/main-media-queries.css">
    <title>Checkout - Codeweb store</title>
</head>

<body>
    <div class="full-loader">
        <div class="spinner"></div>
    </div>
    <header class="checkout-header">
        <div class="header-title-container">
            <h1>Confirm & Order</h1>
        </div>
        <div class="cancel-container">
            <a href="../cart/">
                <i class="fa fa-times"></i>
            </a>
        </div>
    </header>
    <main>
        <div class="order-container">
            <section class="product-info-container">
                <div class="products">
                    <?php
                    $total_amount = 0;

                    foreach ($_SESSION['shopping_cart'] as $key => $values) {
                        $total_amount += $values['product_quantity'] * $values['product_price'];
                    ?>
                        <div class="product">
                            <div class="product-image-container">
                                <img src="<?= $values['product_image'] ?>" alt="Iphone Green">
                            </div>
                            <div class="order-information">
                                <span class="product-name"><?= $values['product_name'] ?></span>
                                <span class="product-quantity">Quantity: <?= $values['product_quantity'] ?></span>
                                <span class="product-price-single">₦ <?= number_format($values['product_quantity'] * $values['product_price'], 2) ?></span>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </section>
            <section class="user-details">
                <div class="info-card">
                    <h2 class="card-title">
                        User Checkout
                    </h2>
                    <div class="card-body">
                        <p>
                            <i class="fa fa-home"></i>
                            <?php echo $email; ?>
                        </p>
                    </div>
                </div>
                <div class="info-card">
                    <h2 class="card-title">
                        Shipping Information
                    </h2>
                    <div class="card-body">
                        <?php
                        if ($sql_user_address->num_rows === 0) {
                        ?>
                            <p>You do not have an address yet. Click <a href="../user/add-address">here</a> to create one.</p>
                        <?php
                        } else {
                            $address_details = $sql_user_address->fetch_assoc();
                        ?>
                            <p>
                                <i class="fa fa-user"></i>
                                <?php echo $address_details['recipient_name'] ?>
                            </p>
                            <p>
                                <i class="fa fa-home"></i>
                                <?php echo $address_details['delivery_address'] . ", " . $address_details['city_name'] . ". " . $address_details['address_state'] . "." ?>
                            </p>
                            <p>
                                <i class="fa fa-phone"></i>
                                <?php echo $address_details['recipient_phone_no'] ?>
                            </p>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="info-card">
                    <h2 class="card-title">
                        Payment
                    </h2>
                    <div class="card-body">
                        <form id="payment-form">
                            <p>
                                <label for="card-radio">
                                    <input type="radio" name="payment-method" value="card" id="card-radio" checked>
                                    <i class="fa fa fa-credit-card"></i>
                                    Pay by credit card (default)
                                </label>
                            </p>
                            <p>
                                <label for="cash-radio">
                                    <input type="radio" name="payment-method" id="cash-radio" value="cash">
                                    <i class="fa fa-money"></i>
                                    Cash on delivery
                                </label>
                            </p>
                        </form>
                    </div>
                </div>
                <div class="sum-container">
                    <p>
                        <span class="title">Subtotal:</span>
                        ₦ <?php echo number_format($total_amount) ?>
                    </p>
                    <p>
                        <span class="title"><b>Total Price:</b></span>
                        <b style="color: var(--primary-color)">₦ <?php echo number_format($total_amount) ?></b>
                    </p>
                </div>
                <div class="order-btn-container">
                    <button>
                        Start Saving
                    </button>
                    <button>
                        <i class="fa fa-credit-card"></i>
                        Process your order
                    </button>
                </div>
            </section>
        </div>
        <?php
        if (isset($_SESSION['shopping_cart'])) {
        ?>
            <div class="payment-plan-wrapper">
                <section class="payment-plan-container">
                    <header>
                        <h2>Choose your plan</h2>
                        <a href="javascript:void(0)">close</a>
                    </header>
                    <section class="products-section">
                        <?php
                        if (count($_SESSION['shopping_cart']) > 1) {
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
                            $productMonths = array();
                            $productPrices = array();
                            foreach ($_SESSION['shopping_cart'] as $key => $values) {
                                $product_id = $values['product_id'];
                                $sql_get_product_savings_duration = $db->query("SELECT price,duration_of_payment FROM products WHERE product_id = {$product_id}");

                                // SAVINGS DURATION OF EACH PRODUCT
                                $product_details = $sql_get_product_savings_duration->fetch_assoc();
                                $product_savings_duration = intval($product_details['duration_of_payment']);
                                $product_price = $product_details['price'];

                                array_push($productMonths, $product_savings_duration);
                                array_push($productPrices, ($product_price * $values['product_quantity']));

                                if ($key == 0) {
                            ?>
                                    <div class="savings-product active">
                                        <div class="savings-product-image-container">
                                            <img src="<?= $values['product_image'] ?>" alt="<?= $values['product_name'] ?>">
                                        </div>
                                        <div class="savings-product-details">
                                            <span class="savings-product-name"><?= $values['product_name'] ?></span>
                                            <span class="savings-product-qty">Qty: <?= $values['product_quantity'] ?></span>
                                        </div>
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div class="savings-product">
                                        <div class="savings-product-image-container">
                                            <img src="<?= $values['product_image'] ?>" alt="<?= $values['product_name'] ?>">
                                        </div>
                                        <div class="savings-product-details">
                                            <span class="savings-product-name"><?= $values['product_name'] ?></span>
                                            <span class="savings-product-qty">Qty: <?= $values['product_quantity'] ?></span>
                                        </div>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </section>
                    <?php
                    // DETERMINING MAXIMUM SAVINGS PERIOD AND TOTAL PRODUCT PRICES PLUS INTTEREST
                    $max_month = max($productMonths);
                    $total_price = 0;

                    foreach ($productPrices as $price) {
                        $total_price += $price;
                    }

                    // CALCUALTING INTEREST
                    $final_price = (20 / 100) * $total_price + $total_price;

                    $daysWeeksMonths = getDaysWeeks($max_month);

                    ?>
                    <form id="savings-form">
                        <div class="payment-plans">
                            <div id="required-radio-container">
                                <input type="radio" name="payment-plan" value="1" id="payment-plan-1" />
                                <label for="payment-plan-1" class="payment-plan">
                                    <div class="radio-container">
                                        <div class="custom-radio"></div>
                                    </div>
                                    <div class="payment-plan-info">
                                        <h3>Daily payment</h3>
                                        <p>Save daily to aquire this product</p>
                                        <p><sup>₦</sup> <span> <?= number_format(($final_price / $daysWeeksMonths['days']), 2) ?> </span><sub>/day</sub></p>
                                    </div>
                                </label>
                                <input type="radio" name="payment-plan" value="2" id="payment-plan-2" />
                                <label for="payment-plan-2" class="payment-plan">
                                    <div class="radio-container">
                                        <div class="custom-radio"></div>
                                    </div>
                                    <div class="payment-plan-info">
                                        <h3>Weekly payment</h3>
                                        <p>Save weekly to aquire this product</p>
                                        <p><sup>₦</sup> <span> <?= number_format(($final_price / $daysWeeksMonths['weeks']), 2) ?> </span><sub>/week</sub></p>
                                    </div>
                                </label>
                                <input type="radio" name="payment-plan" value="3" id="payment-plan-3" />
                                <label for="payment-plan-3" class="payment-plan">
                                    <div class="radio-container">
                                        <div class="custom-radio"></div>
                                    </div>
                                    <div class="payment-plan-info">
                                        <h3>Monthly payment</h3>
                                        <p>Save monthly to aquire this product</p>
                                        <p><sup>₦</sup> <span> <?= number_format(($final_price / $daysWeeksMonths['months']), 2) ?> </span><sub>/month</sub></p>
                                    </div>
                                </label>
                            </div>
                            <div class="form-group-container">
                                <div class="form-group animate">
                                    <select name="agent_id" id="agent_id">
                                        <option value="">Choose manager</option>
                                        <?php
                                        $sql_get_all_agents = $db->query("SELECT * FROM agents");

                                        while ($agent_details = $sql_get_all_agents->fetch_assoc()) {
                                        ?>
                                            <option value="<?= $agent_details['agent_id'] ?>"><?= $agent_details['last_name'] . " " . $agent_details['first_name'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <label for="agent_id">Select Relationship Manager</label>
                                </div>
                            </div>

                            <div class="savings-action-btn-container">
                                <button class="btn" type="submit">Proceed</button>
                            </div>
                        </div>
                    </form>
                    <footer class="modal-footer">
                        <div class="total-amount-container">
                            Amount to save: <br> <span class="total-amount">NGN <?= number_format($final_price, 2) ?></span>
                        </div>
                        <a href="<?= $url ?>user/">Back to dashboard</a>
                    </footer>
                </section>
            </div>
        <?php
        }
        ?>
    </main>
    <!-- FONT AWESOME JIT SCRIPT-->
    <script src="https://kit.fontawesome.com/3ae896f9ec.js" crossorigin="anonymous"></script>
    <!-- JQUERY SCRIPT -->
    <script src="../assets/js/jquery/jquery-3.6.min.js"></script>
    <!-- JQUERY MIGRATE SCRIPT (FOR OLDER JQUERY PACKAGES SUPPORT)-->
    <script src="../assets/js/jquery/jquery-migrate-1.4.1.min.js"></script>
    <!-- JUST VALIDATE LIBRARY -->
    <script src="../assets/js/just-validate/just-validate.js"></script>
    <script>
        function activateSavingsValidator() {
            const validation = new JustValidate("#savings-form", {
                errorFieldCssClass: "is-invalid",
            });

            validation
                .addRequiredGroup("#required-radio-container", "Please select an option")
                .addField("#agent_id", [{
                    rule: "required",
                    errorMessage: "Field is required",
                }])
                .onSuccess((event) => {
                    console.log(event);
                });
        }

        activateSavingsValidator();

        let selectedOrder = "";
        const orderBtnContainer = $(".order-btn-container");
        const $paymentPlanDialogCloseBtn = $(".payment-plan-container header a");

        $paymentPlanDialogCloseBtn.on("click", function() {
            $(".payment-plan-wrapper").toggleClass("active");
        });

        $(".order-btn-container button:nth-of-type(1)").on("click", function() {
            $(".payment-plan-wrapper").addClass("active");
        });

        $("[name='payment-method']").each(function() {
            const radioBtn = $(this);

            radioBtn.click(function() {
                if (radioBtn.val() === "cash") {
                    selectedOrder = "cash";
                    orderBtnContainer.children()[1].remove();

                    orderBtnContainer.append(`<button>
                        <i class="fa fa-money"></i>
                        Place Your Order
                    </button>`);
                } else {
                    selectedOrder = "card";
                    orderBtnContainer.children()[1].remove();
                    orderBtnContainer.append(`<button>
                        <i class="fa fa-credit-card"></i>
                        Process Your Order
                    </button>`);
                }
            });
        });

        $(document).on("click", ".order-btn-contaiiner button:nth-of-type(2)", function() {
            if (selectedOrder === "card") return;

            const formData = new FormData();

            formData.append("submit", true);
            formData.append("pid", <?php //echo $selectedProductDetails['pid'] 
                                    ?>);
            formData.append("uid", <?php //echo $userID 
                                    ?>);
            formData.append("amount", <?php //echo $qty 
                                        ?>);
            formData.append("total", <?php //echo $total 
                                        ?>);

            $.ajax({
                url: "./controllers/process-order.php",
                type: "post",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $(".full-loader").addClass("active");
                },
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.success === 1) {
                        location.replace("./checkout_success");
                    } else {
                        // ALERT USER
                        Swal.fire({
                            title: response.error_title,
                            icon: "error",
                            text: response.error_msg,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        });

                        $(".full-loader").removeClass("active");
                    }
                }
            });


        });
    </script>
</body>

</html>