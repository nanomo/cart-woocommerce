function mp_settings_accordion_start( className , subclassName, iconClass) {

	var acc = document.getElementsByClassName( "mp-settings-title-align" );
	var i;
	for (i = 0; i < acc.length; i++) {
		acc[i].addEventListener("click", function() {
			this.classList.toggle("active");
			if( "mp-settings-margin-left" && "mp-arrow-up" ){
				var accordionArrow = null;
					for (var i = 0; i < this.childNodes.length; i++) {
						if (this.childNodes[i]?.classList?.contains( "mp-settings-margin-left" )) {
							accordionArrow = this.childNodes[i];
							break;
						}
				}
				accordionArrow.childNodes[1].classList.toggle(iconClass);
			}
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

function mp_get_requirements() {
	wp.ajax.post( "mp_get_requirements", {} )
	  .done(function(response) {
		  const requirements = {
			  ssl: document.getElementById('mp-req-ssl'),
			  gd_ext: document.getElementById('mp-req-gd'),
			  curl_ext: document.getElementById('mp-req-curl')
		  };

		  for (let i in requirements) {
			  let requirement = requirements[i];
			  requirement.style = '';
			  if (!response[i]) {
				  requirement.classList.remove('mp-settings-icon-success');
				  requirement.classList.add('mp-settings-icon-warning');
			  }
		  }
	  });
}

window.addEventListener('load', function () {
	mp_get_requirements();
	mp_settings_accordion_start();
	mp_settings_accordion_options();
	mp_get_requirements();
});


function mp_settings_accordion_options( ) {

	var element = document.getElementById( 'options');
	var elementBlock = document.getElementById('block-two');

		element.addEventListener("click", function() {
			this.classList.toggle("active");
			var panel = this.nextElementSibling;
			if (panel.style.display === "block") {
				panel.style.display = "none";
			} else {
				panel.style.display = "block";
			}

			/* Altera o alinhamento vertical */
			if( !element.classList.contains("active") && !elementBlock.classList.contains("mp-settings-flex-start") ){
				elementBlock.classList.toggle("mp-settings-flex-start");
				element.textContent="Ver opções avançadas";

			} else {
				element.textContent="Ocultar opções avançadas";
				elementBlock.classList.remove("mp-settings-flex-start");
			}

		});

	console.log('MP Settings Accordion Started 2!');
}
