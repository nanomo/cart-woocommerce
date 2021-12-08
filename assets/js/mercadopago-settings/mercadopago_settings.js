window.addEventListener('load', function () {
	console.log('Mercado Pago Settings');

	var acc = document.getElementsByClassName("mp-settings-badge-spacing");
	var i;
	console.log(acc)
	for (i = 0; i < acc.length; i++) {
		acc[i].addEventListener("click", function() {
			this.classList.toggle("active");
			var accordionArrow = null;
			console.log(this.childNodes)
			for (var i = 0; i < this.childNodes.length; i++) {
				if (this.childNodes[i]?.classList?.contains('mp-settings-margin-left')) {
					accordionArrow = this.childNodes[i];
					break;
				}
			}

			accordionArrow.classList.toggle("arrow-up");

			var panel = this.nextElementSibling;
			if (panel.style.display === "block") {
				panel.style.display = "none";

			} else {
				panel.style.display = "block";
			}
		});
	}
});
