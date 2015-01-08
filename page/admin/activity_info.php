<!--
  * Activity List page
  * Author: Chen Minghai
  * Last modified: 2014.12.10
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


<link rel="stylesheet" type="text/css" href="./css/ActivityList.css">

<link rel="stylesheet" type="text/css" href="./lib/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="./lib/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="./lib/css/bootstrap-theme.css">
<link rel="stylesheet" type="text/css" href="./lib/css/bootstrap-datetimepicker.min.css"  media="screen">
</head>

<body>



 
<div class="container center">
        
        <form class="form-horizontal"  id="activity-form">
            <div class="form-group" id = "Title">“紫荆之声”活动管理系统</div>
<?php
	require_once "php/dataAPI.php";
	$test = new DataAPI();
    echo"<h>$_POST['activity_id']</h>";
?>            
        </form>
    </div>

<script type="text/javascript" src="../lib/js/jquery-1.11.1.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="../lib/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../lib/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="../lib/js/locales/bootstrap-datetimepicker.en.js" charset="UTF-8"></script>
<script type="text/javascript" src="../lib/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
<script type="text/javascript" src="../js/ActivityDetail.js"></script>
<script type="text/javascript">

</script>


<div class="modal-footer">
    <p class="text-center">共青团清华大学委员会 &copy 2014</p>
</div>



</body>
</html>
