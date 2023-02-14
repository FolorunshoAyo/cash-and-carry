<?php 
require(dirname(dirname(dirname(__DIR__))) . '/auth-library/resources.php');

if(isset($_POST['submit'])){
    $agentID =  $db->real_escape_string($_POST['aid']);

    $deletedAgent = $db->query("SELECT first_name FROM agents WHERE agent_id={$agentID}");

    $deletedAgentDetails = $deletedAgent->fetch_assoc();

    $agentName = $deletedAgentDetails['first_name'];

    if($deletedAgent){
        $deleteAgent = $db->query("UPDATE agents SET deleted='1' WHERE agent_id={$agentID}");

        echo json_encode(array('success' => 1, 'title' => "Agent Delete", 'message' => "$agentName was deleted successfully"));
    }else{
        echo json_encode(array('success' => 0, 'error_title' => 'Product Delete', 'error_message' => 'There was an error deleting the product'));
    }
}
?>