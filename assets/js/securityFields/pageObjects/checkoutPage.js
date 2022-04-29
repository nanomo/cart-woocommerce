const CheckoutPage = {
  setElementDisplay(element, operator) {
    document.querySelector(CheckoutElements[element]).style.display = operator;
  },

  setText(element, text) {
    document.querySelector(CheckoutElements[element]).innerHTML = text;
  },

  setValue(element, value) {
    document.querySelector(CheckoutElements[element]).value = value;
  },

  setBackground(element, background) {
    document.querySelector(CheckoutElements[element]).style.background =
      background;
  },

  setImageCard(secureThumbnail) {
    this.setBackground(
      "fcCardholderNameContainer",
      "url(" + secureThumbnail + ") 98% 50% no-repeat #fff"
    );
    document.querySelector(
      CheckoutElements.fcCardholderNameContainer
    ).style.backgroundSize = "auto 24px";
  },

  setDisplayOfInputHelper(name, operator) {
    let divInputHelper = document.querySelector(
      "input-helper[input-id=" + name + "-helper]"
    );
    if (divInputHelper) {
      let inputHelper = divInputHelper.querySelector("div");
      inputHelper.style.display = operator;
    }
  },

  setCvvHint(securityCode) {
    var cvvText = wc_mercadopago_params.cvvText;
    cvvText = `${securityCode.length} ${cvvText} `;
    cvvText += this.cvvLocationTranslate(securityCode.card_location);
    this.setText("mpSecurityCodeInfo", cvvText);
  },

  cvvLocationTranslate(location) {
    $cvvFront = wc_mercadopago_params.cvvHint["front"];
    $cvvBack = wc_mercadopago_params.cvvHint["back"];
    return location === "back" ? $cvvBack : $cvvFront;
  },

  additionalInfoHandler(additionalInfoNeeded) {
    if (additionalInfoNeeded.cardholder_name) {
      this.setElementDisplay("fcCardholderName", "block");
    } else {
      this.setElementDisplay("fcCardholderName", "none");
    }

    if (additionalInfoNeeded.issuer) {
      this.setElementDisplay("mpIssuerContainer", "block");
    } else {
      this.setElementDisplay("mpIssuerContainer", "none");
    }

    if (
      additionalInfoNeeded.cardholder_identification_type &&
      additionalInfoNeeded.cardholder_identification_number
    ) {
      this.setElementDisplay("mpDocumentContainer", "block");
    } else {
      this.setElementDisplay("mpDocumentContainer", "none");
    }
  },

  getCountry() {
    return wc_mercadopago_params.site_id;
  },

  changeCvvPlaceHolder(cvvLength) {
    let text = "";
    for (let index = 0; index < cvvLength; index++) {
      text += index + 1;
    }
    cardForm.update("securityCode", { placeholder: text });
  },

  clearTax() {
    this.setElementDisplay("mpInputTaxCft", "none");
    this.setText("mpTaxCftText", "");
    this.setText("mpTaxTeaText", "");
  },

  handleInstallments(paymentTypeId) {
    let element = document.querySelector(CheckoutElements.fcInstallments);

    if (paymentTypeId === "debit_card") {
      element.setAttribute("disabled", "disabled");
    } else {
      element.removeAttribute("disabled");
    }
  },

  formatCurrency(value) {
    const formatter = new Intl.NumberFormat("es-AR", {
      style: "currency",
      currency: "ARS",
      currencyDisplay: "narrowSymbol",
    });

    return formatter.format(value);
  },

  inputHelperName(field) {
    let inputHelperName = {
      cardNumber: CheckoutElements.mpCardNumber,
      cardholderName: CheckoutElements.mpCardholderName,
      expirationDate: CheckoutElements.mpExpirationDate,
      securityCode: CheckoutElements.mpSecurityCode,
      identificationNumber: CheckoutElements.mpIdentificationNumber,
    };
    return inputHelperName[field];
  },

  removeAdditionFields() {
    this.setElementDisplay("mpDocumentContainer", "none");
    this.setElementDisplay("mpInstallments", "none");
    this.setElementDisplay("mpIssuerContainer", "none");
    this.setDisplayOfInputHelper("installments", "none");
    this.setValue("cardInstallments", "");
  },

  clearInstallmentsComponent() {
    const selectorInstallments = document.querySelector(
      CheckoutElements.mpInstallmentsContainer
    );
    selectorInstallments.classList.remove(
      CheckoutElements.mpInstallmentsContainer
    );

    if (selectorInstallments.firstElementChild) {
      selectorInstallments.removeChild(selectorInstallments.firstElementChild);
    }
  },

  showInstallmentsComponent(child) {
    const selectorInstallments = document.querySelector(
      CheckoutElements.mpInstallmentsContainer
    );
    selectorInstallments.classList.add(
      CheckoutElements.mpInstallmentsContainer
    );
    selectorInstallments.appendChild(child);
  },

  getHelperMessage(field) {
    let query =
      "input-helper[input-id=" + this.inputHelperName(field) + "-helper]";
    let divInputHelper = document.querySelector(query);
    let helperMessage = divInputHelper.querySelector(
      "div[class=mp-helper-message]"
    );
    return helperMessage;
  },

  argentinaResolution(payerCosts) {
    let dataInput = "";

    if (this.getCountry() === "mla") {
      for (let l = 0; l < payerCosts.length; l++) {
        if (payerCosts[l].indexOf("CFT_") !== -1) {
          dataInput = payerCosts[l];
        }
      }
    }

    return dataInput;
  },

  hideErrors() {
    let inputHelpers = document.querySelectorAll("input-helper");
    inputHelpers.forEach((inputHelper) => {
      inputHelper.querySelector("div").style.display = "none";
    });
  },

  clearInputs() {
    this.hideErrors();

    this.setBackground("fcCardholderNameContainer", "no-repeat #fff");
    this.setValue("fcCardExpirationDateContainer", "");
    this.setValue("fcIdentificationNumber", "");
    this.setValue("fcSecurityNumberContainer", "");
    this.setValue("fcCardholderName", "");
  },

  verifyDocument() {
    let input = document.querySelector(CheckoutElements.fcIdentificationNumber);
    if (input.value === "-1" || input.value === "") {
      return false;
    }

    let inputHelper = document.querySelector(
      "input-helper[input-id=mp-doc-number-helper]"
    );
    if (inputHelper.querySelector("div").style.display == "flex") {
      return false;
    }

    return true;
  },

  loadAdditionalInfo(sdkAdditionalInfoNeeded) {
    additionalInfoNeeded = {
      issuer: false,
      cardholder_name: false,
      cardholder_identification_type: false,
      cardholder_identification_number: false,
    };

    for (let i = 0; i < sdkAdditionalInfoNeeded.length; i++) {
      if (sdkAdditionalInfoNeeded[i] === "issuer_id") {
        additionalInfoNeeded.issuer = true;
      }
      if (sdkAdditionalInfoNeeded[i] === "cardholder_name") {
        additionalInfoNeeded.cardholder_name = true;
      }
      if (sdkAdditionalInfoNeeded[i] === "cardholder_identification_type") {
        additionalInfoNeeded.cardholder_identification_type = true;
      }
      if (sdkAdditionalInfoNeeded[i] === "cardholder_identification_number") {
        additionalInfoNeeded.cardholder_identification_number = true;
      }
    }
  },

  verifyInstallments() {
    if (document.querySelector(CheckoutElements.cardInstallments).value == "") {
      this.setDisplayOfInputHelper("mp-installments", "flex");
      return false;
    }
    this.setDisplayOfInputHelper("mp-installments", "none");
    return true;
  },

  validateInputsCreateToken() {
    let isInstallmentsValid = this.verifyInstallments();
    let isDocumentValid = this.verifyDocument();
    return isInstallmentsValid && isDocumentValid ? true : false;
  },

  showTaxes() {
    const selectorInstallments = document.querySelectorAll(
      CheckoutElements.mpInputRadio
    );
    let tax = null;
    let display = "block";

    selectorInstallments.forEach((installment) => {
      if (installment.checked) {
        tax = installment.getAttribute("datarate");
      }
    });

    let cft = "";
    let tea = "";

    if (tax != null) {
      const tax_split = tax.split("|");

      cft = tax_split[0].replace("_", " ");
      tea = tax_split[1].replace("_", " ");

      if (cft === "CFT 0,00%" && tea === "TEA 0,00%") {
        display = "none";
        cft = "";
        tea = "";
      }
    }

    document.querySelector(CheckoutElements.mpInputTaxCft).style.display =
      display;
    document.querySelector(CheckoutElements.mpTaxCftText).innerHTML = cft;
    document.querySelector(CheckoutElements.mpTaxTeaText).innerHTML = tea;
  },

  setupTaxEvents() {
    const taxesElements = document.getElementsByClassName(
      "mp-input-table-label"
    );
    for (var i = 0; i < taxesElements.length; i++) {
      let installmentValue =
        taxesElements[i].getElementsByTagName("input")[0].value;
      taxesElements[i].addEventListener("click", this.showTaxes);
      taxesElements[i].addEventListener("click", () => {
        this.setValue("fcInstallments", installmentValue);
        this.setValue("cardInstallments", installmentValue);
      });
    }
  },

  getInstallments(response) {
    let payerCosts = [];
    const installments = [];

    this.clearInstallmentsComponent();
    payerCosts = response.payer_costs;
    if (payerCosts) {
      this.setElementDisplay("mpInstallments", "block");
    }

    for (let j = 0; j < payerCosts.length; j++) {
      const installment = payerCosts[j].installments;
      const installmentRate = payerCosts[j].installment_rate === 0;

      installments.push({
        id: `installment-${installment}`,
        value: installment,
        rowText: `${installment}x ${this.formatCurrency(
          payerCosts[j].installment_amount
        )}`,
        rowObs: installmentRate
          ? wc_mercadopago_params.installmentObsFee
          : this.formatCurrency(payerCosts[j].total_amount),
        highlight: installmentRate ? "true" : "",
        dataRate: this.argentinaResolution(payerCosts[j].labels),
      });
    }

    return installments;
  },

  setChangeEventOnInstallments(siteId, response) {
    var installments = this.getInstallments(response);

    const inputTable = document.createElement("input-table");
    inputTable.setAttribute("name", "mp-installments");
    inputTable.setAttribute(
      "button-name",
      wc_mercadopago_params.installmentButton
    );
    inputTable.setAttribute("columns", JSON.stringify(installments));
    this.setElementDisplay("mpInstallments", "block");
    this.showInstallmentsComponent(inputTable);
    this.setupTaxEvents();
    document.getElementById("more-options").addEventListener("click", () => {
      setTimeout(() => {
        this.setupTaxEvents();
      }, 200);
    });

    if (siteId === "mla") {
      this.clearTax();
    }
  },
};
