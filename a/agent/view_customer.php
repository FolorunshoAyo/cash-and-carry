<?php
require(dirname(dirname(__DIR__)) . '/auth-library/resources.php');
AgentAuth::User("a/login");

$agent_id = $_SESSION['agent_id'];

if (isset($_GET['uid']) && !empty($_GET['uid'])) {
    $uid = $_GET['uid'];

    $sql_agent_customer_details = $db->query("SELECT * FROM users WHERE user_id={$uid}");

    if($sql_agent_customer_details->num_rows === 1){
        $customer_details = $sql_agent_customer_details->fetch_assoc();
    }else{
        header("Location: ./");
    }
    
} else {
    header("Location: ./");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Custom Fonts (Inter) -->
    <link rel="stylesheet" href="../../assets/fonts/fonts.css" />
    <!-- BASE CSS -->
    <link rel="stylesheet" href="../../assets/css/base.css" />
    <!-- FORM CSS -->
    <link rel="stylesheet" href="../../assets/css/form.css" />
    <!-- ADMIN FORM CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash/admin-form.css">
    <!-- ADMIN DASHBOARD MENU CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash-menu.css" />
    <!-- DASHHBOARD MEDIA QUERIES -->
    <link rel="stylesheet" href="../../assets/css/media-queries/admin-dash-mediaqueries.css" />
    <style>
        .address-cards {
            margin-top: 10px;
        }

        .address-count {
            font-size: 2rem;
        }

        .address-card {
            box-shadow: rgba(17, 17, 26, 0.05) 0px 1px 0px, rgba(17, 17, 26, 0.1) 0px 0px 8px;
            padding: 2rem;
            border-radius: 10px;
            font-size: 1.5rem;
        }

        .address-card:not(:last-child) {
            margin-bottom: 20px;
        }

        .address-count {
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .address-card p {
            margin-bottom: 10px;
        }

        .address-label {
            color: var(--primary-color);
            font-weight: bold;
        }

        .address-value {
            line-height: 1.5;
        }

        .address-info:not(:last-child) {
            margin-bottom: 10px;
        }

        .address-status-container {
            text-align: end;
            margin-top: 10px;
        }

        .address-status-container {
            display: inline-block;
            padding: 1rem 2rem;
            border-radius: 10px;
            background-color: var(--primary-color);
            color: var(--white);
        }
    </style>
    <title>View customer - Hallfcarry Agent</title>
</head>

<body style="background-color: #fafafa">
    <div class="dash-wrapper">
        <?php
        include("includes/agent-sidebar.php");
        ?>
        <section class="page-wrapper">
            <header class="dash-header">
                <a href="./" class="back-link">
                    <i class="fa fa-arrow-left"></i>
                </a>
            </header>
            <div class="form-wrapper">
                <h2 class="form-title">Customer Details</h2>

                <div class="form-container">
                    <form id="customer-upload-form">
                        <div class="form-groupings">
                            <div class="form-group-container">
                                <div class="form-group-container">
                                    <div class="form-group animate">
                                        <input type="text" name="fname" id="fname" class="form-input" placeholder=" " value="<?= $customer_details['first_name'] ?>" disabled />
                                        <label for="fname">First Name</label>
                                    </div>
                                </div>

                                <div class="form-group-container">
                                    <div class="form-group animate">
                                        <input type="text" name="lname" id="lname" class="form-input" placeholder=" " value="<?= $customer_details['last_name'] ?>" disabled />
                                        <label for="lname">Last Name</label>
                                    </div>
                                </div>

                                <!-- <div class="form-group-container">
                                    <div class="form-group animate">
                                        <input type="text" name="oname" id="oname"
                                            class="form-input" placeholder=" " value="Ayomide" required />
                                        <label for="oname">Other Name</label>
                                    </div>
                                </div> -->

                                <!-- <div class="form-group-container">
                                    <h3 class="static-label">Email</h3>
                                    <span class="static-value">folushoayomide11@gmail.com</span>
                                </div> -->

                                <div class="form-group-container">
                                    <div class="form-group animate">
                                        <input type="text" name="email" id="email" class="form-input" placeholder=" " value="<?php echo $customer_details['email'] ?>" disabled />
                                        <label for="email">Email</label>
                                    </div>
                                </div>

                                <div class="form-group-container">
                                    <div class="form-group animate">
                                        <input type="number" name="phoneno" id="phoneno" class="form-input" placeholder=" " value="<?= $customer_details['phone_no'] ?>" disabled />
                                        <label for="phoneno">Phone</label>
                                    </div>
                                </div>

                                <h2 class="product-form-title">Customer Addresses</h2>

                                <?php
                                $sql_check_addresses = $db->query("SELECT * FROM users_addresses WHERE user_id = {$uid}");

                                $hasAddress = $sql_check_addresses->num_rows > 0;

                                if ($hasAddress) {
                                ?>
                                    <div class="address-cards">
                                        <?php
                                        $get_user_addresses = $db->query("SELECT * FROM users_addresses WHERE user_id={$uid}");
                                        $count = 1;
                                        while ($address = $get_user_addresses->fetch_assoc()) {
                                            $get_address_details = $db->query("SELECT * FROM adddresses WHERE address_id = {$address['address_id']}");

                                            $address_details = $get_address_details->fetch_assoc();

                                        ?>
                                            <div class="address-card">
                                                <h3 class="address-count">#<?= $count ?></h3>

                                                <p>Recipients info:</p>
                                                <div class="address-info">
                                                    <span class="address-label">Name:</span>
                                                    <span class="address-value"><?= $address_details['recipient_name'] ?></span>
                                                </div>
                                                <div class="address-info">
                                                    <span class="address-label">Phone no:</span>
                                                    <span class="address-value"><?= $address_details['recipient_phone_no'] ?></span>
                                                </div>
                                                <div class="address-info">
                                                    <span class="address-label">Delivery Address:</span>
                                                    <span class="address-value">Plot 5a, Olaoluwa Ige St. Ikorodu, Ogun State. (1102345)</span>
                                                </div>
                                                <?php
                                                if ($address_details['additional_information']) {
                                                ?>
                                                    <div class="address-info">
                                                        <span class="address-label">Additional Info:</span>
                                                        <span class="address-value"><?= $address_details['additional_information'] ?></span>
                                                    </div>
                                                <?php
                                                }
                                                if ($address['active'] === "1") {
                                                ?>
                                                    <div class="address-status-container">
                                                        <span>active</span>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    <?php
                                } else {
                                    echo "<p style='text-align: center; font-size: 2rem; color: var(--primary-color)'>No address yet</p>";
                                }
                                    ?>
                                    </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <!-- FONT AWESOME JIT SCRIPT-->
    <script src="https://kit.fontawesome.com/3ae896f9ec.js" crossorigin="anonymous"></script>
    <!-- JQUERY SCRIPT -->
    <script src="../../assets/js/jquery/jquery-3.6.min.js"></script>
    <!-- JQUERY MIGRATE SCRIPT (FOR OLDER JQUERY PACKAGES SUPPORT)-->
    <script src="../../assets/js/jquery/jquery-migrate-1.4.1.min.js"></script>
    <!-- METIS MENU JS -->
    <script src="../../assets/js/metismenujs/metismenujs.js"></script>
    <!-- SWEET ALERT PLUGIN -->
    <script src="../../auth-library/vendor/dist/sweetalert2.all.min.js"></script>
    <!-- JUST VALIDATE LIBRARY -->
    <script src="../../assets/js/just-validate/just-validate.js"></script>
    <!-- DASHBOARD SCRIPT -->
    <script src="../../assets/js/admin-dash.js"></script>
</body>

</html>