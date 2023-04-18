<header>
    <div class="top-header">
        <a href="<?= $url ?>" class="logo-container">
            <div class="logo-image-container">
                <img src="<?= $url ?>assets/images/halfcarry-logo.jpeg" alt="Header Logo">
            </div>
        </a>

        <nav class="navigation-menu">
            <ul class="nav-links">
                <li class="nav-link-item">
                    <a href="#">
                        <i class="fa fa-money"></i>
                        Purchases
                    </a>
                </li>
                <li class="nav-link-item">
                    <a href="#">
                        <i class="fa fa-rocket"></i>
                        Packages
                    </a>
                </li>
                <li class="nav-link-item">
                    <a href="#">
                        <i class="fa fa-info"></i>
                        Help
                    </a>
                </li>
                <li class="nav-link-item cart-link">
                    <a href="javascript:void(0)">
                        <span class="cart-badge">0</span>
                        <i class="fa fa-shopping-cart"></i>
                        Cart
                    </a>
                </li>
                <!-- <li class="nav-link-item">
                        <div class="dark-mode-container">
                            <span>Dark Mode</span>
                            <img src="assets/images/toggle-off.png" alt="toggle-off">
                        </div>
                    </li> -->
            </ul>
        </nav>
    </div>
    <div class="bottom-header">
        <div class="categories-btn-container">
            <a href="<?= $url ?>all-products?view-categories">Categories</a>
        </div>
        <div class="search-container">
            <form class="search-box" action="search/">
                <input type="text" name="q" placeholder="Search for an item">
                <button type="submit" class="search-icon-btn">
                    <i class="fa fa-search"></i>
                </button>
            </form>
        </div>
        <div class="other-links-container">
            <!-- <button class="installment-btn">Installments</button> -->
            <div class="menu-container">
                <a href="javascript:void(0)"><i class="fa fa-user-o"></i> <?php echo ($inSession ?  explode(" ", $user_name)[0] : "Account") ?></a>
                <?php
                if (!$inSession) {
                ?>
                    <ul class="menu">
                        <li><a href="<?= $url ?>login">Sign In</a></li>
                        <li><a href="<?= $url ?>register">Register</a></li>
                    </ul>
                <?php
                } else {
                ?>
                    <ul class="menu">
                        <li><a href="<?= $url ?>user/">Dashboard</a></li>
                        <li><a href="<?= $url ?>user/orders">Orders</a></li>
                        <li><?= $isActiveRequest? '<a onclick="displayActiveRequest()" href="javascript:void(0)"> <span class="circle"></span> Requests</a>' : '<a href="' . $url . 'user/savings?requests"> Requests</a>' ?> </li>
                        <li><a href="<?= $url ?>logout?rd=home">Log out</a></li>
                    </ul>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</header