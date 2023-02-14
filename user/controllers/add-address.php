<?php
    require(dirname(dirname(__DIR__)) . '/auth-library/resources.php');

    if(isset($_POST['submit'])){
        $uid = $_SESSION['user_id'];
        $rname =  $db->real_escape_string($_POST['rname']);
        $rphoneno = $db->real_escape_string($_POST['rphoneno']);
        $daddress = $db->real_escape_string($_POST['daddress']);
        $ainfo = $db->real_escape_string($_POST['ainfo']);
        $city = $db->real_escape_string($_POST['city']);
        $pcode = $db->real_escape_string($_POST['pcode']);
        $state = $db->real_escape_string($_POST['state']);

        if(empty($rname) || empty($rphoneno) || empty($daddress) || empty($city) || empty($pcode) || empty($state)){
            echo json_encode(array('success' => 0, 'error_title' => "Address Update Error", 'error_msg' => 'One or more input fields are empty'));
            exit();
        }else{
            // CHECK FOR DEFAULT
            $sql_check_default_address = $db->query("SELECT * FROM user_addresses WHERE user_id={$uid} AND active=1");

            if($sql_check_default_address->num_rows === 1){
                // CREATE EXTRA ADDRESS
                $sql_add_to_addresses = $db->query("INSERT INTO addresses (recipient_name, recipient_phone_no, additional_info, city_name, delivery_address, address_state, address_postalcode) VALUES ('$rname', '$rphoneno', '$ainfo', '$city', '$daddress', '$state', '$pcode')");

                if($sql_add_to_addresses){
                    $address_id = $db->insert_id;
                    //INSERT IN ADDRESS LOOKUP 
                    $sql_add_to_address_lookup = $db->query("INSERT INTO user_addresses (user_id, address_id, active) VALUES ('$uid', '$address_id', 0)");
                    echo json_encode(array('success' => 1));
                    exit();
                }
            }else{
                // CREATE DEFAULT ADDRESS
                $sql_add_to_addresses = $db->query("INSERT INTO addresses (recipient_name, recipient_phone_no, additional_info, city_name, delivery_address, address_state, address_postalcode) VALUES ('$rname', '$rphoneno', '$ainfo', '$city', '$daddress', '$state', '$pcode')");

                if($sql_add_to_addresses){
                    $address_id = $db->insert_id;
                    //INSERT IN ADDRESS LOOKUP 
                    $sql_add_to_address_lookup = $db->query("INSERT INTO user_addresses (user_id, address_id, active) VALUES ('$uid', '$address_id', 1)");
                    echo json_encode(array('success' => 1));
                    exit(); 
                }
            }
        }
    }else{ 
        echo json_encode(array('success' => 0, 'error_title' => 'Fatal', 'error_msg' => 'Address cannot be updated'));
    } 

?>