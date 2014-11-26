<?php
/**
  * data API for mysql
  * Author: Chen Minghai
  * Last modified: 2014.11.12
  */
class DataAPI{
	
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

		//获得活动名称
		$activity_name = mysql_fetch_row(mysql_query("SELECT name FROM activity WHERE id = $activity_id LIMIT 1"))[0];

		for ($i = 0; $i < $ticket_num; $i++){
			mysql_query("INSERT INTO ticket (state,activity_id,activity_name) VALUES (0,".$activity_id.",'".$activity_name."')");	
		}
		return (array("state" => "true", "message" => ""));
	}


	//!!state 暂时为1
    //create某项活动,包括初始化它的票
	//参数: 一个数组，各项分别是：
		/*
  		name char(60),  			#活动名称
		start_time datetime,		#活动开始时间
		end_time datetime,			#活动结束时间
		ticket_start_time datetime,	#抢票开始时间
		ticket_end_time datetime,	#抢票结束时间
		
		stage char(50),				#活动地点 "大礼堂" "新清华学堂" "综体"
		information char(200),		#附加信息
		ticket_number int(4),		#票总数
	
		ticket_per_student int(4),	#每人最大可抢票数
		is_seat_selectable int(4)	#是否可选座  0:不可选座  1:可选座
		*/
		//其中 datetime为字符串，格式如"2014-11-11 08:00:00"
	//返回: ["state", "message"]: ["true", int activity_id] or ["false", 错误信息] 
	public function createActivity($activity){
        //连接数据库
        $con = mysql_connect("db.igeek.asia","wx9","1mnd35mD050HWqOa");
        if (!$con){
            return(array("state" => "false", "message" => "数据库连接错误"));
        }
		mysql_query("SET NAMES UTF8");
		mysql_select_db("wx9_db", $con);
        $name = $activity["name"];
		$start_time = $activity["start_time"];
		$end_time = $activity["end_time"];
		$ticket_start_time = $activity["ticket_start_time"];
		$ticket_end_time = $activity["ticket_end_time"];
		$state = 1;				#五个状态：抢票前、中、结束，活动已经开始，活动结束 分别是0,1,2,3,4 
		$stage = $activity["stage"];
		$information = $activity["information"];
		$ticket_number = $activity["ticket_number"];
		$ticket_available_number = $activity["ticket_number"];
		$ticket_per_student = $activity["ticket_per_student"];
		$is_seat_selectable = $activity["is_seat_selectable"];

        //插入活动    
        if (!mysql_query("INSERT INTO activity 	(name,start_time,end_time,ticket_start_time,ticket_end_time,state,stage,information,ticket_number,ticket_available_number,ticket_per_student,is_seat_selectable)  VALUES ('".$name."','".$start_time."','".$end_time."','".$ticket_start_time."','".$ticket_end_time."',$state,'".$stage."','".$information."',$ticket_number,$ticket_available_number,$ticket_per_student,$is_seat_selectable)")){
             return(array("state" =>"false", "message" => "插入活动出错"));           
        }



        //查询此次活动分配的id
        $result_set = mysql_query("SELECT id FROM activity WHERE stage ='".$stage."'");
        if (!$result_set){
			return(array("state" =>"false", "message" => "返回活动id出错"));			
		}
        while($result =  mysql_fetch_array($result_set)){
            $activity_id = $result[0];
        }

		//添加对应的票
		$this->initTicket($ticket_number, $activity_id);

        return(array("state" => "true", "message" => $activity_id));
    }

	

	//获得活动信息
	//参数：int activity_id
	//返回: ["state", "message"]: ["true", 关联数组（见活动表）] or ["false", 错误信息] 
    //！！！信息不完善
	public function getActivityInfo($activity_id){
		//连接数据库
        $con = mysql_connect("db.igeek.asia","wx9","1mnd35mD050HWqOa");
        if (!$con){
            return(array("state" => "false", "message" => "数据库连接错误"));
        }
		mysql_select_db("wx9_db", $con);
		mysql_query("SET NAMES UTF8");
		
		if (!$result = mysql_fetch_assoc(mysql_query("SELECT * FROM activity WHERE id=$activity_id"))){
			return(array("state" => "false", "message" => "没有找到此活动"));
		}else{
			return(array("state" => "true", "message" => $result));
		}	
	}

	//获得票信息
	//参数：int ticket_id
	//返回: ["state", "message"]: ["true", 关联数组（见票表）] or ["false", 错误信息] 
    //！！！信息不完善
	public function getTicketInfo($ticket_id){
		//连接数据库
        $con = mysql_connect("db.igeek.asia","wx9","1mnd35mD050HWqOa");
        if (!$con){
            return(array("state" => "false", "message" => "数据库连接错误"));
        }
		mysql_select_db("wx9_db", $con);
		mysql_query("SET NAMES UTF8");
		
		if (!$result = mysql_fetch_assoc(mysql_query("SELECT * FROM ticket WHERE id=$ticket_id"))){
			return(array("state" => "false", "message" => "没有找到此活动"));
		}else{
			return(array("state" => "true", "message" => $result));
		}	
	}


    //建立活动座位
	//参数：int activity_id, char location（几排几列或者几区）, int capability （可选，座位容量，默认为1）
	//返回: ["state", "message"]: ["true", ""] or ["false", 错误信息] 
    //！！！信息不完善
	public function createSeat($activity_id, $location, $capability = 1){
        //连接数据库
        $con = mysql_connect("db.igeek.asia","wx9","1mnd35mD050HWqOa");
        if (!$con){
            return(array("state" => "false", "message" => "数据库连接错误"));
        }
		mysql_select_db("wx9_db", $con);
        
        //插入座位    
        if (!mysql_query("INSERT INTO seat (activity_id, location, capability,resitual_capability) VALUES (".$activity_id.","."'".$location."',".$capability.",".$capability.")")){
             return(array("state" =>"false", "message" => "插入座位出错"));           
        }

        //查询此次座位分配的id
        /*$result_set = mysql_query("SELECT id FROM seat WHERE stage='".$stage."'");
        if (!$result_set){
			return(array("state" =>"false", "message" => "返回座位id出错"));			
		}
        while($result =  mysql_fetch_array($result_set)){
            $seat_id = $result[0];
        }
		*/
        return(array("state" => "true", "message" => ""));
    }
    

	//绑定
	//参数：String openid, int student_id
	//返回: ["state", "message"]: ["true", ""] or ["false", 错误信息]
    public function bind($openId, $studentId){
        //连接数据库
        $con = mysql_connect("db.igeek.asia","wx9","1mnd35mD050HWqOa");
        if (!$con){
            return(array("state" => "false", "message" => "数据库连接错误"));
        }
		mysql_select_db("wx9_db", $con);

        $result = mysql_query("SELECT * FROM user_information WHERE openid='".$openId ."'");
		if (!empty(mysql_fetch_array($result))){
			return(array("state" => "false", "message" => "这个openId已经绑定"));			
		}
		$result = mysql_query("SELECT * FROM user_information WHERE student_id=".$studentId);
		if (!empty(mysql_fetch_array($result))){
			return(array("state" => "false", "message" => "这个studentId已经绑定"));			
		}
		mysql_query("INSERT INTO user_information (student_id, openid) VALUES (".$studentId.",'".$openId."')");
		return(array("state" => "true", "message" => ""));
    }


	//强制绑定
	//参数：String openid, int student_id
	//返回: ["state", "message"]: ["true", ""] or ["false", 错误信息]
    public function forceBinding($openId, $studentId){
        //连接数据库
        $con = mysql_connect("db.igeek.asia","wx9","1mnd35mD050HWqOa");
        if (!$con){
            return(array("state" => "false", "message" => "数据库连接错误"));
        }
		mysql_select_db("wx9_db", $con);

        $result = mysql_query("SELECT * FROM user_information WHERE openid='".$openId ."'");
		if (!empty(mysql_fetch_array($result))){
			return(array("state" => "false", "message" => "这个openId已经绑定"));			
		}

		$result = mysql_query("DELETE from user_information WHERE student_id=".$studentId);

		mysql_query("INSERT INTO user_information (student_id, openid, state) VALUES (".$studentId.",'".$openId."')");
		return(array("state" => "true", "message" => ""));
    }


    //解绑
	//参数：String openid, int student_id
	//返回: ["state", "message"]: ["true", ""] or ["false", 错误信息]
    public function unbind($openId, $studentId){
        //连接数据库
        $con = mysql_connect("db.igeek.asia","wx9","1mnd35mD050HWqOa");
        if (!$con){
            return(array("state" => "false", "message" => "数据库连接错误"));
        }
		mysql_select_db("wx9_db", $con);

		$result = mysql_query("SELECT id FROM user_information WHERE student_id=".$studentId ." AND openid='".$openId."'");
		if (empty(mysql_fetch_array($result))){
			return(array("state" => "false", "message" => "没有找到绑定记录"));
		}

		mysql_query("DELETE FROM user_information WHERE student_id=".$studentId ." AND openid='".$openId."'");
		return(array("state" => "true", "message" => ""));
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
		$result = mysql_fetch_array(mysql_query("SELECT student_id FROM user_information WHERE openid='".$openId ."'"));
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

		//获得这个活动
		$activity = mysql_fetch_array(mysql_query("SELECT state, ticket_available_number FROM activity WHERE id=$activity_id LIMIT 1"));
		if ($activity){
			if ($activity["state"] != 1){
				return(array("state" => "false", "message" =>"非抢票时间"));
			}
			if ($activity["ticket_available_number"] == 0){
				return(array("state" => "false", "message" =>"票已抢光"));
			}
		}else{
			return(array("state" => "false", "message" =>"活动不存在"));
		}
		
		//找到空票
		$result = mysql_query("SELECT id FROM ticket WHERE activity_id=".$activity_id ." AND student_id is NULL LIMIT 1");
		$ticket_found = mysql_fetch_array($result);
		$ticket_id = $ticket_found['id'];
		
		if (mysql_query("UPDATE ticket SET student_id = ".$student_id." WHERE id=".$ticket_id ." LIMIT 1")){
			//更新活动余票
			mysql_query("UPDATE activity SET ticket_available_number =".($activity['ticket_available_number']-1)."WHERE id=$activity_id LIMIT 1");
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
		if (empty($ticket=mysql_fetch_array(mysql_query("SELECT activity_id from ticket WHERE id=".$ticket_id." AND student_id = $student_id LIMIT 1")))){
			return(array("state" =>"false", "message" => "没有对应的票"));
		}

		//退票
		$result1 = mysql_query("UPDATE ticket SET student_id = null, seat_id=null, seat_location=null WHERE id=".$ticket_id." AND student_id = ".$student_id."LIMIT 1");
		$result2 = mysql_query("UPDATE activity SET ticket_available_number = ticket_available_number -1 WHERE id =$ticket[0] LIMIT 1");
		if (!$result1 || !$result2){
			return(array("state" =>"false", "message" => "退票时出错"));
		}else{
			return(array("state" => "true", "message" => ""));
		}
	}


	//查票(列表)
	//参数：int openId；第二个参数int activity_id，查此活动的票，如果没有第二个参数是查所有活动的票
	//返回: ["state", "message"]: ["true", [[int id, Stirng activity_name]]] or ["false", 错误信息] 
	//!!尚未考虑票是否已使用;未返回活动不存在的信息
	public function getTicketList($openId, $activity_id = -1){
		//连接数据库
        $con = mysql_connect("db.igeek.asia","wx9","1mnd35mD050HWqOa");
        if (!$con){
            return(array("state" => "false", "message" => "数据库连接错误"));
        }
		mysql_select_db("wx9_db", $con);
		mysql_query("SET NAMES UTF8");

		//获得student_id
		$get_student_id = $this->getStudentId($openId);
		if ($get_student_id['state'] == "true"){
			$student_id = $get_student_id['message'];
		}else{
			return(array("state" => "false", "message" => $get_student_id['message']));
		}

		$result = array();
		if ($activity_id == -1){//查询所有活动
			$result_set = mysql_query("SELECT id, activity_name FROM ticket WHERE student_id=".$student_id);
			if (!$result_set){
				return(array("state" =>"false", "message" => "查询出错"));			
			}
			while($result_row = mysql_fetch_assoc($result_set)){
				array_unshift($result, $result_row);
			}
		}else{//查询指定活动
			$result_set = mysql_query("SELECT id, activity_name FROM ticket WHERE student_id=".$student_id." AND activity_id = ".$activity_id);
			if (!$result_set){
				return(array("state" =>"false", "message" => "查询出错"));			
			}
			while($result_row = mysql_fetch_assoc($result_set)){
				array_unshift($result, $result_row);
			}
		}
		
		return(array("state" =>"true", "message" => $result));			
	}


    //选座
	//参数：int ticket_id；int seat_id
	//返回: ["state", "message"]: ["true", ""] or ["false", 错误信息] 
	//!!尚未考虑票是否已使用;未考虑openid
	public function takeSeat($ticket_id, $seat_id){
		//连接数据库
        $con = mysql_connect("db.igeek.asia","wx9","1mnd35mD050HWqOa");
        if (!$con){
            return(array("state" => "false", "message" => "数据库连接错误"));
        }
		mysql_select_db("wx9_db", $con);
    
        //验证票是否存在
        $result_set = mysql_query("SELECT * FROM ticket WHERE id=".$ticket_id);
		if (!$ticket=mysql_fetch_array($result_set)){
			return(array("state" => "false", "message" => "这张票不存在或无效"));		
		}

        //验证票是否未绑定座位  
		if ($ticket['seat_id']!=null){
			return(array("state" => "false", "message" => "错误！这张票已经选过座位了！"));	
		}
		
		
		//获取座位已选票数
		//!！未考虑票是否使用、有效等
        $result_set_2 = mysql_query("SELECT id FROM ticket WHERE seat_id=".$seat_id." AND activity_id =".$ticket['activity_id']);
        if (!$result_set_2){
			return(array("state" =>"false", "message" => "查询已选票数出错"));			
		}
        $num_seated = 0;
        while( mysql_fetch_array($result_set_2)){
            $num_seated++;
        }


		//获取座位容量
		$seat_set = mysql_query("SELECT * FROM seat WHERE id=".$seat_id);
		if (!$seat=mysql_fetch_array($seat_set)){
			return(array("state" => "false", "message" => "这个座位不存在"));		
		}

		//验证要选的座位是否有余量		 
		if($seat['capability'] <= $num_seated){//没有余量
			if ($seat['capability'] >1){  //是区域
				return(array("state" =>"false", "message" => "此区域没有余票"));
			}else{							//是座位
				return(array("state" =>"false", "message" => "此座位已经被选"));
			}
		}else{//有余量
			mysql_query("UPDATE ticket SET seat_id = ".$seat_id." WHERE id=".$ticket_id);
			return(array("state" => "true", "message" => ""));
		}

    }



    //获取单个座位信息
	//参数：int activity_id, int seat_id
	//返回: ["state", "message"]: ["true", ["seat_id", "capability", "num_seated"]] or ["false", 错误信息] 
    //    其中"seat_id", "capability", "num_seated"都是int。"capability"为座位容量，"num_seated"为此座位已选的票数
    //尚未考虑票是否已使用、取消等
	public function getSingleSeatInfo($activity_id, $seat_id){
		//连接数据库
        $con = mysql_connect("db.igeek.asia","wx9","1mnd35mD050HWqOa");
        if (!$con){
            return(array("state" => "false", "message" => "数据库连接错误"));
        }
		mysql_select_db("wx9_db", $con);
        
        //获取座位容量
        $result_set = mysql_query("SELECT capability FROM seat WHERE id=".$seat_id);
        if (!$result_set){
			return(array("state" =>"false", "message" => "查询座位容量出错"));			
		}
        $capability = mysql_fetch_array($result_set)[0];
        
        //获取已选票数
		//!！未考虑票是否使用、有效等
        $result_set = mysql_query("SELECT id FROM ticket WHERE seat_id=".$seat_id." AND activity_id =".$activity_id);
        if (!$result_set){
			return(array("state" =>"false", "message" => "查询已选票数出错"));			
		}
        $num_seated = 0;
        while( mysql_fetch_array($result_set)){
            $num_seated++;
        }
        return(array("state" => "true", "message" => array("seat_id"=>$seat_id, "capability"=>$capability, "num_seated"=>$num_seated)));     
    }
    

    //获取全部座位信息
	//参数：int activity_id
	//返回: ["state", "message"]: ["true", [["seat_id", "capability", "num_seated"]]] or ["false", 错误信息] 
    //    其中"seat_id", "capability", "num_seated"都是int。"capability"为座位容量，"num_seated"为此座位已选的票数
    //尚未考虑票是否已使用、取消等等
//使用例子：
/*
$result = $test->getSeatInfo(1);
$resultMessage = $result['message'];
if ($result['state'] == "true"){
	foreach($result['message'] as $a){
		echo($a["seat_id"].$a["capability"].$a["num_seated"]."\n");
	}
}else{
	echo($resultMessage."\n");
}*/

	public function getSeatInfo($activity_id){
		//连接数据库
        $con = mysql_connect("db.igeek.asia","wx9","1mnd35mD050HWqOa");
        if (!$con){
            return(array("state" => "false", "message" => "数据库连接错误"));
        }
		mysql_select_db("wx9_db", $con);
    
        //获得活动地点
        $result_set = mysql_query("SELECT location FROM activity WHERE id=".$activity_id);
        if (!$result_set){
				return(array("state" =>"false", "message" => "查询活动出错"));			
		}
        $location = mysql_fetch_array($result_set)[0];
        
        //根据地点取出seat列表
        $result_set = mysql_query("SELECT id FROM seat WHERE location='".$location."'");
        if (!$result_set){
				return(array("state" =>"false", "message" => "获取座位列表出错"));			
		}      
        
        $result = array();
        //对每个seat查询capability 和 num_seated
        while($result_row = mysql_fetch_array($result_set)){
            $single_result = $this->getSingleSeatInfo($activity_id, $result_row[0]);
            if ($single_result['state'] == "false"){
                return(array("state" =>"false", "message" => $single_result['message']));
            }else{
                array_unshift($result, $single_result['message']);            
            }
		}
        return(array("state" =>"true", "message" => $result));  
    }	
}
?> 

