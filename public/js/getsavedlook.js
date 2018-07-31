$(document).ready(function getScreenshot() {
	var btn = $("#saveBtn");
	btn.on("click", function() {
		var video = document.getElementById("#videoel");
		html2canvas(video).then(function(canvas) {
			var base64image = canvas.toDataURL("image.png");
			window.open(base64image, "_blank");
		});
	});
});