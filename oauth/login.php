<?php
// Start Session
session_start();

error_log($_SERVER['HTTP_REFERER']);

// SETUP LOGIN TO MASTODON
require 'include/oauth_config.php';


// If Session doesn't exist, redirect
# Check for proper session
if(!isset($_SESSION['secret']))
{
		header("location: /");
}
$secret=$_SESSION['secret'];
$hashed_secret=hash('sha512',$secret);

// Google returns information we can use to validate the user along with the state we passed earlier we check for validity on our side.
// We should be receiving a token and a auth_provider. Parse that out from $_GET['state'] or $_POST['state']
if(isset($_GET['state'])){
	if(preg_match('/^token=(.*)&auth_provider=(.*)&invite=(.*)$/',urldecode($_GET['state']),$matches)){
		$token = $matches[1];
		$auth_provider = $matches[2];
		$invite_code = $matches[3];
	}
	elseif(preg_match('/^token=(.*)&auth_provider=(.*)$/',urldecode($_GET['state']),$matches)){
		$token = $matches[1];
		$auth_provider = $matches[2];
		$invite_code = '-';
	}
}
// Different OAuth implementations use GET and some use POST
elseif(isset($_POST['state'])){
	if(preg_match('/^token=(.*)&auth_provider=(.*)&invite=(.*)$/',urldecode($_POST['state']),$matches)){
		$token = $matches[1];
		$auth_provider = $matches[2];
		$invite_code = $matches[3];
	}
	elseif(preg_match('/^token=(.*)&auth_provider=(.*)$/',urldecode($_POST['state']),$matches)){
		$token = $matches[1];
		$auth_provider = $matches[2];
		$invite_code = '-';
	}
}

# Check the state returned for valid data
if(!$token || !$auth_provider){
	error_log("Didn't receive token or auth_provider");
	header("Location: /");
}

// Get Google's OpenID Discovery Document
#$discover_doc = json_decode(file_get_contents($GOOGLE_DISCOVERY_DOCUMENT));

# Validate token provided in state
if($token == $hashed_secret){ // Valid Login, check Auth Provider
	
	// Check for valid auth_provider
	if($auth_provider == "mastodon"){
		echo "Auth Code: ".$_GET['code']."<br>";
	
		// GET AUTH TOKEN
		# Set Parameters
		$data = array('code' => $_GET['code'], 'client_id' => $client_id, 'client_secret' => $client_secret, 'grant_type' => 'authorization_code', 'redirect_uri' => $redirect_url);
		$data_json = json_encode($data);
		# Post to OAuth Endpoint to get User Information
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $oauth_token_endpoint);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		# Receive JWT Response
		$response  = json_decode(curl_exec($ch));
		curl_close($ch);
		
		# Parse the JWT
		//var_dump($response);
		$bearer_token = $response->access_token;
		
		// User exists and has authenticated
		// We now have an access token we can use to make API queries.
		echo "Access Token: ".$bearer_token."<br>";
		
		// Verify Credentials
		$verify_url = "https://social.technomystics.com/api/v1/accounts/verify_credentials";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $verify_url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',"Authorization: Bearer ".$bearer_token));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = json_decode(curl_exec($ch));
		
		echo "Verify Credentials Response<br>";
		var_dump($response);
		echo "<br>";
		
		if(isset($response->id) && isset($response->username)){
			$_SESSION['logged_in'] = true;
			$_SESSION['id'] = $response->id;
			$_SESSION['username'] = $response->username;
			$_SESSION['avatar'] = $response->avatar;
		}
		else{
			$_SESSION['logged_in'] = false;
		}
		
		error_log("LoggedIn: ".$_SESSION['logged_in']);
		header("Location: /");
	}
	else{
		error_log("Unknown Auth Provider");
		header("Location: /");
	}
	
}
else{
	error_log("Invalid session for login.php");
	error_log("token: ".$token);
	error_log("Sesh: ".$hashed_secret);
	header("Location: /");
}

?>
