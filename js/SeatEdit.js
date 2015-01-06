function SetSVGAttr(Dom, attr, value){
    var svgns = "http://www.w3.org/2000/svg";
    if (typeof(value) != "undefined"){
        Dom.setAttributeNS(null, attr, value);
    }
    return Dom;
}

/*
SVG Info
width, height, maxW, maxH, id
*/

/*
Create a SVG
Param: DOM, Object(int, int, int, int, string)
*/
function CreateSVG(Dom, args){
    var svgns = "http://www.w3.org/2000/svg";
    var svg = document.createElementNS(svgns, "svg");
    
    SetSVGAttr(svg, "version", 1.1);
    
    SetSVGAttr(svg, "width", args.width);
    SetSVGAttr(svg, "height", args.height);
    SetSVGAttr(svg, "maxw", args.maxW);
    SetSVGAttr(svg, "maxh", args.maxH);
    SetSVGAttr(svg, "viewBox", "0 0 " + args.maxW.toString() + " " + args.maxH.toString());
    SetSVGAttr(svg, "id", args.id);
    
    $(Dom).append(svg);
    return svg;
}

/*
Seat Info
x, y, width, height: int
fillcolor: HTML color
seatname, seatclass: string

Seat Class
seat_able | seat_unable | seat_multi
*/

/*
Create a seat
Param: DOM, int, int, int, int, color, string, string
*/
function CreateSeat(Dom, args){
    var svgns = "http://www.w3.org/2000/svg";
    var rect = document.createElementNS(svgns, "rect");
    
    SetSVGAttr(rect, "x", args.x);
    SetSVGAttr(rect, "y", args.y);
    SetSVGAttr(rect, "width", args.width);
    SetSVGAttr(rect, "height", args.height);
    SetSVGAttr(rect, "fill", args.fill);
    
    var r = parseInt(Math.min(args.width, args.height) / 4);
    //SetSVGAttr(rect, "stroke", "#000000");
    SetSVGAttr(rect, "stroke-width", 0);
    SetSVGAttr(rect, "rx", r);
    SetSVGAttr(rect, "ry", r);
    
    SetSVGAttr(rect, "id", args.seatname);
    SetSVGAttr(rect, "class", args.seatclass);
    
    $(Dom).append(rect);
    return rect;
}

function CreateThumb(CanvasDom, SourceDom, x, y, width){
    
    var canvas = $("<div id='canvas_thumb'></div>");
    canvas.css("position", "absolute");
    canvas.css("display", "none");
    canvas.css("left", x);
    canvas.css("top", y);
    
    var w = $(SourceDom).attr("maxw");
    var h = $(SourceDom).attr("maxh");
    
    canvas.css("width", width);
    canvas.css("height", parseInt(h * width / w));
    canvas.css("background-color", "white");
    canvas.css("z-index", 100);
    canvas.css("overflow", "hidden");
    $(CanvasDom).append(canvas);
    
    var tmp = $(SourceDom).parent().html();
    $(canvas).html(tmp);
    var thumb = $(canvas).children();
    thumb[0].id = "svg_thumb";
    thumb.width("100%");
    thumb.height("100%");
    ViewBox(thumb[0], 0, 0, thumb.attr("maxw"), thumb.attr("maxh"));
    
    CreateViewRect(thumb[0]);
    Args.thumb = true;
}

function CreateViewRect(Dom){
    var svgns = "http://www.w3.org/2000/svg";
    var rect = document.createElementNS(svgns, "rect");
    
    SetSVGAttr(rect, "stroke", "#FF0000");
    SetSVGAttr(rect, "stroke-width", 1);
    SetSVGAttr(rect, "fill", "none");
    SetSVGAttr(rect, "id", "thumb_viewrect");
    
    $(Dom).append(rect);
}

function ModifyViewRect(x, y, w, h){
    var Dom = $("#thumb_viewrect")[0];
    SetSVGAttr(Dom, "x", x + 2);
    SetSVGAttr(Dom, "y", y + 2);
    SetSVGAttr(Dom, "width", w - 4);
    SetSVGAttr(Dom, "height", h - 4);
    
    $("#canvas_thumb").css("display", "block");
    clearTimeout(Args.timeout);
    Args.timeout = setTimeout(function(){$("#canvas_thumb").css("display", "none");}, 2000);
}

/*
Save Seats SVG
Param: DOM
Return: string
*/
function SaveSVG(Dom){
    return $(Dom).find("svg").parent().html();
}

/*
Load Seats SVG
Param: DOM, string
*/
function LoadSVG(Dom, svgtext){
    $(Dom).html(svgtext);
    var svg = $(Dom).children();
    //AddMoveListener(svg);
    return svg;
}

/*

function loadSVG(Rpaper, json_data){
    var data = JSON.parse(json_data);
    Rpaper.clear();
    Rpaper.add(data.SVG);
    var i = 0;
    Rpaper.forEach(function(e){
        e.data("position", data.info[i].position);
    });
    Rpaper.maxW = data.maxW;
    Rpaper.maxH = data.maxH;
    Rpaper.setViewBox(0, 0, Rpaper.maxW, Rpaper.maxH);
    $(Rpaper.canvas).prop("maxW", Rpaper.maxW);
    $(Rpaper.canvas).prop("maxH", Rpaper.maxH);
    
    AddListener(Rpaper.canvas);
}

function saveSVG(Rpaper_data){
    var i = 0;
    var result = Object();
    result.SVG = Array();
    result.info = Array();
    result.maxW = Rpaper_data.maxW;
    result.maxH = Rpaper_data.maxH;
    Rpaper_data.forEach(function(e){
        if (e.data("position") != undefined){
            result.SVG[i] = e.attrs;
            result.SVG[i].type = e.type;
            result.info[i] = Object();
            result.info[i].position = e.data("position");
            i++;
        }
    });
    return JSON.stringify(result);
}
*/
