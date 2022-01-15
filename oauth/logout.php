<?php
session_start();

if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
	error_log("logout.php: Logging Out User: ".$_SESSION['username']);
	session_destroy();
}

header("Location: /");
?>
