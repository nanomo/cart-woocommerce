var form = document.querySelector("form[id=checkout]");

if (form) {
  jQuery(document).on("updated_checkout", function () {
    if (cardFormMounted) {
      cardForm.unmount();
    }

    setCustomCheckoutOnLoad();

    init_cardForm()
      .then(() => {
        setCustomCheckoutLoaded();
      })
      .catch((error) => {
        setCustomCheckoutError();
        console.error("Instance cardForm error: ", error);
      });
  });
}
