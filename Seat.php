<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1.0">
<link rel="stylesheet" href="./css/jquery.mobile-1.4.5.min.css" />
<script src="./js/jquery-1.11.1.min.js"></script>
<script src="./js/jquery.mobile-1.4.5.min.js"></script>
<script src="./js/SeatEdit.js"></script>
<script src="./js/SeatCtrl.js"></script>
<script src="./js/Seat.js"></script>
</head>
<body>

<div data-role="page" data-theme="a" id="mainpage" >
  <div data-role="header">
    <h1>选择座位</h1>
  </div>
  
  <div data-role="content">
    <div data-role="collapsible">
        <h1>座位示意图</h1>
        <img src="./img/seat2.png" style="width:100%;height:auto"/>
    </div>
    <div data-role="collapsible" data-collapsed="false" id="thumbpos">
        <h1>选座</h1>
        <div id="canvas">
        <?php
            $ssa = file_get_contents("./seat/" . $_GET['activityid'] . ".ssa", "r");
            echo $ssa;
        ?>
        </div>
        <div data-role="controlgroup" data-type="horizontal">
            <a href="javascript:Zoom($('#svg_seat')[0], -0.25);" data-role="button" id="zoomin">放大</a>
            <a href="javascript:Zoom($('#svg_seat')[0], 0.25);" data-role="button" id="zoomout">缩小</a>
            <a href="javascript:InitViewBox($('#svg_seat')[0]);" data-role="button" id="reset">恢复</a>
        </div>
    </div>
    <ul data-role="listview" data-inset="true">
        <li> 已选座位 <span id="selected_seat" style="color:red;"></span></li>
        <li> <span id="message">请选择座位后点击确定</span></li>
    </ul>
    <div data-role="controlgroup" data-type="vertical">
        <a href="javascript:Confirm();" data-role="button" id="bconfirm">确定</a>
        <a href="javascript:Unselect();" data-role="button" id="breselect">重选</a>
        <a href="javascript:Update('请选择座位后点击确定');" data-role="button">刷新</a>
    </div>
  </div>
  
  <div data-role="footer">
  <h1>共青团清华大学委员会 &copy 2014</h1>
  </div>
</div> 

<div id="ticketid" style="display:none;"><?php echo $_GET['ticketid'];?></div>
<div id="activityid" style="display:none;"><?php echo $_GET['activityid'];?></div>
<div id="openid" style="display:none;"><?php echo $_GET['openid'];?></div>

</body>
</html>
