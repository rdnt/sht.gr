$(window).on("load", function() {

    // parallax(".red", .3);
    // parallax(".green", .5);
    // parallax(".blue", .7);
    //
    // parallax("#articles", -.1);

    // $(".layer").each(function(index, element) {
    //     setTimeout(function() {
    //         $(element).addClass("load");
    //     }, ($(".layer").length - 1) * 175 - index * 175);
    // });

    $(".layer").addClass("load");





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
