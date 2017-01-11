<?php
	$db = new mysqli('localhost', 'root', '', 'hangman');
	date_default_timezone_set('America/New_York');
	if ($db->connect_error):
		die ("Could not connect to db: " . $db->connect_error);
	endif;
	$db->query("drop table Words");
	$result = $db->query("create table Words (word varchar(50))") or die ("Invalid: " . $db->error);
	$wordArray = file('words.txt');
	foreach($wordArray as $word) {
		$db->query("INSERT INTO Words (word) VALUES
			(\"$word\")");
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>ITSupport DB Init</title>
	</head>
	<body>
		<p>Database Initialized!</p>
		Inserted words: </br>
		<?php
		$wordArray = file('words.txt');
		foreach($wordArray as $word) {
			echo $word . "</br>";
		}
		?>
    	<a href="index.html">Continue</a>
	</body>
</html>