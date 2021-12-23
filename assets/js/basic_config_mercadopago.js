/*jshint multistr: true */

const payment_mercado_pago_basic = {
  initScreen: function () {
    if (!this.hasConfigurations()) {
      this.removeElements();
      return;
    }
    this.setDescriptionInputWidth();
    this.setInputMaxLength();
    this.setTitleDescriptionStyle();
    this.setHide();
    this.makeCollapsibleAdvancedConfig();
    this.setPaymentMethodsId();
    this.createOnlinePaymentsCheckAll();
    this.createDebitAndPrepaidPaymentsCheckAll();
    this.createOfflinePaymentsCheckAll();
  },
  hasConfigurations: function () {
    const settings_table = document.querySelector("table.form-table");
    return settings_table.hasChildNodes();
  },
  removeElements: function () {
    const settings_table = document.querySelector("table.form-table");
    settings_table.previousElementSibling.remove();
    settings_table.previousElementSibling.remove();
    settings_table.nextElementSibling.remove();
  },
  setDescriptionInputWidth: function () {
    var descriptionInput = document.querySelectorAll('p.description');
    for (var i = 0; i < descriptionInput.length; i++) {
      descriptionInput[i].style.width = '420px';
    }
  },
  setTitleDescriptionStyle: function () {
    //update form_fields label
    var label = document.querySelectorAll('th.titledesc');
    for (var j = 0; j < label.length; j++) {
      label[j].id = 'mp_field_text';
      if (label[j] && label[j].children[0] && label[j].children[0].children[0]) {
        label[j].children[0].children[0].style.position = 'relative';
        label[j].children[0].children[0].style.fontSize = '22px';
      }
    }
  },
  setInputMaxLength: function () {
    // Add max length to title input
    let titleInput = document.querySelectorAll('.limit-title-max-length');
    titleInput.forEach(
      (element) => {
        element.setAttribute('maxlength', '65');
      }
    );
  },
  setHide: function () {
    document.querySelectorAll('.hidden-field-mp-desc').forEach(
      (element) => {
        element.closest('tr').style.display = 'none';
      }
    );
  },
  setPaymentMethodsId: function () {
    //payment methods
    var tablePayments = document.querySelector('#woocommerce_woo-mercado-pago-basic_checkout_payments_description').nextElementSibling.getAttribute('class');
    var mp_input_payments = document.querySelectorAll('.' + tablePayments + ' td.forminp label');
    for (i = 0; i < mp_input_payments.length; i++) {
      mp_input_payments[i].id = 'mp_input_payments_mt';
    }
  },
  createOnlinePaymentsCheckAll: function () {
    //online payments
    var online_payment_translate = '';
    var onlineChecked = '';
    var countOnlineChecked = 0;
    var onlineInputs = document.querySelectorAll('.online_payment_method');
    for (var ion = 0; ion < onlineInputs.length; ion++) {
      online_payment_translate = onlineInputs[ion].getAttribute('data-translate');
      if (onlineInputs[ion].checked === true) {
        countOnlineChecked += 1;
      }
    }

    if (countOnlineChecked === onlineInputs.length) {
      onlineChecked = 'checked';
    }

    for (var oni = 0; oni < onlineInputs.length; oni++) {
      if (oni === 0) {
        var checkbox_online_prepend = '<div class="all_checkbox">\
          <label for="checkmeon" id="mp_input_payments">\
            <input type="checkbox" name="checkmeon" id="checkmeon" ' + onlineChecked + ' onclick="this.completeOnlineCheckbox()">\
            ' + online_payment_translate + '\
          </label>\
        </div>';
        onlineInputs[oni].parentElement.insertAdjacentHTML('beforebegin', checkbox_online_prepend);
        break;
      }
    }
  },
  createDebitAndPrepaidPaymentsCheckAll: function () {
    //debit and prepaid payments
    var debit_payment_translate = '';
    var debitChecked = '';
    var countDebitChecked = 0;
    var debitInputs = document.querySelectorAll('.debit_payment_method');
    for (var ideb = 0; ideb < debitInputs.length; ideb++) {
      debit_payment_translate = debitInputs[ideb].getAttribute('data-translate');
      if (debitInputs[ideb].checked === true) {
        countDebitChecked += 1;
      }
    }

    if (countDebitChecked === debitInputs.length) {
      debitChecked = 'checked';
    }

    for (var debi = 0; debi < debitInputs.length; debi++) {
      if (debi === 0) {
        var checkbox_debit_prepend = '<div class="all_checkbox">\
          <label for="checkmedeb" id="mp_input_payments">\
            <input type="checkbox" name="checkmedeb" id="checkmedeb" ' + debitChecked + ' onclick="this.completeDebitCheckbox()">\
            ' + debit_payment_translate + '\
          </label>\
        </div>';
        debitInputs[debi].parentElement.insertAdjacentHTML('beforebegin', checkbox_debit_prepend);
        break;
      }
    }
  },
  createOfflinePaymentsCheckAll: function () {
    //offline payments configuration form
    var offline_payment_translate = '';
    var offlineChecked = '';
    var countOfflineChecked = 0;
    var offlineInputs = document.querySelectorAll('.offline_payment_method');
    for (var ioff = 0; ioff < offlineInputs.length; ioff++) {
      offline_payment_translate = offlineInputs[ioff].getAttribute(['data-translate']);
      if (offlineInputs[ioff].checked === true) {
        countOfflineChecked += 1;
      }
    }

    if (countOfflineChecked === offlineInputs.length) {
      offlineChecked = 'checked';
    }

    for (var offi = 0; offi < offlineInputs.length; offi++) {
      if (offi === 0) {
        var checkbox_offline_prepend = '<div class="all_checkbox">\
          <label for="checkmeoff" id="mp_input_payments" style="margin-bottom: 37px !important;">\
            <input type="checkbox" name="checkmeoff" id="checkmeoff" ' + offlineChecked + ' onclick="this.completeOfflineCheckboxMP()">\
            ' + offline_payment_translate + '\
          </label>\
        </div>';
        offlineInputs[offi].parentElement.insertAdjacentHTML('beforebegin', checkbox_offline_prepend);
        break;
      }
    }
  },
  makeCollapsibleOptions: function (id_plus, id_less) {
    return '<span class="mp-btn-collapsible" id="' + id_plus + '" style="display:block">+</span>\
      <span class="mp-btn-collapsible" id="' + id_less + '" style="display:none">-</span>';
  },
  makeCollapsibleAdvancedConfig: function () {
    //collpase Configuración Avanzada
    var collapse_title_2 = document.querySelector('#woocommerce_woo-mercado-pago-basic_checkout_payments_advanced_title');
    var collapse_table_2 = document.querySelector('#woocommerce_woo-mercado-pago-basic_checkout_payments_advanced_description').nextElementSibling;
    var collapse_description_2 = document.querySelector('#woocommerce_woo-mercado-pago-basic_checkout_payments_advanced_description');
    collapse_table_2.style.display = 'none';
    collapse_description_2.style.display = 'none';
    collapse_title_2.style.cursor = 'pointer';

    collapse_title_2.innerHTML += this.makeCollapsibleOptions('header_plus_2', 'header_less_2');

    var header_plus_2 = document.querySelector('#header_plus_2');
    var header_less_2 = document.querySelector('#header_less_2');

    collapse_title_2.onclick = function () {
      if (collapse_table_2.style.display === 'none') {
        collapse_table_2.style.display = 'block';
        collapse_description_2.style.display = 'block';
        header_less_2.style.display = 'block';
        header_plus_2.style.display = 'none';
      } else {
        collapse_table_2.style.display = 'none';
        collapse_description_2.style.display = 'none';
        header_less_2.style.display = 'none';
        header_plus_2.style.display = 'block';
      }
    };
  },
  completeOnlineCheckbox: function () {
    var onlineCheck = document.getElementById('checkmeon').checked;
    var onlineInputs = document.querySelectorAll('.online_payment_method');
    for (var i = 0; i < onlineInputs.length; i++) {
      if (onlineCheck === true) {
        onlineInputs[i].checked = true;
      } else {
        onlineInputs[i].checked = false;
      }
    }
  },
  completeDebitCheckbox: function () {
    var debitCheck = document.getElementById('checkmedeb').checked;
    var debitInputs = document.querySelectorAll('.debit_payment_method');
    for (var i = 0; i < debitInputs.length; i++) {
      if (debitCheck === true) {
        debitInputs[i].checked = true;
      } else {
        debitInputs[i].checked = false;
      }
    }
  },
  completeOfflineCheckboxMP: function () {
    var offlineCheck = document.getElementById('checkmeoff').checked;
    var offlineInputs = document.querySelectorAll('.offline_payment_method');
    for (var i = 0; i < offlineInputs.length; i++) {
      if (offlineCheck === true) {
        offlineInputs[i].checked = true;
      } else {
        offlineInputs[i].checked = false;
      }
    }
  }
};

window.addEventListener('load', function () {
  payment_mercado_pago_basic.initScreen();
});
