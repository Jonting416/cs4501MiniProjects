<?php
$wordArray = file('words.txt');
foreach($wordArray as $word) {
	echo $word . "</br>";
}
?>