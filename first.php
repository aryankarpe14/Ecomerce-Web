<!DOCTYPE html>
<html>
<head>
    <title>Enquiry Form</title>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<header>
		<h2>Enquiry Form</h2>
		<p>Submit your questions or feedback about our products</p>
	<div class="auth-buttons">
		<a href="index.html" class="auth-btn login-btn">Home</a>
	</div>
	</header>

<form method="post">
    Name:<input type="text" name="userText" placeholder="Enter the Name" required><br><br>
		<input type="submit" value="Submit" name="submit">
</form>

<?php
if(isset($_POST['submit'])) {
    $text = $_POST['userText'];
    $result = "Thank you " . $text . "! Your enquiry has been received.";
    echo "<h3>$result</h3>";

}
?>

	<footer>
		<p>&copy; 2026 DebugDuo. All Rights Reserved.</p>
	</footer>
</body>
</html>
