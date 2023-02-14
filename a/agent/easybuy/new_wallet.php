<?php
    require(dirname(dirname(dirname(__DIR__))) . '/auth-library/resources.php');
    AgentAuth::User("a/login");

    $agent_id = $_SESSION['agent_id'];

    if(isset($_GET['cid']) && !empty($_GET['cid'])){
        $cid = $_GET['cid'];
        
        // CONFIRM IF A WALLET IS EXISTING
        $sql_check_existing_wallet = $db->query("SELECT * FROM easybuy_wallets WHERE agent_customer_id = {$cid} AND completed='0'");
        $can_create_wallet = ($sql_check_existing_wallet->num_rows === 0);

        if(!$can_create_wallet){
            header("Location: ./");
        }

        $sql_agent_customer_details = $db->query("SELECT * FROM easybuy_agent_customers WHERE agent_customer_id={$cid}");
    
        $customer_details = $sql_agent_customer_details->fetch_assoc();
    }else{
        header("Location: ./");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- JQUERY DATATABLES CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <!-- DROP DOWN MENU CSS -->
    <link rel="stylesheet" href="../../../assets/css/dropdown.css" />
    <!-- Custom Fonts (Inter) -->
    <link rel="stylesheet" href="../../../assets/fonts/fonts.css" />
    <!-- BASE CSS -->
    <link rel="stylesheet" href="../../../assets/css/base.css" />
    <!-- FORMS CSS -->
    <link rel="stylesheet" href="../../../assets/css/form.css">
    <!-- ADMIN DASHBOARD MENU CSS -->
    <link rel="stylesheet" href="../../../assets/css/dashboard/admin-dash-menu.css" />
    <!-- ADMIN TABLE CSS -->
    <link rel="stylesheet" href="../../../assets/css/dashboard/admin-dash/admin-table.css">
    <!-- ADMIN AGENT CSS -->
    <link rel="stylesheet" href="../../../assets/css/dashboard/admin-dash/agents.css">
    <!-- ADMIN PRODUCTS CSS -->
    <link rel="stylesheet" href="../../../assets/css/dashboard/admin-dash/products.css">
    <!-- MAIN TABLE CSS -->
    <link rel="stylesheet" href="../../../assets/css/dashboard/admin-dash/main-table.css">
    <!-- DASHHBOARD MEDIA QUERIES -->
    <link rel="stylesheet" href="../../../assets/css/media-queries/admin-dash-mediaqueries.css" />
    <style>
        .form-container {
            width: 95%;
            margin: 0 auto;
        }

        .product-title {
            text-align: initial;
        }

        .add-container a {
            width: 150px;
        }
    </style>
    <title>Create new wallet - CDS AGENT</title>
</head>

<body style="background-color: #fafafa">
    <div class="dash-wrapper">
        <div class="mobile-backdrop"></div>
        <aside class="dash-menu">
            <div class="logo">
                <div class="menu-icon">
                    <i class="fa fa-bars"></i>
                    <i class="fa fa-times"></i>
                </div>
                <a href="#" class="logo">
                    <i class="fa fa-home"></i>
                    <span> CDS AGENT </span>
                </a>
            </div>
            <ul class="side-menu" id="side-menu">
                <li class="nav-item">
                    <a href="../">
                        <i class="fa fa-users"></i>
                        <span>Customers</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)">
                        <i class="fa fa-truck"></i>
                        <span>Shipping</span>
                    </a>
                </li>
                <li class="nav-item active">
                    <a href="./">
                        <i class="fa fa-money"></i>
                        <span>Easy Buy</span>
                    </a>
                </li>
                <li class="nav-item active">
                    <a href="../debtors/">
                        <!-- <span class="blue-dot"></span> -->
                        <i class="fa fa-info-circle"></i>
                        <span>Debtor</span>
                        <!-- <span class="nav-item-badge">1</span> -->
                    </a>
                </li>
            </ul>

            <ul class="side-menu-bottom">
                <li class="nav-item logout">
                    <a href="../../logout">
                        <i class="fa fa-sign-out"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </aside>
        <section class="page-wrapper">
            <div class="table-wrapper">
                <h2 class="table-title">Create Easy Buy wallet for <?php echo ucfirst($customer_details['last_name']) . " " . ucfirst($customer_details['first_name']) ?></h2>

                <div class="table-container">
                    <table class="generic-table">
                        <thead>
                            <tr>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Email
                                </th>
                                <th>
                                    Phone number
                                </th>
                                <th>
                                    Customer ID
                                </th>
                                <th>
                                    BVN
                                </th>
                                <th>
                                    Date added
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 

                            ?>
                            <tr>
                                <td>
                                    <?php echo $customer_details['last_name'] . " " . $customer_details['first_name'] ?>
                                </td>
                                <td>
                                    <?php echo $customer_details['email']? $customer_details['email'] : "No email yet"  ?>
                                </td>
                                <td>
                                    <?= $customer_details['phone_no'] ?>
                                </td>
                                <td>
                                    <span class="id-number">#<?php echo str_pad($customer_details['agent_customer_id'], 4, "0", STR_PAD_LEFT) ?></span>
                                </td>
                                <td>
                                    <?= $customer_details['bvn'] ?>
                                </td>
                                <td>
                                <?php echo date("M d, Y", strtotime($customer_details['created_at'])) ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="form-container">
                    <form id="view-item-form">
                        <div class="form-groupings">
                            <div class="form-group-container">
                                <div class="form-group-container">
                                    <div class="form-group animate">
                                        <select name="productId" id="productId" class="form-input">\\
                                            <option value="">Select product</option>
                                            <?php
                                                $sql_all_products = $db->query("SELECT * FROM products");

                                                while($product = $sql_all_products->fetch_assoc()){
                                            ?>
                                                <option value="<?php echo $product['product_id'] ?>"><?php echo $product['name'] . " (" . "NGN " . number_format($product['price']) . ")"?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                        <label for="productId">Pick Item</label>
                                    </div>
                                </div>

                                <div class="submit-btn-container">
                                    <button type="submit" class="admin-submit-btn">Generate Item details</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="loader-container hide">
                    <div class="loader"></div>
                </div>

                <!-- GENERATED PRODUCT DETAILS HERE -->
                <div class="item-picked-view hide">
                    <div class="table-container">
                        <table class="generic-table wallet-table">
                            <thead>
                                <tr>
                                    <th>
                                        Item picked
                                    </th>
                                    <th>
                                        Product ID
                                    </th>
                                    <th>
                                        Price
                                    </th>
                                    <th>
                                        Duration in months
                                    </th>
                                    <th>
                                        Daily payment
                                    </th>
                                    <th>
                                        Product Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="product-details-container">
                                            <div class="product-img-container">
                                                <img src="../../assets/images/4-runner.jpg" alt="Product Image">
                                            </div>
                                            <div class="product-details">
                                                <span class="product-title">Toyota RAV 4</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span id="product-id">#09878</span>
                                    </td>
                                    <td>
                                        NGN <span id="product-price">24k</span>
                                    </td>
                                    <td>
                                        <span id="product-duration">10</span> Months
                                    </td>
                                    <td>
                                        NGN <span id="product-daily-amount">500</span>
                                    </td>
                                    <td>
                                        <span class="status-badge success">active</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="add-container">
                        <a href="javascript:void(0)">Create EB Wallet</a>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- FONT AWESOME JIT SCRIPT-->
    <script src="https://kit.fontawesome.com/3ae896f9ec.js" crossorigin="anonymous"></script>
    <!-- JQUERY SCRIPT -->
    <script src="../../../assets/js/jquery/jquery-3.6.min.js"></script>
    <!-- JQUERY MIGRATE SCRIPT (FOR OLDER JQUERY PACKAGES SUPPORT)-->
    <script src="../../../assets/js/jquery/jquery-migrate-1.4.1.min.js"></script>
    <!-- METIS MENU JS -->
    <script src="../../../assets/js/metismenujs/metismenujs.js"></script>
    <!-- Sweet Alert JS -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- JQUERY DATATABLE SCRIPT -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <!-- DROP DOWN JS -->
    <script type="text/javascript" src="../../../assets/js/dropdown/dropdown.min.js"></script>
    <!-- JUST VALIDATE LIBRARY -->
    <script src="../../../assets/js/just-validate/just-validate.js"></script>
    <!-- DASHBOARD SCRIPT -->
    <script src="../../../assets/js/admin-dash.js"></script>
    <script>
        $(function () {
            let selectedProductPrice;

            $("#view-item-table").DataTable({
                "pageLength": 10
            });

            const formatCash = n => {
                if (n < 1e3) return n;
                if (n >= 1e3 && n < 1e6) return +(n / 1e3).toFixed(1) + "K";
                if (n >= 1e6 && n < 1e9) return +(n / 1e6).toFixed(1) + "M";
                if (n >= 1e9 && n < 1e12) return +(n / 1e9).toFixed(1) + "B";
                if (n >= 1e12) return +(n / 1e12).toFixed(1) + "T";
            };

            //FORM VALIDATION WITH VALIDATE.JS

            const validation = new JustValidate("#view-item-form", {
                errorFieldCssClass: "is-invalid",
            });

            validation
                .addField("#productId", [
                    {
                        rule: "required",
                        errorMessage: "Field is required",
                    },
                ])
                .onSuccess((event) => {
                    const  form = document.getElementById("view-item-form");

                    const formData = new FormData(form);

                    formData.append("submit", true);

                    const productImageEl = $(".product-img-container img"),
                        productNameEl = $(".product-title"),
                        itemView = $(".item-picked-view"),
                        productIdEl = $("#product-id"),
                        productPriceEl = $("#product-price"),
                        productDurationEl = $("#product-duration"),
                        productDailyAmount = $("#product-daily-amount"),
                        productStatusEl = $(".product-status");

                    $(".loader-container").removeClass("hide");
                    itemView.addClass("hide");
                    setTimeout(() => {

                        $(".loader-container").addClass("hide");
                        itemView.removeClass("hide");
                    }, 5000);

                    //SENDING FORM DATA TO THE SERVER
                    $.ajax({
                        type: "post",
                        url: "../controllers/fetch_product_details.php",
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: "json",
                        beforeSend: function () {
                            $(".loader-container").removeClass("hide");
                            itemView.addClass("hide");
                        },
                        success: function (response) {
                            setTimeout(() => {
                                if (response.success === 1) {
                                    productImageEl.attr("src", `../../admin/images/${response.image}`);
                                    productNameEl.html(response.name);
                                    productIdEl.html(`#${response.pid}`);
                                    productPriceEl.html(formatCash(response.price));
                                    selectedProductPrice = (response.price/2).toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                    productDurationEl.html(response.duration_in_months);
                                    productDailyAmount.html(
                                        //formatCash(response.daily_payment)
                                        "500"
                                    );
                                    productStatusEl.attr("class", `product-status ${response.product_status? "success" : "danger"}`);
                                    productStatusEl.html(response.product_status ? "active" : "inactive");

                                    $(".loader-container").addClass("hide");
                                    itemView.removeClass("hide");

                                    prepareAddWalletButton(response.pid);
                                } else {
                                    if (response.error_title === "fatal") {
                                        // REFRESH CURRENT PAGE
                                        location.reload();
                                    } else {
                                        // ALERT USER
                                        Swal.fire({
                                            title: response.error_title,
                                            icon: "error",
                                            text: response.error_message,
                                            allowOutsideClick: false,
                                            allowEscapeKey: false,
                                        });
                                    }
                                }
                            }, 1500);
                        },
                    });

                });

            function prepareAddWalletButton(productID) {
                const addWalletBtn = $(".add-container a");
                const formData = new FormData();

                formData.append("product_id", productID);
                formData.append("submit", true);
                formData.append("customer_id", "<?= $cid ?>");

                addWalletBtn.on("click", function (e) {

                    if(confirm(`Creating this wallet automatically adds NGN ${selectedProductPrice} to this wallet \n Continue?`)){
                        $.ajax({
                            type: "post",
                            url: "controllers/add_wallet.php",
                            data: formData,
                            contentType: false,
                            processData: false,
                            dataType: "json",
                            beforeSend: function () {
                                addWalletBtn.html("Adding...");
                            },
                            success: function (response) {
                                if (response.success == 1) {
                                    // ALERT AND REDIRECT AGENT TO USER WALLETS
                                    Swal.fire({
                                        width: '60%',
                                        imageUrl: `../../admin/images/${response.product_image}`,
                                        imageWidth: 400,
                                        imageHeight: 200,
                                        imageAlt: 'Selected product',
                                        title: 'Wallet created successfully',
                                        html:
                                            `<b>Price</b>: NGN ${response.price.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")} <br><br>` +
                                            "<?php echo $customer_details['first_name'] ?>"  + ` would be making a daily savings of ₦500 daily over a period of ${response.duration_in_months} months`,
                                        showCloseButton: true,
                                        showCancelButton: true,
                                        focusConfirm: false,
                                        confirmButtonText: 'View wallet',
                                        cancelButtonText: 'Ok',
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.href = `./wallets?cid=${response.cid}`;
                                        }else{
                                            location.href = "./";
                                        }
                                    });
                                } else {
                                    // ALERT THE AGENT UPON ERROR
                                    Swal.fire({
                                        title: response.error_title,
                                        icon: "error",
                                        text: response.error_msg,
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                    });
                                }
                            }
                        });
                    }
                });
            }
        });
    </script>
</body>

</html>