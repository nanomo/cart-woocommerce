/* globals wc_mercadopago_notices_params */
(function () {
  window.addEventListener("load", function () {
    try {
      var link = document.createElement("link");
      link.rel = "stylesheet";
      link.type = "text/css";
      link.href = "https://http2.mlstatic.com/storage/v1/plugins/notices/woocommerce.css";

      link.onerror = function () {
        sendError({ target: "notices_woocommerce_client_css" });
      };

      link.onload = function () {
        var scriptTag = document.createElement("script");
        scriptTag.setAttribute("id", "mpnotices_woocommerce_client");
        scriptTag.src = "https://http2.mlstatic.com/storage/v1/plugins/notices/woocommerce.js";
        scriptTag.async = true;
        scriptTag.defer = true;

        scriptTag.onerror = function () {
          sendError({ target: "notices_woocommerce_client_js" });
        };

        document.body.appendChild(scriptTag);
      };

      document.body.appendChild(link);
    } catch (e) {
      console.warn(e);
    }
  });

  function sendError({ target }) {
    var url = "https://api.mercadopago.com/v1/plugins/notices/metrics";
    var payload = {
      target,
      type: "error",
      name: "ERR_CONNECTION_REFUSED",
      message: "ERR_CONNECTION_REFUSED",
      plugin: {
        version: wc_mercadopago_notices_params.plugin_version,
      },
      platform: {
        name: "woocommerce",
        uri: `${window.location.pathname}${window.location.search}`,
        version: wc_mercadopago_notices_params.platform_version,
        location: wc_mercadopago_notices_params.location,
      },
    };

    navigator.sendBeacon(url, JSON.stringify(payload));
  }
})();
