<?php
    require(dirname(dirname(__DIR__)) . '/auth-library/resources.php');


    if(isset($_POST['submit'])){
        $aid = $db->real_escape_string($_POST['aid']); 
        $rname =  $db->real_escape_string($_POST['rname']);
        $rphoneno = $db->real_escape_string($_POST['rphoneno']);
        $daddress = $db->real_escape_string($_POST['daddress']);
        $ainfo = $db->real_escape_string($_POST['ainfo']);
        $city = $db->real_escape_string($_POST['city']);
        $pcode = $db->real_escape_string($_POST['pcode']);
        $state = $db->real_escape_string($_POST['state']);

        if(empty($rname) || empty($rphoneno) || empty($daddress) || empty($ainfo) || empty($city) || empty($pcode) || empty($state)){
            echo json_encode(array('success' => 0, 'error_title' => "Address Update Error", 'error_msg' => 'One or more input fields are empty'));
            exit();
        }else{
            $sql_update_address = $db->query("UPDATE addresses SET recipient_name='$rname', recipient_phone_no='$rphoneno', additional_info='$ainfo', city_name='$city', delivery_address='$daddress', address_state='$state', address_postalcode='$pcode' WHERE address_id='$aid'");

            if($sql_update_address){
                echo json_encode(array('success' => 1));
            }else{
                echo json_encode(array('success' => 0, 'error_title' => "Address Update Error", 'error_msg' => 'Address cannot be updated'));
            }
        }
    }else{ 
        echo json_encode(array('success' => 0, 'error_title' => 'Fatal', 'error_msg' => 'Address cannot be updated'));
    } 

?>