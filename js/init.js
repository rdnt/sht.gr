parallax("#articles", -0.1);
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
