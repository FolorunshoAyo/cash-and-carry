<?php 
require(dirname(dirname(dirname(__DIR__))) . '/auth-library/resources.php');
     
if(isset($_POST['submit'])){ 
    $productID =  $db->real_escape_string($_POST['product_id']);
    $productName = $db->real_escape_string($_POST['pname']);
	$productPrice = $db->real_escape_string($_POST['pprice']);
    $dailyPaymentPrice = $db->real_escape_string($_POST['daily_payment']);
    $durationInMonths = $db->real_escape_string($_POST['duration']);
    $productDesc = $db->real_escape_string($_POST['pdesc']);
    $category = $db->real_escape_string($_POST['category']);
    $active = $db->real_escape_string($_POST['active']);

    // File upload configuration 
    $targetDir = "../images/"; 
    $allowTypes = array('jpg','png','jpeg'); 
     
    $fileNames = array_filter($_FILES['pimages']['name']); 
    $numberOfFiles = count($fileNames);

    $images = "";
    $errors = array();

    if(!empty($fileNames)){ 
        foreach($_FILES['pimages']['name'] as $key=>$val){ 
            // File upload path 
            $fileName = basename($_FILES['pimages']['name'][$key]); 
            $targetFilePath = $targetDir . $fileName; 
             
            // Check whether file type is valid 
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
             
            if(in_array($fileType, $allowTypes)){ 
                // Upload file to server 
                if(move_uploaded_file($_FILES["pimages"]["tmp_name"][$key], $targetFilePath)){ 
                    // add images names for storage in the database
                    if(($key + 1) === $numberOfFiles){
                        $images .= "$fileName";
                    }else{
                        $images .= "$fileName,";
                    }
                }else{
                    array_push($errors, "Unable to move file");
                }
            }else{
                array_push($errors, "The file type is not allowed");
            }
        } 

        // CHECK IF FORM DATA WAS PASSED
        if(empty($productID) || empty($productName) || empty($productPrice) || empty($dailyPaymentPrice) || empty($durationInMonths) || empty($productDesc)){
            echo json_encode(array('success' => 0, 'error_title' => 'Product Edit', 'error_msg' => 'Some field(s) were not filled'));
            exit();
        }

        if(count($errors) === 0){ 
            // DELETE EXISTING FILES
            // $sql_former_images = $db->query("SELECT pictures FROM products WHERE product_id={$productID}");

            // $pictures = explode(",", $sql_former_images->fetch_assoc()['pictures']);
            // foreach($pictures as $picture){
            //     unlink("../images/" . $picture);
            // }

            // Update product details in database
            $updateProduct = $db->query("UPDATE products SET name = '$productName', price = '$productPrice', pictures='$images', details='$productDesc', active='$active', category='$category'
            WHERE product_id = '$productID';"); 
            if($updateProduct){ 
                $updateProductMeta = $db->query("UPDATE product_meta SET daily_payment='$dailyPaymentPrice', duration_in_months='$durationInMonths' WHERE product_id = '$productID';");

                if($updateProductMeta){
                    echo json_encode(array('success' => 1, 'product_name' => $productName));
                }else{
                    echo json_encode(array('success' => 0, 'error_title' => 'Product Edit', 'error_msg' => '(errno: 1) There was an error editing the product'));
                }
            }else{ 
               echo json_encode(array('success' => 0, 'error_title' => 'Product Edit', 'error_msg' => '(errno: 2) There was an error editing the product'));
            } 
        }else{ 
            echo json_encode(array('success' => 0, 'error_title' => 'Product Edit', 'error_msg' => '(errNo: 3) There was an error editing the product'));
        } 
    }else{ 
       echo json_encode(array('success' => 0, 'error_title' => 'Image Edit', 'error_msg' => 'No Images were uploaded'));
    } 
} 
 
?>
