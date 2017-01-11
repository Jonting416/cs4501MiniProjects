<?php
session_start();
?>
<h1>Change Password</h1>
<form action="passForgotCheck.php" method="POST" id="pass_form">
	<input type="text" name="passwordNew" id="passwordNew" placeholder="New Password"> </br>
	<input type="submit" value="Change Password">
</form>