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
		<div>
			<fieldset>
				<input class="input-text regular-input" type="<?php echo esc_attr( $settings['input_type'] ); ?>" name="<?php echo esc_attr( $field_key ); ?>" id="<?php echo esc_attr( $field_key ); ?>" style="<?php echo esc_attr( $settings['css'] ); ?>" value="<?php echo esc_attr( $value ); ?>" placeholder="<?php echo esc_attr( $settings['placeholder'] ); ?>" <?php echo esc_attr( $custom_attributes ); ?> />
				<br/>

				<label for="<?php echo esc_attr( $field_key_checkbox ); ?>">
					<input type="checkbox" name="<?php echo esc_attr( $field_key_checkbox ); ?>" id="<?php echo esc_attr( $field_key_checkbox ); ?>" value="1" <?php checked( $enabled, 'yes' ); ?>> <?php echo wp_kses_post( $settings['checkbox_label'] ); ?>
				</label>
				<br/>

				<?php if ( $settings['description'] ) { ?>
				<p class="description"><?php echo wp_kses_post( $settings['description'] ); ?></p>
				<?php } ?>
			</fieldset>
		</div>
	</td>
</tr>
