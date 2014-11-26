drop database wx9_db;

create database wx9_db
CHARACTER SET utf8 
DEFAULT CHARACTER 
SET utf8 COLLATE utf8_general_ci 
DEFAULT COLLATE utf8_general_ci;

use wx9_db;

#学生表
create table user_information(
id int(4) not null primary key auto_increment,
student_name char(20),		#学生姓名
student_id int(4),		#学号
openid char(50),		#openid
);

#活动表
create table activity(
id int(4) not null primary key auto_increment,
name char(60),			#活动名称
start_time datetime,		#活动开始时间
end_time datetime,		#活动结束时间
state int(4),			#五个状态：抢票前、中、结束，活动已经开始，活动结束 分别是0,1,2,3,4 
stage char(50),			#活动地点 0:大礼堂  1:新清华学堂  2:综体
information char(200),		#附加信息
ticket_start_time datetime,	#抢票开始时间
ticket_end_time datetime,	#抢票结束时间
ticket_number int(4),		#票总数
ticket_available_number int(4),	#票余量
ticket_per_student int(4),	#每人最大可抢票数
is_seat_selectable int(4)	#是否可选座  0:不可选座  1:可选座
#seat_map_id int(4),		#座位图id 
);

#活动座位信息表（跟活动有关）
create table seat( 		
id int(4) not null primary key auto_increment,
activity_id int(4),		#对应的活动id
resitual_capability int(4),	#此座位剩余容量
#stage char(50),		#座位所在的场所
location char(50),		#座位的位置（排、列）
#available bool,		#是否可选
capability int(4)		#此座位容量（单人座为1,区域可设置）
);


#固定座位信息表（每个场所的座位固定）
#create table seat_base(
#id int(4) not null primary key auto_increment,
#stage char(50),			#座位所在的场所
#location char(50),		#座位的位置（排、列）
#capability int(4)		#此座位容量（单人座为1,区域可设置）
#);

#票信息表
create table ticket(
id int(4) not null primary key auto_increment,
state int(4),			#两个状态：0未入场，1已入场
activity_id int(4),		#活动id
activity_name char(60),		#活动名称
seat_id int(4),			#座位id
seat_location char(50),		#座位的位置（排、列）
student_id int(4)		#学号
);

