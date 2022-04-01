/* globals wc_melidata_params */
(function () {
  window.onload = function () {
    window.melidata = null;

    try {
      var scriptTag = document.createElement("script");

      scriptTag.setAttribute("id", "melidata_woocommerce_client");
      scriptTag.src = "http://localhost:8080/development/woocommerce";
      scriptTag.async = true;
      scriptTag.defer = true;

      scriptTag.onload = function () {
        window.melidata = new MelidataClient({
          siteID: wc_melidata_params.site_id,
          pluginVersion: wc_melidata_params.platform_version,
          platformVersion: wc_melidata_params.plugin_version,
          pageLocation: "admin",
        });
      };

      document.body.appendChild(scriptTag);
    } catch (e) {
      console.warn(e);
    }
  };
})();
