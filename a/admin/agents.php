<?php
require(dirname(dirname(__DIR__)) . '/auth-library/resources.php');
AdminAuth::User("a/login");
$admin_id = $_SESSION['admin_id'];
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
    <!-- ADMIN FORM CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash/admin-form.css" />
    <!-- ADMIN DASHBOARD MENU CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash-menu.css" />
    <!-- ADMIN TABLE CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash/admin-table.css">
    <!-- ADMIN AGENT CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash/agents.css">
    <!-- DASHHBOARD MEDIA QUERIES -->
    <link rel="stylesheet" href="../../assets/css/media-queries/admin-dash-mediaqueries.css" />
    <title>Agent - Halfcarry Admin</title>
</head>

<body style="background-color: #fafafa">
    <div class="dash-wrapper">
        <?php
        include("includes/admin-sidebar.php");
        ?>
        <section class="page-wrapper">
            <div class="table-wrapper">
                <h2 class="table-title">All Agents</h2>

                <div class="table-container">
                    <table id="agents-table" class="main-table">
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
                                    status
                                </th>
                                <th>

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            function showStatus($status)
                            {
                                $html = "";
                                switch ($status) {
                                    case "0":
                                        $html = "<span class='status-badge danger'>suspended</span>";
                                        break;
                                    case "1":
                                        $html = "<span class='status-badge success'>active</span>";
                                        break;
                                    case "2":
                                        $html = "<span class='status-badge danger'>inactive</span>";
                                        break;
                                    default:
                                        $html = "Status not recognised";
                                        break;
                                }

                                return $html;
                            }
                            $sql_agents = $db->query("SELECT * FROM agents ORDER BY agent_id DESC");
                            $count = 1;

                            while ($agent = $sql_agents->fetch_assoc()) {
                                if ($agent['deleted'] !== "1") {
                            ?>
                                    <tr>
                                        <td>
                                            <?php echo $agent['last_name'] . " " . $agent['first_name'] ?>
                                        </td>
                                        <td>
                                            <?php echo $agent['email'] ?>
                                        </td>
                                        <td>
                                            <?php echo $agent['phone_no'] ?>
                                        </td>
                                        <td>
                                            <?php echo date("j M, Y", strtotime($agent['created_at'])) ?>
                                        </td>
                                        <td>
                                            <?php echo showStatus($agent['account_status']) ?>
                                        </td>
                                        <td>
                                            <div class="dropdown" style="font-size: 12px;">
                                                <button class="dropdown-toggle" data-dd-target="<?php echo $count ?>" aria-label="Dropdown Menu">
                                                    o<br>o<br>o
                                                </button>
                                                <div class="dropdown-menu" data-dd-path="<?php echo $count ?>">
                                                    <a class="dropdown-menu__link" href="./edit_agent?aid=<?php echo $agent['agent_id'] ?>">Edit Agent</a>
                                                    <a class="dropdown-menu__link deleteEl" href="javascript:void(0)" data-agentId="<?php echo $agent['agent_id'] ?>">Delete
                                                        Agent</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                            <?php
                                }
                                $count++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="add-container">
                    <a href="./add_agent">Add Agent</a>
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
            const agentTable = $("#agents-table").DataTable({
                "pageLength": 10
            });

            // HANDLE PRODUCT DELETION
            $(".deleteEl").each(function() {
                $(this).on("click", function(e) {
                    e.preventDefault();

                    const selectedAgentId = $(this).attr("data-agentId");
                    const self = this;

                    if (confirm("Are you sure you want to delete this agent? \n NB: This action would delete all the data related to this agent")) {
                        $.post("controllers/delete_agent.php", {
                            aid: selectedAgentId,
                            submit: true
                        }, function(response) {
                            response = JSON.parse(response);
                            if (response.success === 1) {
                                // ALERT ADMIN
                                Swal.fire({
                                    title: response.title,
                                    icon: "success",
                                    text: response.message,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                });

                                // REMOVE PRODUCT FROM RECORDS
                                const tr = $(`.deleteEl[data-agentId="${selectedAgentId}"]`).parents('tr');
                                const row = agentTable.row(tr);

                                // REMOVE TABLE ROW
                                row.remove().draw();
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