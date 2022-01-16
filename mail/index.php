<?php

# Start server session
session_start();

require 'include/config.php';
require 'include/mail.php';

// First, is the user logged in?
// if not, redirect them to do so
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) {
	header("Location: /oauth/index.php?landing=mail");
}

// User is logged in
// Do they have a mailbox setup in postfix?

// connect to postfix db
$pfdb = pg_connect("$db_host $db_port $db_name $db_credentials");
if(!$pfdb) {
	echo "<p>Error : Unable to open database</p>";
} else {
	echo "<p>Opened database successfully</p>";
	#error_log("mail/index.php: DB Opened");
}

// Query for user
// hardset domain because usernames come from mastodon and are missing '@domain'
$get_user_sql = "SELECT username FROM mailbox WHERE username='".pg_escape_string($_SESSION['username'])."@".$default_domain."'";
error_log("mail/index.php: Running Query");
$get_user_ret = pg_query($pfdb, $get_user_sql);
if($get_user_ret){
	$user = pg_fetch_assoc($get_user_ret);
	#error_log("User: ".$user['username']);
	#error_log("Session User: ".$_SESSION['username']);
	if(trim($user['username']) == trim($_SESSION['username']."@".$default_domain)){
		// User has a mailbox, forward to the webmail client
		#error_log("User has a mailbox");
		header("Location: https://mail.technomystics.com");
	}
	else{
		// User Doesn't have a mailbox or the query failed
		echo "<p>Couldn't find a mailbox for this user</p>";
		error_log("User Doesn't have a Mailbox Setup");
		
		// We need to create the mailbox in postfix
		$result = create_new_mailbox($_SESSION['username'],$default_domain,$default_quota,$pfdb);
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
	// User Doesn't have a mailbox or the query failed hard. Something else must be going on.
	error_log("mail/index.php: DB Fail: ".pg_last_error($pfdb));
	header("Location: /");
}

?>
