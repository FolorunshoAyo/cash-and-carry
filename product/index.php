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
    <!-- BASE CSS -->
    <link rel="stylesheet" href="../assets/css/base.css" />
    <!-- CUSTOM CSS (HOME) -->
    <link rel="stylesheet" href="../assets/css/index.css" type="text/css" />
    <!-- PRODUCT PAGE CSS -->
    <link rel="stylesheet" href="../assets/css/product.css" type="text/css" />
    <!-- MEDIA QUERIES -->
    <link rel="stylesheet" href="../assets/css/media-queries/main-media-queries.css" />
    <title>{product name} - Codeweb store</title>
</head>

<body>
    <div class="full-loader">
        <div class="spinner"></div>
    </div>
    <div class="cart-backdrop"></div>
    <aside class="cart-menu">
        <div class="close-container">
            <i class="fa fa-times"></i>
        </div>
        <div class="cart-menu-items-container">
            <div class="cart-menu-items">
                <div class="cart-menu-item">
                    <div class="cart-menu-item-image-container">
                        <img src="../assets/images/web-cam-1.jpg" />
                    </div>
                    <div class="cart-product-details">
                        <a href="#" class="cart-product-name">Web cam 2.0</a>
                        <div class="cart-item-meta">
                            <span class="quantity">2</span> &times; <span class="price">N 300,000</span>
                        </div>
                    </div>
                    <div class="close-btn-container">
                        <button>
                            <i class="fa fa-cross"></i>
                        </button>
                    </div>
                </div>
                <div class="cart-menu-item">
                    <div class="cart-menu-item-image-container">
                        <img src="../assets/images/web-cam-1.jpg" />
                    </div>
                    <div class="cart-product-details">
                        <a href="#" class="cart-product-name">Web cam 2.0</a>
                        <div class="cart-item-meta">
                            <span class="quantity">2</span> &times; <span class="price">N 300,000</span>
                        </div>
                    </div>
                    <div class="close-btn-container">
                        <button>
                            <i class="fa fa-cross"></i>
                        </button>
                    </div>
                </div>
                <div class="cart-menu-item">
                    <div class="cart-menu-item-image-container">
                        <img src="../assets/images/web-cam-1.jpg" />
                    </div>
                    <div class="cart-product-details">
                        <a href="#" class="cart-product-name">Web cam 2.0</a>
                        <div class="cart-item-meta">
                            <span class="quantity">2</span> &times; <span class="price">N 300,000</span>
                        </div>
                    </div>
                    <div class="close-btn-container">
                        <button>
                            <i class="fa fa-cross"></i>
                        </button>
                    </div>
                </div>
                <div class="cart-menu-item">
                    <div class="cart-menu-item-image-container">
                        <img src="../assets/images/web-cam-1.jpg" />
                    </div>
                    <div class="cart-product-details">
                        <a href="#" class="cart-product-name">Web cam 2.0</a>
                        <div class="cart-item-meta">
                            <span class="quantity">2</span> &times; <span class="price">N 300,000</span>
                        </div>
                    </div>
                    <div class="close-btn-container">
                        <button>
                            <i class="fa fa-cross"></i>
                        </button>
                    </div>
                </div>
                <div class="cart-menu-item">
                    <div class="cart-menu-item-image-container">
                        <img src="../assets/images/web-cam-1.jpg" />
                    </div>
                    <div class="cart-product-details">
                        <a href="#" class="cart-product-name">Web cam 2.0</a>
                        <div class="cart-item-meta">
                            <span class="quantity">2</span> &times; <span class="price">N 300,000</span>
                        </div>
                    </div>
                    <div class="close-btn-container">
                        <button>
                            <i class="fa fa-cross"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="sub-total-container">
                Subtotal: <span class="subtotal-amount">N 300,000</span>
            </div>
            <div class="cart-menu-action-btns">
                <a href="../cart/" class="btn">View Cart</a>
                <a href="../checkout/" class="btn">Checkout</a>
            </div>
        </div>
    </aside>
    <header>
        <div class="top-header">
            <a href="index.html" class="logo-container">
                <div class="logo-image-container">
                    <img src="../assets/images/logo.jpg" alt="Header Logo">
                </div>
                <div class="logo-text">
                    <span class="title">Codeweb store</span>
                    <span>pay half now - pay half later</span>
                </div>
            </a>

            <nav class="navigation-menu">
                <ul class="nav-links">
                    <li class="nav-link-item">
                        <a href="#">
                            <i class="fa fa-money"></i>
                            Purchases
                        </a>
                    </li>
                    <li class="nav-link-item">
                        <a href="#">
                            <i class="fa fa-rocket"></i>
                            Packages
                        </a>
                    </li>
                    <li class="nav-link-item">
                        <a href="#">
                            <i class="fa fa-info"></i>
                            Help
                        </a>
                    </li>
                    <li class="nav-link-item cart-link">
                        <a href="javascript:void(0)">
                            <span class="cart-badge">0</span>
                            <i class="fa fa-shopping-cart"></i>
                            Cart
                        </a>
                    </li>
                    <!-- <li class="nav-link-item">
                        <div class="dark-mode-container">
                            <span>Dark Mode</span>
                            <img src="../assets/images/toggle-off.png" alt="toggle-off">
                        </div>
                    </li> -->
                </ul>
            </nav>
        </div>
        <div class="bottom-header">
            <div class="categories-btn-container">
                <button>Categories</button>
            </div>
            <div class="search-container">
                <form class="search-box" action="search/">
                    <input type="text" name="q" placeholder="Search for an item" />
                    <button type="submit" class="search-icon-btn">
                        <i class="fa fa-search"></i>
                    </button>
                </form>
            </div>
            <div class="other-links-container">
                <div class="menu-container">
                    <a href="javascript:void(0)"><i class="fa fa-user-o"></i> <?php echo ($inSession ?  explode(" ", $user_name)[0] : "Account") ?></a>
                    <?php
                    if (!$inSession) {
                    ?>
                        <ul class="menu">
                            <li><a href="login">Sign In</a></li>
                        </ul>
                    <?php
                    } else {
                    ?>
                        <ul class="menu">
                            <li><a href="user/">Dashboard</a></li>
                            <li><a href="user/orders">Orders</a></li>
                            <li><a href="logout?rd=home">Log out</a></li>
                        </ul>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </header>
    <main>
        <section class="product-section">
            <div class="product-section-container">
                <div class="product-slider-container">
                    <div class="product-image-container">
                        <img src="../assets/images/web-cam-1.jpg" alt="#" />
                    </div>
                    <div class="product-images">
                        <img src="../assets/images/web-cam-1.jpg" alt="#">
                        <img src="../assets/images/web-cam-1.jpg" alt="#">
                        <img src="../assets/images/web-cam-1.jpg" alt="#">
                    </div>
                </div>
                <div class="product-info">
                    <div class="breadcrumbs">
                        <a href="#">Home</a> / <a href="#">Electronics</a> / Iphone 13 Green
                    </div>
                    <h1 class="product-name">
                        Iphone 13 Green
                    </h1>
                    <div class="product-info-group price">
                        <span class="product-value">
                            ₦ 300,000.00
                        </span>
                    </div>
                    <div class="product-info-group">
                        <span class="product-badge">Pay N300,000 half</span>
                        <span class="product-badge">Pay N50,000 per month</span>
                    </div>
                    <div class="product-info-group">
                        <div class="product-details">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Hic modi illo facere molestiae, eveniet dicta maxime quia inventore labore totam?</p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Hic modi illo facere molestiae, eveniet dicta maxime quia inventore labore totam?</p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Hic modi illo facere molestiae, eveniet dicta maxime quia inventore labore totam?</p>
                        </div>
                    </div>
                    <div class="product-info-group amount-block">
                        <span class="product-label"> Quantity: </span>
                        <input type="number" min="1" max="50" value="1" id="amount">
                    </div>
                    <div class="buy-options-container">
                        <button>Add to cart</button>
                        <button>Start Saving</button>
                    </div>
                </div>
            </div>
        </section>
        <section class="related-products-section">
            <div class="related-products-container">
                <h2>Related Products</h2>
                <div class="products">
                    <div class="product-card">
                        <a href="#">
                            <figure>
                                <span class="product-badge half">Pay half (₦300,000)</span>
                                <span class="product-badge month">Pay per month (₦50,000)</span>
                                <img src="../a/admin/images/iphone13-green.jpg">
                                <figcaption>
                                    <span class="product-desc product-category-name">Iphone 13 green</span>
                                    <span class="product-desc product-category-price">
                                        ₦ 300,000.00
                                    </span>
                                </figcaption>
                            </figure>
                        </a>
                        <div class="add-to-cart-btn">
                            <button>Add to Cart</button>
                        </div>
                    </div>
                    <div class="product-card">
                        <a href="#">
                            <figure>
                                <span class="product-badge half">Pay half (₦300,000)</span>
                                <span class="product-badge month">Pay per month (₦50,000)</span>
                                <img src="../a/admin/images/iphone13-green.jpg">
                                <figcaption>
                                    <span class="product-desc product-category-name">Iphone 13 green</span>
                                    <span class="product-desc product-category-price">
                                        ₦ 300,000.00
                                    </span>
                                </figcaption>
                            </figure>
                        </a>
                        <div class="add-to-cart-btn">
                            <button>Add to Cart</button>
                        </div>
                    </div>
                    <div class="product-card">
                        <a href="#">
                            <figure>
                                <span class="product-badge half">Pay half (₦300,000)</span>
                                <span class="product-badge month">Pay per month (₦50,000)</span>
                                <img src="../a/admin/images/iphone13-green.jpg">
                                <figcaption>
                                    <span class="product-desc product-category-name">Iphone 13 green</span>
                                    <span class="product-desc product-category-price">
                                        ₦ 300,000.00
                                    </span>
                                </figcaption>
                            </figure>
                        </a>
                        <div class="add-to-cart-btn">
                            <button>Add to Cart</button>
                        </div>
                    </div>
                    <div class="product-card">
                        <a href="#">
                            <figure>
                                <span class="product-badge half">Pay half (₦300,000)</span>
                                <span class="product-badge month">Pay per month (₦50,000)</span>
                                <img src="../a/admin/images/iphone13-green.jpg">
                                <figcaption>
                                    <span class="product-desc product-category-name">Iphone 13 green</span>
                                    <span class="product-desc product-category-price">
                                        ₦ 300,000.00
                                    </span>
                                </figcaption>
                            </figure>
                        </a>
                        <div class="add-to-cart-btn">
                            <button>Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <div class="footer-container">
            <div class="footer-row">
                <div class="footer-group-container">
                    <div class="footer-logo-container">
                        <div class="footer-logo-image-container">
                            <img src="../assets/images/logo.jpg" alt="Footer logo">
                        </div>
                        <div class="footer-logo-text">
                            <span class="logo-title">CODEWEB STORE</span>
                            <span>Buy now pay later</span>
                        </div>
                    </div>
                    <p class="footer-message">
                        Codeweb project solutions was founded in 2019, since then we have continued to produce
                        reliable services in all sectors of production and consumption.
                    </p>
                </div>

                <div class="footer-group call-container">
                    <div class="call-center-container">
                        <div class="call-center-textbox">
                            <span class="call-center-text">Call Center</span>
                            <a href="tel:+2349045840662" class="call-center-no">+234 9045840662</a>
                        </div>
                        <div class="tel-icon-container">
                            <i class="fa fa-phone"></i>
                        </div>
                    </div>
                    <ul class="social-media-links">
                        <li>
                            <a href="#">
                                <i class="fa fa-facebook"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-instagram"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-twitter"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="copyright-message">
                <div>C</div>
                <span>Copyright Codeweb 2022</span>
            </div>
        </div>
    </footer>
    <!-- FONT AWESOME JIT SCRIPT -->
    <script src="https://kit.fontawesome.com/3ae896f9ec.js" crossorigin="anonymous"></script>
    <!-- JQUERY SCRIPT -->
    <script src="../assets/js/jquery/jquery-3.6.min.js"></script>
    <!-- JQUERY MIGRATE SCRIPT (FOR OLDER JQUERY PACKAGES SUPPORT)-->
    <script src="../assets/js/jquery/jquery-migrate-1.4.1.min.js"></script>
    <!-- SLICK SLIDER SCRIPT -->
    <script src="../assets/js/slick/slick.js"></script>
    <!-- SWEET ALERT SCRIPT -->
    <script src="auth-library/vendor/dist/sweetalert2.all.min.js"></script>
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

            cartBackdrop.addEventListener("click", function(){
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

            $(".start-saving-btn").on("click", function() {
                // ALERT USER
                Swal.fire({
                    title: "Start Saving",
                    icon: "error",
                    text: "This feature is not available at the moment",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                });

            });

            <?php
            if ($inSession) {
            ?>

                $(".buy-now-btn").on("click", function() {
                    const amountInputEl = document.getElementById("amount");
                    const productImage = document.querySelector(".product-slide-item img").src;
                    const amount = amountInputEl.value;

                    const formData = new FormData();

                    formData.append("submit", true);
                    formData.append("pid", <?php echo $pid ?>);
                    formData.append("pname", "<?php echo ($product_details['name']) ?>");
                    formData.append("qty", amount);
                    formData.append("price", <?php echo (intval($product_details['price'])) ?>);
                    formData.append("image", productImage);

                    if (Number(amount) === 0) {
                        alert("Please provide a quantity");
                    } else {
                        $.ajax({
                            url: "./controllers/recieve-order.php",
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
                                    location.replace("./checkout");
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
                    }
                })

            <?php
            } else {
            ?>

                $(".buy-now-btn").on("click", function() {
                    // ALERT ADMIN
                    Swal.fire({
                        title: "Purchase Error",
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

        });
    </script>
</body>

</html>