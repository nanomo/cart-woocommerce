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
		<label for="<?php echo esc_attr( $field_key ); ?>"><?php echo esc_attr( $settings['title'] ); ?></label>
	</th>
	<td class="forminp">
		<div>
			<label class="mp-toggle">
				<input class="mp-toggle-checkbox" type="checkbox" name="<?php echo esc_attr( $field_key ); ?>" value='yes' id="<?php echo esc_attr( $field_key ); ?>" <?php checked( $field_value, 'yes' ); ?>/>
				<div class="mp-toggle-switch"></div>
				<span class="mp-toggle-label"><?php echo esc_attr( $settings['description'] ); ?></span>
			</label>
		</div>
	</td>
</tr>
