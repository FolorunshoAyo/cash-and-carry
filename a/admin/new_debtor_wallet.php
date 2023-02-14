<?php
    require(dirname(dirname(__DIR__)) . '/auth-library/resources.php');
    AdminAuth::User("a/login");

    $admin_id = $_SESSION['admin_id'];

    if(isset($_GET['did']) && !empty($_GET['did'])){
        $did = $_GET['did'];

        $sql_debtor_details = $db->query("SELECT * FROM debtors WHERE debtor_id={$did}");

    
        $debtor_details = $sql_debtor_details->fetch_assoc();
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
    <link rel="stylesheet" href="../../assets/css/dropdown.css" />
    <!-- Custom Fonts (Inter) -->
    <link rel="stylesheet" href="../../assets/fonts/fonts.css" />
    <!-- BASE CSS -->
    <link rel="stylesheet" href="../../assets/css/base.css" />
    <!-- FORMS CSS -->
    <link rel="stylesheet" href="../../assets/css/form.css">
    <!-- ADMIN DASHBOARD MENU CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash-menu.css" />
    <!-- ADMIN TABLE CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash/admin-table.css">
    <!-- ADMIN AGENT CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash/agents.css">
    <!-- ADMIN PRODUCTS CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash/products.css">
    <!-- MAIN TABLE CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash/main-table.css">
    <!-- DASHHBOARD MEDIA QUERIES -->
    <link rel="stylesheet" href="../../assets/css/media-queries/admin-dash-mediaqueries.css" />
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
                <a href="./" class="logo">
                <i class="fa fa-home"></i>
                <span> CDS ADMIN </span>
                </a>
            </div>
            <ul class="side-menu" id="side-menu">
                <li title="dashboard" class="nav-item">
                <a href="./">
                    <i class="fa fa-tachometer"></i>
                    <span>Dashboard</span>
                </a>
                </li>
                <li title="statistics" class="nav-item">
                <a href="javascript:void(0">
                    <i class="fa fa-signal"></i>
                    <span>Statistics</span>
                </a>
                </li>
                <li title="orders" class="nav-item">
                <a href="./orders">
                    <i class="fa fa-usd"></i>
                    <span>Orders</span>
                </a>
                </li>
                <li title="shipping" class="nav-item">
                <a href="javascript:void(0">
                    <i class="fa fa-recycle"></i>
                    <span>Shipping</span>
                </a>
                </li>
                <li title="products" class="nav-item">
                <a href="./products">
                    <i class="fa fa-shopping-bag"></i>
                    <span>Products</span>
                </a>
                </li>
                <li title="agents" class="nav-item">
                <a href="./agents">
                    <i class="fa fa-users"></i>
                    <span>Agents</span>
                </a>
                </li>
                <li title="debtors" class="nav-item active">
                <a href="./debtors">
                    <i class="fa fa-info-circle"></i>
                    <span>Debtors</span>
                </a>
                </li>
                <li title="messages" class="nav-item">
                <a href="javascript:void(0">
                    <i class="fa fa-commenting-o"></i>
                    <span>Messages</span>
                </a>
                </li>
            </ul>

            <ul title="settings" class="side-menu-bottom">
                <li class="nav-tem">
                <a href="javascript:void(0)">
                    <i class="fa fa-gear"></i>
                    <span>Settings</span>
                </a>
                </li>
                <li title="logout" class="nav-item logout">
                <a href="../logout">
                    <i class="fa fa-sign-out"></i>
                    <span>Logout</span>
                </a>
                </li>
            </ul>
        </aside>
        <section class="page-wrapper">
            <div class="table-wrapper">
                <h2 class="table-title">Create a Debt wallet for <?php echo ucfirst($debtor_details['last_name']) . " " . ucfirst($debtor_details['first_name']) ?></h2>

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
                                    <?php echo $debtor_details['last_name'] . " " . $debtor_details['first_name'] ?>
                                </td>
                                <td>
                                    <?php echo $debtor_details['email']? $debtor_details['email'] : "No email yet"  ?>
                                </td>
                                <td>
                                    <?= $debtor_details['phone_no'] ?>
                                </td>
                                <td>
                                    <span class="id-number">#<?php echo str_pad($debtor_details['debtor_id'], 4, "0", STR_PAD_LEFT) ?></span>
                                </td>
                                <td>
                                    <?php echo empty($debtor_details['bvn'])? "N/A" : $debtor_details['bvn'] ?>
                                </td>
                                <td>
                                <?php echo date("M d, Y", strtotime($debtor_details['created_at'])) ?>
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
                                        <select name="productId" id="productId" class="form-input">
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

                                <div class="form-group-container">
                                    <div class="form-group animate">
                                        <select name="agent_id" id="agent_id" class="form-input">
                                            <option value="">Select agent</option>
                                            <?php
                                                $sql_all_agents = $db->query("SELECT * FROM agents WHERE deleted='0'");

                                                while($agent = $sql_all_agents->fetch_assoc()){
                                            ?>
                                                <option value="<?php echo $agent['agent_id'] ?>"><?php echo $agent['last_name'] . " " . $agent['first_name']  ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                        <label for="agent_id">Assign to</label>
                                    </div>
                                </div>

                                <div class="form-group-container">
                                    <div class="form-group animate">
                                        <input type="text" name="amount_paid" id="amount_paid" class="form-input format" placeholder=" " required />
                                        <label for="amount_paid">Amount Paid</label>
                                    </div>
                                </div>

                                <div class="submit-btn-container">
                                    <button type="submit" class="admin-submit-btn">Generate Item details</button>
                                </div>

                                <p class="note-text">
                                    <i class="fa fa-info-circle"></i> Creating this wallet would add the specified initial amount to this wallet.
                                </p>
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
                        <a href="javascript:void(0)">Create Debt Wallet</a>
                    </div>
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
    <!-- Sweet Alert JS -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- JQUERY DATATABLE SCRIPT -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <!-- DROP DOWN JS -->
    <script type="text/javascript" src="../../assets/js/dropdown/dropdown.min.js"></script>
    <!-- JUST VALIDATE LIBRARY -->
    <script src="../../assets/js/just-validate/just-validate.js"></script>
    <!-- DASHBOARD SCRIPT -->
    <script src="../../assets/js/admin-dash.js"></script>
    <script>
        $(function () {
            let selectedProductPrice, amountAdded, amountAddedNum, selected_agent_id;

            $("#view-item-table").DataTable({
                "pageLength": 10
            });

            // COVERT NUMBER TO READABLE FORM
            $('input.format').keyup(function (event) {
                // skip for arrow keys
                if (event.which >= 37 && event.which <= 40) return;

                // format number
                $(this).val(function (index, value) {
                    return value
                        .replace(/\D/g, "")
                        .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                });
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
                .addField("#amount_paid", [
                    {
                        rule: "required",
                        errorMessage: "Field is required",
                    },
                ])
                .addField("#agent_id", [
                    {
                        rule: "required",
                        errorMessage: "Field is required",
                    },
                ])
                .onSuccess((event) => {
                    const form = document.getElementById("view-item-form");

                    const formData = new FormData(form);
                    formData.append("submit", true);

                    amountAdded = formData.get("amount_paid");
                    selected_agent_id = formData.get("agent_id");

                    // CONVERTING FORMATTED(HUMAN READABLE) FIELDS BACK TO NUMBER 
                    const formatedFields = [];

                    for (let [key, value] of formData.entries()) {
                        if (key === "amount_paid") {
                            formatedFields.push(value);
                        }
                    }

                    const modifiedFormatedFields = formatedFields.map(value => value.replace(/,/g, ""));

                    formData.set("amount_paid", modifiedFormatedFields[0]);

                    amountAddedNum = modifiedFormatedFields[0];

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
                    // DISABLE ALL INPUT
                    $("#productId").attr("disabled", true);
                    $("#agent_id").attr("disabled", true);
                    $("#amount_paid").attr("disabled", true);
                    $(".submit-btn-container button").attr("disabled", true);
                    setTimeout(() => {
                        $(".loader-container").addClass("hide");
                        itemView.removeClass("hide");
                    }, 3000);

                    //SENDING FORM DATA TO THE SERVER
                    $.ajax({
                        type: "post",
                        url: "./controllers/fetch_product_details.php",
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
                                    $(".submit-btn-container button").css("display", "none");
                                    productImageEl.attr("src", `./images/${response.image}`);
                                    productNameEl.html(response.name);
                                    productIdEl.html(`#${response.pid}`);
                                    productPriceEl.html(formatCash(response.price));
                                    selectedProductPrice = (response.price/2).toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                    productDurationEl.html(response.duration_in_months);
                                    productDailyAmount.html("500");
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
                formData.append("debtor_id", "<?= $did ?>");
                formData.append("amount", amountAddedNum);
                formData.append("agent_id", selected_agent_id);

                addWalletBtn.on("click", function (e) {
                        if(confirm(`Creating this wallet automatically adds NGN ${amountAdded} to this wallet and is assigned to the selected agent \n Continue?`)){
                            $.ajax({
                                type: "post",
                                url: "controllers/add_debtor_wallet.php",
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
                                            imageUrl: `./images/${response.product_image}`,
                                            imageWidth: 400,
                                            imageHeight: 200,
                                            imageAlt: 'Selected product',
                                            title: 'Wallet created successfully',
                                            html:
                                                `<b>Price</b>: NGN ${response.price.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")} <br><br>` +
                                                "<?php echo $debtor_details['first_name'] ?>"  + ` would be making a daily savings of ₦500 daily over a period of ${response.duration_in_months} months`,
                                            showCloseButton: true,
                                            showCancelButton: true,
                                            focusConfirm: false,
                                            confirmButtonText: 'View wallet',
                                            cancelButtonText: 'Ok',
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                location.href = `./debtor_wallets?did=<?= $did ?>`;
                                            }else{
                                                location.href = "./debtors";
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