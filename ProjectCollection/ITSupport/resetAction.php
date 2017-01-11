<?php
session_start();
$db = new mysqli('localhost', 'root', '', 'assignment2');
if ($db->connect_error):
	die("Could not connect to db: " . $db->connect_error);
endif;
$newPass = md5($_POST["password"]);
$username = $_POST["username"];
$query = "UPDATE login SET password = \"$newPass\" WHERE username = \"$username\"";
$result = $db->query($query);
header("Location: login.php");
?>