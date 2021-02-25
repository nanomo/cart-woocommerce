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
	<div class="mp-redirect-frame">
			<img src="<?php echo esc_html( $image_pix ); ?>" class="mp-img-fluid mp-img-redirect" alt=""/>
			<p><?php echo esc_html_e( 'Pague de forma segura e instantânea! Ao finalizar o pedido, você verá o código para fazer o pagamento.', 'woocommerce-mercadopago' ); ?></p>
		</div>
	</div>
</div>
