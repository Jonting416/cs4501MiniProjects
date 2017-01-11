<!DOCTYPE html>
<html>
<head><title>ITSupport Add a Ticket!</title></head>
<body>
	<h1>Ticket Submission Form</h1>
	<form action="insertTicket.php" method="POST">
		<p><label>First Name: </label><input type="text" name="FName" placeholder="First Name" required></p>
		<p><label>Last Name: </label><input type="text" name="LName" placeholder="Last Name" required> </p>
		<p><label>Email Address: </label><input type="email" name="email" placeholder="Email Address" required> </p>
		<p><label>Subject: </label><input type="text" name="subject" placeholder="Subject" required> </p>
		<p><label>Description: </label><textarea id="description" name="description" rows = "3" cols="80" placeholder="Description" required></textarea> </p>
		<input type="submit" value="Submit">
	</form>
</body>