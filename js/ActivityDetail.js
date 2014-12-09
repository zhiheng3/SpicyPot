/**
  * Activity Detail Control page
  * Author: Xu Yi
  * Last modified: 2014.12.2
  * method:
  * param:
*/


$(document).ready(function(){
	ClearTimeChoosen();

	AdjustInput();

	PreviewImg();


});




function ClearTimeChoosen(){
	$("#Remove-RS").click(function(){
		$("#Rob-Start").val("");
	});
	$("#Remove-RE").click(function(){
		$("#Rob-End").val("");
	});
	$("#Remove-AS").click(function(){
		$("#Act-Start").val("");
	});
	$("#Remove-AE").click(function(){
		$("#Act-End").val("");
	});			
}

function AdjustInput(){
	$("#input-total_tickets").css("width","40%");
}

function PreviewImg(){
	$('[type=file]').change(function(e) {
		var file = e.target.files[0]
		PreviewPic(file);
	});
}



function PreviewPic(file) {
	var img = new Image(), url = img.src = URL.createObjectURL(file);
	var $img = $(img);
	img.onload = function() {
		URL.revokeObjectURL(url);
		$('#Preview').empty().append($img);
	}
}

function CheckTimeVaild(){
	var RS = $("#Rob-Start").val();
	var RE = $("#Rob-End").val();
	var AS = $("#Act-Start").val();
	var AE = $("#Act-End").val();
	debugger;
	if(RS && RE && AS && AE){
		var RobStartTime = parseDate(RS);
		var RobEndTime = parseDate(RE);
		var ActStartTime = parseDate(AS);
		var ActEndTime = parseDate(AE);

		var now = new Date();
		debugger;
		if(RobStartTime < now){
			$("#Rob-Start").popover({
                    html: true,
                    placement: 'top',
                    title:'',
                    content: '<span style="color:red;">“订票开始时间”应晚于“当前时间”</span>',
                    trigger: 'focus',
                    container: 'body'
            });
            $("#Rob-Start").focus();

			return false;
		}

		if(RobEndTime < RobStartTime){
			$("#Rob-End").popover({
                html: true,
                placement: 'top',
                title:'',
                content: '<span style="color:red;">“订票结束时间”应晚于“订票开始时间”</span>',
                trigger: 'focus',
                container: 'body'
            });
            $("#Rob-End").focus();
			return false;
		}

		if(ActStartTime < RobEndTime){
	        $("#Act-Start").popover({
                html: true,
                placement: 'top',
                title:'',
                content: '<span style="color:red;">“活动开始时间”应晚于“订票结束时间”</span>',
                trigger: 'focus',
                container: 'body'
	        });			
			return false;
		}

		if(ActEndTime < ActStartTime){
            $("#Act-End").popover({
	            html: true,
	            placement: 'top',
	            title:'',
	            content: '<span style="color:red;">“活动结束时间”应晚于“活动开始时间”</span>',
	            trigger: 'focus',
	            container: 'body'
	        });
         	$("#Act-End").focus();

			return false;
		}

		return true;
	}
	else{
		return false;
	}
}

function parseDate(date){
	re = /(\d+)\-(\d+)\-(\d+)\-(\d+)\:(\d+)/g;
	if(re.test(date)){
		return(new Date(RegExp.$1,(RegExp.$2-1),RegExp.$3,RegExp.$4,RegExp.$5));
	}
}

