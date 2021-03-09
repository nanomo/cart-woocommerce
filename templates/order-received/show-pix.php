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
<p class="mp-details-title">
	<?php echo esc_html__( 'Agora é só pagar com o PIX para finalizar sua compra', 'woocommerce-mercadopago' ); ?>
</p>
<div class="mp-details-pix">
	<div class="mp-row-checkout-pix">

		<div class="mp-col-md-4">

			<img src="<?php echo esc_html( $img_pix ); ?>" class="mp-details-pix-img" />

			<p class="mp-details-pix-title">
				<?php echo esc_html_e( 'Como pagar com PIX:', 'woocommerce-mercadopago' ); ?>
			</p>
			<ul class="mp-steps-congrats mp-pix-left">
				<li class="mp-details-list">
					<p class="mp-details-pix-number-p">1</p>
					<p class="mp-details-list-description"><?php echo esc_html_e( 'Acesse o app ou site do seu banco', 'woocommerce-mercadopago' ); ?></p>
				</li>
				<li class="mp-details-list">
					<p class="mp-details-pix-number-p">
						2
					</p>
					<p class="mp-details-list-description"><?php echo esc_html_e( 'Busque a opção de pagar com PIX', 'woocommerce-mercadopago' ); ?></p>
				</li>
				<li class="mp-details-list">
					<p class="mp-details-pix-number-p">
						3
					</p>
					<p class="mp-details-list-description"><?php echo esc_html_e( 'Leia o QR code ou cole o código PIX', 'woocommerce-mercadopago' ); ?></p>
				</li>
				<li class="mp-details-list">
					<p class="mp-details-pix-number-p">
						4
					</p>
					<p class="mp-details-list-description"><?php echo esc_html_e( 'Pronto! Você verá a confirmação do pagamento', 'woocommerce-mercadopago' ); ?></p>
				</li>
			</ul>

		</div>

		<div class="mp-col-md-8 mp-text-center mp-pix-right">
			<p class="mp-details-pix-amount">
				<span class="mp-details-pix-qr">
					<?php echo esc_html_e( 'Valor a pagar:', 'woocommerce-mercadopago' ); ?>
				</span>
				<span class="mp-details-pix-qr-value">
					<?php echo esc_html_e( 'R$ 460,00', 'woocommerce-mercadopago' ); ?>
				</span>
			</p>
			<p class="mp-details-pix-qr-title">
				<?php echo esc_html_e( 'Escaneie o QR code:', 'woocommerce-mercadopago' ); ?>
			</p>
			<img class="mp-details-pix-qr-img" src="<?php echo esc_html( $qr_code ); ?>" />
			<p class="mp-details-pix-qr-subtitle">
				<?php echo esc_html_e( 'Código válido por 30 minutos.', 'woocommerce-mercadopago' ); ?>
			</p>
			<div class="mp-details-pix-container">
				<p class="mp-details-pix-qr-description">
					<?php echo esc_html_e( 'Se preferir, você pode pagar copiando e colando o seguinte código', 'woocommerce-mercadopago' ); ?>
				</p>
				<div class="mp-row-checkout-pix-container">
					<input value="{qr_code}" class="container"></input>
					<button for="cvv" class="mp-details-pix-button" onclick="true"><?php echo esc_html_e( 'Copiar código', 'woocommerce-mercadopago' ); ?></button>
				</div>
			</div>
		</div>
	</div>
</div>
