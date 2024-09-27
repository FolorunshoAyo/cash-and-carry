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
    <title>Users - Halfcarry Admin</title>
</head>

<body style="background-color: #fafafa">
    <div class="dash-wrapper">
        <?php
        include("includes/agent-sidebar.php");
        ?>
        <section class="page-wrapper">
            <div class="table-wrapper">
                <h2 class="table-title">All Users</h2>

                <div class="table-container">
                    <table id="users-table" class="main-table">
                        <thead>
                            <tr>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Username
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
                            $sql_users = $db->query("SELECT * FROM users ORDER BY user_id DESC");
                            $count = 1;

                            while ($user = $sql_users->fetch_assoc()) {
                            ?>
                                    <tr>
                                        <td>
                                            <?php echo $user['last_name'] . " " . $user['first_name'] ?>
                                        </td>
                                        <td>
                                            <?php echo $user['username']? $user['username'] : "No Username" ?>
                                        </td>
                                        <td>
                                            <?php echo $user['email']? $user['email'] : "No Email" ?>
                                        </td>
                                        <td>
                                            <?php echo $user['phone_no'] ?>
                                        </td>
                                        <td>
                                            <?php echo date("j M, Y", strtotime($user['created_at'])) ?>
                                        </td>
                                        <td>
                                            <?php echo showStatus($user['account_status']) ?>
                                        </td>
                                        <td>
                                            <div class="dropdown" style="font-size: 12px;">
                                                <button class="dropdown-toggle" data-dd-target="<?php echo $count ?>" aria-label="Dropdown Menu">
                                                    o<br>o<br>o
                                                </button>
                                                <div class="dropdown-menu" data-dd-path="<?php echo $count ?>">
                                                    <a class="dropdown-menu__link" href="./edit_user?uid=<?php echo $user['user_id'] ?>">Edit User</a>
                                                    <!-- <a class="dropdown-menu__link deleteEl" href="javascript:void(0)" data-userId="<?php echo $user['user_id'] ?>">Delete
                                                        Agent</a> -->
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
                    <a href="./add_user">Add User</a>
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
            const userTable = $("#users-table").DataTable({
                "pageLength": 10
            });

            // HANDLE PRODUCT DELETION
            $(".deleteEl").each(function() {
                $(this).on("click", function(e) {
                    e.preventDefault();

                    const selectedAgentId = $(this).attr("data-userId");
                    const self = this;

                    if (confirm("Are you sure you want to delete this user? \n NB: This action would delete all the data related to this user")) {
                        $.post("controllers/delete_user.php", {
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
                                const tr = $(`.deleteEl[data-userId="${selectedAgentId}"]`).parents('tr');
                                const row = userTable.row(tr);

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