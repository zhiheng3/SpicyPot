<?php
/**
  * Process the user's request
  * Author: Zhao Zhiheng, Feng Zhibin
  * Last modified: 2015.1.8
  */
  
require_once "dataformat.php";
require_once "dataAPI.php";
require_once "ticket.php";
  
class RequestProcess{
    //Author: Zhao Zhiheng, Feng Zhibin
    //Process with the request data
    //params: RequestData $data
    //return: ResponseData $
    public function process($data){
	    $result = new ResponseData();
	    if ($data->msgType == "text"){
            $content = trim($data->content);

            if (substr($content, 0, 6) == "解绑"){
                $result = $this->unbind($data);
            }
            else{
                $result->msgType = "text";
                $result->content = "未知的命令";
            }
        }
        else if ($data->msgType == "event"){
            //Menu click
            if ($data->event == "CLICK"){
                //Bind
                if ($data->eventKey == "USER_BIND"){
                    $result = $this->bindlink($data);
                }
                //Help
                else if($data->eventKey == "HELP"){
                    $url = $_SERVER['SERVER_NAME'];
                    $result->msgType = "text";
                    $result->content = "<a href=\"$url/page/wechat/help.html\">请点击我查看帮助</a>";
                }
                //Take tickets
				else if(substr($data->eventKey, 0, 4) == "TAKE"){
				    //No activity is avaliable
				    if($data->eventKey == "TAKE_TICKET"){
				        $result->msgType = "text";
				        $result->content = "当前没有活动可以抢票～";
				    }
				    else{
                        $ticketHandler = new ticketHandler();
					    $result = $ticketHandler->takeTicket($data);
				    }
				}
				//Check tickets
                else if($data->eventKey == "CHECK_TICKET"){
                    $ticketHandler = new ticketHandler();
                    $result = $ticketHandler->getTicket($data);
                }
                //Check activities
                else if($data->eventKey == "CHECK_ACTIVITY"){
                    $result = $this->checkActivity();
                }
            }
        }
        
        $result->toUserName = $data->fromUserName;
        $result->fromUserName = $data->toUserName;
        $result->createTime = time();
        return $result;
    }
    
    //Author: Zhao Zhiheng
    //Process the bind/unbind operation
    //params: RequestData $data
    //return: ResponseData $result
    
    public function bindlink($data){
        $url = $_SERVER['SERVER_NAME'];
        $result = new ResponseData();
        $dataapi = new dataAPI();
        $studentid = $dataapi->getStudentId($data->fromUserName);
        $result->msgType = "text";
        if ($studentid['state'] == 'true'){
            $result->content = "你目前绑定的学号是" . $studentid['message']
                             . "如需解绑" . "<a href=\"$url/page/wechat/Unbind.php?id=$data->fromUserName\">请点击这里</a>";
        }
        else{
            $result->content = "<a href=\"$url/page/wechat/Verify.html?id=$data->fromUserName\">请点击我进行绑定</a>";
        }
        return $result;
    }
    
    //Author: Zhao Zhiheng
    //Process the unbind operation
    //params: RequestData $data
    //return: ResponseData $result
    public function unbind($data){
        $result = new ResponseData();
        $result->msgType = "text";
        $openId = $data->fromUserName;
        $studentId = trim(substr(trim($data->content), 6));
        if (!is_numeric($studentId) || strlen($studentId) != 10){
            $result->content = "学号输入错误";
            return $result;
        }
        $dataapi = new dataAPI();
        $unbindResult = $dataapi->unbind($openId, intval($studentId));
	if($unbindResult['state'] == "true"){
		$result->content = "解绑成功";
	}
	else{
		$result->content = "解绑失败：" . $unbindResult['message'];
	}
        return $result;
    }

    //Author: Feng Zhibin
    //Get all activities
    //params: none
    //return: ResponseData $result
    public function checkActivity(){
        $url = $_SERVER['SERVER_NAME'];
        //Get all activities from database
        $dataapi = new DataAPI();
        $activityResult = $dataapi->getActivityList();
        
        //Fail to get activities, return error message in text form
        if($activityResult["state"] == "false"){
            $result->msgType = "text";
            $result->content = "查询活动失败：" . $activityResult["message"];
            return $result;
        }
        
        $activities = count($activityResult["message"]);
        //No activity currently, return message in text form
        if($activities == 0){
            $result->msgType = "text";
            $result->content = "当前没有活动！";
            return $result;
        }
        
        //One or more activity exists, return message in news form
        $result->msgType = "news";
        //Limited by Tencent, at most 10 articles
        if($activities > 10) $activities = 10;
        //Specify number of articles
        $result->articleCount = $activities;
        $result->articles = array();
        for($i = 0; $i < $activities; $i++){
            $result->articles[$i] = new Article();
            $id = $activityResult["message"][$i];
            //Get an activity's info with it's ID
            $singleActivity = $dataapi->getActivityInfo($id);
            //If everything goes well on database
            if($singleActivity["state"] == true){
                $result->articles[$i]->title = $singleActivity["message"]["name"];
                $result->articles[$i]->description = $singleActivity["message"]["information"];
                
                //Specify pictures of this activity, you should modify this if necessary
                $result->articles[$i]->picUrl = "http://$url/page/wechat/resource/upload/activity$id";
                
                $result->articles[$i]->url = "http://$url/page/wechat/Activity.php?id=$id";
            }
            
            //Failed to get activity info
            else{
                $result->articles[$i]->title = "获取活动错误";
                $result->articles[$i]->description = $singleActivity["message"];
                $result->articles[$i]->picUrl = "";
                $result->articles[$i]->url = "";
            } 
        }
        return $result;
    }
}
?>
