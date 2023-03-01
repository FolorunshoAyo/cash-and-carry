<?php
require(dirname(__DIR__) . '/auth-library/resources.php');

// NUMBER FORMATTER
// $human_readable = new \NumberFormatter(
//   'en_US', 
//   \NumberFormatter::PADDING_POSITION
// );

if (!isset($_GET['q']) && empty($_GET['q'])) {
  header("Location: ../");
}

$inSession = (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) || (isset($_SESSION['user_name']) && !empty($_SESSION['user_name']));

if ($inSession) {
  $user_id = $_SESSION['user_id'];
  $user_name = $_SESSION['user_name'];
}

$productQuery = $_GET['q'];
$searchProducts = $db->query("SELECT * FROM products WHERE name LIKE '%$productQuery%';");
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
  <link rel="stylesheet" href="../assets/css/pagination.css">
  <!-- CUSTOM CSS (HOME) -->
  <link rel="stylesheet" href="../assets/css/index.css" />
  <!-- CUSTOM STYLESHEET -->
  <link rel="stylesheet" href="../assets/css/search.css" />
  <!-- MEDIA QUERIES -->
  <link rel="stylesheet" href="../assets/css/media-queries/main-media-queries.css" />
  <title>Search results: <?php echo ($productQuery) ?></title>
</head>

<body>
  <header>
    <div class="top-header">
      <a href="../" class="logo-container">
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
    <section class="search-result-header">
      <div class="search-result-header-container">
        <h1 class="search-result-heading">Search Results for: <?php echo ($productQuery) ?></h1>
      </div>
    </section>
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
              <a href="../product?pid=<?php echo ($productID) ?>" class="available-good">
                <figure>
                  <img src="../a/admin/images/<?php echo (explode(",", $rowProduct['pictures'])[0]) ?>" alt="<?php echo ($rowProduct['name']) ?>" />
                  <figcaption>
                    <div class="payment-plans">
                      <span class="product-badge daily">₦<?php echo number_format(($installment_price / $calculatedDays), 2) ?>/day</span>
                      <span class="product-badge weekly">₦<?php echo number_format(($installment_price / $calculatedWeeks), 2) ?>/week</span>
                      <span class="product-badge month">₦<?php echo number_format(($installment_price / $calculatedMonths), 2) ?>/month</span>
                    </div>
                    <span class="product-desc product-category-name"><?= $rowProduct['name'] ?></span>
                    <span class="product-desc product-category-price">
                      ₦ <?php echo number_format($rowProduct['price'], 2) ?>
                    </span>
                  </figcaption>
                </figure>
              </a>
          </div>
      <?php
            }
          }
      ?>
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
</body>
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
    paginatePosition: ['top']
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

</html>