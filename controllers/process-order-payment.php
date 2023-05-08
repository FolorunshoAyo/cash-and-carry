<?php
require(dirname(__DIR__) . '/auth-library/resources.php');
Auth::User("login");

$uid = $_SESSION['user_id'];

if (isset($_GET["transaction_id"]) && isset($_GET["status"]) && isset($_GET["tx_ref"])) {
  $trans_id = $_GET['transaction_id'];
  $trans_status = $_GET['status'];
  $trans_ref = $_GET['tx_ref'];

  $url = "https://api.flutterwave.com/v3/transactions/" . $trans_id . "/verify";
  //Create cURL session
  $curl = curl_init($url);
  //Turn off SSL checker
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
  //Decide the request that you want
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
  //Set the API headers
  curl_setopt($curl, CURLOPT_HTTPHEADER, [
    // "Authorization: Bearer FLWSECK-39743e6c4b313849e1a091fb9e47b322-X",
    "Authorization: Bearer FLWSECK_TEST-a2811a821fc0113cb78c03ca07632980-X",
    "Content-Type: Application/json"
  ]);
  //Run cURL
  $run = curl_exec($curl);
  //Check for erros
  $error = curl_error($curl);
  if ($error) {
    die("Curl returned some errors: " . $error);
  }

  //echo"<pre>" . $run ."</pre>";

  //Convert to json obj
  $result = json_decode($run);
  //print_r($result);

  if ($result->data->status == "successful") {
    $status = $result->data->status;
    $api_tranx_ref = $result->data->tx_ref;
    $api_amount = $result->data->amount;
    $api_charged_amount = $result->data->charged_amount;

    $order_no = $_SESSION['order_no'];
    $deposit_id = $_SESSION['deposit_id'];
    $total_order_price = 0;

    // GET DEFAULT ADDRESS
    $sql_address = $db->query("SELECT * FROM user_addresses WHERE user_id={$uid} AND active=1");
    $address_id = $sql_address->fetch_assoc()['address_id'];

    $sql_address_details = $db->query("SELECT * FROM addresses WHERE address_id={$address_id}");

    $default_address_details = $sql_address_details->fetch_assoc();

    $shipping_address = $default_address_details['recipient_name'] . "%" . $default_address_details['delivery_address'] . ", " . $default_address_details['city_name'] . ". " . $default_address_details['address_state'] . "." .  " (" . $default_address_details['address_postalcode'] . ") " . $default_address_details['recipient_phone_no'];

    $readable_shipping_address = $default_address_details['delivery_address'] . ", " . $default_address_details['city_name'] . ". " . $default_address_details['address_state'] . "." .  " (" . $default_address_details['address_postal_code'] . ") ";

    if ($default_address_details['additional_info']) {
      $shipping_address .= "<br>" . $default_address_details['additional_info'];
    }

    $order_products = "";

    // INSERT ORDER INTO DATABASE
    foreach ($_SESSION['shopping_cart'] as $key => $values) {
      $product_id = $values['product_id'];
      $quantity = $values['product_quantity'];

      $total_order_price += $values['product_quantity'] * $values['product_price'];

      $db->query("INSERT INTO orders_products (order_id, product_id) VALUES({$order_no}, {$product_id}, {$quantity})");

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
                  <span style="display: table-cell;  padding: 10px; font-size: 15px; text-align: right;">₦ ' . number_format($value['product_price'], 2) . '</span>
                </p>
              </div>
            </div>';
    }



    $sql_update_order = $db->query("UPDATE orders SET placed_successfully = 1 WHERE order_no = {$order_no}");
    $sql_update_deposit = $db->query("UPDATE deposits SET deposit_status=1 WHERE deposit_id = {$deposit_id}");

    unset($_SESSION['deposit_id']);

    if ($sql_insert_order && $sql_update_deposit) {
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
                          It will be packed and and shipped as soon as possible. You would recieve a notificcation from us once the item(s)
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
                            <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;"> Prepaid </span>
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
                            <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;"> Prepaid </span>
                          </div>
                      </section>
                    </main>
                  </body>
                </html>';

      // SEND MAILS TO BOTH USER AND ADMIN 
      // send_custom_mail($user_details['email'], "Your Halfcarry Order - #$order_no has been placed successfully", $user_message);
      // send_custom_mail("sodje.o@gmail.com", "Hello Charles, you have a new order - #$order_no", $admin_message);

      header("location: ../order-success");
    } else {
      header("location: ../order-failure");
    }
  } else {
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
                    shopping quality products. 
                  </p>

                  <p style="margin-bottom: 10px; line-height: 1.5; text-align: justify;">
                    We regret to inform you that your Order #' . $oid . ' has been cancelled because your payment could not be completed.
                  </p>
          
                  <p style="margin-bottom: 5px;"><b>This could have happened because:</b></p>
                  
                  <ul>
                    <li>You attempted to pay via Debit/Credit Card but wrongly entered the Security PIN/ Name / Expiry date or your card is not activated for online transactions by your bank.
                    </li>
                    <liYou have insufficient funds or credit.
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
                      <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;"> Prepaid </span>
                    </div>
                </section>
              </main>
            </body>
          </html>
          ';
          
    header("location: ../order-failure");
  }

  curl_close($curl);
} else {
  header("location: ../cart/");
}
