$(document).ready(function() {
	$(".link").on("click", function() {
		$(this).addClass("active").siblings().removeClass("active");
		$(".tabcontent").hide();
		var anEvent = $(this).html();
		$("#" + anEvent).show();
	});
});

$("#About").hide();
$("#Testimonials").hide();
$("#Contact").hide();
$("#Gallery").hide();