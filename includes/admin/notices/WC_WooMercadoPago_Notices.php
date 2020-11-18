<?php

/**
 * Part of Woo Mercado Pago Module
 * Author - Mercado Pago
 * Developer
 * Copyright - Copyright(c) MercadoPago [https://www.mercadopago.com]
 * License - https://www.gnu.org/licenses/gpl.html GPL version 2 or higher
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class WC_WooMercadoPago_Notification
 */
class WC_WooMercadoPago_Notices
{
    public static $instance = null;

    private function __construct()
    {
        add_action('admin_enqueue_scripts', [$this, 'loadAdminNoticeCss']);
        add_action('admin_enqueue_scripts', [$this, 'loadAdminNoticeJs']);
        add_action('wp_ajax_mercadopago_review_dismiss', array($this, 'reviewDismiss') );
    }

    /**
     * @return WC_WooMercadoPago_Module|null
     * Singleton
     */
    public static function initMercadopagoNnotice()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Load admin notices CSS
     */
    public function loadAdminNoticeCss()
    {
        if (is_admin()) {
            $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

            wp_enqueue_style(
                'woocommerce-mercadopago-admin-notice',
                plugins_url('../../assets/css/admin_notice_mercadopago' . $suffix . '.css', plugin_dir_path(__FILE__))
            );
        }
    }

    /**
     * Load admin notices JS
     */
    public function loadAdminNoticeJs()
    {
        if (is_admin()) {
            $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

            wp_enqueue_script(
                'woocommerce-mercadopago-admin-notice-review',
                plugins_url('../../assets/js/review'.$suffix.'.js', plugin_dir_path(__FILE__)),
                array(),
                WC_WooMercadoPago_Constants::VERSION
            );
        }
    }

    /**
     * @param $message
     * @param $type
     * @return string
     */
    public static function getAlertFrame($message, $type)
    {
        $inline = null;
        if (
            (class_exists('WC_WooMercadoPago_Module') && WC_WooMercadoPago_Module::isWcNewVersion())
            &&
            (isset($_GET['page']) && $_GET['page'] == "wc-settings")
        ) {
            $inline = "inline";
        }

        $notice = '<div id="message" class="notice ' . $type . ' is-dismissible ' . $inline . '">
                    <div class="mp-alert-frame">
                        <div class="mp-left-alert">
                            <img src="' . plugins_url('../../assets/images/minilogo.png', plugin_dir_path(__FILE__)) . '">
                        </div>
                        <div class="mp-right-alert">
                            <p>' . $message . '</p>
                        </div>
                    </div>
                    <button type="button" class="notice-dismiss">
                        <span class="screen-reader-text">' . __('Discard', 'woocommerce-mercadopago') . '</span>
                    </button>
                </div>';
        if (class_exists('WC_WooMercadoPago_Module')) {
            WC_WooMercadoPago_Module::$notices[] = $notice;
        }

        return $notice;
    }

    /**
     * @param $message
     * @param $type
     * @return string
     */
    public static function getAlertWocommerceMiss($message, $type)
    {

        $is_installed = false;

        if (function_exists('get_plugins')) {
            $all_plugins = get_plugins();
            $is_installed = !empty($all_plugins['woocommerce/woocommerce.php']);
        }

        if ($is_installed && current_user_can('install_plugins')) {
            $buttonUrl = '<a href="' . wp_nonce_url(self_admin_url('plugins.php?action=activate&plugin=woocommerce/woocommerce.php&plugin_status=active'), 'activate-plugin_woocommerce/woocommerce.php') . '" class="button button-primary">' . __('Activate WooCommerce', 'woocommerce-mercadopago') . '</a>';
        } else {
            if (current_user_can('install_plugins')) {
                $buttonUrl = '<a href="' . wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=woocommerce'), 'install-plugin_woocommerce') . '" class="button button-primary">' . __('Install WooCommerce', 'woocommerce-mercadopago') . '</a>';
            } else {
                $buttonUrl = '<a href="http://wordpress.org/plugins/woocommerce/" class="button button-primary">' . __('See WooCommerce', 'woocommerce-mercadopago') . '</a>';
            }
        }

        $inline = null;
        if (
            (class_exists('WC_WooMercadoPago_Module') && WC_WooMercadoPago_Module::isWcNewVersion())
            &&
            (isset($_GET['page']) && $_GET['page'] == "wc-settings")
        ) {
            $inline = "inline";
        }

        $notice = '<div id="message" class="notice ' . $type . ' is-dismissible ' . $inline . '">
                    <div class="mp-alert-frame">
                        <div class="mp-left-alert">
                            <img src="' . plugins_url('../../assets/images/minilogo.png', plugin_dir_path(__FILE__)) . '">
                        </div>
                        <div class="mp-right-alert">
                            <p>' . $message . '</p>
							<p>' . $buttonUrl . '</p>
                        </div>
                    </div>
                    <button type="button" class="notice-dismiss">
                        <span class="screen-reader-text">' . __('Discard', 'woocommerce-mercadopago') . '</span>
                    </button>
                </div>';

        if (class_exists('WC_WooMercadoPago_Module')) {
            WC_WooMercadoPago_Module::$notices[] = $notice;
        }
        return $notice;
    }

    /**
     * @param $message
     * @param $type
     * @return string
     */
    public static function getPluginReviewBanner()
    {
        $inline = null;
        if (
            (class_exists('WC_WooMercadoPago_Module') && WC_WooMercadoPago_Module::isWcNewVersion()) &&
            (isset($_GET['page']) && $_GET['page'] == "wc-settings")
        ) {
            $inline = "inline";
        }

        $notice = '<div id="message" class="notice is-dismissible mp-rating-notice ' . $inline . '">
                    <div class="mp-rating-frame">
                        <div class="mp-left-rating">
                            <div>
                                <img src="' . plugins_url('../../assets/images/minilogo.png', plugin_dir_path(__FILE__)) . '">
                            </div>
                            <div class="mp-left-rating-text">
                                <p class="mp-rating-title">' .
                                    wp_get_current_user()->user_login . ', ' .
                                    __('do you have a minute to share your experience with our plugin?', 'woocommerce-mercadopago') .
                                '</p>
                                <p class="mp-rating-subtitle">' .
                                    __('Your opinion is very important so that we can offer you the best possible payment solution and continue to improve.', 'woocommerce-mercadopago') .
                                '</p>
                            </div>
                        </div>
                        <div class="mp-right-rating">
                            <a
                                class="mp-rating-link"
                                href="https://wordpress.org/support/plugin/woocommerce-mercadopago/reviews/?filter=5#new-post" target="blank"
                            >'
                                . __('Rate the plugin', 'woocommerce-mercadopago') .
                            '</a>
                        </div>

                        <button type="button" class="notice-dismiss">
                            <span class="screen-reader-text">' . __('Discard', 'woocommerce-mercadopago') . '</span>
                        </button>
                    </div>
                </div>';

        if (class_exists('WC_WooMercadoPago_Module')) {
            WC_WooMercadoPago_Module::$notices[] = $notice;
        }

        return $notice;
    }

    /**
	 * Dismiss the review admin notice
	 */
	public function reviewDismiss() {
        $dismissedReview = (int) get_option('_mp_dismiss_review', 0);

        if ($dismissedReview == 0) {
            update_option('_mp_dismiss_review', 1, true);
        }

		wp_send_json_success();
	}
}
