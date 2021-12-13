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
					title="<? echo esc_html_e( 'Checkout Pro em Modo Teste', 'woocommerce-mercadopago' ); ?>"
					description="<? echo esc_html_e( 'Utilize meios do Mercado Pago sem cobranças reais. ', 'woocommerce-mercadopago' ); ?>"
					linkText="<? echo esc_html_e( 'Consulte as regras do modo teste.', 'woocommerce-mercadopago' ); ?>"
					linkUrl="<? echo esc_html( $test_mode_link )  ?>"
				>
				</test-mode>
			</div>
		<?php endif; ?>

		<checkout-benefits
			title="<? echo esc_html_e( 'Paga más rápido con Mercado Pago', 'woocommerce-mercadopago' ); ?>"
			items='[
				"<? echo esc_html_e( 'Pago seguro', 'woocommerce-mercadopago' ); ?>",
				"<? echo esc_html_e( 'Sin cargar datos', 'woocommerce-mercadopago' ); ?>",
				"<? echo esc_html_e( 'Cuotas disponibles', 'woocommerce-mercadopago' ); ?>"
			]'
			list-style-type-src="<? echo esc_html( $list_style_type_src ) ?>"
			list-style-type-alt="<? echo esc_html_e( 'List style type blue check', 'woocommerce-mercadopago' ); ?>"
		>
		</checkout-benefits>

		<div class="mp-checkout-pro-payment-methods">
			<payment-methods methods="<? echo esc_html( $payment_methods );  ?>"></payment-methods>
		</div>
	</div>

	<?php if ( 'redirect' === $method ) : ?>
		<div class="mp-checkout-pro-redirect">
			<checkout-redirect
				text="<? echo esc_html_e( 'Al confirmar tu compra, te redirigiremos a tu cuenta de Mercado Pago', 'woocommerce-mercadopago' ); ?>"
				alt="<? echo esc_html_e( 'Checkout Pro redirect info image', 'woocommerce-mercadopago' ); ?>"
				src="<? echo esc_html( $redirect_image ); ?>"
			>
			</checkout-redirect>
		</div>
	<?php endif; ?>
</div>

<!-- Terms and conditions link at checkout -->
<div class="mp-checkout-pro-terms-and-conditions">
	<terms-and-conditions href="<? echo esc_html( $link_terms_and_conditions ) ?>"></terms-and-conditions>
</div>
