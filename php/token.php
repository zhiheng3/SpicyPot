<?php
/**
  * Get access token from WeChat
  * Author: Feng Zhibin
  * Last modified: 2014.12.03
  */
class AccessToken{
	public function getAccessToken($tokenPath = "../log/access_token", $logPath = "../log/token_log"){
	    $xml = simplexml_load_file("../config/wx_config.xml");
		$appid = $xml->wxapi->appid;
		$secret = $xml->wxapi->secret;
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";

        //Get the expire time of the latest token
		$storeFile = file($tokenPath);
		if (count($storeFile) >= 2){
			$expireTime = intval(trim($storeFile[1]));
			if(time() < $expireTime) return trim($storeFile[0]); //Return that token if it is still avaliable
		}

        //If no token before or the latest token has expired
        //Get a new token (a json from WeChat, decode it as $result, an array)
		$json = file_get_contents($url);
		$result = json_decode($json, true);
		if($result['access_token']){
			$access_token = $result['access_token'];
			$expires_in = $result['expires_in'];
			$tokenFile = fopen($tokenPath, "w");

            //Set expire time as half of the time returned from WeChat
            //Since we have 2000 tokens a day, we can aquire tokens more frequently
			fwrite($tokenFile, $access_token . "\n" . (time() + intval($expires_in) / 2) . "\n");
			fclose($tokenFile);
			$logFile = fopen($logPath, "a");
			fwrite($logFile, $json);
			fclose($logFile);
			return $result['access_token'];
		}

        //Fail to get a new token, save the log
		else{
			$logFile = fopen($logPath, "a");
			fwrite($logFile, $json);
			fclose($logFile);
			return "";
		}
		//return $result;
	}
}
?>
