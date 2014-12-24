<?php

require_once "dataAPI.php";
require_once "dataformat.php";
require_once "token.php";
require_once "timer.php";

$timeHandler = new TimeHandler();
$timeHandler->runTimer();

class TimeHandler{
    public function runTimer(){
        ignore_user_abort();
        set_time_limit(0);
        $timer = new Timer();
        
        $start = time();
        $interval = 30;
        $count = 1;
        do{
            if(time() - $start > 600) break;
            echo "Scan $count\n";
            $count++;
            $this->clearMenu();
            $this->updateActivityState();
            $this->distributeSeat();
            sleep($interval);
        }while(true);
    }
    
    public function clearMenu(){
        $dataapi = new DataAPI();
        $timer = new Timer();
        $activityList = $dataapi->getActivityList();
        if($activityList["state"] == "true"){
            $activityNumber = count($activityList["message"]);
            for($i = 0; $i < $activityNumber; $i++){ 
                $status = $timer->timeStatus($activityList["message"][$i]);
                if($status == 2) $this->clearActivity($activityList["message"][$i]);
            }
        }
    }
    
    public function distributeSeat(){
        $dataapi = new DataAPI();
        $timer = new Timer();
        $activityList = $dataapi->getActivityList();
        if($activityList["state"] == "true"){
            $activityNumber = count($activityList["message"]);
            for($i = 0; $i < $activityNumber; $i++){ 
                $status = $timer->timeStatus($activityList["message"][$i]);
                if($status == 2){
                    $dataapi->assignSeats($activityList["message"][$i]);
                    //echo "{$activityList["message"][$i]}: Seat distributed!\n";
                }
            }
        }    
    }
    
    public function clearActivity($activityId){
        $tokenTaker = new AccessToken();
        $accessToken = $tokenTaker->getAccessToken("access_token", "log/token_log");
        $menu = file_get_contents("https://api.weixin.qq.com/cgi-bin/menu/get?access_token=$accessToken");
        $result = json_decode($menu, true);
        
        $activityList = $result["menu"]["button"][1]["sub_button"];
        
        $count = count($activityList);
        if($count == 0){
            $feedback["state"] = "false";
            $feedback["message"] = "Empty menu!";
            return $feedback;
        }
        $pos = 0;
        $i = 0;
        for($i; $i < $count; $i++){
            if($activityList[$i]["key"] == "TAKE_$activityId"){
                $pos = $i;
                break;
            }
        }
        if($i == $count){
            $feedback["state"] = "false";
            $feedback["message"] = "Activity not found in menu!";
            return $feedback;
        }
        array_splice($activityList, $pos, 1);
        
        $result["menu"]["button"][1]["sub_button"] = $activityList;
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
            $feedback["message"] = "succeed!";
            //echo "$activityId: Menu updated!\n";
        }
        else{
            $feedback["state"] = "false";
            $feedback["message"] = $finalResult["errmsg"];
        }
        return $feedback;
    }
    
    public function updateActivityState(){
        $dataapi = new DataAPI();
        $updateResult = $dataapi->getActivityList(date("Y-m-d H:i:s"));
        return $updateResult;
    }
    
}
?>
