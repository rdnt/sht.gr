
function toggleTheme() {
    // setTimeout(function() {
    // 	$(".theme-overlay").addClass("dark");
    // 	$("nav, main").addClass("theming");
    // 	setTimeout(function() {
    // 		$("nav, main").addClass("dark");
    // 		setTimeout(function() {
    // 			$("nav, main").removeClass("theming");
    // 		}, 500);
    // 	}, 900);
    // }, 1000);
}
//
$(window).on("load", function() {

    $("nav").hover(
        function() {
            $(this).addClass("hover");
        }
    );

    $("main").mousemove(
        function() {
            if ($("nav").hasClass("load")) {
                $("nav").removeClass("hover load");
            }
            else {
                $("nav").removeClass("hover");
            }
        }
    );

    $("main").hover(function() {
        $("#side-reveal").addClass("hover");
        $("#background-img").addClass("hover");
    }, function() {
        $("#side-reveal").removeClass("hover");
        $("#background-img").removeClass("hover");
    });

    $("main").click(function() {
        $("#side-reveal").addClass("active");
        $("#background-img").addClass("active");
    });

});

$(".playlist .track").hover(function() {
    var ep = $(this).data("ep");
    $("#background-img::before").css("background-img", "url(\"/images/ardent/covers/bg" + ep + ".jpg\");");
});

var parallax_items = [];

parallax(".red", .1);
parallax(".green", .3);
parallax(".blue", .5);

parallax();
$(window).scroll(function() {
    parallax();
});

function __parallax(element, multiplier) {
    $(element).css("transform", "translateY(" + (($(element).offset().top - $(element).height() - $(window).scrollTop()) / 2) * multiplier + "px)");
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
