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
        <li> 已选座位 <span id="selected"></span></li>
    </ul>
    <div data-role="controlgroup" data-type="vertical">
        <a href="#" data-role="button">确定</a>
        <a href="javascript:unselect();" data-role="button">重选</a>
        <a href="#" data-role="button">返回</a>
    </div>
  </div>
  
  <div data-role="footer" data-position="fixed" data-disable-page-zoom="false" data-fullscreen="true">
  <h1>共青团清华大学委员会 &copy 2014</h1>
  </div>
</div> 

<script>
$(document).ready(function(){
    selectedseat = "";
    selectedcolor = "#a1a1a1";
    $("td").height($("td").width());
    $("td").css("text-align", "center");
    setTable(2);
    $("td").css("background", "#a1a1a1");
    $("#C").css("background", "#00ff00");
});

function setTable(seats){
    if (seats > 4){
    }
    else{
        $("#seats").css("border-spacing", "10px");
        $("td").css("border-radius", "25px");
    }
}

function select(seat){
    unselect();
    selectedseat = $(seat);
    selectedcolor = $(seat).css("background");
    $(seat).css("background", "#ff0000");
    $("#selected").text($(seat)[0].id);
}

function unselect(){
    $(selectedseat).css("background", selectedcolor);
    $("#selected").text("");
}

$(document).on("click", "td", function(e){
    select(e.target);
});

</script>
</body>
</html>
