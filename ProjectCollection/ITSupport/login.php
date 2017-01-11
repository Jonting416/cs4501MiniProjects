<?php
session_start();
?>
<!DOCTYPE html>
</html>
<head><title>ITSupport Admin Login</title></head>
<body>
	<h1>ITSupport Site Admin Login</h1>
	<?php
	if(isset($_SESSION["failed"]) && $_SESSION["failed"]):
	?>
	<div style="color:red">Login failed!</div>
	<?php endif; ?>
	<form action="loginCheck.php" method="POST">
		<input type="text" name="username" placeholder="Username"> </br>
		<input type="password" name="password" placeholder="Password"> </br>
		<input type="submit" value="Login">
	</form>
	<a href="forgotpass.php">Forgot Password</a>
</body>