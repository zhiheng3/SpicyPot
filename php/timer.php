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
            $yearExpire = substr($expireTime, 0, 4);
            $monthExpire = substr($expireTime, 5, 2);
            $dayExpire = substr($expireTime, 8, 2);
            $hourExpire = substr($expireTime, 11, 2);
            $minExpire = substr($expireTime, 14, 2);
            
            $yearPremature = substr($prematureTime, 0, 4);
            $monthPremature = substr($prematureTime, 5, 2);
            $dayPremature = substr($prematureTime, 8, 2);
            $hourPremature = substr($prematureTime, 11, 2);
            $minPremature = substr($prematureTime, 14, 2);
            if(date("Y") >= $yearExpire && date("m") >= $monthExpire && date("d") >= $dayExpire && date("H") >= $hourExpire && date("i") >= $minExpire){
                return "Expired";
            }
            else if(date("Y") <= $yearPremature && date("m") <= $monthPremature && date("d") <= $dayPremature && date("H") <= $hourPremature && date("i") <= $minPremature){
                return "Premature";
            }
            else return "OK";
        }
    }
}
?>
