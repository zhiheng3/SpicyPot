<!--
  * Lanch Activity page
  * Author: Xu Yi
  * Last modified: 2014.12.8
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
</head>

<body>


<?php
	require_once "php/dataAPI.php";
	$data = new DataAPI();
    
    $name= "活动全称，如马兰花开第一百场纪念演出";
    $brief_name= "用户用于订票的活动代称，推荐使用中文(少于7个字)，如马兰花开";
    $stage = "活动地点，如大礼堂";
    $information = "描述，如好看的舞台剧";
    $ticket_number = "此次活动通过“紫荆之声”的发票总数，如1000";
    $start_time = "";
    $end_time = "";
    $ticket_start_time = "";
    $ticket_end_time ="";
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
            $name = $activity["name"];   
            $brief_name= "??";
            $stage = $activity["stage"];
            $information = $activity["information"];
            $ticket_number = $activity["ticket_number"]; 
            $start_time = substr(str_replace(" ", "-",$activity["start_time"]),0,16);
            $end_time = substr(str_replace(" ", "-",$activity["end_time"]),0,16);
            $ticket_start_time = substr(str_replace(" ", "-",$activity["ticket_start_time"]),0,16);
            $ticket_end_time = substr(str_replace(" ", "-",$activity["ticket_end_time"]),0,16);
        }
    }
    
?>
 
<div class="container" id="detail-form">
        
        <form class="form-horizontal"  id="activity-form">
            <div class="form-group" id = "Title">“紫荆之声”活动发布系统</div>

            <div class="form-group">
                <label for="input-name" class="col-sm-2 control-label" id="label-input-name">活动全称</label>
                <div class="col-sm-10">
                    <input type='text' maxlength='26' name='name' class='form-control' id='input-name' placeholder=<?php echo "$name"; ?> autofocus>
                </div>
            </div>



            <div class="form-group">
                <label for="input-key" class="col-sm-2 control-label">活动简称</label>
                <div class="col-sm-10">
                    <input type="text" maxlength="12" name="key" class="form-control" id="input-key" placeholder=<?php echo "$brief_name"; ?>>
                </div>
            </div>



            <div class="form-group">
                <label for="input-place" class="col-sm-2 control-label">活动地点</label>
                <div class="col-sm-10">
                    <input type="text" name="place" class="form-control" id="input-place" placeholder=<?php echo "$stage"; ?>>
                </div>
            </div>

            <div class="form-group">
                <label for="input-description" class="col-sm-2 control-label">活动简介</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="description" rows="3" id="input-description" placeholder=<?php echo "$information"; ?> row="3" style="resize: none;"></textarea>
                </div>
            </div>




            <div class="form-group">
                <label for="input-total_tickets" class="col-sm-2 control-label">总票数</label>
                <div class="col-sm-10">
                    <input type="number" name="total_tickets" class="form-control" id="input-total_tickets" min="1" placeholder=<?php echo "$ticket_number";?>>
                </div>
            </div>

            <div class="form-group">
                <label for="input-pic_url" class="col-sm-2 control-label" min="0">抢票开始时间</label>
                
                <div class="input-group date form_datetime col-md-5" data-date="2015-01-01T05:25:07Z" data-date-format="yyyy-MM-dd-HH:ii" data-link-field="dtp_input1">
                    <input class="form-control" size="16" type="text" name="Rob-Start" value ="" id = "Rob-Start"readonly placeholder=<?php echo "$ticket_start_time";?>>
                    <span class="input-group-addon" id = "Remove-RS"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                </div>
                <input type="hidden" id="dtp_input1" value="" /><br/>
            </div>

            <div class="form-group">
                <label for="input-pic_url" class="col-sm-2 control-label" min="0">抢票结束时间</label>
                
                <div class="input-group date form_datetime col-md-5" data-date="2015-01-01T05:25:07Z" data-date-format="yyyy-MM-dd-HH:ii" data-link-field="dtp_input1">
                    <input class="form-control" size="16" type="text" name="Rob-End" value ="" id = "Rob-End" readonly placeholder=<?php echo "$ticket_end_time";?>>
                    <span class="input-group-addon" id = "Remove-RE"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                </div>
                <input type="hidden" id="dtp_input1" value="" /><br/>
            </div>     

            <div class="form-group">
                <label for="input-pic_url" class="col-sm-2 control-label" min="0">活动开始时间</label>
                
                <div class="input-group date form_datetime col-md-5" data-date="2015-01-01T05:25:07Z" data-date-format="yyyy-MM-dd-HH:ii" data-link-field="dtp_input1">
                    <input class="form-control" size="16" type="text" name="Act-Start" value ="" id = "Act-Start"readonly placeholder=<?php echo "$start_time";?>>
                    <span class="input-group-addon" id = "Remove-AS"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                </div>
                <input type="hidden" id="dtp_input1" value="" /><br/>
            </div>

            <div class="form-group">
                <label for="input-pic_url" class="col-sm-2 control-label" min="0">活动结束时间</label>
                
                <div class="input-group date form_datetime col-md-5" data-date="2015-01-01T05:25:07Z" data-date-format="yyyy-MM-dd-HH:ii" data-link-field="dtp_input1">
                    <input class="form-control" size="16" type="text" name="Act-End" value ="" id = "Act-End"readonly placeholder=<?php echo "$end_time";?>>
                    <span class="input-group-addon" id = "Remove-AE"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                </div>
                <input type="hidden" id="dtp_input1" value="" /><br/>
            </div>            


            <div class="form-group">
                <label for="input-pic_url" class="col-sm-2 control-label" min="0">活动配图</label>
                <div class="col-sm-10">
                    <input type="file" name="pic_upload" class="form-control" id="input-pic_upload" min="0" placeholder="请选择图片">
                    <div id = "Preview"><img src=""></div>
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-2 control-label">座位分配设置</label>
                <div class="col-sm-10">
                    <select name="seat_status" id="input-seat_status" class="form-control" >
                        <option value = "0">不分配座位</option>
                        <option value = "1">综体：分配B、C两入口</option>
                        <option value = "2">新清华学堂</option>
                    </select>
                </div>
            </div>



            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" onclick="publishActivity();" class="btn btn-primary" id="publishBtn">发布</button>
                    <button type="submit" class="btn btn-default" id="saveBtn">暂存</button>
                    <button type="reset" class="btn btn-warning" id="resetBtn">重置</button>
                </div>
            </div>
        </form>
    </div>

<script type="text/javascript" src="./js/jquery-1.11.1.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="./js/bootstrap.min.js"></script>
<script type="text/javascript" src="./js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="./js/locales/bootstrap-datetimepicker.en.js" charset="UTF-8"></script>
<script type="text/javascript" src="./js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
<script type="text/javascript" src="./js/ActivityDetail.js"></script>
<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        language:  'zh-CN',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    });
	$('.form_date').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });
	$('.form_time').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 1,
		minView: 0,
		maxView: 1,
		forceParse: 0
    });
</script>


<div class="modal-footer">
    <p class="text-center">共青团清华大学委员会 &copy 2014</p>
</div>



</body>
</html>
