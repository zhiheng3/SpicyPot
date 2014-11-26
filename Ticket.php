<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1">
<link rel="stylesheet" type="text/css" href="./css/Ticket.css">
<link rel="stylesheet" href="./css/jquery.mobile-1.4.5.min.css" />
<script src="./js/jquery-1.11.1.min.js"></script>
<script src="./js/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>

<div data-role="page" data-theme="a" id="pageone">
  <div data-role="header" id = "ImgTop">
    <h1>购票详情</h1>
  </div>

  <div data-role="content" id = "TicketInfo">
    <ul data-role="listview" data-inset="true">
        <li data-role="collapsible">
            <h1>二维码电子票</h1>
            <p>此处是电子票</p>
        </li>
        <li> 活动地点 </li>
        <li> 座位 </li>
        <li> 活动开始时间 </li>
        <li> 活动结束结束 </li>
    </ul>
    <div data-role="controlgroup" data-type="vertical">
        <a href="#" data-role="button" data-inline="false" data-icon="info">活动详情</a>
        <a href="#" data-role="button" data-inline="false" data-icon="search">选座</a>
        <a href="#" data-role="button" data-inline="false" data-icon="delete">退票</a>
    </div>   
  </div>

  <div data-role="footer" data-position="fixed">
  <h1>共青团清华大学委员会</h1>
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


