var parallax_items = [];

function __parallax(element, multiplier) {
    $(element).css("transform", "translateY(" + (($(element).offset().top - $(element).height() - $(window).scrollTop()) / 2.0) * multiplier + "px)");
}

function parallax(element = null, multiplier = null) {
    if (element && multiplier) {
        parallax_items.push([element, multiplier]);
    }
    else if (element) {
        parallax_items.push([element, .5]);
    }
    else {
        $(parallax_items).each(function() {
            __parallax(this[0], this[1]);
        });
    }
}

parallax();
$(window).scroll(function() {
    parallax();
});
