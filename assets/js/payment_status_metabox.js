window.addEventListener("load", () => {
    const orderDataElement = document.getElementById("woocommerce-order-data");
    const paymentStatusMetaboxElement = document.getElementById("payment-status-metabox");

    orderDataElement.after(paymentStatusMetaboxElement);
});
