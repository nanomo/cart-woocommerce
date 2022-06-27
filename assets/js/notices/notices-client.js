/* globals wc_mercadopago_notices_params */
(function () {
  window.addEventListener("load", function () {
    try {
      var link = document.createElement("link");
      link.rel = "stylesheet";
      link.type = "text/css";
      link.href = "https://http2.mlstatic.com/storage/homol/v1/plugins/notices/woocommerce.css?v=100";

      link.onerror = function () {
        console.error("Error on load mpnotices woocommerce client styles");
      };

      link.onload = function () {
        var scriptTag = document.createElement("script");
        scriptTag.setAttribute("id", "mpnotices_woocommerce_client");
        scriptTag.src = "https://http2.mlstatic.com/storage/homol/v1/plugins/notices/woocommerce.js?v=100";
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
