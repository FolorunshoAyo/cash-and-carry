<div class="dashboard-links-wrapper">
    <div class="dashboard-links">
        <ul class="dashboard-nav-links">
            <li class="title">My Profile</li>
            <li class="dashboard-nav-link  <?= ($file_name === "index.php")? 'active' : ''?>">
                <a href="./">Dashboard</a>
            </li>
            <li class="dashboard-nav-link <?= ($file_name === "savings.php") || ($file_name === "wallet.php") || ($file_name === "savings-request.php") || ($file_name === "active_savings.php")? 'active' : ''?>">
                <a href="./savings">Savings</a>
            </li>
            <li class="dashboard-nav-link <?= ($file_name === "order_details.php") || ($file_name === "orders.php")? 'active' : ''?>">
                <a href="./orders">Orders</a>
            </li>
            <li class="dashboard-nav-link <?= ($file_name === "edit_address.php") || ($file_name === "add_address.php") || ($file_name === "addresses.php")? 'active' : ''?>">
                <a href="./addresses">Address</a>
            </li>
            <li class="dashboard-nav-link <?= ($file_name === "profile.php")? 'active' : ''?>">
                <a href="./profile">My profile</a>
            </li>
            <li class="dashboard-nav-link logout">
                <a href="../">Logout</a>
            </li>
        </ul>
    </div>
</div>