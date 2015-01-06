<!--
  * Lanch Activity page
  * Author: Xu Yi, Feng Zhibin, Chen Minghai
  * Last modified: 2014.12.16
  * method: 
  * param: 
  * Bootstrap Version : V3
  */   
-->

<!DOCTYPE html>
<html>
<head>
    <title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<meta name="viewport" content="width=device-width"/>


<link rel="stylesheet" type="text/css" href="./css/ActivityDetail.css">
<link rel="stylesheet" type="text/css" href="./css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="./css/bootstrap-theme.css">
<link rel="stylesheet" type="text/css" href="./css/bootstrap-datetimepicker.min.css"  media="screen">
<script type="text/javascript" src="./js/jquery-1.11.1.min.js" charset="UTF-8"></script>
<script src="./js/SeatCtrl.js"></script>
<script src="./js/SeatEdit.js"></script>
</head>

<body>


<?php
    //检测是否登录，若没登录则转向登录界面
    session_start();
    if(!isset($_SESSION['name'])){
        header("Location:login.html");
        exit();
    }
    
    require_once "php/dataAPI.php";
	$data = new DataAPI();
    
    $name= "";
    $brief_name= "";
    $stage = "";
    $information = "";
    $ticket_number = "";
    $start_time = "";
    $end_time = "";
    $ticket_start_time = "";
    $ticket_end_time ="";
    $image = "";
    $ticket_per_student = 1;

    
    //初始化都可编辑
    $dis_name = "false";
    $dis_brief_name= "false";
    $dis_stage = "false";
    $dis_information = "false";
    $dis_ticket_number = "false";
    $dis_ticket_per_student = "false";
    $dis_start_time = "false";
    $dis_end_time = "false";
    $dis_ticket_start_time = "false";
    $dis_ticket_end_time = "false";
    $dis_image="false";

/*
    $is_seat_selectable;*/

    $activity_id = $_GET["id"];
    if ($activity_id != ''){
        $get_activity = $data->getActivityInfo($activity_id);
        if ($get_activity["state"] == "false"){
            echo"<h>获取活动信息失败</h>";  
            exit(0); 
        }else{
        
            $activity = $get_activity["message"];
            $state = $activity["state"];
            $name = $activity["name"];   
            $brief_name= $activity["brief_name"];
            $stage = $activity["stage"];
            $information = $activity["information"];
            $ticket_number = $activity["ticket_number"]; 
            $start_time = substr(str_replace(" ", "-",$activity["start_time"]),0,16);
            $end_time = substr(str_replace(" ", "-",$activity["end_time"]),0,16);
            $ticket_start_time = substr(str_replace(" ", "-",$activity["ticket_start_time"]),0,16);
            $ticket_end_time = substr(str_replace(" ", "-",$activity["ticket_end_time"]),0,16);
            $ticket_per_student = $activity["ticket_per_student"];
            //if (file_exists)
            $image="upload/activity".$activity_id;

            //设置不可编辑
            if($state>"0"){
                $dis_ticket_number = "true";
                $dis_ticket_start_time = "true";
            }
            if($state>"1"){
                $dis_ticket_per_student = "true";
                $dis_ticket_end_time = "true";
            }
            if($state>"2"){
                $dis_name = "true";
                $dis_brief_name= "true";
                $dis_stage = "true";
                $dis_information = "true";
                $dis_start_time = "true";
                $dis_end_time = "true";
                $dis_image="true";
            }
            
        }
    }
    
    //Get seat template
    $templatefiles = glob("./seat/*.sst");
    $templatenames = array();
    $defaultssa = 0;
    for ($i = 0; $i < count($templatefiles); ++$i){
        $tmpname = preg_replace('/^.+[\\\\\\/]/', '', $templatefiles[$i]); 
        $templatenames[$i] = substr($tmpname, 0, strlen($tmpname) - 4);
    }
    if ($activity_id != '' && file_exists("./seat/$activity_id.ssa")){
        $defaultssa = count($templatefiles) + 1;
        array_push($templatenames, "当前使用的座位图");
        array_push($templatefiles, "./seat/$activity_id.ssa");
    }
?>
 
<div class="container" id="detail-form">
        
        <form class="form-horizontal"  id="activity-form">
            <div class="form-group " id = "Title">
                    “紫荆之声”活动管理系统&nbsp&nbsp
                <a href='activity_list.php'>
                     <button type='button' class='btn btn-default btn-sm' title="返回">
			            <span class='glyphicon glyphicon-arrow-left'> </span> 
			        </button>
                </a>
                <a href='login.php?action=logout'>

                    <button type='button' class='btn btn-default btn-sm' id='aa' title="注销">
			            <span class='glyphicon glyphicon-log-out'> </span> 
			        </button>
                    
                </a>
            </div>
            <div class="form-group">
                <label for="input-name" class="col-sm-2 control-label" id="label-input-name">活动全称</label>
                <div class="col-sm-10">
                    <input type='text' maxlength='26' name='name' class='form-control' id='input-name' placeholder="活动全称，如马兰花开第一百场纪念演出" value='<?php echo "$name"; ?>' <?php if($dis_name =="true") echo "readonly" ?> autofocus>
                </div>
            </div>



            <div class="form-group">
                <label for="input-key" class="col-sm-2 control-label">活动简称</label>
                <div class="col-sm-10">
                    <input type="text" maxlength="12" name="key" class="form-control" id="input-key" placeholder="用户用于订票的活动代称，推荐使用中文(少于7个字)，如马兰花开" value='<?php echo "$brief_name"; ?>' <?php if($dis_brief_name =="true") echo "readonly" ?>>
                </div>
            </div>



            <div class="form-group">
                <label for="input-place" class="col-sm-2 control-label">活动地点</label>
                <div class="col-sm-10">
                    <input type="text" name="place" class="form-control" id="input-place" placeholder = '活动地点，如大礼堂' value='<?php echo "$stage"; ?>' <?php if($dis_stage =="true") echo "readonly" ?>>
                </div>
            </div>

            <div class="form-group">
                <label for="input-description" class="col-sm-2 control-label">活动简介</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="description" rows="3" id="input-description"  placeholder = '描述，如好看的舞台剧' row="3" style="resize: none;" <?php if($dis_information =="true") echo "readonly" ?>><?php echo "$information"; ?></textarea>
                </div>
            </div>




            <div class="form-group">
                <label for="input-total_tickets" class="col-sm-2 control-label">总票数</label>
                <div class="col-sm-10">
                    <input type="number" name="total_tickets" class="form-control" id="input-total_tickets" placeholder = '此次活动通过“紫荆之声”的发票总数，如300' min="1" value='<?php echo "$ticket_number";?>' <?php if($dis_ticket_number =="true") echo "readonly" ?>>
                </div>
            </div>

            <div class="form-group">
                <label for="input-ticket_per_student" class="col-sm-2 control-label">每人最大可选票数</label>
                <div class="col-sm-10">
                    <input type="number" name="ticket_per_student" class="form-control" id="input-ticket_per_student" min="1" placeholder = '此次活动每人最多可抢票数，如2' value='<?php echo "$ticket_per_student";?>' <?php if($dis_ticket_per_student =="true") echo "readonly" ?>>
                </div>
            </div>

            <div class="form-group">
                <label for="input-pic_url" class="col-sm-2 control-label" min="0">抢票开始时间</label>
                
                <div class="input-group date <?php if($dis_ticket_start_time =="false") echo "form_datetime" ?> col-md-5" data-date="2015-01-01T05:25:07Z" data-date-format="yyyy-MM-dd-HH:ii" data-link-field="dtp_input1">
                    <input class="form-control" size="16" type="text" name="Rob-Start"  id = "Rob-Start"readonly value=<?php echo "$ticket_start_time";?>  >
                    <?php if($dis_ticket_start_time =="false") echo 
                    "<span class='input-group-addon' id = 'Remove-RS' ><span class='glyphicon glyphicon-remove'></span></span>
                    <span class='input-group-addon' ><span class='glyphicon glyphicon-th'></span></span>"
                    ?>
                    
                </div>
                <input type="hidden" id="dtp_input1" value="" /><br/>
            </div>

            <div class="form-group">
                <label for="input-pic_url" class="col-sm-2 control-label" min="0">抢票结束时间</label>
                
                <div class="input-group date <?php if($dis_ticket_end_time =="false") echo "form_datetime" ?> col-md-5" data-date="2015-01-01T05:25:07Z" data-date-format="yyyy-MM-dd-HH:ii" data-link-field="dtp_input1">
                    <input class="form-control" size="16" type="text" name="Rob-End"  id = "Rob-End" readonly  value=<?php echo "$ticket_end_time";?>>                   
                    <?php if($dis_ticket_end_time =="false") echo 
                    "<span class='input-group-addon' id = 'Remove-RE' ><span class='glyphicon glyphicon-remove'></span></span>
                    <span class='input-group-addon' ><span class='glyphicon glyphicon-th'></span></span>"
                    ?>
                </div>
                <input type="hidden" id="dtp_input1" value="" /><br/>
            </div>     

            <div class="form-group">
                <label for="input-pic_url" class="col-sm-2 control-label" min="0">活动开始时间</label>
                
                <div class="input-group date <?php if($dis_start_time =="false") echo "form_datetime" ?> col-md-5" data-date="2015-01-01T05:25:07Z" data-date-format="yyyy-MM-dd-HH:ii" data-link-field="dtp_input1">
                    <input class="form-control" size="16" type="text" name="Act-Start"  id = "Act-Start"readonly value=<?php echo "$start_time";?>>
                    <?php if($dis_start_time =="false") echo 
                    "<span class='input-group-addon' id = 'Remove-AS' ><span class='glyphicon glyphicon-remove'></span></span>
                    <span class='input-group-addon' ><span class='glyphicon glyphicon-th'></span></span>"
                    ?>
                </div>
                <input type="hidden" id="dtp_input1" value="" /><br/>
            </div>

            <div class="form-group">
                <label for="input-pic_url" class="col-sm-2 control-label" min="0">活动结束时间</label>
                
                <div class="input-group date <?php if($dis_end_time =="false") echo "form_datetime" ?>  col-md-5" data-date="2015-01-01T05:25:07Z" data-date-format="yyyy-MM-dd-HH:ii" data-link-field="dtp_input1">
                    <input class="form-control" size="16" type="text" name="Act-End"  id = "Act-End"readonly  value=<?php echo "$end_time";?>>
                    <?php if($dis_end_time =="false") echo 
                    "<span class='input-group-addon' id = 'Remove-AE' ><span class='glyphicon glyphicon-remove'></span></span>
                    <span class='input-group-addon' ><span class='glyphicon glyphicon-th'></span></span>"
                    ?>
                </div>
                <input type="hidden" id="dtp_input1" value="" /><br/>
            </div>  

            <div class="form-group">
                <label for="input-pic_url" class="col-sm-2 control-label" min="0">活动配图</label>
                <div class="col-sm-10">
                    <input type="file" name="pic_upload" class="form-control" id="input-pic_upload" min="0" placeholder="请选择图片" <?php if($dis_image =="true") echo "readonly" ?>>
                    <div id = "Preview"><?php if(file_exists($image)) {echo "<img src=$image>";} ?></div>
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-2 control-label">座位分配模板</label>
                <div class="col-sm-10">
                <?php
                    echo "<select name='seat_status' id='input-seat_status' class='form-control' default='$defaultssa'>\n";
                ?>
                        <option value = "0">不分配座位</option>
                        <?php
                            //Show the seat templates
                            for ($i = 0; $i < count($templatenames); ++$i){
                                $val = $i + 1;
                                $tmpname = $templatenames[$i];
                                echo "<option value = '$val'>$tmpname</option>\n";
                            }
                        ?>
                    </select>
                </div>
            </div>
            
            <?php
                for ($i = 0; $i < count($templatefiles); ++$i){
                    $val = $i + 1;
                    echo "<div class='form-group seattemplate' id='canvas$val' style='display:none;' oncontextmenu='return false'>\n";
                    $ssa = file_get_contents($templatefiles[$i], "r");
                    echo $ssa;
                    echo "</div>";
                }
            ?>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" class="btn btn-primary" name ='<?php echo $activity_id ?>' <?php if ($activity_id != '') {echo "id='updateBtn'>修改";}else{echo "id='publishBtn'>发布";} ?></button>
                    <button type="submit" class="btn btn-default" id="saveBtn">暂存</button>
                    <button type="reset" class="btn btn-warning" id="resetBtn">重置</button>
                    <span id="log"></span>
                </div>
            </div>
        </form>
    </div>


<script type="text/javascript" src="./js/bootstrap.min.js"></script>
<script type="text/javascript" src="./js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="./js/locales/bootstrap-datetimepicker.en.js" charset="UTF-8"></script>
<script type="text/javascript" src="./js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
<script type="text/javascript" src="./js/ActivityDetail.js"></script>
<script type="text/javascript" src="./js/sisyphus.min.js"></script>

<div class="modal-footer">
    <p class="text-center">共青团清华大学委员会 &copy 2014</p>
</div>



<script>

function selectChangeHandler(e){
    var templates = $(".seattemplate");
    for (var i = 0; i < templates.length; ++i)
        DeleteMoveListener($(templates[i]).children()[0]);
    $(".seattemplate").css("display", "none");
    $("#input-total_tickets").attr("readonly", ""); 

    var tmpval = $("#input-seat_status").val();
    if (tmpval > 0){
        Args.curtemplate = "#canvas" + tmpval;
        $("#canvas" + tmpval).css("display", "block");
        AddMoveListener($("#canvas" + tmpval).children()[0]);
        $("#input-total_tickets").attr("readonly", ""); //Auto compute ticket number
        $("#input-total_tickets").val(CountSeatsNumber(Args.curtemplate));
    }
}

$(document).ready(function(){
    $("#input-seat_status").val($("#input-seat_status").attr("default"));
    selectChangeHandler();
    $("#input-seat_status").change(selectChangeHandler);
    
    Args.clickHandler = function(e){
        var element = $(Args.curtemplate).find("#" + e);
        if (element.attr("class") == "seat")
            element.attr("class", "invalid");
        else
            element.attr("class", "seat");
        
        $("#input-total_tickets").val(CountSeatsNumber(Args.curtemplate));
    }
    Args.selectHandler = function(e){
        var element = $(Args.curtemplate).find("#" + e);
        if (element.attr("class") == "seat")
            element.attr("class", "invalid");
        else
            element.attr("class", "seat");
        $("#input-total_tickets").val(CountSeatsNumber(Args.curtemplate));
    }
    Args.infoChangedHandler = function (e){
        $("#input-total_tickets").val(CountSeatsNumber(Args.curtemplate));
    }
    Args.mode = "select";
});





</script>


</body>
</html>
