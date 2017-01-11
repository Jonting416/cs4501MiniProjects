<?php
session_start();
if(isset($_COOKIE["quizTaken"])) {
	$takenUsers = $_COOKIE["quizTaken"];
	$userArray = explode("#", $takenUsers);
	$username = $_SESSION["username"];
	if(in_array($username,$userArray)) {
		header("Location: quizDone.php");
	} else {
		header("Location: quiz.php");
	}
} else {
	header("Location: quiz.php");
}
?>