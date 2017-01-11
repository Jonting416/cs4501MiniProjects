<?php
$input = file_get_contents('php://input');
$ticketArray = json_decode($input);
echo "<table border=1 align=\"center\">";
echo "<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Subject</th><th>Time Received</th><th>Admin</th><th>Status</th><th>Select</th></tr>";
foreach($ticketArray as $ticket) {
	echo "<tr><td>" . $ticket->id . "</td><td>" . $ticket->fname . "</td><td>" . $ticket->lname . "</td><td>" . $ticket->email . "</td><td>" . $ticket->subject . "</td><td>" . $ticket->timeReceived . "</td><td>" . $ticket->admin . "</td><td>" . $ticket->open . "</td><td>" . "<input form=\"buttons\" type=\"radio\" name=\"pick\" value=\"$ticket->id\"></td></tr>";
}
echo "<tr><td>" . "<input form=\"sorting\" type=\"radio\" name=\"pick\" value=\"id\">" . "</td><td>" . "<input form=\"sorting\" type=\"radio\" name=\"pick\" value=\"fname\">" . "</td><td>" . "<input form=\"sorting\" type=\"radio\" name=\"pick\" value=\"lname\">" . "</td><td>" . "<input form=\"sorting\" type=\"radio\" name=\"pick\" value=\"email\">" . "</td><td>" . "<input form=\"sorting\" type=\"radio\" name=\"pick\" value=\"subject\">" . "</td><td>" . "<input form=\"sorting\" type=\"radio\" name=\"pick\" value=\"timeReceived\">" . "</td><td>" . "<input form=\"sorting\" type=\"radio\" name=\"pick\" value=\"admin\">" . "</td><td>" . "<input form=\"sorting\" type=\"radio\" name=\"pick\" value=\"open\">" . "</td><td>" . "</td></tr>";
echo "</table>";
?>
<form id="buttons" action="detailView.php" method="GET">
</form>
<form id="sorting" action="sortedView.php" method="POST">
	<input type="hidden" name="query" value="<?php echo $query; ?>">
</form>
<table align="center">
	<tr><td><button class="frmbtn" onclick="viewAll()">View All Tickets</button></td><td><input class="frmbtn" form="sorting" type="submit" value="Sort by select"></td><td><input class="frmbtn" form="buttons" type="submit" value="Detail View"></td></tr>
	<tr><td><button class="frmbtn" onclick="viewMine()">View My Tickets</button></td><td><a href="logout.php"><button class="frmbtn">Logout</button></a></td><td><button class="frmbtn" onclick="viewOpen()">View Unassigned Tickets</button></td></tr>
</table>