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
    <title>All Active Wallets - Halfcarry Agent</title>
</head>

<body style="background-color: #fafafa">
    <div class="dash-wrapper">
        <?php
        include("includes/agent-sidebar.php");
        ?>
        <section class="page-wrapper">
            <div class="table-wrapper">
                <h2 class="table-title" style="font-size: 2rem;">All active wallets</h2>

                <div class="table-container">
                    <table id="agent-table" class="main-table">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <!-- <th>
                                    No. of products
                                </th> -->
                                <th>
                                    Type of savings
                                </th>
                                <th>
                                    Duration of Savings
                                </th>
                                <th>
                                    Installment Amount
                                </th>
                                <th>
                                    Current Amount
                                </th>
                                <th>
                                    Target Amount
                                </th>
                                <th>

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_active_wallets = $db->query("SELECT store_wallets.*, savings_requests.installment_type as installment_type, savings_requests.duration_of_savings as duration_of_savings,
                             savings_requests.installment_amount as installment_amount, savings_requests.target_amount as target_amount, savings_requests.type_of_savings as type_of_savings
                            FROM store_wallets INNER JOIN savings_requests ON store_wallets.wallet_no = savings_requests.savings_id
                            WHERE store_wallets.agent_id='$agent_id' AND savings_requests.status = 2 ORDER BY store_wallets.wallet_id DESC");

                            $count = 1;
                            while ($wallet_details = $sql_active_wallets->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td>
                                        <?= $wallet_details['wallet_no'] ?>
                                    </td>
                                    <!-- <td>
                                        <?php
                                        // $get_products_in_request = $db->query("SELECT COUNT(*) as num_of_products FROM savings_products WHERE savings_id={$wallet_details['wallet_no']}");

                                        // $number_of_products = $get_products_in_request->fetch_assoc()['num_of_products'];

                                        ?>
                                        <?php // $number_of_products ?>
                                    </td> -->
                                    <td>
                                        <?= $wallet_details['type_of_savings'] === "1" ? "Normal Savings" : "Half Savings" ?>
                                    </td>
                                    <td>
                                        <?php
                                        $period_suffix = $wallet_details['installment_type'] === "1" ? "day(s)" : ($wallet_details['installment_type'] === "2" ? "week(s)" : "month(s)");

                                        echo $wallet_details['duration_of_savings'] . " " . $period_suffix;
                                        ?>
                                    </td>
                                    <td>
                                        ₦ <?= number_format($wallet_details['installment_amount'], 2) ?>
                                    </td>
                                    <td>
                                        ₦ <?= number_format($wallet_details['amount'], 2) ?>
                                    </td>
                                    <td>
                                        ₦ <?= number_format($wallet_details['target_amount'], 2) ?>
                                    </td>
                                    <td>
                                        <div class="dropdown" style="font-size: 10px;">
                                            <button class="dropdown-toggle" data-dd-target="<?php echo $count ?>" aria-label="Dropdown Menu">
                                                o<br>o<br>o
                                            </button>
                                            <div class="dropdown-menu" data-dd-path="<?php echo $count ?>">
                                                <a class="dropdown-menu__link" href="wallet?id=<?= $wallet_details['wallet_no'] ?>">View Wallet</a>
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
        $(function() {
            $("#agent-table").DataTable({
                "pageLength": 20
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