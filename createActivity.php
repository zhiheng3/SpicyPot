<?php
/**
  *Create an activity and get picture
  *Author: Feng Zhibin
  *Last modified: 2014.12.10
**/
require_once "php/dataAPI.php";
require_once "php/dataformat.php";

header("Content-Type:text/html; charset=utf-8");
$activityCreater = new ActivityCreater();
$result = $activityCreater->createActivity();
echo $result;

class ActivityCreater{
    //Author: Feng Zhibin
    //create an activity with a picture
    //params: none
    //return: string Message
    public function createActivity(){
        $activityResult = $this->addActivity();
        if($activityResult["state"] == "true"){
            $pictureResult = $this->addPicture($activityResult["message"]);
            if($pictureResult["state"] == "true"){
                $result = "活动创建成功，图片上传成功！";
            }
            else{
                $result = "活动创建成功，图片上传失败，错误信息：" . $pictureResult["message"];
            }
        }
        else{
            $result = "活动创建失败，错误信息：" . $activityResult["message"];
        }
        return $result;
    }
    //Author: Feng Zhibin
    //add an activity (without picture)
    //params: none
    //return: Array["state", "message"], state: "true" or "false", "message": int activityID or string errorMessage
    public function addActivity(){
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
        $activity->ticket_per_student = 1;  //每人最大抢票数
        $activity->is_seat_selectable = htmlspecialchars($_POST["seat_status"]);  //是否可选座：0不可选，1可选

        //Convert to an array
        $activityArray = (array)$activity;

        //Connect to DB and get response
        $dataapi = new DataAPI();
        $result = $dataapi->createActivity($activityArray);
        return $result;
    }
    
    //Author: Feng Zhibin
    //Add a picture for an activity
    //params: int $activityId
    //return: Array["state", "message"], state: "true" or "false", "message": Message
    public function addPicture($activityId){
        //Path of the file saved
        $savePath = "upload/activity$activityId";

        //Check for format
        if ((($_FILES["pic_upload"]["type"] == "image/gif")
        || ($_FILES["pic_upload"]["type"] == "image/jpeg")
        || ($_FILES["pic_upload"]["type"] == "image/pjpeg"))){
            if ($_FILES["pic_upload"]["error"] > 0){//Upload failed
                return (array("state" => "false", "message" => $_FILES["pic_upload"]["error"]));
            }
            else{//File already exists
                if (file_exists($savePath)){
                    return (array("state" => "false", "message" => "同名文件已经存在!"));
                }
                else{//All OK
                    move_uploaded_file($_FILES["pic_upload"]["tmp_name"], $savePath);
                    return (array("state" => "true", "message" => "上传的图片已经被储存到 $savePath."));
                }
            }
        }
        else{//Invalid file
            return (array("state" => "false", "message" => "文件格式不正确！"));
        }           
    }
}
?>
