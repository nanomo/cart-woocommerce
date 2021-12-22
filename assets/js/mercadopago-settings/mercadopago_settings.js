function mp_settings_accordion_start(className, subclassName, iconClass) {
	var acc = document.getElementsByClassName("mp-settings-title-align");
	var i;
	for (i = 0; i < acc.length; i++) {
		acc[i].addEventListener("click", function () {
			this.classList.toggle("active");
			if ("mp-settings-margin-left" && "mp-arrow-up") {
				var accordionArrow = null;
				for (var i = 0; i < this.childNodes.length; i++) {
					if (
						this.childNodes[i]?.classList?.contains("mp-settings-margin-left")
					) {
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
	document
		.getElementById("mp-access-token-prod")
		.addEventListener("change", function () {
			var self = this;

			wp.ajax
				.post("mp_validate_credentials", {
					access_token: this.value,
					is_test: false,
				})
				.done(function (response) {
					self.classList.add("mp-credential-feedback-positive");
					self.classList.remove("mp-credential-feedback-negative");
				})
				.fail(function (error) {
					self.classList.remove("mp-credential-feedback-positive");
					self.classList.add("mp-credential-feedback-negative");
				});
		});
	document
		.getElementById("mp-access-token-test")
		.addEventListener("change", function () {
			var self = this;

			wp.ajax
				.post("mp_validate_credentials", {
					access_token: this.value,
					is_test: true,
				})
				.done(function (response) {
					self.classList.add("mp-credential-feedback-positive");
					self.classList.remove("mp-credential-feedback-negative");
				})
				.fail(function (error) {
					self.classList.remove("mp-credential-feedback-positive");
					self.classList.add("mp-credential-feedback-negative");
				});
		});

	document
		.getElementById("mp-public-key-test")
		.addEventListener("change", function () {
			var self = this;

			wp.ajax
				.post("mp_validate_credentials", {
					public_key: this.value,
					is_test: true,
				})
				.done(function (response) {
					self.classList.add("mp-credential-feedback-positive");
					self.classList.remove("mp-credential-feedback-negative");
				})
				.fail(function (error) {
					self.classList.remove("mp-credential-feedback-positive");
					self.classList.add("mp-credential-feedback-negative");
				});
		});

	document
		.getElementById("mp-public-key-prod")
		.addEventListener("change", function () {
			var self = this;

			wp.ajax
				.post("mp_validate_credentials", {
					public_key: this.value,
					is_test: false,
				})
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

function update_option_credentials() {
	const btn_credentials = document.getElementById("mp-btn-credentials");

	btn_credentials.addEventListener("click", function () {
		const credentials = {
			access_token_prod: document.getElementById("mp-access-token-prod").value,
			access_token_test: document.getElementById("mp-access-token-test").value,
			public_key_prod: document.getElementById("mp-public-key-prod").value,
			public_key_test: document.getElementById("mp-public-key-test").value,
		};

		wp.ajax
			.post("update_option_credentials", credentials)
			.done(function (response) {
				console.log("ok");
			})
			.fail(function (error) {
				console.log("error");
			});
	});

	console.log("MP option update!");
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
			store_debug_mode: document.querySelector("#mp-store-debug-mode:checked")?.value,
		};
		wp.ajax
			.post("mp_validate_store_information", store_information)
			.done(function (response) {
				console.log(response);
			})
			.fail(function (error) {
				console.log(error);
			});
	});
}

function mp_settings_accordion_options() {
  var element = document.getElementById("options");
  var elementBlock = document.getElementById("block-two");

  element.addEventListener("click", function () {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
      panel.style.display = "none";
    } else {
      panel.style.display = "block";
    }

    /* Altera o alinhamento vertical */
    if (
      !element.classList.contains("active") &&
      !elementBlock.classList.contains("mp-settings-flex-start")
    ) {
      elementBlock.classList.toggle("mp-settings-flex-start");
      element.textContent = "Ver opções avançadas";
    } else {
      element.textContent = "Ocultar opções avançadas";
      elementBlock.classList.remove("mp-settings-flex-start");
    }
  });

  console.log("MP Settings Accordion Started 2!");
}

function mp_store_mode() {

  var button = document.getElementById("mp-store-mode-save");

  button.addEventListener("click", function () {
    var input_mode_id = document.querySelector('input[name="mp-test-prod"]:checked').value;
    input_value = ( input_mode_id === 'yes' )? 'yes' : 'no';
    console.log(input_value);
    wp.ajax
      .post("mp_store_mode", input_value)
      .done(function (response) {
        console.log(response);
      })
      .fail(function (error) {
        console.log(error);
      });
  });

}

function mp_settings_screen_load() {
	mp_settings_accordion_start();
	mp_settings_accordion_options();
	mp_get_requirements();
	mp_validate_credentials();
	update_option_credentials();
	mp_validate_store_information();
};


