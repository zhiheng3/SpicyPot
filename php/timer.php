<?php

require_once "dataAPI.php";
require_once "dataformat.php";
require_once "menu.php";
require_once "activity.php";

//$timer = new Timer();
//$timer->runTimer();

class Timer{

    //Author: Feng Zhibin
    //Run the timer
    //params: none
    //return: none
    public function runTimer(){
        ignore_user_abort();
        set_time_limit(0);
        $timer = new Timer();
        $start = time();
        $interval = 30;//Run every $interval seconds
        $count = 1;
        $menuManager = new MenuManager();
        $activityManager = new ActivityManager();
        do{
            if(time() - $start > 600) break;
            echo "Scan $count\n";
            $count++;
            $menuManager->clearMenu();
            $activityManager->updateActivityState();
            $activityManager->distributeSeat();
            sleep($interval);//Wait for $interval seconds
        }while(true);
    }
}
?>
