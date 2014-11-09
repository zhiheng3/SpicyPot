<?php
/**
  * Parse the user's messages
  * Author: Zhao Zhiheng; Feng Zhibin
  * Last modified: 2014.11.9
  */

require_once "dataformat.php";
  
class RequestParse{
    //Author: Zhao Zhiheng; Feng Zhibin
    //Parse a response xml string
    //params: string $xml_string
    //return: RequestData
    //Test: No
    public function parse($xml_string){
        $postObj = simplexml_load_string($xml_string, 'SimpleXMLElement', LIBXML_NOCDATA);
        $result = new RequestData();
        $result->toUserName = $postObj->ToUserName;
        $result->fromUserName = $postObj->FromUserName;
        $result->createTime = $postObj->CreateTime;
        $result->msgType = $postObj->MsgType;
        $result->msgId = $postObj->MsgId;
        
        //Parse for specific type
        if ($result->msgType == "text"){
            $result->content = trim($postObj->Content);
            return $result;
        }
    }
}
?>