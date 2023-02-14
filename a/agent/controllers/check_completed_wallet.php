<?php
    require(dirname(dirname(dirname(__DIR__))) . '/auth-library/resources.php');

    if(isset($_GET['wid'])){
        $wid = $_GET['wid'];

        $sql_check_completed = $db->query("SELECT completed from agent_wallets WHERE wallet_id='$wid'");

        $isWalletComplete = $sql_check_completed->fetch_assoc()['completed'];

        echo json_encode(array('completed' => $isWalletComplete));
    }
?>