<?php
/**
  * Operations for WeChat menu
  * Author: Feng Zhibin
  * Last modified: 2014.12.27
  */

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
        //Get all activity
        $dataapi = new DataAPI();
        $activityManager = new ActivityManager();
        $activityList = $dataapi->getActivityList();
        
        if($activityList["state"] == "true"){
            $activityNumber = count($activityList["message"]);
            for($i = 0; $i < $activityNumber; $i++){ 
                //get state for all activities
                $status = $activityManager->timeStatus($activityList["message"][$i]);
                //clean up when expired
                if($status == 2) $this->clearActivity($activityList["message"][$i], "../access_token", "../log/token_log");
            }
        }
    }
    
    //Author: Feng Zhibin
    //Drop an activity on the menu
    //params: int $activityId
    //return: array, ["state"]: "true" or "false", ["message"]: message
    public function clearActivity($activityId, $tokenPath, $logPath){
        //Get token from Tencent
        //You should specify the path of access_token and token_log for yourself, with $tokenPath and $logPath here
        //If you call getAccessToken with no parameter, it would be "../access_token" and "../log/token_log"
        $tokenTaker = new AccessToken();
        $accessToken = $tokenTaker->getAccessToken($tokenPath, $logPath);
        
        //Get menu JSON with token
        $menu = file_get_contents("https://api.weixin.qq.com/cgi-bin/menu/get?access_token=$accessToken");
        $result = json_decode($menu, true);
        
        //Activity list
        $activityList = $result["menu"]["button"][1]["sub_button"];
        
        $count = count($activityList);
        //No activity currently, return state false and empty message
        if($count == 0){
            $feedback["state"] = "false";
            $feedback["message"] = "Empty menu!";
            return $feedback;
        }
        $pos = 0;
        $i = 0;
        for($i; $i < $count; $i++){
            //Find the position of a specific activity, mark it with $pos
            if($activityList[$i]["key"] == "TAKE_$activityId"){
                $pos = $i;
                break;
            }
        }
        if($i == $count){
            //Activity not found in menu, return state false and message
            $feedback["state"] = "false";
            $feedback["message"] = "Activity not found in menu!";
            return $feedback;
        }
        //If activity found, remove it
        array_splice($activityList, $pos, 1);
        
        //Update activity list in menu
        $result["menu"]["button"][1]["sub_button"] = $activityList;
        
        //Send the latest menu to Tencent
        //Method: POST
        //Header: declares type and length
        //content: the latest menu code
        $context = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded'.
						        '\n'.'Content-length:' . (strlen(json_encode($result["menu"], JSON_UNESCAPED_UNICODE)) + 1),
                'content' => json_encode($result["menu"], JSON_UNESCAPED_UNICODE))
            );
            
        //$context should be converted to stream context in order to use file_get_contents()
        $stream_context = stream_context_create($context);
        
        //Post everything to Tencent and get their response
        $updateResult = file_get_contents("https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$accessToken", false, $stream_context);
        $finalResult = json_decode($updateResult, true);
        
        //If everything is OK, errcode should be 0
        if($finalResult["errcode"] == 0){
            $feedback["state"] = "true";
            $feedback["message"] = "succeed!";
            //echo "$activityId: Menu updated!\n";
        }
        
        //Fail to update menu, should check errmsg on http://mp.weixin.qq.com/wiki/10/5c7947deb9668737bab97696889cd6a2.html
        else{
            $feedback["state"] = "false";
            $feedback["message"] = $finalResult["errmsg"];
        }
        return $feedback;
    }    
}
?>
