<?php
/**
  * Response the user's request
  * Author: Zhao Zhiheng; Feng Zhibin
  * Last modified: 2014.11.9
  */

require_once "dataformat.php";
  
class RequestResponse{
    //Author: Zhao Zhiheng
    //Generate a response xml string
    //params: ResponseData $data
    //return: string
    //Test: No
    public function response($data){
        $toUserName = $data->toUserName;
        $fromUserName = $data->fromUserName;
        $createTime = time();
        $msgType = $data->msgType;
        $result = "<xml>
                        <ToUserName><![CDATA[$toUserName]]></ToUserName>
						<FromUserName><![CDATA[$fromUserName]]></FromUserName>
						<CreateTime>$createTime</CreateTime>
						<MsgType><![CDATA[$msgType]]></MsgType>
						%s
					</xml>";
        $xml = $this->getTypeXML($data);
        $result = sprintf($result, $xml);
        return $result;
    }
    
    //Author: Feng Zhibin
    //Generate the specific part of response string
    //params: ResponseData $data
    //return： string
    //Test: No
    private function getTypeXML($data){
        if ($data->msgType == "text"){
            $content = $data->content;
            $result = "<Content><![CDATA[$content]]></Content>";
            return $result;
        }
    }
}

?>