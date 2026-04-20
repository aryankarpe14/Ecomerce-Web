<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
session_start();
$order = $_SESSION['order_success'] ?? null;
unset($_SESSION['cart']); // Clear cart
unset($_SESSION['order_success']);
?>
<header>
    <h2>✅ Order Confirmed!</h2>
    <p>Thank you for your purchase. Order details:</p>
    <div class="auth-buttons">
        <a href="index.html" class="auth-btn login-btn">Shop More</a>
    </div>
</header>

<div class="success-message">
    <?php if ($order): ?>
        <h3>Order Summary</h3>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($order['name']); ?></p>
        <p><strong>Total Items:</strong> <?php echo $order['items_count']; ?></p>
        <p><strong>Amount Paid:</strong> $<?php echo number_format($order['amount'], 2); ?> (Cart Total: ₹<?php echo number_format($order['total'], 0); ?>)</p>
        <p>Order ID: #ECL-<?php echo date('Ymd-His'); ?></p>
    <?php else: ?>
        <h3>Something went wrong. No order data.</h3>
    <?php endif; ?>
    <a href="index.html" class="add-to-cart-btn">Continue Shopping</a>
</div>

<footer>
    <p>&copy; 2026 DebugDuo. All Rights Reserved.</p>
</footer>
<script src="script.js"></script>
</body>
</html>
