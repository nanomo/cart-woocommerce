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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="mp-checkout-pro-container">
	<div class="mp-checkout-pro-content">
		<?php if ( true === $test_mode ) : ?>
			<div class="mp-checkout-pro-test-mode">
				<test-mode
					title="<?= esc_html( $test_mode_title ) ?>"
					description="<?= esc_html( $test_mode_description ) ?>"
					linkText="<?= esc_html( $test_mode_link_text ) ?>"
					linkUrl="<?= esc_html( $test_mode_link_src ) ?>"
				>
				</test-mode>
			</div>
		<?php endif; ?>

		<checkout-benefits
			title="Paga más rápido con Mercado Pago"
			items='["Pago seguro", "Sin cargar datos", "Cuotas disponibles"]'
			list-style-type-src="https://raw.githubusercontent.com/PluginAndPartners/mpmodules-narciso/develop/src/assets/images/blue-check.png?token=ADYLYLYXEAEOM3DGCXOFET3BXSOJI"
			list-style-type-alt="List style type blue check"
		>
		</checkout-benefits>

		<div class="mp-checkout-pro-payment-methods">
			<payment-methods methods="<?= esc_html( $payment_methods ); ?>"></payment-methods>
		</div>
	</div>

	<?php if ( 'redirect' === $method ) : ?>
		<div class="mp-checkout-pro-redirect">
			<checkout-redirect
				text="Al confirmar tu compra, te redirigiremos a tu cuenta de Mercado Pago"
				src="https://raw.githubusercontent.com/PluginAndPartners/mpmodules-narciso/develop/src/assets/images/cho-pro-redirect.png?token=ADYLYL5H7A7QZDIGTISVQQLBXSNZA"
				alt="Checkout Pro redirect info image"
			>
			</checkout-redirect>
		</div>
	<?php endif; ?>
</div>

<!-- Terms and conditions link at checkout -->
<div class="mp-checkout-pro-terms-and-conditions">
	<terms-and-conditions href="https://developers.mercadopago.com"></terms-and-conditions>
</div>
