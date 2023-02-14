<?php
    require(dirname(dirname(__DIR__)) . '/auth-library/resources.php');

    if(isset($_POST['submit'])){
        $uid = $_SESSION['user_id'];
        $aid =  $db->real_escape_string($_POST['aid']);

        if(empty($aid)){
            echo json_encode(array('success' => 0, 'error_title' => "Address Update Error", 'error_msg' => 'One or more input fields are empty'));
            exit();
        }else{
            // SET FORMER DEFAULT ADDRESS TO INACTIVE
            $sql_previous_default_address = $db->query("SELECT * FROM user_addresses WHERE user_id='$uid' AND active=1");
            $previous_default_address_id = $sql_previous_default_address->fetch_assoc()['address_id'];

            $sql_update_previous_address_details = $db->query("UPDATE user_addresses SET active=0 WHERE address_id='$previous_default_address_id'");

            if($sql_update_previous_address_details){
                $sql_update_new_address_to_default = $db->query("UPDATE user_addresses SET active=1 WHERE address_id='$aid' AND user_id='$uid'");

                if($sql_update_new_address_to_default){
                    echo json_encode(array('success' => 1));
                    exit();
                }
            }
        }
    }else{ 
        echo json_encode(array('success' => 0, 'error_title' => 'Fatal', 'error_msg' => 'Address cannot be updated'));
        exit();
    } 

?>