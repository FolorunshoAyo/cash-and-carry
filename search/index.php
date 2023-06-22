<?php
require(dirname(__DIR__) . '/auth-library/resources.php');

// NUMBER FORMATTER
// $human_readable = new \NumberFormatter(
//   'en_US', 
//   \NumberFormatter::PADDING_POSITION
// );
$link="../";
if (!isset($_GET['q']) && empty($_GET['q'])) {
  header("Location: ../");
}

$inSession = (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) || (isset($_SESSION['user_name']) && !empty($_SESSION['user_name']));

if ($inSession) {
  $user_id = $_SESSION['user_id'];
  $user_name = $_SESSION['user_name'];
}

$productQuery = $_GET['q'];
// $searchProducts = $db->query("SELECT * FROM products WHERE deleted='0' AND name LIKE '%$productQuery%';");
//UPDATED QUERY
$searchProducts = $db->query("SELECT * FROM products as p inner join product_categories as pc  ON p.name LIKE '%$productQuery%' or pc.category_name LIKE '%$productQuery%' or details LIKE '%$productQuery%' ORDER BY p.name ASC; ");
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
  <!-- PAGINATE CSS -->
  <link rel="stylesheet" href="../assets/css/jquery.paginate.css">
  <!-- CUSTOM PAGINATE CSS -->
  <link rel="stylesheet" href="../assets/css/custom-paginate.css">
  <!-- CUSTOM CSS (HOME) -->
  <link rel="stylesheet" href="../assets/css/index.css" />
  <!-- CUSTOM STYLESHEET -->
  <link rel="stylesheet" href="../assets/css/search.css" />
  <!-- MEDIA QUERIES -->
  <link rel="stylesheet" href="../assets/css/media-queries/main-media-queries.css" />
   <!-- Font Awesome -->
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../assets/bootstrap-5/css/bootstrap.min.css">
  <title>Search results: <?php echo ($productQuery) ?></title>
</head>

<body>
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
      <a href="../" class="logo-container">
        <div class="logo-image-container">
          <img src="../assets/images/halfcarry-logo.jpeg" alt="Header Logo">
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
        <a href="../all-products/?view-categories">Categories</a>
      </div>
      <div class="search-container">
        <form class="search-box" action="../search/">
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
              <li><a href="../login">Sign In</a></li>
            </ul>
          <?php
          } else {
          ?>
            <ul class="menu">
              <li><a href="../user/">Dashboard</a></li>
              <li><a href="../user/orders">Orders</a></li>
              <li><a href="../logout?rd=home">Log out</a></li>
            </ul>
          <?php
          }
          ?>
        </div>
      </div>
    </div>
  </header>
  <main>
    <div class="info-container">
      <span>Searched for: <?= $productQuery ?>, Retrieved <?= $searchProducts->num_rows ?> results.</span>
    </div>
    <section class="search-result-section">
      <div class="search-result-container">
        <?php
        if ($searchProducts->num_rows === 0) {
        ?>
          <div class="no-result-container">
            No products matching your query was found.
          </div>
        <?php
        } else {
        ?>
          <div id="available-goods" class="available-goods">
            <?php
            while ($rowProduct = $searchProducts->fetch_assoc()) {
              $interest_amount = (30 / 100) * $rowProduct['price'];

              $installment_price = $rowProduct['price'] + $interest_amount;

              $calculatedPeriods = getDaysWeeks($rowProduct['duration_of_payment']);

              $calculatedDays = $calculatedPeriods['days'];
              $calculatedWeeks = $calculatedPeriods['weeks'];
              $calculatedMonths = $calculatedPeriods['months'];
            ?>
              <a href="../product/?pid=<?php echo ($rowProduct['product_id']) ?>" class="available-good">
                <figure>
                  <img src="../assets/product-images/<?php echo (explode(",", $rowProduct['pictures'])[0]) ?>" alt="<?php echo ($rowProduct['name']) ?>" />
                  <figcaption>
                    <div class="payment-plans">
                      <span class="product-badge daily">₦<?php echo number_format(($installment_price / $calculatedDays), 2) ?>/day (<?= $calculatedPeriods['days'] ?> days)</span>
                      <span class="product-badge weekly">₦<?php echo number_format(($installment_price / $calculatedWeeks), 2) ?>/week (<?= $calculatedPeriods['weeks'] ?> weeks)</span>
                      <span class="product-badge month">₦<?php echo number_format(($installment_price / $calculatedMonths), 2) ?>/month (<?= $calculatedPeriods['months'] ?> months)</span>
                    </div>
                    <span class="product-desc product-category-name"><?= $rowProduct['name'] ?></span>
                    <span class="product-desc product-category-price">
                      ₦ <?php echo number_format($rowProduct['price'], 2) ?>
                    </span>
                  </figcaption>
                </figure>
              </a>
            <?php
            }
            ?>
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
  <!-- FONT AWESOME JIT SCRIPT-->
  <script src="https://kit.fontawesome.com/3ae896f9ec.js" crossorigin="anonymous"></script>
  <!-- JQUERY SCRIPT -->
  <script src="../assets/js/jquery/jquery-3.6.min.js"></script>
  <!-- JQUERY MIGRATE SCRIPT (FOR OLDER JQUERY PACKAGES SUPPORT)-->
  <script src="../assets/js/jquery/jquery-migrate-1.4.1.min.js"></script>
  <!-- JQUERY PAGINATE -->
  <script src="../assets/js/jquery.paginate.js"></script>
  <script>
    $("#available-goods").paginate({
      scope: $(".available-good"),
      paginatePosition: ['top'],
      perPage: 10
    });

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
  </script>
</body>

</html>