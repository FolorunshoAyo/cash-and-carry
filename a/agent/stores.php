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
    <title>Registered stores by you  - Halfcarry Agent</title>
</head>

<body style="background-color: #fafafa">
    <div class="dash-wrapper">
        <?php
        include("includes/agent-sidebar.php");
        ?>
        <section class="page-wrapper">
            <div class="table-wrapper">
                <h2 class="table-title" style="font-size: 2rem;">Your Registered Stores</h2>

                <div class="table-container">
                    <table id="agent-table" class="main-table">
                        <thead>
                            <tr>
                                <th>
                                    Store name
                                </th>
                                <th>
                                    Owner name
                                </th>
                                <th>
                                    Owner phone 
                                </th>
                                <th>
                                    Owner email 
                                </th>
                                <th>
                                    Created on
                                </th>
                                <th>

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_agent_stores = $db->query("SELECT * FROM stores WHERE agent_id = {$agent_id}");

                            $count = 1;
                            while ($store_details = $sql_agent_stores->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td>
                                        <?= $store_details['name']; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $store_owner_name = explode(" ", $store_details['owner_name']);

                                        echo $store_owner_name[0] . " " . $store_owner_name[1];
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo  $store_details['owner_phone']  ?>
                                    </td>
                                    <td>
                                        <?php echo $store_details['owner_email'] ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo date("j M, Y", strtotime($store_details['created_at']))
                                        ?>
                                    </td>
                                    <td>
                                        <div class="dropdown" style="font-size: 10px;">
                                            <button class="dropdown-toggle" data-dd-target="<?php echo $count ?>" aria-label="Dropdown Menu">
                                                o<br>o<br>o
                                            </button>
                                            <div class="dropdown-menu" data-dd-path="<?php echo $count ?>">
                                                <a class="dropdown-menu__link" href="edit_store?sid=<?php echo $store_details['id'] ?>">edit store</a>
                                                <a class="dropdown-menu__link" href="store_products?sid=<?php echo $store_details['id'] ?>">view store products</a>
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
                    <a href="./new_store">Add Store</a>
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
                "pageLength": 10
            });

            // HANDLE PRODUCT DELETION
            // $(".deleteEl").each(function () {
            //     $(this).on("click", function (e) {

            //         const selectedCustomerId = $(this).attr("data-cusId");

            //         if(confirm("Delete this agent? \n NB: Deleting this store$store_details would wipe out all it's details.")){
            //             $.post("controllers/delete-agent-store$store_details.php", { cid: selectedCustomerId, submit: true }, function (response) {
            //                 if (reponse.success === 1) {
            //                     // ALERT ADMIN
            //                     Swal.fire({
            //                         title: "store$store_details Delete",
            //                         icon: "success",
            //                         text: "store$store_details deleted successfully",
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