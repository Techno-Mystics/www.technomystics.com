<?php
#	sign-in/sign-up example
#
#
#
# Start server session
session_start();

function generateNonce($length){
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

# Generate secret for individual session (Server Side Security)
$secret = generateNonce(64);
$hashed_secret = hash('sha512',$secret);
# Store secret in session
$_SESSION['secret']=$secret;

# Generate nonce for OAuth call (Provider Side Security)
$nonce = generateNonce(64);

// SETUP LOGIN TO MASTODON
require 'include/oauth_config.php';

# Set OAuth Parameters
$response_type="code";
$scope=urlencode("read");
$tm_state=urlencode("token=".$hashed_secret."&auth_provider=mastodon");

// Complete Google OAuth URL
# This is the URL we send the user to for signing-in/signing-up
$mastodon_auth_url = $oauth_auth_endpoint."?response_type=".$response_type."&client_id=".$client_id."&scope=".$scope."&redirect_uri=".$redirect_url."&state=".$tm_state."&nonce=".$nonce;

// Below is the HTML the user will interact with.
?>
<a id="google-login-button" class="btn btn-block btn-lg btn-social btn-google" href="
	<?php 
		echo $mastodon_auth_url;
		header("Location: ".$mastodon_auth_url);

	?>
	">
		Mastodon
	</a>
	
	
	
</main>

</body>
</html>
