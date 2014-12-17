<!--
  * Lanch Activity page
  * Author: Xu Yi, Feng Zhibin
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



</head>

<body>



 
<div class="container" id="detail-form">
        
        <form class="form-horizontal" id="activity-form" action="createActivity.php" method="post" enctype="multipart/form-data">
            <div class="form-group" id = "Title">“紫荆之声”活动发布系统</div>

            <div class="form-group">
                <label for="input-name" class="col-sm-2 control-label" id="label-input-name">活动名称</label>
                <div class="col-sm-10">
                    <input type="text" maxlength="26" name="name" class="form-control" id="input-name" placeholder="活动名称，如 马兰花开" autofocus>
                </div>
            </div>

            <div class="form-group">
                <label for="input-key" class="col-sm-2 control-label">活动代称</label>
                <div class="col-sm-10">
                    <input type="text" maxlength="12" name="key" class="form-control" id="input-key" placeholder="用户用于订票的活动代称，推荐使用中文(少于7个字)，如 马兰花开">
                </div>
            </div>


            <div class="form-group">
                <label for="input-place" class="col-sm-2 control-label">活动地点</label>
                <div class="col-sm-10">
                    <input type="text" name="place" class="form-control" id="input-place" placeholder="活动地点，如 大礼堂">
                </div>
            </div>

            <div class="form-group">
                <label for="input-description" class="col-sm-2 control-label">活动简介</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="description" rows="3" id="input-description" placeholder="描述，如 好看的舞台剧" row="3" style="resize: none;"></textarea>
                </div>
            </div>




            <div class="form-group">
                <label for="input-total_tickets" class="col-sm-2 control-label">总票数</label>
                <div class="col-sm-10">
                    <input type="number" name="total_tickets" class="form-control" id="input-total_tickets" min="1" placeholder="此次活动通过“紫荆之声”的发票总数，如 1000">
                </div>
            </div>

            <div class="form-group">
                <label for="input-pic_url" class="col-sm-2 control-label" min="0">抢票开始时间</label>
                
                <div class="input-group date form_datetime col-md-5" data-date="2015-01-01T05:25:07Z" data-date-format="yyyy-MM-dd-HH:ii" data-link-field="dtp_input1">
                    <input class="form-control" size="16" type="text" name="Rob-Start" value ="" id = "Rob-Start"readonly>
                    <span class="input-group-addon" id = "Remove-RS"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                </div>
                <input type="hidden" id="dtp_input1" value="" /><br/>
            </div>

            <div class="form-group">
                <label for="input-pic_url" class="col-sm-2 control-label" min="0">抢票结束时间</label>
                
                <div class="input-group date form_datetime col-md-5" data-date="2015-01-01T05:25:07Z" data-date-format="yyyy-MM-dd-HH:ii" data-link-field="dtp_input1">
                    <input class="form-control" size="16" type="text" name="Rob-End" value ="" id = "Rob-End" readonly>
                    <span class="input-group-addon" id = "Remove-RE"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                </div>
                <input type="hidden" id="dtp_input1" value="" /><br/>
            </div>     

            <div class="form-group">
                <label for="input-pic_url" class="col-sm-2 control-label" min="0">活动开始时间</label>
                
                <div class="input-group date form_datetime col-md-5" data-date="2015-01-01T05:25:07Z" data-date-format="yyyy-MM-dd-HH:ii" data-link-field="dtp_input1">
                    <input class="form-control" size="16" type="text" name="Act-Start" value ="" id = "Act-Start"readonly>
                    <span class="input-group-addon" id = "Remove-AS"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                </div>
                <input type="hidden" id="dtp_input1" value="" /><br/>
            </div>

            <div class="form-group">
                <label for="input-pic_url" class="col-sm-2 control-label" min="0">活动结束时间</label>
                
                <div class="input-group date form_datetime col-md-5" data-date="2015-01-01T05:25:07Z" data-date-format="yyyy-MM-dd-HH:ii" data-link-field="dtp_input1">
                    <input class="form-control" size="16" type="text" name="Act-End" value ="" id = "Act-End"readonly>
                    <span class="input-group-addon" id = "Remove-AE"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                </div>
                <input type="hidden" id="dtp_input1" value="" /><br/>
            </div>            


            <div class="form-group">
                <label for="input-pic_url" class="col-sm-2 control-label" min="0">活动配图</label>
                <div class="col-sm-10">
                    <input type="file" name="pic_upload" class="form-control" id="input-pic_upload" min="0" placeholder="请选择图片">
                    <div id = "Preview"></div>
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
                    <button type="submit" class="btn btn-primary" id="saveBtn">发布</button>
                    <button type="reset" class="btn btn-warning" id="resetBtn">重置</button>
                    <span id = "log"></span>
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
<script type="text/javascript" src="./js/sisyphus.min.js"></script>
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

<div>
<!--
活动名称 <?php echo $_POST["name"];?> <br> 
活动代称 <?php echo $_POST["key"];?> <br>
活动地点 <?php echo $_POST["place"];?> <br>
活动简介 <?php echo $_POST["description"];?> <br>
总票数 <?php echo $_POST["total_tickets"];?> <br>
抢票开始时间 <?php echo $_POST["Rob-Start"];?> <br>
抢票结束时间 <?php echo $_POST["Rob-End"];?> <br>
活动开始时间 <?php echo $_POST["Act-Start"];?> <br>
活动结束时间 <?php echo $_POST["Act-End"];?> <br>
活动配图 <?php print_r($_FILES["pic_upload"]);?> <br>
活动配图类型 <?php echo $_FILES["pic_upload"]["type"];?> <br>
活动配图名称 <?php echo $_FILES["pic_upload"]["name"];?> <br>
活动配图大小 <?php echo $_FILES["pic_upload"]["size"];?> <br>
活动配图信息 <?php echo $_FILES["pic_upload"]["error"];?> <br>
座位分配设置 <?php echo $_POST["seat_status"];?> <br>
-->
</div>


<div class="modal-footer">
    <p class="text-center">共青团清华大学委员会 &copy 2014</p>
</div>



</body>
</html>
