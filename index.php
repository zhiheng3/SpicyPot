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
        $logfile = fopen("./log/t_log", "a");
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

        //The following line is for pressure test
        //$postStr = file_get_contents("php://input");

        //Debug xml request
		/*$postStr = "<xml>
    <ToUserName><![CDATA[gh_c91b78a69c83]]></ToUserName>
    <FromUserName><![CDATA[o9aMOszP5QhMgEWO8GJTOOolWIEM]]></FromUserName>
    <CreateTime>1417336884</CreateTime>
    <MsgType><![CDATA[event]]></MsgType>
    <Event><![CDATA[CLICK]]></Event>
    <EventKey><![CDATA[TAKE_1]]></EventKey>
    <Encrypt><![CDATA[DmVFNgPKsJGTeO5+PFiK+5bLhlqXLLisxSuE/IJiWeR9F9H5jHcVoXgEffSoXIx3JA6muuoMQX3PaxgJIZFckRrAhRW1dfm4H1YTQS8izxi78cMGaAhBF4+5+FLh3ts/aP9w+pAsqHcbcj1BCFBfXg19xkABXChHsE7hvEoLVz9eEVuQSRLr9lwsBp0Tp5jYPbWZ8jIQ50L0hYAuplfJXiepkKbgxPATJI5rzHAkmFzAuqQMvEaJ8CIZhuVy+vaq6cThonhgYLzF8Q4H7gF8wSrLDk28k5gH+UKky3FaHmHVTv8mLuvxPA6uKLKS+die0QzaqpT19Bc/mVOwikznCuW5W0UPd2Iyzn5ZvwfHrYq7wOteSZCdVhYoERKtmI6nWQT2DXNqb37es/nYKFXXBPZhvOkUGprJl7d1pr2Ngro=]]></Encrypt>
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
