// DOM content loaded
$(function(){

    $("#right-panel").addClass("slide-in");
    $("#left-panel").addClass("slide-in");

});

// Page content loaded
$(window).on('load', function(){

    $("#right-panel").addClass("slide-right");
    $("#left-panel").addClass("slide-left");

    setTimeout(function(){
        setTimeout(function(){
            $("#right-panel").removeClass("init-right");
            $("#left-panel").removeClass("init-left");
            setTimeout(function(){
                $("#loader").addClass("display-none");
            }, 1000);
        }, 500);
        $("#logo-wrapper").addClass("invisible");
        setTimeout(function(){
            $("#loader").addClass("transparent");
        }, 50);
    }, 1100);

});
