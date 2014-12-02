<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1">
<link rel="stylesheet" type="text/css" href="./css/Ticket.css">
<link rel="stylesheet" href="./css/jquery.mobile-1.4.5.min.css" />
<script src="./js/jquery-1.11.1.min.js"></script>
<script src="./js/jquery.mobile-1.4.5.min.js"></script>
<script> var tmphref = location.href; </script>
</head>
<body>

<div data-role="page" data-theme="a" id="mainpage">
  <div data-role="header" id = "ImgTop">
    <h1>购票详情</h1>
  </div>

  
  <?php
    require_once "./lib/phpqrcode.php";
    require_once "./php/dataAPI.php";
    $dataapi = new dataAPI();
    $verify = $dataapi->getStudentId($_GET['openid']);
    $result = $dataapi->getTicketInfo($_GET['id']);
    $activityid = $result['message']['activity_id'];
    $result2 = $dataapi->getActivityInfo($activityid);
    $studentid = $result['message']['student_id'];
    if ($result['state'] == 'false' || $result2['state'] == 'false' || $studentid != $verify['message']){
echo <<< EOT
    <div data-role="content" id = "Error">
        没有查询到这张票！
    </div>
EOT;
    }
    else{
        if ($result['message']['state'] == 0){
            $status = "有效";
        }
        else{
            $status = "已使用";
        }
/*
        //Generate a QR Code
        //$qrcodeInfo = $studentid . "\n" . $_GET['id'];
        //$qrcodeName = "./qrcode/{$_GET['id']}.png";
        $qrcodeInfo = "test";
        $qrcodeName = "./qrcode/test.png";
        $errorCorrectionLevel = "L";
        $matrixPointSize = 4;
        QRCode::png($qrcodeInfo, $qrcodeName, $errorCorrectionLevel, $matrixPointSize, 2);
*/

        $activityname = $result2['message']['name'];
        $activitystage = $result2['message']['stage'];
        $starttime = $result2['message']['start_time'];
        $endtime = $result2['message']['end_time'];
        $open_id = $_GET['openid'];
        $ticket_id = $_GET['id'];
        if($result2['message']['is_seat_selectable'] == 0){
            $seatInfo = "本活动不需要选座";
        }
        else{
            if($result['message']['seat_location']){
                $seatInfo = $result['message']['seat_location'];
            }
            else $seatInfo = "该活动需要选座，请在下方进行选座操作";
        }

echo <<< EOT
  <div data-role="content" id = "TicketInfo">
    <ul data-role="listview" data-inset="true">
        <li data-role="collapsible">
            <h1>二维码电子票</h1>
EOT;
           echo "<img src=\"./qrcode/{$_GET['id']}.png\" style=\"width:100%;height:auto\"/>";
echo <<< EOT
        </li>
        <li> 学号 $studentid </li>
        <li> 该票状态 $status </li>
        <li> 活动名称 $activityname </li>
        <li> 活动地点 $activitystage </li>
        <li> 座位 $seatInfo </li>
        <li> 开始时间 $starttime </li>
        <li> 结束时间 $endtime </li>
    </ul>
    <div data-role="controlgroup" data-type="vertical">
        <a href="./Activity.php?id=$activityid" data-ajax="false" data-role="button" data-icon="info">活动详情</a>
EOT;
        if(!$result['message']['seat_location'] && $result2['message']['is_seat_selectable'] == 1){
echo <<< EOT
        <a href="./Seat.php?activityid=$activityid&ticketid=$ticket_id&openid=$open_id" data-ajax="false" data-role="button" data-icon="grid">选座</a>
EOT;
        }
echo <<< EOT
        <a href="#refund" data-transition="none" data-rel="dialog" data-role="button" data-icon="delete">退票</a>
    </div>
    <div id="postdata" style="display:none">method=refundTicket&openid=$open_id&ticketid=$ticket_id</div>
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
        <h1 id = "TicketBack">确认退票</h1>
    </div>
  <div data-role="content">
        <div data-role="controlgroup" data-type="vertical">
        <a href="#" data-role="button" id="refund_confirm">确认</a>
        <a href="#mainpage" data-transition="none" data-role="button">取消</a>
    </div>   
  </div>
</div>

<div data-role="page" data-theme="a" id="refundsuccess">
    <div data-role="header">
        <h1>退票成功</h1>
    </div>
    <div data-role="content">
        <a href="javascript:WeixinJSBridge.invoke('closeWindow',{},function(res){});" data-role="button">返回</a>
    </div>
    <div data-role="footer" data-position="fixed">
        <h1>共青团清华大学委员会 &copy 2014</h1>
    </div>
</div>

<div data-role="page" data-theme="a" id="refundfail">
    <div data-role="header">
        <h1>退票失败</h1>
    </div>
    <div data-role="content">
        <a href="#mainpage" data-transition="none" data-role="button">返回</a>
    </div>
    <div data-role="footer" data-position="fixed">
        <h1>共青团清华大学委员会 &copy 2014</h1>
    </div>
</div>

<script>
    $(document).on("click", "#refund_confirm", function(){
    $.post("./mask.php", $("#postdata").text(), function(data){
        var result = JSON.parse(data);
        if(result["state"] == "true"){
            location.href = tmphref + "#refundsuccess";
        }
        else{
            location.href = tmphref + "#refundfail";
        }
    });
});

</script>

</body>
</html>


