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
        <li class="nav-item">
            <a href="./">
                <i class="fa fa-users"></i>
                <span>Customers</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="javascript:void(0)">
                <i class="fa fa-handshake-o"></i>
                <span>Requests</span>
                <i class="fas fa-chevron-right"></i>
            </a>
            <ul class="sub-menu">
                <li>
                    <a href="<?= $url ?>a/agent/requests/savings_requests">
                        <i class="fa fa-bullseye"></i>
                        <span>Full savings</span>
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
        <li class="nav-item">
            <a href="./all_wallets">
                <i class="fa fa-money"></i>
                <span>Active Wallets</span>
            </a>
        </li>
    </ul>

    <ul class="side-menu-bottom">
        <li class="nav-item logout">
            <a href="../logout">
                <i class="fa fa-sign-out"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>
</aside>