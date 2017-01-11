<?php
session_start();
?>
<!DOCTYPE html>
</html>
<head><title>Quiz Of The Day Login</title></head>
<body>
	<?php
	if(isset($_SESSION["failed"]) && $_SESSION["failed"]):
	?>
	<div style="color:red">Login failed!</div>
	<?php endif; ?>
	<form action="loginCheck.php" method="POST">
		<input type="text" name="username" placeholder="Username"> </br>
		<input type="password" name="password" placeholder="Password"> </br>
		<input type="checkbox" name="cookieSet" value="set"> Stay logged in? </br>
		<input type="submit" value="Login">
	</form>
</body>