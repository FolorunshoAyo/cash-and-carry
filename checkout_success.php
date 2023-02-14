<?php
    require(__DIR__ . '/auth-library/resources.php');
    Auth::User("./login");
    $url = strval($url);
    
    if(isset($_SESSION['order_no']) && !empty($_SESSION['order_no'])){
        $order_no = $_SESSION['order_no'];
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
    <!-- Favicon Icon -->
    <link rel="icon" href="assets/images/logo.jpg">
    <!-- Custom Fonts (KyivType Sans and Inter) -->
    <link rel="stylesheet" href="assets/fonts/fonts.css">
    <!-- BASE CSS -->
    <link rel="stylesheet" href="assets/css/base.css">
    <!-- Custom CSS (HOME)) -->
    <link rel="stylesheet" href="assets/css/success.css" type="text/css">
    <!-- MEDIA QUERIES (MAIN) -->
    <link rel="stylesheet" href="assets/css/media-queries/main-media-queries.css">
    <title>Order Successful</title>
    <style>
        .continue-btn-container{
            margin-top: 30px;
            text-align: center;
        }

        .continue-btn{
            width: 70%;
            color: var(--white);
            background-color: var(--primary-color);
            border: none;
            padding: 2rem 3rem;
            border-radius: 10px;
            display: inline-block;
            text-align: center;
            text-decoration: none;
        }

        .success-text.large{
            font-size: 2rem;
        }
    </style>
</head>
<body>
    <div class="success-wrapper">
        <div class="success-container">
            <i class="fa fa-check-circle-o" aria-hidden="true"></i>
            <h2 class="success-title">You order has been recieved </h2>
            <p class="success-text large">Thank you for your purchase !</p><br>
            <p>Your order ID is: <?php echo $order_no ?></p><br>
            <p>You would recieve an order confirmation email with details of your order</p>
            <div class="continue-btn-container">
                <a href="./" class="continue-btn">Continue Shopping</a>
            </div>
        </div>
    </div>
     <!-- FONT AWESOME JIT SCRIPT-->
     <script
     src="https://kit.fontawesome.com/3ae896f9ec.js"
     crossorigin="anonymous"
   ></script>
</body>
</html>

<?php
    $email = $_SESSION['email'];
    $subject = "CDS Order Confirmation";
    $product_name = $_SESSION['ordered_product_info']['name'];
    $product_quantity =  $_SESSION['ordered_product_info']['quantity'];

    $message = "<div class='container'>
				  <div class='image-container'>
				  	<img src='" . $url . "/assets/images/logo-small.png' alt='logo'/>
				  </div>
                  <div class='box'>
                    <h2>". greeting() . "!</h2>
                    <p>This mail is to confirm the order(#$order_no) with the following information:</p>                              
                    <p>Product Name: $product_name</p>                              
                    <p>Quantity: $product_quantity</p>                              
                    <p><b>NB:</b> Orders are non-refundable</p>                              
                  </div>
                </div>";

	send_raw_mail($email, $subject, $message);  

    unset($_SESSION['order_no']);
    unset( $_SESSION['ordered_product_info']);
    unset($_SESSION['email']);
?>