<?php

require 'config.php';

$url = $POLYSCAN_MAIN_ENDPOINT."?module=stats&action=maticprice&apikey=".$POLYSCAN_API_KEY;
//echo $url;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
# Receive JWT Response
$responseJSON  = curl_exec($ch);
curl_close($ch);

header("Content-Type: application/json");
print $responseJSON;

?>