<?php
/**
  * Operations for activities
  * Author: Feng Zhibin
  * Last modified: 2014.12.27
  */

require_once "dataAPI.php";
require_once "dataformat.php";

class ActivityManager{

    //Author: Feng Zhibin
    //Distribute seat randomly(?) for those who did not take a seat on desired time
    //params: none
    //return: none
    public function distributeSeat(){
        //Get all activity
        $dataapi = new DataAPI();
        $activityList = $dataapi->getActivityList();
        
        if($activityList["state"] == "true"){
            $activityNumber = count($activityList["message"]);
            //get state for all activities
            for($i = 0; $i < $activityNumber; $i++){
                $status = $this->timeStatus($activityList["message"][$i]);
                if($status == 2){
                    //distribute seats when time's up
                    $dataapi->assignSeats($activityList["message"][$i]);   
                }
            }
        }
    }
    
    //Author: Feng Zhibin
    //Update activity states
    //params: none
    //return: array, ["state"]: "true" or "false", ["message"]: message
    public function updateActivityState(){
        $dataapi = new DataAPI();
        $updateResult = $dataapi->updateActivityState(date("Y-m-d H:i:s"));
        return $updateResult;
    }
    
    //Author: Feng Zhibin
    //Check status of an activity
    //params: int $activityId
    //return: int $activityState, ranges from 0 to 4, check dataAPI.php for meanings
    public function timeStatus($activityId){
        date_default_timezone_set("Asia/Shanghai");
        $dataapi = new DataAPI();
        $activity = $dataapi->getActivityInfo($activityId);
        if($activity["state"] == "true"){
            $ticketStartTime = $activity["message"]["ticket_end_time"];
            $ticketEndTime = $activity["message"]["ticket_start_time"];
            $actStartTime = $activity["message"]["end_time"];
            $actEndTime = $activity["message"]["start_time"];
            $current = strtotime(date("Y-m-d H:i:s"));
            
            if($current < strtotime($ticketStartTime)) return 0;
            else if($current >= strtotime($ticketStartTime) && $current <= strtotime($ticketEndTime)) return 1;
            else if($current > strtotime($ticketEndTime) && $current <= strtotime($actStartTime)) return 2;
            else if($current <= strtotime($actEndTime)) return 3;
            else return 4;
        }
    }    
}
?>
