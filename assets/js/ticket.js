/* jshint es3: false */
/* globals wc_mercadopago_ticket_params */
(function ($) {
  "use strict";

  $(function () {
    var mercado_pago_submit_ticket = false;

    /**
     * Handler form submit
     * @return {bool}
     */
    function mercadoPagoFormHandlerTicket() {
      if (
        !document.getElementById("payment_method_woo-mercado-pago-ticket")
          .checked
      ) {
        return true;
      }

      let ticketContent = document.querySelector(".mp-checkout-ticket-content");
      let ticketHelpers = ticketContent.querySelectorAll("input-helper");

      verifyDocument(ticketContent, ticketHelpers);
      verifyInstallments();

      if (!checkForErrors(ticketHelpers)) {
        mercado_pago_submit_ticket = true;
      } else {
        removeBlockOverlay();
      }

      return mercado_pago_submit_ticket;
    }

    function checkForErrors(ticketHelpers) {
      ticketHelpers.forEach((item) => {
        let inputHelper = item.querySelector("div");
        if (inputHelper.style.display != "none") return true;
      });
      return false;
    }

    function verifyDocument(ticketContent, ticketHelpers) {
      let documentElement = ticketContent.querySelectorAll(".mp-document");

      if (documentElement[0].value == "") {
        let child = ticketHelpers[0].querySelector("div");
        child.style.display == "flex";
      }
    }

    function verifyInstallments() {
      let paymentOptionSelected = false;
      document.querySelectorAll(".mp-input-radio-radio").forEach((item) => {
        if (item.checked) paymentOptionSelected = true;
      });

      if (paymentOptionSelected == false)
        CheckoutPage.setDisplayOfInputHelper("mp-payment-method", "flex");

      const radioElements = document.getElementsByClassName(
        "mp-input-table-label"
      );
      for (var i = 0; i < radioElements.length; i++) {
        radioElements[i].addEventListener("click", () => {
          CheckoutPage.setDisplayOfInputHelper("mp-payment-method", "none");
        });
      }
    }

    // Process when submit the checkout form.
    $("form.checkout").on(
      "checkout_place_order_woo-mercado-pago-ticket",
      function () {
        return mercadoPagoFormHandlerTicket();
      }
    );

    // If payment fail, retry on next checkout page
    $("form#order_review").submit(function () {
      return mercadoPagoFormHandlerTicket();
    });

    /**
     * Remove Block Overlay from Order Review page
     */
    function removeBlockOverlay() {
      if ($("form#order_review").length > 0) {
        $(".blockOverlay").css("display", "none");
      }
    }
  });
})(jQuery);
