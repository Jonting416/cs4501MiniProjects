<?php
session_start();
$db = new mysqli('localhost', 'root', '', 'assignment2');
if ($db->connect_error):
	die("Could not connect to db: " . $db->connect_error);
endif;
$temp = strip_tags($_GET["unique"]);
$username = strip_tags($_GET["name"]);
$query = "SELECT * FROM login WHERE username = \"$username\"";
$result = $db->query($query);
if($result != False) {
	$row = $result->fetch_assoc();
	$pass = $row["password"];
}
if(strcmp($temp, $pass) != 0) {
	header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head></head>
<body>
	<form action="resetAction.php" method="POST">
		<input type="hidden" name="username" value="<?php echo $username; ?>">
		<input type="text" name="password" placeholder="New Password"> </br>
		<input type="submit" value="Reset">
	</form>
</body>
</html>