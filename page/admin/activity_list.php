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
<link rel="stylesheet" type="text/css" href="./css/ActivityDetail.css">
<link rel="stylesheet" type="text/css" href="./lib/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="./lib/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="./lib/css/bootstrap-theme.css">
<link rel="stylesheet" type="text/css" href="./lib/css/bootstrap-datetimepicker.min.css"  media="screen">
<script src="./js/hint.js"></script>
</head>

<body>



 
<div class="container center">
        
        <form class="form-horizontal"  id="activity-form">
           
            <div class="form-group " id = "Title">
                    “紫荆之声”活动管理系统&nbsp&nbsp
                <a href='./php/login.php?action=logout'>
                    <botton type='button' class='btn btn-default btn-sm' id='aa' title="注销">
			            <span class='glyphicon glyphicon-log-out'> </span> 
			        </botton>
                </a>
            </div>
            <a href='ActivityDetail.php'>
                <botton type='button' class='btn btn-default btn-sm' id='aa'>
			        <span class='glyphicon glyphicon-plus'> </span> 创建活动
			    </botton>
            </a>
            <p></p>
            

<?php

    //检测是否登录，若没登录则转向登录界面
    session_start();
    if(!isset($_SESSION['name'])){
        header("Location:login.html");
        exit();
    }
    

	require_once "php/dataAPI.php";
	$test = new DataAPI();
	$gettingList =$test->getActivityList(5);
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
						<a href='ActivityDetail.php?id=$activity_id' class='list-group-item'>
         
							<span class='col-lg-2'>$name</span>
							<span class='col-sm-2'><span class='label label-$stateLabel'>$state</span></span>
							<botton type='button' class='btn btn-default btn-sm delete' id='aa' onclick='doDelete($activity_id)'>
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

<script type="text/javascript" src="./lib/js/jquery-1.11.1.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="./lib/js/bootstrap.min.js"></script>
<script type="text/javascript" src="./lib/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="./lib/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
<script type="text/javascript">
    $(".delete").click(function(event){
        return false;
    });
    
    function doDelete(id){
        ShowHintBox("正在删除活动，请稍候......");
        <?php
            echo"$.post('./php/mask.php',{id:id, method: \"deleteActivity\"},function(data){HideHintBox(data, 1.5); setTimeout(function(){location.reload(true);}, 1500)});";
        ?>
    }

    

</script>


<div class="modal-footer">
    <p class="text-center">共青团清华大学委员会 &copy 2014</p>
</div>



</body>
</html>
