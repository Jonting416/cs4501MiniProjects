<?php
session_start();
function __autoload($class) {
	require_once $class . '.php';
}
if(!isset($_SESSION["username"])) {
	header("Location: login.php");
}
$db = new mysqli('localhost', 'root', '', 'assignment3');
if ($db->connect_error):
	die("Could not connect to db: " . $db->connect_error);
endif;

$ticketArray = array();
$query = "SELECT * FROM tickets NATURAL JOIN assign";
$result = $db->query($query);
while($row = $result->fetch_assoc()) {
	$newTicket = new Ticket($row["FName"], $row["LName"], $row["email"], $row["subject"], $row["description"], $row["timeReceived"], $row["adminName"], $row["open"], $row["ticket_id"]);
	$ticketArray[] = $newTicket;
}
echo json_encode($ticketArray);
?>