<?php
    require(dirname(dirname(dirname(__DIR__))) . '/auth-library/resources.php');
     
    if(isset($_POST['submit'])){
        $fname = $db->real_escape_string($_POST['fname']);
        $lname = $db->real_escape_string($_POST['lname']);
        $uname = $db->real_escape_string($_POST['uname']);
        $email = $db->real_escape_string($_POST['email']);
        $phoneno = $db->real_escape_string($_POST['phoneno']);
        $account_status = isset($_POST['active'])? $db->real_escape_string($_POST['active']) : "2  ";
        $random_pass = rand(00000000, 99999999);
        $random_pass = "123456";

        if(empty($fname) || empty($lname) || empty($uname) || empty($phoneno) || empty($account_status)){
            echo json_encode(array('success' => 0, 'error_title' => "Create User", 'error_message' => 'One or more fields are empty'));
        }else{
            if(!empty($uname)){
                $sql_check_existing_user = $db->query("SELECT * FROM users WHERE username = '{$uname}'");

                if ($sql_check_existing_user->num_rows == 1) {
                    echo json_encode(array('success' => 0, 'error_title' => 'Create Agent', 'error_message' => 'A user with this username already exist'));
                    exit();
                }
            }

            if(!empty($email)){
                $sql_check_existing_user = $db->query("SELECT * FROM users WHERE email = '{$email}'");

                if ($sql_check_existing_user->num_rows == 1) {
                    echo json_encode(array('success' => 0, 'error_title' => 'Create Agent', 'error_message' => 'A user with this email already exist'));
                    exit();
                }
            }

            // MD5 HASHING FOR PASSWORD
            $passkey = password_hash(strval($random_pass), PASSWORD_DEFAULT);
            $sql_add_user = $db->query("INSERT INTO users (last_name, first_name, username, email, passkey, is_email_verified, phone_no, account_status) VALUES('$lname', '$fname', '$uname', '$email', '$passkey', '1', '$phoneno', '$account_status')");

            if($sql_add_user){
                // $subject = "Halfcarry User Verification";
                // // SEND MAIL
                // $html = "<!DOCTYPE html>
                // <html>
                //   <head>
                //     <link rel='stylesheet' href='https://halfcarry.com.ng/assets/fonts/fonts.css' />
                //   </head>
                //   <body style='
                //   font-family: 'Inter', sans-serif !important'>
                
                //     <header style='margin: 50px 0; text-align: center;'>
                //       <img src='https://halfcarry.com.ng/assets/images/halfcarry-logo.jpeg' style='width: 150px; height: 80px;'/>
                //     </header>
                //     <main>
                //       <section style='margin: 50px 10px; font-size: 14px;'>
                //       <p style='margin-bottom: 10px; line-height: 1.5;'>'" . greeting() . $fname . ",</p>
                
                //         <p style='margin-bottom: 10px; line-height: 1.5; text-align: justify;'>
                //           Welcome to <b>HalfCarry</b> Your user password is <b>" . $random_pass . "</b>
                //         </p>
                //     </main>
                //     </body>
                //     </html>
                //     ";

                // send_custom_mail($email, $subject, $message);
                echo json_encode(array('success' => 1, 'user_name' => $uname, 'random_pass' => $random_pass));
            }
        }
    }else{
        echo json_encode(array('success' => 0, 'error_title' => 'Create Agent', 'error_message' => 'Unable to create user'));
    }
?>