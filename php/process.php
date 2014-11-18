<?php
/**
  * Process the user's request
  * Author: Zhao Zhiheng, Feng Zhibin
  * Last modified: 2014.11.17
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
		$ticketHandler = new ticketHandler();
        $content = trim($data->content);
        if ($content == "帮助"){
            $result = $this->help($data);
        }
        else if (substr($content, 0, 6) == "绑定"){
            $result = $this->bind($data);
        }
        else if (substr($content, 0, 6) == "解绑"){
            $result = $this->unbind($data);
        }
	    else if (substr($content, 0, 6) == "抢票" || substr($content, 0, 6) == "退票" || substr($content, 0, 6) == "查票"){
		    $result = $ticketHandler->ticketHandle($data);
	    }
        else{
            $result->msgType = "text";
            $result->content = "请输入帮助查看应用说明";
        }
        $result->toUserName = $data->fromUserName;
        $result->fromUserName = $data->toUserName;
        $result->createTime = time();
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
        $result->content = "目前此平台有两个功能，点击下方菜单可以进入验证界面，输入绑定+学号可以绑定微信号到学号，输入解绑+学号可以解绑微信号。
                            目前两个功能是独立的。所有的输入忽略空格。";
        return $result;
    }
    
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
        $result->content = $dataapi->binding($openId, intval($studentId), "binding");
        return $result;
    }
    
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
        $result->content = $dataapi->binding($openId, intval($studentId), "unbinding");
        return $result;
    }
}
?>
