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
    alert("Mousedown");
    StartMove(e.clientX, e.clientY);
    e.preventDefault();
}

function MousemoveHandler(e){
    ProcessMove(e.clientX, e.clientY, e.currentTarget);
    e.preventDefault();
}

function MouseupHandler(e){
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
    alert("Touchdown");
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
    Args.move.start = false;
    if (typeof(e) == "undefined")
        return ;
    if (!Args.move.moved && e.target.tagName != "svg"){
        Args.clickHandler(e.target.id);
    }
}

function updateThumb(canvas, viewbox){
    var tmp = $("#svg_seat").clone();
    $("#test").empty();
    $("#test").append(tmp);
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
});
