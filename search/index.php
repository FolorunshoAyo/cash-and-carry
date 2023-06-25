<?php
require(dirname(__DIR__) . '/auth-library/resources.php');

// NUMBER FORMATTER
// $human_readable = new \NumberFormatter(
//   'en_US', 
//   \NumberFormatter::PADDING_POSITION
// );
$link = "../";
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
$searchProducts = $db->query("SELECT * FROM products as p inner join product_categories as pc ON p.category = pc.category_id WHERE p.name = '%$productQuery%' or pc.category_name LIKE '%$productQuery' or details LIKE '%$productQuery%' ORDER BY p.name ASC; ");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="../assets/bootstrap-5/css/bootstrap.min.css">
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
  <title>Search results: <?php echo ($productQuery) ?></title>
</head>

<body>
  <?php
  include_once("../includes/cart.php");
  include_once("../includes/savings-request-modal.php");
  include_once("../includes/header.php");
  ?>
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
              $interest_rate = $rowProduct['duration_of_payment'] === "6" ? 30 : 20;

              $interest_amount = ($interest_rate / 100) * $rowProduct['price'];

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
    function displayActiveRequest() {
      $(".savings-request-modal-wrapper").addClass("active");
    }

    // ACTIVE SAVINGS REQUEST MODAL EVENT
    $(document).on("click", ".savings-request-modal .modal-header .close-container", function() {
      $(".savings-request-modal-wrapper").removeClass("active");
    });

    $("#available-goods").paginate({
      scope: $(".available-good"),
      paginatePosition: ['top'],
      perPage: 10
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
  </script>
</body>

</html>