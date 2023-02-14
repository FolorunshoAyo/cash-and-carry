<?php 
  require(dirname(dirname(__DIR__)) . '/auth-library/resources.php');
  AdminAuth::User("a/login");
  $admin_id = $_SESSION['admin_id'];

//   $date_time = $db->query("SELECT NOW() AS nowdate");
//   $row = $date_time->fetch_assoc();
//   $dated = $row['nowdate'];
//   $now = strtotime($dated);
  // $time = date("M d Y, h:i A", $now);

  $current_date = date('Y-m-d');
  $str_current_date = strtotime(date('Y-m-d'));

  $admin_sql = $db->query("SELECT * FROM admin WHERE admin_id={$admin_id}");
  if($admin_sql->num_rows == 1){
      $row_admin = $admin_sql->fetch_assoc();
  }else{
      header("Location: ../login");
  }

  function showStatus($status){
    $html = "";
    switch($status){
      case "1":
        $html = "<span class='dot pending-dot'></span> pending";
      break;
      case "2":
        $html = "<span class='dot awaiting-shipment-dot'></span> awaiting shipment";
      break;
      case "3":
        $html = "<span class='dot shipped-dot'></span> shipped";
      break;
      case "4":
        $html = "<span class='dot completed-dot'></span> completed";
      break;
      case "5":
        $html = "<span class='dot cancelled-dot'></span> cancelled";
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
    <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash/orders.css">
    <!-- DASHHBOARD MEDIA QUERIES -->
    <link rel="stylesheet" href="../../assets/css/media-queries/admin-dash-mediaqueries.css" />
    <title>Orders - CDS</title>
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
                <li title="orders" class="nav-item active">
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
                <li title="debtors" class="nav-item">
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
                <h2 class="table-title">All Orders</h2>

                <div class="table-container">
                    <table id="teams-table" class="main-table">
                        <thead>
                            <tr>
                                <!-- <th>
                                    Product(s)
                                </th> -->
                                <th>
                                    Order ID
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
                                    Total
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $sql_all_orders = $db->query("SELECT orders.*, users.last_name, users.first_name FROM orders INNER JOIN users ON orders.user_id=users.user_id");

                                $count = 1;
                                while($order = $sql_all_orders->fetch_assoc()){
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
                                    #<?php echo $order['order_no'] ?>
                                </td>
                                <td>
                                    <?php echo date("F j, Y", strtotime($order['ord_date'])) ?>
                                </td>
                                <td>
                                    <?php 
                                        $name = ucfirst($order['last_name'])  . " " . ucfirst($order['first_name']);
                                        echo $name;
                                    ?>
                                </td>
                                <td class="status-cell-<?php echo $order['order_no'] ?>">
                                    <?php echo showStatus($order['status']) ?>
                                </td>
                                <td>
                                    <form>
                                        <?php
                                            $status = $order['status'];
                                        ?>
                                        <select class="order-status-select" name="order-status" data-orderID="<?php echo $order['order_no'] ?>">
                                            <option <?php echo $status === "1"? "selected" : "" ?> value="1">pending</option>
                                            <option <?php echo $status === "2"? "selected" : "" ?> value="2">awaiting shipment</option>
                                            <option <?php echo $status === "3"? "selected" : "" ?> value="3">shipped</option>
                                            <option <?php echo $status === "4"? "selected" : "" ?> value="4">completed</option>
                                            <option <?php echo $status === "5"? "selected" : "" ?> value="5">cancelled</option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    NGN<?php echo number_format($order['purch_amt']) ?>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="dropdown-toggle" data-dd-target="<?php echo $count ?>" aria-label="Dropdown Menu">
                                            o<br>o<br>o
                                        </button>
                                        <div style="font-size: 1rem;" class="dropdown-menu" data-dd-path="<?php echo $count ?>">
                                            <a class="dropdown-menu__link" href="order-details?oid=<?php echo $order['order_id'] ?>">View Order</a>
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
            $("#teams-table").DataTable({
                "pageLength": 10
            });

            // HANDLE ORDER STATUS UPDATE
            $(".order-status-select").each(function () {
                $(this).on("change", function (e) {
                    const selectedOrderStatus = e.target.value;
                    const selectEl = this;

                    const selectedOrderId = $(this).attr("data-orderID");

                    $(selectEl).after("<img src='../../assets/images/loading-gif.gif' alt='Loading'>")

                    
                    $.post("controllers/update-order-status.php", { oid: selectedOrderId, status: selectedOrderStatus, submit: true }, function (response) {
                        response = JSON.parse(response);
                        if (response.success === 1) {
                            let statusHTML;
                            // ALERT ADMIN
                            Swal.fire({
                                title: "Order status",
                                icon: "success",
                                text: "Order status updated successfully",
                                allowOutsideClick: true,
                                allowEscapeKey: true,
                            });

                            switch(selectedOrderStatus){
                                case "1":
                                    statusHTML = "<span class='dot pending-dot'></span> pending";
                                break;
                                case "2":
                                    statusHTML = "<span class='dot awaiting-shipment-dot'></span> awaiting shipment"
                                break;
                                case "3":
                                    statusHTML = "<span class='dot shipped-dot'></span> shipped";
                                break;
                                case "4":
                                    statusHTML = "<span class='dot completed-dot'></span> completed";
                                break;
                                case "5":
                                    statusHTML = "<span class='dot cancelled-dot'></span> cancelled";
                                break;
                                default: 
                                console.log("Not recognized");
                                break;
                            }

                            // UPDATE STATUS CELL
                            $(`.status-cell-${selectedOrderId}`).html(statusHTML);
                            // REMOVE LOADER
                            $(selectEl).next("img[alt='Loading']").remove();
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
                });
            });
        });
    </script>
</body>

</html>