<?php
    require(dirname(__DIR__).'/auth-library/call.php');

    $url = $_ENV['URL'];
    $url_lib = $_ENV['URL_LIB'];
    $url_admin = $_ENV['URL_ADMIN'];

    //Load other app resources
    include(dirname(__DIR__).'/auth-library/Model/UserController.php');
    include(dirname(__DIR__).'/auth-library/classes/auth.php');
    include(dirname(__DIR__).'/auth-library/classes/mailer.php');
    include(dirname(__DIR__).'/auth-library/classes/alert.php');
    include(dirname(__DIR__).'/auth-library/classes/connection.php');
    include(dirname(__DIR__).'/auth-library/helpers.php');
    
    $UserController = new UserModel();
?>