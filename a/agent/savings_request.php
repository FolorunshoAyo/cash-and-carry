<?php
require(dirname(dirname(__DIR__)) . '/auth-library/resources.php');
AgentAuth::User("a/login");
$agent_id=(isset($_SESSION['agent_id']))?$_SESSION['agent_id']:"";
$user_id=(isset($_GET['uid']))?$_GET['uid']:"";
// echo $user_id;
?>
<?php
if(isset($_POST['savings_request'])){
    
    $type_of_savings=$db->real_escape_string($_POST['type_of_savings']);
    $installment_type=$db->real_escape_string($_POST['installment_type']);
    $duration_of_savings=$db->real_escape_string($_POST['duration_of_savings']);
    $installment_amount=$db->real_escape_string($_POST['installment_amount']);
    $target_amount=$db->real_escape_string($_POST['target_amount']);
    if(empty($type_of_savings) 
    || empty($installment_type) 
    || empty($duration_of_savings) 
    || empty($installment_amount) 
    || empty($target_amount) 
    )
    {
        echo json_encode(array('success' => 0, 'error_title' => "Form error", 'error_message' => "All fields are required"));
        exit();
    }
    if($installment_amount>$target_amount){
        echo json_encode(array('success' => 0, 'error_title' => "Request error", 'error_message' => "Installment amount cannot be greater than the target amount"));
        exit();     
    }
    if(
        empty($agent_id) 
        || empty($user_id) 
    ){
        echo json_encode(array('success' => 0, 'error_title' => "Request error", 'error_message' => "Agent Or User Credentials are Missing"));
        exit(); 
    }
    else{
//CONVERTING AMOUNTS INTO MONETARY VALUES FOR ACCURACY
$installment_amount = number_format($installment_amount, 2, '.', ',');
$target_amount = number_format($target_amount, 2, '.', ',');


// GENERATING A RANDOM 10 DIGIT NUMBER
$min=1000000000;
$max=9999999999;
$randomNumber = str_pad(rand($min, $max), 10, '0', STR_PAD_LEFT); 

// Prepare a query to check if the random number exists
$foundDuplicate = true;
while ($foundDuplicate) {
    // Prepare a query to check if the random number exists
    $checkQuery = "SELECT COUNT(*) AS count FROM savings_requests WHERE savings_id = '$randomNumber'";
    $result = $db->query($checkQuery);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $count = $row["count"];

        if ($count > 0) {
            // If the random number already exists, generate a new one
            $randomNumber = rand($min, $max);
            $randomNumber = str_pad($randomNumber, 10, '0', STR_PAD_LEFT);
        } else {
            $foundDuplicate = false;
        }
    } else {
        $foundDuplicate = false;
    }
}

// Insert the distinct random number into the database
$statement_personal = $db->prepare("INSERT INTO `savings_requests`(`savings_id`, `user_id`, `agent_id`, `type_of_savings`, `installment_type`, `duration_of_savings`, `installment_amount`, `target_amount`, `status`) VALUES (?,?,?,?,?,?,?,?,?)");
$status_pending='1';
$statement_personal->bind_param("sssssssss", $randomNumber, $user_id, $agent_id, $type_of_savings, $installment_type,$duration_of_savings,$installment_amount,$target_amount,$status_pending);
if ($statement_personal->execute()) {
    echo json_encode(array('success' => 1));
    echo"
    <script>
        alert('savings request successful');
        window.location.href='agent-customers';
    </script>
    ";

} else {
    $error_message="Error Creating Savings Request: " . $db->error;
    echo json_encode(array('success' => 0, 'error_title' => "Fatal", 'error_message' => $error_message));
    echo"
    <script>
        alert('savings request successful');
        window.location.href='agent-customers';
    </script>
    ";
    exit();
}






}
}



?>