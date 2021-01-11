<?php
/**
 * Part of Woo Mercado Pago Module
 * Author - Mercado Pago
 * Developer
 * Copyright - Copyright(c) MercadoPago [https://www.mercadopago.com]
 * License - https://www.gnu.org/licenses/gpl.html GPL version 2 or higher
 *
 * @package MercadoPago
 * @category Includes
 * @author Mercado Pago
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$GLOBALS['LIB_LOCATION'] = dirname( __FILE__ );

/**
 * Class MP
 */
class MP {

	/**
	 * Client Id
	 *
	 * @var false|mixed
	 */
	private $client_id;

	/**
	 * Client secret
	 *
	 * @var false|mixed
	 */
	private $client_secret;

	/**
	 * LL access token
	 *
	 * @var false|mixed
	 */
	private $ll_access_token;

	/**
	 * Is sandbox?
	 *
	 * @var bool
	 */
	private $sandbox = false;

	/**
	 * @var
	 */
	private $access_token_by_client;

	/**
	 * @var WC_WooMercadoPago_PaymentAbstract
	 */
	private $payment_class;

	/**
	 * MP constructor.
	 *
	 * @throws WC_WooMercadoPago_Exception
	 */
	public function __construct() {
		$includes_path = dirname( __FILE__ );
		require_once $includes_path . '/rest-client/class-rest-client-abstract.php';
		require_once $includes_path . '/rest-client/class-meli-rest-client.php';
		require_once $includes_path . '/rest-client/class-mp-rest-client.php';

		$i = func_num_args();
		if ( $i > 2 || $i < 1 ) {
			throw new WC_WooMercadoPago_Exception( 'Invalid arguments. Use CLIENT_ID and CLIENT SECRET, or ACCESS_TOKEN' );
		}

		if ( $i == 1 ) {
			$this->ll_access_token = func_get_arg( 0 );
		}

		if ( $i == 2 ) {
			$this->client_id     = func_get_arg( 0 );
			$this->client_secret = func_get_arg( 1 );
		}
	}

	/**
	 * @param $email
	 */
	public function set_email( $email ) {
		MP_Rest_Client::set_email( $email );
		Meli_Rest_Client::set_email( $email );
	}

	/**
	 * @param $country_code
	 */
	public function set_locale( $country_code ) {
		MP_Rest_Client::set_locale( $country_code );
		Meli_Rest_Client::set_locale( $country_code );
	}

	/**
	 * @param null $enable
	 * @return bool
	 */
	public function sandbox_mode( $enable = null ) {
		if ( ! is_null( $enable ) ) {
			$this->sandbox = $enable === true;
		}
		return $this->sandbox;
	}

	/**
	 * @return mixed|null
	 * @throws WC_WooMercadoPago_Exception
	 */
	public function get_access_token() {

		if ( isset( $this->ll_access_token ) && ! is_null( $this->ll_access_token ) ) {
			return $this->ll_access_token;
		}

		if ( ! empty( $this->access_token_by_client ) ) {
			return $this->access_token_by_client;
		}

		$app_client_values = array(
			'client_id'     => $this->client_id,
			'client_secret' => $this->client_secret,
			'grant_type'    => 'client_credentials',
		);

		$access_data = MP_Rest_Client::post(
			array(
				'uri'     => '/oauth/token',
				'data'    => $app_client_values,
				'headers' => array(
					'content-type' => 'application/x-www-form-urlencoded',
				),
			)
		);

		if ( $access_data['status'] != 200 ) {
			return null;
		}

		$response                     = $access_data['response'];
		$this->access_token_by_client = $response['access_token'];

		return $this->access_token_by_client;
	}

	/**
	 * @param $id
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception
	 */
	public function search_payment_v1( $id ) {

		$request = array(
			'uri'    => '/v1/payments/' . $id,
			'params' => array( 'access_token' => $this->get_access_token() ),
		);

		return MP_Rest_Client::get( $request, WC_WooMercadoPago_Constants::VERSION );
	}

	// === CUSTOMER CARDS FUNCTIONS ===

	/**
	 * @param $payer_email
	 * @return array|mixed|null
	 * @throws WC_WooMercadoPago_Exception
	 */
	public function get_or_create_customer( $payer_email ) {

		$customer = $this->search_customer( $payer_email );

		if ( $customer['status'] == 200 && $customer['response']['paging']['total'] > 0 ) {
			$customer = $customer['response']['results'][0];
		} else {
			$resp     = $this->create_customer( $payer_email );
			$customer = $resp['response'];
		}

		return $customer;
	}

	/**
	 * @param $email
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception
	 */
	public function create_customer( $email ) {

		$request = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $this->get_access_token(),
			),
			'uri'     => '/v1/customers',
			'data'    => array(
				'email' => $email,
			),
		);

		return MP_Rest_Client::post( $request );
	}

	/**
	 * @param $email
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception
	 */
	public function search_customer( $email ) {

		$request = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $this->get_access_token(),
			),
			'uri'     => '/v1/customers/search',
			'params'  => array(
				'email' => $email,
			),
		);

		return MP_Rest_Client::get( $request );
	}

	/**
	 * @param $customer_id
	 * @param $token
	 * @param null        $payment_method_id
	 * @param null        $issuer_id
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception
	 */
	public function create_card_in_customer(
		$customer_id,
		$token,
		$payment_method_id = null,
		$issuer_id = null
	) {

		$request = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $this->get_access_token(),
			),
			'uri'     => '/v1/customers/' . $customer_id . '/cards',
			'data'    => array(
				'token'             => $token,
				'issuer_id'         => $issuer_id,
				'payment_method_id' => $payment_method_id,
			),
		);

		return MP_Rest_Client::post( $request );
	}

	/**
	 * @param $customer_id
	 * @param $token
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception
	 */
	public function get_all_customer_cards( $customer_id, $token ) {

		$request = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $this->get_access_token(),
			),
			'uri'     => '/v1/customers/' . $customer_id . '/cards',
		);

		return MP_Rest_Client::get( $request );
	}

	// === COUPOM AND DISCOUNTS FUNCTIONS ===
	/**
	 * @param $transaction_amount
	 * @param $payer_email
	 * @param $coupon_code
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception
	 */
	public function check_discount_campaigns( $transaction_amount, $payer_email, $coupon_code ) {
		$request = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $this->get_access_token(),
			),
			'uri'     => '/discount_campaigns',
			'params'  => array(
				'transaction_amount' => $transaction_amount,
				'payer_email'        => $payer_email,
				'coupon_code'        => $coupon_code,
			),
		);
		return MP_Rest_Client::get( $request );
	}

	// === CHECKOUT AUXILIARY FUNCTIONS ===

	/**
	 * @param $id
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception
	 */
	public function get_authorized_payment( $id ) {

		$request = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $this->get_access_token(),
			),
			'uri'     => '/authorized_payments/{$id}',
		);

		return MP_Rest_Client::get( $request );
	}

	/**
	 * @param $preference
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception
	 */
	public function create_preference( $preference ) {

		$request = array(
			'uri'     => '/checkout/preferences',
			'headers' => array(
				'user-agent'    => 'platform:desktop,type:woocommerce,so:' . WC_WooMercadoPago_Constants::VERSION,
				'Authorization' => 'Bearer ' . $this->get_access_token(),
			),
			'data'    => $preference,
		);

		return MP_Rest_Client::post( $request );
	}

	/**
	 * @param $id
	 * @param $preference
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception
	 */
	public function update_preference( $id, $preference ) {

		$request = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $this->get_access_token(),
			),
			'uri'     => '/checkout/preferences/{$id}',
			'data'    => $preference,
		);

		return MP_Rest_Client::put( $request );
	}

	/**
	 * @param $id
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception
	 */
	public function get_preference( $id ) {

		$request = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $this->get_access_token(),
			),
			'uri'     => '/checkout/preferences/{$id}',
		);

		return MP_Rest_Client::get( $request );
	}

	/**
	 * @param $preference
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception
	 */
	public function create_payment( $preference ) {

		$request = array(
			'uri'     => '/v1/payments',
			'headers' => array(
				'X-Tracking-Id' => 'platform:v1-whitelabel,type:woocommerce,so:' . WC_WooMercadoPago_Constants::VERSION,
				'Authorization' => 'Bearer ' . $this->get_access_token(),
			),
			'data'    => $preference,
		);

		return MP_Rest_Client::post( $request );
	}

	/**
	 * @param $preapproval_payment
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception
	 */
	public function create_preapproval_payment( $preapproval_payment ) {

		$request = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $this->get_access_token(),
			),
			'uri'     => '/preapproval',
			'data'    => $preapproval_payment,
		);

		return MP_Rest_Client::post( $request );
	}

	/**
	 * Get Preapproval Payment
	 *
	 * @param string $id Payment Id.
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Get Preapproval payment exception.
	 */
	public function get_preapproval_payment( $id ) {

		$request = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $this->get_access_token(),
			),
			'uri'     => '/preapproval/' . $id,
		);

		return MP_Rest_Client::get( $request );
	}

	/**
	 * Update Preapproval payment
	 *
	 * @param string $id Payment Id.
	 * @param array  $preapproval_payment Pre Approval Payment.
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Update preapproval payment exception.
	 */
	public function update_preapproval_payment( $id, $preapproval_payment ) {

		$request = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $this->get_access_token(),
			),
			'uri'     => '/preapproval/' . $id,
			'data'    => $preapproval_payment,
		);

		return MP_Rest_Client::put( $request );
	}

	/**
	 * Cancel preapproval payment
	 *
	 * @param string $id Preapproval Id.
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Cancel Preapproval payment.
	 */
	public function cancel_preapproval_payment( $id ) {

		$request = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $this->get_access_token(),
			),
			'uri'     => '/preapproval/' . $id,
			'data'    => array(
				'status' => 'cancelled',
			),
		);

		return MP_Rest_Client::put( $request );
	}

	// === REFUND AND CANCELING FLOW FUNCTIONS ===

	/**
	 * Refund payment
	 *
	 * @param string $id Payment id.
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Refund payment exception.
	 */
	public function refund_payment( $id ) {

		$request = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $this->get_access_token(),
			),
			'uri'     => '/v1/payments/' . $id . '/refunds',
		);

		return MP_Rest_Client::post( $request );
	}

	/**
	 * Partial refund payment
	 *
	 * @param string       $id Payment id.
	 * @param string|float $amount Amount.
	 * @param string       $reason Reason.
	 * @param string       $external_reference External reference.
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Partial refund exception.
	 */
	public function partial_refund_payment( $id, $amount, $reason, $external_reference ) {

		$request = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $this->get_access_token(),
			),
			'uri'     => '/v1/payments/' . $id . '/refunds',
			'data'    => array(
				'amount'   => $amount,
				'metadata' => array(
					'metadata'           => $reason,
					'external_reference' => $external_reference,
				),
			),
		);

		return MP_Rest_Client::post( $request );
	}

	/**
	 * Cancel payment
	 *
	 * @param string $id Payment id.
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Cancel payment exception.
	 */
	public function cancel_payment( $id ) {

		$request = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $this->get_access_token(),
			),
			'uri'     => '/v1/payments/' . $id,
			'data'    => '{"status":"cancelled"}',
		);

		return MP_Rest_Client::put( $request );
	}

	/**
	 * Get payment method
	 *
	 * @param string $access_token Access token.
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Get payment method exception.
	 */
	public function get_payment_methods( $access_token ) {
		$request = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $access_token,
			),
			'uri'     => '/v1/payment_methods',
		);

		$response = MP_Rest_Client::get( $request );

		if ( $response['status'] > 202 ) {
			$log = WC_WooMercadoPago_Log::init_mercado_pago_log( 'get_payment_methods' );
			$log->write_log( 'API get_payment_methods error: ', $response['response']['message'] );
			return null;
		}

		asort( $response );

		return $response;
	}

	/**
	 * Validate if the seller is homologated
	 *
	 * @param string|null $access_token Access token.
	 * @param string|null $public_key Public key.
	 * @return array|null|false
	 * @throws WC_WooMercadoPago_Exception Get credentials wrapper.
	 */
	public function get_credentials_wrapper( $access_token = null, $public_key = null ) {
		$request = array(
			'uri' => '/plugins-credentials-wrapper/credentials',
		);

		if ( ! empty( $access_token ) && empty( $public_key ) ) {
			$request['headers'] = array( 'Authorization' => 'Bearer ' . $access_token );
		}

		if ( empty( $access_token ) && ! empty( $public_key ) ) {
			$request['params'] = array( 'public_key' => $public_key );
		}

		$response = MP_Rest_Client::get( $request );

		if ( $response['status'] > 202 ) {
			$log = WC_WooMercadoPago_Log::init_mercado_pago_log( 'getCredentialsWrapper' );
			$log->write_log( 'API GET Credentials Wrapper error:', $response['response']['message'] );
			return false;
		}

		return $response['response'];
	}

	// === GENERIC RESOURCE CALL METHODS ===

	/**
	 * Get call
	 *
	 * @param string|array $request Request.
	 * @param array        $headers Headers.
	 * @param bool         $authenticate Is authenticate.
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Get exception.
	 */
	public function get( $request, $headers = array(), $authenticate = true ) {

		if ( is_string( $request ) ) {
			$request = array(
				'headers'      => $headers,
				'uri'          => $request,
				'authenticate' => $authenticate,
			);
		}

		if ( ! isset( $request['authenticate'] ) || false !== $request['authenticate'] ) {
			$access_token = $this->get_access_token();
			if ( ! empty( $access_token ) ) {
				$request['headers'] = array( 'Authorization' => 'Bearer ' . $access_token );
			}
		}

		return MP_Rest_Client::get( $request );
	}

	/**
	 * Post call
	 *
	 * @param array|string $request Request.
	 * @param null         $data Request data.
	 * @param null         $params Request params.
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Post exception.
	 */
	public function post( $request, $data = null, $params = null ) {

		if ( is_string( $request ) ) {
			$request = array(
				'headers' => array( 'Authorization' => 'Bearer ' . $this->get_access_token() ),
				'uri'     => $request,
				'data'    => $data,
				'params'  => $params,
			);
		}

		$request['params'] = isset( $request['params'] ) && is_array( $request['params'] ) ?
			$request['params'] :
			array();

		return MP_Rest_Client::post( $request );
	}

	/**
	 * Put call
	 *
	 * @param array|string $request Request.
	 * @param null         $data Request data.
	 * @param null         $params Request params.
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Put exception.
	 */
	public function put( $request, $data = null, $params = null ) {

		if ( is_string( $request ) ) {
			$request = array(
				'headers' => array( 'Authorization' => 'Bearer ' . $this->get_access_token() ),
				'uri'     => $request,
				'data'    => $data,
				'params'  => $params,
			);
		}

		$request['params'] = isset( $request['params'] ) && is_array( $request['params'] ) ?
			$request['params'] :
			array();

		return MP_Rest_Client::put( $request );
	}

	/**
	 * Delete call
	 *
	 * @param array      $request Request.
	 * @param null|array $params Params.
	 * @return array|null
	 * @throws WC_WooMercadoPago_Exception Delete exception.
	 */
	public function delete( $request, $params = null ) {

		if ( is_string( $request ) ) {
			$request = array(
				'headers' => array( 'Authorization' => 'Bearer ' . $this->get_access_token() ),
				'uri'     => $request,
				'params'  => $params,
			);
		}

		$request['params'] = isset( $request['params'] ) && is_array( $request['params'] ) ?
			$request['params'] :
			array();

		return MP_Rest_Client::delete( $request );
	}

	/**
	 * Set payment class
	 *
	 * @param null|WC_WooMercadoPago_PaymentAbstract $payment Payment class.
	 */
	public function set_payment_class( $payment = null ) {
		if ( ! empty( $payment ) ) {
			$this->payment_class = get_class( $payment );
		}
	}

	/**
	 * Get payment class
	 *
	 * @return WC_WooMercadoPago_PaymentAbstract
	 */
	public function get_payment_class() {
		return $this->payment_class;
	}

}
