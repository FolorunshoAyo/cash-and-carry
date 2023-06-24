<?php
require(dirname(dirname(__DIR__)) . '/auth-library/resources.php');
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
    <link rel="stylesheet" href="../../assets/css/dropdown.css" />
    <!-- Custom Fonts (Inter) -->
    <link rel="stylesheet" href="../../assets/fonts/fonts.css" />
    <!-- BASE CSS -->
    <link rel="stylesheet" href="../../assets/css/base.css" />
    <!-- ADMIN DASHBOARD MENU CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash-menu.css" />
    <!-- ADMIN TABLE CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash/admin-table.css">
    <!-- ADMIN AGENT CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash/agent-index.css">
    <!-- DASHHBOARD MEDIA QUERIES -->
    <link rel="stylesheet" href="../../assets/css/media-queries/admin-dash-mediaqueries.css" />
    <title>Welcome Agent. Folorunsho - Halfcarry Agent</title>
</head>

<body style="background-color: #fafafa">
    <div class="dash-wrapper">
        <?php
        include("includes/agent-sidebar.php");
        ?>
        <section class="page-wrapper">
            <div class="table-wrapper">
                <h2 class="table-title" style="font-size: 2rem;">All assigned customers with outstanding payments</h2>

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
                                    Joined on
                                </th>
                                <th class="">
                                        <a href="../../register.php?agent_id='<?= $agent_id ?>'">
                                        <i class="bi bi-plus-circle"></i>
                                            <span>Add Customer</span>
                                        </a>
                                    
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_agent_customers = $db->query("SELECT DISTINCT store_wallets.*, users.first_name as user_first_name, users.last_name as user_last_name, users.email as user_email, users.phone_no as user_phone_no 
                            FROM store_wallets INNER JOIN users ON store_wallets.user_id = users.user_id
                            WHERE store_wallets.agent_id='$agent_id' ORDER BY store_wallets.wallet_id DESC");

                            $count = 1;
                            while ($customer = $sql_agent_customers->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $customer['user_last_name'] . " " . $customer['user_first_name']
                                            ?>
                                    </td>
                                    <td>
                                        <?php echo $customer['user_email'] ?>
                                    </td>
                                    <td>
                                        <?php echo $customer['user_phone_no'] ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo date("j M, Y", strtotime($customer['created_at']))
                                            ?>
                                    </td>
                                    <td>
                                        <div class="dropdown" style="font-size: 10px;">
                                            <button class="dropdown-toggle" data-dd-target="<?php echo $count ?>"
                                                aria-label="Dropdown Menu">
                                                o<br>o<br>o
                                            </button>
                                            <div class="dropdown-menu" data-dd-path="<?php echo $count ?>">
                                                <a class="dropdown-menu__link"
                                                    href="view_customer?uid=<?php echo $customer['user_id'] ?>">View
                                                    Profile</a>
                                                <a class="dropdown-menu__link"
                                                    href="user_wallets?uid=<?php echo $customer['user_id'] ?>">Assigned
                                                    Wallets</a>
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
    <!-- DASHBOARD SCRIPT -->
    <script src="../../assets/js/admin-dash.js"></script>
    <script>
        $(function () {
            $("#agent-table").DataTable({
                "pageLength": 10
            });

            // HANDLE PRODUCT DELETION
            // $(".deleteEl").each(function () {
            //     $(this).on("click", function (e) {

            //         const selectedCustomerId = $(this).attr("data-cusId");

            //         if(confirm("Delete this agent? \n NB: Deleting this customer would wipe out all it's details.")){
            //             $.post("controllers/delete-agent-customer.php", { cid: selectedCustomerId, submit: true }, function (response) {
            //                 if (reponse.success === 1) {
            //                     // ALERT ADMIN
            //                     Swal.fire({
            //                         title: "Customer Delete",
            //                         icon: "success",
            //                         text: "Customer deleted successfully",
            //                         allowOutsideClick: false,
            //                         allowEscapeKey: false,
            //                     });

            //                     // REMOVE PRODUCT FROM RECORDS
            //                     $(this).parent().parent().parent().parent()[0].remove();
            //                 } else {
            //                     Swal.fire({
            //                         title: response.error_title,
            //                         icon: "error",
            //                         text: response.error_message,
            //                         allowOutsideClick: false,
            //                         allowEscapeKey: false,
            //                     });
            //                 }
            //             });
            //         }   
            //     });
            // });
        });
    </script>
</body>

</html>