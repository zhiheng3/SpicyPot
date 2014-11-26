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

hBefYibifc3KlkWld0-wsfVSLH_gdW636bxVUFESrBc37o1IEIjqzlGv9tt_kuTd3vZA4C7kSiLXQ9t9MldUuwjLkAQjvw68mJkhQt3D2Hg

{
    "button":[
    {
        "name":"用户管理",
        "sub_button":[
        {
            "type":"click",
            "name":"绑定/解绑",
            "key":"USER_BIND"
        }
    },
      {
           "name":"菜单",
           "sub_button":[
           {	
               "type":"view",
               "name":"搜索",
               "url":"http://www.soso.com/"
            },
            {
               "type":"view",
               "name":"视频",
               "url":"http://v.qq.com/"
            },
            {
               "type":"click",
               "name":"赞一下我们",
               "key":"V1001_GOOD"
            }]
       }]
 }