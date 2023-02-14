<?php
  require(__DIR__ . '/auth-library/resources.php');
  Auth::User("./login");

  $userID = $_SESSION['user_id'];

  if(isset($_SESSION['ordered_product_info']) && !empty($_SESSION['ordered_product_info'])){
    $selectedProductDetails = $_SESSION['ordered_product_info'];

    $product_name = $selectedProductDetails['name'];
    $qty = $selectedProductDetails['quantity'];
    $price = $selectedProductDetails['price'];
    $image = $selectedProductDetails['image'];

    $sql_user_address = $db->query("SELECT *
    FROM addresses INNER JOIN user_addresses ON 
    addresses.address_id = user_addresses.address_id WHERE user_id={$userID} AND active=1");

    $sql_user_email_sql = $db->query("SELECT email FROM users WHERE user_id={$userID}");

    $email = $sql_user_email_sql->fetch_assoc()['email'];

    $_SESSION['email'] = $email;
  }else{
    header("Location: ./");
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
    <!-- CONFIRMATION CSS -->
    <link rel="stylesheet" href="assets/css/checkout.css">
    <!-- MEDIA QUERIES -->
    <link rel="stylesheet" href="assets/css/media-queries/main-media-queries.css">
    <title>Checkout - Confidence Daily Savings (CDS)</title>
</head>
<body>
    <div class="full-loader">
      <div class="spinner"></div>
    </div>
    <header>
        <div class="header-title-container">
            <h1>Confirm & Order</h1>
        </div>
        <div class="cancel-container">
            <a href="./product?pid=<?php echo $selectedProductDetails['pid'] ?>">
                <i class="fa fa-times"></i>
            </a>
        </div>
    </header>
    <main>
        <div class="order-container">
            <section class="product-info-container">
                <div class="product-info">
                    <div class="product-image-container">
                        <img src="<?php echo $image ?>" alt="Iphone Green">
                    </div>
                    <div class="order-information">
                        <span class="product-name"><?php echo $product_name ?></span>
                        <span class="product-quantity">Qty: <?php echo $qty ?></span>
                        <span class="product-price-single">₦<?php echo number_format(intval($price)) ?></span>
                    </div>
                </div>
            </section>
            <section class="user-details">
                <div class="info-card">
                    <h2 class="card-title">
                        User Checkout
                    </h2>
                    <div class="card-body">
                        <p>
                            <i class="fa fa-home"></i>
                            <?php echo $email;?>
                        </p>
                    </div>
                </div>
                <div class="info-card">
                    <h2 class="card-title">
                        Shipping Information
                    </h2>
                    <div class="card-body">
                        <?php
                            if($sql_user_address->num_rows === 0){
                        ?>
                        <p>You do not have an address yet. Click <a href="user/add-address">here</a> to create one.</p>
                        <?php
                            }else{
                                $address_details = $sql_user_address->fetch_assoc();
                        ?>
                        <p>
                            <i class="fa fa-user"></i>
                            <?php echo $address_details['recipient_name'] ?>
                        </p>
                        <p>
                            <i class="fa fa-home"></i>
                            <?php echo $address_details['delivery_address'] . ", " . $address_details['city_name'] . ". " . $address_details['address_state'] . "." ?>
                        </p>
                        <p>
                            <i class="fa fa-phone"></i>
                            <?php echo $address_details['recipient_phone_no'] ?>
                        </p>
                        <?php
                            }
                        ?>
                    </div>
                </div>
                <div class="info-card">
                    <h2 class="card-title">
                        Payment
                    </h2>
                    <div class="card-body">
                        <p>
                            <i class="fa fa-money"></i>
                            Cash on delivery (default)
                        </p>
                    </div>
                </div>
                <div class="sum-container">
                    <p>
                        <span class="title">Subtotal:</span>
                        <?php 
                            $total = intval($qty) * intval($price);
                        ?>
                        ₦<?php echo number_format(intval($total)) ?>
                    </p>
                    <p>
                        <span class="title"><b>Total Price:</b></span>
                        <b>₦<?php echo number_format(intval($total)) ?></b>
                    </p>
                </div>
                <div class="order-btn-container">
                    <button class="order-btn">
                        <i class="fa fa-shopping-cart"></i>
                        Place Your Order
                    </button>
                </div>
            </section>
        </div>
    </main>
    <!-- FONT AWESOME JIT SCRIPT-->
    <script src="https://kit.fontawesome.com/3ae896f9ec.js" crossorigin="anonymous"></script>
    <!-- JQUERY SCRIPT -->
    <script src="assets/js/jquery/jquery-3.6.min.js"></script>
    <!-- JQUERY MIGRATE SCRIPT (FOR OLDER JQUERY PACKAGES SUPPORT)-->
    <script src="assets/js/jquery/jquery-migrate-1.4.1.min.js"></script>
    <script>
        $(".order-btn-container button").on("click", function(){
            const formData = new FormData();

            formData.append("submit", true);
            formData.append("pid", <?php echo $selectedProductDetails['pid'] ?>);
            formData.append("uid", <?php echo $userID ?>);
            formData.append("amount", <?php echo $qty ?>);
            formData.append("total", <?php echo $total ?>);

            $.ajax({
              url: "./controllers/process-order.php",
              type: "post",
              data: formData,
              processData: false,
              contentType: false,
              beforeSend: function(){
                $(".full-loader").addClass("active");
              },
              success: function (response) {
                response = JSON.parse(response);
                  if(response.success === 1){
                    location.replace("./checkout_success");
                  }else{
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
        });
    </script>
</body>
</html>