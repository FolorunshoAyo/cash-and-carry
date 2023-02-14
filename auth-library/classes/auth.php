<?php
session_start();
require(dirname(__DIR__)."/call.php");
class Auth
{
    /**
     * Authentication for pages outside the user folder
     */
    static function Route($url)
    {
        if (isset($_SESSION['user_id'])) {             
            header("Location: ".$_ENV['URL']. $url);
        }else {
        //Don't Redirect
        }
    }

    /**
     * Authentication for pages inside the user folder
     * */
    static function  User($url)
    {
        if (isset($_SESSION['user_id'])) {
            //Don't Redirect
        }else {
            header("Location: ".$_ENV['URL']. $url);
        }
    }
}

class AdminAuth extends Auth{
    /**
     * Authentication for pages ouside the admin folder
     */
    static function Route($url)
    {
        if (isset($_SESSION['admin_id'])) {             
            header("Location: ".$_ENV['URL']. $url);
        }else {
        //Don't Redirect
        }
    }

    /**
     * Authentication for pages inside the admin folder
     * */
    static function  User($url)
    {
        if (isset($_SESSION['admin_id'])) {
            //Don't Redirect
        }else {
            header("Location: ".$_ENV['URL']. $url);
        }
    }
}

class AgentAuth extends Auth{
    /**
     * Authentication for pages inside the admin folder
     */
    static function Route($url)
    {
        if (isset($_SESSION['agent_id'])) {             
            header("Location: ".$_ENV['URL']. $url);
        }else {
        //Don't Redirect
        }
    }

    /**
     * Authentication for pages inside the admin folder
     * */
    static function  User($url)
    {
        if (isset($_SESSION['agent_id'])) {
            //Don't Redirect
        }else {
            header("Location: ".$_ENV['URL']. $url);
        }
    }
}
?>