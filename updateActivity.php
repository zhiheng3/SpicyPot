<?php
/**
  *Update an activity and get picture
  *Author: Chen Minghai
  *Last modified: 2014.12.22
**/
require_once "./php/dataAPI.php";
require_once "./php/dataformat.php";
require_once "./php/token.php";

class ActivityUpdater{
    //Author: Feng Zhibin
    //create an activity with a picture
    //params: none
    //return: Array["state", "message"], state: "true" or "false", "message": int activityID or string errorMessage
    public function updateActivity(){
        $activityResult = $this->updateActivityInfo();
        if($activityResult["state"] == "true"){
            $pictureResult = $this->updatePicture();
            if($pictureResult["state"] == "true"){
                $result["state"] = "true";
                $result["message"] = "活动修改成功，图片上传成功！";
            }
            else{
                $result["state"] = "true";
                $result["message"] = "活动修改成功，图片上传失败，错误信息：" . $pictureResult["message"];
            }
        }
        else{
            $result["state"] = "false";
            $result["message"] = "活动修改失败，错误信息：" . $activityResult["message"];
        }
        $menuResult = $this->updateMenu($activityResult["message"]);
        if($menuResult["state"] == "true") $result["message"] .= "微信菜单更新成功！";
        else $result["message"] .= "微信菜单更新失败！";
        return $result;
    }

    
    //update an activity (without picture)
    //params: none
    //return: Array["state", "message"], state: "true" or "false", "message": int activityID or string errorMessage
    public function updateActivityInfo(){
        //Initialization
        $activity = new Activity();
        $activity->name = htmlspecialchars($_POST["name"]); //名称
        $activity->start_time = htmlspecialchars($_POST["Act-Start"]);  //活动开始时间
        $activity->end_time = htmlspecialchars($_POST["Act-End"]);  //活动结束时间
        $activity->ticket_start_time = htmlspecialchars($_POST["Rob-Start"]);  //抢票开始时间
        $activity->ticket_end_time = htmlspecialchars($_POST["Rob-End"]);  //抢票结束时间
        $activity->stage = htmlspecialchars($_POST["place"]);  //活动地点
        $activity->information = htmlspecialchars($_POST["description"]);  //详细信息
        $activity->ticket_number = htmlspecialchars($_POST["total_tickets"]);  //总票数
        $activity->ticket_per_student = htmlspecialchars($_POST["ticket_per_student"]);   //每人最大抢票数
        $activity->is_seat_selectable = htmlspecialchars($_POST["seat_status"]);  //是否可选座：0不可选，1可选

        //Convert to an array
        $activityArray = (array)$activity;

        //Connect to DB and get response
        $dataapi = new DataAPI();
        $result = $dataapi->updateActivity($_POST["activity_id"],$activityArray);
        return $result;
    }
    
    
    //Update a picture for an activity
    //params: int $activityId
    //return: Array["state", "message"], state: "true" or "false", "message": Message
    public function updatePicture(){
        //Path of the file saved
        $activityId = $_POST["activity_id"];
        $savePath = "upload/activity$activityId";
        if($_FILES["pic_upload"]["size"] == "0"){
            return(array("state" => "false", "message" => "上传图片为空"));        
        }
        //Check for format
        if ((($_FILES["pic_upload"]["type"] == "image/gif")
        || ($_FILES["pic_upload"]["type"] == "image/jpeg")
        || ($_FILES["pic_upload"]["type"] == "image/pjpeg"))){
            if ($_FILES["pic_upload"]["error"] > 0){//Upload failed
                return (array("state" => "false", "message" => $_FILES["pic_upload"]["error"]));
            }
            else{
                //File already exists
                if (file_exists($savePath)){

                   unlink($savePath);
                    
                }
                
                move_uploaded_file($_FILES["pic_upload"]["tmp_name"], $savePath);
                return (array("state" => "true", "message" => "上传的图片已经被储存到 $savePath."));
            }
        }
        else{//Invalid file
            return (array("state" => "false", "message" => "文件格式不正确！"));
        }           
    }
    
    //Author: Feng Zhibin
    //Update the menu on WeChat
    //params: int $activityId
    //return: Array["state", "message"], state: "true" or "false", "message": Message
    public function updateMenu($activityId){
        $tokenTaker = new AccessToken();
        $accessToken = $tokenTaker->getAccessToken("access_token", "log/token_log");
        $menu = file_get_contents("https://api.weixin.qq.com/cgi-bin/menu/get?access_token=$accessToken");
        $result = json_decode($menu, true);
        
        $activityList = $result["menu"]["button"][1]["sub_button"];

        if(count($activityList) == 0){
            $newBtn = array();
            $newBtn["name"] = $result["menu"]["button"][1]["name"];
            $newBtn["sub_button"] = array();
            $newBtn["sub_button"][0]["type"] = "click";
            $newBtn["sub_button"][0]["name"] = $_POST["name"];
            $newBtn["sub_button"][0]["key"] = "TAKE_$activityId";
            $newBtn["sub_button"][0]["sub_button"] = array();
            $result["menu"]["button"][1] = $newBtn;
        }
        else{
            $count = count($activityList);

            for($i = $count - 1; $i >= 0; $i--){
                if($i < 4) $activityList[$i + 1] = $activityList[$i];
            }
            $activityList[0]["type"] = "click";
            $activityList[0]["name"] = $_POST["name"];
            $activityList[0]["key"] = "TAKE_$activityId";
            $activityList[0]["sub_button"] = array();
            $result["menu"]["button"][1]["sub_button"] = $activityList;
        }

        $context = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded'.
						        '\n'.'Content-length:' . (strlen(json_encode($result["menu"], JSON_UNESCAPED_UNICODE)) + 1),
                'content' => json_encode($result["menu"], JSON_UNESCAPED_UNICODE))
            );
        $stream_context = stream_context_create($context);
        $updateResult = file_get_contents("https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$accessToken", false, $stream_context);
        $finalResult = json_decode($updateResult, true);
        if($finalResult["errcode"] == 0){
            $feedback["state"] = "true";
        }
        else{
            $feedback["state"] = "false";
            $feedback["message"] = $finalResult["errmsg"];
        }
        return $feedback;
    }
}
?>
