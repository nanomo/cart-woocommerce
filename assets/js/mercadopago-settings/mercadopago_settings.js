function mp_settings_accordion_start() {
	var acc = document.getElementsByClassName("mp-settings-title-align");
	var i;
	for (i = 0; i < acc.length; i++) {
		acc[i].addEventListener("click", function() {
			this.classList.toggle("active");
			var accordionArrow = null;
			console.log(this.childNodes);
			for (var i = 0; i < this.childNodes.length; i++) {
				if (this.childNodes[i]?.classList?.contains('mp-settings-margin-left')) {
					accordionArrow = this.childNodes[i];
					break;
				}
			}

			accordionArrow.childNodes[1].classList.toggle("mp-arrow-up");

			var panel = this.nextElementSibling;
			if (panel.style.display === "block") {
				panel.style.display = "none";
			} else {
				panel.style.display = "block";
			}
		});
	}
	console.log('MP Settings Accordion Started!');
}

window.addEventListener('load', function () {
	mp_settings_accordion_start();
});
