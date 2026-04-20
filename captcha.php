<?php
$captcha = rand(1000,9999);
$_SESSION['captcha'] = $captcha;
echo $captcha;
?>