<?php
session_start();
$db = new mysqli('localhost', 'root', '', 'assignment3');
if ($db->connect_error):
	die("Could not connect to db: " . $db->connect_error);
endif;
$newPass = md5($_POST["passwordNew"]);
$username = $_SESSION["username"];
$query = "UPDATE login SET password = \"$newPass\" WHERE username = \"$username\"";
$result = $db->query($query);
?>
<p>Password Changed!</p>
<a href="login.php">Click here to proceed</a>