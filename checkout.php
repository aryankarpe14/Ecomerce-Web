<?php
session_start();

$error = '';
$show_form = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $amount = floatval($_POST['amount'] ?? 0);

    if (empty($name) || empty($email) || $amount <= 0) {
        $error = 'Please fill all fields correctly.';
    } else {
        $cart_total = 0;
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $details) {
                $cart_total += $details['price'] * $details['quantity'];
            }

            if ($amount != $cart_total) {
                $error = 'Payment amount must match cart total of ₹' . number_format($cart_total, 0) . '.';
            } else {
                // ✅ SET SESSION (important fix)
                $_SESSION['order_success'] = [
                    'name' => $name,
                    'email' => $email,
                    'amount' => $amount,
                    'items_count' => count($_SESSION['cart']),
                    'total' => $cart_total
                ];

                // ✅ REDIRECT AFTER SETTING SESSION
                header('Location: process.php');
                exit;
            }
        } else {
            $error = 'Your cart is empty. Please add items first.';
        }
    }
}

// Calculate cart for display
$cart_items = [];
$cart_total = 0;
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $product => $details) {
        $subtotal = $details['price'] * $details['quantity'];
        $cart_items[] = [
            'product' => $product,
            'price' => $details['price'],
            'quantity' => $details['quantity'],
            'subtotal' => $subtotal
        ];
        $cart_total += $subtotal;
    }
}
$show_form = !empty($cart_items);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Secure Payment</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h2>🛒 Checkout</h2>
        <p>Review your order details and complete payment</p>
        <div class="auth-buttons">
            <a href="cart.php" class="auth-btn login-btn">← Back to Cart</a>
            <a href="index.html" class="auth-btn register-btn">Continue Shopping</a>
        </div>
    </header>

    <div class="cart-page" style="max-width: 1400px; margin: 0 auto; padding: 40px 20px; display: grid; grid-template-columns: 1fr 380px; gap: 40px;">
        
        <!-- Order Items -->
        <div class="cart-main">
            <div class="cart-header">
                <h3>Order Items (<?php echo count($cart_items); ?>)</h3>
            </div>
            
            <?php if (empty($cart_items)): ?>
                <figure class="product">
                    <div class="product-image">🛒</div>
                    <figcaption style="text-align: center; padding: 40px;">
                        <h3>Your cart is empty</h3>
                        <p>Add some products to checkout</p>
                        <a href="index.html" class="add-to-cart-btn">Start Shopping →</a>
                    </figcaption>
                </figure>
            <?php else: ?>
                <div class="cart-items">
                    <?php foreach ($cart_items as $item): 
                        $words = explode(' ', $item['product']);
                        $icon = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                    ?>
                    <figure class="product product-card">
                        <div class="product-image"><?php echo htmlspecialchars($icon); ?></div>
                        <figcaption>
                            <div class="product-name"><?php echo htmlspecialchars($item['product']); ?></div>
                            <div class="product-price">₹<?php echo number_format($item['price'], 0); ?> × <?php echo $item['quantity']; ?></div>
                            <div class="product-price-small">Subtotal ₹<?php echo number_format($item['subtotal'], 0); ?></div>
                        </figcaption>
                    </figure>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Payment Sidebar -->
        <div class="cart-sidebar">
            <div class="order-summary">
                <h4>Order Summary</h4>
                <div class="summary-row">
                    <span>Items (<?php echo count($cart_items); ?>):</span>
                    <span>₹<?php echo number_format($cart_total, 0); ?></span>
                </div>
                <div class="summary-row summary-total">
                    <span><strong>Total Amount</strong></span>
                    <span class="total-amount">₹<?php echo number_format($cart_total, 0); ?></span>
                </div>
                
                <!-- ✅ FIXED ERROR DISPLAY -->
                <?php if (!empty($error)): ?>
                    <div class="error" style="margin: 20px 0; padding: 15px;">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <?php if ($show_form): ?>
                    <!-- ✅ FIXED FORM ACTION (MAIN FIX) -->
                    <form method="POST" action="">
                        <div class="summary-row promo-row">
                            <input type="text" name="name" placeholder="Full Name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required style="flex: 1;">
                        </div>
                        <div class="summary-row promo-row">
                            <input type="text" name="email" placeholder="Email Address" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required style="flex: 1;">
                        </div>
                        <div class="summary-row">
                            <span>Amount:</span>
                            <strong>₹<?php echo number_format($cart_total, 0); ?></strong>
                            <input type="hidden" name="amount" value="<?php echo $cart_total; ?>">
                        </div>
                        <button type="submit" class="checkout-btn-large">Complete Secure Payment</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2026 DebugDuo. All Rights Reserved.</p>
    </footer>
    <script src="script.js"></script>
</body>
</html>