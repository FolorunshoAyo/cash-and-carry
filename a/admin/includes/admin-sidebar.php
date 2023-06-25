<?php
$page_info = explode("/", $_SERVER['SCRIPT_NAME']);
$file_name = end($page_info);
?>

<div class="mobile-backdrop"></div>
<aside class="dash-menu">
    <div class="logo">
        <div class="menu-icon">
            <i class="fa fa-bars"></i>
            <i class="fa fa-times"></i>
        </div>
        <a href="./" class="logo">
            <i class="fa fa-home"></i>
            <span> Halfcarry Admin </span>
        </a>
    </div>
    <ul class="side-menu" id="side-menu">
        <li title="dashboard" class="nav-item <?= $file_name === "index.php"? 'active' : ''?>">
            <a href="./">
                <i class="fa fa-tachometer"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li title="statistics" class="nav-item">
            <a href="javascript:void(0)">
                <i class="fa fa-signal"></i>
                <span>Statistics</span>
            </a>
        </li>
        <li title="" class="nav-item <?= ($file_name === "orders.php") || ($file_name === "order-details.php")? 'active' : ''?>">
            <a href="./orders">
                <i class="fa fa-usd"></i>
                <span>Orders</span>
            </a>
        </li>
        <li title="orders" class="nav-item <?= ($file_name === "edit_agent.php") || ($file_name === "add_agent.php") || ($file_name === "agents.php")? 'active' : ''?>">
            <a href="./agents">
                <i class="fa fa-users"></i>
                <span>Agents</span>
            </a>
        </li>
        <li title="orders" class="nav-item <?= ($file_name === "all_savings.php") || ($file_name === "request_details.php") || ($file_name === "wallet.php")? 'active' : ''?>">
            <a href="./all_savings">
                <i class="fa fa-money"></i>
                <span>Savings</span>
            </a>
        </li>
        <li title="shipping" class="nav-item">
            <a href="javascript:void(0)">
                <i class="fa fa-recycle"></i>
                <span>Shipping</span>
            </a>
        </li>
        <li title="products" class="nav-item <?= ($file_name === "add_product.php") || ($file_name === "products.php")? 'active' : ''?>">
            <a href="./products">
                <i class="fa fa-shopping-bag"></i>
                <span>Products</span>
            </a>
        </li>
        <li title="messages" class="nav-item">
            <a href="javascript:void(0">
                <i class="fa fa-commenting-o"></i>
                <span>Messages</span>
            </a>
        </li>
    </ul>

    <ul title="settings" class="side-menu-bottom">
        <li class="nav-tem">
            <a href="javascript:void(0)">
                <i class="fa fa-gear"></i>
                <span>Settings</span>
            </a>
        </li>
        <li title="logout" class="nav-item logout">
            <a href="../logout">
                <i class="fa fa-sign-out"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>
</aside>