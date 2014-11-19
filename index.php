<?php
/**
  * Wechat Index
  * Author: Zhao Zhiheng
  * Last modified: 2014.11.9
  */

require_once "./php/parse.php";
require_once "./php/process.php";
require_once "./php/response.php";

//define your token
define("TOKEN", "SpicyPot");
$wechatObj = new WechatCallbackAPI();
$wechatObj->processMsg();

class WechatCallbackAPI
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }
    
    private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}

    public function processMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		/*$postStr = "<xml><ToUserName><![CDATA[toUserName]]></ToUserName><FromUserName><![CDATA[fromUserName]]></FromUserName><CreateTime>createTime</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[抢票 123]]></Content></xml>";*/

      	//extract post data
      	$logfile = fopen("./log/request_log", "a");
      	fwrite($logfile, $postStr);
      	fclose($logfile);
		if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
                libxml_disable_entity_loader(true);
                $parseObj = new RequestParse();
                $requestData = $parseObj->parse($postStr);
                $processObj  = new RequestProcess();
                $responseData = $processObj->process($requestData);
                $responseObj = new RequestResponse();
                //echo $responseObj->response($responseData);
<<<<<<< HEAD
		$teststr = $responseObj->response($responseData);
		echo $teststr;
		$logfile = fopen("log.txt", "w");
		fwrite($logfile, $postStr);
		fwrite($logfile, $teststr);
		fclose($logfile);
=======
		        $response = $responseObj->response($responseData);
		        echo $response;
		        $logfile = fopen("./log/response", "a");
		        fwrite($logfile, $response);
		        fclose($logfile);
>>>>>>> ec0ed20a64dfa5b8d32296fa22d0f710dc08d0c9

        }else {
        	echo "";
        	exit;
        }
    }
}
?>
