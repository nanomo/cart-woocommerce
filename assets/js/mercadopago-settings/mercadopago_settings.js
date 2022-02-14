function mp_settings_accordion_start() {
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
        accordionArrow.childNodes[1].classList.toggle("mp-arrow-up");
      }
      var panel = this.nextElementSibling;
      if (panel.style.display === "block") {
        panel.style.display = "none";
      } else {
        panel.style.display = "block";
      }
    });
  }
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

function mp_update_option_credentials() {
  const btn_credentials = document.getElementById("mp-btn-credentials");

  btn_credentials.addEventListener("click", function () {
    const credentials = {
      access_token_prod: document.getElementById("mp-access-token-prod").value,
      access_token_test: document.getElementById("mp-access-token-test").value,
      public_key_prod: document.getElementById("mp-public-key-prod").value,
      public_key_test: document.getElementById("mp-public-key-test").value,
    };

    wp.ajax
      .post("mp_update_option_credentials", credentials)
      .done(function (response) {
        mp_show_message(response, "success", "credentials");
        mp_validate_credentials_tips();
        setTimeout(() => {
          mp_go_to_next_step(
            "mp-step-1",
            "mp-step-2",
            "mp-credentials-arrow-up",
            "mp-store-info-arrow-up"
          );
        }, 3000);
      })
      .fail(function (error) {
        mp_show_message(error, "error", "credentials");
      });
  });
}

function mp_update_store_information() {
  button = document.getElementById("mp-store-info-save");
  button.addEventListener("click", function () {
    const store_information = {
      store_identificator: document.getElementById("mp-store-identificator")
        .value,
      store_category_id: document.getElementById("mp-store-category-id").value,
      store_categories: document.getElementById("mp-store-categories").value,
      store_url_ipn: document.querySelector("#mp-store-url-ipn").value,
      store_integrator_id: document.getElementById("mp-store-integrator-id")
        .value,
      store_debug_mode: document.querySelector("#mp-store-debug-mode:checked")
        ?.value,
    };
    wp.ajax
      .post("mp_update_store_information", store_information)
      .done(function (response) {
        mp_validate_store_tips();
        mp_show_message(response, "success", "store");
        setTimeout(() => {
          mp_go_to_next_step(
            "mp-step-2",
            "mp-step-3",
            "mp-store-info-arrow-up",
            "mp-payments-arrow-up"
          );
        }, 3000);
      })
      .fail(function (error) {
        mp_show_message(error, "error", "store");
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
}

function mp_set_mode() {
  var button = document.getElementById("mp-store-mode-save");
  button.addEventListener("click", function () {
    var mode_value = document.querySelector(
      'input[name="mp-test-prod"]:checked'
    ).value;
    wp.ajax
      .post("mp_store_mode", { input_mode_value: mode_value })
      .done(function (response) {
        var badge = document.getElementById("mp-mode-badge");
        var color_badge = document.getElementById("mp-orange-badge");
        var icon_badge = document.getElementById("mp-icon-badge");
        var text_badge = document.getElementById("mp-text-badge");
        var helper_test = document.getElementById("mp-helper-test");
        var helper_prod = document.getElementById("mp-helper-prod");
        text_badge.textContent = response;

        if (mode_value === "yes") {
          badge.classList.remove("mp-settings-prod-mode-alert");
          badge.classList.add("mp-settings-test-mode-alert");

          color_badge.classList.remove(
            "mp-settings-alert-payment-methods-green"
          );
          color_badge.classList.add("mp-settings-alert-payment-methods-orange");

          icon_badge.classList.remove("mp-settings-icon-success");
          icon_badge.classList.add("mp-settings-icon-warning");

          badge.textContent = "Loja em modo teste";

          helper_test.style.display = "block";
          helper_prod.style.display = "none";

          mp_show_message(response, "success", "test_mode");
        } else {
          badge.classList.remove("mp-settings-test-mode-alert");
          badge.classList.add("mp-settings-prod-mode-alert");
          badge.textContent = "Loja em modo vendas (Produção)";

          color_badge.classList.remove(
            "mp-settings-alert-payment-methods-orange"
          );
          color_badge.classList.add("mp-settings-alert-payment-methods-green");

          icon_badge.classList.remove("mp-settings-icon-warning");
          icon_badge.classList.add("mp-settings-icon-success");

          helper_test.style.display = "none";
          helper_prod.style.display = "block";

          mp_show_message(response, "success", "test_mode");
        }
      })
      .fail(function (error) {
        mp_show_message(error, "error", "test_mode");
      });
  });
}

function mp_get_payment_properties() {
  wp.ajax
    .post("mp_get_payment_properties", {})
    .done(function (response) {
      const payment = document.getElementById("mp-payment");
      response.reverse().forEach((gateway) => {
        payment.insertAdjacentHTML("afterend", mp_payment_properties(gateway));
        mp_payment_properties(gateway);
      });
    })
    .fail(function (error) {});
}

function mp_payment_properties(gateway) {
  var payment_active =
    gateway.enabled == "yes"
      ? "mp-settings-badge-active"
      : "mp-settings-badge-inactive";
  var text_payment_active =
    gateway.enabled == "yes"
      ? gateway.badge_translator.yes
      : gateway.badge_translator.no;
  return (
    ' <a href="' +
    gateway.link +
    '" class="mp-settings-link mp-settings-font-color"><div class="mp-block mp-block-flex mp-settings-payment-block mp-settings-margin-right mp-settings-align-div">\
      <div class="mp-settings-align-div">\
        <div class="mp-settings-icon ' +
    gateway.icon +
    '"></div>\
        <span class="mp-settings-subtitle-font-size mp-settings-margin-title-payment"> <b>' +
    gateway.title +
    "</b> - " +
    gateway.description +
    ' </span>\
        <span class="' +
    payment_active +
    '" > ' +
    text_payment_active +
    '</span>\
      </div>\
      <div class="mp-settings-title-align">\
      <span class="mp-settings-text-payment">Configurar</span>\
        <img class="mp-settings-icon-config">\
      </div>\
      </div></a>'
  );
}

function mp_validate_credentials_tips() {
  var icon_credentials = document.getElementById(
    "mp-settings-icon-credentials"
  );
  wp.ajax
    .post("mp_validate_credentials_tips", {})
    .done(function (response) {
      icon_credentials.classList.remove("mp-settings-icon-credentials");
      icon_credentials.classList.add("mp-settings-icon-success");
    })
    .fail(function (error) {
      icon_credentials.classList.remove("mp-settings-icon-success");
    });
}

function mp_validate_store_tips() {
  var icon_store = document.getElementById("mp-settings-icon-store");
  wp.ajax
    .post("mp_validate_store_tips", {})
    .done(function (response) {
      icon_store.classList.remove("mp-settings-icon-store");
      icon_store.classList.add("mp-settings-icon-success");
    })
    .fail(function (error) {
      icon_store.classList.remove("mp-settings-icon-success");
    });
}

function mp_validate_payment_tips() {
  var icon_payment = document.getElementById("mp-settings-icon-payment");
  wp.ajax
    .post("mp_validate_payment_tips", {})
    .done(function (response) {
      icon_payment.classList.remove("mp-settings-icon-payment");
      icon_payment.classList.add("mp-settings-icon-success");
    })
    .fail(function (error) {
      icon_payment.classList.remove("mp-settings-icon-success");
    });
}

function mp_show_message(message, type, block) {
  const messageDiv = document.createElement("div");
  var card = "";
  var heading = "";

  switch (block) {
    case "credentials":
      card = document.querySelector(".mp-message-credentials");
      heading = document.querySelector(".mp-heading-credentials");
      break;
    case "store":
      card = document.querySelector(".mp-message-store");
      heading = document.querySelector(".mp-heading-store");
      break;
    case "payment":
      card = document.querySelector(".mp-message-payment");
      heading = document.querySelector(".mp-heading-payment");
      break;
    case "test_mode":
      card = document.querySelector(".mp-message-test-mode");
      heading = document.querySelector(".mp-heading-test-mode");
      break;
    default:
      card = "";
      heading = "";
  }

  type === "error"
    ? (messageDiv.className =
        "mp-alert mp-alert-danger mp-text-center mp-card-body")
    : (messageDiv.className =
        "mp-alert mp-alert-success mp-text-center mp-card-body");

  messageDiv.appendChild(document.createTextNode(message));
  card.insertBefore(messageDiv, heading);

  setTimeout(clearMessage, 3000);
}

function clearMessage() {
  document.querySelector(".mp-alert").remove();
}

function mp_go_to_next_step(actualStep, nextStep, actualArrowId, nextArrowId) {
  var actual = document.getElementById(actualStep);
  var next = document.getElementById(nextStep);
  var actualArrow = document.getElementById(actualArrowId);
  var nextArrow = document.getElementById(nextArrowId);

  actual.style.display = "none";
  next.style.display = "block";
  actualArrow.classList.remove("mp-arrow-up");
  nextArrow.classList.add("mp-arrow-up");
}

function mp_continue_to_next_step() {
  var continueButton = document.getElementById("mp-payment-method-continue");
  continueButton.addEventListener("click", function () {
    mp_go_to_next_step(
      "mp-step-3",
      "mp-step-4",
      "mp-payments-arrow-up",
      "mp-modes-arrow-up"
    );
  });
}

function mp_settings_screen_load() {
  mp_settings_accordion_start();
  mp_settings_accordion_options();
  mp_get_requirements();
  mp_validate_credentials();
  mp_update_option_credentials();
  mp_update_store_information();
  mp_set_mode();
  mp_get_payment_properties();
  mp_validate_credentials_tips();
  mp_validate_store_tips();
  mp_validate_payment_tips();
  mp_continue_to_next_step();
}