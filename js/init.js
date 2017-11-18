// DOM content loaded
$(function(){

    $("#right-panel").addClass("slide-in");
    $("#left-panel").addClass("slide-in");

});

// Page loaded
$(window).on('load', function(){


    setTimeout(function(){

        $("#right-panel").addClass("init-center");
        $("#left-panel").addClass("init-center");

    }, 500);

    setTimeout(function(){

        $("#right-panel").removeClass("init-right slide-in");
        $("#left-panel").removeClass("init-left slide-in");

        $("#right-panel").addClass("slide-right");
        $("#left-panel").addClass("slide-left");

        $("#loader").addClass("transparent");

        setTimeout(function(){
            $("#loader").addClass("display-none");
        }, 1000);
    }, 1500);


});
