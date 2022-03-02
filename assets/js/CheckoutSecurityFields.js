var mp_security_fields_loaded = false;

jQuery( document ).on( 'updated_checkout', function() {
	updated_checkout = true
	if(!mp_security_fields_loaded){
		init_cardForm();			
		mp_security_fields_loaded = true;
	}
}); 