$(window).on("load", function() {
	$(".carousel .img:not(last-child)").hover(handlerIn, handlerOut);
    var offset = 5;
    var width = 200;
    $(".carousel .imgfirst-child").nextAll().each(function(index) {
        $(this).css("transform", "skew(-15deg) translateX(" + offset * width  + "px");
        offset++;
    });

    setTimeout(function() {
        $(".carousel .img").removeClass("load");
    }, 0);






    function handlerIn() {
        index = $(".carousel .img").index(this);
        $(this).addClass("active");
        if (index == 0) {
            offset = 5;
            $(this).nextAll().each(function(index) {

                $(this).css("transform", "skew(-15deg) translateX(" + offset * width  + "px");
                offset++;
            });
        }
        else {
            offset =+ index;
            $(this).css("transform", "skew(-15deg) translateX(" + offset * width  + "px");
            offset += 5;
            $(this).nextAll().each(function(index) {

                $(this).css("transform", "skew(-15deg) translateX(" + offset * width  + "px");
                offset++;
            });
            offset =+ index - 1;
            $(this).prevAll().each(function(index) {

                $(this).css("transform", "skew(-15deg) translateX(" + offset * width  + "px");
                offset--;
            });
        }

    }




    function handlerOut() {
        $(this).removeClass("active");

    }

	var time_resolution = 100;

	var scale_factor = 4;

	var start = [
		0, 183, 341, 471
	];

	var end = [
		213, 370, 485, 741
	];

	var lengths = [];
	for (var i=0; i<start.length; i++) {
		lengths[i] = end[i] - start[i];
	}



	var i = 1;
	$("#tracks .group.a .track").each(function() {
        $(this).attr("id", "track" + i);
		i += 2;
    });
	var i = 1;
	$("#tracks .group.b .track").each(function() {
        $(this).attr("id", "track" + (i+1));
		i += 2;
    });

	$("#tracks .track").each(function() {
        var id = $(this).attr("id").slice(5);
		var length = lengths[id-1] * scale_factor;
		$(this).css("width", length+"px");
		var offset = start[id-1] * scale_factor;
		$(this).css("transform", "translateX("+offset+"px)");
    });

	var time = 180 * time_resolution;
	var time = 0;

	//update();

	setInterval(function() {
		update();
	}, 1000 / time_resolution);

	function update() {
		var a = false;
		var b = false;
		for (var i=0; i<start.length; i++) {
			if (time < end[i] * time_resolution && time > start[i] * time_resolution) {
				$("#tracks #track" + (i + 1)).addClass("active");
				if (i % 2 == 0) {
					$("#segment").addClass("a");
					a = true;
				}
				else {
					$("#segment").addClass("b");
					b = true;
				}
			}
			else {
				if (a == false) {
					$("#segment").removeClass("a");
				}
				if (b == false) {
					$("#segment").removeClass("b");
				}
				$("#tracks #track" + (i + 1)).removeClass("active");
			}
		}
		$("#tracks").css("transform", "translateX("+(-1 * time / time_resolution * scale_factor)+"px)");
		time += 1;
	}

});
