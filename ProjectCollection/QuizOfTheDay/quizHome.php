<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head><title>Quiz Home!</title></head>
<body>
	<h1>Welcome to the Quiz of the Day Website, <?php echo $_SESSION["username"]; ?>!</h1>
	<a href="quizEntry.php"><button value="">Click me to take the Quiz!</button></a></br>
	<a href="logout.php">Not you? Click here to change users.</a>
</body>