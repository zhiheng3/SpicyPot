<?php
require_once "./php/dataAPI.php";
require_once "./php/dataformat.php";
require_once "createActivity.php";
require_once "updateActivity.php";

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

else if($method == 'updateActivity'){
//echo json_encode(array("state"=>"false","message"=>$_POST['name']));
    $activityUpdater = new ActivityUpdater();
    $updateResult = $activityUpdater->updateActivity();
    echo json_encode($updateResult);
}

else{
    $result['state'] = "false";
    $result["message"] = "failed to match a method.";
    echo json_encode($result);
}
?>
