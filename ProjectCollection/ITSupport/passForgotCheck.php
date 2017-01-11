<?php
session_start();
$db = new mysqli('localhost', 'root', '', 'assignment2');
if ($db->connect_error):
	die("Could not connect to db: " . $db->connect_error);
endif;
if(isset($_POST["username"])):
	//login check logic goes here
	$username = $_POST["username"];
	$email = $_POST["email"];
	$query = "SELECT * FROM login WHERE username = \"$username\"";
	$result = $db->query($query);
	if($result != False) {
		$row = $result->fetch_assoc();
		if(strcmp($row["email"], $email) == 0) {
			$updateID = uniqid();
			$query = "UPDATE login SET password = \"$updateID\" WHERE username = \"$username\"";
			$db->query($query);
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
			$subj = "Reset password";
			$link = "localhost/ITSupport/resetPassword.php?unique=" . $updateID . "&name=" . $username;
			$msg = "Click <a href=$link>here</a> to reset your password.";

			$mail->addAddress($receiver);
			$mail->SetFrom($sender);
			$mail->Subject = "$subj";
			$mail->Body = "$msg";
			$mail->send();
		} else {
			//Wrong Password
			$_SESSION["failed"] = True;
			header("Location: login.php");
		}
	} else {
		$_SESSION["failed"] = True;
		header("Location: login.php");
	}
else:
	$_SESSION["failed"] = True;
	header("Location: login.php");
endif;
?>

<!DOCTYPE html>
<html>
<body>
	Check your email. In case the email didn't send (for debug):
	<?php echo $link; ?>
</body>
</html>