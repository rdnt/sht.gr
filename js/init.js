
$(window).on("load", function() {
	setTimeout(function() {
		//$(".theme-overlay").addClass("dark");
	},1000);

	setTimeout(function() {
		//$("nav, main").addClass("dark");
	},2250);

	$("nav").hover(
		function() {
			$(this).addClass("hover");
		}
	);

	$(".container").mousemove(
		function() {
			if ($("nav").hasClass("load")) {
				$("nav").removeClass("hover load");
				console.log("removed");
			}
			else {
				$("nav").removeClass("hover");
			}
		}
	);

});
