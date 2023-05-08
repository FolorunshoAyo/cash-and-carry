<?php
require(dirname(dirname(__DIR__)) . '/auth-library/resources.php');
AgentAuth::User("a/login");
$agent_id = $_SESSION['agent_id'];

//   $date_time = $db->query("SELECT NOW() AS nowdate");
//   $row = $date_time->fetch_assoc();
//   $dated = $row['nowdate'];
//   $now = strtotime($dated);
// $time = date("M d Y, h:i A", $now);

$current_date = date('Y-m-d');
$str_current_date = strtotime(date('Y-m-d'));

$agent_sql = $db->query("SELECT * FROM agents WHERE agent_id={$agent_id}");
if ($agent_sql->num_rows == 1) {
    $row_agent = $agent_sql->fetch_assoc();
} else {
    header("Location: ../login");
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
    <!-- ADMIN FORM CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash/admin-form.css" />
    <!-- ADMIN DASHBOARD MENU CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash-menu.css" />
    <!-- ADMIN TABLE CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash/admin-table.css">
    <!-- ADMIN PRODUCTS CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard/admin-dash/products.css">
    <!-- DASHHBOARD MEDIA QUERIES -->
    <link rel="stylesheet" href="../../assets/css/media-queries/admin-dash-mediaqueries.css" />
    <title>Products - Halfcarry Agent</title>
</head>

<body style="background-color: #fafafa">
    <div class="full-loader">
        <div class="spinner"></div>
    </div>
    <div class="dash-wrapper">
        <?php
        include("includes/agent-sidebar.php");
        ?>
        <section class="page-wrapper">
            <div class="table-wrapper">
                <h2 class="table-title">All Products</h2>

                <div class="table-container">
                    <table id="products-table" class="main-table">
                        <thead>
                            <tr>
                                <th>
                                    Product Details
                                </th>
                                <th>
                                    Store
                                </th>
                                <th>
                                    ID
                                </th>
                                <th>
                                    Date added
                                </th>
                                <th>
                                    Status
                                </th>
                                <th>
                                    In stock
                                </th>
                                <th>

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_products = $db->query("SELECT stores.name as store_name, products.* , product_categories.*
                                FROM ((products
                                INNER JOIN product_categories
                                ON products.category = product_categories.category_id)
                                INNER JOIN stores ON products.store_id = stores.id) WHERE stores.agent_id = {$agent_id}");

                            $products_count = 1;
                            while ($row_product = $sql_products->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td>
                                        <div class="product-details-container">
                                            <div class="product-img-container">
                                                <?php
                                                $product_images = $row_product['pictures'];

                                                $first_image = explode(",", $product_images);
                                                ?>
                                                <img src="<?= $url ?>assets/product-images/<?php echo ($first_image[0]); ?>" alt="Product Image" />
                                            </div>
                                            <div class="product-details">
                                                <span class="product-title"><?php echo ($row_product['name']); ?></span>
                                                <span class="product-span">Category: <?php echo ($row_product['category_name']); ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="store-name"><?= $row_product['store_name'] ?></span>
                                    </td>
                                    <td>
                                        <div class="productid-container">
                                            <span class="id-number">#<?php echo str_pad($row_product['product_id'], 4, "0", STR_PAD_LEFT) ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <?php
                                        $product_upload_timestamp = strtotime($row_product['created_at']);
                                        $product_upload_date = date("M d, Y", $product_upload_timestamp);
                                        $product_upload_time = date("h:ia", $product_upload_timestamp);
                                        ?>
                                        <div class="date-added-container">
                                            <span class="date-added"><?php echo ($product_upload_date); ?></span>
                                            <span class="time-added"><?php echo ($product_upload_time); ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <?php
                                        $isProductVisible = $row_product['visibility'];
                                        ?>
                                        <span class="status-badge <?php echo ($isProductVisible ? "success" : "danger"); ?>"><?php echo ($isProductVisible ? "active" : "inactive"); ?></span>
                                    </td>
                                    <td>
                                        <span class="in-stock"><?= $row_product['in_stock'] ?></span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="dropdown-toggle" data-dd-target="<?php echo ($products_count); ?>" aria-label="Dropdown Menu">
                                                o<br>o<br>o
                                            </button>
                                            <div class="dropdown-menu" data-dd-path="<?php echo ($products_count); ?>">
                                                <a class="dropdown-menu__link" href="edit_product?pid=<?php echo ($row_product['product_id']); ?>">Edit product</a>
                                                <a class="dropdown-menu__link deleteEl" href="javascript:void(0)" onclick="deleteProduct('<?= $row_product['product_id'] ?>', <?= $products_count ?>)" data-productId="<?php echo ($row_product['product_id']); ?>">Delete
                                                    product</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                                $products_count++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="add-container">
                    <a href="add_product">Add Product</a>
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
    <!-- SWEET ALERT PLUGIN -->
    <script src="../../auth-library/vendor/dist/sweetalert2.all.min.js"></script>
    <!-- DROP DOWN JS -->
    <script type="text/javascript" src="../../assets/js/dropdown/dropdown.min.js"></script>
    <!-- DASHBOARD SCRIPT -->
    <script src="../../assets/js/admin-dash.js"></script>
    <script>
        const product_table = $("#products-table").DataTable({
            "pageLength": 10
        });

        function deleteProduct(product_id, row_num) {
            // const removeProduct = () => $(`.deleteEl[data-productId="${product_id}"]`).parent().parent().parent().parent()[0].remove();
            const removeProduct = function() {

                const tr = $(`.deleteEl[data-productId="${product_id}"]`).parents('tr');
                const row = product_table.row(tr);

                // REMOVE TABLE ROW
                row.remove().draw();
            };

            if (confirm("Are you sure you want to delete this product?")) {
                const loader = $(".full-loader");

                loader.addClass("active");

                setTimeout(() => {
                    $.post("controllers/delete_product.php", {
                        pid: product_id,
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
                                confirmButtonColor: '#2366B5',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // REMOVE PRODUCT FROM RECORDS
                                    removeProduct();
                                }
                            });


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

                    loader.removeClass("active");
                }, 2000);
            }
        }
    </script>
</body>

</html>