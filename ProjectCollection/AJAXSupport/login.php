<!DOCTYPE html>
</html>
<head><title>AJAXSupport Admin Login</title></head>
<body>
	<h1>AJAXSupport Site Admin Login</h1>
	<?php
	if(isset($_SESSION["failed"]) && $_SESSION["failed"]):
	?>
	<div style="color:red">Login failed!</div>
	<?php endif; ?>
	<form action="loginCheck.php" method="POST">
		<input type="text" name="username" placeholder="Username"> </br>
		<input type="password" name="password" placeholder="Password"> </br>
		<input type="submit" name="login" value="Login">
		<input type="submit" name="newuser" value="New User"> </br>
		<input type="text" name="firstName" placeholder="New User: First name"> </br>
		<input type="text" name="lastName" placeholder="New User: Last name"> </br>
		<input type="text" name="email" placeholder="New User: Email"> </br>
	</form>
	<a href="forgotpass.php">Forgot Password</a>
</body>