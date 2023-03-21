<?php
require(dirname(__DIR__) . '/auth-library/resources.php');

$url = strval($url);

$total_price = 0;
$total_item = 0;

$output = '';

$inSession = (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) || (isset($_SESSION['user_name']) && !empty($_SESSION['user_name']));

$output .= "<div class='spinner-wrapper'>
<div class='spinner-container'>
    <img src='" . $url . "assets/images/halfcarry-logo.jpeg' alt='Halfcarry Logo'>
    <div class='spinner'></div>
</div>
</div><div class='cart-menu-items'>";

if (!empty($_SESSION["shopping_cart"])) {
    foreach ($_SESSION["shopping_cart"] as $keys => $values) {
        $total_price += $values['product_quantity'] * $values['product_price'];

        $output .= "
  <div class='cart-menu-item'>
  <div class='cart-menu-item-image-container'>
      <img src='". $values['product_image'] . "'/>
  </div>
  <div class='cart-product-details'>
      <a href='" . $url . "product/?pid=" . $values['product_id'] . "' class='cart-product-name'>" . $values['product_name'] . "</a>
      <div class='cart-item-meta'>
          <span class='quantity'>" . $values['product_quantity'] . "</span> &times; <spana class='price'>₦ " . number_format($values['product_price'],  2) . "</spana>
      </div>
  </div>
  <div class='close-btn-container'>
      <button data-product-id='" . $values['product_id'] . "'>
          <i class='fa fa-times'></i>
      </button>
  </div>
</div>
  ";

  $total_item++;
    }
    $output .= "</div>";
    $output .= '
 <div class="sub-total-container">
 Subtotal: <span class="subtotal-amount">₦ ' . number_format($total_price, 2) . '</span>
</div>
<div class="cart-menu-action-btns">
    <a href="' . $url . 'cart/" class="btn">View Cart</a>
    <a ' . ($inSession? 'href="' . $url . 'checkout/" class="btn"' : 'href="#" class="btn disabled"') . ' class="btn">Checkout</a>
</div>
 ';
} else {
    $output .= '
    <p style="margin-top: 20px; font-size: 1.5rem;"> No products in cart. </p>
    ';
}

$data = array(
    'cart_details'  => $output,
    'total_item'  => $total_item
);

echo json_encode($data);
