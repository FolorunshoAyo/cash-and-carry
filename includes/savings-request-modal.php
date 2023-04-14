<?php
$get_request_details = $db->query("SELECT savings_requests.*, agents.first_name as agent_first_name, agents.last_name as agent_last_name, agents.phone_no as agent_phone_no, agents.email as agent_email FROM 
    (savings_requests INNER JOIN agents ON savings_requests.agent_id=agents.agent_id) WHERE status = '1' ORDER BY requested_at DESC LIMIT 1");

$isActiveRequest = 0;
if ($get_request_details->num_rows === 1) {
    $products = array();
    $isActiveRequest = 1;
    $request_details = $get_request_details->fetch_assoc();
    $savings_id = $request_details['savings_id'];

    $get_products = $db->query("SELECT savings_products.*, products.pictures as product_pictures, products.name as product_name FROM savings_products INNER JOIN products ON savings_products.product_id = products.product_id WHERE savings_id={$savings_id}");

    while ($product = $get_products->fetch_assoc()) {
        $product_picture = explode(",", $product['product_pictures'])[0];
        $product_object = array("product_name" => $product['product_name'], "product_picture" => $product_picture, "product_quantity" => $product['quantity']);

        array_push($products, $product_object);
    }
}


function generateStatus($status)
{
    $html = "";

    switch ($status) {
        case "1":
            $html = '<span class="dot pending"> </span> pending';
            break;
        case "2":
            $html = '<span class="dot approved"> </span> approved';
            break;
        case "3":
            $html = '<span class="dot rejected"> </span> rejected';
            break;
        default:
            $html = 'Unable to generate status';
            break;
    }

    return $html;
}

if ($isActiveRequest !== 0) {
?>
    <div class="savings-request-modal-wrapper">
        <div class="savings-request-modal">
            <div class="modal-header">
                <div class="savings-id-container">
                    <i class="fa fa-handshake-o"></i> #<?= $request_details['savings_id'] ?>
                </div>
                <div class="close-container">
                    <i class="fa fa-times"></i>
                </div>
            </div>
            <?php
            if (count($products) > 1) {
            ?>
                <div class="controls-container">
                    <button data-direction="prev" disabled><i class="fa fa-arrow-left"></i></button>
                    <button data-direction="next"><i class="fa fa-arrow-right"></i></button>
                </div>
            <?php
            }
            ?>

            <div class="products-container">
                <?php
                foreach ($products as $key => $product) {
                    if ($key == 0) {
                ?>
                        <div class="savings-product active">
                            <div class="savings-product-image-container">
                                <img src="<?= $url ?>a/admin/images/<?= $product['product_picture'] ?>" alt="Web cam #1">
                            </div>
                            <div class="savings-product-details">
                                <span class="savings-product-name"><?= $product['product_name'] ?></span>
                                <span class="savings-product-qty">Qty: <?= $product['product_quantity'] ?></span>
                            </div>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="savings-product">
                            <div class="savings-product-image-container">
                                <img src="<?= $url ?>a/admin/images/<?= $product['product_picture'] ?>" alt="Web cam #1">
                            </div>
                            <div class="savings-product-details">
                                <span class="savings-product-name"><?= $product['product_name'] ?></span>
                                <span class="savings-product-qty">Qty: <?= $product['product_quantity'] ?></span>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
            <ul class="savings-info">
                <li class="savings-info-block">
                    <span class="savings-label">
                        Savings type:
                    </span>
                    <span class="savings-value">
                        <?= $request_details['type_of_savings'] === "1" ? "Normal Savings" : "Half savings" ?>
                    </span>
                </li>
                <li class="savings-info-block">
                    <span class="savings-label">
                        Duration:
                    </span>
                    <span class="savings-value">
                        <?php
                        $installment_type = $request_details['installment_type'];

                        if ($installment_type == "1") {
                            echo $request_details['duration_of_savings'] . " days (NGN " . number_format($request_details['installment_amount'], 2) . "/day)";
                        } elseif ($installment_type == "2") {
                            echo $request_details['duration_of_savings'] . " weeks (NGN " . number_format($request_details['installment_amount'], 2) . "/week)";
                        } else {
                            echo $request_details['duration_of_savings'] . " months (NGN " . number_format($request_details['installment_amount'], 2) . "/month)";
                        }
                        ?>
                    </span>
                </li>
                <li class="savings-info-block">
                    <span class="savings-label">
                        Type of payment:
                    </span>
                    <span class="savings-value">
                        <?php
                        $installment_type = $request_details['installment_type'];

                        if ($installment_type == "1") {
                            echo "Daily";
                        } elseif ($installment_type == "2") {
                            echo "Weekly";
                        } else {
                            echo "Monthly";
                        }
                        ?>
                    </span>
                </li>
                <li class="savings-info-block">
                    <span class="savings-label">
                        Amount to save:
                    </span>
                    <span class="savings-value">
                        NGN <?= number_format($request_details['target_amount'], 2) ?>
                    </span>
                </li>
                <li class="savings-info-block">
                    <span class="savings-label">
                        Agent:
                    </span>
                    <span class="savings-value">
                        <?= $request_details['agent_last_name'] . " " . $request_details['agent_first_name'] ?>
                    </span>
                </li>
                <li class="savings-info-block">
                    <span class="savings-label">
                        Agent Mobile No:
                    </span>
                    <span class="savings-value">
                        <?= $request_details['agent_phone_no'] ?>
                    </span>
                </li>
                <li class="savings-info-block">
                    <span class="savings-label">
                        Agent Email:
                    </span>
                    <span class="savings-value">
                        <?= $request_details['agent_email'] ?>
                    </span>
                </li>
                <li class="savings-info-block">
                    <span class="savings-label">
                        Status:
                    </span>
                    <span class="savings-value">
                        <?= generateStatus($request_details['status']) ?>
                    </span>
                </li>
            </ul>
        </div>
    </div>
<?php
}
?>