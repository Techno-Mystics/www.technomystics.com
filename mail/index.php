<?php

# Start server session
session_start();

require 'include/config.php';
require 'include/mail.php';

// First, is the user logged in?
// if not, redirect them to do so
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) {
	error_log("mail/index.php: User not logged in, redirecting");
	header("Location: /oauth/index.php?landing=mail");
	die;
}

// User is logged in
// Do they have a mailbox setup in postfix?

// connect to postfix db
$pfdb = pg_connect("$db_host $db_port $db_name $db_credentials");
if(!$pfdb) {
	error_log("mail/index.php: Failed to open DB");
	die;
}

// Query for user
// hardset domain because usernames come from mastodon and are missing '@domain'
$get_user_sql = "SELECT username FROM mailbox WHERE username='".pg_escape_string($_SESSION['username'])."@".$default_domain."'";
$get_user_ret = pg_query($pfdb, $get_user_sql);
// deal with results
if($get_user_ret){
	// get 1st row
	$user = pg_fetch_assoc($get_user_ret);
	
	if(isset($user['username']) && trim($user['username']) == trim($_SESSION['username']."@".$default_domain)){
		// User has a mailbox, forward to the webmail client
		header("Location: https://mail.technomystics.com");
	}
	else{
		// User Doesn't have a mailbox
		
		// We need to create the mailbox in postfix
		$result = create_new_mailbox($_SESSION['username'],$default_domain,$default_quota,$pfdb);
		// check for errors
		if($result['error'] == true){
			error_log("Failed to create new mailbox: ".$_SESSION['username']."@".$default_domain);
			echo "<p>Failed to create new mailbox for user ".$_SESSION['username']."@".$default_domain."</p>";
			echo "<pre>";
			echo $result['msg'];
			echo "</pre>";
		}
		else{
			// Mailbox Created Successfully, forward user
			error_log("Created New Mailbox: ".$_SESSION['username']."@".$default_domain);
			header("Location: https://mail.technomystics.com");
		}
	}
}
else{
	// Query failed hard. Something else must be going on.
	error_log("mail/index.php: DB Fail: ".pg_last_error($pfdb));
	header("Location: /");
}

?>
