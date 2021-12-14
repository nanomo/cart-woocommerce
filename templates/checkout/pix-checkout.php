<?php

/**
 * Part of Woo Mercado Pago Module
 * Author - Mercado Pago
 * Developer
 * Copyright - Copyright(c) MercadoPago [https://www.mercadopago.com]
 * License - https://www.gnu.org/licenses/gpl.html GPL version 2 or higher
 *
 * @package MercadoPago
 */

if ( ! defined('ABSPATH') ) {
	exit;
}
?>

<div class="mp-checkout-pix-container">
    <div class="mp-checkout-pix-test-mode">
        <test-mode
            title="Pix in Test Mode"
            description="You can test the flow to generate a code, but you cannot finalize the payment."
        >
        </test-mode>
    </div>

    <pix-template
        title="Pay instantly."
        subtitle="By confirming your purchase, we will show you a code to make the payment."
        src="https://raw.githubusercontent.com/PluginAndPartners/mpmodules-narciso/develop/src/assets/images/pix-logo.png?token=ADYLYLZL7L34M4WQDXKIKDLBYHU3O"
        alt="PIX logo"
    >
    </pix-template>

    <div class="mp-checkout-pix-terms-and-conditions">
        <terms-and-conditions
            description="By continuing, you agree with our"
            link-text="Terms and Conditions"
            link-src="https://developers.mercadopago.com"
        >
        </terms-and-conditions>
    </div>
</div>
