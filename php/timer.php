<?php

require_once "dataAPI.php";
require_once "dataformat.php";

class Timer{  
    public function expired($activityId, $mode){
        $dataapi = new DataAPI();
        $activity = $dataapi->getActivityInfo($activityId);
        if($activity["state"] == "true"){
            if($mode == "ticket") $expireTime = $activity["message"]["ticket_end_time"];
            else if($mode == "activity") $expireTime = $activity["message"]["end_time"];
            $year = substr($expireTime, 0, 4);
            $month = substr($expireTime, 5, 2);
            $day = substr($expireTime, 8, 2);
            $hour = substr($expireTime, 11, 2);
            $min = substr($expireTime, 14, 2);
            if(date("Y") >= $year && date("m") >= $month && date("d") >= $day && date("H") >= $hour && date("i") >= $min){
                return true;
            }
            else return false;
        }
    }
}
?>
