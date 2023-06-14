<?php
require(__DIR__ . '/auth-library/resources.php');
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon Icon -->
    <link rel="favicon" href="assets/images/halfcarry-logo.jpeg">
    <!-- Custom Fonts (Inter) -->
    <link rel="stylesheet" href="assets/fonts/fonts.css">
    <!-- BASE CSS -->
    <link rel="stylesheet" href="assets/css/base.css?v=1">
    <!-- IZITOAST CSS -->
    <link rel="stylesheet" href="auth-library/vendor/dist/css/iziToast.min.css">
    <!-- Slick plugin stylesheet -->
    <link rel="stylesheet" href="assets/css/slick/slick.css">
    <!-- CUSTOM SLIDER STYLING -->
    <link rel="stylesheet" href="assets/css/slider-theme.css" type="text/css">
    <!-- CUSTOM CSS (HOME) -->
    <link rel="stylesheet" href="assets/css/index.css?v=1" type="text/css">
    <!-- MEDIA QUERIES -->
    <link rel="stylesheet" href="assets/css/media-queries/main-media-queries.css">
    <title>Home - Halfcarry</title>
</head>

<body>
    <?php
    include_once("includes/cart.php");
    include_once("includes/savings-request-modal.php");
    include_once("includes/header.php");
    ?>
    <main>
        <section class="categories-section">
            <div class="categories-container">
                <div class="categories-slider-container">
                    <div class="categories-slider">
                        <div class="product-desc product-category">
                            <div>
                                <span>Cars</span>
                                <img src="assets/images/corolla.jpg" alt="#">
                            </div>
                        </div>
                        <div class="product-desc product-category">
                            <div>
                                <span>Laptops</span>
                                <img src="assets/images/hp-15.jpg" alt="#">
                            </div>
                        </div>
                        <div class="product-desc product-category">
                            <div>
                                <span>Phones</span>
                                <img src="assets/images/iphone-13.jpg" alt="#">
                            </div>
                        </div>
                        <div class="product-desc product-category">
                            <div>
                                <span>Commercials</span>
                                <img src="assets/images/na-pep.jpg" alt="#">
                            </div>
                        </div>
                        <div class="product-desc product-category">
                            <div>
                                <span>Tvs & Monitors</span>
                                <img src="assets/images/alienware.jpg" alt="#">
                            </div>
                       </div>
                        <div class="product-desc product-category">
                            <div>
                                <span>Furnitures</span>
                                <img src="assets/images/bed-20.jpg" alt="#">
                            </div>
                        </div>
                        <div class="product-desc product-category">
                            <div>
                                <span>Cameras</span>
                                <img src="assets/images/nikon-d90.jpg" alt="#">
                            </div>
                        </div>
                        <div class="product-desc product-category">
                            <div>
                                <span>Appliances</span>
                                <img src="assets/images/hisense-ac.jpg" alt="#">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="hero-section">
            <div class="hero-container">
                <!-- <div class="hero-text-box">
                    The <br> <span>Smarter</span> way to spend and look <b>good doing it.</b>
                </div>
                <div class="hero-img-container">
                    <img src="assets/images/banner-main.png" alt="Male jollying with money in his hands">
                </div>
                <div class="hero-logo-container">
                    <img src="assets/images/halfcarry-logo.jpeg" alt="Logo">
                </div> -->
                <img src="assets/images/halfcarry-banner-1.jpeg" alt="Banner">
            </div>
        </section>
        <section class="available-goods-section">
            <div class="available-goods-container">
                <div class="available-goods-text-box">
                    <h2 class="available-goods-title">Top deals</h2>
                    <p class="available-goods-text">According to in-demand purchases, get yours now!</p>
                </div>
                <div class="available-goods">
                    <?php
                    $recentProductsSql = $db->query("SELECT * FROM products WHERE deleted='0' ORDER BY RAND() LIMIT 8");

                    while ($rowProduct = $recentProductsSql->fetch_assoc()) {
                        $interest_amount = (30 / 100) * $rowProduct['price'];

                        $installment_price = $rowProduct['price'] + $interest_amount;

                        $calculatedPeriods = getDaysWeeks($rowProduct['duration_of_payment']);

                        $calculatedDays = $calculatedPeriods['days'];
                        $calculatedWeeks = $calculatedPeriods['weeks'];
                        $calculatedMonths = $calculatedPeriods['months'];

                        $inStock = $rowProduct['in_stock'] === "0" ? 0 : 1;
                    ?>
                        <div class="available-good">
                            <?php
                            //    $product_name_bits = explode(" ", strtolower($rowProduct['name']));

                            //    $refinedProductName = join("-", $product_name_bits);
                            ?>
                            <a href="product/?pid=<?= $rowProduct['product_id'] ?>">
                                <figure>
                                    <img id="product-image-<?= $rowProduct['product_id'] ?>" src="<?php echo $url ?>assets/product-images/<?php echo explode(",", $rowProduct['pictures'])[0] ?>" alt="<?php echo $rowProduct['name'] ?>">
                                    <figcaption>
                                        <div class="payment-plans">
                                            <span class="product-badge daily">₦<?php echo number_format(($installment_price / $calculatedDays), 2) ?>/day (<?= $calculatedPeriods['days'] ?> days)</span>
                                            <span class="product-badge weekly">₦<?php echo number_format(($installment_price / $calculatedWeeks), 2) ?>/week (<?= $calculatedPeriods['weeks'] ?> weeks)</span>
                                            <span class="product-badge month">₦<?php echo number_format(($installment_price / $calculatedMonths), 2) ?>/month (<?= $calculatedPeriods['months'] ?> months)</span>
                                        </div>
                                        <span id='name-<?php echo $rowProduct['product_id'] ?>' data-name='<?php echo $rowProduct['name'] ?>' class="product-desc product-category-name"><?= $rowProduct['name'] ?></span>
                                        <span id='price-<?php echo $rowProduct['product_id'] ?>' data-price='<?php echo $rowProduct['price'] ?>' class="product-desc product-category-price">
                                            ₦ <?php echo number_format($rowProduct['price'], 2) ?>
                                        </span>
                                    </figcaption>
                                </figure>
                            </a>

                            <?php
                            if (!$inStock) {
                            ?>
                                <div class='out-of-stock-container'>
                                    <span class='dot red'></span> Out of Stock
                                </div>
                            <?php
                            } else {
                            ?>

                                <div class='add-to-cart-btn'>
                                    <button data-product-id='<?= $rowProduct['product_id'] ?>'>Add to Cart</button>
                            </div>
                            <?php
                            }
                            ?>

                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class=" view-all-container">
                    <a href="./all-products/">view all</a>
                </div>
            </div>
        </section>
        <!-- <section class="services-section">
            <div class="services-container">
                <h1 class="services-title main-title">
                    Why save and spend with us?
                </h1>
                <div class="services-offered">
                    <div class="service left">
                        <h2 class="service-sub-title sub-title">
                            Easier living for the common man
                        </h2>
                        <p class="service-text">
                            With CDS, you get access to your favourite items, all in one place at very affordable
                            prices.
                        </p>
                    </div>
                    <div class="service right">
                        <h2 class="service-sub-title sub-title">
                            The best payment plans
                        </h2>
                        <p class="service-text">
                            As a customer of CDS, you get access to our affordable payment plans and you choose what is
                            irght for you and your pocket.
                        </p>
                    </div>
                    <div class="service left">
                        <h2 class="service-sub-title sub-title">
                            Guaranteed withdrawals
                        </h2>
                        <p class="service-text">
                            With our savings platforms, your savings are secured and timely withdrawal guaranteed.
                        </p>
                    </div>
                </div>
            </div>
        </section> -->
        <section class="banner-section">
            <div class="banner-section-container">
                <div class="banner-img-container">
                    <img src="assets/images/banner.png" alt="Banner group">
                </div>
                <div class="banner-text-box-container">
                    <div class="banner-text-box">
                        <h2 class="text-box-title">
                            Buy now and pay later!!
                        </h2>
                        <p class="banner-text">
                            Half Carry is a marketplace that recognises the economic state and promises to
                            deliver you with what you need at the convenience of your pocket.
                        </p>
                        <div class="banner-btn-container">
                            <a href="#">Learn more</a>
                        </div>
                    </div>
                </div>
                <div class="circle"></div>
            </div>
        </section>
        <section class="top-categories-section">
            <div class="top-categories-container">
                <div class="top-categories-text-box">
                    <h2 class="top-categories-title">Top categories</h2>
                    <p class="top-categories-text">These are the hottest categories right now!!</p>
                </div>
                <div class="top-categories">
                    <a href="./all-products/?category=electronics" class="top-category">
                        <figure>
                            <img src="a/admin/images/46.jpeg" alt="#">
                            <figcaption>
                                Electronics
                            </figcaption>
                        </figure>
                    </a>
                    <a href="./all-products/?category=home-kitchen" class="top-category">
                        <figure>
                            <img src="assets/images/kitchen-interior.jpg" alt="#">
                            <figcaption>
                                Home and kitchen
                            </figcaption>
                        </figure>
                    </a>
                    <a href="./all-products/?category=phone-tablets" class="top-category">
                        <figure>
                            <img src="assets/images/modern-stationary-collection-arrangement.jpg" alt="#">
                            <figcaption>
                                Phones and tablet
                            </figcaption>
                        </figure>
                    </a>
                    <a href="./all-products/?category=computer-accessories" class="top-category">
                        <figure>
                            <img src="a/admin/images/adapter-1.jpg" alt="#">
                            <figcaption>
                                Computers and accessories
                            </figcaption>
                        </figure>
                    </a>
                    <!-- <a href="./all-products/?category=furniture" class="top-category">
                        <figure>
                            <img src="a/admin/images/bed-3.jpeg" alt="#">
                            <figcaption>
                                Furniture
                            </figcaption>
                        </figure>
                    </a> -->
                    <!-- <a href="./all-products/?category=groceries" class="top-category">
                        <figure>
                            <img src="assets/images/bed-21.jpg" alt="#">
                            <figcaption>
                                Groceries
                            </figcaption>
                        </figure>
                    </a>
                    <a href="./all-products/?category=fashion" class="top-category">
                        <figure>
                            <img src="assets/images/bed-21.jpg" alt="#">
                            <figcaption>
                                Fashion
                            </figcaption>
                        </figure>
                    </a>
                    <a href="./all-products/?category=health-beauty" class="top-category">
                        <figure>
                            <img src="assets/images/bed-21.jpg" alt="#">
                            <figcaption>
                                Health and Beauty
                            </figcaption>
                        </figure>
                    </a> -->
                </div>
            </div>
        </section>
        <!-- <section class="our-brands-section">
            <div class="our-brands-container">
                <div class="our-brands-text-box">
                    <h2 class="our-brands-title">Our Official Brands</h2>
                    <p class="our-brands-text">Here are our supported brands/dealers</p>
                </div>
                <div class="scroll-container">
                    <div class="scroll-element scroll-element-first">
                        <div class="scroll-image">
                            <img src="assets/images/bed-21.jpg" alt="">
                        </div>
                        <div class="scroll-image">
                            <img src="assets/images/bed-21.jpg" alt="">
                        </div>
                        <div class="scroll-image">
                            <img src="assets/images/bed-21.jpg" alt="">
                        </div>
                        <div class="scroll-image">
                            <img src="assets/images/bed-21.jpg" alt="">
                        </div>
                        <div class="scroll-image">
                            <img src="assets/images/bed-21.jpg" alt="">
                        </div>
                    </div>
                    <div class="scroll-element scroll-element-second">
                        <div class="scroll-image">
                            <img src="assets/images/bed-21.jpg" alt="">
                        </div>
                        <div class="scroll-image">
                            <img src="assets/images/bed-21.jpg" alt="">
                        </div>
                        <div class="scroll-image">
                            <img src="assets/images/bed-21.jpg" alt="">
                        </div>
                        <div class="scroll-image">
                            <img src="assets/images/bed-21.jpg" alt="">
                        </div>
                        <div class="scroll-image">
                            <img src="assets/images/bed-21.jpg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
    </main>
    <?php
    include("includes/footer.php");
    ?>
    <!-- FONT AWESOME JIT SCRIPT-->
    <script src="https://kit.fontawesome.com/3ae896f9ec.js" crossorigin="anonymous"></script>
    <!-- JQUERY SCRIPT -->
    <script src="assets/js/jquery/jquery-3.6.min.js"></script>
    <!-- JQUERY MIGRATE SCRIPT (FOR OLDER JQUERY PACKAGES SUPPORT)-->
    <script src="assets/js/jquery/jquery-migrate-1.4.1.min.js"></script>
    <script src="assets/js/slick/slick.js"></script>
    <!-- IZI TOAST SCRIPT -->
    <script src="auth-library/vendor/dist/js/iziToast.min.js"></script>
    <script>
        function displayActiveRequest() {
            $(".savings-request-modal-wrapper").addClass("active");
        }
        $(function() {
            // const burgerMenu = $(".burger-menu");
            // const mobileNav = $(".mobile-menu");

            $('.categories-slider').slick({
                dots: false,
                arrows: false,
                slidesToShow: 7,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
                responsive: [{
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 5,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 1
                        }
                    }
                ]
            });


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


            // CART FUNCTIONALITY
            $(document).on('click', '.add-to-cart-btn button', function() {
                var product_id = $(this).attr("data-product-id");
                var product_name = $('#name-' + product_id).attr("data-name");
                var product_price = $('#price-' + product_id).attr("data-price");
                var product_image_src = $("#product-image-" + product_id).attr("src");
                var product_quantity = 1;
                var action = "add";

                var add_to_cart_btn = $(this);

                if (product_quantity > 0) {
                    $.ajax({
                        url: "controllers/cart-controller.php",
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
                        success: function(data) {
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
                        }
                    });
                } else {
                    return false;
                }
            });

            load_cart_data();

            function load_cart_data() {
                $.ajax({
                    url: "controllers/fetch-cart.php",
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
        });
    </script>
</body>

</html>