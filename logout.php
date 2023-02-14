<?php
session_start();
session_destroy();

$location =  $_GET['rd'] === "home"? "./" : "./login";

header("Location: $location");
?>