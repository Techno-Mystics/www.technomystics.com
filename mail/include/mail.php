<?php

/**
 * Generate a random password of $length characters.
 * @param int $length (optional, default: 12)
 * @return string
 *
 */
function generate_password($length = 12) {

    // define possible characters
    $possible = "012345678923456789abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ"; # skip 0 and 1 to avoid confusion with O and>

    // add random characters to $password until $length is reached
    $password = "";
    while (strlen($password) < $length) {
        $random = random_int(0, strlen($possible) -1);
        $char = substr($possible, $random, 1);

        // we don't want this character if it's already in the password
        if (!strstr($password, $char)) {
            $password .= $char;
        }
    }

    return $password;
}

function create_new_mailbox($username, $domain, $quota, $pfdb) {
	$status = array('error'=>true,'msg'=>'Failed');
	
	$full_email = $username."@".$domain;
	// Random password for every new mailbox, users forced to login via OAuth via Webmail anyways. 
	// SMTP OUT is disabled on public interfaces.
	$new_password = generate_password();
	$hashed_password = "{SHA512}".base64_encode(hash('sha512',$new_password,true));
	
	
	// create mailbox
	$new_mb_sql = "INSERT INTO mailbox (username,password,name,local_part,maildir,domain,quota,active,token_validity,password_expiry) VALUES ('".$full_email."','".$hashed_password."','".$username."','".$username."','".$domain."/".$username."/','".$domain."',".$quota.",'t',NOW(),NOW())";
	$new_mb_ret = pg_query($pfdb,$new_mb_sql);
	if($new_mb_ret){
		$status['msg'] = "Mailbox Created";
		error_log("create_new_mailbox: Mailbox Created");
	}
	else{
		error_log("create_new_mailbox: Failed to insert into DB: ".pg_last_error($pfdb));
		$status['msg'] = "Failed to insert into DB: ".pg_last_error($pfdb);
		return $status;
	}
	// create default alias
	$new_alias_sql = "INSERT INTO alias (address,goto,domain,active) VALUES ('".$full_email."','".$full_email."','".$domain."','t')";
	$new_alias_ret = pg_query($pfdb,$new_alias_sql);
	if($new_alias_ret){
		$status['msg'] = "Created Mailbox and Default Alias";
		error_log("create_new_mailbox: Default Alias Created");
	}
	else{
		error_log("create_new_mailbox: Failed to create default alias: ".pg_last_error($pfdb));
		$status['msg'] = "Failed to create default alias: ".pg_last_error($pfdb);
		return $status;
	}
	$status['error'] = false;
	return $status;
}

?>
