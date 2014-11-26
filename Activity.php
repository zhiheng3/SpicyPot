<?php
/**
  * View activity page
  * Author: Xu Yi
  * Last modified: 2014.11.25
  * method: GET
  * param: id activity's id in database
  */
?>

<?xml version="1.0" encoding="UTF-8"?>  
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">  
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>  
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<meta name="viewport" content="width=device-width"/>
<link rel="stylesheet" type="text/css" href="./css/ActivityInfo.css">
<script type="text/javascript" src = "./js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src = "./js/ActivityInfo.js"></script>
<title>活动详情</title>
</head>
<body>
<!--	<div id = "ImgTop">
		<img src="./img/newlogo.jpg">
	</div>
-->
	<div id = "MainContent">
		<div id = "Activity">
			<div id = "Activity-Title">紫荆之声</div>
			<hr width="50%" margin-bottom="0" size="2" color="#FFFFFF" style="FILTER: alpha(opacity=0,finishopacity=50,style=3)" >
			<div id = "colorblock"></div>
		</div>

	    <div id ="Ticket-Info">
			<div class = "General-Title" id = "NStart-Title">距离抢票开始还有：</div>
			<div class = "General-Title" id = "Start-Title">抢票正在进行，距离结束还有：</div>

			<div id = "Time-Left">
				<div class = "Number-Left" id = "Day-Left">12</div>
				<div class = "Text-Title">天</div>

				<div class = "Number-Left" id = "Hor-Left">12</div>
				<div class = "Text-Title">时</div>

				<div class = "Number-Left" id = "Min-Left">22</div>
				<div class = "Text-Title">分</div>

				<div class = "Number-Left" id = "Sec-Left">12</div>
				<div class = "Text-Title">秒</div>
			</div>
			

			<div class = "General-Title" id= "NTicket-Title">活动预计发票：</div>
			<div class = "General-Title" id= "Ticket-Title">当前余票：</div>
			<div id = "Ticket-Box">
				<div id = "Ticket-Number">9999</div>
				<div id = "Ticket-Unit">张</div>
			</div>
	    </div>
	    
	    <div id="Time-Info">
			<div class = "General-Title">抢票时间：</div>
			<div class = "General-Box"><p>21312</p></div>

			<div class = "General-Title">活动时间：</div>
			<div class = "General-Box"><p id = "ActivityStartTime">21312</p></div>
			<div class = "General-Box"><p id = "ActivityEndTime">21312</p></div>

			<div class = "General-Title">活动地点：</div>
			<div class = "General-Box"><p id = "ActivityPlace">21312</p></div>
			<div id = "colorblock2"></div>
	    </div>
	</div>
	
	<div id = "Activity-Inc">
		<hr style="FILTER: alpha(opacity=100,finishopacity=0,style=3)" width="80%" size="1">
		<p>清华大学/校团委</p>
		<p>@2014</p>
	</div>
</body>
</html>