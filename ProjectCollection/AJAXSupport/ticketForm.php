<?php
session_start();
if(!isset($_SESSION["username"])) {
	header("Location: login.php");
}
?>
<h1>Ticket Submission Form</h1>
<form action="insertTicket.php" method="POST" id="ticket_form">
	<p><label>Subject: </label><input type="text" id="subject" name="subject" placeholder="Subject" required> </p>
	<p><label>Description: </label><textarea id="description" name="description" rows = "3" cols="80" placeholder="Description" required></textarea> </p>
	<input type="submit" value="Submit">
</form>