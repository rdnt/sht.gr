(function($){
    $(function(){
        $('.sidenav').sidenav();
        $('.parallax').parallax();
    }); // end of document ready
})(jQuery); // end of jQuery name space

// DOM content loaded
$(function(){

});

function animate_code() {
    if($(this).scrollTop()>=$('#code').position().top - $(window).height() + 300) {
        $("#code-container").addClass("animate-code");
        $("#watch-container .screen").addClass("animate-watch");
        $("#watch-container").addClass("visible");
        setTimeout(function(){
            $("#watch-container .hover-overlay").addClass("hover");
        }, 1800);
    }
}

function animate_gaming() {
    if($(this).scrollTop()>=$('#gaming').position().top - $(window).height() + 300) {
        $("#gaming-container").addClass("animate-gaming");
    }
}

function animate_music() {
    if($(this).scrollTop()>=$('#music').position().top - $(window).height() + 300) {
        $("#music-container").addClass("animate-music");
    }
}



// Page content loaded
$(window).on('load', function(){

    animate_code();
    animate_gaming();
    animate_music();
    $(window).scroll(function() {
        animate_code();
        animate_gaming();
        animate_music();
    });

    setTimeout(function(){
        $("#right-panel").addClass("slide-in slide-right");
        $("#left-panel").addClass("slide-in slide-left");
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
        }, 1000);
    }, 100);
});
