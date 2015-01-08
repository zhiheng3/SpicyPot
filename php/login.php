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

<?php
/**
    Author:chenminghai
*/

//退出处理


//注销登录
if($_GET['action'] == "logout"){
    session_start();
    unset($_SESSION['name']);
    header("Location: ../login.html"); 
    exit;
}

//登录处理
//登录
if(!isset($_POST['submit'])){
    exit('非法访问!');
}
$name = htmlspecialchars($_POST['username']);
$password = MD5($_POST['password']);


//检测用户名及密码是否正确
require_once "./dataAPI.php";
$dataapi = new dataAPI();
$result = $dataapi->managerLogin($name, $password);
if($result["state"]=="true"){
    //登录成功
    session_start();
    $_SESSION['name'] = $name;
    header("Location: ../activity_list.php"); 
    //确保重定向后，后续代码不会被执行 
    exit;
} else {
    exit('登录失败<a href="javascript:history.back(-1);">返回</a> 重试');
}

 


?>


</body>
</html>

