<?php
require(dirname(__DIR__) . '/auth-library/resources.php');

function generateUniqueCode()
{
    $order_random_id = rand(0000000000, 9999999999);

    function checkIfSavingsIdExists($order_random_id)
    {
        global $db;
        $check_order_code = $db->query("SELECT * FROM orders WHERE order_id = {$order_random_id}");

        return $check_order_code->num_rows === 1;
    }

    while (checkIfSavingsIdExists($order_random_id)) {
        $order_random_id = rand(0000000000, 9999999999);
    }

    return $order_random_id;
}

if (isset($_POST['submit'])) {
    $uid = $db->real_escape_string($_POST['uid']);
    $order_no = generateUniqueCode();
    $total_order_price = 0;

    $isPayment = isset($_POST['trx_ref']) ? 1 : 0;

    if (empty($uid)) {
        echo json_encode(array('success' => 0, 'error_title' => "Order Error", 'error_message' => "One or more field(s) were not provided"));
        exit();
    } else {
        // GET DEFAULT ADDRESS
        $sql_address = $db->query("SELECT * FROM users_addresses WHERE user_id={$uid} AND active=1");
        $address_id = $sql_address->fetch_assoc()['address_id'];

        $sql_address_details = $db->query("SELECT * FROM addresses WHERE address_id={$address_id}");

        $default_address_details = $sql_address_details->fetch_assoc();

        $shipping_address = $default_address_details['recipient_name'] . "%" . $default_address_details['delivery_address'] . ", " . $default_address_details['city_name'] . ". " . $default_address_details['address_state'] . "." .  " (" . $default_address_details['address_postal_code'] . ") " . $default_address_details['recipient_phone_no'];

        $readable_shipping_address = $default_address_details['delivery_address'] . ", " . $default_address_details['city_name'] . ". " . $default_address_details['address_state'] . "." .  " (" . $default_address_details['address_postal_code'] . ") ";

        if ($default_address_details['additional_info']) {
            $shipping_address .= "<br>" . $default_address_details['additional_info'];
        }

        // GET USER DETAILS
        $get_user_details = $db->query("SELECT * FROM users WHERE user_id = {$uid}");

        $user_details = $get_user_details->fetch_assoc();

        $order_products = "";

        foreach ($_SESSION['shopping_cart'] as $key => $values) {
            $product_id = $values['product_id'];
            $quantity = $values['product_quantity'];

            $total_order_price += $values['product_quantity'] * $values['product_price'];

            $db->query("INSERT INTO orders_products (order_no, product_id, quantity) VALUES({$order_no}, {$product_id}, {$quantity})");

            // CONSTRUCT SAVINGS PRODUCTS FOR EMAIL

            $order_products .= '<div style="border: 1px solid #ff5c00;
            border-bottom: 5px solid #ff5c00; margin-bottom: 40px;">
              <div style="height: 80px;
              text-align: center;
              border-bottom: 1px solid #ff5c00;" >
                <img src="' . $values['product_image'] .  '" style=" height: 100%;
                width: 80px;" />
              </div>
              <div style="display: table; border-collapse: collapse; width: 100%;">
                <p style="display: table-row; border-bottom: 1px solid #ff5c00;">
                  <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Item </span>
                  <span style="display: table-cell;"></span>
                  <span style="display: table-cell;  padding: 10px; font-size: 15px; text-align: right; width: 100%;" >' . $values['product_name'] . '</span>
                </p>
                <p style="display: table-row; border-bottom: 1px solid #ff5c00;">
                  <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Quantity </span>
                  <span style="display: table-cell;  padding: 10px;"></span>
                  <span style="display: table-cell;  padding: 10px; font-size: 15px; text-align: right;">' . $values['product_quantity'] . '</span>
                </p>
                <p style="display: table-row; border-bottom: 1px solid #ff5c00;">
                  <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Price </span>
                  <span style="display: table-cell;  padding: 10px;"></span>
                  <span style="display: table-cell;  padding: 10px; font-size: 15px; text-align: right;">₦ ' . number_format($values['product_price'], 2) . '</span>
                </p>
              </div>
            </div>';
        }

        $_SESSION['order_no'] = $order_no;
        $_SESSION['order_type'] = $isPayment ? "1" : "2";

        if ($isPayment) {
            $trx_ref = $db->real_escape_string($_POST['trx_ref']);
            $sql_insert_order = $db->query("INSERT INTO orders (order_no, user_id, amount, shipping_address, payment_method) VALUES ('$order_no', '$uid', '$total_order_price', '$shipping_address', '1')");
            $sql_insert_to_deposits = $db->query("INSERT INTO deposits (user_id, transaction_ref, type, type_no, deposit_amount) VALUES('$uid', '$trx_ref', '1', '$order_no', '$total_order_price')");
            $_SESSION['deposit_id'] = $db->insert_id;

            if ($sql_insert_to_deposits & $sql_insert_order) {
                echo json_encode(array('success' => 1, 'type' => 'card', 'amount_charged' => $total_order_price, 'trx_ref' => $trx_ref));
                exit();
            } else {
                echo json_encode(array('success' => 0, 'error_title' => "Order Error", 'error_message' => "Unable to process order."));
                exit();
            }
        } else {
            // INSERT ORDER INTO DATABASE
            $sql_insert_order = $db->query("INSERT INTO orders (order_no, user_id, amount, shipping_address, payment_method, placed_successfully) VALUES ('$order_no', '$uid', '$total_order_price', '$shipping_address', '2', '1')");

            if ($sql_insert_order) {
                // SEND MAIL TO USER AND ADMIN
                $user_message = '<!DOCTYPE html>
                <html>
                  <head>
                    <link rel="stylesheet" href="https://halfcarry.com.ng/assets/fonts/fonts.css" />
                  </head>
                  <body style="
                  font-family: \'Inter\', sans-serif !important">
                
                    <header style="margin: 50px 0; text-align: center;">
                      <img src="https://halfcarry.com.ng/assets/images/halfcarry-logo.jpeg" style="width: 150px; height: 80px;"/>
                    </header>
                    <main>
                      <section style="margin: 50px 10px; font-size: 14px;">
                        <p style="margin-bottom: 10px; line-height: 1.5;">Dear ' . $user_details['first_name'] . ',</p>
                
                        <p style="margin-bottom: 10px; line-height: 1.5; text-align: justify;">
                          Thank You for choosing <b>HalfCarry</b> as your preferred choice for
                          shopping quality products. Your Order #' . $order_no . ' has been placed successfully.
                        </p>

                        <p style="margin-bottom: 10px; line-height: 1.5; text-align: justify;">
                          It will be packed and and shipped as soon as possible. You would recieve a notification from us once the item(s)
                          are ready for delivery.
                        </p>
                
                        <p style="margin-bottom: 5px;"><b>Please note:</b></p>
                        
                        <ul>
                          <li>You can track your Halfcarry order through your personal Halfcarry account by logging into your dashboard <a href="https://halfcarry.com.ng/login" style="color: #ff5c00;">here</a>.
                          If you would like to cancel your order, simply contact us at <a href="tel:+23470266790425">+234 702 6790425</a>. Please note your order can only be cancelled prior to the order being shipped.
                          </li>
                          <li>If you ordered multiple items, you may recieve them on different days. This is because they are sold by different stores on our platform and we want each item delivered to you as soon as
                          possible after recieving it.
                          </li>
                        </ul>
                
                      </section>
                      <section style="margin: 50px 10px; font-size: 14px;">

                        <section style="margin: 50px 10px;">
                          <div style="display: table;  border-spacing: 10px; width: 100%;">
                            <div style="display: table-row; height: 100px;">
                              <div style="display: table-cell;">
                                <div style="border: 1px solid #ff5c00;">
                                  <h3 style="margin: 0px; padding: 10px 20px; background-color: #ff5c00; color: white; font-size: 15px;">
                                    Recipient details
                                  </h3>
                                  <p style="font-size: 15px; padding: 10px;">
                                    ' . $default_address_details['recipient_name'] . '
                                  </p>
                                </div>
                              </div>  
                              <div style="display: table-cell;">
                                <div style="border: 1px solid #ff5c00;">
                                  <h3 style="margin: 0px; padding: 10px 20px; background-color: #ff5c00; color: white; font-size: 15px;">
                                    Delivery address
                                  </h3>
                                  <p style="font-size: 15px; padding: 10px;">
                                    '  . $readable_shipping_address . '
                                  </p>
                                </div>
                              </div>  
                            </div>
                            <div style="display: table-row; height: 100px;">
                              <div style="display: table-cell;">
                                <div style="border: 1px solid #ff5c00;">
                                  <h3 style="margin: 0px; padding: 10px 20px; background-color: #ff5c00; color: white; font-size: 15px;">
                                    Delivery method
                                  </h3>
                                  <p style="font-size: 15px; padding: 10px;">
                                    Door Delivery
                                  </p>
                                </div>
                              </div> 
                            </div>
                          </div>
                        </section>

                        <p style=" font-size: 16px; margin-bottom: 10px;"><strong>You ordered for</strong></p>
                        
                        ' . $order_products . '

                      </section>
                
                      <section style="margin: 50px 10px;">
                        <div style="display: table; border-collapse: collapse; width: 100%; border: 2px solid #ff5c00;
                        border-bottom: 5px solid #ff5c00; margin-bottom: 40px;">
                          <div style="display: table-row; border-bottom: 2px solid #ff5c00;">
                            <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Total </span>
                            <span style="display: table-cell;"></span>
                            <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;"> ' . number_format($total_order_price, 2) . ' </span>
                          </div>
                          <div style="display: table-row; border-bottom: 2px solid #ff5c00;">
                            <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Payment Method </span>
                            <span style="display: table-cell;"></span>
                            <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;"> Postpaid (Cash on delivery) </span>
                          </div>
                      </section>
                    </main>
                  </body>
                </html>
                ';

                $admin_message = '<!DOCTYPE html>
                <html>
                  <head>
                    <link rel="stylesheet" href="https://halfcarry.com.ng/assets/fonts/fonts.css" />
                  </head>
                  <body style="
                  font-family: \'Inter\', sans-serif !important">
                
                    <header style="margin: 50px 0; text-align: center;">
                      <img src="https://halfcarry.com.ng/assets/images/halfcarry-logo.jpeg" style="width: 150px; height: 80px;"/>
                    </header>
                    <main>
                      <section style="margin: 50px 10px; font-size: 14px;">
                        <p style="margin-bottom: 10px; line-height: 1.5;">' . greeting() . 'Admin,</p>
                
                        <p style="margin-bottom: 10px; line-height: 1.5; text-align: justify;">
                          You have a new pending Order #' . $order_no . '
                        </p>
                      </section>

                      <section style="margin: 50px 10px; font-size: 14px;">

                        <section style="margin: 50px 10px;">
                          <p style="margin-bottom: 10px;">Address details:</p>

                          <div style="display: table;  border-spacing: 10px; width: 100%;">
                            <div style="display: table-row; height: 100px;">
                              <div style="display: table-cell;">
                                <div style="border: 1px solid #ff5c00;">
                                  <h3 style="margin: 0px; padding: 10px 20px; background-color: #ff5c00; color: white; font-size: 15px;">
                                    Recipient details
                                  </h3>
                                  <p style="font-size: 15px; padding: 10px;">
                                    ' . $default_address_details['recipient_name'] . '
                                  </p>
                                </div>
                              </div>  
                              <div style="display: table-cell;">
                                <div style="border: 1px solid #ff5c00;">
                                  <h3 style="margin: 0px; padding: 10px 20px; background-color: #ff5c00; color: white; font-size: 15px;">
                                    Delivery address
                                  </h3>
                                  <p style="font-size: 15px; padding: 10px;">
                                    '  . $readable_shipping_address . $default_address_details['recipient_phone_no'] . '
                                  </p>
                                </div>
                              </div>  
                            </div>
                            <div style="display: table-row; height: 100px;">
                              <div style="display: table-cell;">
                                <div style="border: 1px solid #ff5c00;">
                                  <h3 style="margin: 0px; padding: 10px 20px; background-color: #ff5c00; color: white; font-size: 15px;">
                                    Delivery method
                                  </h3>
                                  <p style="font-size: 15px; padding: 10px;">
                                    Door Delivery
                                  </p>
                                </div>
                              </div> 
                            </div>
                          </div>
                        </section>

                        <p style=" font-size: 16px; margin-bottom: 10px;"><strong>You ordered for</strong></p>
                        
                        ' . $order_products . '

                      </section>
                
                      <section style="margin: 50px 10px;">
                        <div style="display: table; border-collapse: collapse; width: 100%; border: 2px solid #ff5c00;
                        border-bottom: 5px solid #ff5c00; margin-bottom: 40px;">
                          <div style="display: table-row; border-bottom: 2px solid #ff5c00;">
                            <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> User name </span>
                            <span style="display: table-cell;"></span>
                            <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;"> ' . $user_details['last_name'] . $user_details['first_name'] . ' </span>
                          </div>
                          <div style="display: table-row; border-bottom: 2px solid #ff5c00;">
                            <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> User email </span>
                            <span style="display: table-cell;"></span>
                            <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;"> ' . $user_details['email'] . ' </span>
                          </div>
                          <div style="display: table-row; border-bottom: 2px solid #ff5c00;">
                            <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Total </span>
                            <span style="display: table-cell;"></span>
                            <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;"> ' . number_format($total_order_price, 2) . ' </span>
                          </div>
                          <div style="display: table-row; border-bottom: 2px solid #ff5c00;">
                            <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Payment Method </span>
                            <span style="display: table-cell;"></span>
                            <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;"> Postpaid (Cash on delivery) </span>
                          </div>
                      </section>
                    </main>
                  </body>
                </html>';

                // SEND MAILS TO BOTH USER AND ADMIN 
                // send_custom_mail($user_details['email'], "Your Halfcarry Order - #$order_no has been placed successfully", $user_message);
                // send_custom_mail("sodje.o@gmail.com", "Hello Charles, you have a new order - #$order_no", $admin_message);

                echo json_encode(array('success' => 1, 'type' => 'cash'));
                exit();
            } else {
                echo json_encode(array('success' => 0, 'error_title' => "Order Error", 'error_message' => "Unable to process order."));
                exit();
            }
        }
    }
} else {
    echo json_encode(array('success' => 0, 'error_title' => "Order Error", 'error_message' => "Unable to process order."));
    exit();
}
