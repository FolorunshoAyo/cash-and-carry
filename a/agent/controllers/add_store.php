<?php
    require(dirname(dirname(dirname(__DIR__))) . '/auth-library/resources.php');
     
    $agent_id = $_SESSION['agent_id'];

    if(isset($_POST['submit'])){
        $sname = $db->real_escape_string($_POST['sname']);
        $fname = $db->real_escape_string($_POST['fname']);
        $lname = $db->real_escape_string($_POST['lname']);
        $semail = $db->real_escape_string($_POST['semail']);
        $phoneno = $db->real_escape_string($_POST['phoneno']);
        $reg_no = $db->real_escape_string($_POST['reg_no']);

        if(empty($sname) || empty($fname) || empty($lname) || empty($semail) || empty($phoneno) || empty($reg_no)){
            echo json_encode(array('success' => 0, 'error_title' => "Create Agent", 'error_msg' => 'One or more fields are empty'));
        }else{
            $owner_name = trim($lname) . " " . trim($fname);
            $sql_add_agent = $db->query("INSERT INTO stores (agent_id, name, owner_name, owner_email, owner_phone, reg_no) VALUES('$agent_id', '$sname', '$owner_name', '$semail', '$phoneno', '$reg_no')");

            if($sql_add_agent){
                $subject = "Halfcarry Store Verification";
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
                          Welcome to <b>HalfCarry</b> You are recieving this mail to confirm your registeration to the platform.
                          Thank you for trusting us. We are looking forward to working with you and expanding together.
                        </p>
                    </main>
                    </body>
                    </html>
                    ";

                // send_custom_mail($email, $subject, $message);
                echo json_encode(array('success' => 1, 'store_name' => $sname));
            }
        }
    }else{
        echo json_encode(array('success' => 0, 'error_title' => 'Create New Store', 'error_msg' => 'Unable to create store'));
    }
?>