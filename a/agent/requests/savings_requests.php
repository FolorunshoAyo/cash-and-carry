<?php
require(dirname(dirname(dirname(__DIR__))) . '/auth-library/resources.php');
AgentAuth::User("a/login");

$agent_id = $_SESSION['agent_id'];

$agent_sql = $db->query("SELECT * FROM agents WHERE agent_id={$agent_id}");
if ($agent_sql->num_rows == 1) {
    $row_agent = $agent_sql->fetch_assoc();
} else {
    header("Location: ../login");
}

function showStatus($status)
{
    $html = "";
    switch ($status) {
        case "1":
            $html = "<span class='dot pending-dot'></span> pending";
            break;
        case "2":
            $html = "<span class='dot shipped-dot'></span> granted";
            break;
        case "3":
            $html = "<span class='dot cancelled-dot'></span> rejected";
            break;
        default:
            $html = "Unable to detect status";
            break;
    }

    return $html;
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
    <!-- ADMIN DASHBOARD MENU CSS -->
    <link rel="stylesheet" href="../../../assets/css/dashboard/admin-dash-menu.css" />
    <!-- ADMIN TABLE CSS -->
    <link rel="stylesheet" href="../../../assets/css/dashboard/admin-dash/admin-table.css">
    <!-- ADMIN AGENT CSS -->
    <link rel="stylesheet" href="../../../assets/css/dashboard/admin-dash/orders.css">
    <!-- DASHHBOARD MEDIA QUERIES -->
    <link rel="stylesheet" href="../../../assets/css/media-queries/admin-dash-mediaqueries.css" />
    <title>Normal Savings Requests - Halfcarry Agent</title>
</head>

<body style="background-color: #fafafa">
    <div class="dash-wrapper">
        <?php
        include("../includes/agent-sidebar.php");
        ?>
        <section class="page-wrapper">
            <div class="table-wrapper">
                <h2 class="table-title">All Savings Request</h2>

                <div class="table-container">
                    <table id="teams-table" class="main-table">
                        <thead>
                            <tr>
                                <!-- <th>
                                    Product(s)
                                </th> -->
                                <th>
                                    ID
                                </th>
                                <th>
                                    Date
                                </th>
                                <th>
                                    Customer
                                </th>
                                <th>
                                    status
                                </th>
                                <th>
                                    Set status
                                </th>
                                <th>
                                    Installment Amount
                                </th>
                                <th>
                                    Target Amount
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_all_savings_requests = $db->query("SELECT * FROM savings_requests INNER JOIN users ON savings_requests.user_id = users.user_id WHERE savings_requests.agent_id={$agent_id} AND type_of_savings='1' ORDER BY id DESC");

                            $count = 1;
                            while ($request_details = $sql_all_savings_requests->fetch_assoc()) {
                            ?>
                                <tr>
                                    <!-- <td>
                                    <div class="product-details-container">
                                        <div class="product-img-container">
                                            <img src="images/iphone13-green.jpg" alt="Product Image" />
                                        </div>
                                        <div class="product-details">
                                            <span class="product-title">Iphone 13 green</span>
                                            <span class="product-span">Category: Phone</span>
                                        </div>
                                    </div>
                                </td> -->
                                    <td>
                                        #<?php echo $request_details['savings_id'] ?>
                                    </td>
                                    <td>
                                        <?php echo date("F j, Y", strtotime($request_details['requested_at'])) ?>
                                    </td>
                                    <td>
                                        <?php
                                        $name = ucfirst($request_details['last_name'])  . " " . ucfirst($request_details['first_name']);
                                        echo $name;
                                        ?>
                                    </td>
                                    <td class="status-cell-<?php echo $request_details['id'] ?>">
                                        <?php echo showStatus($request_details['status']) ?>
                                    </td>
                                    <td>
                                        <form>
                                            <?php
                                            $status = $request_details['status'];
                                            ?>
                                            <select class="request-status-select" name="request-status-<?= $request_details['id'] ?>" data-requestID="<?php echo $request_details['id'] ?>" data-userID="<?= $request_details['user_id'] ?>" <?= ($status === "2" || $status === "3")? "disabled" : "" ?>>
                                                <option <?php echo $status === "1" ? "selected" : "" ?> value="1">pending</option>
                                                <option <?php echo $status === "2" ? "selected" : "" ?> value="2">granted</option>
                                                <option <?php echo $status === "3" ? "selected" : "" ?> value="3">rejected</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        NGN <?php echo number_format($request_details['installment_amount'], 2) ?>
                                    </td>
                                    <td>
                                        NGN <?php echo number_format($request_details['target_amount'], 2) ?>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="dropdown-toggle" data-dd-target="<?php echo $count ?>" aria-label="Dropdown Menu">
                                                o<br>o<br>o
                                            </button>
                                            <div style="font-size: 1rem;" class="dropdown-menu" data-dd-path="<?php echo $count ?>">
                                                <a class="dropdown-menu__link" href="../request_details?sid=<?php echo $request_details['savings_id'] ?>">View request</a>
                                                <!-- <a class="dropdown-menu__link deleteEl" href="javascript:void(0)" data-productId="1"></a> -->
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
        $(function() {
            $("#teams-table").DataTable({
                "pageLength": 10
            });

            // HANDLE HALFSAVINGS REQUEST STATUS UPDATE
            $(".request-status-select").each(function() {
                $(this).on("change", function(e) {
                    const selectedRequestStatus = e.target.value;
                    const selectEl = this;
                    const userId = $(this).attr("data-userID");

                    const selectedRequestId = $(this).attr("data-requestID");

                    $(selectEl).after("<img src='../../../assets/images/loading-gif.gif' alt='Loading'>")

                    // PREVENT UPDATE IF PENDING
                    if (selectedRequestStatus === "1") return;

                    if (selectedRequestStatus === "2" || selectedRequestStatus === "3") {
                        Swal.fire({
                            title: "Update Withdrawal Request",
                            icon: "info",
                            text: "This is a one time action and cannot be reversed, continue?",
                            allowOutsideClick: true,
                            allowEscapeKey: true,
                            showCloseButton: true,
                            showCancelButton: true,
                            focusConfirm: false,
                            confirmButtonText: 'Yes',
                            cancelButtonText: 'No',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                updateAndDisableSavingsRequest(selectedRequestId, selectEl, userId, selectedRequestStatus);
                            } else {
                                $(selectEl).next("img[alt='Loading']").remove();
                            }
                        });
                    }
                });
            });

            function updateAndDisableSavingsRequest(requestId, selectEl, userId, status) {
                $.post("controllers/update-savings-request", {
                    rid: requestId,
                    status: status,
                    user_id: userId,
                    type_of_savings: "1",
                    submit: true
                }, function(response) {
                    response = JSON.parse(response);
                    if (response.success === 1) {
                        let statusHTML;
                        // ALERT ADMIN
                        Swal.fire({
                            title: "Request Status",
                            icon: "success",
                            text: status === "2"? "This user has been notified and can go ahead to make savings." : "This user request has been rejected",
                            allowOutsideClick: true,
                            allowEscapeKey: true,
                        });

                        switch (status) {
                            case "1":
                                statusHTML = "<span class='dot pending-dot'></span> pending";
                                break;
                            case "2":
                                statusHTML = "<span class='dot completed-dot'></span> granted";
                                break;
                            case "3":
                                statusHTML = "<span class='dot cancelled-dot'></span> rejected";
                                break;
                            default:
                                console.log("Not recognized");
                                break;
                        }

                        // UPDATE STATUS CELL
                        $(`.status-cell-${requestId}`).html(statusHTML);

                        // REMOVE LOADER
                        $(selectEl).next("img[alt='Loading']").remove();

                        // DISABLE SELECT ELEMENT
                        $(`[data-requestID = '${requestId}']`).attr("disabled", true);
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
    </script>
</body>

</html>