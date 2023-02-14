<?php
    require(dirname(dirname(dirname(__DIR__))) . '/auth-library/resources.php');

    if(isset($_POST['submit'])){
        $oid = $db->real_escape_string($_POST['oid']);
        $status = $db->real_escape_string($_POST['status']);

        if(empty($oid) || empty($status)){
            echo json_encode(array('success' => 0, 'error_title' => 'Update Order Error', 'error_msg' => 'Unable to update order'));
            exit();
        }else{
            //UPDATE ORDER STATUS
            $sql_update_order = $db->query("UPDATE orders SET status='$status' WHERE order_no=$oid");

            if($sql_update_order){
                echo json_encode(array('success' => 1));
                exit();
            }
        }

    }else{
        echo json_encode(array('success' => 0, 'error_title' => 'Update Order Error', 'error_msg' => 'Unable to update order'));
        exit();
    }
?>