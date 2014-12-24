<?php
require_once "dataAPI.php";
require_once "dataformat.php";
require_once "token.php";
require_once "activity.php";

class MenuManager{

    //Author: Feng Zhibin
    //Drop expired activities on the menu
    //params: none
    //return: none
    public function clearMenu(){
        $dataapi = new DataAPI();
        $activityManager = new ActivityManager();
        $activityList = $dataapi->getActivityList();
        if($activityList["state"] == "true"){
            $activityNumber = count($activityList["message"]);
            for($i = 0; $i < $activityNumber; $i++){ //get state for all activities
                $status = $activityManager->timeStatus($activityList["message"][$i]);
                if($status == 2) $this->clearActivity($activityList["message"][$i], "../access_token", "../log/token_log");//clean up when expired
            }
        }
    }
    
    //Author: Feng Zhibin
    //Drop an activity on the menu
    //params: int $activityId
    //return: array, ["state"]: "true" or "false", ["message"]: message
    public function clearActivity($activityId, $tokenPath, $logPath){
        $tokenTaker = new AccessToken();//Get token for operating the menu
        $accessToken = $tokenTaker->getAccessToken($tokenPath, $logPath);//Specify the path of token files
        $menu = file_get_contents("https://api.weixin.qq.com/cgi-bin/menu/get?access_token=$accessToken");//Request for menu
        $result = json_decode($menu, true);
        
        $activityList = $result["menu"]["button"][1]["sub_button"];//Activity part of menu
        
        $count = count($activityList);
        if($count == 0){//If no activity currently
            $feedback["state"] = "false";
            $feedback["message"] = "Empty menu!";
            return $feedback;
        }
        $pos = 0;
        $i = 0;
        for($i; $i < $count; $i++){//Find the position of a specific activity
            if($activityList[$i]["key"] == "TAKE_$activityId"){
                $pos = $i;
                break;
            }
        }
        if($i == $count){//Activity not found in menu
            $feedback["state"] = "false";
            $feedback["message"] = "Activity not found in menu!";
            return $feedback;
        }
        array_splice($activityList, $pos, 1);//
        
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
}
?>
