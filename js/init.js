(function($){
  $(function(){

    $('.sidenav').sidenav();
    $('.parallax').parallax();

  }); // end of document ready
})(jQuery); // end of jQuery name space

// DOM content loaded
$(function(){



});

// Page content loaded
$(window).on('load', function(){


    setTimeout(function(){
        $("#right-panel").addClass("slide-in slide-right");
        $("#left-panel").addClass("slide-in slide-left");
    }, 100);

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
