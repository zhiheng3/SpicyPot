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
<link rel="stylesheet" href="./css/jquery.mobile-1.4.5.min.css" />
<script src="./js/jquery-1.11.1.min.js"></script>
<script src="./js/jquery.mobile-1.4.5.min.js"></script>
<title>活动详情</title>
</head>
<body>
	<div id = "ImgTop">
		<img src="./img/newlogo.jpg">
	</div>
    <?php
        require_once "./php/dataAPI.php";
        $dataapi = new dataAPI();
        $result = $dataapi->getActivityInfo($_GET['id']);
        $remain = 0;
        if ($result['state'] == 'true'){
            $activity = $result['message']['name'];
            $remain = $result['message']['ticket_available_number'];
            $location = $result['message']['stage'];
            $startTime = $result['message']['ticket_start_time'];
            $endTime = $result['message']['ticket_end_time'];
        }
    ?>
	<div data-role="page" data-theme="a" id="pageone">
		<div data-role="header" id = "ImgTop">
	    	<h1><?php echo $activity;?></h1>
	  	</div>

	<div data-role="content" id = "TicketInfo">
	    <ul data-role="listview" data-inset="true">
	    	<li id = "Rob-Start">离抢票开始还有</li>
	    	<li id = "Rob-End">离抢票结束还有</li>
	    	<li id = "Act-Start">离活动开始还有</li>
	    	<li id = "Act-End">离活动结束还有</li>
	    	<li id = "END">活动已经结束</li>
	    	<li>
	    		<div id = "Time-Left">
					<div class = "Number-Left" id = "Day-Left"></div>
					<div class = "Text-Title">天</div>

					<div class = "Number-Left" id = "Hor-Left"></div>
					<div class = "Text-Title">时</div>

					<div class = "Number-Left" id = "Min-Left"></div>
					<div class = "Text-Title">分</div>

					<div class = "Number-Left" id = "Sec-Left"></div>
					<div class = "Text-Title">秒</div>

					<div class = "Clearfix"></div>
				</div>
	    	</li>
	       	<li>抢票开始时间：<span id = "RobStartTime"></span></li>
	       	<li>抢票结束时间：<span id = "RobEndTime"></span></li>
	       	<li>当前余票: <span id = "TicketLeft"><?php echo $remain;?></span> 张</li>
	        <li id = "ActivityPlace">活动地点：<?php echo $location;?></li>
	        <li>活动开始时间：<span id = "ActivityStartTime"><?php echo $startTime;?></span></li>
	        <li>活动结束时间：<span id = "ActivityEndTime"><?php echo $endTime;?></span></li>
	         <li data-role="collapsible">
	            <h1>活动预览</h1>
	            <p>暂无图片</p>
	        </li>
	    </ul>
 
	 </div>

  <div data-role="footer" data-position="fixed">
	  <h1>共青团清华大学委员会 &copy 2014</h1>
  </div>
</div> 

</body>
</html>
