<?php
require(dirname(dirname(__DIR__)) . '/auth-library/resources.php');

$url = strval($url);

$total_price = 0;
$total_item = 0;

$output = '';

$inSession = (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) || (isset($_SESSION['user_name']) && !empty($_SESSION['user_name']));

if (!empty($_SESSION["shopping_cart"])) {
    $output .= "<div class='spinner-wrapper'>
    <div class='spinner-container'>
        <img src='" . $url . "assets/images/halfcarry-logo.jpeg' alt='Halfcarry Logo'>
        <div class='spinner'></div>
    </div>
    </div><div class='cart-action-section'>
    <span>Cart Item (<span id='cart-number'>" . count($_SESSION['shopping_cart']) . "</span>)</span>
    <button class='btn' disabled>Update Cart</button>
    </div>

    <div class='labels'>
    <span>item</span>
    <span>quantity</span>
    <span>unit price</span>
    <span>sub total</span>
    </div><div class='cart-items'>";

    foreach ($_SESSION["shopping_cart"] as $keys => $values) {
        $total_price += $values['product_quantity'] * $values['product_price'];

        $output .= "
  <div class='cart-item'>
  <div data-label='Item' class='product-info'>
      <img src='" . $values['product_image'] . "' alt='" . $values['product_name'] . "'>
      <div class='details'>
          <p><a href='" . $url ."product/?pid=" . $values['product_id'] . "'>" . $values['product_name'] . "</a></p>
          <div class='action-btn-container'>
              <button data-product-id='" . $values['product_id'] . "'><i class='fa fa-trash-o'></i></button>
          </div>
      </div>
  </div>
  <div data-label='Quantity'>
      <input type='number' min='1' max='50' value='" . $values['product_quantity'] . "' class='amount' data-product-id='" . $values['product_id'] . "'>
  </div>
  <div data-label='Unit-price'>
      ₦ ". number_format($values['product_price'], 2) . "
  </div>
  <div data-label='Sub-total'>
      ₦ " . number_format($values['product_quantity'] * $values['product_price'], 2) . "
  </div>
</div>
  ";

        $total_item++;
    }
    $output .= "</div>";
    $output .= '
            <div class="total-container">
            Total: <span> ₦' . number_format($total_price, 2) . '</span> <br> <br>
            Delivery fee not included.
        </div>

        <div class="cart-action-btn-container">
            <div>
                <a href="'. $url . 'all-products/" class="btn">
                    <i class="fa fa-arrow-left"></i>
                    Return to shop
                </a>
            </div>
            <div>
                <a href="' . $url . 'checkout/" class="btn">Proceed to checkout</a>
                <button class="btn">Start Saving</button>
            </div>
        </div>
    ';
} else {
    $output .= '
   <div class="empty-cart-container">
        <p>No Items in Cart</p>
        <a href="' . $url . 'all-products/">Back to store</a>
    </div>
    ';
}

$data = array(
    'cart_details'  => $output,
    'total_item'  => $total_item
);

echo json_encode($data);
