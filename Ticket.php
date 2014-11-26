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

<div data-role="page" data-theme="a" id="mainpage">
  <div data-role="header" id = "ImgTop">
    <h1>购票详情</h1>
  </div>
  
  <?php
    require_once "./php/dataAPI.php";
    $dataapi = new dataAPI();
    $result = $dataapi->getTicketInfo($_GET['id']);
    $result2 = $dataapi->getActivityInfo($result['message']['activity_id']);
    if ($result['state'] == 'false' || $result2['state'] == 'false'){
echo <<< EOT
    <div data-role="content" id = "Error">
        没有查询到这张票！
    </div>
EOT;
    }
    else{
        $studentid = $result['message']['student_id'];
        if ($result['message']['state'] == 0){
            $status = "有效";
        }
        else{
            $status = "已使用";
        }
        $activityname = $result2['message']['name'];
        $activitystage = $result2['message']['stage'];
        $starttime = $result2['message']['start_time'];
        $endtime = $result2['message']['end_time'];

echo <<< EOT
  <div data-role="content" id = "TicketInfo">
    <ul data-role="listview" data-inset="true">
        <li data-role="collapsible">
            <h1>二维码电子票</h1>
            <img src="./img/qrcode_test.png" style="width:100%;height:100%"/>
        </li>
        <li> 学号 $studentid </li>
        <li> 该票状态 $status </li>
        <li> 活动名称 $activityname </li>
        <li> 活动地点 $activitystage </li>
        <li> 座位 </li>
        <li> 开始时间 $starttime </li>
        <li> 结束时间 $endtime </li>
    </ul>
    <div data-role="controlgroup" data-type="vertical">
        <a href="#" data-role="button"data-icon="info">活动详情</a>
        <a href="#" data-role="button"data-icon="search">选座</a>
        <a href="#refund" data-transition="none" data-rel="dialog" data-role="button" data-icon="delete">退票</a>
    </div>   
  </div>
EOT;
}
?>

  <div data-role="footer" data-position="fixed">
  <h1>共青团清华大学委员会 &copy 2014</h1>
  </div>
</div> 

<div data-role="page" id="refund">
    <div data-role="header">
        <h1>确认退票</h1>
    </div>
  <div data-role="content">
        <div data-role="controlgroup" data-type="vertical">
        <a href="#" data-role="button" id="refund_confirm">确认</a>
        <a href="#mainpage" data-transition="none" data-role="button">取消</a>
    </div>   
  </div>
</div>

</body>
</html>


