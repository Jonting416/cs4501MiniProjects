<?php
session_start();
$db = new mysqli('localhost', 'root', '', 'assignment3');
if ($db->connect_error):
	die("Could not connect to db: " . $db->connect_error);
endif;
if(isset($_POST["username"])):
	//login check logic goes here
	$username = $_POST["username"];
	$plainpass = $_POST["password"];
	$password = md5($plainpass);
	$loginSuccess = False;
	if(isset($_POST["newuser"])) {
		$FirstName = $_POST["firstName"];
		$LastName = $_POST["lastName"];
		$emailAdd = $_POST["email"];
		$result = $db->query("INSERT INTO login (username, password, LName, FName, email, admin) VALUES
		('$username', '$password', '$LastName', '$FirstName', '$emailAdd', 0)");
	}
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
			$adminStatus = $row["admin"];
			if($adminStatus == 1) {
				header("Location: adminView.html");
			} else {
				header("Location: support.html");
			}
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