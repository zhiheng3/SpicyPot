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
<link rel="stylesheet" type="text/css" href="./css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="./css/bootstrap-theme.css">
<link rel="stylesheet" type="text/css" href="./css/bootstrap-datetimepicker.min.css"  media="screen">
</head>

<body>



 
<div class="container center">
        
        <form class="form-horizontal"  id="activity-form">
            <div class="form-group" id = "Title">“紫荆之声”活动管理系统</div>
<?php
	require_once "php/dataAPI.php";
	$test = new DataAPI();
	$gettingList =$test->getActivityList();
	if($gettingList["state"] == "false"){
		echo "<div class='form-group' id = 'Title'>获取活动列表失败</div>";
	}else{
		echo"<div class='list-group'> <div class='container'>";
        $stateList=array("抢票前","抢票中","抢票结束","活动已开始","活动结束");
        $labelList=array("info", "danger", "success", "primary", "default");
		foreach($gettingList["message"] as $activity_id){
			$result = $test->getActivityInfo($activity_id);
			if ($result["state"] != "false"){	
				$activity=$result['message'];
				$name = $activity['name'];
				$activity_id = $activity['id'];
				$state = $stateList[$activity['state']];
                $stateLabel = $labelList[$activity['state']];
				echo "
						<a href='#' class='list-group-item' onclick='getInfo($activity_id)'>
         
							<span class='col-lg-2'>$name</span>
							<span class='col-sm-2'><span class='label label-$stateLabel'>$state</span></span>
							<botton type='button' class='btn btn-default btn-sm delete' onclick='doDelete($activity_id)'>
								<span class='glyphicon glyphicon-remove'> </span> 删除
							</botton>
						</a>
            		";
			}
		}
		echo"</div></div>";
	}
?>            
        </form>
    </div>

<script type="text/javascript" src="../js/jquery-1.11.1.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="../js/locales/bootstrap-datetimepicker.en.js" charset="UTF-8"></script>
<script type="text/javascript" src="../js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
<script type="text/javascript" src="../js/ActivityDetail.js"></script>
<script type="text/javascript">
    
    function doDelete(id){
        //event.stopPropagation();
    //event.preventDefault();
        alert(id);
        <?php
           // echo"$.post('delete_activity.php',{id:id},function(data){alert(data);});";
        ?>
    }
    function getInfo(id){
        //event.stopPropagation();
    //event.preventDefault();
        alert(id+"233");
        <?php
            echo"$.post('delete_activity.php',{id:id},function(data){alert(data);});";
        ?>
    }

</script>


<div class="modal-footer">
    <p class="text-center">共青团清华大学委员会 &copy 2014</p>
</div>



</body>
</html>
