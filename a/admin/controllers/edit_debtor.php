<?php
    require(dirname(dirname(dirname(__DIR__))) . '/auth-library/resources.php');
     
    if(isset($_POST['submit'])){
        $did = $db->real_escape_string($_POST['did']);
        $fname = $db->real_escape_string($_POST['fname']);
        $lname = $db->real_escape_string($_POST['lname']);
        $email = $db->real_escape_string($_POST['email']);
        $phoneno = $db->real_escape_string($_POST['phoneno']);
        $oaddress = $db->real_escape_string($_POST['oaddress']);
        $haddress = $db->real_escape_string($_POST['haddress']);
        $bvn = $db->real_escape_string(isset($_POST['bvn'])? $_POST['bvn'] : "" );

        $targetDir = "../../agents/customer-images/"; 
        $allowTypes = array('jpg','png','jpeg'); 
        
        $fileName = $_FILES['customer-img']['name'];

        if(empty($fname) || empty($lname) || empty($email) || empty($phoneno) || empty($oaddress) || empty($haddress)){
            echo json_encode(array('success' => 0, 'error_title' => "Update Customer", 'error_msg' => 'One or more fields are empty'));
        }elseif(!empty($fileName)){
            $fileName = basename($fileName); 
            $targetFilePath = $targetDir . $fileName; 
            
            // Check whether file type is valid 
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            if(in_array($fileType, $allowTypes)){
                // Upload file to server 
                if(move_uploaded_file($_FILES["customer-img"]["tmp_name"], $targetFilePath)){ 
                    $sql_update_customer = $db->query("UPDATE debtors SET first_name='$fname', last_name='$lname', email='$email', phone_no='$phoneno', home_address='$haddress', office_address='$oaddress', bvn='$bvn', image='$fileName' WHERE debtor_id='$did'");

                    if($sql_update_customer){
                        echo json_encode(array('success' => 1));
                    }
                }else{
                    echo json_encode(array('success' => 0, 'error_title' => 'Update Customer', 'error_msg' => 'Unable to move file'));
                }
            }else{
                echo json_encode(array('success' => 0, 'error_title' => 'Update Customer', 'error_msg' => 'Image file type not supported'));
            }
        }else{
            $sql_update_debtor = $db->query("UPDATE debtors SET first_name='$fname', last_name='$lname', email='$email', phone_no='$phoneno', home_address='$haddress', office_address='$oaddress', bvn='$bvn' WHERE debtor_id='$did'");

            if($sql_update_debtor){
                echo json_encode(array('success' => 1));
            }
        }
    }else{
        echo json_encode(array('success' => 0, 'error_title' => 'Update Customer', 'error_msg' => 'Unable to updae customer'));
    }
?>