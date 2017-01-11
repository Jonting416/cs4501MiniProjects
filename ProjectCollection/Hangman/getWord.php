<?php
$db = new mysqli('localhost', 'root', '', 'hangman');
if($db->connect_error):
	die("Could not connect to db " . $db->connect_error);
endif;

$query = "SELECT * FROM Words";
$result = $db->query($query);
$wordList = $result->fetch_all();
$data = array();
foreach($wordList as $word) {
	$data[] = trim($word[0]);
}
$encoded = json_encode($data);
echo $encoded;
?>