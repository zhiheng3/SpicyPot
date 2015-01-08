<?php
/**
  * Get the access token from Wechat server
  * Author: Zhao Zhiheng
  * Last modified: 2014.11.17
  */
//phpinfo();
 
function getToken()
{
    $appid = "wx31f3308295716fd1";
    $secret = "1eeac4dc44d5e2ae0141d3675dbeef7b";
    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";
    echo $url, "\n";
    $access_token = file_get_contents($url);
    print_r($access_token);
} 

getToken();

?>
