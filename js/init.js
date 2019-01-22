
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

$(window).on("load", function() {

	$("nav").hover(
		function() {
			$(this).addClass("hover");
		}
	);

	$(".container").mousemove(
		function() {
			if ($("nav").hasClass("load")) {
				$("nav").removeClass("hover load");
			}
			else {
				$("nav").removeClass("hover");
			}
		}
	);

	// $(".container").hover(function() {
	// 	$("#side-reveal").addClass("hover");
	// 	$("#background-img").addClass("hover");
	// }, function() {
	// 	$("#side-reveal").removeClass("hover");
	// 	$("#background-img").removeClass("hover");
	// });
	//
	// $(".container").click(function() {
	// 	$("#side-reveal").addClass("active");
	// 	$("#background-img").addClass("active");
	// });

});
