<?php
/**
  * Operations for WeChat menu
  * Author: Feng Zhibin
  * Last modified: 2014.12.28
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
        //Param 5: Get all activities, expired activities included
        $activityList = $dataapi->getActivityList(5);
        
        if($activityList["state"] == "true"){
            $activityNumber = count($activityList["message"]);
            for($i = 0; $i < $activityNumber; $i++){ 
                //get state for all activities
                $status = $activityManager->timeStatus($activityList["message"][$i]);
                //clean up when expired
                if($status >= 2) $this->updateMenu($activityList["message"][$i], "drop", "../log/access_token", "../log/token_log");
            }
        }
    }

    //Author: Feng Zhibin
    //Update menu
    //params: int $activityId, String $operation, $tokenPath, $logPath
    //$operation: "add" / "drop" / "update"
    //return: array, ["state"]: "true" or "false", ["message"]: message
    public function updateMenu($activityId, $operation, $tokenPath = "../log/access_token", $logPath = "../log/token_log"){
    
        //Only "add", "drop" and "update" are valid
        if($operation != "add" && $operation != "drop" && $operation != "update"){
            $feedback["state"] = "false";
            $feedback["message"] = "Invalid operation!";
            return $feedback;
        }  
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
        //No activity currently
        if($count == 0){
            //Add operation, create a new button for an empty menu
            if($operation == "add" || $operation == "update"){
                $newBtn = array();
                $newBtn["name"] = $result["menu"]["button"][1]["name"];
                $newBtn["sub_button"] = array();
                $newBtn["sub_button"][0]["type"] = "click";
                $newBtn["sub_button"][0]["name"] = $_POST["name"];
                $newBtn["sub_button"][0]["key"] = "TAKE_$activityId";
                $newBtn["sub_button"][0]["sub_button"] = array();
                $result["menu"]["button"][1] = $newBtn;
                $activityList = $newBtn["sub_button"];
            }
            //Drop operation, return false
            else if($operation == "drop"){
                $feedback["state"] = "false";
                $feedback["message"] = "Empty menu!";
                return $feedback;
            }
        }
        else{
            if($operation == "add"){
                $activity = array();
                $activity["type"] = "click";
                $activity["name"] = $_POST["name"];
                $activity["key"] = "TAKE_$activityId";
                $activity["sub_button"] = array();
                
                //Put this activity to the head of menu
                array_unshift($activityList, $activity);
                //If number of activities > 5, cut the rest
                array_splice($activityList, 5);
            }
            else if($operation == "drop" || $operation == "update"){
                $pos = 0;
                $i = 0;
                for($i; $i < $count; $i++){
                    //Find the position of a specific activity, mark it with $pos
                    if($activityList[$i]["key"] == "TAKE_$activityId"){
                        $pos = $i;
                        if($operation == "update") $activityList[$pos]["name"] = $_POST["name"];
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
                if($operation == "drop") array_splice($activityList, $pos, 1); 
            }
        }
 
        
        //Update activity list in menu
        if(count($activityList) != 0){
            $result["menu"]["button"][1]["sub_button"] = $activityList;
        }
        else{
            $result["menu"]["button"][1]["type"] = "click";
            $result["menu"]["button"][1]["key"] = "TAKE_TICKET";
            $result["menu"]["button"][1]["sub_button"] = array();
        }
       
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
