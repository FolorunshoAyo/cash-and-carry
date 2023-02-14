<?php
    require(dirname(dirname(__DIR__)) . '/auth-library/resources.php');

    if(isset($_POST['submit'])){
        $uid = $_SESSION['user_id'];
        $aid =  $db->real_escape_string($_POST['aid']);

        if(empty($aid)){
            echo json_encode(array('success' => 0, 'error_title' => "Address Update Error", 'error_msg' => 'One or more input fields are empty'));
            exit();
        }else{
            // DELETE RECORD FROM LOOKUP
            $sql_delete_address_lookup = $db->query("DELETE FROM user_addresses WHERE address_id='$aid' AND user_id='$uid'");

            if($sql_delete_address_lookup){
                //DELETE RECORD FROM ADDRESSES
                $sql_delete_address = $db->query("DELETE FROM addresses WHERE address_id='$aid'"); 

                if($sql_delete_address){
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