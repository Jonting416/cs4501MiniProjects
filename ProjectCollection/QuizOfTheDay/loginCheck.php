<?php
session_start();
date_default_timezone_set("America/New_York");
$_SESSION["failed"] = False;
if(!isset($_COOKIE["saveLogin"])) {
	if(!isset($_POST["username"])) {
		header("Location: login.php");
		exit();
	}
	$username = rtrim($_POST["username"]);
	$password = rtrim($_POST["password"]);
	$users = file("users.txt");
	foreach($users as $val){
		$userInfo = explode("#", $val);
		if(strcmp($username, rtrim($userInfo[0])) == 0) {
			if(strcmp($password, rtrim($userInfo[1])) == 0) {
				$_SESSION["username"] = $username;
				$_SESSION["failed"] = False;
				header("Location: quizHome.php");
				if(isset($_POST["cookieSet"])) {
					setcookie("saveLogin", $username, strtotime('today 23:59'), '/');
				}
				break;
			} else {
				$_SESSION["failed"] = True;
				header("Location: login.php");
			}
		} else {
			$_SESSION["failed"] = True;
			header("Location: login.php");
		}
	}
}
else {
	$_SESSION["username"] = $_COOKIE["saveLogin"];
	header("Location: quizHome.php");
}
?>