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

if (!defined('ABSPATH')) {
	exit;
}
?>

<div class="mp-checkout-ticket-container">
	<div class="mp-checkout-ticket-content">
		<?php if (true === $test_mode) : ?>
			<div class="mp-checkout-ticket-test-mode">
				<test-mode
					title="<?php echo esc_html_e('Offline Methods in Test Mode', 'woocommerce-mercadopago'); ?>"
					description="<?php echo esc_html_e('You can test the flow to generate an invoice, but you cannot finalize the payment. ', 'woocommerce-mercadopago'); ?>"
					link-text="<?php echo esc_html_e('See the rules for the test mode.', 'woocommerce-mercadopago'); ?>"
					link-src="<?php echo esc_html($test_mode_link); ?>">
				</test-mode>
			</div>
		<?php endif; ?>
		<!--
		<div class="mp-checkout-ticket-input-document">
			<input-document documents='[
                    {"name":"CPF"},
                    {"name":"CNPJ"},
                    {"name":"CI"},
                    {"name":"Outro"}
                        ]' validate=true></input-document>
		</div>
		<h2 class="mp-checkout-ticket-text">Select where you want to pay</h2>
		<input-table name="payment-options" columns='
                [
                    {
                        "id": "boleto",
                        "value": "boleto",
                        "rowText": "Boleto",
                        "img": "https://logodownload.org/wp-content/uploads/2019/09/boleto-logo-0.png",
                        "alt": "logo do boleto"
                    },
                    {
                        "id": "loterica",
                        "value": "loterica",
                        "rowText": "Pagamento em lotérica sem boleto",
                        "img": "https://logodownload.org/wp-content/uploads/2020/01/loterias-caixa-logo-0.png",
                        "alt": "logo caixa"
                        }
                ]
                '>
		</input-table>
		<div class="mp-checkout-ticket-terms-and-conditions">
			<terms-and-conditions href="https://developers.mercadopago.com"></terms-and-conditions>
		</div>
		-->
	</div>
</div>
