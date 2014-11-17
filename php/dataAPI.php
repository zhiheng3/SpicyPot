<?php
/**
  * data API for mysql
  * Author: Chen Minghai
  * Last modified: 2014.11.12
  */
class DataAPI{
    //Author: Chen Minghai
    //Binding or unbinding process
    //params: string $openId string $studentId string $type("binding" or "unbinding")
    //return: string $message("success" for success)
    //Test: No
    public function binding($openId, $studentId, $type){
        $con = mysql_connect("db.igeek.asia","wx9","1mnd35mD050HWqOa");
        if (!$con){
            die('无法连接数据库: ' . mysql_error());
        }
        mysql_select_db("wx9_db", $con);
        if ($type == "binding"){
            $result = mysql_query("SELECT * FROM user_information WHERE openid='".$openId ."' AND state = 1");
            if (!empty(mysql_fetch_array($result))){
                return("该微信账号已经被绑定");            
            }
            $result = mysql_query("SELECT * FROM user_information WHERE student_id=".$studentId ." AND state = 1");
            if (!empty(mysql_fetch_array($result))){
                return("该学号已经被绑定");            
            }
            mysql_query("INSERT INTO user_information (student_id, openid, state) VALUES (".$studentId.",'".$openId."',1)");
            return("绑定成功");
        }
        else{
            if ($type == "unbinding"){
                $result = mysql_query("SELECT * FROM user_information WHERE student_id=".$studentId ." AND state = 1 AND openid='".$openId."'");
                if (empty(mysql_fetch_array($result))){
                    return("该微信账号尚未绑定");
                }
                mysql_query("UPDATE user_information SET state = 0 WHERE student_id=".$studentId ." AND openid='".$openId."'");
                return("解绑成功");
            }
            else{
                return("错误的数据类型");
            }
        }
    }
}

?>
