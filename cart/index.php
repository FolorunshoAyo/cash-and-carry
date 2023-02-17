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
    <link rel="stylesheet" href="../assets/css/cart.css" type="text/css" />
    <!-- MEDIA QUERIES -->
    <link rel="stylesheet" href="../assets/css/media-queries/main-media-queries.css" />
    <title>Home - Confidence Daily Savings (CDS)</title>
</head>

<body>
    <div class="full-loader">
        <div class="spinner"></div>
    </div>
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
                        <a href="">
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
        <section class="cart-section">
            <div class="cart-container">
                <div class="cart-number-indicator">
                    Cart Item (<span id="cart-number">5</span>)
                </div>

                <div class="labels">
                    <span>item</span>
                    <span>quantity</span>
                    <span>unit price</span>
                    <span>sub total</span>
                </div>

                <div class="cart-items">
                    <div class="cart-item">
                        <div data-label="Item" class="product-info">
                            <img src="../assets/images/web-cam-1.jpg" alt="Web cam">
                            <div class="details">
                                <p><a href="#">Web Cam 2.0</a></p>
                                <div class="action-btn-container">
                                    <button><i class="fa fa-trash-o"></i></button>
                                </div>
                            </div>
                        </div>
                        <div data-label="Quantity">
                            <input type="number"  min="1" max="50" value="1" id="amount">
                        </div>
                        <div data-label="Unit-price">
                            ₦ 300,000
                        </div>
                        <div data-label="Sub-total">
                            ₦ 300,000
                        </div>
                    </div>
                    <div class="cart-item">
                        <div data-label="Item" class="product-info">
                            <img src="../assets/images/web-cam-1.jpg" alt="Web cam">
                            <div class="details">
                                <p><a href="#">Web Cam 2.0</a></p>
                                <div class="action-btn-container">
                                    <button><i class="fa fa-trash-o"></i></button>
                                </div>
                            </div>
                        </div>
                        <div data-label="Quantity">
                            <input type="number"  min="1" max="50" value="1" id="amount">
                        </div>
                        <div data-label="Unit-price">
                            ₦ 300,000
                        </div>
                        <div data-label="Sub-total">
                            ₦ 300,000
                        </div>
                    </div>
                    <div class="cart-item">
                        <div data-label="Item" class="product-info">
                            <img src="../assets/images/web-cam-1.jpg" alt="Web cam">
                            <div class="details">
                                <p><a href="#">Web Cam 2.0</a></p>
                                <div class="action-btn-container">
                                    <button><i class="fa fa-trash-o"></i></button>
                                </div>
                            </div>
                        </div>
                        <div data-label="Quantity">
                            <input type="number"  min="1" max="50" value="1" id="amount">
                        </div>
                        <div data-label="Unit-price">
                            ₦ 300,000
                        </div>
                        <div data-label="Sub-total">
                            ₦ 300,000
                        </div>
                    </div>
                    <div class="cart-item">
                        <div data-label="Item" class="product-info">
                            <img src="../assets/images/web-cam-1.jpg" alt="Web cam">
                            <div class="details">
                                <p><a href="#">Web Cam 2.0</a></p>
                                <div class="action-btn-container">
                                    <button><i class="fa fa-trash-o"></i></button>
                                </div>
                            </div>
                        </div>
                        <div data-label="Quantity">
                            <input type="number"  min="1" max="50" value="1" id="amount">
                        </div>
                        <div data-label="Unit-price">
                            ₦ 300,000
                        </div>
                        <div data-label="Sub-total">
                            ₦ 300,000
                        </div>
                    </div>
                    <div class="cart-item">
                        <div data-label="Item" class="product-info">
                            <img src="../assets/images/web-cam-1.jpg" alt="Web cam">
                            <div class="details">
                                <p><a href="#">Web Cam 2.0</a></p>
                                <div class="action-btn-container">
                                    <button><i class="fa fa-trash-o"></i></button>
                                </div>
                            </div>
                        </div>
                        <div data-label="Quantity">
                            <input type="number"  min="1" max="50" value="1" id="amount">
                        </div>
                        <div data-label="Unit-price">
                            ₦ 300,000
                        </div>
                        <div data-label="Sub-total">
                            ₦ 300,000
                        </div>
                    </div>
                </div>

                <div class="total-container">
                    Total: <span> ₦ 300,000.00 </span> <br> <br>
                    Delivery fee not included.
                </div>

                <div class="cart-action-btn-container">
                    <div>
                        <a href="#" class="btn">
                            <i class="fa fa-arrow-left"></i>
                            Return to shop
                        </a>
                    </div>
                    <div>
                        <a href="#" class="btn">Proceed to checkout</a>
                        <button class="btn" href="javascrript:void(0)" disabled>Update cart</button>
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

        });
    </script>
</body>

</html>