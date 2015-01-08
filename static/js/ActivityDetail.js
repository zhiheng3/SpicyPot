/**
 * Activity Detail Control page
 * Author: Xu Yi
 * Last modified: 2014.12.27
 * method:
 * param:
 */
$(document).ready(function() {
    ClearTimeChoosen();
    PreviewImg();
    //AutoStorage();
    //clear the pic preview when click resetBtn
    $("#resetBtn").click(function(e) {
        $("#Preview").empty();
    });
});

//create activity
$(document).on("click", "#publishBtn", function() {
    var timeValid = CheckTimeValid();
    var contentValid = CheckContentValid();
    if (timeValid && contentValid) {
        ShowHintBox("正在创建活动，请稍候......");
        createActivity();
    }
});

function createActivity() {
    var dest = "mask.php";
    var form = document.getElementById("activity-form");
    var formData = new FormData(form);
    formData.append("method", "createActivity");
    if ($("#input-seat_status").val() > 0) {
        var rawSeatsObj = GetSeatsInfo(Args.curtemplate);
        var rawSeatStr = SaveSVG(Args.curtemplate);
        var rawSeat = JSON.stringify(rawSeatsObj);
        formData.append("seat_info", rawSeat);
        formData.append("seat_info_str", rawSeatStr);
    }
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                var result = JSON.parse(xhr.responseText);
                console.log(result);
                if (result["message"] != "") {
                    HideHintBox(result["message"], 3);
                }
                //Path may change
                else HideHintBox("活动创建成功", 3, "activity_list.php");
            }
        }
    }
    xhr.open("post", dest, true);
    xhr.setRequestHeader("context-type", "text/xml;charset=utf-8");
    xhr.send(formData);
}

//change activity
$(document).on('click', '#updateBtn', function() {
    var timeValid = CheckTimeValid();
    var contentValid = CheckContentValid();
    //Here is modified By Xu Yi
    //to make Web-Font Friendly,otherwise there will be two popover
    if (!contentValid) {
        return;
    }
    if (!timeValid) {
        return;
    }
    ShowHintBox("正在修改活动，请稍候......");
    var dest = 'mask.php';
    var form = document.getElementById('activity-form');
    var formData = new FormData(form);
    formData.append('method', 'updateActivity');
    formData.append('activity_id', $('#updateBtn')[0].name);
    if ($("#input-seat_status").val() > 0) {
        var rawSeatsObj = GetSeatsInfo(Args.curtemplate);
        var rawSeatStr = SaveSVG(Args.curtemplate);
        var rawSeat = JSON.stringify(rawSeatsObj);
        formData.append("seat_info", rawSeat);
        formData.append("seat_info_str", rawSeatStr);
    }
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                var result = JSON.parse(xhr.responseText);
                console.log(result);
                if (result["message"] != "") {
                    HideHintBox(result["message"], 3);
                }
                //Path may change
                else HideHintBox("活动修改成功", 3, "activity_list.php");
            }
        }
    }
    xhr.open('post', dest, true);
    xhr.setRequestHeader('context-type', 'text/xml;charset=utf-8');
    xhr.send(formData);
});

//click "X" in datetimepicker and it will clear the data you choose
function ClearTimeChoosen() {
    $("#Remove-RS").click(function() {
        $("#Rob-Start").val("");
    });
    $("#Remove-RE").click(function() {
        $("#Rob-End").val("");
    });
    $("#Remove-AS").click(function() {
        $("#Act-Start").val("");
    });
    $("#Remove-AE").click(function() {
        $("#Act-End").val("");
    });
}

//when change picture, perview it
function PreviewImg() {
    $('[type=file]').change(function(e) {
        var file = e.target.files[0];
        PreviewPic(file);
    });
}

//show picture
function PreviewPic(file) {
    var img = new Image(),
        url = img.src = URL.createObjectURL(file);
    var $img = $(img);
    img.onload = function() {
        URL.revokeObjectURL(url);
        $('#Preview').empty().append($img);
    }
}

//judge whether input content is empty
function CheckContentValid() {
    var TicketNumber = $("#input-total_tickets").val();
    var ActDescription = $("#input-description").val();
    var ActPlace = $("#input-place").val();
    var ActKey = $("#input-key").val();
    var ActName = $("#input-name").val();
    var TicketPerStudent = $('#input-ticket_per_student').val();
    var flag = true;
    if (!ActName) {
        InputFocus("#input-name", '“活动全称”不能为空！');
        flag = false;
        return false;
    }
    if (!ActKey) {
        InputFocus("#input-key", '“活动简称”不能为空！');
        flag = false;
        return false;
    }
    if (!ActPlace) {
        InputFocus("#input-place", '“活动地点”不能为空！');
        flag = false;
        return false;
    }
    if (!ActDescription) {
        InputFocus("#input-description", '“活动简介”不能为空！');
        flag = false;
        return false;
    }
    if (!TicketPerStudent) {
        InputFocus("#input-ticket_per_student", '“每人可选票数”不能为空且必须为整数！');
        flag = false;
        return false;
    }
    var TicketPS = parseFloat(TicketPerStudent, 10);
    if (!isInteger(TicketPS) || (TicketPS < 1)) {
        InputFocus("#input-ticket_per_student", '“每人可选票数”必须为正整数！');
        flag = false;
        return false;
    }
    if (!TicketNumber) {
        InputFocus("#input-total_tickets", '“总票数”不能为空且必须为整数！');
        flag = false;
        return false;
    }
    var TicketN = parseFloat(TicketNumber, 10);
    if (!isInteger(TicketN) || (TicketN < 1)) {
        InputFocus("#input-total_tickets", '“总票数”必须为正整数！');
        flag = false;
        return false;
    }
    return flag;
}

//judge whether a number is a int
function isInteger(obj) {
    return Math.floor(obj) === obj
}

//judge whether time is vaild
function CheckTimeValid() {
    var RS = $("#Rob-Start").val();
    var RE = $("#Rob-End").val();
    var AS = $("#Act-Start").val();
    var AE = $("#Act-End").val();
    if (RS && RE && AS && AE) {
        var RobStartTime = parseDate(RS);
        var RobEndTime = parseDate(RE);
        var ActStartTime = parseDate(AS);
        var ActEndTime = parseDate(AE);
        var jqRemoveRS = $("#Remove-RS").length;
        var now = new Date();
        //make sure RobStart can be edited
        if ((RobStartTime < now) && (jqRemoveRS > 0)) {
            InputFocus("#Rob-Start", '“抢票开始时间”应晚于“当前时间”');
            return false;
        }
        if (RobEndTime < RobStartTime) {
            InputFocus("#Rob-End", '“抢票结束时间”应晚于“订票开始时间”');
            return false;
        }
        if (ActStartTime < RobEndTime) {
            InputFocus("#Act-Start", '“活动开始时间”应晚于“订票结束时间”');
            return false;
        }
        if (ActEndTime < ActStartTime) {
            InputFocus("#Act-End", '“活动结束时间”应晚于“活动开始时间”');
            return false;
        }
        return true;
    } else {
        if (!AE) {
            InputFocus("#Act-End", '“活动结束时间”不能为空！');
            return false;
        }
        if (!AS) {
            InputFocus("#Act-Start", '“活动开始时间”不能为空！');
            return false;
        }
        if (!RE) {
            InputFocus("#Rob-End", '“订票结束时间”不能为空！');
            return false;
        }
        if (!RS) {
            InputFocus("#Rob-Start", '“订票开始时间”不能为空！');
            return false;
        }
        return false;
    }
}

//show popover above the 'id' lable
//text:the content 
function InputFocus(id, text) {
    var waring = '<span style="color:red;">' + text + '</span>';
    //clear all the popover
    $(id).popover('destroy');
    $(id).popover({
        html: true,
        placement: 'top',
        title: '',
        content: waring,
        trigger: 'focus',
        container: 'body'
    });
    $(id).popover('show');
    $(id).focus();
}

//accept a string and parse it as a Date object
function parseDate(date) {
    re = /(\d+)\-(\d+)\-(\d+)\-(\d+)\:(\d+)/g;
    if (re.test(date)) {
        return (new Date(RegExp.$1, (RegExp.$2 - 1), RegExp.$3, RegExp.$4, RegExp.$5));
    }
}

//Auto-Save
function AutoStorage() {
    $("#activity-form").sisyphus({
        //Auto-Save every 10s
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

//change format of Date from the Web-Front to the format that can be accepted by DataBase
function dateCorrection(date) {
    var newDate1 = date.substr(0, 10);
    var newDate2 = date.substr(11);
    return (newDate1.concat(" ", newDate2, ":00"));
}
$('.form_datetime').datetimepicker({
    language: 'zh-CN',
    weekStart: 1,
    todayBtn: 1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    forceParse: 0,
    showMeridian: 1
});
$('.form_date').datetimepicker({
    language: 'fr',
    weekStart: 1,
    todayBtn: 1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    minView: 2,
    forceParse: 0
});
$('.form_time').datetimepicker({
    language: 'fr',
    weekStart: 1,
    todayBtn: 1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 1,
    minView: 0,
    maxView: 1,
    forceParse: 0
});
