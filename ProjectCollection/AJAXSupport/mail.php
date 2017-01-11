<?php
session_start();
print_r($_SESSION);
function __autoload($class) {
    require_once $class . '.php';
}
if(!isset($_SESSION["username"])) {
    header("Location: login.php");
}
$ticketInfo = unserialize($_SESSION["tempTicket"]);
?>

<!DOCTYPE html>
<html>
<head>
    <title>ITSupport Mail Message Prompt</title>
</head>
<body>
    <h3>Email Form:</h3>
    <form action = "sendmail.php"
          method = "POST" id = "mailing">

    <b>The email is going to <?php echo $ticketInfo->fname . " " . $ticketInfo->lname; ?></b>
    <input type = "hidden" id = "receiver" name = "receiver" size = "30" maxlength = "30" value = <?php echo urlencode($ticketInfo->email); ?>>
    <input type = "hidden" id = "sender" name = "sender" size = "30" maxlength = "30" value = "">
    <input type = "hidden" id = "subject" name = "subject" size = "60" maxlength = "60" value = "ITSupport Ticket Follow-up...">
    <br /><br />
    <b>Please type your message below:</b><br />
    <br />
    <textarea id="msg" name="msg" rows="5" cols="60"></textarea>
    <br /><br />
    <input type = "submit" value = "Submit">
    </form>
</body>
</html>