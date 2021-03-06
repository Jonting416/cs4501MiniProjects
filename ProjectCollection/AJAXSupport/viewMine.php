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
?>
<?php
$ticketArray = array();
$myName = $_SESSION["FName"];
$myLastName=$_SESSION["LName"];
$query = "SELECT * FROM tickets NATURAL JOIN assign WHERE LName = \"$myLastName\" AND FName = \"$myName\"";
$result = $db->query($query);
while($row = $result->fetch_assoc()) {
	$newTicket = new Ticket($row["FName"], $row["LName"], $row["email"], $row["subject"], $row["description"], $row["timeReceived"], $row["adminName"], $row["open"], $row["ticket_id"]);
	$ticketArray[] = $newTicket;
}
echo "<table border=1 align=\"center\">";
echo "<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Subject</th><th>Time Received</th><th>Admin</th><th>Status</th><th>Select</th></tr>";
foreach($ticketArray as $ticket) {
	echo "<tr><td>" . $ticket->id . "</td><td>" . $ticket->fname . "</td><td>" . $ticket->lname . "</td><td>" . $ticket->email . "</td><td>" . $ticket->subject . "</td><td>" . $ticket->timeReceived . "</td><td>" . $ticket->admin . "</td><td>" . $ticket->open . "</td><td>" . "<input form=\"buttons\" type=\"radio\" name=\"pick\" value=\"$ticket->id\"></td></tr>";
}
echo "<tr><td>" . "<input form=\"sorting\" type=\"radio\" name=\"pick\" value=\"ticket_id\">" . "</td><td>" . "<input form=\"sorting\" type=\"radio\" name=\"pick\" value=\"fname\">" . "</td><td>" . "<input form=\"sorting\" type=\"radio\" name=\"pick\" value=\"lname\">" . "</td><td>" . "<input form=\"sorting\" type=\"radio\" name=\"pick\" value=\"email\">" . "</td><td>" . "<input form=\"sorting\" type=\"radio\" name=\"pick\" value=\"subject\">" . "</td><td>" . "<input form=\"sorting\" type=\"radio\" name=\"pick\" value=\"DATE(timeReceived)\">" . "</td><td>" . "<input form=\"sorting\" type=\"radio\" name=\"pick\" value=\"adminName\">" . "</td><td>" . "<input form=\"sorting\" type=\"radio\" name=\"pick\" value=\"open\">" . "</td><td>" . "</td></tr>";
echo "</table>";
?>
<form id="buttons" action="detailView.php" method="GET">
</form>
<form id="sorting" action="sortedView.php" method="POST">
	<input type="hidden" name="query" value="<?php echo $query; ?>">
</form>
