<?php
/**
 * Part of Woo Mercado Pago Module
 * Author - Mercado Pago
 * Developer
 * Copyright - Copyright(c) MercadoPago [https://www.mercadopago.com]
 * License - https://www.gnu.org/licenses/gpl.html GPL version 2 or higher
 *
 * @package MercadoPago
 * @category Template
 * @author Mercado Pago
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="mp-panel-checkout">
	<div class="mp-row-checkout">
	<div class="mp-redirect-frame-pix">
			<img src="<?php echo esc_html( $image_pix ); ?>" class="mp-img-fluid mp-img-redirect" alt=""/>
			<p>
				<?php echo esc_html_e( 'Accept payments via Pix Transfer and receive the funds instantly.', 'woocommerce-mercadopago' ); ?>
				<br>
				<?php echo esc_html_e( 'Your customers can pay at any time, without date or time restrictions.', 'woocommerce-mercadopago' ); ?>
			</p>

		</div>
	</div>
</div>
