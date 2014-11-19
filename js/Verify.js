/*
	* JS Control For Verify.html
	* Author: XuYi
	* Last modified :2014/11/18
*/
function VerifySuccess(){
	$("#Confirm-List").css("display","none");
	$("#VerifyOKIMG").css("display","block");


}

function VerifyFail(){
	$("#Confirm-List").css("display","none");
	$("#VerifyNOIMG").css("display","block");
	$("#Cancel-Button").css("display","block");
}

$(document).ready(function(){
	var height =  document.body.scrollHeight;
	$("#main-content").css("height",height);
	$("body").css("height",height);

	//alert(height);
	$("#Cancel-Button").click(function(){
		$("#VerifyNOIMG").css("display","none");
		$("#Cancel-Button").css("display","none");
		$("#Confirm-List").css("display","block");
		$("#Username").css("placeholder","请输入您的学号");
		$("#Password").css("placeholder","使用info密码进行登录");
		$("#results").text("请填写信息进行认证。");
	});
});




