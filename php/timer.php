<?php

require_once "dataAPI.php";
require_once "dataformat.php";

class Timer{  
    public function timeStatus($activityId, $mode){
        date_default_timezone_set("Asia/Shanghai");
        $dataapi = new DataAPI();
        $activity = $dataapi->getActivityInfo($activityId);
        if($activity["state"] == "true"){
            if($mode == "ticket"){
                $expireTime = $activity["message"]["ticket_end_time"];
                $prematureTime = $activity["message"]["ticket_start_time"];
            }
            else if($mode == "activity"){
                $expireTime = $activity["message"]["end_time"];
                $prematureTime = $activity["message"]["start_time"];
            }

            if(strtotime(date("Y-m-d H:i:s")) > strtotime($expireTime)) return "Expired";
            else if(strtotime(date("Y-m-d H:i:s")) < strtotime($prematureTime)) return "Premature";
            else return "OK";
        }
    }
}
?>
