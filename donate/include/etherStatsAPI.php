<?php

require 'config.php';


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $ETHERSCAN_MAIN_ENDPOINT."?module=stats&action=ethprice&apikey=".$ETHERSCAN_API_KEY);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
# Receive JWT Response
$responseJSON  = curl_exec($ch);
curl_close($ch);

header("Content-Type: application/json");
print $responseJSON;

?>