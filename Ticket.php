<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css">
<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
</head>
<body>

<div data-role="page" id="pageone">
  <div data-role="header">
    <h1>欢迎访问我的主页</h1>
  </div>

  <div data-role="content">
    <p>欢迎！</p>
    <a href="#pagetwo" data-rel="dialog">转到页面二</a>
  </div>

  <div data-role="footer">
  <h1>页脚文本</h1>
  </div>
</div> 

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


</body>
</html>


