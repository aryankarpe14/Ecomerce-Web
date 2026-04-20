<?php
session_start();
include "db.php";
$message = "";
$messageClass = "";
if(isset($_POST['register']))
{
$username = $_POST['username'];
$password = $_POST['password'];
$hash = password_hash($password, PASSWORD_BCRYPT);
$sql = "INSERT INTO users(name,password) VALUES('$username','$hash')";
 if (mysqli_query($conn, $sql)) {
        $message = "Record inserted successfully!";
        $messageClass = "success";
    } else {
        $message = "Error: " . mysqli_error($conn);
        $messageClass = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
   <form method="post">
        Username:<input type="text" name="username" required><br><br>
        Password:<input type="text" name="password" required><br><br>
        <input type="submit" name="register" value="Register">
    </form>
    <?php if($message): ?>
        <div class="<?php echo $messageClass; ?>"><?php echo $message; ?></div>
    <?php endif; ?>
</body>
</html>