<?php
    require(dirname(dirname(dirname(__DIR__))) . '/auth-library/resources.php');
    AgentAuth::User("a/login");

    $agent_id = $_SESSION['agent_id'];
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
    <!-- ADMIN DASHBOARD MENU CSS -->
    <link rel="stylesheet" href="../../../assets/css/dashboard/admin-dash-menu.css" />
    <!-- ADMIN TABLE CSS -->
    <link rel="stylesheet" href="../../../assets/css/dashboard/admin-dash/admin-table.css">
    <!-- ADMIN AGENT CSS -->
    <link rel="stylesheet" href="../../../assets/css/dashboard/admin-dash/agent-index.css">
    <!-- DASHHBOARD MEDIA QUERIES -->
    <link rel="stylesheet" href="../../../assets/css/media-queries/admin-dash-mediaqueries.css" />
    <title>Agent - CDS</title>
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
                <li class="nav-item">
                    <a href="../debtors">
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
                <h2 class="table-title">All Customers</h2>

                <div class="table-container">
                    <table id="agent-table" class="main-table">
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
                                    Date added
                                </th>
                                <th>

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $sql_agent_customers = $db->query("SELECT * FROM 
                                easybuy_agent_customers WHERE agent_id='$agent_id' ORDER BY agent_customer_id DESC");

                                $count = 1;
                                while($customer = $sql_agent_customers->fetch_assoc()){

                                    // CHECK FOR EXISTING WALLET
                                    $customer_id = $customer['agent_customer_id'];
                                    $sql_check_existing_wallet = $db->query("SELECT * FROM easybuy_agent_wallets WHERE agent_customer_id = {$customer_id} AND completed='0'");
                                    $can_create_wallet = ($sql_check_existing_wallet->num_rows === 0);
                            ?>
                            <tr>
                                <td>
                                    <?php echo $customer['last_name'] . " " . $customer['first_name'] ?>
                                </td>
                                <td>
                                    <?php echo $customer['email']? $customer['email'] : "No email" ?>
                                </td>
                                <td>
                                   <?php echo $customer['phone_no'] ?>
                                </td>
                                <td>
                                    <?php echo date("j M, Y", strtotime($customer['created_at'])) ?>
                                </td>
                                <td>
                                    <div class="dropdown" style="font-size: 10px;">
                                        <button class="dropdown-toggle" data-dd-target="<?php echo $count ?>" aria-label="Dropdown Menu">
                                           o<br>o<br>o
                                        </button>
                                        <div class="dropdown-menu" data-dd-path="<?php echo $count ?>">
                                            <a class="dropdown-menu__link" href="./edit_customer?cid=<?php echo $customer_id ?>">Edit Customer</a>
                                            <a class="dropdown-menu__link" href="<?php echo $can_create_wallet? "./new_wallet?cid=$customer_id" : "javascript:void(0)"?>">New wallet</a>
                                            <a class="dropdown-menu__link" href="./wallets?cid=<?php echo $customer_id ?>">Existing wallets</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php
                                $count++;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="add-container">
                    <a href="./add_customer">Add Customer</a>
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
    <!-- DASHBOARD SCRIPT -->
    <script src="../../../assets/js/admin-dash.js"></script>
    <script>
        $(function () {
            $("#agent-table").DataTable({
                "pageLength": 10
            });


            $("a[href='javascript:void(0)'].dropdown-menu__link").on("click", function(){
                Swal.fire({
                    title: "Unable to create new wallet",
                    icon: "info",
                    text: "A wallet is existing please complete the existing wallet and try again",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                });
            });

            function modal_alert(message){
                console.log(message);
                
            }

            // HANDLE PRODUCT DELETION
            $(".deleteEl").each(function () {
                $(this).on("click", function (e) {

                    const selectedCustomerId = $(this).attr("data-cusId");

                    if(confirm("Delete this agent? \n NB: Deleting this customer would wipe out all it's details.")){
                        $.post("controllers/delete-agent-customer.php", { cid: selectedCustomerId, submit: true }, function (response) {
                            if (reponse.success === 1) {
                                // ALERT ADMIN
                                Swal.fire({
                                    title: "Customer Delete",
                                    icon: "success",
                                    text: "Customer deleted successfully",
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                });

                                // REMOVE PRODUCT FROM RECORDS
                                $(this).parent().parent().parent().parent()[0].remove();
                            } else {
                                Swal.fire({
                                    title: response.error_title,
                                    icon: "error",
                                    text: response.error_message,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                });
                            }
                        });
                    }   
                });
            });
        });
    </script>
</body>

</html>