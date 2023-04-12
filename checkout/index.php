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
        <div class="payment-plan-wrapper">
            <section class="payment-plan-container">
                <header>
                    <h1>Choose your plan</h1>
                    <a href="../user/">Back to dashboard</a>
                </header>
                <!-- <div class="controls-container">
                    <button data-direction="prev" disabled><i class="fa fa-arrow-left"></i></button>
                    <button data-direction="next"><i class="fa fa-arrow-right"></i></button>
                </div> -->
                <div class="products-container">
                    <div class="savings-product active">
                        <div class="savings-product-image-container">
                            <img src="../assets/images/web-cam-1.jpg" alt="Web cam #1">
                        </div>
                        <div class="savings-product-details">
                            <span class="savings-product-name">Web cam 2.0</span>
                            <span class="savings-product-qty">Qty: 3</span>
                        </div>
                    </div>
                    <div class="savings-product">
                        <div class="savings-product-image-container">
                            <img src="../assets/images/web-cam-1.jpg" alt="Web cam #1">
                        </div>
                        <div class="savings-product-details">
                            <span class="savings-product-name">Web cam 2.0</span>
                            <span class="savings-product-qty">Qty: 3</span>
                        </div>
                    </div>
                </div>
                <form>
                    <div class="payment-plans">
                        <input type="radio" name="payment-plan" value="1" id="payment-plan-1" />
                        <label for="payment-plan-1" class="payment-plan">
                            <div class="radio-container">
                                <div class="custom-radio"></div>
                            </div>
                            <div class="payment-plan-info">
                                <h3>Daily payment</h3>
                                <p>Save daily to aquire this product</p>
                                <p><sup>₦</sup> <span> 100.00 </span><sub>/day</sub></p>
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
                                <p><sup>₦</sup> <span> 900.00 </span><sub>/week</sub></p>
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
                                <p><sup>₦</sup> <span> 400 </span><sub>/month</sub></p>
                            </div>
                        </label>
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
                        <div class="payment-action-btns">
                            <button class="btn" type="submit">Proceed</button>
                            <a href="javascript:void(0)">close</a>
                        </div>
                    </div>

                </form>
            </section>
        </div>
    </main>
    <!-- FONT AWESOME JIT SCRIPT-->
    <script src="https://kit.fontawesome.com/3ae896f9ec.js" crossorigin="anonymous"></script>
    <!-- JQUERY SCRIPT -->
    <script src="../assets/js/jquery/jquery-3.6.min.js"></script>
    <!-- JQUERY MIGRATE SCRIPT (FOR OLDER JQUERY PACKAGES SUPPORT)-->
    <script src="../assets/js/jquery/jquery-migrate-1.4.1.min.js"></script>
    <script>
        let selectedOrder = "";
        const orderBtnContainer = $(".order-btn-container");
        const $paymentPlanDialogCloseBtn = $(".payment-action-btns a");

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