<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1">
<link rel="stylesheet" href="./lib/css/jquery.mobile-1.4.5.min.css" />
<script src="./lib/js/jquery-1.11.1.min.js"></script>
<script src="./lib/js/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>

<div data-role="page" data-theme="a">
  <div data-role="header">
    <h1>解除绑定</h1>
  </div>

  <div data-role="content">
    <?php
        require_once "./php/dataAPI.php";
        $open_id = $_GET['id'];
        $dataapi = new dataAPI();
        $data = $dataapi->getStudentId($open_id);
        if ($data['state'] == 'true'){
            $student_id = $data['message'];
            echo "<p>你当前绑定的学号是$student_id</p>";
            echo "<p>是否确认要解绑？</p>";
echo <<< EOT
    <div data-role="controlgroup" data-type="vertical">
        <a id="confirm" data-role="button">确认</a>
        <a id="cancel" data-role="button">返回</a>
    </div>
    <div id="postdata" style="display:none">method=unbind&openid=$open_id&studentid=$student_id</div>
EOT;
        }
        else{
            echo "<p>当前的微信号没有绑定学号！</p>";
echo <<< EOT
    <a id="cancel" data-role="button">关闭</a>
EOT;
        }
    ?>
  </div>

  <div data-role="footer" data-position="fixed">
  <h1>共青团清华大学委员会 &copy 2014</h1>
  </div>
</div>

<script>
$(document).on("click", "#confirm", function(){
    $.post("./php/mask.php", $("#postdata").text(), function(data){
        var result = JSON.parse(data);
        CreateMessage();
      if(result["state"] == "true"){
        $("#unbind_message").text("解绑成功，请点击上方的返回按钮返回");
        $("#confirm").css("display","none");
        $(".unbind_hint").css("display","none");
      }
      else{
        var error_message = "解绑失败,错误原因：" + result['message'] + ",请点击上方的确认按钮重试";
        $("#unbind_message").text(error_message);    
      }
    });
});

$(document).on("click", "#cancel", function(){
    WeixinJSBridge.invoke('closeWindow',{},function(res){});
});

function CreateMessage(){
  var message = $("#unbind_message");
  
  if(message.length == 0){
    var js_message = $('<p id = "unbind_message"></p>');
    $(".ui-content").append(js_message);
  }
}
</script>

</body>
</html>


