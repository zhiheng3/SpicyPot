$(document).ready(function(){
	SetActivityPlace("综体");
	SetTimeInfoDivWidth();
	SetTimeLeftWidth();
	SetTimeInfoDivHeight();
});

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