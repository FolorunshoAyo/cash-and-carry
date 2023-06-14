<?php
require(dirname(dirname(dirname(__DIR__))) . '/auth-library/resources.php');

if (isset($_POST['submit'])) {
    $oid = $db->real_escape_string($_POST['oid']);
    $status = $db->real_escape_string($_POST['status']);

    if (empty($oid) || empty($status)) {
        echo json_encode(array('success' => 0, 'error_title' => 'Update Order Error', 'error_msg' => 'Unable to update order'));
        exit();
    } else {
        $get_order_details = $db->query("SELECT * FROM orders WHERE order_no = {$oid}");

        $order_details = $get_order_details->fetch_assoc();
        $order_curr_status = $order_details['status'];

        $order_status_message = "";

        switch ($order_curr_status) {
            case "1":
                $order_curr_message = "pending";
                break;
            case "2":
                $order_curr_message = "awaiting shipment";
                break;
            case "3":
                $order_curr_message = "shipped";
                break;
            case "4";
                $order_curr_message = "completed";
                break;
            case "5":
                $order_curr_message = "cancelled";
                break;
            default:
                $order_curr_message = "unknown status";
                break;
        }

        if ($status <= $order_curr_status) {
            // SELECTED STATUS IS BACKTRACKED OR SET THE SAME WAY
            echo json_encode(array('success' => 0, 'error_title' => 'Update Order Error', 'error_msg' => "$order_curr_message cannot be re-selected"));
            exit();
        } else {
            //UPDATE ORDER STATUS
            $sql_update_order = $db->query("UPDATE orders SET status='$status' WHERE order_no=$oid");

            if ($sql_update_order) {
                // GET DEFAULT ADDRESS

                $shipping_address = explode("%", $order_details['shipping_address']);

                $recipient_name = $shipping_address[0];
                $recipient_address = $shipping_address[1];

                $mail_message = "";
                $order_products = "";

                $get_order_products = $db->query("SELECT * FROM orders_products INNER JOIN products ON orders_products.product_id = products.product_id WHERE order_no = {$oid}");
                $get_user_details = $db->query("SELECT * FROM users WHERE user_id = {$order_details['user_id']}");
                $user_details = $get_user_details->fetch_assoc();

                while ($product_details = $get_order_products->fetch_assoc()) {
                    $picture = explode(",", $product_details['pictures'])[0];
                  

                    $order_products .= '<div style="border: 1px solid #ff5c00;
                        border-bottom: 5px solid #ff5c00; margin-bottom: 40px;">
                        <div style="height: 80px;
                        text-align: center;
                        border-bottom: 1px solid #ff5c00;" >
                            <img src="https://halfcarry.com.ng/assets/product-images/' . $picture .  '" style=" height: 100%;
                            width: 80px;" />
                        </div>
                        <div style="display: table; border-collapse: collapse; width: 100%;">
                            <p style="display: table-row; border-bottom: 1px solid #ff5c00;">
                            <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Item </span>
                            <span style="display: table-cell;"></span>
                            <span style="display: table-cell;  padding: 10px; font-size: 15px; text-align: right; width: 100%;" >' . $product_details['name'] . '</span>
                            </p>
                            <p style="display: table-row; border-bottom: 1px solid #ff5c00;">
                            <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Quantity </span>
                            <span style="display: table-cell;  padding: 10px;"></span>
                            <span style="display: table-cell;  padding: 10px; font-size: 15px; text-align: right;">' . $product_details['quantity'] . '</span>
                            </p>
                            <p style="display: table-row; border-bottom: 1px solid #ff5c00;">
                            <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Price </span>
                            <span style="display: table-cell;  padding: 10px;"></span>
                            <span style="display: table-cell;  padding: 10px; font-size: 15px; text-align: right;">₦ ' . number_format($product_details['price'], 2) . '</span>
                            </p>
                        </div>
                        </div>';
                }

                if ($status === "2") {
                    // PREPARE AWAITING SHIPMENT MAIL
                    $mail_subject = "Your Halfcarry Order $oid has been Confirmed";

                    $mail_message = '<section style="margin: 50px 10px; font-size: 14px;">
                    <p style="margin-bottom: 10px; line-height: 1.5;">Dear ' . $user_details['first_name'] . ',</p>
            
                    <p style="margin-bottom: 10px; line-height: 1.5; text-align: justify;">
                      Thank You for choosing <b>HalfCarry</b> as your preferred choice for
                      shopping quality products. Your Order #' . $oid . ' has been confirmed successfully and is being prepared for shipment.
                    </p>

                    <p style="margin-bottom: 10px; line-height: 1.5; text-align: justify;">
                      It will be packed and and shipped as soon as possible. You would recieve a notification from us once the item(s)
                     shipped and out for delivery.
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
            
                  </section>';
                } elseif ($status === "3") {
                    // PREPARE SHIPPED MAIL
                    $mail_subject = "Your Halfcarry Order $oid has been shipped";

                    $mail_message = '<section style="margin: 50px 10px; font-size: 14px;">
                    <p style="margin-bottom: 10px; line-height: 1.5;">Dear ' . $user_details['first_name'] . ',</p>
            
                    <p style="margin-bottom: 10px; line-height: 1.5; text-align: justify;">
                      Thank You one again for choosing <b>HalfCarry</b> as your preferred choice for
                      shopping quality products.
                    </p>

                    <p style="margin-bottom: 10px; line-height: 1.5; text-align: justify;">
                     We\'d taught you\'d like to know that your item(s) from your Order #' . $oid . ' has been shipped and is out for delivery.
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
            
                  </section>';
                } elseif ($status === "4") {
                    // PREPARE COMPLETED MAIL
                    $mail_subject = "";

                    $mail_message = '<section style="margin: 50px 10px; font-size: 14px;">
                    <p style="margin-bottom: 10px; line-height: 1.5;">Dear ' . $user_details['first_name'] . ',</p>
            
                    <p style="margin-bottom: 10px; line-height: 1.5; text-align: justify;">
                      Thank You one again for choosing <b>HalfCarry</b> as your preferred choice for
                      shopping quality products.
                    </p>

                    <p style="margin-bottom: 10px; line-height: 1.5; text-align: justify;">
                     You\'re getting this mail to confirm that your Order #' . $oid . ' has been delivered to you.
                    </p>
            
                  </section>';
                } else {
                    // PREPARE CANCELLED MAIL
                    $mail_subject = "Your Halfcarry Order $oid was Cancelled";

                    $mail_message = '<section style="margin: 50px 10px; font-size: 14px;">
                    <p style="margin-bottom: 10px; line-height: 1.5;">Dear ' . $user_details['first_name'] . ',</p>
            
                    <p style="margin-bottom: 10px; line-height: 1.5; text-align: justify;">
                      Thank You for choosing <b>HalfCarry</b> as your preferred choice for
                      shopping quality products. 
                    </p>

                    <p style="margin-bottom: 10px; line-height: 1.5; text-align: justify;">
                    We regret to inform you that your Order #' . $oid . ' has been cancelled because your payment could not be completed.
                    </p>
            
                  </section>';
                }

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
                      ' . $mail_message . '
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
                                    ' . $recipient_name . '
                                  </p>
                                </div>
                              </div>  
                              <div style="display: table-cell;">
                                <div style="border: 1px solid #ff5c00;">
                                  <h3 style="margin: 0px; padding: 10px 20px; background-color: #ff5c00; color: white; font-size: 15px;">
                                    Delivery address
                                  </h3>
                                  <p style="font-size: 15px; padding: 10px;">
                                    '  . $recipient_address . '
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
                            <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;"> ' . number_format($order_details['amount'], 2) . ' </span>
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

                // send_custom_mail($user_details['email'], $mail_subject, $mail_message);

                echo json_encode(array('success' => 1));
                exit();
            }
        }
    }
} else {
    echo json_encode(array('success' => 0, 'error_title' => 'Update Order Error', 'error_msg' => 'Unable to update order'));
    exit();
}
