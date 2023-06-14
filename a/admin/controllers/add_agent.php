<?php
    require(dirname(dirname(dirname(__DIR__))) . '/auth-library/resources.php');
     
    if(isset($_POST['submit'])){
        $fname = $db->real_escape_string($_POST['fname']);
        $lname = $db->real_escape_string($_POST['lname']);
        $oname = $db->real_escape_string($_POST['oname']);
        $email = $db->real_escape_string($_POST['email']);
        $phoneno = $db->real_escape_string($_POST['phoneno']);
        $account_status = isset($_POST['active'])? $db->real_escape_string($_POST['active']) : "2  ";
        $random_pass = rand(00000000, 99999999);

        if(empty($fname) || empty($lname) || empty($oname) || empty($email) || empty($phoneno) || empty($account_status)){
            echo json_encode(array('success' => 0, 'error_title' => "Create Agent", 'error_msg' => 'One or more fields are empty'));
        }else{
            // MD5 HASHING FOR PASSWORD
            $passkey = password_hash(strval($random_pass), PASSWORD_DEFAULT);
            $sql_add_agent = $db->query("INSERT INTO agents (last_name, first_name, other_name, email, passkey, phone_no, account_status) VALUES('$lname', '$fname', '$oname', '$email', '$passkey', '$phoneno', '$account_status')");

            if($sql_add_agent){
                $subject = "Halfcarry Agent Verification";
                // SEND MAIL
                $html = "<!DOCTYPE html>
                <html>
                  <head>
                    <link rel='stylesheet' href='https://halfcarry.com.ng/assets/fonts/fonts.css' />
                  </head>
                  <body style='
                  font-family: 'Inter', sans-serif !important'>
                
                    <header style='margin: 50px 0; text-align: center;'>
                      <img src='https://halfcarry.com.ng/assets/images/halfcarry-logo.jpeg' style='width: 150px; height: 80px;'/>
                    </header>
                    <main>
                      <section style='margin: 50px 10px; font-size: 14px;'>
                      <p style='margin-bottom: 10px; line-height: 1.5;'>'" . greeting() . $fname . ",</p>
                
                        <p style='margin-bottom: 10px; line-height: 1.5; text-align: justify;'>
                          Welcome to <b>HalfCarry</b> Your agent password is <b>" . $random_pass . "</b>
                        </p>
                    </main>
                    </body>
                    </html>
                    ";

                // send_custom_mail($email, $subject, $message);
                echo json_encode(array('success' => 1, 'agent_name' => $fname, 'random_pass' => $random_pass));
            }
        }
    }else{
        echo json_encode(array('success' => 0, 'error_title' => 'Create Agent', 'error_msg' => 'Unable to create agent'));
    }
?>