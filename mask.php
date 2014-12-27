<?php
require_once "./php/dataAPI.php";
require_once "./php/dataformat.php";
require_once "createActivity.php";
require_once "updateActivity.php";
require_once "./php/menu.php";

$method = $_POST['method'];
if ($method == 'unbind'){
    $openId = $_POST['openid'];
    $studentId = $_POST['studentid'];
    $dataapi = new dataAPI();
    $unbindResult = $dataapi->unbind($openId, $studentId);
    echo json_encode($unbindResult);
}

else if($method == 'refundTicket'){
    $openId = $_POST['openid'];
    $ticketId = $_POST['ticketid'];
    $dataapi = new dataAPI();
    $refundTicketResult = $dataapi->refundTicket($openId, $ticketId);
    echo json_encode($refundTicketResult);
}

else if($method == 'takeSeat'){
    $ticketId = $_POST['ticketid'];
    $seatId = $_POST['seatid'];
    $dataapi = new dataAPI();
    $takeSeatResult = $dataapi->takeSeat($ticketId, $seatId);
    echo json_encode($takeSeatResult);
}

else if ($method == 'seatInfo'){
    $activityId = $_POST['activityid'];
    $dataapi = new dataAPI();
    $seatInfoResult = $dataapi->getSeatInfo(intval($activityId));
    echo json_encode($seatInfoResult);
}

//Testing
else if($method == 'createActivity'){
    $activityCreater = new ActivityCreater();
    $createResult = $activityCreater->createActivity();
    echo json_encode($createResult);
}

else if($method == 'deleteActivity'){
    //检测是否登录
    session_start();
    if(!isset($_SESSION['name'])){
        echo json_encode(array("state"=>"false","message"=>"Please log in."));
        exit();
    }

	$data = new DataAPI();
    $activityId = $_POST['id'];
    $result = $data->dropActivity($activityId);
    if($result["state"] == "true") $result["message"] = "success";
    echo json_encode($result);

    $menuManager = new MenuManager();
    $menuManager->clearActivity($activityId);
}

else if($method == 'updateActivity'){

    $activityUpdater = new ActivityUpdater();
    $updateResult = $activityUpdater->updateActivity();
    echo json_encode($updateResult);
}

else if($method == 'createSeats'){
    $activity_id = $_POST['activity_id'];
    $seatList = $_POST["seatList"];
    $data = new dataAPI();
    $result=$data -> createSeats($activity_id, $seatList);
    echo json_encode($result);
}

else if($method == 'assignSeats'){
    $activity_id = $_POST['activity_id'];
    $data = new dataAPI();
    $result = $data -> assginSeats($activity_id);
    echo json_encode($result);
}

else{
    $result['state'] = "false";
    $result["message"] = "failed to match a method.";
    echo json_encode($result);
}
?>
