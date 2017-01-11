<?php
session_start();
date_default_timezone_set("America/New_York");
//Keeping track of whether or not the quiz has been taken yet by a user
if(isset($_COOKIE["quizTaken"])) {
	$takenArray = explode("#",$_COOKIE["quizTaken"]);
} else {
	$takenArray = array();
}
if(!in_array($_SESSION["username"], $takenArray)) $takenArray[] = $_SESSION["username"];
setcookie("quizTaken", implode("#",$takenArray), strtotime('today 23:59'), '/');

//Determine which quiz to use if not already determined
if(isset($_COOKIE["quizIndex"])) {
	$quizIndex = $_COOKIE["quizIndex"];
} else {
	$numQuizzes = count(file("quizzes.txt"));
	$numQuizzes = $numQuizzes-1;
	$quizIndex = mt_rand(0, $numQuizzes);
	setcookie("quizIndex", $quizIndex, strtotime('today 23:59'), '/');
}

//Set session variables if first time, otherwise continue
if(!isset($_SESSION["problem"])) {
	$_SESSION["problem"]=1;
	$_SESSION["numCorrect"]=0;
	$_SESSION["numWrong"]=0;
}

//Check if POST is valid, if so then increment everything.
if(isset($_POST["questions"]) && isset($_SESSION["problem"])) {
	if(strcmp($_SESSION["correctIndex"], $_POST["questions"]) == 0) {
		$correctOrNot = "Correct!";
		$_SESSION["numCorrect"] = (int)rtrim($_SESSION["numCorrect"]) + 1;
	} 
	else {
		$correctOrNot = "Incorrect!";
		$_SESSION["numWrong"] = (int)rtrim($_SESSION["numWrong"]) + 1;
	}
	$_SESSION["problem"] = (int)rtrim($_SESSION["problem"]) + 1;
}

//Read the appropriate quiz information
$quizptr = file("quizzes.txt");
$quizRead = explode("#", $quizptr[$quizIndex]);
$_SESSION["quizName"] = $quizRead[0];
$_SESSION["numQuest"] = $quizRead[1];

//Check for question limit - if so, move to show answer to last question + button to results page
if((int)$_SESSION["problem"] > (int)$_SESSION["numQuest"]) {
	$_SESSION["finalAnswer"] = $correctOrNot;
	$_SESSION["correctAnswer"] = $_SESSION["correctIndex"];
	header("Location: quizDone.php");
}

//Read the question from the quiz.txt file
$fileptr = fopen(trim($_SESSION["quizName"]), "r");
if(flock($fileptr, LOCK_SH)) {
	$i = 0;
	while($i < $_SESSION["problem"]) {
		$currQuestion = fgets($fileptr);
		$questRead = explode("#", $currQuestion);
		$i++;
	}
	$question = $questRead[0];
	$answers = explode(":", $questRead[1]);
	if(isset($_SESSION["correctIndex"])) $oldCorrectAnswer = $_SESSION["correctIndex"];
	$_SESSION["correctIndex"] = $answers[$questRead[2]-1];
}
flock($fileptr, LOCK_UN);
fclose($fileptr);
?>


<!DOCTYPE html>
<html>
<head><title>Quiz of the Day</title></head>
<body>
	<h1><?php echo $_SESSION["quizName"]; ?></h1></br>
	<?php 
	if(isset($correctOrNot)) {
		echo $correctOrNot . "</br>";
		if(strcmp($correctOrNot, "Incorrect!") == 0) {
			echo "The correct answer was: $oldCorrectAnswer";
		}
	}
	?>

	<p><?php echo $questRead[0]; ?></p>
	<form action="quiz.php" method="POST">
		<?php
		foreach($answers as $val):
		?>
		<input type="radio" name="questions" value="<?php echo $val;?>"><?php echo $val;?></input></br>
		<?php
		endforeach;
		?>
		<input type="submit" value="process">
	</form>
</body>
