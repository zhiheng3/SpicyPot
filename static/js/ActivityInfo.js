/**
 * Activity Activitt Info Control page
 * Description : font-size adjust
 *               count down
 * Author: Xu Yi
 * Last modified: 2014.12.18
 * method:
 * param:
 */

$(document).ready(function() {
    ResetAll();
    StartCountDown();
    AdjustFontSize();

});

//add a count down 
function StartCountDown() {

    $('#Time-Left').flipcountdown({
        size: 'sm',
        tick: function() {
            var nol = function(h) {
                return h > 9 ? h : '0' + h;
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

            //judge activity state accordng to current time
            if (now < RobStartTime) {
                ResetAll();
                endDate = RobStartTime;
                $("#Rob-Start").css("display", "block");
            } else if ((now >= RobStartTime) && (now < RobEndTime)) {
                ResetAll();
                endDate = RobEndTime;
                $("#Rob-End").css("display", "block");
            } else if ((now >= RobEndTime) && (now < ActStartTime)) {
                ResetAll();
                endDate = ActStartTime;
                $("#Act-Start").css("display", "block");
            } else if ((now >= ActStartTime) && (now < ActEndTime)) {
                ResetAll();
                endDate = ActEndTime;
                $("#Act-End").css("display", "block");
            } else {
                ResetAll();
                $("#END").css("display", "block");
                $("#Time-Left").css("display", "none");
                $("#Time-Left").parent().css("display", "none");
                return;
            }
            var NY = Math.round(endDate.getTime() / 1000);

            var range = NY - Math.round((new Date()).getTime() / 1000),
                secday = 86400,
                sechour = 3600,
                days = parseInt(range / secday),
                hours = parseInt((range % secday) / sechour),
                min = parseInt(((range % secday) % sechour) / 60),
                sec = ((range % secday) % sechour) % 60;
            return nol(days) + ' ' + nol(hours) + ' ' + nol(min) + ' ' + nol(sec);
        }
    });

}

//hide all div which show activity state
function ResetAll() {
    $("#Rob-Start").css("display", "none");
    $("#Rob-End").css("display", "none");
    $("#Act-Start").css("display", "none");
    $("#Act-End").css("display", "none");
    $("#END").css("display", "none");

}

//accept a string and parse it as a Date object
function parseDate(date) {
    re = /(\d+)\-(\d+)\-(\d+)\s(\d+)\:(\d+)/g;
    if (re.test(date)) {
        return (new Date(RegExp.$1, (RegExp.$2 - 1), RegExp.$3, RegExp.$4, RegExp.$5));
    }
}

//adjust font size
function AdjustFontSize() {
    var width = document.body.scrollWidth;

    if (width < 370) {
        $("#TicketInfo").css("font-size", "0.9em");
    }
}
