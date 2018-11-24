var hovered = false;
$(window).on("load", function() {
	setTimeout(function() {
		//$(".theme-overlay").addClass("dark");
	},1000);

	setTimeout(function() {
		//$("nav, main").addClass("dark");
	},2250);
	// $("nav").mousemove(function() {
	// 	$("nav").removeClass("hover");
	// 	$("nav ul li").css("transform", "translateY(0)");
	// });
	// if ($("nav").hasClass("load")) {
	// 	setTimeout(function() {
	//
	// 			$("nav").removeClass("hover load");
	// 			console.log("removed");
	//
	// 	}, 0);
	// }

	$("nav").hover(
		function() {
			hovered = true;
			$(this).addClass("hover");
		},

	);

	$(".container").mousemove(
		function() {
			if ($("nav").hasClass("load")) {
				$("nav").removeClass("hover load");
				console.log("removed");
			}
			setTimeout(function() {
				$("nav").removeClass("hover");

			}, 0);
		}

	);

});





// $("html").mouseover(function() {
// 	setTimeout(function() {
// 		$("nav").removeClass("hover");
// 		$("nav ul li").css("transform", "translateY(0)");
// 	}, 0);
// });
