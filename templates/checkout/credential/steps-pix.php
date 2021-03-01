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

<div class="mp-row">
	<h4 class="mp-title-checkout-body mp-pb-20"><?php echo esc_html( $title ); ?></h4>
	<div class="mp-col-md-2 mp-text-center mp-pb-10">
		<p class="mp-number-checkout-body">1</p>
		<p class="mp-text-steps mp-text-center mp-px-20">
			<?php echo esc_html( $step_one_text ); ?>
		</p>
	</div>

	<div class="mp-col-md-2 mp-text-center mp-pb-10">
		<p class="mp-number-checkout-body">2</p>
		<p class="mp-text-steps mp-text-center mp-px-20">
			<?php echo esc_html( $step_two_text_one ); ?>
			<b><?php echo esc_html( $step_two_text_two ); ?></b>
			<?php echo esc_html( $step_two_text_highlight_one ); ?>
			<b><?php echo esc_html( $step_two_text_highlight_two ); ?></b>
		</p>
	</div>

	<div class="mp-col-md-2 mp-text-center mp-pb-10">
		<p class="mp-number-checkout-body">3</p>
		<p class="mp-text-steps mp-text-center mp-px-20">
			<?php echo esc_html( $step_three_text ); ?>
		</p>
	</div>

	<div class="mp-col-md-12 mp-pb-10">
		<p class="mp-text-observation">
			<?php echo esc_html( $observation_one ); ?>
		</p>
	</div>

	<div class="mp-col-md-12 mp_tienda_link">
		<p class="">
			<a href=<?php echo esc_html( $link_url_one ); ?> target="_blank"><?php echo esc_html( $button_about_pix ); ?></a>
		</p>
	</div>

</div>
