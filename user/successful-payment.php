<?php
    if(isset($_SESSION['duration_of_savings']) && isset($_SESSION['period_to_pay']) && isset($_SESSION['installment_type'])){
        $period_payed = $_SESSION['period_to_pay'];
        $duration_of_savings = $_SESSION['duration_of_savings'];
        $installment_type = $_SESSION['installment_type'];
    }else{
        header("location: ./wallet");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon Icon -->
    <link rel="icon" href="../assets/images/logo.jpg">
    <!-- Custom Fonts (KyivType Sans and Inter) -->
    <link rel="stylesheet" href="../assets/fonts/fonts.css">
    <!-- BASE CSS -->
    <link rel="stylesheet" href="../assets/css/base.css">
    <!-- MEDIA QUERIES (MAIN) -->
    <link rel="stylesheet" href="../assets/css/media-queries/main-media-queries.css">
    <title>Payment successful - Halfcarry</title>
    <style>
        .success-wrapper{
            background-color: #fafafa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .success-container{
            text-align: center;
        }

        .success-container img{
            width: 100px;
            height: 100px;
            margin-bottom: 10px;
        }

        .success-container .success-title, .success-container .success-text{
            font-family: "monserrat", sans-serif;
        }

        .success-container .success-title{
            color: var(--primary-color);
            font-size: 3rem;
        }

        .success-container .success-text{
            font-size: 1.5rem;
            margin-top: 10px;
        }

    </style>
</head>
<body>
    <div class="success-wrapper">
        <div class="success-container">
            <img src="../assets/images/check-icon.png" />
            <h2 class="success-title">Payment Successful</h2>
            <?php
            $period_suffix =  $installment_type === "1" ? "day(s)" : ($installment_type === "2" ? "week(s)" : "month(s)");
            ?>
            <p class="success-text">We have recieved your payment and you have saved for <?= $period_payed . " " . $period_suffix ?> weeks out of <?= $duration_of_savings . " " . $period_suffix ?> weeks.</p>
            <p class="success-text">Please wait, you will be redirected soon</p>
        </div>
    </div>
     <!-- FONT AWESOME JIT SCRIPT-->
     <script
     src="https://kit.fontawesome.com/3ae896f9ec.js"
     crossorigin="anonymous"
   ></script>
   <script>
        setTimeout(()=> {
            window.location.replace("./wallet");
        }, 3500);
   </script>
</body>
</html>

<?php
    unset($_SESSION['period_to_pay']);
    unset($_SESSION['duration_of_savings']);
    unset($_SESSION['installment_type']);
?>