$(window).on("load", function() {
	setTimeout(function() {
		//$(".theme-overlay").addClass("dark");
	},1000);

	setTimeout(function() {
		//$("nav, main").addClass("dark");
	},2250);
});
$("nav").hover(function() {
	var i = 1;
	$("nav ul li").each(function(index, element) {
		$(element).css("transform", "translateY("+ 6 * i +"px)");
		i++;
	});
},
function() {
	$("nav ul li").css("transform", "translateY(0)");
});
