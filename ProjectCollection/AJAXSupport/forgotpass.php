<?php
session_start();
?>
<!DOCTYPE html>
</html>
<head><title>ITSupport Admin Login</title></head>
<body>
	<h1>Forgot Password</h1>
	<form action="passForgotCheck.php" method="POST">
		<input type="text" name="username" placeholder="Username"> </br>
		<input type="text" name="email" placeholder="Email"> </br>
		<input type="submit" value="Login">
	</form>
</body>