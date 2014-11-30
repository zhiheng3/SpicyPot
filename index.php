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

        //return true;
	}

    public function processMsg()
    {
		//get post data, May be due to the different environments
	    $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        //$postStr = file_get_contents("php://input");
/*
		$postStr = "<xml>
<ToUserName><![CDATA[1]]></ToUserName>
<FromUserName><![CDATA[test0563]]></FromUserName>
<CreateTime>1417286261</CreateTime>           
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[抢票 压力测试]]></Content>
</xml>";
*/
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
		        $response = $responseObj->response($responseData);
		        echo $response;
		        $logfile = fopen("./log/response", "a");
		        fwrite($logfile, $response);
		        fclose($logfile);
        }else {
        	echo "";
        	exit;
        }
    }
}
?>
