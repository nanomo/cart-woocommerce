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
		<label for="<?php echo esc_attr( $field_key ); ?>"><?php echo wp_kses_post( $settings['title'] ); ?> <?php echo esc_html($settings['desc_tip']); ?></label>
	</th>
	<td class="forminp">
		<fieldset>
			<legend class="screen-reader-text"><span><?php echo wp_kses_post( $settings['title'] ); ?></span></legend>
			<select class="select <?php echo esc_attr( $settings['class'] ); ?>" name="<?php echo esc_attr( $field_key ); ?>" id="<?php echo esc_attr( $field_key ); ?>" style="<?php echo esc_attr( $settings['css'] ); ?>" <?php disabled( $settings['disabled'], true ); ?>>
				<?php foreach ( (array) $settings['options'] as $option_key => $option_value ) : ?>
					<?php if ( is_array( $option_value ) ) { ?>
						<optgroup label="<?php echo esc_attr( $option_key ); ?>">
							<?php foreach ( $option_value as $option_key_inner => $option_value_inner ) { ?>
								<option value="<?php echo esc_attr( $option_key_inner ); ?>" <?php selected( (string) $option_key_inner, esc_attr( $value ) ); ?>><?php echo esc_html( $option_value_inner ); ?></option>
							<?php } ?>
						</optgroup>
					<?php } else { ?>
						<option value="<?php echo esc_attr( $option_key ); ?>" <?php selected( (string) $option_key, esc_attr( $value ) ); ?>><?php echo esc_html( $option_value ); ?></option>
					<?php } ?>
				<?php endforeach; ?>
			</select>
			<?php if ( $settings['description'] ) { ?>
			<p class="description"><?php echo wp_kses_post( $settings['description'] ); ?></p>
			<?php } ?>
		</fieldset>
		<div class="mp-wallet-button-preview">
			<p class="description"><?php echo esc_html( $settings['img-wallet-button-description'] ); ?></p>
			<br>
			<img src="<?php echo esc_url( $settings['img-wallet-button-uri'] ); ?>">
		</div>
	</td>
</tr>
