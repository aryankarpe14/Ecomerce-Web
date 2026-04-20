<?php
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update']) && isset($_SESSION['cart'][$_POST['update']])) {
    $update_product = $_POST['update'];
    $new_quantity = max(1, (int)$_POST['quantity']);
    $_SESSION['cart'][$update_product]['quantity'] = $new_quantity;
}

$total = 0.0;
$items = array();
$cart_count = 0;
if(isset($_SESSION['cart'])) {
    $cart_count = count($_SESSION['cart']);
    foreach($_SESSION['cart'] as $product => $details) {
        $price = (float)$details['price'];
        $qty = (int)$details['quantity'];
        $subtotal = $price * $qty;
        $total += $subtotal;
        $items[] = array('product' => $product, 'price' => $price, 'qty' => $qty, 'subtotal' => $subtotal);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
  <h2>Shopping Cart</h2>
  <p>Review your selected items and manage quantities before checkout.</p>
  <div class="auth-buttons">
    <a href="login.php" class="auth-btn login-btn">Login</a>
    <a href="register.php" class="auth-btn register-btn">Register</a>
  </div>
</header>

<div class="products-container">
  <?php if (empty($items)): ?>
    <figure class="product">
  <div class="product-image">🛒</div>
      <figcaption class="product-name" style="font-size: 1.5rem;">Your Cart is Empty</figcaption>
      <div style="color: #6c757d; margin-top: 10px;">No items in cart yet</div>
      <a href="index.html" class="add-to-cart-btn" style="margin-top: 20px; display: block;">Start Shopping →</a>
    </figure>
  <?php else: ?>
    <?php foreach($items as $item): 
      extract($item);
      // Use first word or product name snippet for image
      $words = explode(' ', $product);
      $imageText = $words[0][0];
      if (isset($words[1])) $imageText .= $words[1][0];
      $imageText = strtoupper($imageText);
    ?>
    <figure class="product product-card">
      <div class="product-image"><?php echo htmlspecialchars($imageText); ?></div>
      <figcaption>
        <h4 style="margin: 0 0 10px 0;"><?php echo htmlspecialchars($product); ?></h4>
        <div class="product-name"><?php echo htmlspecialchars($product); ?></div>
        <div class="product-price">₹<?php echo number_format($price, 0); ?> x <?php echo $qty; ?></div>
        <div style="font-weight: bold; color: #28a745;">Subtotal: ₹<?php echo number_format($subtotal, 0); ?></div>
        <div style="margin: 15px 0;">
          <form method="post" style="display: inline-block; margin-right: 10px;">
            <input type="hidden" name="update" value="<?php echo htmlspecialchars($product); ?>">
            <input type="hidden" name="quantity" value="<?php echo ($qty > 1 ? $qty - 1 : 1); ?>">
            <button type="submit" style="background: #ffc107; color: #000; border: none; padding: 8px 12px; border-radius: 5px; cursor: pointer; font-weight: bold; margin-right: 5px;">-</button>
          </form>
          <form method="post" style="display: inline-block; margin-right: 10px;">
            <input type="hidden" name="update" value="<?php echo htmlspecialchars($product); ?>">
            <input type="hidden" name="quantity" value="<?php echo $qty + 1; ?>">
            <button type="submit" style="background: #28a745; color: white; border: none; padding: 8px 12px; border-radius: 5px; cursor: pointer; font-weight: bold;">+</button>
          </form>
          <a href="remove.php?product=<?php echo urlencode($product); ?>" style="background: #dc3545; color: white; padding: 8px 12px; text-decoration: none; border-radius: 5px; font-weight: bold;" onclick="return confirm('Remove <?php echo addslashes($product); ?>?');">Remove</a>
        </div>
      </figcaption>
    </figure>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<div class="cart-total" style="text-align: center; margin: 20px auto; max-width: 350px; width: fit-content; display: block; margin-left: auto; margin-right: auto; padding: 8px 16px;">
  <h3 style="font-size: 1.8rem; margin: 0; line-height: 1.2;">Total: ₹<?php echo number_format($total, 0); ?></h3>
</div>

<div class="checkout-actions">
  <a href="index.html" class="add-to-cart-btn" style="background: linear-gradient(45deg, #6c757d, #495057);">Continue Shopping</a>
<a href="checkout.php" class="add-to-cart-btn">Checkout</a>

</div>

<footer>
	<p>&copy; 2026 DebugDuo. All Rights Reserved.</p>
</footer>
<script src="script.js"></script>
</body>
</html>
