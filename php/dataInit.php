<?php
require_once "dataAPI.php";
$test = new DataAPI();
//echo($test->getStudentId("openid000000000000000003")["message"]."\n");
//echo($test->binding("openid000000000000000001", 2012010001, "binding")."\n");
//echo($test->binding("openid000000000000000003", 2012010002)."\n");
//echo($test->binding("openid000000000000000001", 2012010003, "binding")."\n");

/*
echo($test->createActivity(array(
	"name" => "软件学院学生节2",
	"start_time" => "2014-11-11 08:00:00",
	"end_time" => "2014-11-11 09:00:00",
	"ticket_start_time" => "2014-11-2 19:00:00",
	"ticket_end_time" =>  "2014-11-2 19:00:00",
	"stage" => "大礼堂",
	"information" => "有ipad奖品哦！",
	"ticket_number" => 60,
	"ticket_per_student" => 1,
	"is_seat_selectable" => 1
))['message']);
*/
print_r($test->refundTicket("o9aMOs0bER4zxjWSx5gEmMkv1bvo",1));

//print_r($test->getTicketList("o9aMOs0bER4zxjWSx5gEmMkv1bvo",1)['message']);


//print_r($test->getTicketInfo(1)['message']);

/*
echo($test->takeSeat(0,1)['message']."!\n");
echo($test->takeSeat(1,1)['message']."!\n");
echo($test->takeSeat(1,2)['message']."!\n");
echo($test->takeSeat(2,1)['message']."!\n");
echo($test->takeSeat(2,2)['message']."!\n");
*/

//echo($test->initTicket(30, 1)['state']."\n");
//echo($test->takeTicketInfo("openid000000000000000001", 1)['message']."\n");
//echo($test->takeTicket("openid000000000000000002", 1)['message']."\n");
//echo($test->takeTicket("openid000000000000000002", 1)['message']."\n");
//echo($test->takeTicket("openid000000000000000002", 2)['message']."\n");
//echo($test->refundTicket("openid000000000000000002", 3)['message']."\n");

/*for ($x = 1;$x<=4;$x++){
$result = $test->takeTicket("openid000000000000000001", 1 );
$resultMessage = $result['message'];
	echo($result['state']."\n");
}
*/

/*
$result = $test->getInfo(1);
$resultMessage = $result['message'];
if ($result['state'] == "true"){
	
	foreach($result['message'] as $a){
		echo($a["seat_id"].$a["capability"].$a["num_seated"]."\n");
	}
}else{
	echo("11\n");
	echo($resultMessage."\n");
}
*/


/*$result = $test->createActivity("DaLiTang");
$resultMessage = $result['message'];
if ($result['state'] == "true"){
	echo($result['state']."\n");
}else{
	echo($resultMessage."\n");
}


$result = $test->binding("openid000000000000000001", 2012010001, "binding");
$resultMessage = $result['message'];
if ($result['state'] == "true"){
		echo("true"."\n");
}else{
	echo($resultMessage."\n");
}


$result = $test->initTicket(3, 1);
$resultMessage = $result['message'];
if ($result['state'] == "true"){
		echo("true"."\n");
}else{
	echo($resultMessage."\n");
}
*/
/*$result = $test->initTicket(3, 1);
$resultMessage = $result['message'];
if ($result['state'] == "true"){
	for ($i = 0; $i < count($resultMessage);$i++){
		echo($resultMessage[$i]."\n");
	}
}else{
	echo($resultMessage."\n");
}
*/

/*$result = $test->bind("openid000000000000000003", 2012010002);
$resultMessage = $result['message'];
if ($result['state'] == "true"){
	echo("true");
}else{
	echo($resultMessage."\n");
}*/


//echo($test->refundTicket("openid000000000000000002", 6)['message']."\n");
//echo($test->refundTicket("openid000000000000000002", 6)['message']."\n");
//echo($test->refundTicket("openid000000000000000001", 6)['message']."\n");
//echo($test->refundTicket("openid000000000000000001", 6)['message']."\n");
?>
