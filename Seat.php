<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=2.0, user-scalable=yes">
<link rel="stylesheet" href="./css/jquery.mobile-1.4.5.min.css" />
<script src="./js/jquery-1.11.1.min.js"></script>
<script src="./js/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>

<div data-role="page" data-theme="a" id="mainpage" >
  <div data-role="header" data-position="fixed" data-disable-page-zoom="false">
    <h1>选择座位</h1>
  </div>
  
  <div data-role="content">
    <div data-role="collapsible">
        <h1>座位示意图</h1>
        <img src="./img/seat2.png" style="width:100%;height:auto"/>
    </div>
    请选择座位后点击确定按钮。
    <div data-role="controlgroup" data-type="vertical">
        <a href="#" data-role="button">确定</a>
        <a href="#" data-role="button">重选</a>
        <a href="#" data-role="button">返回</a>
    </div>
  </div>
  
  <div data-role="footer" data-position="fixed" data-disable-page-zoom="false" data-fullscreen="true">
  <h1>共青团清华大学委员会 &copy 2014</h1>
  </div>
</div> 
</body>
</html>
