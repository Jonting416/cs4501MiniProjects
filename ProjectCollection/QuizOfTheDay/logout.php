<?php
session_start();
//TAKE CARE OF DESETTING THE COOKIE
setcookie("saveLogin", "", time()-3600, '/');
$_SESSION = array();
session_destroy();
header("Location: login.php");
?>