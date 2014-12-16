<?php
/**
  * Deal with requests for tickets
  * Author: Feng Zhibin
  * Last modified: 2014.12.16
  */

require_once "dataformat.php";
require_once "dataAPI.php";

class ticketHandler{
    //Author: Feng Zhibin
    //Handle requests for tickets
    //params: RequestData $data
    //return: ResponseData $result
/*
    public function ticketHandle($data){
        $content = trim($data->content);
        if(substr($content, 0, 6) == "退票"){
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
*/

    //Author: Feng Zhibin
    //Get ticket operation
    //params: RequestData $data
    //return: ResponseData $result
    public function takeTicket($data){
        $result = new ResponseData();
        $openId = $data->fromUserName;
        $eventId = intval(substr($data->eventKey, 5));
        $dataapi = new DataAPI();
        $ticketResult = $dataapi->takeTicket($openId, $eventId);
        //Return a 'text' message, consists of a page for ticket information
        $result->msgType = "text";
        if($ticketResult['state'] == "true"){
            $result->content = "抢票成功，" . 
                                "<a href=\"http://wx9.igeek.asia/Ticket.php?openid=$openId&id={$ticketResult['message']}\">点此查看电子票</a>";
        }
        else{
            //No ticket avaliable
			if($ticketResult['message'] == "票已抢光"){
				$result->content = "胜败乃兵家常事，大侠请下次再来。（票已抢光）";
			}
            //Error from database
            else{
				$result->content = "抢票失败：" . $ticketResult['message'];
			}
        }
        return $result;
    }

    //Author: Feng Zhibin
    //Drop ticket operation
    //params: RequestData $data
    //return ResponseData $result
    public function refundTicket($data){
        $result = new ResponseData();
        $result->msgType = "text";
        $openId = $data->fromUserName;
        $ticketId = substr($data->content, 6);
        $dataapi = new DataAPI();
        $ticketResult = $dataapi->refundTicket($openId, $ticketId);
        if($ticketResult['state'] == "true"){
            $result->content = "再见官人，奴家会想你的！（退票成功）";
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
        $openId = $data->fromUserName;
        $dataapi = new DataAPI();
        $ticketResult = $dataapi->getTicketList($openId);
        //Everything goes well on database
        if($ticketResult['state'] == "true"){
            $tickets = count($ticketResult['message']);
            //User has no ticket
            if($tickets == 0){
                $result->msgType = "text";
                $result->content = "您目前没有票哦~";
                return $result;
            }
            //User has ticket(s)
            //Return a 'news' message, consists of at most 10 ticket info pieces
            $result->msgType = "news";
			$tks = $tickets;
			if($tks > 10) $tks = 10; //Limited by WeChat, at most 10
            $result->articleCount = $tks;
	        $result->articles = array();
            for($i = 0; $i < $tks; $i++){
                $j = $i + 1;
			    $result->articles[$i] = new Article();
			    //Test
			    $activityId = $ticketResult['message'][$i]['activity_id'];
			    $activityResult = $dataapi->getActivityInfo($activityId);
			    if($activityResult['state'] != "true"){
                    $result->articles[$i]->title = "查询活动出错";
                    $result->articles[$i]->description = "请确定操作正确，如有疑问请咨询客服";
                    $result->articles[$i]->picUrl = "";
                    $result->articles[$i]->url = "";
                    continue;
			    }
			    $result->articles[$i]->title = $activityResult['message']['name'];
			    $result->articles[$i]->description = "活动地点：" . $activityResult['message']['stage'] . "\n" . "活动开始时间：" .         $activityResult['message']['start_time'] . "\n" . "活动结束时间：" . $activityResult['message']['end_time'];
			    $result->articles[$i]->picUrl = "http://wx9.igeek.asia/img/qrcode_test.png";
			    $result->articles[$i]->url = "http://wx9.igeek.asia/Ticket.php?openid=$openId&id={$ticketResult['message'][$i]['id']}";
			    //End
			    /*
                $result->articles[$i]->title = $ticketResult['message'][$i]['activity_name'];
                $result->articles[$i]->description = "您的第" . $j . "张票";
                $result->articles[$i]->picUrl = "http://wx9.igeek.asia/img/qrcode_test.png";
                $result->articles[$i]->url = "http://wx9.igeek.asia/Ticket.php?openid=$openId&id={$ticketResult['message'][$i]['id']}";
                */
            }
        }
        //Error from database
        else{
            $result->msgType = "text";
            $result->content = "查询失败：" . $ticketResult['message'];
        }
        return $result;
    }
}
?>
