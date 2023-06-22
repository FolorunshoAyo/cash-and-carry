<?php
require(dirname(__DIR__) . '/auth-library/resources.php');

// NUMBER FORMATTER
// $human_readable = new \NumberFormatter(
//   'en_US', 
//   \NumberFormatter::PADDING_POSITION
// );
$link="../";
$url = strval($url);

$inSession = (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) || (isset($_SESSION['user_name']) && !empty($_SESSION['user_name']));

if ($inSession) {
    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
}

if (isset($_GET['pid']) && !empty($_GET['pid'])) {
    $pid = $_GET['pid'];

    $sql_product = $db->query("SELECT products.*, product_categories.*, stores.name as store_name FROM ((products INNER JOIN product_categories ON products.category=product_categories.category_id) INNER JOIN stores ON products.store_id = stores.id) WHERE product_id={$pid}");

    if ($sql_product->num_rows === 0) {
        header("Location: ../");
    } else {
        $product_details = $sql_product->fetch_assoc();
    }
} else {
    header("Location: ../");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Custom Fonts (Inter) -->
    <link rel="stylesheet" href="../assets/fonts/fonts.css" />
    <!-- BASE CSS -->
    <link rel="stylesheet" href="../assets/css/base.css?v=1" />
    <!-- IZITOAST CSS -->
    <link rel="stylesheet" href="../auth-library/vendor/dist/css/iziToast.min.css">
    <!-- CUSTOM FORMS CSS -->
    <link rel="stylesheet" href="../assets/css/form.css" />
    <!-- CUSTOM CSS (HOME) -->
    <link rel="stylesheet" href="../assets/css/index.css?v=1" type="text/css" />
    <!-- PRODUCT PAGE CSS -->
    <link rel="stylesheet" href="../assets/css/product.css" type="text/css" />
    <!-- MEDIA QUERIES -->
    <link rel="stylesheet" href="../assets/css/media-queries/main-media-queries.css" />
<<<<<<< Updated upstream
     <!-- Font Awesome -->
=======
         <!-- Font Awesome -->
>>>>>>> Stashed changes
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../assets/bootstrap-5/css/bootstrap.min.css">
    <title><?php echo $product_details['name'] ?> - Halfcarry</title>
</head>

<body>
    <?php
    include_once("../includes/cart.php");
    include_once("../includes/savings-request-modal.php");
    include_once("../includes/header.php");
    ?>
    <main>
        <section class="product-section">
            <div class="product-section-container">
                <div class="product-slider-container">
                    <div class="product-image-container">
                        <div class="product-image-slider-container view-1">
                            <?php
                            foreach (explode(",", $product_details['pictures']) as $key => $picture) {
                                if ($key === 0) {
                                    echo "<img src='" . $url . "assets/product-images/$picture' id='product-image-" . $product_details['product_id'] . "' alt='" . $product_details['name'] . " " . ($key + 1) . "' />";
                                } else {
                                    echo "<img src='" . $url . "assets/product-images/$picture' alt='" . $product_details['name'] . " " . ($key + 1) . "' />";
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class="product-images">
                        <?php
                        foreach (explode(",", $product_details['pictures']) as $key => $picture) {
                            echo "<img src='../assets/product-images/$picture' alt='" . $product_details['name'] . " " . ($key + 1) . "' data-image='" . ($key + 1) . "'/>";
                        }
                        ?>
                    </div>
                </div>
                <div class="product-info">
                    <div class="breadcrumbs">
                        <a href="../">Home</a> / <a href="../all-products/?category=<?php echo str_replace(" ", "", join("-", explode("&", $product_details['category_name']))) ?>"><?php echo $product_details['category_name'] ?></a> / <?php echo $product_details['name'] ?>
                    </div>
                    <h1 id="name-<?= $product_details['product_id'] ?>" data-name="<?= $product_details['name'] ?>" class="product-name">
                        <?php echo $product_details['name'] ?>
                    </h1>
                    <div class="product-info-stock-and-store">
                        <ul>
                            <li>
                                <span class="key">Store:</span>
                                <span class="value"><?= $product_details['store_name'] ?></span>
                            </li>
                            <li>
                                <span class="key">Qty In Stock:</span>
                                <span class="value"><?= $product_details['in_stock'] ?></span>
                            </li>
                        </ul>
                    </div>
                    <div class="product-info-group price">
                        <span id="price-<?= $product_details['product_id'] ?>" data-price="<?= $product_details['price'] ?>" class="product-value">
                            ₦ <?php echo number_format($product_details['price'], 2) ?>
                        </span>
                    </div>
                    <?php
                    $product_interest_amount = (20 / 100) * $product_details['price'];

                    $product_installment_price = $product_details['price'] + $product_interest_amount;

                    $productCalculatedPeriods = getDaysWeeks($product_details['duration_of_payment']);

                    $productCalculatedDays = $productCalculatedPeriods['days'];
                    $productCalculatedWeeks = $productCalculatedPeriods['weeks'];
                    $productCalculatedMonths = $productCalculatedPeriods['months'];

                    $inStock = $product_details['in_stock'] === "0" ? 0 : 1;
                    ?>
                    <div class="product-info-group">
                        <span class="product-badge">Pay ₦<span><?php echo number_format(($product_installment_price / $productCalculatedDays), 2) ?></span> daily (<?= $productCalculatedPeriods['days'] ?> days)</span>
                        <span class="product-badge">Pay ₦<span><?php echo number_format(($product_installment_price / $productCalculatedWeeks), 2) ?></span> per week (<?= $productCalculatedPeriods['weeks'] ?> weeks)</span>
                        <span class="product-badge">Pay ₦<span><?php echo number_format(($product_installment_price / $productCalculatedMonths), 2) ?></span> per month (<?= $productCalculatedPeriods['months'] ?> months)</span>
                    </div>
                    <div class="product-info-group">
                        <div class="product-details">
                            <?php
                            echo $product_details['details'];
                            ?>
                        </div>
                    </div>
                    <?php
                    if (!$inStock) {
                    ?>
                        <div class="out-of-stock-container">
                            <span class="dot red"></span> Out of stock
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="product-info-group amount-block">
                            <span class="product-label"> Quantity: </span>
                            <input type="number" min="1" max="50" value="1" id="amount">
                        </div>
                        <div class="buy-options-container">
                            <button data-product-id="<?= $product_details['product_id'] ?>">Add to cart</button>
                            <button>Start Saving</button>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </section>
        <?php
        $category_id = $product_details['category'];
        $sql_get_related_products = $db->query("SELECT * FROM products WHERE category = {$category_id} AND product_id NOT IN ($pid) ORDER BY RAND() LIMIT 4");

        if ($sql_get_related_products->num_rows > 0) {
        ?>
            <section class="related-products-section">
                <div class="related-products-container">
                    <h2>Related Products</h2>
                    <div class="products">
                        <?php
                        while ($related_product = $sql_get_related_products->fetch_assoc()) {

                            $interest_amount = (20 / 100) * $related_product['price'];

                            $installment_price = $related_product['price'] + $interest_amount;

                            $calculatedPeriods = getDaysWeeks($related_product['duration_of_payment']);

                            $calculatedDays = $calculatedPeriods['days'];
                            $calculatedWeeks = $calculatedPeriods['weeks'];
                            $calculatedMonths = $calculatedPeriods['months'];

                            $inStock = $related_product['in_stock'] === "0" ? 0 : 1;
                        ?>
                            <div class="product-card">
                                <a href="./?pid=<?= $related_product['product_id'] ?>">
                                    <figure>
                                        <?php
                                        $related_product_image_src = explode(",", $related_product['pictures'])[0];
                                        ?>
                                        <img id="related-product-image-<?= $related_product['product_id'] ?>" src="<?= $url ?>assets/product-images/<?= $related_product_image_src ?>">
                                        <figcaption>
                                            <div class="payment-plans">
                                                <span class="product-badge daily">₦<?php echo number_format(($installment_price / $calculatedDays), 2) ?>/day (<?= $calculatedPeriods['days'] ?> days)</span>
                                                <span class="product-badge weekly">₦<?php echo number_format(($installment_price / $calculatedWeeks), 2) ?>/week (<?= $calculatedPeriods['weeks'] ?> weeks)</span>
                                                <span class="product-badge month">₦<?php echo number_format(($installment_price / $calculatedMonths), 2) ?>/month (<?= $calculatedPeriods['months'] ?> months)</span>
                                            </div>
                                            <span id="related-product-name-<?= $related_product['product_id'] ?>" data-name="<?= $related_product['name'] ?>" class="product-desc product-category-name"><?= $related_product['name'] ?></span>
                                            <span id="related-product-price-<?= $related_product['product_id'] ?>" data-price="<?= $related_product['price'] ?>" class="product-desc product-category-price">
                                                ₦ <?= number_format($related_product['price'], 2) ?>
                                            </span>
                                        </figcaption>
                                    </figure>
                                </a>
                                <?php
                                if (!$inStock) {
                                ?>
                                    <div class="out-of-stock-container center">
                                        <span class="dot red"></span> Out of stock
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div class="add-to-cart-btn">
                                        <button data-product-id="<?= $related_product['product_id'] ?>">Add to Cart</button>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </section>
        <?php
        }
        ?>
        <div class="payment-plan-wrapper">
            <section class="payment-plan-container">
                <header>
                    <h2>Choose your plan</h2>
                    <a href="javascript:void(0)">close</a>
                </header>
                <div class="products-container">
                    <div class="savings-product active">
                        <div class="savings-product-image-container">
                            <?php
                            $picture = explode(",", $product_details['pictures'])[0];
                            ?>
                            <img src="<?= $url . "assets/product-images/" . $picture ?>" alt="<?= $product_details['name'] ?>">
                        </div>
                        <div class="savings-product-details">
                            <span class="savings-product-name"> <?= $product_details['name'] ?> </span>
                            <span class="savings-product-qty">Qty: 1</span>
                        </div>
                    </div>
                </div>
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
                                    <p><sup>₦</sup> <span><?php echo number_format(($product_installment_price / $productCalculatedDays), 2) ?></span><sub>/day</sub></p>
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
                                    <p><sup>₦</sup> <span><?php echo number_format(($product_installment_price / $productCalculatedWeeks), 2) ?></span><sub>/week</sub></p>
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
                                    <p><sup>₦</sup> <span><?php echo number_format(($product_installment_price / $productCalculatedMonths), 2) ?></span><sub>/month</sub></p>
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

                        <div class="important-message-container">
                            <i class="fa fa-info-circle"></i> Note: 20% of the product price is incurred as charges for savings</i>
                        </div>

                        <div class="savings-action-btn-container">
                            <button class="btn" type="submit">Proceed</button>
                        </div>
                    </div>
                </form>
                <footer class="modal-footer">
                    <div class="total-amount-container">
                        Amount to save: <br> <span class="total-amount">NGN <?= number_format($product_installment_price, 2) ?></span>
                    </div>
                    <a href="<?= $url ?>user/">Back to dashboard</a>
                </footer>
            </section>
        </div>
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
    <!-- SWEET ALERT SCRIPT -->
    <script src="../auth-library/vendor/dist/sweetalert2.all.min.js"></script>
    <!-- IZI TOAST SCRIPT -->
    <script src="../auth-library/vendor/dist/js/iziToast.min.js"></script>
    <!-- JUST VALIDATE LIBRARY -->
    <script src="../assets/js/just-validate/just-validate.js"></script>
    <script>
        let productQuantity = 1;

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
                    const savingsForm = document.querySelector("#savings-form");

                    const formData = new FormData(savingsForm);

                    formData.append("submit", true);
                    formData.append("product_id", "<?= $product_details['product_id'] ?>");
                    formData.append("quantity", productQuantity);
                    formData.append("type", "1");

                    for (const [key, value] of formData.entries()) {
                        console.log(`${key}: ${value}`);
                    }

                    // CREATE SAVINGS REQUEST
                    $.ajax({
                        url: "../controllers/make-savings-request.php",
                        method: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            $(".spinner-wrapper").addClass("active");
                            $(".savings-action-btn-container button.btn").html("<i class='fa fa-spinner rotate'></i>")
                        },
                        success: function(response) {
                            response = JSON.parse(response);

                            if (response.success == 1) {
                                Swal.fire({
                                    title: "Savings Request",
                                    icon: "success",
                                    text: "Your request has been placed successfully, your chosen agent would contact you shortly.",
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                }).then((result) => {
                                    location.href = `../user/savings-request?id=${response.savings_id}`;
                                });
                            } else {
                                $(".spinner-wrapper").removeClass("active");
                                $(".savings-action-btn-container buttton.btn").html("Proceed");

                                Swal.fire({
                                    title: "Savings Request Error",
                                    icon: "error",
                                    text: "Unable to place savings request. Please try again.",
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                });
                            }
                        }
                    });

                });
        }

        activateSavingsValidator();

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
            const $paymentPlanDialog = $(".payment-plan-wrapper");
            const $paymentPlanDialogCloseBtn = $(".payment-plan-container header a");

            $paymentPlanDialogCloseBtn.on("click", function() {
                $paymentPlanDialog.toggleClass("active");
            });

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

            <?php
            if ($inSession) {
            ?>

                $(".buy-options-container button:nth-of-type(2)").on("click", function() {
                    /* UPDATE ALL SAVINGS AMOUNT BEFORE MODAL DISPLAY
                       =========================================
                    */
                    // SHOWING SELECTED QUANTITY IN MODAL
                    const selectedQuantity = Number($(".product-info-group.amount-block #amount").val());

                    productQuantity = selectedQuantity;
                    const savingsPrices = [];

                    if (!selectedQuantity) return;

                    if (selectedQuantity > <?= $product_details['in_stock'] ?>) {
                        alert("Sorry! This Item only has <?= $product_details['in_stock'] ?> items in stock");
                        return
                    }

                    $(".product-badge span").each(function() {
                        savingsPrices.push(Number($(this).text().trim().replace(/,/g, "")));
                    });

                    $(".savings-product-qty").html(`Qty: ${selectedQuantity}`);

                    $(".payment-plans .payment-plan-info span").each(function(index) {
                        const paymentOptionPrice = savingsPrices[index];

                        const result = paymentOptionPrice * selectedQuantity;

                        $(this).text(result.toLocaleString("en-US"));
                    });

                    // CALCULATING AMOUNT TO SAVE FROM PRODUCT PRICE
                    const productPrice = Number($("#price-<?= $product_details['product_id'] ?>").attr("data-price"));

                    const calculatedPrice = selectedQuantity * productPrice;
                    const finalPrice = ((20 / 100) * calculatedPrice) + calculatedPrice;

                    $(".modal-footer .total-amount-container .total-amount").html("NGN " + finalPrice.toLocaleString("en-US"));

                    $(".payment-plan-wrapper").addClass("active");
                    /* 
                       =========================================
                    */
                })

            <?php
            } else {
            ?>

                $(".buy-options-container button:nth-of-type(2)").on("click", function() {
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
                            location.replace("../login");
                        }
                    });
                });

            <?php
            }
            ?>

            $(".product-images img").each(function() {
                $(this).click(function() {
                    const imageNo = $(this).attr("data-image");

                    $(".product-image-slider-container").attr("class", `product-image-slider-container view-${imageNo}`)
                });
            });

            // CART FUNCTIONALITY
            // SINGLE PRODUCT CART FUNCTION
            $(document).on('click', '.buy-options-container button:nth-of-type(1)', function() {
                var product_id = $(this).attr("data-product-id");
                var product_name = $('#name-' + product_id).attr("data-name");
                var product_price = $('#price-' + product_id).attr("data-price");
                var product_image_src = $("#product-image-" + product_id).attr("src");
                var product_quantity = $("#amount").val();
                var action = "add";

                var add_to_cart_btn = $(this);

                if (!product_quantity) return;

                if (product_quantity > <?= $product_details['in_stock'] ?>) {
                    alert("Sorry! This item only has <?= $product_details['in_stock'] ?> items in stock");
                    return;
                } else {
                    $.ajax({
                        url: "../controllers/cart-controller.php",
                        method: "POST",
                        data: {
                            product_id: product_id,
                            product_name: product_name,
                            product_price: product_price,
                            product_quantity: product_quantity,
                            product_image: product_image_src,
                            action: action
                        },
                        beforeSend: function() {
                            $(".spinner-wrapper").addClass("active");
                            add_to_cart_btn.html("<i class='fa fa-spinner rotate'></i>");
                        },
                        success: function() {
                            add_to_cart_btn.html("Add to Cart");
                            $(".spinner-wrapper").removeClass("active");
                            iziToast.success({
                                title: "Item successfully added to cart",
                                timeout: 3000,
                                backgroundColor: 'green',
                                theme: 'dark',
                                position: 'topRight'
                            });
                            load_cart_data();
                        }
                    });
                }
            });
        });

        //RELATED PRODUCTS FUNCTION
        $(document).on('click', '.add-to-cart-btn button', function() {
            var product_id = $(this).attr("data-product-id");
            var product_name = $('#related-product-name-' + product_id).attr("data-name");
            var product_price = $('#related-product-price-' + product_id).attr("data-price");
            var product_image_src = $("#related-product-image-" + product_id).attr("src");
            var product_quantity = 1
            var action = "add";

            var add_to_cart_btn = $(this);

            if (product_quantity > 0) {
                $.ajax({
                    url: "../controllers/cart-controller.php",
                    method: "POST",
                    data: {
                        product_id: product_id,
                        product_name: product_name,
                        product_price: product_price,
                        product_quantity: product_quantity,
                        product_image: product_image_src,
                        action: action
                    },
                    beforeSend: function() {
                        $(".spinner-wrapper").addClass("active");
                        add_to_cart_btn.html("<i class='fa fa-spinner rotate'></i>");
                    },
                    success: function() {
                        add_to_cart_btn.html("Add to Cart");
                        $(".spinner-wrapper").removeClass("active");
                        iziToast.success({
                            title: "Item successfully added to cart",
                            timeout: 3000,
                            backgroundColor: 'green',
                            theme: 'dark',
                            position: 'topRight'
                        });
                        load_cart_data();
                    }
                });
            }
        });

        $(document).on('click', '.close-btn-container button', function() {
            var product_id = $(this).attr("data-product-id");
            var action = 'remove';
            if (confirm("Are you sure you want to remove this product?")) {
                $.ajax({
                    url: "../controllers/cart-controller.php",
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
                    }
                });
            } else {
                return false;
            }
        });

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

            if (requestProductCount > 1 && requestProductCount < savingsProducts.length) {
                $(".controls-container button[data-direction = 'prev']").attr("disabled", false);
                $(".controls-container button[data-direction = 'next']").attr("disabled", false);
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
    </script>
</body>

</html>