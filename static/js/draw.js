$(document).ready(function() {
    var svg_param = Object();
    svg_param.width = 240;
    svg_param.height = 200;
    svg_param.maxW = 480;
    svg_param.maxH = 400;
    svg_param.id = "svg_seat";
    var svg = CreateSVG($("#canvas")[0], svg_param);
    for (var i = 0; i < 5; ++i) {
        for (var j = 0; j < 5; ++j) {
            var rect_param = Object();
            rect_param.x = 20 * (i % 2) + 20 + j * 80;
            rect_param.y = 20 + i * 80;
            rect_param.width = 60;
            rect_param.height = 60;
            rect_param.fill = "#aaaaff";
            rect_param.seatname = (i + 1).toString() + "R" + (j + 1).toString() + "C";
            if (i < 4) {
                rect_param.seatclass = "seat_able seat_multi";
            } else {
                rect_param.seatclass = "seat_unable";
            }
            CreateSeat(svg, rect_param);
        }
    }
    var tmp = SaveSVG(svg);
    $(svg).remove();
    svg = LoadSVG($("#canvas")[0], tmp);
    AddSeatClickListener(svg);
});
