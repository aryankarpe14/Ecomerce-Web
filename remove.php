<?php
session_start();

$product = $_GET['product'];

unset($_SESSION['cart'][$product]);

header("Location: cart.php");

?>