<?php
require(dirname(__DIR__) . '/auth-library/resources.php');

// NUMBER FORMATTER
// $human_readable = new \NumberFormatter(
//   'en_US', 
//   \NumberFormatter::PADDING_POSITION
// );
$url = strval($url);

$inSession = (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) || (isset($_SESSION['user_name']) && !empty($_SESSION['user_name']));

if ($inSession) {
    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
}

//   if(isset($_GET['pid']) && !empty($_GET['pid'])){
//     $pid = $_GET['pid'];

//     $sql_product = $db->query("SELECT * FROM products WHERE product_id={$pid}");
//     $sql_product_meta = $db->query("SELECT * FROM product_meta WHERE product_id={$pid}");

//     $product_details = $sql_product->fetch_assoc();
//     $product_meta_details = $sql_product_meta->fetch_assoc();
//   }else{
//     header("Location: ./");
//   }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Custom Fonts (Inter) -->
    <link rel="stylesheet" href="../assets/fonts/fonts.css" />
    <!-- IZITOAST CSS -->
    <link rel="stylesheet" href="../auth-library/vendor/dist/css/iziToast.min.css">
    <!-- BASE CSS -->
    <link rel="stylesheet" href="../assets/css/base.css" />
    <!-- CUSTOM FORMS CSS -->
    <link rel="stylesheet" href="../assets/css/form.css" />
    <!-- CUSTOM CSS (HOME) -->
    <link rel="stylesheet" href="../assets/css/index.css" type="text/css" />
    <!-- PRODUCT PAGE CSS -->
    <link rel="stylesheet" href="../assets/css/cart.css" type="text/css" />
    <!-- MEDIA QUERIES -->
    <link rel="stylesheet" href="../assets/css/media-queries/main-media-queries.css" />
    <title>Cart - Halfcarry</title>
</head>

<body>
    <?php
    include_once("../includes/cart.php");
    include_once("../includes/savings-request-modal.php");
    include_once("../includes/header.php");
    ?>
    <main>
        <section class="cart-section">
            <div class="cart-container">
                <div class='spinner-wrapper active'>
                    <div class='spinner-container'>
                        <img src='../assets/images/halfcarry-logo.jpeg' alt='Halfcarry Logo'>
                        <div class='spinner'></div>
                    </div>
                </div>
                <?php
                if (empty($_SESSION['shopping_cart'])) {
                ?>
                    <div class="empty-cart-container">
                        <p>No Items in Cart</p>
                        <a href="../all-products/">Back to store</a>
                    </div>
                <?php
                } else {
                ?>
                    <div class="cart-action-section">
                        <span>Cart Item (<span id="cart-number"><?php echo count($_SESSION['shopping_cart']) ?></span>)</span>
                        <button class="btn" disabled>Update Cart</button>
                    </div>

                    <div class="labels">
                        <span>item</span>
                        <span>quantity</span>
                        <span>unit price</span>
                        <span>sub total</span>
                    </div>

                    <div class="cart-items">
                        <?php
                        $total_price = 0;
                        foreach ($_SESSION['shopping_cart'] as $keys => $values) {
                            $product_sub_total = $values['product_price'] * $values['product_quantity'];
                        ?>
                            <div class="cart-item">
                                <div data-label="Item" class="product-info">
                                    <img src="<?php echo $values['product_image'] ?>" alt="<?= $values['product_name'] ?>">
                                    <div class="details">
                                        <p><a href="../product/?pid=<?= $values['product_id'] ?>"><?= $values['product_name'] ?></a></p>
                                        <div class="action-btn-container">
                                            <button data-product-id="<?= $values['product_id'] ?>"><i class="fa fa-trash-o"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div data-label="Quantity">
                                    <input type="number" min="1" max="50" value="<?= $values['product_quantity'] ?>" class="amount" data-product-id="<?= $values['product_id'] ?>">
                                </div>
                                <div data-label="Unit-price">
                                    ₦ <?= number_format($values['product_price'], 2) ?>
                                </div>
                                <div data-label="Sub-total">
                                    ₦ <?= number_format($product_sub_total, 2) ?>
                                </div>
                            </div>

                        <?php
                            $total_price += $product_sub_total;
                        }
                        ?>

                    </div>

                    <div class="total-container">
                        Total: <span> ₦ <?= number_format($total_price, 2) ?> </span> <br> <br>
                        Delivery fee not included.
                    </div>

                    <div class="cart-action-btn-container">
                        <div>
                            <a href="../all-products/" class="btn">
                                <i class="fa fa-arrow-left"></i>
                                Return to shop
                            </a>
                        </div>
                        <div>
                            <a href="../checkout/" class="btn">Proceed to checkout</a>
                            <button class="btn">Start Saving</button>
                        </div>
                    </div>

                <?php
                }
                ?>
            </div>
        </section>
        <?php
        if (isset($_SESSION['shopping_cart'])) {
        ?>
            <div class="payment-plan-wrapper">
                <section class="payment-plan-container">
                    <header>
                        <h1>Choose your plan</h1>
                        <a href="<?= $url ?>user/">Back to dashboard</a>
                    </header>
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
                            array_push($productPrices, $product_price);

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

                            <div class="payment-action-btns">
                                <button class="btn" type="submit">Proceed</button>
                                <a href="javascript:void(0)">close</a>
                            </div>
                        </div>

                    </form>
                </section>
            </div>
        <?php
        }
        ?>
    </main>
    <?php
    include("../includes/footer.php");
    ?>
    <!-- FONT AWESOME JIT SCRIPT -->
    <script src="https://kit.fontawesome.com/3ae896f9ec.js" crossorigin="anonymous"></script>
    <!-- JQUERY SCRIPT -->
    <script src="../assets/js/jquery/jquery-3.6.min.js"></script>
    <!-- JQUERY MIGRATE SCRIPT (FOR OLDER JQUERY PACKAGES SUPPORT)-->
    <script src="../assets/js/jquery/jquery-migrate-1.4.1.min.js"></script>
    <!-- SLICK SLIDER SCRIPT -->
    <script src="../assets/js/slick/slick.js"></script>
    <!-- IZI TOAST SCRIPT -->
    <script src="../auth-library/vendor/dist/js/iziToast.min.js"></script>
    <!-- JUST VALIDATE LIBRARY -->
    <script src="../assets/js/just-validate/just-validate.js"></script>
    <script>
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

        function displayActiveRequest() {
            $(".savings-request-modal-wrapper").addClass("active");
        }

        $(function() {
            const menuContainer = document.querySelector(".menu-container a");
            menuContainer.addEventListener("click", toggle);

            const cartBtn = document.querySelector(".cart-link");
            const cartBackdrop = document.querySelector(".cart-backdrop");
            const cartMenu = document.querySelector(".cart-menu");
            const cartClose = document.querySelector(".close-container i");

            cartBtn.addEventListener("click", function() {
                cartMenu.classList.toggle("active");
                cartBackdrop.classList.toggle("active");
            });

            cartClose.addEventListener("click", function() {
                cartMenu.classList.toggle("active");
                cartBackdrop.classList.toggle("active");
            });

            cartBackdrop.addEventListener("click", function() {
                cartMenu.classList.toggle("active");
                cartBackdrop.classList.toggle("active");
            }, false);

            function toggle(e) {
                e.stopPropagation();
                var link = this;
                var menu = link.nextElementSibling;

                if (!menu) return;
                if (menu.style.display !== 'block') {
                    menu.style.display = 'block';
                } else {
                    menu.style.display = 'none';
                }
            };

            function closeAll() {
                menuContainer.nextElementSibling.style.display = 'none';
            };

            window.onclick = function(event) {
                closeAll.call(event.target);
            };

            $(document).on("click", ".payment-action-btns a", function() {
                $(".payment-plan-wrapper").toggleClass("active");
            });

            <?php
            if ($inSession) {
            ?>

                $(".cart-action-btn-container button.btn").on("click", function() {
                    const formData = new FormData();

                    formData.append("submit", true);

                    // FETCH SAVINGS DETAILS
                    $.ajax({
                        url: "controllers/generate-savings-plans.php",
                        method: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            $(".spinner-wrapper").addClass("active");
                        },
                        success: function(data) {
                            $("section.payment-plan-container").html(data);
                            $(".spinner-wrapper").removeClass("active");
                        }
                    });

                    $(".payment-plan-wrapper").addClass("active");
                });

            <?php
            } else {
            ?>

                $(".cart-action-btn-container .btn").on("click", function() {
                    // ALERT ADMIN
                    Swal.fire({
                        title: "Savings Error",
                        icon: "error",
                        text: "You need to login to use this action.",
                        showCancelButton: true,
                        confirmButtonText: 'Login',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        confirmButtonColor: '#2366B5',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // REDIRECT USER TO LOGIN PAGE
                            location.replace("./login");
                        }
                    });
                });

            <?php
            }
            ?>

            load_cart_data();

            function load_cart_data() {
                $.ajax({
                    url: "../controllers/fetch-cart.php",
                    method: "POST",
                    dataType: "json",
                    beforeSend: function() {
                        $(".spinner-wrapper").addClass("active");
                    },
                    success: function(data) {
                        $(".spinner-wrapper").removeClass("active");
                        if (data.total_item === 0) {
                            $(".cart-menu-items-container").html(data.cart_details);
                            $('.cart-badge').text("0");
                        } else {
                            $('.cart-menu-items-container').html(data.cart_details);
                            $('.cart-badge').text(data.total_item);
                        }
                    }
                });
            }

            var updatedProducts = []; // CONTAINS A LIST OF ALL THE UPDATED PRODUCTS AND THEIR QUANTITIES

            $(document).on("click", ".cart-action-section button.btn", function() {
                $.ajax({
                    url: "controllers/cart-controller.php",
                    method: "POST",
                    data: {
                        action: "update",
                        product_details: updatedProducts
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $(".spinner-wrapper").addClass("active");
                    },
                    success: function() {
                        $(".spinner-wrapper").removeClass("active");
                        iziToast.success({
                            title: "Cart successfuly updated",
                            timeout: 3000,
                            backgroundColor: 'green',
                            theme: 'dark',
                            position: 'topRight'
                        });
                        load_cart_data_2();
                        load_cart_data();
                    }
                });
            });

            // EVENT FIRED ON NORMAL NUMBER CHANGE
            $(document).on("change", ".amount", function() {
                const product_quantity = $(this).val();
                const product_id = $(this).attr("data-product-id");


                // ENABLE UPDATE BUTTON
                // console.log(Numbe);
                if (Number(product_quantity) > 0) {
                    enableUpdateCartButton();

                    if (updatedProducts.length == 0) {
                        updatedProducts.push({
                            product_id,
                            product_quantity
                        });
                    } else {
                        updatedProducts.forEach((item, index) => {
                            if (updatedProducts.some((item) => item.product_id == product_id)) {
                                updatedProducts[index] = {
                                    product_id,
                                    product_quantity
                                }
                            } else {
                                updatedProducts.push({
                                    product_id,
                                    product_quantity
                                });
                            }
                        });
                    }
                } else {
                    disableUpdateCartButton();
                }
            });

            // EVENT FIRED ON DIRECT KEYBOARD CHANGE
            $(document).on("keyup", ".amount", function() {
                const product_quantity = $(this).val();
                const product_id = $(this).attr("data-product-id");


                // ENABLE UPDATE BUTTON
                // console.log(Numbe);
                if (Number(product_quantity) > 0) {
                    console.log("product quantity isn't zero");

                    enableUpdateCartButton();

                    if (updatedProducts.length == 0) {
                        updatedProducts.push({
                            product_id,
                            product_quantity
                        });
                    } else {
                        updatedProducts.forEach((item, index) => {
                            if (updatedProducts.some((item) => item.product_id == product_id)) {
                                updatedProducts[index] = {
                                    product_id,
                                    product_quantity
                                }
                            } else {
                                updatedProducts.push({
                                    product_id,
                                    product_quantity
                                });
                            }
                        });
                    }
                } else {
                    console.log("product quantity is zero");
                    disableUpdateCartButton();
                }
            });

            function enableUpdateCartButton() {
                $(".cart-action-section button.btn").attr("disabled", false);
            }

            function disableUpdateCartButton() {
                $(".cart-action-section button.btn").attr("disabled", true);
            }

            function load_cart_data_2() {
                $.ajax({
                    url: "controllers/fetch-cart.php",
                    method: "POST",
                    dataType: "json",
                    beforeSend: function() {
                        $(".spinner-wrapper").addClass("active");
                    },
                    success: function(data) {
                        $(".spinner-wrapper").removeClass("active");
                        $(".cart-container").html(data.cart_details);
                    }
                });
            }

            $(document).on("click", ".cart-item .details .action-btn-container button", function() {
                var product_id = $(this).attr("data-product-id");
                var action = "remove";

                if (confirm("Are you sure you want to remove this product from cart?")) {
                    $.ajax({
                        url: "controllers/cart-controller.php",
                        method: "POST",
                        data: {
                            product_id: product_id,
                            action: action
                        },
                        beforeSend: function() {
                            $(".spinner-wrapper").addClass("active");
                        },
                        success: function() {
                            $(".spinner-wrapper").removeClass("active");
                            iziToast.error({
                                title: "Item removed from cart",
                                timeout: 3000,
                                backgroundColor: 'red',
                                theme: 'dark',
                                position: 'topRight'
                            });
                            load_cart_data();
                            load_cart_data_2();
                        }
                    })
                } else {
                    return;
                }
            });

            $(document).on('click', '.close-btn-container button', function() {
                var product_id = $(this).attr("data-product-id");
                var action = 'remove';
                if (confirm("Are you sure you want to remove this product?")) {
                    $.ajax({
                        url: "controllers/cart-controller.php",
                        method: "POST",
                        data: {
                            product_id: product_id,
                            action: action
                        },
                        beforeSend: function() {
                            $(".spinner-wrapper").addClass("active");
                        },
                        success: function() {
                            $(".spinner-wrapper").removeClass("active");
                            iziToast.error({
                                title: "Item removed from cart",
                                timeout: 3000,
                                backgroundColor: 'red',
                                theme: 'dark',
                                position: 'topRight'
                            });
                            load_cart_data();
                            load_cart_data_2();
                        }
                    });
                } else {
                    return false;
                }
            });

            // SAVINGS PLAN MODAL FUNCTIONALITY 
            let savingsProductCount = 1;
            $(document).on("click", ".payment-plan-container .controls-container button", function() {
                const btnClicked = $(this).attr("data-direction");
                const savingsProducts = $(".payment-plan-container .products-container .savings-product");

                if (btnClicked === "next") {
                    savingsProducts.each(function() {
                        $(this).removeClass("active");
                    });

                    savingsProductCount++;

                    ($(savingsProducts[savingsProductCount - 1]).addClass("active"));
                } else {
                    savingsProducts.each(function() {
                        $(this).removeClass("active");
                    });

                    savingsProductCount--;

                    ($(savingsProducts[savingsProductCount - 1]).addClass("active"));
                }

                if (savingsProductCount === 1) {
                    $(".payment-plan-container .controls-container button[data-direction = 'prev']").attr("disabled", true);
                    $(".payment-plan-container .controls-container button[data-direction = 'next']").attr("disabled", false);
                }

                if (savingsProductCount === savingsProducts.length) {
                    $(".payment-plan-container .controls-container button[data-direction = 'next']").attr("disabled", true);
                    $(".payment-plan-container .controls-container button[data-direction = 'prev']").attr("disabled", false);
                }
            });

            // ACTIVE SAVINGS REQUEST MODAL FUNCTIONALITY 
            let requestProductCount = 1;
            $(document).on("click", ".savings-request-modal .controls-container button", function() {
                const btnClicked = $(this).attr("data-direction");
                const savingsProducts = $(".savings-request-modal .products-container .savings-product");

                if (btnClicked === "next") {
                    savingsProducts.each(function() {
                        $(this).removeClass("active");
                    });

                    requestProductCount++;

                    ($(savingsProducts[requestProductCount - 1]).addClass("active"));
                } else {
                    savingsProducts.each(function() {
                        $(this).removeClass("active");
                    });

                    requestProductCount--;

                    ($(savingsProducts[requestProductCount - 1]).addClass("active"));
                }

                if (requestProductCount === 1) {
                    $(".savings-request-modal .controls-container button[data-direction = 'prev']").attr("disabled", true);
                    $(".savings-request-modal .controls-container button[data-direction = 'next']").attr("disabled", false);
                }

                if (requestProductCount === savingsProducts.length) {
                    $(".savings-request-modal .controls-container button[data-direction = 'next']").attr("disabled", true);
                    $(".savings-request-modal .controls-container button[data-direction = 'prev']").attr("disabled", false);
                }
            });

            // ACTIVE SAVINGS REQUEST MODAL EVENT
            $(document).on("click", ".savings-request-modal .modal-header .close-container", function() {
                $(".savings-request-modal-wrapper").removeClass("active");
            });

        });
    </script>
</body>

</html>