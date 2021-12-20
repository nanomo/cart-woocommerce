function mp_settings_accordion_start(className, subclassName, iconClass) {

	var acc = document.getElementsByClassName("mp-settings-title-align");
	var i;
	for (i = 0; i < acc.length; i++) {
		acc[i].addEventListener("click", function () {
			this.classList.toggle("active");
			if ("mp-settings-margin-left" && "mp-arrow-up") {
				var accordionArrow = null;
				for (var i = 0; i < this.childNodes.length; i++) {
					if (this.childNodes[i]?.classList?.contains("mp-settings-margin-left")) {
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
	console.log("MP Settings Accordion Started!");
}

function mp_get_requirements() {
	wp.ajax.post("mp_get_requirements", {}).done(function (response) {
		const requirements = {
			ssl: document.getElementById("mp-req-ssl"),
			gd_ext: document.getElementById("mp-req-gd"),
			curl_ext: document.getElementById("mp-req-curl"),
		};

		for (let i in requirements) {
			let requirement = requirements[i];
			requirement.style = "";
			if (!response[i]) {
				requirement.classList.remove("mp-settings-icon-success");
				requirement.classList.add("mp-settings-icon-warning");
			}
		}
	});
}

function mp_validate_credentials() {
	const credentials_access_token = {
		access_token_prod: document.getElementById("mp-access-token-prod"),
		access_token_test: document.getElementById("mp-access-token-test"),
	};
	const credentials_public_key = {
		public_key_prod: document.getElementById("mp-public-key-prod"),
		public_key_test: document.getElementById("mp-public-key-test"),
	};

	for (let i in credentials_access_token) {
		let credential = credentials_access_token[i];

		credential.addEventListener("change", function () {
			var self = this;

			wp.ajax
				.post("mp_validate_credentials", { access_token: this.value })
				.done(function (response) {
					self.classList.add("mp-credential-feedback-positive");
					self.classList.remove("mp-credential-feedback-negative");
				})
				.fail(function (error) {
					self.classList.remove("mp-credential-feedback-positive");
					self.classList.add("mp-credential-feedback-negative");
				});
		});
	}
	for (let i in credentials_public_key) {
		let credential = credentials_public_key[i];

		credential.addEventListener("change", function () {
			var self = this;

			wp.ajax
				.post("mp_validate_credentials", { public_key: this.value })
				.done(function (response) {
					self.classList.add("mp-credential-feedback-positive");
					self.classList.remove("mp-credential-feedback-negative");
				})
				.fail(function (error) {
					self.classList.remove("mp-credential-feedback-positive");
					self.classList.add("mp-credential-feedback-negative");
				});
		});
	}
}


function mp_validate_store_information() {

	console.log("chegando aqui");

	button = document.getElementById("mp-store-info-save");
	button.addEventListener("click", function () {
		const store_information = {
			store_identificator: document.getElementById("mp-store-identificator").value,
			store_category_id: document.getElementById("mp-store-category-id").value,
			store_categories: document.getElementById("mp-store-categories").value,
			store_url_ipn: document.querySelector("#mp-store-url-ipn").value,
			store_integrator_id: document.getElementById("mp-store-integrator-id").value,
			store_debug_mode : document.querySelector("#mp-store-debug-mode:checked")?.value,
		};
		wp.ajax
			.post("mp_validate_store_information", store_information)
			.done(function (response) {
				console.log(response)
			})
			.fail(function (error) {
				console.log(error)
			});
	});

}

function update_option_credentials() { }

window.addEventListener("load", function () {
	mp_settings_accordion_start();
	mp_settings_accordion_options();
	mp_get_requirements();
	mp_validate_credentials();
	mp_validate_store_information();

});


function mp_settings_accordion_options() {

	var element = document.getElementById('options');
	var elementBlock = document.getElementById('block-two');

	element.addEventListener("click", function () {
		this.classList.toggle("active");
		var panel = this.nextElementSibling;
		if (panel.style.display === "block") {
			panel.style.display = "none";
		} else {
			panel.style.display = "block";
		}

		/* Altera o alinhamento vertical */
		if (!element.classList.contains("active") && !elementBlock.classList.contains("mp-settings-flex-start")) {
			elementBlock.classList.toggle("mp-settings-flex-start");
			element.textContent = "Ver opções avançadas";

		} else {
			element.textContent = "Ocultar opções avançadas";
			elementBlock.classList.remove("mp-settings-flex-start");
		}

	});

	console.log('MP Settings Accordion Started 2!');
}

function mp_save_store_info() {
	var element = document.getElementById('mp-store-info-save');

	element.addEventListener("onclick", function () {
		mp_validate_store_information();
		alert('info sent');
	})
}
