<?php 
require(dirname(dirname(dirname(__DIR__))) . '/auth-library/resources.php');

if(isset($_POST['submit'])){
    $productID =  $db->real_escape_string($_POST['pid']);

    $deletedProduct = $db->query("SELECT name FROM products WHERE product_id={$productID}");

    $deletedProductDetails = $deletedProduct->fetch_assoc();

    $productName = $deletedProductDetails['name'];

    $deleteProduct = $db->query("DELETE FROM product_meta WHERE product_id={$productID}");

    if($deleteProduct){
        $deleteProductMeta = $db->query("DELETE FROM products WHERE product_id={$productID}");

        echo json_encode(array('success' => 1, 'title' => "Product Delete", 'message' => "$productName was deleted successfully"));
    }else{
        echo json_encode(array('success' => 0, 'error_title' => 'Product Delete', 'error_message' => 'There was an error deleting the product'));
    }
}
?>