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
    <div data-role="collapsible" data-collapsed="false">
        <h1>选座</h1>
        <?php
            $seatarr = file_get_contents("./seat/" . $_GET['activityid'] . ".seat", "r");
            echo $seatarr;
        ?>
    </div>
    <ul data-role="listview" data-inset="true">
        <li> 已选座位 <span id="selected" style="color:red;"></span></li>
        <li> <span id="message">请选择座位后点击确定</span></li>
    </ul>
    <div data-role="controlgroup" data-type="vertical">
        <a href="javascript:confirm();" data-role="button" id="bconfirm">确定</a>
        <a href="javascript:unselect();" data-role="button" id="breselect">重选</a>
        <a href="javascript:update('请选择座位后点击确定');" data-role="button">刷新</a>
    </div>
  </div>
  
  <div data-role="footer" data-position="fixed" data-disable-page-zoom="false" data-fullscreen="true">
  <h1>共青团清华大学委员会 &copy 2014</h1>
  </div>
</div> 

<div id="ticketid" style="display:none;"><?php echo $_GET['ticketid'];?></div>
<div id="activityid" style="display:none;"><?php echo $_GET['activityid'];?></div>
<div id="openid" style="display:none;"><?php echo $_GET['openid'];?></div>

<script>

$(document).ready(function(){
    seatstate = Array();
    seatstate["A区"] = 1;
    seatstate["B区"] = 5;
    seatstate["C区"] = 0;
    seatstate["D区"] = 10;
    
    VC = "#00dd00"; // Valid
    IC = "#aaaaaa"; // Invalid
    SC = "#dd0000"; // Select
    
    
    
    selectedseat = "";
    selectedcolor = IC;
    setTable(parseInt($("#columns").text()));
    update("请选择座位后点击确定");
    var size = $("td").width();
    $("td").width(size);
    $("td").height(size);
    $("td p").css("display", "none");
    //tag a
    $("td a").css("text-align", "center"); 
    $("td a").css("display", "block");
    $("td a").css("width", "100%");
    $("td a").css("height", "100%");
    $("td a").css("color", "black");
    $("td a").css("font-size", "16pt");
    $("td a").css("line-height", size + "px");
});

function setTable(seats){
    if (seats > 4){
        displayname = false;
        $("#seats").css("border-spacing", "5px");
        $("td").css("border-radius", "5px");
    }
    else{
        displayname = true;
        $("#seats").css("border-spacing", "10px");
        $("td").css("border-radius", "25px");
    }
}

function select(seat){
    if (seatstate[seat.id] <= 0)
        return ;
    if (selectedseat[0] == $(seat)[0]){
        unselect();
    }
    else{
        unselect();
        selectedseat = $(seat);
        selectedcolor = $(seat).css("background-color");
        $(seat).css("background-color", SC);
        $("#selected").text($(seat)[0].id);
    }
}

function unselect(){
    $(selectedseat).css("background", selectedcolor);
    $("#selected").text("");
    selectedseat = "";
}

function draw(){
    for (var seat in seatstate){
        if (displayname){
            $("#" + seat + " a").text(seat + " - " + seatstate[seat]);
        }
        else{
            $("#" + seat + " a").text("");
        }
        if (seatstate[seat] > 0){
            $("#" + seat).css("background-color", VC);
        }
        else{
            $("#" + seat).css("background-color", IC);
        }
    }
}

function update(message){
    selectedseat = "";
    $("#message").text("正在更新座位信息...");
    $.post("./mask.php", {"method":"seatInfo", "activityid":$("#activityid").text()}, function (data){
        var result = JSON.parse(data);
        if (result["state"] == "true"){
            $("#message").text(message);
            for (var i in result["message"]){
                seatstate[result["message"][i]["location"]] = parseInt(result["message"][i]["resitual_capability"]);
            }
            draw();
        }
        else{
            $("#message").text(result["message"]);
        }
    });
}

function confirm(){
    if (selectedseat == ""){
        return ;
    }
    var seat = selectedseat[0].id;
    $("#message").text("正在处理选座请求...");
    $.post("./mask.php", {"method":"takeSeat", "ticketid":$("#ticketid").text(), "seatid":seat}, function(data){
        var result = JSON.parse(data);
        
        if (result["state"] == "true"){
            update("选座成功");
            $("#bconfirm").remove();
            $("#breselect").remove();
            location.replace("./Ticket.php?id=" + $("#ticketid").text() + "&openid=" + $("#openid").text());
        }
        else{
            update(result["message"]);
        }
    });
}

$(document).on("click", "td a", function(e){
    select(e.target.parentElement);
    return false;
});

</script>
</body>
</html>
