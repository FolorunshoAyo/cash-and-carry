<?php

$page_info = explode("/", $_SERVER['SCRIPT_NAME']);
$file_name = end($page_info);

?>

<div class="mobile-backdrop"></div>
<aside class="mobile-menu">
    <div class="cross-icon-wrapper">
        <div class="cross-icon-container">
            <i class="fa fa-times"></i>
        </div>
    </div>
    <div class="nav-link-container">
        <ul class="nav-links">
            <li class="nav-link-item <?= ($file_name === "index.php")? 'active' : ''?>">
                <a href="./" class="nav-link"> Dashboard </a>
            </li>
            <li class="nav-link-item <?= ($file_name === "savings.php") || ($file_name === "active_savings.php")? 'active' : ''?>">
                <a href="./savings" class="nav-link"> Savings </a>
            </li>
            <li class="nav-link-item <?= ($file_name === "order_details.php") || ($file_name === "orders.php")? 'active' : ''?>">
                <a href="./orders" class="nav-link">Orders</a>
            </li>
            <li class="nav-link-item <?= ($file_name === "edit_address.php") || ($file_name === "add_address.php") || ($file_name === "addresses.php")? 'active' : ''?>">
                <a href="./addresses" class="nav-link"> Addresses </a>
            </li>
            <li class="nav-link-item <?= ($file_name === "profile.php")? 'active' : ''?>">
                <a href="./profile" class="nav-link"> My profile </a>
            </li>
            <li class="nav-link-item">
                <a href="../logout" class="nav-link logout"> Logout </a>
            </li>
        </ul>
    </div>
</aside>