/* globals wc_mercadopago_notices_params */
(function () {
  window.addEventListener("load", function () {
    try {
      var link = document.createElement("link");
      link.rel = "stylesheet";
      link.type = "text/css";
      link.href = wc_mercadopago_notices_params.notices_css_link;

      link.onerror = function () {
        console.error("Error on load mpnotices woocommerce client styles");
      };

      link.onload = function () {
        var scriptTag = document.createElement("script");
        scriptTag.setAttribute("id", "mpnotices_woocommerce_client");
        scriptTag.src = wc_mercadopago_notices_params.notices_js_link;
        scriptTag.async = true;
        scriptTag.defer = true;

        scriptTag.onerror = function () {
          console.error("Error on load mpnotices woocommerce client script");
        };

        document.body.appendChild(scriptTag);
      };

      document.body.appendChild(link);
    } catch (e) {
      console.warn(e);
    }
  });
})();
