/*
	* JS Control For Verify.html
	* Author: XuYi
	* Last modified :2014/11/18
*/

//认证成功之后页面前端显示
function VerifySuccess(){
	$("#Confirm-List").css("display","none");
	$("#VerifyOKIMG").css("display","block");
}

//认证失败之后页面前端显示
function VerifyFail(){
	$("#Confirm-List").css("display","none");
	$("#VerifyNOIMG").css("display","block");
	$("#Cancel-Button").css("display","block");
}


//设置底栏
function SetFooter(){
	var height =  document.body.scrollHeight;

	

	var js_main_content = $("#main-content");
	var set = js_main_content.hasClass("Setted");
	
	if(!set){
		js_main_content.addClass("Setted");
		js_main_content.css("height",height);
	}
	$("body").css("height",height);
	
}



function SetComfirmList(){
	var width =  document.body.scrollWidth;	
	var js_comfirmlist = $("#Confirm-List");
	var js_comfirmBox = $("#ConfirmBox");
	if(width * 0.8 > 400){

		js_comfirmBox.css("width",450);		
		js_comfirmlist.css("width",400);
	}
	else if(width < 250){
		js_comfirmlist.css("width",width*0.9);
		js_comfirmlist.css("margin","auto");
		$("#Username").css("height","20px");
		$("#Password").css("height","20px");
	}

}

//选中/取消强制绑定之后的前端显示
function SetForceBlindText(){
	
	var js_ForceBlindText = $("#ForeBlindText");

	if(js_ForceBlindText.hasClass("BlindDisActive")){
		js_ForceBlindText.attr("class","BlindActive");
		js_ForceBlindText.css("color","rgb(200,0,0)");
	}
	else{
		js_ForceBlindText.attr("class","BlindDisActive");
		js_ForceBlindText.css("color","black");
	}

                
}


//背景图片自适应
function SetBGIMG(){
	var width =  document.body.scrollWidth;	
	var height =  document.body.scrollHeight;
	var js_BGIMG = $("#BG-IMG");

	if(width > 500){
		if(width > height){
			js_BGIMG.attr("src","./img/Verify_bg_Big_Width.png");
		}
		else{
			js_BGIMG.attr("src","./img/Verify_bg_Big_Height.png");
		}
	}
	
	var bg_height = height - 45;	
	js_BGIMG.css("height",bg_height);


	
}

$(document).ready(function(){
	SetFooter();
	SetComfirmList();
	SetBGIMG();


	$("#Cancel-Button").click(function(){
		$("#VerifyNOIMG").css("display","none");
		$("#Cancel-Button").css("display","none");
		$("#Confirm-List").css("display","block");
		$("#Username").val("");
		$("#Password").val("");
		$("#results").text("请填写信息进行认证。");

	});

	$("#Forcebind").mousedown(function(){
		SetForceBlindText();
	});
});




