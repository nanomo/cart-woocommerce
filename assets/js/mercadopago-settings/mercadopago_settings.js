function mp_settings_accordion_start() {
	var acc = document.getElementsByClassName("mp-settings-title-align");
	var i;
	for (i = 0; i < acc.length; i++) {
		acc[i].addEventListener("click", function () {
			this.classList.toggle("active");
			var accordionArrow = null;
			console.log(this.childNodes);
			for (var i = 0; i < this.childNodes.length; i++) {
				if (
					this.childNodes[i]?.classList?.contains("mp-settings-margin-left")
				) {
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
function update_option_credentials() {}

window.addEventListener("load", function () {
	mp_settings_accordion_start();
	mp_get_requirements();
	mp_validate_credentials();
});
