<?php
/**
  * Process the user's request
  * Author: 
  * Last modified: 2014.11.9
  */
  
require_once "dataformat.php";
  
class RequestProcess{
    //Author: Zhao Zhiheng
    //Process with the request data
    //params: RequestData $data
    //return: ResponseData $data
    //Test: No
    public function process($data){
        $result = new ResponseData();
        $result->toUserName = $data->fromUserName;
        $result->fromUserName = $data->toUserName;
        $result->createTime = time();
        $result->msgType = "text";
        if ($data->content == "绑定"){
            $result->content = "此功能正在开发";
        }
        else{
            $result->content = "请输入绑定试试";
        }
        return $result;
    }
}
?>