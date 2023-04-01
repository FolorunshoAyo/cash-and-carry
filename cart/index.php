<?php
require(dirname(__DIR__) . '/auth-library/resources.php');

// NUMBER FORMATTER
// $human_readable = new \NumberFormatter(
//   'en_US', 
//   \NumberFormatter::PADDING_POSITION
// );

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
                            <a href="#" class="btn">Proceed to checkout</a>
                            <button class="btn">Start Saving</button>
                        </div>
                    </div>

                <?php
                }
                ?>
            </div>
        </section>
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
    <script>
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

        });
    </script>
</body>

</html>