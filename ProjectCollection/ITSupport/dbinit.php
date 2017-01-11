<?php
	$db = new mysqli('localhost', 'root', '', 'assignment2');
	date_default_timezone_set('America/New_York');
	if ($db->connect_error):
		die ("Could not connect to db: " . $db->connect_error);
	endif;
	$db->query("drop table Login");
	$db->query("drop table Tickets");
	$db->query("drop table Assign");
	$passphrase = md5("password");
	$result = $db->query("create table Login (username varchar(30) primary key not null,password char(32) not null, LName char(30) not null, FName char(30) not null, email varchar(50))") or die ("Invalid: " . $db->error);
	$result = $db->query("create table Tickets (ticket_id int primary key auto_increment, LName char(30) not null, FName char(30) not null, email varchar(50), subject varchar(100), description text, timeReceived char(30) not null)") or die ("Invalid: " . $db->error);
	$result = $db->query("create table Assign (ticket_id int primary key auto_increment, adminName varchar(30), open bool)") or die ("Invalid: " . $db->error);
	$result = $db->query("ALTER TABLE Tickets AUTO_INCREMENT=0");
	$result = $db->query("ALTER TABLE Assign AUTO_INCREMENT=0");
	$result = $db->query("INSERT INTO login (username, password, LName, FName, email) VALUES
		('jonting', '$passphrase', 'Ting', 'Jon', 'jting416@gmail.com'),
		('admin', '$passphrase', 'User', 'Admin', 'otterrules@gmail.com')");
	$ticketArray = file('inittickets.txt');
	$now = date("F j Y g:i a");
	foreach($ticketArray as $ticket) {
		$split = explode("#", $ticket);
		$db->query("INSERT INTO Tickets (LName, FName, email, subject, description, timeReceived) VALUES
			(\"$split[0]\", \"$split[1]\", \"$split[2]\", \"$split[3]\", \"$split[4]\", \"$now\")");
		$db->query("INSERT INTO Assign (adminName, open) VALUES ('', '0')");
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>ITSupport DB Init</title>
	</head>
	<body>
		<p>Database Initialized!</p>
		<?php
		foreach($ticketArray as $ticket):
			$split = explode("#", $ticket);
			echo "<p>'$split[0]', '$split[1]', '$split[2]', '$split[3]', '$split[4]', '$now'</p>";
		endforeach;
		?>
    	<a href="index.html">Continue</a>
	</body>
</html>