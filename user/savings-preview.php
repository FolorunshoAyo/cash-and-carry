<?php
require(dirname(dirname(__DIR__)) . '/auth-library/resources.php');
Auth::User("login");
$user_id = $_SESSION['user_id'];
//==================================================================

//CHECK IF ALL THE DATA ARE IN SESSION
if (isset($_SESSION['amount']) && isset($_SESSION['savings_duration'])) {
    //GET ALL THE SAVINGS INFO FROM SESSION
    $get_amount = $_SESSION['amount'];
    $get_days = $_SESSION['savings_duration'];

}else{
    //IF NO DATA ARE FOUND, REDIRECT BACK TO ADD SAVINGS PAGE
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
    <link rel="icon" href="../assets/images/halfcarry-logo.jpg">
    <!-- Custom Fonts (KyivType Sans and Inter) -->
    <link rel="stylesheet" href="../assets/css/fonts.css">
    <!-- BASE CSS -->
    <link rel="stylesheet" href="../assets/css/base.css">
    <!-- PLAN PREVIEW CSS -->
    <link rel="stylesheet" href="../assets/css/dashboard/user-dash/savings-preview.css">
    <!-- MEDIA QUERIES (DASHBOARD) -->
    <link rel="stylesheet" href="../assets/css/mediaqueries/dash-mediaqueries.css">
    <title>Savings Summary - HalfCarry</title>
</head>

<body>
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
                        <?php echo(number_format($get_amount, 2)) ?>
                    </div>
                </div>
                <div class="plan-info plan-amount">
                    <div class="plan-label">
                        Frequency
                    </div>
                    <div class="plan-value">
                        Daily
                    </div>
                </div>
                <!-- <div class="plan-info plan-amount">
                    <div class="plan-label">
                        Start date
                    </div>
                    <div class="plan-value">
                        <?php // echo($get_start_date) ?>
                    </div>
                </div>
                <div class="plan-info plan-amount">
                    <div class="plan-label">
                        End date
                    </div>
                    <div class="plan-value">
                        <?php // echo($get_end_date) ?>
                    </div>
                </div> -->
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
    <script src="../../assets/js/jquery/jquery-3.6.min.js"></script>
    <!-- JQUERY MIGRATE SCRIPT (FOR OLDER JQUERY PACKAGES SUPPORT)-->
    <script src="../../assets/js/jquery/jquery-migrate-1.4.1.min.js"></script>
    <!-- TOASTER PLUGIN -->
    <script src="../../auth-library/vendor/dist/sweetalert2.all.min.js"></script>
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
                redirect_url: `https://localhost/studentextra/student/controllers/process`,

                customer: {
                    email: "info@codeweb.ng",
                    phone_number: "123456789",
                    name: "CODEWEB",
                },
                customizations: {
                    title: "Savings Deposit",
                    description: '',
                    logo: "https://studentxtra.codeweb.ng/assets/images/studentxtra-logo.jpg",
                },
            });
        }

        function generateTransaction_ref() {
            var randm = Math.floor((Math.random() * 100000000) + 1);
            var tran = "TRX-";
            return tran + randm;
        }

        $(".continue-btn-container button").on("click", function () {
            // GENERATING TRANSACTION REF:
            const tranx_ref = generateTransaction_ref();

            const formData = new FormData();

            formData.append("submit", true);
            formData.append("tx_ref", tranx_ref);


            $.ajax({
                url: '../controllers/create-savings.php',
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $(this).html("loading...");
                },
                success: function (response) {
                    response = JSON.parse(response);

                    if (response.success === 1) {

                        makePayment(tranx_ref, response.amount_charged);

                    } else {
                        // ALERT THE USER UPON FAILED REQUEST/RESPONSE
                        console.error(response.error_message);
                    }
                }
            });
        });
    </script>
</body>

</html>