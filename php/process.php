<?php
/**
  * Process the user's request
  * Author: Zhao Zhiheng, Feng Zhibin
  * Last modified: 2014.12.27
  */
  
require_once "dataformat.php";
require_once "dataAPI.php";
require_once "ticket.php";
  
class RequestProcess{
    //Author: Zhao Zhiheng, Feng Zhibin
    //Process with the request data
    //params: RequestData $data
    //return: ResponseData $result
    //Test: No
    public function process($data){
	    $result = new ResponseData();
	    if ($data->msgType == "text"){
            $content = trim($data->content);
            if ($content == "帮助"){
                $result = $this->help($data);
            }
            
            if ($content == "测试"){
                $result = $this->test($data);
            }

            else if (substr($content, 0, 6) == "解绑"){
                $result = $this->unbind($data);
            }
/*
	        else if (substr($content, 0, 6) == "退票"){
                $ticketHandler = new ticketHandler();
	            $result = $ticketHandler->ticketHandle($data);
	        }
*/
            else{
                $result->msgType = "text";
                $result->content = "请输入帮助查看应用说明";
            }
        }
        else if ($data->msgType == "event"){
            //Menu click
            if ($data->event == "CLICK"){
                //Bind
                if ($data->eventKey == "USER_BIND"){
                    $result = $this->bindlink($data);
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
    //Test: No
    
    public function bindlink($data){
        $result = new ResponseData();
        $dataapi = new dataAPI();
        $studentid = $dataapi->getStudentId($data->fromUserName);
        $result->msgType = "text";
        if ($studentid['state'] == 'true'){
            $result->content = "你目前绑定的学号是" . $studentid['message']
                             . "如需解绑" . "<a href=\"wx9.igeek.asia/Unbind.php?id=$data->fromUserName\">请点击这里</a>";
        }
        else{
            $result->content = "<a href=\"wx9.igeek.asia/Verify.html?id=$data->fromUserName\">请点击我进行绑定</a>";
        }
        return $result;
    }
    
    //Author: Zhao Zhiheng
    //Display the help info
    //params: RequestData $data
    //return: ResponseData $result
    //Test: No
    public function help($data){
        $result = new ResponseData();
        $result->msgType = "text";
        $result->content = "目前此平台有两个功能，点击用户管理菜单可以进入绑定页面，输入解绑+学号可以解绑微信号。
                            输入抢票X（X为活动编号）。所有的输入忽略空格。";
        return $result;
    }
    
    private function test($data){
        $result = new ResponseData();
        $result->msgType = "text";
        $result->content = "<a href=\"101.5.97.126/test/Seat.html\">";
        return $result;
    }
    /*
    //Author: Zhao Zhiheng
    //Process the bind operation
    //params: RequestData $data
    //return: ResponseData $result
    //Test: No
    public function bind($data){
        $result = new ResponseData();
        $result->msgType = "text";
        $openId = $data->fromUserName;
        $studentId = trim(substr(trim($data->content), 6));
        if (!is_numeric($studentId) || strlen($studentId) != 10){
            $result->content = "学号输入错误";
            return $result;
        }
        $dataapi = new dataAPI();
        $bindResult = $dataapi->binding($openId, intval($studentId), "binding");
	if($bindResult['state'] == "true"){
		$result->content = "绑定成功";
	}
	else{
		$result->content = "绑定失败：" . $bindResult['message'];
	}
        return $result;
    }
    */
    //Author: Zhao Zhiheng
    //Process the unbind operation
    //params: RequestData $data
    //return: ResponseData $result
    //Test: No
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
                $result->articles[$i]->picUrl = "http://wx9.igeek.asia/upload/activity$id";
                
                $result->articles[$i]->url = "http://wx9.igeek.asia/Activity.php?id=$id";
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
