<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1">
<link rel="stylesheet" href="./css/jquery.mobile-1.4.5.min.css" />
<script src="./js/jquery-1.11.1.min.js"></script>
<script src="./js/jquery.mobile-1.4.5.min.js"></script>
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
        <a id="cancel" data-role="button">取消</a>
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
  <h1>共青团清华大学委员会</h1>
  <h1>&copy 2014</h1>
  </div>
</div>

<script>
$(document).on("click", "#confirm", function(){
    $.post("./mask.php", $("#postdata").text(), function(data){
      CreateMessage();
      if(data['status'] == true){
        $("#unblind_message").text("解绑成功，请点击上方的取消按钮返回");
    
        $("#confirm").css("display","none");
         $(".unblind_hint").css("display","none");
      }
      else{
        var error_message = "解绑失败," + data['message'] + ",请点击上方的取消按钮返回";
        $("#unblind_message").text(error_message);    
      }
    });
});

$(document).on("click", "#cancel", function(){
    window.close();
});

function CreateMessage(){
  var message = $("#unblind_message");
  
  if(message.length == 0){
    var js_message = $('<p id = "unblind_message"></p>');
    $(".ui-content").append(js_message);
  }
}
</script>

</body>
</html>


