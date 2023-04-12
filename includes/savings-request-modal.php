<?php
$url = strval($url);
?>
<div class="savings-request-modal-wrapper">
    <div class="savings-request-modal">
        <div class="modal-header">
            <div class="savings-id-container">
                <i class="fa fa-handshake-o"></i> #2345678990
            </div>
            <div class="close-container">
                <i class="fa fa-times"></i>
            </div>
        </div>
        <div class="controls-container">
            <button data-direction="prev" disabled><i class="fa fa-arrow-left"></i></button>
            <button data-direction="next"><i class="fa fa-arrow-right"></i></button>
        </div>
        <div class="products-container">
            <div class="savings-product active">
                <div class="savings-product-image-container">
                    <img src="<?= $url ?>assets/images/web-cam-1.jpg" alt="Web cam #1">
                </div>
                <div class="savings-product-details">
                    <span class="savings-product-name">Web cam 2.0</span>
                    <span class="savings-product-qty">Qty: 3</span>
                </div>
            </div>
            <div class="savings-product">
                <div class="savings-product-image-container">
                    <img src="<?= $url ?>assets/images/web-cam-1.jpg" alt="Web cam #1">
                </div>
                <div class="savings-product-details">
                    <span class="savings-product-name">Web cam 2.0</span>
                    <span class="savings-product-qty">Qty: 5</span>
                </div>
            </div>
        </div>
        <ul class="savings-info">
            <li class="savings-info-block">
                <span class="savings-label">
                    Savings type:
                </span>
                <span class="savings-value">
                    Normal Savings
                </span>
            </li>
            <li class="savings-info-block">
                <span class="savings-label">
                    Duration:
                </span>
                <span class="savings-value">
                    3 Months
                </span>
            </li>
            <li class="savings-info-block">
                <span class="savings-label">
                    Type of payment:
                </span>
                <span class="savings-value">
                    Daily
                </span>
            </li>
            <li class="savings-info-block">
                <span class="savings-label">
                    Amount to save:
                </span>
                <span class="savings-value">
                    ₦30,000.00
                </span>
            </li>
            <li class="savings-info-block">
                <span class="savings-label">
                    Agent:
                </span>
                <span class="savings-value">
                    Shodiya Folorunsho
                </span>
            </li>
            <li class="savings-info-block">
                <span class="savings-label">
                    Agent Mobilel No:
                </span>
                <span class="savings-value">
                    07087857141
                </span>
            </li>
            <li class="savings-info-block">
                <span class="savings-label">
                    Agent Email:
                </span>
                <span class="savings-value">
                    folushoayomide11@gmail.com
                </span>
            </li>
            <li class="savings-info-block">
                <span class="savings-label">
                    Status:
                </span>
                <span class="savings-value">
                    <span class="dot pending"> </span> pending
                </span>
            </li>
        </ul>
    </div>
</div>