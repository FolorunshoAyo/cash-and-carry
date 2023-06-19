<?php
require 'vendor/autoload.php';

// Set up the Google Client
$client = new Google_Client();
$client->setClientId('176009817869-5b0iq35i3lf14sm6chdqbcvmuk3buflu.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('index.php');
$client->addScope('email'); // Add additional scopes as needed

// Handle the authorization flow
if (!isset($_GET['code'])) {
    // Step 1: Redirect the user to the OAuth authorization URL
    $authUrl = $client->createAuthUrl();
    header('Location: ' . $authUrl);
    exit;
} else {
    // Step 2: Handle the authorization callback
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);

    // Step 3: Use the access token to make authenticated API requests
    $service = new Google_Service_Oauth2($client);
    $userInfo = $service->userinfo->get();
    
    // Access user data
    $userId = $userInfo->id;
    $userName = $userInfo->name;
    $userEmail = $userInfo->email;

    // Do something with the user data
    // ...

    // Redirect or display success message
    // ...
}
?>
