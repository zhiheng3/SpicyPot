<?php
require_once "dataAPI.php";
$test = new DataAPI();

/*$list = array();
for ($i=1;$i<32;$i++){
    $item = array("capability"=>1,"location"=>"1R".$i."C");
    array_push($list,$item);
}
*/
//print_r($list);
print_r($test->createSeats(84,$list));
//echo($test->getStudentId("openid000000000000000003")["message"]."\n");
/*for($i = 10001; $i <13001;$i++){
	$s ="test".substr((""+$i),1);
	$test->bind($s, $i, "binding");
}*/
//$test->binding("openid000000000000000001", 2012010001, "binding");
//echo($test->binding("openid000000000000000003", 2012010002)."\n");
//echo($test->binding("openid000000000000000001", 2012010003, "binding")."\n");

echo($test->updateActivity(86,array(
	"name" => "马兰花开100场献礼",
    "brief_name" => "马兰花开!",
	"start_time" => "2014-11-11 08:00:00",
	"end_time" => "2014-11-11 09:00:00",
	"ticket_start_time" => "2014-11-2 19:00:00",
	"ticket_end_time" =>  "2014-11-2 19:00:00",
	"stage" => "新清华学堂",
	"information" => "第五十场献礼！",
	"ticket_number" => 500,
	"ticket_per_student" => 3,
	"is_seat_selectable" => 1
))['message']);

/*
echo($test->createActivity(array(
	"name" => "马兰花开100场献礼",
    "brief_name" => "马兰花开",
	"start_time" => "2014-11-11 08:00:00",
	"end_time" => "2014-11-11 09:00:00",
	"ticket_start_time" => "2014-11-2 19:00:00",
	"ticket_end_time" =>  "2014-11-2 19:00:00",
	"stage" => "新清华学堂",
	"information" => "第五十场献礼！",
	"ticket_number" => 20,
	"ticket_per_student" => 3,
	"is_seat_selectable" => 1
))['message']);


echo($test->createActivity(array(
	"name" => "马杯女篮决赛",
	"start_time" => "2014-11-11 08:00:00",
	"end_time" => "2014-11-11 09:00:00",
	"ticket_start_time" => "2014-11-2 19:00:00",
	"ticket_end_time" =>  "2014-11-2 19:00:00",
	"stage" => "综体",
	"information" => "强强碰撞！",
	"ticket_number" => 20,
	"ticket_per_student" => 3,
	"is_seat_selectable" => 1
))['message']);


echo($test->createActivity(array(
	"name" => "亲亲非凡哥",
	"start_time" => "2014-11-11 08:00:00",
	"end_time" => "2014-11-11 09:00:00",
	"ticket_start_time" => "2014-11-2 19:00:00",
	"ticket_end_time" =>  "2014-11-2 19:00:00",
	"stage" => "大礼堂",
	"information" => "啦啦啦！",
	"ticket_number" => 20,
	"ticket_per_student" => 1,
	"is_seat_selectable" => 0
))['message']);
*/
//print_r($test->updateActivityState(16,1));
/*
print_r($test->refundTicketTest("test0013"));
print_r($test->refundTicketTest("test0013"));
print_r($test->refundTicketTest("test0013"));
print_r($test->refundTicketTest("test0013"));
print_r($test->refundTicketTest("test0013"));
*/
/*
print_r($test->refundTicketTest("test0008"));
print_r($test->refundTicketTest("test0009"));

print_r($test->refundTicketTest("test0014"));
print_r($test->refundTicketTest("test0015"));
print_r($test->refundTicketTest("test0016"));
print_r($test->refundTicketTest("test0017"));
*/
/*
print_r($test->takeTicketTest("test0001"));
print_r($test->takeTicketTest("test0001"));
print_r($test->takeTicketTest("test0001"));
print_r($test->takeTicketTest("test3000"));
print_r($test->takeTicketTest("test3000"));
*/
//print_r($test->getActivityList());
/*
echo($test->createActivity(array(
	"name" => "小平太2",
	"start_time" => "2014-11-11 08:00:00",
	"end_time" => "2014-11-11 09:00:00",
	"ticket_start_time" => "2014-11-2 19:00:00",
	"ticket_end_time" =>  "2014-11-2 19:00:00",
	"stage" => "综体",
	"information" => "Mr.L",
	"ticket_number" => 3,
	"ticket_per_student" => 1,
	"is_seat_selectable" => 1
))['message']);
*/

/*
print_r($test->createSeats(9, [array("location" => "1-1","capability" => 1),array("location" => "1-2","capability" => 1),array("location" => "1-3","capability" => 1),array("location" => "2-1","capability" => 1),array("location" => "2-2","capability" => 1),array("location" => "2-3","capability" => 1),array("location" => "B区","capability" => 9),array("location" => "C区","capability" => 5)]));



print_r($test->createSeats(10, [array("location" => "A区","capability" =>5),array("location" => "B区","capability" => 5),array("location" => "C区","capability" => 12),array("location" => "D区","capability" => 3)]));
*/

/*
print_r($test->getTicketInfo(1));
unset($test);
$test2 = new DataAPI();
print_r($test2->getTicketInfo(1));
*/
//print_r($test->refundTicket("o9aMOs0bER4zxjWSx5gEmMkv1bvo",242));
//print_r($test->refundTicket("o9aMOs2MKJ4HZbZIdQUo4D37gusg",1));
//print_r($test->getTicketList("o9aMOs0bER4zxjWSx5gEmMkv1bvo",1)['message']);
//print_r($test->takeTicket("o9aMOs0bER4zxjWSx5gEmMkv1bvo",1)['message']);

//print_r($test->getTicketInfo(1)['message']);

/*
print_r($test->takeSeat(1,'1-1'));
print_r($test->takeSeat(1,'1-2'));
print_r($test->takeSeat(4,'1-1'));
print_r($test->takeSeat(4,'2-2'));
print_r($test->takeSeat(5,'B区'));
print_r($test->takeSeat(6,'B区'));
print_r($test->takeSeat(7,'B区'));
print_r($test->takeSeat(8,'B区'));
print_r($test->takeSeat(9,20));
print_r($test->takeSeat(-1,'C区'));
*/
//print_r($test->takeSeat(64,'B区'));

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
//print_r($test->getSeatInfo(10));

//echo($test->refundTicket("openid000000000000000002", 6)['message']."\n");
//echo($test->refundTicket("openid000000000000000002", 6)['message']."\n");
//echo($test->refundTicket("openid000000000000000001", 6)['message']."\n");
//echo($test->refundTicket("openid000000000000000001", 6)['message']."\n");
?>
