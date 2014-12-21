<?php
/**
    chenminghai
    删除活动    
*/

    //检测是否登录
    session_start();
    if(!isset($_SESSION['name'])){
        echo "please login";
        exit();
    }

    require_once "php/dataAPI.php";
	$data = new DataAPI();
    $result = $data->dropActivity($_POST["id"]);
    if ($result["state"]=="true"){
        echo("success");
    }else{
        echo $result["message"];
    }
?>
