window.addEventListener("load", () => {
    const orderDataElement = document.getElementById("woocommerce-order-data");
    const paymentStatusMetaboxElement = document.getElementById("payment-status-metabox");
    const paymentStatusMetaboxTitle = document.querySelector('#payment-status-metabox > div.postbox-header > h2');

    if (orderDataElement) {
        orderDataElement.after(paymentStatusMetaboxElement);
        paymentStatusMetaboxTitle.style.fontFamily = "'Lato', sans-serif";
        paymentStatusMetaboxTitle.style.fontSize = "18px";
    }
});
