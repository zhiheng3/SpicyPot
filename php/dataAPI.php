<?php
/**
  * data API for mysql
  * Author: Chen Minghai
  * Last modified: 2014.11.12
  */
class DataAPI{
    
    
    //绑定或解绑
	//参数：int ticket_num(票的总数), int activity_id
	//返回: ["state", "message"]: ["true", ""] or ["false", 错误信息]
    public function binding($openId, $studentId, $type){
        //连接数据库
        $con = mysql_connect("db.igeek.asia","wx9","1mnd35mD050HWqOa");
        if (!$con){
            return(array("state" => "false", "message" => "数据库连接错误"));
        }
		mysql_select_db("wx9_db", $con);

		
        if ($type == "binding"){//绑定
            $result = mysql_query("SELECT * FROM user_information WHERE openid='".$openId ."' AND state = 1");
			if (!empty(mysql_fetch_array($result))){
				return(array("state" => "false", "message" => "这个openId已经绑定"));			
			}
			$result = mysql_query("SELECT * FROM user_information WHERE student_id=".$studentId ." AND state = 1");
			if (!empty(mysql_fetch_array($result))){
				return(array("state" => "false", "message" => "这个studentId已经绑定"));			
			}
			mysql_query("INSERT INTO user_information (student_id, openid, state) VALUES (".$studentId.",'".$openId."',1)");
			return(array("state" => "true", "message" => ""));
        }else{
			if ($type == "unbinding"){//解除绑定
				$result = mysql_query("SELECT * FROM user_information WHERE student_id=".$studentId ." AND state = 1 AND openid='".$openId."'");
				if (empty(mysql_fetch_array($result))){
					return(array("state" => "false", "message" => "没有找到绑定记录"));
				}
				mysql_query("UPDATE user_information SET state = 0 WHERE student_id=".$studentId ." AND openid='".$openId."'");
				return(array("state" => "true", "message" => ""));
			}else{
				return(array("state" => "false", "message" => "错误的type值"));
			}
		}
    }



	//初始化某项活动的票
	//参数：int ticket_num(票的总数), int activity_id
	//返回: ["state", "message"]: ["true", ""] or ["false", 错误信息] 
	public function initTicket($ticket_num, $activity_id){
        //连接数据库
        $con = mysql_connect("db.igeek.asia","wx9","1mnd35mD050HWqOa");
        if (!$con){
            return(array("state" => "false", "message" => "数据库连接错误"));
        }
		mysql_select_db("wx9_db", $con);

		for ($i = 0; $i < $ticket_num; $i++){
			mysql_query("INSERT INTO ticket (activity_id) VALUES (".$activity_id.")");	
		}
		return (array("state" => "true", "message" => ""));
	}

	//根据openid获得student_id
	//参数：int openId
	//返回: ["state", "message"]: ["true", int student_id] or ["false", 错误信息] 
	public function getStudentId($openId){
		$con = mysql_connect("db.igeek.asia","wx9","1mnd35mD050HWqOa");
        if (!$con){
            return(array("state" => "false", "message" => "数据库连接错误"));
        }
		mysql_select_db("wx9_db", $con);
		$result = mysql_fetch_array(mysql_query("SELECT student_id FROM user_information WHERE openid='".$openId ."' AND state = 1"));
		if (empty($result)){
			return(array("state" =>"false", "message" => "没有对应的学生"));
		}
		return(array("state" =>"true", "message" => $result[0]));
	}

	//抢票
	//参数：int openId, int activity_id
	//返回: ["state", "message"]: ["true", int ticket_id] or ["false", 错误信息] 
	public function takeTicket($openId, $activity_id){
		//连接数据库
        $con = mysql_connect("db.igeek.asia","wx9","1mnd35mD050HWqOa");
        if (!$con){
            return(array("state" => "false", "message" => "数据库连接错误"));
        }
		mysql_select_db("wx9_db", $con);

		//获得student_id
		$get_student_id = $this->getStudentId($openId);
		if ($get_student_id['state'] == "true"){
			$student_id = $get_student_id['message'];
		}else{
			return(array("state" => "false", "message" => $get_student_id['message']));
		}

		$result = mysql_query("SELECT id FROM ticket WHERE activity_id=".$activity_id ." AND student_id is NULL");
		$ticket_found = mysql_fetch_array($result);
		if (empty($ticket_found)){
			return(array("state" => "false", "message" =>"票已抢光"));
		}
		$ticket_id = $ticket_found[0];
		if (mysql_query("UPDATE ticket SET student_id = ".$student_id." WHERE id=".$ticket_id)){
			return (array("state" => "true", "message" => $ticket_id));
		}else{
			return (array("state" => "true", "message" => "抢票时发生错误"));
		} 
	}

	//退票
	//参数：int openId, int ticket_id
	//返回: ["state", "message"]: ["true", ""] or ["false", 错误信息]   
	public function refundTicket($openId, $ticket_id){
		//连接数据库
        $con = mysql_connect("db.igeek.asia","wx9","1mnd35mD050HWqOa");
        if (!$con){
            return(array("state" => "false", "message" => "数据库连接错误"));
        }
		mysql_select_db("wx9_db", $con);

		//获得student_id
		$get_student_id = $this->getStudentId($openId);
		if ($get_student_id['state'] == "true"){
			$student_id = $get_student_id['message'];
		}else{
			return(array("state" => "false", "message" => $get_student_id['message']));
		}

		//查询符合的票
		if (empty(mysql_fetch_array(mysql_query("SELECT * from ticket WHERE id=".$ticket_id." AND student_id = ".$student_id)))){
			return(array("state" =>"false", "message" => "没有对应的票"));
		}

		//退票
		$result = mysql_query("UPDATE ticket SET student_id = null WHERE id=".$ticket_id." AND student_id = ".$student_id);
		if (!$result){
			return(array("state" =>"false", "message" => "退票时出错"));
		}else{
			return(array("state" => "true", "message" => ""));
		}
	}


	//查票
	//参数：int openId；第二个参数int activity_id，查此活动的票，如果没有第二个参数是查所有活动的票
	//返回: ["state", "message"]: ["true", [int ticket_id]] or ["false", 错误信息] 
	//!!尚未考虑票是否已使用;未返回活动不存在的信息
	public function getTicketInfo($openId, $activity_id = -1){
		//连接数据库
        $con = mysql_connect("db.igeek.asia","wx9","1mnd35mD050HWqOa");
        if (!$con){
            return(array("state" => "false", "message" => "数据库连接错误"));
        }
		mysql_select_db("wx9_db", $con);
		
		//获得student_id
		$get_student_id = $this->getStudentId($openId);
		if ($get_student_id['state'] == "true"){
			$student_id = $get_student_id['message'];
		}else{
			return(array("state" => "false", "message" => $get_student_id['message']));
		}

		$result = array();
		if ($activity_id == -1){//查询所有活动
			$result_set = mysql_query("SELECT id FROM ticket WHERE student_id=".$student_id);
			if (!$result_set){
				return(array("state" =>"false", "message" => "查询出错"));			
			}
			while($result_row = mysql_fetch_array($result_set)){
				array_unshift($result, $result_row[0]);
			}
		}else{//查询指定活动
			$result_set = mysql_query("SELECT id FROM ticket WHERE student_id=".$student_id." AND activity_id = ".$activity_id);
			if (!$result_set){
				return(array("state" =>"false", "message" => "查询出错"));			
			}
			while($result_row = mysql_fetch_array($result_set)){
				array_unshift($result, $result_row[0]);
			}
		}
		
		return(array("state" =>"true", "message" => $result));			
	}

	
}
$test = new DataAPI();
//echo($test->getStudentId("openid000000000000000003")["message"]."\n");
//echo($test->binding("openid000000000000000001", 2012010001, "binding")."\n");
//echo($test->binding("openid000000000000000002", 2012010002, "binding")."\n");
//echo($test->binding("openid000000000000000001", 2012010003, "binding")."\n");
//echo($test->initTicket(3, 2)['state']."\n");
//echo($test->takeTicket("openid000000000000000001", 1)['message']."\n");
//echo($test->takeTicket("openid000000000000000002", 1)['message']."\n");
//echo($test->takeTicket("openid000000000000000002", 1)['message']."\n");
//echo($test->takeTicket("openid000000000000000002", 2)['message']."\n");
//echo($test->refundTicket("openid000000000000000002", 3)['message']."\n");
$result = $test->getTicketInfo("openid000000000000000002");
$resultMessage = $result['message'];
if ($result['state'] == "true"){
	for ($i = 0; $i < count($resultMessage);$i++){
		echo($resultMessage[$i]."\n");
	}
}else{
	echo($resultMessage."\n");
}


//echo($test->refundTicket("openid000000000000000002", 6)['message']."\n");
//echo($test->refundTicket("openid000000000000000002", 6)['message']."\n");
//echo($test->refundTicket("openid000000000000000001", 6)['message']."\n");
//echo($test->refundTicket("openid000000000000000001", 6)['message']."\n");
?> 

