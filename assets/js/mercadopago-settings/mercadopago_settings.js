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

window.addEventListener("load", function () {
	mp_settings_accordion_start();
	mp_get_requirements();
	mp_validate_credentials();
	update_option_credentials();
});
