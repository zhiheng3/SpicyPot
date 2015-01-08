<?php
/**
  * Timer that update the menu and distribute seats periodically
  * Author: Feng Zhibin
  * Last modified: 2014.12.27
  */
require_once "dataAPI.php";
require_once "dataformat.php";
require_once "menu.php";
require_once "activity.php";

class Timer{

    //Author: Feng Zhibin
    //Run the timer, try to update menu and distribute seats every $interval seconds
    //params: none
    //return: none
    
    //Important: 
    //You should use this really CAREFULLY! 
    //Once it is running on server, it would be VERY DIFFICULT TO STOP the timer!
    public function runTimer(){
        ignore_user_abort();
        set_time_limit(0);
        $interval = 10;

        $menuManager = new MenuManager();
        $activityManager = new ActivityManager();
        do{        
            $menuManager->clearMenu();
            $activityManager->updateActivityState();
            $activityManager->distributeSeat();
            
            //Wait for $interval seconds
            sleep($interval);
        }while(true);
    }
}
?>
