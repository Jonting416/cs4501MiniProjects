<?php
session_start();
$db = new mysqli('localhost', 'root', '', 'assignment2');
if ($db->connect_error):
	die("Could not connect to db: " . $db->connect_error);
endif;
if(isset($_POST["username"])):
	//login check logic goes here
	$username = $_POST["username"];
	$plainpass = $_POST["password"];
	$password = md5($plainpass);
	$loginSuccess = False;
	$query = "SELECT * FROM login WHERE username = \"$username\"";
	$result = $db->query($query);
	if($result != False) {
		$row = $result->fetch_assoc();
		if(strcmp($row["password"], $password) == 0) {
			$_SESSION["failed"] = False;
			$_SESSION["username"] = $row["username"];
			$_SESSION["email"] = $row["email"];
			$_SESSION["FName"] = $row["FName"];
			$_SESSION["LName"] = $row["LName"];
			header("Location: main.php");
		} else {
			//Wrong Password
			$_SESSION["failed"] = True;
			header("Location: login.php");
		}
	} else {
		$_SESSION["failed"] = True;
		header("Location: login.php");
	}
elseif(!isset($_SESSION["failed"])):
	//redirect to login-page, first time
	$_SESSION["failed"] = False;
	header("Location: login.php");
else:
	$_SESSION["failed"] = True;
	header("Location: login.php");
endif;
?>