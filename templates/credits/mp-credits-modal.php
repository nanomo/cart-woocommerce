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

if ( ! defined('ABSPATH') ) {
	exit;
}

?><div class="mp-credits-banner-info">
	<div class="mp-credits-banner-round-base">
		<div class="mp-credits-banner-round-background">
			<img class="mp-credits-banner-round-logo" src="<?php echo esc_html(plugins_url( '../assets/images/credits/mp-logo-hands-shake.png', plugin_dir_path( __FILE__ ) )); ?>">
		</div>
	</div>
	<div class="mp-credits-banner-text">
		<span><?php echo wp_kses_post($banner_title); ?></span>
	</div>
	<div class="mp-credits-banner-link">
		<span><a href="#" id="mp-open-modal"><?php echo esc_html($banner_link); ?></a></span>
		<div id="mp-credits-modal">
			<div class="mp-credits-modal-container">
				<div class="mp-credits-modal-container-content">
					<div class="mp-credits-modal-content">
						<div class="mp-credits-modal-close-button">
							<img id="mp-credits-modal-close-modal" src="<?php echo esc_html(plugins_url( '../assets/images/credits/Icon shape.png', plugin_dir_path( __FILE__ ) )); ?>">
						</div>
						<div class="mp-logo-img">
							<img src="<?php echo esc_html(plugins_url( '../assets/images/credits/Group.png', plugin_dir_path( __FILE__ ) )); ?>">
						</div>

						<div class="mp-credits-modal-titles">
							<div>
								<h1><?php echo esc_html($modal_title); ?></h1>
								<p><?php echo esc_html($modal_subtitle); ?><p>
							</div>
							<div>
								<h2><?php echo esc_html($modal_how_to); ?></h2>
								<div class="mp-credits-modal-how-to-use">
									<div>
										<div class="mp-credits-modal-blue-circle"><span>1</span></div>
										<span><?php echo esc_html($modal_step_1); ?></span>
									</div>
									<div>
										<div class="mp-credits-modal-blue-circle"><span>2</span></div>
										<span><?php echo esc_html($modal_step_2); ?></span>
									</div>
									<div>
										<div class="mp-credits-modal-blue-circle"><span>3</span></div>
										<span><?php echo esc_html($modal_step_3); ?></span>
									</div>
								</div>
							</div>
						</div>
						<div class="mp-credits-modal-FAQ">
							<p><?php echo esc_html($modal_footer); ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
