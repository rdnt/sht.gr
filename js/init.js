(function($){
    $(function(){
        $('.sidenav').sidenav();
        $('.parallax').parallax();
    }); // end of document ready
})(jQuery); // end of jQuery name space

// DOM content loaded
$(function(){

});

function animate_watch() {
    if($(this).scrollTop()>=$('#watch-container').position().top - $(window).height()){
        $("#watch-container .screen").addClass("animate-watch");

        setTimeout(function(){
            $("#watch-container .hover-overlay").addClass("hover");
        }, 1800);
    }
}

// Page content loaded
$(window).on('load', function(){

    animate_watch();
    $(window).scroll(function() {
        animate_watch();
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
