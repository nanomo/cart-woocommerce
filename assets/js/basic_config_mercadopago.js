/*jshint multistr: true */

window.addEventListener('load', function () {
  var descriptionInput = document.querySelectorAll('p.description');
  for (var i = 0; i < descriptionInput.length; i++) {
    descriptionInput[i].style.width = '420px';
  }

  //update form_fields label
  var label = document.querySelectorAll('th.titledesc');
  for (var j = 0; j < label.length; j++) {
    label[j].id = 'mp_field_text';
    if (label[j] && label[j].children[0] && label[j].children[0].children[0]) {
      label[j].children[0].children[0].style.position = 'relative';
      label[j].children[0].children[0].style.fontSize = '22px';
    }
  }

  // Add max length to title input
  let titleInput = this.document.querySelectorAll('.limit-title-max-length');
  titleInput.forEach(
    (element) => {
      element.setAttribute('maxlength', '65');
    }
  );

  document.querySelectorAll('.hidden-field-mp-desc').forEach(
    (element) => {
      element.closest('tr').style.display = 'none';
    }
  );

  //payment methods
  var tablePayments = document.querySelector('#woocommerce_woo-mercado-pago-basic_checkout_payments_description').nextElementSibling.getAttribute('class');
  var mp_input_payments = document.querySelectorAll('.' + tablePayments + ' td.forminp label');
  for (i = 0; i < mp_input_payments.length; i++) {
    mp_input_payments[i].id = 'mp_input_payments_mt';
  }

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
            <input type="checkbox" name="checkmeon" id="checkmeon" ' + onlineChecked + ' onclick="completeOnlineCheckbox()">\
            ' + online_payment_translate + '\
          </label>\
        </div>';
      onlineInputs[oni].parentElement.insertAdjacentHTML('beforebegin', checkbox_online_prepend);
      break;
    }
  }

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
            <input type="checkbox" name="checkmedeb" id="checkmedeb" ' + debitChecked + ' onclick="completeDebitCheckbox()">\
            ' + debit_payment_translate + '\
          </label>\
        </div>';
      debitInputs[debi].parentElement.insertAdjacentHTML('beforebegin', checkbox_debit_prepend);
      break;
    }
  }

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
            <input type="checkbox" name="checkmeoff" id="checkmeoff" ' + offlineChecked + ' onclick="completeOfflineCheckboxMP()">\
            ' + offline_payment_translate + '\
          </label>\
        </div>';
      offlineInputs[offi].parentElement.insertAdjacentHTML('beforebegin', checkbox_offline_prepend);
      break;
    }
  }

//Online payments
  window.completeOnlineCheckbox = function () {
    var onlineCheck = document.getElementById('checkmeon').checked;
    var onlineInputs = document.querySelectorAll('.online_payment_method');
    for (var i = 0; i < onlineInputs.length; i++) {
      if (onlineCheck === true) {
        onlineInputs[i].checked = true;
      } else {
        onlineInputs[i].checked = false;
      }
    }
  };

//Debit and prepaid payments
  window.completeDebitCheckbox = function () {
    var debitCheck = document.getElementById('checkmedeb').checked;
    var debitInputs = document.querySelectorAll('.debit_payment_method');
    for (var i = 0; i < debitInputs.length; i++) {
      if (debitCheck === true) {
        debitInputs[i].checked = true;
      } else {
        debitInputs[i].checked = false;
      }
    }
  };

//Offline payments
  window.completeOfflineCheckboxMP = function () {
    var offlineCheck = document.getElementById('checkmeoff').checked;
    var offlineInputs = document.querySelectorAll('.offline_payment_method');
    for (var i = 0; i < offlineInputs.length; i++) {
      if (offlineCheck === true) {
        offlineInputs[i].checked = true;
      } else {
        offlineInputs[i].checked = false;
      }
    }
  };

});
