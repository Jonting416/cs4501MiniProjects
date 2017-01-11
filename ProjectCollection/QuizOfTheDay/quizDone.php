<?php
session_start();
//This page changes the content based on whether or not finalAnswer is set in the session
//It will always show the average percentage, but it will show quiz results while the session is active.
$quizIndex = rtrim($_COOKIE["quizIndex"]);
?>
<!DOCTYPE html>
<html>
<head><title>Results Page</title></head>
<body>
	<h1>You <?php if(!isset($_SESSION["finalAnswer"])) echo "have already";?> finished the quiz!</h1>
	<?php
	if(isset($_SESSION["finalAnswer"])):
	?>
	<?php 
	echo $_SESSION["finalAnswer"] . "</br>";
	if(strcmp($_SESSION["finalAnswer"], "Incorrect!") == 0) {
		echo "The correct answer was: " . $_SESSION["correctAnswer"];
	}
	?>
		<p>Questions answered correctly: <?php echo $_SESSION["numCorrect"]; ?> </p>
		<p>Percent Correct: <?php echo (int)(($_SESSION["numCorrect"]/($_SESSION["numCorrect"]+$_SESSION["numWrong"]))*100); ?>%</p>
	<?php else: ?>
		<p>Try again tomorrow!</p>
	<?php endif; ?>

	<?php
	//Parsing statistic info here
	$quizzes = file("quizzes.txt");
	$quizInfo = explode("#", $quizzes[$quizIndex]);
	if(isset($_SESSION["numCorrect"])) {
		$quizInfo[2] += 1;
		$quizInfo[3] += $_SESSION["numCorrect"];
		$quizInfo[4] += $_SESSION["numWrong"];
		unset($_SESSION["problem"]);
		unset($_SESSION["numCorrect"]);
		unset($_SESSION["numWrong"]);
		unset($_SESSION["finalAnswer"]);
	}
	echo "The average score for " . $quizInfo[2] . " people on this quiz is " . ($quizInfo[3]/($quizInfo[3]+$quizInfo[4]))*100 . "%.</br>";
	$replaceQuiz = $quizInfo[0] . "#" . $quizInfo[1] . "#" . $quizInfo[2] . "#" . $quizInfo[3] . "#" . $quizInfo[4];
	$quizzes[$quizIndex] = $replaceQuiz;
	$trimmedArray = array_map('trim', $quizzes);
	file_put_contents("quizzes.txt", implode("\r\n", array_filter($trimmedArray)));
	?>
	<a href="quizHome.php">Click here to go to Home</a>
</body>