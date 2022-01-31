<?php

require 'config.php';

if(isset($_GET['cmd'])){
    switch ($_GET['cmd']) {
        case 'maticprice':
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
            exit;
            break;
        
        case 'accountbalance':
            $url = $POLYSCAN_MAIN_ENDPOINT."?module=account&action=balance&address=".$TECHNOMYSTICS_MATIC_ADDRESS."&apikey=".$POLYSCAN_API_KEY;
            //echo $url;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            # Receive JWT Response
            $responseJSON  = curl_exec($ch);
            curl_close($ch);
            //$responseObj = json_decode($responseJSON);

            header("Content-Type: application/json");
            print $responseJSON;

            //echo "<p>MATIC: ".($responseObj->result / 1000000000000000000)."</p>";

            exit;
            break;
    }
}


?>