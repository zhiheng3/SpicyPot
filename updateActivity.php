<?php
/**
  *Create / update an activity
  *Author: Feng Zhibin, Chen Minghai
  *Last modified: 2014.12.28
**/
require_once "./php/dataAPI.php";
require_once "./php/dataformat.php";
require_once "./php/token.php";
require_once "./php/menu.php";

class ActivityUpdater{
    //Author: Feng Zhibin
    //Set an activity with picture
    //params: String $status = "new" or "update"
    //return: Array["state", "message"], state: "true" or "false", "message": int activityID or string errorMessage
    public function updateActivity($status){
        if($status != "new" && $status != "update"){
            $result["state"] = "false";
            $result["message"] = "未定义的操作代码";
            return $result;
        }
        
        $activityResult = $this->setActivity($status); 
        
        if($activityResult["state"] == "true"){
        
            if($status == "update") $pictureResult = $this->setPicture($_POST["activity_id"]);
            else if($status == "new") $pictureResult = $this->setPicture($activityResult["message"]);
            
            if($_POST["seat_status"] > 0){
                if ($status == "new")
                    $seatResult = $this->setSeats($activityResult["message"]);
                else
                    $seatResult = $this->setSeats($_POST["activity_id"]);
            }
            
            $result["state"] = "true";
            //$result["message"] = "活动创建成功！\n";
            $result["message"] = "";
            if($pictureResult["state"] == "true"){
                //$result["message"] .= "图片上传成功！\n";
            }
            else{
                $result["message"] .= "图片上传失败，错误信息：" . $pictureResult["message"] . "\n";
            }
            //if(!$seatResult) $result["message"] .= "本活动不需要创建座位！\n";
            //else if($seatResult["state"] == "true") $result["message"] .= "座位创建成功！\n";
            //else $result["message"] .= "座位创建失败，错误信息：" . $seatResult["message"] . "\n";
            if($seatResult && $seatResult["state"] != "true") $result["message"] .= "座位创建失败，错误信息：" . $seatResult["message"] . "\n";
        }
        else{
            $result["state"] = "false";
            $result["message"] = "活动创建失败，错误信息：" . $activityResult["message"] . "\n";
        }

        $menuManager = new MenuManager();
        if($status == "new") $menuResult = $menuManager->updateMenu($activityResult["message"], "add", "access_token", "log/token_log");
        else $menuResult = $menuManager->updateMenu($_POST["activity_id"], "update", "access_token", "log/token_log");
        
        
        //if($menuResult["state"] == "true") $result["message"] .= "微信菜单更新成功！";
        //else $result["message"] .= "微信菜单更新失败！" . $menuResult["message"];
        if($menuResult["state"] != "true") $result["message"] .= "微信菜单更新失败！" . $menuResult["message"];
        
        return $result;
    }

    
    //Set an activity (without picture)
    //params: String $status = "new" or "update"
    //return: Array["state", "message"], state: "true" or "false", "message": int activityID or string errorMessage
    public function setActivity($status){
    
        if($status != "new" && $status != "update"){
            $result["state"] = "false";
            $result["message"] = "未定义的操作代码";
            return $result;
        }
        //Initialization
        $activity = new Activity();
        $activity->name = htmlspecialchars($_POST["name"]); //名称
        $activity->brief_name = htmlspecialchars($_POST["key"]); //简称
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
        
        if($status == "update") $result = $dataapi->updateActivity($_POST["activity_id"], $activityArray);
        else $result = $dataapi->createActivity($activityArray);
        return $result;
    }
    
    
    //Update a picture for an activity
    //params: int $activityId
    //return: Array["state", "message"], state: "true" or "false", "message": Message
    public function setPicture($activityId){
    
        //Path of the file saved
        $savePath = "upload/activity$activityId";
        if($_FILES["pic_upload"]["size"] == "0"){
            if (file_exists($savePath))
                return (array("state" => "true", "message" => "图片已经上传"));
            else
                return(array("state" => "true", "message" => "上传图片为空"));        
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
    
    //Create seat, have not test yet
    public function setSeats($activityId){
        $seatStr = trim($_POST["seat_info_str"]);
        $ssaFile = fopen("./seat/$activityId.ssa", "w");
        fwrite($ssaFile, $seatStr);
        fclose($ssaFile);
        
        $seatInfo = json_decode($_POST["seat_info"], true);
        $dataapi = new DataAPI();
        $result = $dataapi->createSeats($activityId, $seatInfo);
        return $result;
    }
}
?>
