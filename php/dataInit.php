<?php
require_once "dataAPI.php";
$test = new DataAPI();

//echo($test->getStudentId("openid000000000000000003")["message"]."\n");
/*for($i = 10001; $i <13001;$i++){
	$s ="test".substr((""+$i),1);
	$test->bind($s, $i, "binding");
}*/
//$test->binding("openid000000000000000001", 2012010001, "binding");
//echo($test->binding("openid000000000000000003", 2012010002)."\n");
//echo($test->binding("openid000000000000000001", 2012010003, "binding")."\n");
/*
echo($test->createActivity(array(
	"name" => "压力测试",
	"start_time" => "2014-11-11 08:00:00",
	"end_time" => "2014-11-11 09:00:00",
	"ticket_start_time" => "2014-11-2 19:00:00",
	"ticket_end_time" =>  "2014-11-2 19:00:00",
	"stage" => "综体",
	"information" => "Mr.L",
	"ticket_number" => 2000,
	"ticket_per_student" => 1,
	"is_seat_selectable" => 1
))['message']);
*/
print_r($test->refundTicketTest("",253));
print_r($test->refundTicketTest("",254));
print_r($test->refundTicketTest("",255));
print_r($test->refundTicketTest("",256));
print_r($test->refundTicketTest("",251));
print_r($test->refundTicketTest("",252));
print_r($test->refundTicketTest("",252));

/*
print_r($test->takeTicketTest("test0001"));
print_r($test->takeTicketTest("test0001"));
print_r($test->takeTicketTest("test0001"));
print_r($test->takeTicketTest("test3000"));
print_r($test->takeTicketTest("test3000"));

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
print_r($test->createSeats(1, [array("location" => "1-1","capability" => 1),array("location" => "1-2","capability" => 1),array("location" => "1-3","capability" => 1),array("location" => "2-1","capability" => 1),array("location" => "2-2","capability" => 1),array("location" => "2-3","capability" => 1),array("location" => "B区","capability" => 3),array("location" => "C区","capability" => 10)]));
*/

/*
print_r($test->createSeats(2, [array("location" => "A区","capability" =>10),array("location" => "B区","capability" => 10),array("location" => "C区","capability" => 10),array("location" => "D区","capability" => 10)]));
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


//echo($test->refundTicket("openid000000000000000002", 6)['message']."\n");
//echo($test->refundTicket("openid000000000000000002", 6)['message']."\n");
//echo($test->refundTicket("openid000000000000000001", 6)['message']."\n");
//echo($test->refundTicket("openid000000000000000001", 6)['message']."\n");
?>
