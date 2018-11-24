
$(window).on("load", function() {
	setTimeout(function() {
		$(".theme-overlay").addClass("dark");
		$("nav, main").addClass("theming");
		setTimeout(function() {
			$("nav, main").addClass("dark");
			setTimeout(function() {
				$("nav, main").removeClass("theming");
			}, 500);
		}, 900);

	}, 1000);


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

});
