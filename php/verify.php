<?php
/**
  * Verify the user's id and password by auth.igeek.asia
  * Author: Zhao Zhiheng
  * Last modified: 2014.11.12
  */

if ($_POST["type"] == "time"){
    //Get time
	$url = 'http://auth.igeek.asia/v1/time';
	$time = file_get_contents($url);
	/*
echo "0";
    $ch_time = curl_init();
exit;
    curl_setopt($ch_time, CURLOPT_URL, 'http://auth.igeek.asia/v1/time');
    curl_setopt($ch_time, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch_time, CURLOPT_HEADER, 0);
    curl_setopt($ch_time, CURLOPT_TIMEOUT, 1);
    $time = curl_exec($ch_time);  
    $errno = curl_errno($ch_time);
    if ($errno != 0){
        $time = 0;
    }
    curl_close($ch_time);*/
    echo $time;
}
else if ($_POST["type"] == "verify"){
    $url = "http://auth.igeek.asia/v1";
    $post_data = "secret=" . $_POST["secret"];
/*
    $ch_verify = curl_init();
    curl_setopt($ch_verify, CURLOPT_URL, $url);
    curl_setopt($ch_verify, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch_verify, CURLOPT_HEADER, 0);
    curl_setopt($ch_verify, CURLOPT_POST, true);
    curl_setopt($ch_verify, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch_verify, CURLOPT_TIMEOUT, 5);
    
    $result = curl_exec($ch_verify);
    curl_close($result);*/
	$context = array(
		'http' => array(
			'method' => 'POST',
			'header' => 'Content-type: application/x-www-form-urlencoded'.
						'\n'.'Content-length:' . strlen($post_data) + 1,
			'content' => $post_data)
	);
	$stream_context = stream_context_create($context);
	$result = file_get_contents($url, false, $stream_context);
    echo $result;
}
?>
