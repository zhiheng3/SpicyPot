/*
Set or Get ViewBox
Param: DOM, int, int, int, int
*/

function ViewBox(Dom, x, y, w, h){
    var viewbox = $(Dom).prop("viewBox");
    var val = viewbox.baseVal;
    if (typeof(x) == "undefined"){
        return val;
    }
    else{
        viewbox.baseVal.x = x;
        viewbox.baseVal.y = y;
        viewbox.baseVal.width = w;
        viewbox.baseVal.height = h;
        $(Dom).prop("viewBox", viewbox);
        if (Args.thumb)
            ModifyViewRect(x, y, w, h);
    }
}

function InitViewBox(Dom){
    var svg = $(Dom)[0];
    ViewBox(svg, 0, 0, parseInt($(svg).width()), parseInt($(svg).height()));
}

/*
Move SVG
Param: DOM, int, int, Bool
*/

function Move(Dom, deltaX, deltaY, scale){
    var viewbox = ViewBox(Dom);
    
    var X = viewbox.x + deltaX;
    var Y = viewbox.y + deltaY;
    var maxW = $(Dom).attr("maxw");
    var maxH = $(Dom).attr("maxh");
    
    if (X < 0)
        X = 0;
    if (Y < 0)
        Y = 0;
    if (X + viewbox.width > maxW)
        X = maxW - viewbox.width;
    if (Y + viewbox.height > maxH)
        Y = maxH - viewbox.height;
    ViewBox(Dom, X, Y, viewbox.width, viewbox.height);
}

/*
Zoom SVG
Param: DOM, double, int, int
*/
function Zoom(Dom, rate, centerX, centerY){
    var viewbox = ViewBox(Dom);
    var viewW = $(Dom).width();
    var viewH = $(Dom).height();
    var width = viewbox.width + viewW * rate;
    var height = viewbox.height + viewH * rate;
    
    centerX = viewbox.x + viewbox.width / 2;
    centerY = viewbox.y + viewbox.height / 2;
    
    var aspect = width / height;
    
    if (width * Args.zoom.minscale > viewW){
        width = viewW / Args.zoom.minscale;
        height = width / aspect;
    }
    if (height * Args.zoom.minscale > viewH){
        height = viewH / Args.zoom.minscale;
        width = height * aspect;
    }
    if (width * Args.zoom.maxscale < viewW){
        width = viewW / Args.zoom.maxscale;
        height = width / aspect;
    }
    if (height * Args.zoom.maxscale < viewH){
        height = viewH / Args.zoom.maxscale;
        width = height * aspect;
    }
    else if (centerX == undefined || centerY == undefined){
        ViewBox(Dom, viewbox.x, viewbox.y, width, height);
    }
    else{
        ViewBox(Dom, centerX - width / 2, centerY - height / 2, width, height);
    }
    Move(Dom, 0, 0);
}

function AddMoveListener(Dom){
    $(Dom).on("mousedown", MousedownHandler);
    $(Dom).on("mousemove", MousemoveHandler);
    $(Dom).on("mouseup", MouseupHandler);
    $(Dom).on("mouseleave", MouseleaveHandler);
    
    $(Dom).on("touchstart", TouchstartHandler);
    $(Dom).on("touchmove", TouchmoveHandler);
    $(Dom).on("touchend", TouchendHandler);
}

/*
Mouse Handler
*/
function MousedownHandler(e){
    if (Args.mode == "select"){
        StartSelect(e.target, e.offsetX, e.offsetY);
        return ;
    }
    StartMove(e.clientX, e.clientY);
    e.preventDefault();
}

function MousemoveHandler(e){
    if (Args.mode == "select"){
        ProcessSelect(e.target, e.offsetX, e.offsetY);
        return ;
    }
    ProcessMove(e.clientX, e.clientY, e.currentTarget);
    e.preventDefault();
}

function MouseupHandler(e){
    if (Args.mode == "select"){
        EndSelect(e.target, e.offsetX, e.offsetY);
        return ;
    }
    EndMove(e);
    e.preventDefault();
}

function MouseleaveHandler(e){
    EndMove();
    e.preventDefault();
}

/*
Touch Handler
*/
function TouchstartHandler(e){
    var touches = e.originalEvent.targetTouches;
    if (touches.length == 1){
        StartMove(touches[0].clientX, touches[0].clientY);
    }
    e.preventDefault();
}

function TouchmoveHandler(e){
    var touches = e.originalEvent.targetTouches;
    if (touches.length == 1){
        ProcessMove(touches[0].clientX, touches[0].clientY, e.currentTarget);
    }
    e.preventDefault();
}

function TouchendHandler(e){
    EndMove(e);
    e.preventDefault();
}

/*
Move Event
*/
function StartMove(x, y){
    if (Args.move.start)
        return ;
    //alert(x + " " + y);
    Args.move.x = x;
    Args.move.y = y;
    Args.move.start = true;
    Args.move.moved = false;
}

function ProcessMove(x, y, Dom){
    if (!Args.move.start)
        return false;
    var deltaX = x - Args.move.x;
    var deltaY = y - Args.move.y;
    
    if (Math.abs(deltaX) + Math.abs(deltaY) < 10)
        return false;
    Move(Dom, -deltaX, -deltaY, true);
    Args.move.x = x;
    Args.move.y = y;
    Args.move.moved = true;
}

function EndMove(e){
    if (!Args.move.start)
        return ;
    Args.move.start = false;
    if (typeof(e) == "undefined")
        return ;
    if (!Args.move.moved && e.target.tagName != "svg"){
        Args.clickHandler(e.target.id);
    }
}

/*
Select Event
*/

function StartSelect(Dom, x, y){
    if (Args.select.start)
        return ;
    //alert(x + " " + y);
    Args.select.x = x;
    Args.select.y = y;
    Args.select.start = true;
    Args.select.moved = false;
    
    var svgns = "http://www.w3.org/2000/svg";
    var rect = document.createElementNS(svgns, "rect");
    
    SetSVGAttr(rect, "stroke", "#888888");
    SetSVGAttr(rect, "stroke-width", 1);
    SetSVGAttr(rect, "stroke-dasharray", "1,1");
    SetSVGAttr(rect, "fill", "none");
    SetSVGAttr(rect, "id", "select_rect");
    
    $(Dom).append(rect);
}

function ProcessSelect(Dom, x, y){
    if (!Args.select.start)
        return false;
    var deltaX = x - Args.move.x;
    var deltaY = y - Args.move.y;

    if (Math.abs(deltaX) + Math.abs(deltaY) > 5)
        Args.select.moved = true;
    
    var rect = $("#select_rect")[0];

    SetSVGAttr(rect, "x", Math.min(x, Args.select.x));
    SetSVGAttr(rect, "y", Math.min(y, Args.select.y));
    SetSVGAttr(rect, "width", Math.abs(x - Args.select.x));
    SetSVGAttr(rect, "height", Math.abs (y - Args.select.y));
}

function EndSelect(Dom, x, y){
    $("#select_rect").remove();
    Args.select.start = false;
    if (Args.select.moved){
        var X = Math.min(x, Args.select.x);
        var Y = Math.min(y, Args.select.y);
        var W = Math.abs(x - Args.select.x);
        var H = Math.abs(y - Args.select.y);
        var elements = $("#svg_seat").children();
        for (var i = 0; i < elements.length; ++i){
            var ex = parseInt($(elements[i]).attr("x"));
            var ey = parseInt($(elements[i]).attr("y"));
            var ew = parseInt($(elements[i]).attr("width"));
            var eh = parseInt($(elements[i]).attr("height"));
            if (IsInterSect(X, Y, W, H, ex, ey, ew, eh))
                Args.selectHandler(elements[i].id);
        }
        /*
        for (var i in elements){
            console.log(i);
        }*/
    }
    
    if (!Args.select.moved && Dom.tagName != "svg"){
        Args.clickHandler(Dom.id);
    }
}

function IsInterSect(X, Y, W, H, x, y, w, h){
    var threshold = w * h / 2;
    
    var left = Math.max(X, x);
    var top = Math.max(Y, y);
    var right = Math.min(X + W, x + w);
    var bottom = Math.min(Y + H, y + h);
    
    if (right < left)
        return false;
    if (bottom < top)
        return false;
    
    if ((right -left) * (bottom - top) >= threshold)
        return true;
    return false;
    /*
    if (x >= X && x < X + W && y >= Y && y < Y + H)
        return true;
    return false;
    */
}

/*
viewbox : Object() x y width height
*/

function UpdateThumb(SourceDom, ThumbDom, viewbox){
    var tmp = $(SourceDom).parent().html();
    $(ThumbDom).html(tmp);
    var thumb = $(ThumbDom).children();
    thumb.width("100%");
    thumb.height("100%");
    ViewBox(thumb[0], 0, 0, thumb.attr("maxw"), thumb.attr("maxh"));
    
    /*
    $("#test").empty();
    $("#test").append(tmp);*/
}

$(document).ready(function(){
    //Init
    Args = Object();
    Args.move = Object();
    Args.move.start = false;
    Args.move.moved = false;
    Args.move.x = 0;
    Args.move.y = 0;
    Args.zoom = Object();
    Args.zoom.minscale = 1;
    Args.zoom.maxscale = 1;
    Args.thumb = false;
    Args.mode = "drag";
    
    Args.select = Object();
    Args.select.start = false;
    Args.select.moved = false;
    Args.select.x = 0;
    Args.select.y = 0;
    
    Args.timeout = 0;
});
