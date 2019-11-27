<?php
function doStuff($type, $input_utterance, $json, $token){
    $input_utterance = rawurlencode($input_utterance);
    $witVersion = "20191024";

    //$witURL = $witRoot . "v=" . $witVersion . "&q=" . $input_utterance;

    $witURL = "https://api.wit.ai/". $type. "?v=". $witVersion;
    if($input_utterance != null){
        $witURL .= "&q=" . $input_utterance;
    }
    echo $witURL. "<br><br><br>";
    
    $ch = curl_init();
    $header = array();
    $header[] = "Authorization: Bearer ". $token;

    curl_setopt($ch, CURLOPT_URL, $witURL);
    //curl_setopt($ch, CURLOPT_POST, 1);  //sets method to POST (1 = TRUE)
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header); //sets the header value above - required for wit.ai authentication
    if(isset($json)){
        curl_setopt($ch, CURLOPT_POST, 1); // Do a regular HTTP POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json); // Insert JSON body
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //inhibits the immediate display of the returned data

    $server_output = curl_exec($ch); //call the URL and store the data in $server_output

    curl_close($ch);
    echo $server_output. "<br><br>";
    
    return $server_output;
}

function putStuff($type, $input_utterance, $json, $token){
    $input_utterance = rawurlencode($input_utterance);
    $witVersion = "20191024";

    //$witURL = $witRoot . "v=" . $witVersion . "&q=" . $input_utterance;

    $witURL = "https://api.wit.ai/". $type. "?v=". $witVersion;
    if($input_utterance != null){
        $witURL .= "&q=" . $input_utterance;
    }
    echo $witURL. "<br><br><br>";
    
    $ch = curl_init();
    $header = array();
    $header[] = "Authorization: Bearer ". $token;

    curl_setopt($ch, CURLOPT_URL, $witURL);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    //curl_setopt($ch, CURLOPT_POST, 1);  //sets method to POST (1 = TRUE)
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header); //sets the header value above - required for wit.ai authentication
    if(isset($json)){
        curl_setopt($ch, CURLOPT_POST, 1); // Do a regular HTTP POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json); // Insert JSON body
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //inhibits the immediate display of the returned data

    $server_output = curl_exec($ch); //call the URL and store the data in $server_output

    curl_close($ch);
    echo $server_output. "<br><br>";
    
    return $server_output;
}

function deleteStuff($type, $token){
    $witVersion = "20191024";

    //$witURL = $witRoot . "v=" . $witVersion . "&q=" . $input_utterance;

    $witURL = "https://api.wit.ai/". $type. "?v=". $witVersion;
    echo $witURL. "<br><br><br>";
    
    $ch = curl_init();
    $header = array();
    $header[] = "Authorization: Bearer ". $token;

    curl_setopt($ch, CURLOPT_URL, $witURL);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    //curl_setopt($ch, CURLOPT_POST, 1);  //sets method to POST (1 = TRUE)
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header); //sets the header value above - required for wit.ai authentication
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //inhibits the immediate display of the returned data

    $server_output = curl_exec($ch); //call the URL and store the data in $server_output

    curl_close($ch);
    echo $server_output. "<br><br>";
    
    return $server_output;
}
?>