<?php
session_start();

if (isset($_SESSION['order_no']) && isset($_SESSION['order_type'])) {
    $order_no = $_SESSION['order_no'];
    $order_type = $_SESSION['order_type'];
}else{
    header("cart/");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon Icon -->
    <link rel="icon" href="assets/images/logo.jpg">
    <!-- Custom Fonts (KyivType Sans and Inter) -->
    <link rel="stylesheet" href="assets/fonts/fonts.css">
    <!-- BASE CSS -->
    <link rel="stylesheet" href="assets/css/base.css">
    <!-- MEDIA QUERIES (MAIN) -->
    <link rel="stylesheet" href="assets/css/media-queries/main-media-queries.css">
    <title>Order placed successfully - Halfcarry</title>
    <style>
        .success-wrapper {
            background-color: #fafafa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .success-container {
            text-align: center;
        }

        .success-container img {
            width: 100px;
            height: 100px;
            margin-bottom: 10px;
        }

        .success-container .success-title,
        .success-container .success-text {
            font-family: "monserrat", sans-serif;
        }

        .success-container .success-title {
            color: var(--primary-color);
            font-size: 3rem;
        }

        .success-container .success-text {
            font-size: 1.5rem;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="success-wrapper">
        <div class="success-container">
            <img src="assets/images/check-icon.png" />
            <h2 class="success-title">Order Placed Successfullly</h2>
            <?php
            if ($order_type === "1") {
            ?>
                <p class="success-text">We have recieved your payment and your order has been placed.</p>
            <?php
            } else {
            ?>
                <p class="success-text">We have recieved your order and it is being processed.</p>
            <?php
            }
            ?>
            <p class="success-text">Please wait, you will be redirected soon.</p>
        </div>
    </div>
    <!-- FONT AWESOME JIT SCRIPT-->
    <script src="https://kit.fontawesome.com/3ae896f9ec.js" crossorigin="anonymous"></script>
    <script>
        setTimeout(() => {
            window.location.replace("./user/order-details?oid=<?= $order_no ?>");
        }, 3500);
    </script>
</body>

</html>

<?php
unset($_SESSION['order_no']);
?>