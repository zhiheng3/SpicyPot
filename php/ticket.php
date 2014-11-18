<?php
/**
  * Deal with requests for tickets
  * Author: Feng Zhibin
  * Last modified: 2014.11.17
  */

require_once "dataformat.php";
require_once "dataAPI.php";

class ticketHandler{
    //Author: Feng Zhibin
    //Handle requests for tickets
    //params: RequestData $data
    //return: ResponseData $result
    public function ticketHandle($data){
        $content = trim($data->content);
        if(substr($content, 0, 6) == "抢票"){
            $result = $this->takeTicket($data);
        }
        else if(substr($content, 0, 6) == "退票"){
            $result = $this->refundTicket($data);
        }
        else if(substr($content, 0, 6) == "查票"){
            $result = $this->getTicket($data);        
        }
        else{
            $result->msgType = "text";
            $result->content = "请输入帮助查看应用说明";
        }
        return $result;
    }

    //Author: Feng Zhibin
    //Get ticket operation
    //params: RequestData $data
    //return: ResponseData $result
    public function takeTicket($data){
        $result = new ResponseData();
        $openId = $data->fromUserName;
        $eventId = substr($data->content, 7);
        $dataapi = new DataAPI();
        $ticketResult = $dataapi->takeTicket($openId, $eventId);
        if($ticketResult['state'] == true){
            $result->msgType = "news";
            $result->articleCount = 1;
			$result->articles = array();
			$result->articles[0] = new Article();
            $result->articles[0]->title = "抢票成功！";
            $result->articles[0]->description = "抢票成功！";
            $result->articles[0]->picUrl = "http://wx9.igeek.asia/img/31.png";
            $result->articles[0]->url = "http://wx9.igeek.asia/php/ActivityInfo.php";
        }
        else{
            $result->MsgType = "text";
            $result->content = "抢票失败：" . $ticketResult['message'];
        }
        return $result;
    }

    //Author: Feng Zhibin
    //Drop ticket operation
    //params: RequestData $data
    //return ResponseData $result
    public function refundTicket($data){
        $result = new ResponseData();
        $result->MsgType = "text";
        $openId = $data->fromUserName;
        $ticketId = substr($data->content, 7);
        $dataapi = new DataAPI();
        $ticketResult = $dataapi->refundTicket($openId, $ticketId);
        if($ticketResult['state'] == true){
            $result->content = "退票成功！";
        }
        else{
            $result->content = "退票失败：" . $ticketResult['message'];
        }
        return $result;
    }

    //Author: Feng Zhibin
    //Check ticket operation
    //params: RequestData $data
    //return ResponseData $result
    public function getTicket($data){
        $result = new ResponseData();
        $result->MsgType = "text";
        $openId = $data->fromUserName;
        $dataapi = new DataAPI();
        $ticketResult = $dataapi->getTicket($openId);
        $result->content = "";
        if($ticketResult['state'] == true){
            for($i = 0; $i < count($ticketResult['message']); $i++){
                $j = $i + 1;
                $result->content .= "$j: ";
                $result->content .= $ticketResult['message'][$i];
                $result->content .= "\n";
            }
        }
        else{
            $result->content = "查询失败：" . $ticketResult['message'];
        }
        return $result;
    }
}
?>
