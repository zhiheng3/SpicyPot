<?php
/**
    chenminghai
    删除活动    
*/
    require_once "php/dataAPI.php";
	$data = new DataAPI();
    $result = $data->dropActivity($_POST["id"]);
    if ($result["state"]=="true"){
        echo("success");
    }else{
        echo $result["message"];
    }
?>
