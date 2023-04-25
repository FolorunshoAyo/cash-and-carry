<?php
require(dirname(__DIR__) . '/auth-library/resources.php');
Auth::User("login");
$user_id = $_SESSION['user_id'];
//==================================================================

//CHECK IF ALL THE DATA ARE IN SESSION
if (isset($_SESSION['amount_to_pay']) && isset($_SESSION['start_period']) && isset($_SESSION['end_period']) && isset($_SESSION['period_to_pay']) && isset($_SESSION['wallet_no'])) {
    //GET ALL THE SAVINGS INFO FROM SESSION
    $amount_to_pay = $_SESSION['amount_to_pay'];
    $start_period = $_SESSION['start_period'];
    $end_period = $_SESSION['end_period'];
    $installment_type = $_SESSION['installment_type'];
    $wallet_no = $_SESSION['wallet_no'];
} else {
    //IF NO DATA ARE FOUND, REDIRECT BACK TO ADD SAVINGS PAGE
    header("Location: ./savings?active");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon Icon -->
    <link rel="icon" href="../assets/images/halfcarry-logo.jpg">
    <!-- Custom Fonts (KyivType Sans and Inter) -->
    <link rel="stylesheet" href="../assets/css/fonts.css">
    <!-- BASE CSS -->
    <link rel="stylesheet" href="../assets/css/base.css">
    <!-- PLAN PREVIEW CSS -->
    <link rel="stylesheet" href="../assets/css/dashboard/user-dash/savings-preview.css">
    <!-- MEDIA QUERIES (DASHBOARD) -->
    <link rel="stylesheet" href="../assets/css/media-queries/user-dash-mediaqueries.css">
    <title>Savings Summary - HalfCarry</title>
</head>

<body>
    <!-- SPINNER -->
    <div class="spinner-wrapper">
        <div class="spinner-container">
            <img src="../assets/images/halfcarry-logo.jpeg" alt="Halfcarry Logo">
            <div class="spinner"></div>
        </div>
    </div>
    <header class="plan-summary-header">
        <div class="icon-container">
            <i class="fa fa fa-arrow-left"></i>
        </div>
        <h2>Savings Summary</h2>
    </header>

    <section class="plan-summary-section">
        <div class="plan-summary-container">
            <div class="plan-infos">
                <div class="plan-info plan-amount">
                    <div class="plan-label">
                        Amount
                    </div>
                    <div class="plan-value">
                        <span class="currency">NGN</span>
                        <?= number_format($amount_to_pay, 2) ?>
                    </div>
                </div>
                <div class="plan-info plan-amount">
                    <div class="plan-label">
                        Frequency
                    </div>
                    <div class="plan-value">
                        <?= $installment_type === "1" ? "Daily" : ($installment_type === "2" ? "Weekly" : "Monthly") ?>
                    </div>
                </div>
                <div class="plan-info plan-amount">
                    <div class="plan-label">
                        <?= $installment_type === "1" ? "Days" : ($installment_type === "2" ? "Weeks" : "Months") ?> Range
                    </div>
                    <div class="plan-value">
                        <?php
                        $period_suffix = $installment_type === "1" ? "day(s)" : ($installment_type === "2" ? "week(s)" : "month(s)");
                        echo ($start_period === "1" && $end_period === "1") ? "$start_period $period_suffix" : "$start_period - $end_period $period_suffix";
                        ?>
                    </div>
                </div>
                <div class="plan-info plan-amount">
                    <div class="plan-label">
                        Lock Status
                    </div>
                    <div class="plan-value">
                        Locked
                    </div>
                </div>
            </div>
            <div class="continue-btn-container">
                <button class="btn">
                    Continue
                </button>
            </div>
        </div>
    </section>
    <!-- JQUERY SCRIPT -->
    <script src="../assets/js/jquery/jquery-3.6.min.js"></script>
    <!-- JQUERY MIGRATE SCRIPT (FOR OLDER JQUERY PACKAGES SUPPORT)-->
    <script src="../assets/js/jquery/jquery-migrate-1.4.1.min.js"></script>
    <!-- TOASTER PLUGIN -->
    <script src="../auth-library/vendor/dist/sweetalert2.all.min.js"></script>
    <script src="https://checkout.flutterwave.com/v3.js"></script>
    <script>
        function makePayment(x, final_amt) {
            FlutterwaveCheckout({
                // public_key: "FLWPUBK-8a73c7e27bc482383e107f69056d6c48-X",
                public_key: "FLWPUBK_TEST-9907ef66591a80edfb5c7ea51208031d-X",
                tx_ref: x,
                amount: final_amt,
                currency: "NGN",
                payment_options: "card, banktransfer, ussd",
                // redirect_url: `https://studentextra.codeweb.ng/student/controllers/process`,
                redirect_url: `https://localhost/cash-and-carry/user/controllers/process`,

                customer: {
                    email: "info@halfcarry.com.ng",
                    phone_number: "123456789",
                    name: "Halfcarry",
                },
                customizations: {
                    title: "Savings Deposit",
                    description: '',
                    logo: "https://halfcarry.com.ng/assets/images/halfcarry-logo.jpeg",
                },
            });
        }

        function generateTransaction_ref() {
            var randm = Math.floor((Math.random() * 100000000) + 1);
            var tran = "TRX-";
            return tran + randm;
        }

        $(".continue-btn-container button").on("click", function() {
            // GENERATING TRANSACTION REF:
            const tranx_ref = generateTransaction_ref();
            const btnEl = $(this);
            const formData = new FormData();

            formData.append("submit", true);
            formData.append("tx_ref", tranx_ref);
            formData.append("wallet_no", <?= $wallet_no ?>);


            $.ajax({
                url: 'controllers/create-savings.php',
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $(".spinner-wrapper").addClass("active");
                    btnEl.html("loading...");
                    btnEl.attr("disabled", true);
                },
                success: function(response) {
                    response = JSON.parse(response);

                    if (response.success === 1) {
                        $(".spinner-wrapper").removeClass("active");
                        btnEl.html("continue");
                        btnEl.attr("disabled", false);
                        makePayment(tranx_ref, response.amount_charged);
                    } else {
                        // ALERT THE USER UPON FAILED REQUEST/RESPONSE
                        $(".spinner-wrapper").removeClass("active");
                        btnEl.html("continue");
                        btnEl.attr("disabled", false);
                        console.error(response.error_message);
                    }
                }
            });
        });
    </script>
</body>

</html>