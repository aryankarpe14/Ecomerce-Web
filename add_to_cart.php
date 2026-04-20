<?php
session_start();
$product = $_POST['product'];
$price = $_POST['price'];
if(isset($_SESSION['cart'][$product]))
{
    $_SESSION['cart'][$product]['quantity']++;
}
else
{
    $_SESSION['cart'][$product] = array(
        "price"=>$price,
        "quantity"=>1
    );
}
header("Location: cart.php");
?>