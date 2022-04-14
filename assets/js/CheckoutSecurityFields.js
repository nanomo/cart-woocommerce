var mp_security_fields_loaded = false;
var form = document.querySelector('form[id=checkout]')

if (form) {
	jQuery( document ).on( 'updated_checkout', function() {
		if(mp_security_fields_loaded){
      cardForm.unmount();
		}
    init_cardForm();
    mp_security_fields_loaded = true;
	});
}
