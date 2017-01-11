<?php
session_start();
$db = new mysqli('localhost', 'root', '', 'assignment3');
date_default_timezone_set('America/New_York');
//Create email notification to user and admins + add ticket to DB
$now = date("F j Y g:i a");
//TODO: Change split 0,1,2 to _SESSION instead of _POST, remove fields from form
$split[0] = $_SESSION["LName"];
$split[1] = $_SESSION["FName"];
$split[2] = $_SESSION["email"];
$split[3] = $_POST["subject"];
$split[4] = $_POST["description"];
$result = $db->query("INSERT INTO Tickets (LName, FName, email, subject, description, timeReceived) VALUES
			('$split[0]', '$split[1]', '$split[2]', '$split[3]', '$split[4]', '$now')");
$result = $db->query("INSERT INTO Assign (adminName, open) VALUES ('', '0')");

if($result == FALSE) {
	echo "<h1>Ticket Didn't Submit!</h1>";
} else {
	echo "<h1>Ticket Submitted!</h1>";
}

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
$receiver = strip_tags($_SESSION["email"]);
$subj = "Ticket submitted to ITSupport Team";
$msg = "Please wait for us to contact you.  Thank you for your patience. \n Your ticket was
	\n Subject: $split[3]
	\n Description: $split[4]";

$mail->addAddress($receiver);
$mail->SetFrom($sender);
$mail->Subject = "$subj";
$mail->Body = "$msg";
if(!$mail->send()) {
	echo 'Message could not be sent.';
	echo 'Mailer Error: ' . $mail->ErrorInfo;
} 
else {  }
$mail->ClearAllRecipients();
$query = "SELECT email FROM login";
$result = $db->query($query);
while($row = $result->fetch_assoc()) {
	$mail->addAddress($row["email"]);
}
$mail->Subject = "New Support Ticket";
$mail->Body = "Login to help the customer.";
if(!$mail->send()) {
	echo 'Message could not be sent.';
	echo 'Mailer Error: ' . $mail->ErrorInfo;
} 
else {  }
?>