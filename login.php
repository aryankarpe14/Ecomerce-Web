<?php
session_start();
include "db.php";
if(isset($_POST['login'])){
$username = $_POST['username'];
$password = $_POST['password'];
$captcha = $_POST['captcha'];
if($captcha != $_SESSION['captcha']){
echo "Invalid CAPTCHA";
}
else{
$sql = "SELECT * FROM users WHERE name='$username'";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($result);
if(password_verify($password,$row['password'])){
$_SESSION['username'] = $username;
header("Location: index.html");
}
else{
echo "Invalid Password";
}
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form method="post">
        Username:<input type="text" name="username" required><br><br>
        Password:<input type="password" name="password" required><br><br>
        CAPTCHA:<input type="text" name="captcha" required><br><br>
        Captcha Code:<?php include "captcha.php"; ?><br><br>
        <input type="submit" name="login" value="Login">
    </form>
</body>
</html>
