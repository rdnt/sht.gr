var parallax_items = [];

function __parallax(element, top, multiplier) {
    var viewport = window.innerHeight;
    var height = $(element).outerHeight();
    var center = top + (height / 2);
    var offset = $(window).scrollTop();
    var calc = offset + (viewport / 2) - center;
    $(element).css("transform", "translateY(" + calc * multiplier * -1.0 + "px)");
}

function parallax(element = null, multiplier = null) {
    if (element) {
        if (!$(element).length) {
            console.log("Failed to initialize parallax for element " + element);
            return;
        }
        if (!multiplier) {
            multiplier = .5;
        }
        parallax_items.push([element, $(element).offset().top, multiplier]);
        $(element).addClass("loaded");
        parallax();
    }
    else {
        $(parallax_items).each(function() {
            __parallax(this[0], this[1], this[2]);
        });
    }
}

$(window).scroll(function() {
    parallax();
});

$(window).resize(function() {
    $(parallax_items).each(function(index) {
        element = this[0];
        var matrix = $(element).css("transform").replace(/[^0-9\-.,]/g, "").split(",");
        var transform = matrix[13] || matrix[5];
        parallax_items[index] = [this[0], $(this[0]).offset().top - transform, this[2]];
    });
    parallax();
});

$(window).on("load", function() {
    parallax();
});

var parallax_img = document.querySelectorAll(".parallax .bg");
for (var i = 0; i < parallax_img.length; i++) {
    parallax_img[i].innerHTML += '<div class="inner"></div>';
}

$(".parallax .bg img").on("load", function() {
    var src = $(this).attr("src");
    var id = $(this).parent().parent().attr("id");
    $(this).siblings(".inner").css("background", "url(\"" + src + "\") no-repeat center center");
    $(this).siblings(".inner").addClass("loaded");
    $(this).siblings(".inner").attr("data-parent", id);
    $(this).remove();
    parallax(".parallax .bg .inner[data-parent=" + id + "]", -.1);
});
