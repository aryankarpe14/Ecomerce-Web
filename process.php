<?php
session_start();

// Debug (remove after testing)
// print_r($_SESSION); exit;

$order = $_SESSION['order_success'] ?? null;

if (!$order) {
    header('Location: cart.php');
    exit;
}

$paypalURL = "https://www.sandbox.paypal.com/cgi-bin/webscr";
$paypalID  = "sb-2zd3k49976182@business.example.com";

$amount = $order['amount'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Processing Payment</title>
</head>
<body>

<h3>Redirecting to PayPal...</h3>
<p>Amount: $<?php echo number_format($amount, 2); ?></p>
<p>Name: <?php echo htmlspecialchars($order['name']); ?></p>

<form action="<?php echo $paypalURL; ?>" method="post" id="paypalForm">

    <input type="hidden" name="business" value="<?php echo $paypalID; ?>">
    <input type="hidden" name="cmd" value="_xclick">

    <input type="hidden" name="item_name" value="Order Payment">
    <input type="hidden" name="amount" value="<?php echo $amount; ?>">
    <input type="hidden" name="currency_code" value="USD">

    <!-- IMPORTANT: change path if needed -->
    <input type="hidden" name="return" value="http://localhost/ECL/success.php">
    <input type="hidden" name="cancel_return" value="http://localhost/ECL/cancel.php">

</form>

<script>
document.getElementById("paypalForm").submit();
</script>

</body>
</html>