<?php
  require(__DIR__ . '/auth-library/resources.php');

  // NUMBER FORMATTER
  // $human_readable = new \NumberFormatter(
  //   'en_US', 
  //   \NumberFormatter::PADDING_POSITION
  // );

  $inSession = (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) || (isset($_SESSION['user_name']) && !empty($_SESSION['user_name']));

  if($inSession){
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
    <!-- Custom Fonts (Inter) -->
    <link rel="stylesheet" href="assets/fonts/fonts.css">
    <!-- BASE CSS -->
    <link rel="stylesheet" href="assets/css/base.css">
    <!-- Slick plugin stylesheet -->
    <link rel="stylesheet" href="assets/css/slick/slick.css">
    <!-- CUSTOM SLIDER STYLING -->
    <link rel="stylesheet" href="assets/css/slider-theme.css" type="text/css">
    <!-- CUSTOM CSS (HOME) -->
    <link rel="stylesheet" href="assets/css/index.css" type="text/css">
    <!-- MEDIA QUERIES -->
    <link rel="stylesheet" href="assets/css/media-queries/main-media-queries.css">
    <title>Home - Confidence Daily Savings (CDS)</title>
</head>

<body>
    <header>
        <div class="top-header">
            <a href="index.html" class="logo-container">
                <div class="logo-image-container">
                    <img src="assets/images/logo-small.png" alt="Header Logo">
                </div>
                <div class="logo-text">
                    <span class="title">CDS</span>
                    <span>Confidence daily savings</span>
                </div>
            </a>

            <nav class="navigation-menu">
                <ul class="nav-links">
                    <li class="nav-link-item">
                        <a href="#">Purchases</a>
                    </li>
                    <li class="nav-link-item">
                        <a href="#">Package deals</a>
                    </li>
                    <li class="nav-link-item">
                        <a href="#">Help</a>
                    </li>
                    <li class="nav-link-item">
                        <div class="dark-mode-container">
                            <span>Dark Mode</span>
                            <img src="assets/images/toggle-off.png" alt="toggle-off">
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="bottom-header">
            <div class="categories-btn-container">
                <button>Categories</button>
            </div>
            <div class="search-container">
                <form class="search-box" action="search/">
                    <input type="text" name="q" placeholder="Search for an item">
                    <button type="submit" class="search-icon-btn">
                        <i class="fa fa-search"></i>
                    </button>
                </form>
            </div>
            <div class="other-links-container">
                <button class="installment-btn">Installments</button>
                <div class="menu-container">
                    <a href="javascript:void(0)"><i class="fa fa-user-o"></i> <?php echo($inSession?  explode(" ", $user_name)[0] : "Account") ?></a>
                    <?php
                        if(!$inSession){
                    ?>
                    <ul class="menu">
                        <li><a href="login">Sign In</a></li>
                    </ul>
                    <?php
                        }else{
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
                                <span>Cameras</span>
                                <img src="assets/images/nikon-d90.jpg" alt="#">
                            </div>
                        </div>
                        <div class="product-desc product-category">
                            <div>
                                <span>Home Appliances</span>
                                <img src="assets/images/hisense-ac.jpg" alt="#">
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
                                <span>Home Appliances</span>
                                <img src="assets/images/hisense-ac.jpg" alt="#">
                            </div>
                        </div>
                        <div class="product-desc product-category">
                            <div>
                                <span>Home Appliances</span>
                                <img src="assets/images/hisense-ac.jpg" alt="#">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="hero-section">
            <div class="hero-container">
                <div class="hero-text-box">
                    The <br> <span>Smarter</span> way to spend and look <b>good doing it.</b>
                </div>
                <div class="hero-img-container">
                    <img src="assets/images/banner-main.png" alt="Male jollying with money in his hands">
                </div>
                <div class="hero-logo-container">
                    <img src="assets/images/logo-small.png" alt="#">
                </div>
            </div>
        </section>
        <section class="available-goods-section">
            <div class="available-goods-container">
                <div class="available-goods-text-box">
                    <h2 class="available-goods-title">Available goods this month</h2>
                    <p class="available-goods-text">According to in-demand purchases, get yours now!</p>
                </div>
                <div class="available-goods">
                    <?php 
                        $recentProductsSql = $db->query("SELECT * FROM products ORDER BY product_id desc LIMIT 8");

                        while($rowProduct = $recentProductsSql->fetch_assoc()){
                            $productID = $rowProduct['product_id'];
                            $productMetaSql = $db->query("SELECT * FROM product_meta WHERE product_id={$productID}");
            
                            $productMetaRecord = $productMetaSql->fetch_assoc();
                    ?>
                    <a href="product?pid=<?php echo($productID) ?>" class="available-good">
                        <figure>
                            <img src="a/admin/images/<?php echo(explode(",", $rowProduct['pictures'])[0]) ?>" alt="<?php echo($rowProduct['name']) ?>">
                            <figcaption>
                                <span class="product-desc product-category-name"><?php echo($rowProduct['name']) ?></span>
                                <span class="product-desc product-category-duration">
                                    N<?php 
                                        // echo($human_readable->format(intval($rowProduct['price']))) 
                                        echo($rowProduct['price'])
                                      ?> 
                                    X 
                                    <?php echo($productMetaRecord['duration_in_months']) ?> 
                                    Months
                                </span>
                                <span class="product-desc product-category-price">
                                    N<?php 
                                    // echo($human_readable->format($productMetaRecord['daily_payment']))
                                    echo($productMetaRecord['daily_payment']) 
                                    ?> 
                                    Daily
                                </span>
                            </figcaption>
                        </figure>
                    </a>
                    <?php 
                        }
                    ?>
                </div>
                <div class="view-all-container">
                    <a href="#">view all</a>
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
                            Pay in installments
                        </h2>
                        <p class="banner-text">
                            Confidence Daily Savings is a platform that recognises the economic state and promises to
                            deliver you with what you need at the onvenience of your pocket.
                        </p>
                        <div class="banner-btn-container">
                            <a href="#">Learn more</a>
                        </div>
                    </div>
                </div>
                <div class="circle"></div>
            </div>
        </section>
        <section class="avilable-goods-section">
            <div class="available-goods-container">
                <div class="available-goods-text-box">
                    <h2 class="available-goods-title">Available goods this month</h2>
                    <p class="available-goods-text">According to in-demand purchases, get yours now!</p>
                </div>
                <div class="available-goods">
                <?php 
                    $recentProductsSql = $db->query("SELECT * FROM products LIMIT 8");

                    while($rowProduct = $recentProductsSql->fetch_assoc()){
                        $productID = $rowProduct['product_id'];
                        $productMetaSql = $db->query("SELECT * FROM product_meta WHERE product_id={$productID}");
            
                        $productMetaRecord = $productMetaSql->fetch_assoc();
                ?>
                    <a href="#" class="available-good">
                        <figure>
                            <img src="a/admin/images/<?php echo(explode(",", $rowProduct['pictures'])[0]) ?>" alt="<?php echo($rowProduct['name']) ?>">
                            <figcaption>
                                <span class="product-desc product-category-name"><?php echo($rowProduct['name']) ?></span>
                                <span class="product-desc product-category-duration">
                                    N<?php 
                                        // echo($human_readable->format(intval($rowProduct['price']))) 
                                        echo($rowProduct['price'])
                                      ?> 
                                    X 
                                    <?php echo($productMetaRecord['duration_in_months']) ?> 
                                    Months
                                </span>
                                <span class="product-desc product-category-price">
                                    N<?php 
                                    // echo($human_readable->format($productMetaRecord['daily_payment']))
                                    echo($productMetaRecord['daily_payment']) 
                                    ?> 
                                    Daily
                                </span>
                            </figcaption>
                        </figure>
                    </a>
                    <?php 
                        }
                    ?>
                </div>
                <div class="view-all-container">
                    <a href="#">view all</a>
                </div>
            </div>
        </section>
        <section class="owner-message-section">
            <div class="owner-message-container">
                <div class="owner-message-textbox">
                    <h1 class="owner-message-title">
                        Your satisfaction is our concern!
                    </h1>
                    <p class="owner-message">
                        Confidence Daily Savings is a platform that helps the common man to save (small-small, obere, di
                        e di e, kandan-kandan) to acquire items such as food items, properties, electrical appliances,
                        building materials etc. <br>
                        With our savings platforms, your savings are secured and timely withdrawal guaranteed.
                    </p>
                </div>
                <div class="owner-image-container">
                    <div class="owner-image-wrapper">
                        <img src="assets/images/confidence-miss.jpeg" alt="Owner of confidence">
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
                        <img src="assets/images/logo-small.png" alt="Footer logo">
                        <div class="footer-logo-text">
                            <span class="logo-title">CDS</span>
                            <span>Confidence daily savings</span>
                        </div>
                    </div>
                    <p class="footer-message">
                        Confywills Nigeria Limited was founded in 2012, since then we have continue to produce a
                        reliable services in all sectors of production and consumption.
                    </p>
                </div>

                <div class="footer-group call-container">
                    <div class="call-center-container">
                        <div class="call-center-textbox">
                            <span class="call-center-text">Call Center</span>
                            <a href="tel:09045840662" class="call-center-no">09045840662</a>
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
                <span>Copyright CDS 2022</span>
            </div>
        </div>
    </footer>
    <!-- FONT AWESOME JIT SCRIPT-->
    <script src="https://kit.fontawesome.com/3ae896f9ec.js" crossorigin="anonymous"></script>
    <!-- JQUERY SCRIPT -->
    <script src="assets/js/jquery/jquery-3.6.min.js"></script>
    <!-- JQUERY MIGRATE SCRIPT (FOR OLDER JQUERY PACKAGES SUPPORT)-->
    <script src="assets/js/jquery/jquery-migrate-1.4.1.min.js"></script>
    <script src="assets/js/slick/slick.js"></script>
    <script>
        $(function () {
            // const burgerMenu = $(".burger-menu");
            // const mobileNav = $(".mobile-menu");

            $('.categories-slider').slick({
                dots: false,
                arrows: false,
                slidesToShow: 7,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
                responsive: [
                    {
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

            function toggle(e) {
                 e.stopPropagation();
                var link=this;
                var menu = link.nextElementSibling;

                if(!menu) return;
                if (menu.style.display !== 'block') {
                    menu.style.display = 'block';
                }  else {
                    menu.style.display = 'none';
                }
            };

            function closeAll() {
                menuContainer.nextElementSibling.style.display='none';
            };

            window.onclick=function(event){
                closeAll.call(event.target);
            };

            // //CHANGING THE ARROW BUTTONS TO ARROWS
            // $(".slick-next").html("<i class='fas fa-arrow-right'></i>");
            // $(".slick-prev").html("<i class='fas fa-arrow-left'></i>");

            //HEADER STICKY FUNCTIONALITY
            // Jquery handler for displaying sticky header upon scroll.
            // $(window).on("scroll", () => {
            //     let header = $("header");

            //     header[0].classList.toggle("sticky", $(window)[0].scrollY > 180);
            // });

            // Event Handler for Burger Menu Toggle
            // burgerMenu.on("click", () => {
            //     burgerMenu.toggleClass("active");
            //     mobileNav.toggleClass("active");
            // });

            // SMOOTH SCROLL FUNCTIONALITY
            // Smooth scroll function declaration for handling smooth document fragmenting.
            // const smoothScroll = (buttonID, location, duration) => {
            //     $(buttonID).on("click", (e) => {
            //         $([document.documentElement, document.body]).animate({
            //             scrollTop: $(location).offset().top
            //         }, duration);
            //     })
            // };

            // smoothScroll(".collaborate-btn-container button", "#services", 3000)
        });
    </script>
</body>

</html>