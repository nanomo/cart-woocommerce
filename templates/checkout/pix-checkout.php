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

<div class="mp-panel-checkout">
	<?php
		$alertTitle       = 'PIX em Modo Teste';
		$alertDescription = 'É possível testar o fluxo até gerar o código, mas não é possível finalizar o pagamento.';
		$alert            = "<div class='mp-alert-checkout-test-mode'>
			<div class='mp-alert-icon-checkout-test-mode'>
				<img
					src='" . esc_url( plugins_url( '../assets/images/generics/circle-alert.png', plugin_dir_path( __FILE__ ) ) ) . "'
					alt='alert'
					class='mp-alert-circle-img'
				>
			</div>
			<div class='mp-alert-texts-checkout-test-mode'>
				<h2 class='mp-alert-title-checkout-test-mode'>$alertTitle</h2>
				<p class='mp-alert-description-checkout-test-mode'>$alertDescription</p>
			</div>
		</div>";

		// @codingStandardsIgnoreLine
		echo 'yes' === $is_prod_mode ? '' : $alert;
	?>
	<div class="mp-row-checkout">
	<div class="mp-redirect-frame-pix">
			<img src="<?php echo esc_html( $image_pix ); ?>" class="mp-img-fluid mp-img-redirect" alt=""/>
			<p>
				<?php echo esc_html_e( 'Pay securely and instantly!', 'woocommerce-mercadopago' ); ?>
				<br>
				<?php echo esc_html_e( 'When you finish the order, you will see the code to complete the payment.', 'woocommerce-mercadopago' ); ?>
			</p>

		</div>
	</div>
</div>
