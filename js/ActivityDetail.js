/**
  * Activity Detail Control page
  * Author: Xu Yi
  * Last modified: 2014.12.17
  * method:
  * param:
*/


$(document).ready(function(){
	ClearTimeChoosen();

	PreviewImg();

	//AutoStorage();

	$("#resetBtn").click(function(e){
		$("#Preview").empty();
	});
});



$(document).on('click', '#updateBtn', function(){
    var timeValid = CheckTimeValid();
    var contentValid = CheckContentValid();
    if(!timeValid || !contentValid) return;
    var dest = 'mask.php';
    var form = document.getElementById('activity-form');
    var formData = new FormData(form);
    formData.append('method', 'updateActivity');
    formData.append('activity_id',$('#updateBtn')[0].name);
    
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if (xhr.readyState == 4){
            if(xhr.status == 200){
                var result = JSON.parse(xhr.responseText);
                console.log(result);
                alert(result['message']);
                window.location.href ="activity_list.php";
            }
        }
    }
    xhr.open('post', dest, true);
    xhr.setRequestHeader('context-type','text/xml;charset=utf-8');
    xhr.send(formData);
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


function PreviewImg(){
	$('[type=file]').change(function(e) {
		var file = e.target.files[0];
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

function CheckContentValid(){
	var TicketNumber = $("#input-total_tickets").val();
	var ActDescription = $("#input-description").val();
	var ActPlace = $("#input-place").val();
	var ActKey = $("#input-key").val();
	var ActName = $("#input-name").val();
    var TicketPerStudent = $('#input-ticket_per_student').val();
	var flag = true;


	if(!ActName){
		InputFocus("#input-name",'“活动全称”不能为空！');
		flag = false;
        return false;
	}

	if(!ActKey){
		InputFocus("#input-key",'“活动简称”不能为空！');
		flag = false;
        return false;
	}
	if(!ActPlace){
		InputFocus("#input-place",'“活动地点”不能为空！');
		flag = false;
        return false;
	}	
	if(!ActDescription){
		InputFocus("#input-description",'“活动简介”不能为空！');
		flag = false;
        return false;
	}	
    if(!TicketPerStudent){
		InputFocus("#input-ticket_per_student",'“每人可选票数”不能为空！');
		flag = false;
        return false;
	}			
	if(!TicketNumber){
		InputFocus("#input-total_tickets",'“总票数”不能为空！');
		flag = false;
        return false;
	}	
	return flag;
}

function CheckTimeValid(){
	var RS = $("#Rob-Start").val();
	var RE = $("#Rob-End").val();
	var AS = $("#Act-Start").val();
	var AE = $("#Act-End").val();

	if(RS && RE && AS && AE){
		var RobStartTime = parseDate(RS);
		var RobEndTime = parseDate(RE);
		var ActStartTime = parseDate(AS);
		var ActEndTime = parseDate(AE);

		var now = new Date();

		if(RobStartTime < now){
			InputFocus("#Rob-Start",'“订票开始时间”应晚于“当前时间”');
			/*$("#Rob-Start").popover({
                    html: true,
                    placement: 'top',
                    title:'',
                    content: '<span style="color:red;">“订票开始时间”应晚于“当前时间”</span>',
                    trigger: 'focus',
                    container: 'body'
            });
            $("#Rob-Start").focus();*/

			return false;
		}

		if(RobEndTime < RobStartTime){
			InputFocus("#Rob-End",'“订票结束时间”应晚于“订票开始时间”');
			return false;
		}

		if(ActStartTime < RobEndTime){
			InputFocus("#Act-Start",'“活动开始时间”应晚于“订票结束时间”');
			return false;
		}

		if(ActEndTime < ActStartTime){
			InputFocus("#Act-End",'“活动结束时间”应晚于“活动开始时间”');
			return false;
		}

		return true;
	}
	else{
		if(!AE){
			InputFocus("#Act-End",'“活动结束时间”不能为空！');
            return false;
		}	
		if(!AS){
			InputFocus("#Act-Start",'“活动开始时间”不能为空！');
            return false;
		}	
		if(!RE){
			InputFocus("#Rob-End",'“订票结束时间”不能为空！');
            return false;
		}				
		if(!RS){
			InputFocus("#Rob-Start",'“订票开始时间”不能为空！');
            return false;
		}
		return false;
	}
}

function InputFocus(id,text){
	var waring = '<span style="color:red;">' + text + '</span>'
	$(id).popover('destroy');
	$(id).popover({
        html: true,
        placement: 'top',
        title:'',
        content: waring,
        trigger: 'focus',
        container: 'body'
    });
    $(id).popover('show');
    $(id).focus();	
}

function parseDate(date){
	re = /(\d+)\-(\d+)\-(\d+)\-(\d+)\:(\d+)/g;
	if(re.test(date)){
		return(new Date(RegExp.$1,(RegExp.$2-1),RegExp.$3,RegExp.$4,RegExp.$5));
	}
}


function AutoStorage(){
	$("#activity-form").sisyphus({
		timeout: 10,
		onSave: function() {
			$('#log').html('正在自动保存...').fadeIn().delay(2000).fadeOut();
		},
		onRestore: function() {
			$('#log').html('已从本地恢复...').fadeIn().delay(2000).fadeOut();
		},
		onRelease: function() {
			$('#log').html('内容已经清除...').fadeIn().delay(2000).fadeOut();
		}
	});

}
