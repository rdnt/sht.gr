$(window).on("load", function() {
	$(".carousel .img:not(last-child)").hover(handlerIn, handlerOut);
    var offset = 5;
    var width = 200;
    $(".carousel .imgfirst-child").nextAll().each(function(index) {
        $(this).css("transform", "skew(-15deg) translateX(" + offset * width  + "px");
        offset++;
    });

    setTimeout(function() {
        $(".carousel .img").removeClass("load");
    }, 0);






    function handlerIn() {
        index = $(".carousel .img").index(this);
        $(this).addClass("active");
        if (index == 0) {
            offset = 5;
            $(this).nextAll().each(function(index) {

                $(this).css("transform", "skew(-15deg) translateX(" + offset * width  + "px");
                offset++;
            });
        }
        else {
            offset =+ index;
            $(this).css("transform", "skew(-15deg) translateX(" + offset * width  + "px");
            offset += 5;
            $(this).nextAll().each(function(index) {

                $(this).css("transform", "skew(-15deg) translateX(" + offset * width  + "px");
                offset++;
            });
            offset =+ index - 1;
            $(this).prevAll().each(function(index) {

                $(this).css("transform", "skew(-15deg) translateX(" + offset * width  + "px");
                offset--;
            });
        }

    }




    function handlerOut() {
        $(this).removeClass("active");

    }

});
