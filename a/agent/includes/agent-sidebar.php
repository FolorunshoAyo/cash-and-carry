<?php
$page_info = explode("/", $_SERVER['SCRIPT_NAME']);
$file_name = end($page_info); 

$url = strval($url);
?>

<div class="mobile-backdrop"></div>
<aside class="dash-menu">
    <div class="logo">
        <div class="menu-icon">
            <i class="fa fa-bars"></i>
            <i class="fa fa-times"></i>
        </div>
        <a href="#" class="logo">
            <i class="fa fa-home"></i>
            <span> Halfcarry Agent </span>
        </a>
    </div>
    <ul class="side-menu" id="side-menu">
        <li class="nav-item <?= ($file_name === "index.php")? 'active' : ''?>">
            <a href="<?= $url ?>a/agent/">
                <i class="fa fa-users"></i>
                <span>Customers</span>
            </a>
        </li>
        <li title="users" class="nav-item <?= ($file_name === "edit_user.php") || ($file_name === "add_user.php") || ($file_name === "users.php")? 'active' : ''?>">
            <a href="./users">
                <i class="fa fa-users"></i>
                <span>Users</span>
            </a>
        </li>
        <li class="nav-item <?= ($file_name === "halfsavings_requests.php") || ($file_name === "savings_requests.php") || ($file_name === "user_wallets.php")? 'mm-active' : ''?>">
            <a href="javascript:void(0)">
                <i class="fa fa-handshake-o"></i>
                <span>Requests</span>
                <i class="fas fa-chevron-right"></i>
            </a>
            <ul class="sub-menu">
                <li>
                    <a href="<?= $url ?>a/agent/requests/savings_requests">
                        <i class="fa fa-bullseye"></i>
                        <span>Normal savings</span>
                    </a>
                </li>
                <li>
                    <a href="<?= $url ?>a/agent/requests/halfsavings_requests">
                        <i class="fa fa-dot-circle-o"></i>
                        <span>Half savings</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item <?= ($file_name === "shops.php") || ($file_name === "edit-shop.php") || ($file_name === "add-shop.php")? 'active' : ''?>">
            <a href="<?= $url ?>a/agent/stores">
                <i class="fa fa-home"></i>
                <span>Stores</span>
            </a>
        </li>
        <li class="nav-item <?= ($file_name === "products.php")? 'active' : ''?>">
            <a href="<?= $url ?>a/agent/products">
                <i class="fa fa-shopping-bag"></i>
                <span>Products</span>
            </a>
        </li>
        <li class="nav-item <?= ($file_name === "active_wallets.php")? 'active' : ''?>">
            <a href="<?= $url ?>a/agent/active_wallets">
                <i class="fa fa-money"></i>
                <span>Active Wallets</span>
            </a>
        </li>
    </ul>

    <ul class="side-menu-bottom">
        <li class="nav-item logout">
            <a href="<?= $url ?>a/logout">
                <i class="fa fa-sign-out"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>
</aside>