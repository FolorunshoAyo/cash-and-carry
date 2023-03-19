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

if (isset($_GET['category']) && !empty($_GET['category'])) {
    $category = $_GET['category'];
}

if (isset($_GET['view-categories']) && empty($_GET['view-categories'])) {
    $view_categories = 1;
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
    <!-- IZITOAST CSS -->
    <link rel="stylesheet" href="../auth-library/vendor/dist/css/iziToast.min.css">
    <!-- BASE CSS -->
    <link rel="stylesheet" href="../assets/css/base.css">
    <!-- PAGINATE CSS -->
    <link rel="stylesheet" href="../assets/css/pagination.css" />
    <!-- CUSTOM PAGINATE CSS -->
    <link rel="stylesheet" href="../assets/css/custom-paginate.css">
    <!-- CUSTOM CSS (HOME) -->
    <link rel="stylesheet" href="../assets/css/index.css" type="text/css">
    <!-- SHOP CSS -->
    <link rel="stylesheet" href="../assets/css/all-products.css" type="text/css">
    <!-- MEDIA QUERIES -->
    <link rel="stylesheet" href="../assets/css/media-queries/main-media-queries.css">
    <title>All products - Codeweb Store</title>
</head>

<body>
    <div class="cart-backdrop"></div>
    <aside class="cart-menu">
        <div class="close-container">
            <i class="fa fa-times"></i>
        </div>
        <div class="cart-menu-items-container">
            <div class="spinner-container">
                <img src="../assets/images/halfcarry-logo.jpeg" alt="Halfcarry Logo">
                <div class="spinner"></div>
            </div>
        </div>
    </aside>
    <header>
        <div class="top-header">
            <a href="../" class="logo-container">
                <div class="logo-image-container">
                    <img src="../assets/images/halfcarry-logo.jpeg" alt="Header Logo">
                </div>
                <!-- <div class="logo-text">
                    <span class="title">Codeweb store</span>
                    <span>pay half now - pay half later</span>
                </div> -->
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
        <!-- <div class="bottom-header">
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
        </div> -->
    </header>
    <main>
        <section class="shop-section">
            <div class="shop-container">
                <form action="../search/">
                    <div class="search-container">
                        <div class="search-btn-container">
                            <button type="submit">Search</button>
                        </div>
                        <div class="input-container">
                            <input type="text" name="q" placeholder="Enter search query" />
                            <button type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                        <div class="menu-container allproducts-menu-container">
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
                </form>
                <div class="filter-container">
                    <span class="filter-text">Filter search</span>

                    <div class="filter-select-container">
                        <span>By Category</span>
                        <select id="category-select" class="filter-select">
                            <option>Select &nbsp; &nbsp; &nbsp;</option>
                            <?php
                            $sql_get_all_categories = $db->query("SELECT * FROM product_categories");

                            while ($rowCategory = $sql_get_all_categories->fetch_assoc()) {
                                if (isset($category)) {
                                    $convertedCategory = explode("-", $category)[0];
                                    $dbConvCategory = explode(" ", $rowCategory['category_name'])[0];

                                    $check_category = $convertedCategory === $dbConvCategory;

                                    if ($check_category) {
                                        echo "<option selected value='" . $rowCategory['category_id'] . "'>" . $rowCategory['category_name'] . "</option>";
                                    } else {
                                        echo "<option value='" . $rowCategory['category_id'] . "'>" . $rowCategory['category_name'] . "</option>";
                                    }
                                } else {
                                    echo "<option value='" . $rowCategory['category_id'] . "'>" . $rowCategory['category_name'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="filter-select-container">
                        <span>By Price</span>
                        <select id="price-select" class="filter-select">
                            <option>Select &nbsp; &nbsp; &nbsp;</option>
                            <option value="asc">lowest to highest</option>
                            <option value="desc">highest to lowest</option>
                        </select>
                    </div>

                    <div class="filter-select-container">
                        <span>By Order</span>
                        <select id="order-select" class="filter-select">
                            <option>Select &nbsp; &nbsp; &nbsp;</option>
                            <option value="asc">oldest to newest</option>
                            <option value="desc">newest to oldest</option>
                        </select>
                    </div>
                </div>
                <div class="quick-links-container" style="<?php echo (isset($view_categories)) ? "display: block;" : "display: none"; ?>">
                    <div class="quick-link">
                        <span>Automobiles</span>
                        <a href="./?category=automotive-industrial">
                            <img src="../assets/images/corolla.jpg" />
                        </a>
                        <a href="./?category=automotive-industrial">
                            <img src="../assets/images/na-pep.jpg" />
                        </a>
                    </div>
                    <div class="quick-link">
                        <span>Communication devices</span>
                        <a href="./?category=phone-tablets">
                            <img src="../assets/images/hp-15.jpg" />
                        </a>
                        <a href="./?category=phone-tablets">
                            <img src="../assets/images/iphone-13.jpg" />
                        </a>
                    </div>
                    <div class="quick-link">
                        <span>Technology and gadgets</span>
                        <a href="./?category=electronics">
                            <img src="../assets/images/nikon-d90.jpg" />
                        </a>
                        <a href="./?category=phone-tablets">
                            <img src="../assets/images/alienware.jpg" />
                        </a>
                    </div>
                    <div class="quick-link">
                        <span>Home appliances and other</span>
                        <a href="./?category=electronics">
                            <img src="../assets/images/hisense-ac.jpg" />
                        </a>
                        <a href="./?category=furniture">
                            <img src="../assets/images/bed-3.jpeg">
                        </a>
                    </div>
                </div>
                <div class="results-container" style="<?php echo (isset($view_categories)) ? "display: none;" : "display: block"; ?>">
                    <div class="products-container-overlay"></div>
                    <div class="info-container">
                        <span>Retrieved 0 results</span>
                    </div>
                    <div class="products-container"></div>
                </div>
            </div>
        </section>
    </main>
    <?php
    include("../includes/footer.php");
    ?>
    <!-- FONT AWESOME JIT SCRIPT-->
    <script src="https://kit.fontawesome.com/3ae896f9ec.js" crossorigin="anonymous"></script>
    <!-- JQUERY SCRIPT -->
    <script src="../assets/js/jquery/jquery-3.6.min.js"></script>
    <!-- JQUERY MIGRATE SCRIPT (FOR OLDER JQUERY PACKAGES SUPPORT)-->
    <script src="../assets/js/jquery/jquery-migrate-1.4.1.min.js"></script>
    <!-- SLICK SLIDER JS -->
    <script src="../assets/js/slick/slick.js"></script>
    <!-- JQUERY PAGINATE -->
    <script src="../assets/js/pagination.min.js"></script>
    <!-- IZI TOAST SCRIPT -->
    <script src="../auth-library/vendor/dist/js/iziToast.min.js"></script>
    <script>
        $(function() {
            const allSelects = $('.filter-select');
            const quickLinksContainer = $(".quick-links-container");
            const resultsContainer = $(".results-container")

            allSelects.each(function(index) {

                $(this).on("change", function() {
                    quickLinksContainer.css("display", "none");
                    resultsContainer.css("display", "block");
                    loadData(1, 5);
                });
            });

            function loadData(currPage, pageSize) {
                //RETRIEVE FILTER OPTIONS
                const filterValues = [];
                const allSelects = $('.filter-select');
                const infoEl = $(".info-container span");

                allSelects.each(function(index) {
                    $(this).attr("disabled", true);

                    filterValues[index] = $(this).val().trim() === 'Select' ? "" : $(this).val().trim();
                });

                // PREPARE FORM DATA
                const formData = new FormData();
                formData.append("submit", true);
                formData.append("page_no", currPage);
                formData.append("page_size", pageSize);
                formData.append("category", filterValues[0]);
                formData.append("price_range", filterValues[1]);
                formData.append("order", filterValues[2]);

                $.ajax({
                    url: "./controllers/products-filter",
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $(".products-container-overlay").toggleClass("loading");
                    },
                    success: function(response) {
                        response = JSON.parse(response);

                        if (response.success === 1) {
                            allSelects.each(function(index) {
                                $(this).attr("disabled", false);
                            });

                            infoEl.html(`Retrieved ${response.total_size} results`);
                            // dyanmically set page
                            $(".products-container").whjPaging("setPage", {
                                currPage: response.curr_page,
                                totalPage: response.total_page,
                                totalSize: response.total_size
                            });

                            $(".products-container").prepend(`<div class="products">${response.data}</div>`);
                            setTimeout(() => $(".products-container-overlay").toggleClass("loading"), 2000);
                        }
                    }
                });

                // $(".products-container").prepend("<div class='products'>A random text</div>");
            }


            $(".products-container").whjPaging({
                css: 'css-4',
                // the number of entries
                totalSize: 10,
                // the number of pages
                totalPage: 18,
                // shows pagesize select
                isShowPageSizeOpt: true,
                // allows to jump to a specific page
                isShowSkip: false,
                //
                isResetPage: true,
                // shows refresh page
                isShowRefresh: false,
                // shows total pages
                isShowTotalPage: false,
                // shows total entries
                isShowTotalSize: false,
                firstPage: 'first',
                previousPage: 'previous',
                nextPage: 'next',
                lastPage: 'last',
                skip: 'skip',
                pageSizeOpt: [{
                        value: 5,
                        text: '5/page',
                        selected: true
                    },
                    {
                        value: 10,
                        text: '10/page'
                    },
                    {
                        value: 15,
                        text: '15/page'
                    },
                    {
                        value: 20,
                        text: '20/page'
                    }
                ],
                // callback
                callBack: function(currPage, pageSize) {
                    loadData(currPage, pageSize);
                }
            });

            loadData(1, 5);


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
                        url: "../controllers/cart-controller.php",
                        method: "POST",
                        data: {
                            product_id: product_id,
                            action: action
                        },
                        beforeSend: function () {
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
                    })
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
                    beforeSend: function(){
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
        });
    </script>
</body>

</html>