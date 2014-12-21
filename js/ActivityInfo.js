/**
  * Activity Activitt Info Control page
  * Description : font-size adjust
  *               count down
  * Author: Xu Yi
  * Last modified: 2014.12.18
  * method:
  * param:
*/

$(document).ready(function(){

	//SetActivityPlace("综体");
	//SetTimeInfoDivWidth();
	//SetTimeLeftWidth();
	//SetTimeInfoDivHeight();
    ResetAll();
    StartCountDown();
    AdjustFontSize();

});

function StartCountDown(){
    
    $('#Time-Left').flipcountdown({
        size:'sm',
        tick:function(){
            var nol = function(h){
                return h>9?h:'0'+h;
            }

            var now = new Date(); 

            var AS = $("#ActivityStartTime").text();
            var AE = $("#ActivityEndTime").text();
            var RS = $("#RobStartTime").text();
            var RE = $("#RobEndTime").text();

            var RobStartTime = parseDate(RS);
            var RobEndTime = parseDate(RE);
            var ActStartTime = parseDate(AS);
            var ActEndTime = parseDate(AE);

            var endDate;
            if(now < RobStartTime){
                ResetAll();
                endDate = RobStartTime;
                $("#Rob-Start").css("display","block");
            }

            else if((now >= RobStartTime) && (now < RobEndTime)){
                ResetAll();
                endDate = RobEndTime;
                $("#Rob-End").css("display","block");
            }

            else if((now >= RobEndTime) && (now < ActStartTime)){
                ResetAll();
                endDate = ActStartTime;
                $("#Act-Start").css("display","block");
            }

            else if((now >= ActStartTime) && (now < ActEndTime)){
                ResetAll();
                endDate = ActEndTime;
                $("#Act-End").css("display","block");
            }
            else{
                ResetAll();
                $("#END").css("display","block");
                $("#Time-Left").css("display","none");
                $("#Time-Left").parent().css("display","none");
                return;
            }
            var NY = Math.round(endDate.getTime()/1000);

            var range   = NY-Math.round((new Date()).getTime()/1000),
                secday  = 86400, sechour = 3600,
                days    = parseInt(range/secday),
                hours   = parseInt((range%secday)/sechour),
                min     = parseInt(((range%secday)%sechour)/60),
                sec     = ((range%secday)%sechour)%60;
            return nol(days)+' '+nol(hours)+' '+nol(min)+' '+nol(sec);
        }
    });

}

function SetCountDown(){
    var now = new Date(); 

    var AS = $("#ActivityStartTime").text();
    var AE = $("#ActivityEndTime").text();
    var RS = $("#RobStartTime").text();
    var RE = $("#RobEndTime").text();

    var RobStartTime = parseDate(RS);
    var RobEndTime = parseDate(RE);
    var ActStartTime = parseDate(AS);
    var ActEndTime = parseDate(AE);

    var endDate;

    if(now < RobStartTime){
        ResetAll();
        endDate = RobStartTime;
        $("#Rob-Start").css("display","block");
    }

    else if((now >= RobStartTime) && (now < RobEndTime)){
        ResetAll();
        endDate = RobEndTime;
        $("#Rob-End").css("display","block");
    }

    else if((now >= RobEndTime) && (now < ActStartTime)){
        ResetAll();
        endDate = ActStartTime;
        $("#Act-Start").css("display","block");
    }

    else if((now >= ActStartTime) && (now < ActEndTime)){
        ResetAll();
        endDate = ActEndTime;
        $("#Act-End").css("display","block");
    }
    else{
        ResetAll();
        $("#END").css("display","block");
        $("#Time-Left").css("display","none");
        $("#Time-Left").parent().css("display","none");
        return;
    }

    //var endDate = new Date(Time.year,Time.month,Time.day,Time.hour,Time.min,Time.sec); 
    var leftTime = endDate.getTime() - now.getTime(); 
    var leftsecond = parseInt(leftTime / 1000); 
    
    var day = Math.floor(leftsecond / (60 * 60 * 24)); 
    var hour = Math.floor((leftsecond - day * 24 * 60 * 60) / 3600); 
    var minute = Math.floor((leftsecond - day * 24 * 60 * 60 - hour * 3600) / 60); 
    var second = Math.floor(leftsecond - day* 24 * 60 * 60 - hour * 3600 - minute * 60); 

    $("#Day-Left").text(day);
    $("#Hor-Left").text(hour);
    $("#Min-Left").text(minute);
    $("#Sec-Left").text(second);
}

function ResetAll(){
    $("#Rob-Start").css("display","none");
    $("#Rob-End").css("display","none");
    $("#Act-Start").css("display","none");
    $("#Act-End").css("display","none");
    $("#END").css("display","none");

}

function parseDate(date){
    re = /(\d+)\-(\d+)\-(\d+)\s(\d+)\:(\d+)/g;
    if(re.test(date)){
        return(new Date(RegExp.$1,(RegExp.$2-1),RegExp.$3,RegExp.$4,RegExp.$5));
    }
}

function AdjustFontSize(){
    var width = document.body.scrollWidth;
    
    if(width < 370){
        $("#TicketInfo").css("font-size","0.9em");
    }
}

function SetActivityTime(strat,end){

}

function SetActivityPlace(place){
	$("#ActivityPlace").text(place);
}

function SetTimeInfoDivWidth()
{
	
    var wi = document.body.scrollWidth;
    var js_generalTitle = $(".General-Title");
    var js_generalBox = $(".General-Box");
    var js_timeLeft = $("#Time-Left");
   
    if(wi*0.8<=400)
    {
    	js_generalTitle.css("width",wi*0.8);
    	js_generalBox.css("width",wi*0.8);
    	js_timeLeft.css("width",wi*0.78);
    }
    else if(wi*0.8>400&&wi*0.8<550){
    	js_generalTitle.css("width",300);
        js_generalBox.css("width",300);
        js_timeLeft.css("width",300);
    }
    else if(wi*0.8>=550&&wi*0.8<1000){
    	js_generalTitle.css("width",500);
    	js_generalBox.css("width",500);
    	js_timeLeft.css("width",320);
    }
    else if(wi*0.8>=1000&&wi*0.8<2000){
    	js_generalTitle.css("width",1000);
    	js_generalBox.css("width",1000);
    	js_timeLeft.css("width",320);
    }
    else {
    	js_generalTitle.css("width",2000);
    	js_generalBox.css("width",2000);
    	js_timeLeft.css("width",320);
    }
    

}
function SetTimeLeftWidth()
{
	var wi = document.body.scrollWidth;
	var js_numberLeft = $(".Number-Left");
    var js_textTitle = $(".Text-Title");
    if(wi>700){
    	js_numberLeft.css("width",40);
    	js_numberLeft.css("margin-left",0);
    	js_numberLeft.css("margin-right",0);
    	js_textTitle.css("width",40);
    }

}

function SetTimeInfoDivHeight()
{
	var he = document.body.scrollHeight;
	var js_ImgTop = $("#ImgTop");
	var js_timeInfo = $("#Time-Info");
	if(he>750){
		js_timeInfo.css("height",he-70-192-65);
	}
}