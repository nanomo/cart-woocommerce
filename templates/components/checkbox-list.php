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

?><tr valign="top">
	<th scope="row" class="titledesc">
		<label for="<?php echo esc_attr( $field_key ); ?>"><?php echo esc_html( $settings['title'] ); ?></label>
	</th>
	<td class="forminp">
		<div class="mp-round-border">
			<p class="mp-checkbox-list-description"><?php echo esc_html($settings['description']) ?></p>
			<ul class="mp-list-group">
				
				<?php if ( $settings['credit_card_payments']['list'] ) { ?>
				<li class="mp-list-group-item">
					<div class="mp-custom-checkbox">
						<input class="mp-custom-checkbox-input mp-selectall" id="credit_card_payments" type="checkbox" data-group="credit_card">
						<label class="mp-custom-checkbox-label" for="credit_card_payments"><b><?php echo esc_html($settings['credit_card_payments']['label']) ?></b></label>
					</div>
				</li>
				<?php foreach ( $settings['credit_card_payments']['list'] as $payment_method ) { ?>
				<li class="mp-list-group-item">
					<div class="mp-custom-checkbox">
						<fieldset>
							<input class="mp-custom-checkbox-input mp-child" id="<?php echo esc_attr($payment_method['field_key']) ?>" name="<?php echo esc_attr($payment_method['field_key']) ?>" type="checkbox" value="1" data-group="credit_card" <?php echo checked($payment_method['value'], 'yes') ?>>
							<label class="mp-custom-checkbox-label" for="<?php echo esc_attr($payment_method['field_key']) ?>"><?php echo esc_html($payment_method['label']) ?></label>
						</fieldset>
					</div>
				</li>
				<?php } ?>
				<?php } ?>

			</ul>
			<ul class="mp-list-group">

				<?php if ( $settings['debit_card_payments']['list'] ) { ?>
				<li class="mp-list-group-item">
					<div class="mp-custom-checkbox">
						<input class="mp-custom-checkbox-input mp-selectall" id="debit_card_payments" type="checkbox" data-group="debit_card">
						<label class="mp-custom-checkbox-label" for="debit_card_payments"><b><?php echo esc_html($settings['debit_card_payments']['label']) ?></b></label>
					</div>
				</li>
				<?php foreach ( $settings['debit_card_payments']['list'] as $payment_method ) { ?>
				<li class="mp-list-group-item">
					<div class="mp-custom-checkbox">
						<fieldset>
							<input class="mp-custom-checkbox-input mp-child" id="<?php echo esc_attr($payment_method['field_key']) ?>" name="<?php echo esc_attr($payment_method['field_key']) ?>" type="checkbox" value="1" data-group="debit_card" <?php echo checked($payment_method['value'], 'yes') ?>>
							<label class="mp-custom-checkbox-label" for="<?php echo esc_attr($payment_method['field_key']) ?>"><?php echo esc_html($payment_method['label']) ?></label>
						</fieldset>
					</div>
				</li>
				<?php } ?>
				<?php } ?>

			</ul>
			<ul class="mp-list-group">

				<?php if ( $settings['other_payments' ]['list'] ) { ?>
				<li class="mp-list-group-item">
					<div class="mp-custom-checkbox">
						<input class="mp-custom-checkbox-input mp-selectall" id="other_payments" type="checkbox" data-group="others">
						<label class="mp-custom-checkbox-label" for="other_payments"><b><?php echo esc_html($settings['other_payments']['label']) ?></b></label>
					</div>
				</li>
				<?php foreach ( $settings['other_payments']['list'] as $payment_method ) { ?>
				<li class="mp-list-group-item">
					<div class="mp-custom-checkbox">
						<fieldset>
							<input class="mp-custom-checkbox-input mp-child" id="<?php echo esc_attr($payment_method['field_key']) ?>" name="<?php echo esc_attr($payment_method['field_key']) ?>" type="checkbox" value="1" data-group="others" <?php echo checked($payment_method['value'], 'yes') ?>>
							<label class="mp-custom-checkbox-label" for="<?php echo esc_attr($payment_method['field_key']) ?>"><?php echo esc_html($payment_method['label']) ?></label>
						</fieldset>
					</div>
				</li>
				<?php } ?>
				<?php } ?>

			</ul>
		</div>
	</td>
</tr>
