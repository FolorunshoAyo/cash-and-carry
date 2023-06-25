<?php
    include(dirname(__DIR__) . "/auth-library/resources.php");
?>
<?php 
    require_once(dirname(__DIR__) . '/auth-library/vendor/autoload.php'); 
?>
<?php
$clientID = "917917620260-mj2hqhp2r73k7fqu5r5i3ob2u5plo7q0.apps.googleusercontent.com";
$secret = "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";

// Google API Client
$gclient = new Google_Client();

$gclient->setClientId($clientID);
$gclient->setClientSecret($secret);
$gclient->setRedirectUri('https://localhost/cash-and-carry/login');


$gclient->addScope('email');
$gclient->addScope('profile');

if(isset($_GET['code'])){
    // Get Token
    $token = $gclient->fetchAccessTokenWithAuthCode($_GET['code']);

    // Check if fetching token did not return any errors
    if(!isset($token['error'])){
        // Setting Access token
        $gclient->setAccessToken($token['access_token']);

        // store access token
        $_SESSION['access_token'] = $token['access_token'];

        // Get Account Profile using Google Service
        $gservice = new Google_Service_Oauth2($gclient);

        // Get User Data
        $udata = $gservice->userinfo->get();

        // CHECK AND STORE USER INFORMATION IN DATABASE
        $user_email = $udata['email'];
        $first_name = $udata['givenName'];
        $last_name = $udata['familyName'];

        $sql_check_email = $db->query("SELECT * FROM users WHERE email = '$user_email'");

        if($sql_check_email->num_rows === 0){
            $sql_store_records = $db->query("INSERT INTO users (last_name, first_name, email, phone_no, is_email_verified) VALUES ('$last_name', '$first_name', '$user_email', '','1')");

            $_SESSION['user_id'] = $sql_store_records->insert_id;
            $_SESSION['user_name'] = $first_name . " " . $last_name;
        }else{
            $existing_user_details = $sql_check_email->fetch_assoc();

            $_SESSION['user_id'] = $existing_user_details['user_id'];
            $_SESSION['user_name'] = $existing_user_details['first_name'] . " " . $existing_user_details['last_name'];
        }

        header('location: ./');
    }
}

?>