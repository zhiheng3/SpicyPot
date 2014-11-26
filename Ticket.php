<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1">
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css">
<link rel="stylesheet" type="text/css" href="./css/Ticket.css">
<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
</head>
<body>

<div data-role="page" id="pageone">
  <div data-role="header" id = "ImgTop">
    <h1>Tsinghua</h1>
  </div>

  <div data-role="content" id = "TicketInfo">
    <p id = "ETicket"></p>
    <p id = "ActivityName">XXX E-Ticket</p>
    <p id = "ActivityPlace">活动地点：综体</p>
    <p id = "ActivitySeat">座位：11排11座</p>
    <p id = "ActivityStart">活动开始时间：2014年11月11日09时00分</p>
    <p id = "ActivityEnd">活动结束时间：2014年11月11日11时30分</p>
    <p><a href="#" data-role="button" data-inline="true" data-icon="info">活动详情</a></p>
    <p><a href="#" data-role="button" data-inline="true" data-icon="search">选座</a></p>
    <p><a href="#" data-role="button" data-inline="true" data-icon="delete">退票</a></p>   
  </div>

  <div data-role="footer">
  <h1>清华大学共青团委</h1>
  <h1>&copy 2014</h1>
  </div>
</div> 

<!--
<div data-role="page" id="pagetwo">
  <div data-role="header">
    <h1>我是一个对话框！</h1>
  </div>

  <div data-role="content">
    <p>对话框与普通页面不同，它显示在当前页面的顶端。它不会横跨整个页面宽度。对话框页眉中的图标 “X” 可关闭对话框。</p>
    <a href="#pageone">转到页面一</a>
  </div>

  <div data-role="footer">
  <h1>页脚文本</h1>
  </div>
</div> 
-->

</body>
</html>


