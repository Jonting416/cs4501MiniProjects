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
if(isset($_POST["pick"])) {
	$num = $_POST["pick"];
} else {
	die("Ticket doesn't exist!");
}
if(isset($_POST["action"])) {
	$action = $_POST["action"];
	switch($action) {
		case "toggleOn":
			echo "toggleOn";
			$query = "UPDATE assign SET open=1 WHERE ticket_id = " . $num;
			break;
		case "toggleOff":
			echo "toggleOff";
			$query = "UPDATE assign SET open=0 WHERE ticket_id = " . $num;
			break;
		case "delete":
			echo "delete";
			$query = "DELETE tickets WHERE ticket_id = " . $num;
			$db->query($query);
			$query = "DELETE assign WHERE ticket_id = " . $num;
			header("Location: main.php");
			break;
		case "assign":
			echo "assign";
			$newName = $_SESSION["FName"];
			$query = "UPDATE assign SET adminName=\"$newName\" WHERE ticket_id = " . $num;
			break;
		case "remove":
			echo "remove";
			$query = "UPDATE assign SET adminName=\"\" WHERE ticket_id = " . $num;
			break;
	}
	$db->query($query);
}
?>

<?php
$query = "SELECT * FROM tickets NATURAL JOIN assign WHERE ticket_id = $num";
$result = $db->query($query);
if($result != null) {
	$row = $result->fetch_assoc();
	$displayTicket = new Ticket($row["FName"], $row["LName"], $row["email"], $row["subject"], $row["description"], $row["timeReceived"], $row["adminName"], $row["open"], $row["ticket_id"]);
	if(strcmp($displayTicket->open, "open") == 0) {
		$toggleVal = "toggleOn";
	} else {
		$toggleVal = "toggleOff";
	}
	$emptyAdmin = strcmp($displayTicket->admin, "");
	$youAdmin = strcmp($displayTicket->admin, $_SESSION["FName"]);
	if(isset($action) && strcmp($action, "toggleOn") == 0) {
		$email = $displayTicket->email;
		//MAILING PART
		require 'C:/xampp/vendor/autoload.php';
		$mail = new PHPMailer();
		$mail->SMTPOptions= array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
				)
			);

		$mail->isSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = "tls";
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587;
		$mail->Username = "cs4501.fall15@gmail.com";
		$mail->Password = "UVACSROCKS";

		//setting variables for user confirmation
		$sender = "UVa CS330 TAs";
		$receiver = $email;
		$subj = "Ticket Closed.";
		$msg = "One of your tickets has been closed, please check it!";

		$mail->addAddress($receiver);
		$mail->SetFrom($sender);
		$mail->Subject = "$subj";
		$mail->Body = "$msg";
		$mail->send();
	}
	$_SESSION["tempTicket"] = serialize($displayTicket);
} else {
	die("Ticket doesn't exist! 222");
}
?>
<h1 align="center">Detailed Ticket Info</h1>
<table align="center" border=1>
	<tr><td>Submitter Name</td><td><?php echo $displayTicket->fname . " " . $displayTicket->lname; ?></td></tr>
	<tr><td>Time Submitted</td><td><?php echo $displayTicket->timeReceived; ?></td></tr>
	<tr><td>Subject</td><td><?php echo $displayTicket->subject; ?></td></tr>
	<tr><td>Description</td><td><?php echo $displayTicket->description; ?></td></tr>
	<tr><td>Status</td><td><?php echo $displayTicket->open; ?></td></tr>
	<tr><td>Assigned To</td><td><?php echo $displayTicket->admin; ?></td></tr>
</table>
<form id="selectButtons" action="detailView.php" method="GET">
	<input type="hidden" name="pick" value=<?php echo "$num"; ?>>
</form>
<table align="center">
	<tr><td><button form="selectButtons" class="frmbtn" type="submit" name="action" value="<?php echo $toggleVal; ?>">Open/Close Ticket</button></td><td><button type="submit" form="selectButtons" class="frmbtn" name="action" value="delete">Delete Ticket</button></td></tr>
	<tr><td><button form="selectButtons" class="frmbtn" type="submit" name="action" value="assign" <?php if($emptyAdmin != 0) { echo "disabled"; } ?>>Assign Self to Ticket</button></td><td><button type="submit" form="selectButtons" class="frmbtn" name="action" value="remove" <?php if($youAdmin != 0) { echo "disabled"; } ?>>Remove Self from Ticket</button></td></tr>
	<tr><td><button class="frmbtn" onclick="sendMail()">Email Submitter</button></td><td><button class="frmbtn" onclick="viewTickets()">Find tickets from same submitter</button></td></tr>
	<tr><td><button class="frmbtn" onclick="viewSimilar()">Find all similar tickets</button></td><td><button class="frmbtn" onclick="getTable()">Go Back to Main Page</button></td></tr>
</table>