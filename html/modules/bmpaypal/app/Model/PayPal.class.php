<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bluemooninc
 * Date: 12/07/23
 * Time: 23:16
 * To change this template use File | Settings | File Templates.
 */
if (!defined('XOOPS_ROOT_PATH')) exit();

/**
 * Utility
 */
class Model_PayPal extends AbstractModel
{
	var $message = NULL;
	// Sandbox
	protected $host = 'https://api.sandbox.paypal.com';
	protected $clientId;
	protected $clientSecret;
	// Endpoint
	protected $token_endpoint = '/v1/oauth2/token';
	protected $token_postArgs = 'grant_type=client_credentials';
	// Token
	protected $token;
	// Amount
	protected $total;        // Amount total
	protected $currency = 'USD';    // Default currency doller
	// API return
	protected $related_resource_count;
	protected $payment_detail_url;
	protected $payment_detail_method;
	protected $sale_detail_url;
	protected $sale_detail_method;
	protected $refund_url;
	protected $refund_method;
	protected $json_resp;
	protected $object;

	/**
	 * constructor
	 */
	public function __construct()
	{
		$this->_module_names = $this->getModuleNames();
		$this->host = $this->root->mContext->mModuleConfig['PAYPAL_ENDPOINT'];
		$this->clientId = $this->root->mContext->mModuleConfig['PAYPAL_CLIENT_ID'];
		$this->clientSecret = $this->root->mContext->mModuleConfig['PAYPAL_SECRET'];
	}

	/**
	 * get Instance
	 * @param none
	 * @return object Instance
	 */
	public function &forge()
	{
		static $instance;
		if (!isset($instance)) {
			$instance = new Model_Paypal();
		}
		return $instance;
	}

	public function echoMessage(){
		foreach($this->message as $message){
			echo $message . "<br />";
		}
		die;
	}
	/**
	 * Obtaining OAuth2 Access Token.
	 * @param $url
	 * @param $postdata
	 * @return mixed (Got OAuth Token)
	 */
	function get_access_token($url, $postdata) {
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_POST, TRUE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_USERPWD, $this->clientId . ":" . $this->clientSecret);
		curl_setopt($curl, CURLOPT_HEADER, FALSE);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($curl, CURLOPT_VERBOSE, TRUE);
		$response = curl_exec( $curl );
		if (empty($response)) {
			// some kind of an error happened
			die(curl_error($curl));
			curl_close($curl); // close cURL handler
		} else {
			$info = curl_getinfo($curl);
			$this->message[] = "Time took: " . $info['total_time']*1000 . "ms<br />";
			curl_close($curl); // close cURL handler
			if($info['http_code'] != 200 && $info['http_code'] != 201 ) {
				$this->message[] = "Received error: " . $info['http_code']. "<br />";
				$this->message[] = "Raw response:".$response."<br />";
				return NULL;
			}
		}
		// Convert the result from JSON format to a PHP array
		$jsonResponse = json_decode( $response );
		return $jsonResponse->access_token;
	}

	/**
	 * @param $url
	 * @param $postdata
	 * @return array|mixed
	 */
	function make_post_call($url, $postdata) {
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_POST, TRUE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_HEADER, FALSE);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Authorization: Bearer '.$this->token,
			'Accept: application/json',
			'Content-Type: application/json'
		));

		curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
		#curl_setopt($curl, CURLOPT_VERBOSE, TRUE);
		$response = curl_exec( $curl );
		if (empty($response)) {
			// some kind of an error happened
			die(curl_error($curl));
			curl_close($curl); // close cURL handler
		} else {
			$info = curl_getinfo($curl);
			echo "Time took: " . $info['total_time']*1000 . "ms<br />";
			curl_close($curl); // close cURL handler
			if($info['http_code'] != 200 && $info['http_code'] != 201 ) {
				echo "Received error: " . $info['http_code']. "<br />";
				echo "Raw response:".$response."<br />";
				die();
			}
		}

		// Convert the result from JSON format to a PHP array
		$jsonResponse = json_decode($response, TRUE);
		return $jsonResponse;
	}

	/**
	 * @param $url
	 * @return array|mixed
	 */
	function make_get_call($url) {
		global $token;
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_POST, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_HEADER, FALSE);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Authorization: Bearer '.$token,
			'Accept: application/json',
			'Content-Type: application/json'
		));

		#curl_setopt($curl, CURLOPT_VERBOSE, TRUE);
		$response = curl_exec( $curl );
		if (empty($response)) {
			// some kind of an error happened
			die(curl_error($curl));
			curl_close($curl); // close cURL handler
		} else {
			$info = curl_getinfo($curl);
			echo "Time took: " . $info['total_time']*1000 . "ms<br />";
			curl_close($curl); // close cURL handler
			if($info['http_code'] != 200 && $info['http_code'] != 201 ) {
				echo "Received error: " . $info['http_code']. "<br />";
				echo "Raw response:".$response."<br />";
				die();
			}
		}
		// Convert the result from JSON format to a PHP array
		$jsonResponse = json_decode($response, TRUE);
		return $jsonResponse;
	}

	/**
	 * memberId = uid + uname
	 * @param $root
	 * @return string
	 */
	private function _getMemberId()
	{
		return $this->root->mContext->mXoopsUser->get('uid')
			. "-" . $this->root->mContext->mXoopsUser->get('uname');
	}

	private function _set_message(&$output)
	{
		$errorHandle = new ErrorHandler();
		$errorList = $output->getErrList();
		$this->emsg = "<ul>";
		foreach ($errorList as $errorInfo) {
			/* @var $errorInfo ErrHolder */
			$this->emsg .= '<li>'
				. $errorInfo->getErrCode()
				. ':' . $errorInfo->getErrInfo()
				. ':' . $errorHandle->getMessage($errorInfo->getErrInfo())
				. '</li>';
		}
		$this->emsg .= "</ul>";
	}

	private function _set_exceptionMessage(&$exe)
	{
		$exception = $exe->getException();
		$title = $exception->getMessage();
		$messages = $exception->getMessages();
		$this->emsg = $title . "<ul>";
		if (is_array($messages)) {
			foreach ($messages as $message) {
				$this->emsg .= '<li>' . $message . '</li>';
			}
		}
		$this->emsg .= "</ul>";
	}

	public function &get_message()
	{
		return $this->emsg;
	}
	public function set(&$object){
		$this->object = $object;
	}
	private function _checkToken($json_resp,$token){
		$checkToken = FALSE;
		foreach($json_resp['links'] as $link){
			if (preg_match("/".$token."$/",$link['href'])){
				$checkToken = TRUE;
			}
		}
		return $checkToken;
	}


	/**
	 * Execute the payment
	 *   Once the user approves the payment, PayPal will redirect the user back to the return_url you specified.
	 *   PayPal also appends the payer ID value in the return URL as PayerID:
	 * @param $paypal_id
	 * @param $payer_id
	 * @return array|mixed
	 */
	public function executePayment($paypal_id,$payer_id){
		// Get token for Authorization: Bearer
		$this->token = $this->get_access_token($this->host.$this->token_endpoint,$this->token_postArgs);
		if ( is_null($this->token) ) echoMessage($this->message);
		$url = $this->host.'/v1/payments/payment/'.$paypal_id."/execute/";
		$payment = array(
			'payer_id' => $payer_id
		);
		$json = json_encode($payment);
		$this->json_resp = $this->make_post_call($url, $json);
		return $this->json_resp;
	}
	/**
	 * Get payment canceled
	 *
	 * @param $json_resp
	 * @param $token
	 * @param $uid
	 */
	public function checkToken($json_resp,$token){
		if( $this->_checkToken($json_resp,$token) ){
			return $json_resp['id'];
		}
	}


	public function getLinks(){
		if($this->json_resp) {
			return $this->json_resp['links'];
		}else{
			return NULL;
		}
	}

	/**
	 * Accept a PayPal payment
	 *   Online Document :
	 *     https://developer.paypal.com/webapps/developer/docs/integration/web/accept-paypal-payment/
	 *   Description :
	 *     If the call is successful, we’ll return a confirmation of the transaction with the state being created.
	 *
	 * @param $returnUrl
	 * @param $cancelUrl
	 * @return array|mixed
	 */
	public function &AcceptPayment($returnUrl,$cancelUrl)
	{
		// Get token for Authorization: Bearer
		$this->token = $this->get_access_token($this->host.$this->token_endpoint,$this->token_postArgs);
		if(is_null($this->token)) echoMessage($this->message);

		$url = $this->host.'/v1/payments/payment';
		$payment = array(
			'intent' => 'sale',
			'redirect_urls' => array(
				'return_url' => $returnUrl,
				'cancel_url' => $cancelUrl
			),
			'payer' => array(
				'payment_method' => 'paypal'
			),
			'transactions' => array (array(
				'amount' => array(
					'total' => $this->object->getVar('amount'),
					'currency' => $this->object->getVar('currency')
				),
				'description' => 'Pass payment information to create a payment'
			))
		);
		$json = json_encode($payment);
		$this->json_resp = $this->make_post_call($url, $json);
		return $this->json_resp;
	}
	/**
	 * Making a Credit Card Payment.
	'number' => '5500005555555559',
	'type'   => 'mastercard',
	'expire_month' => 12,
	'expire_year' => 2018,
	'cvv2' => 111,
	'first_name' => 'Joe',
	'last_name' => 'Shopper'
	 */
	public function CreateCardPayment($CardNo,$CardName,$ExpireMonth,$ExpireYear,$cvv2,$FirstName,$LastName)
	{
		//トークン取得
		$this->token = $this->get_access_token($this->host.$this->token_endpoint,$this->token_postArgs);
		if(is_null($this->token)) echoMessage($this->message);

		$url = $this->host.'/v1/payments/payment';
		$payment = array(
			'intent' => 'sale',
			'payer' => array(
				'payment_method' => 'credit_card',
				'funding_instruments' => array ( array(
					'credit_card' => array (
						'number' => $CardNo,
						'type'   => $CardName,
						'expire_month' => intval($ExpireMonth),
						'expire_year' => intval($ExpireYear),
						'cvv2' => intval($cvv2),
						'first_name' => $FirstName,
						'last_name' => $LastName
					)
				))
			),
			'transactions' => array (array(
				'amount' => array(
					'total' => $this->total,
					'currency' => $this->currency
				),
				'description' => 'Pass payment information to create a payment'
			))
		);
		$json = json_encode($payment);
		$json_resp = $this->make_post_call($url, $json);
		foreach ($json_resp['links'] as $link) {
			if($link['rel'] == 'self'){
				$this->payment_detail_url = $link['href'];
				$this->payment_detail_method = $link['method'];
			}
		}
		$this->related_resource_count = 0;
		$related_resources = "";
		foreach ($json_resp['transactions'] as $transaction) {
			if($transaction['related_resources']) {
				$this->related_resource_count = count($transaction['related_resources']);
				foreach ($transaction['related_resources'] as $related_resource) {
					if($related_resource['sale']){
						$related_resources = $related_resources."sale ";
						$sale = $related_resource['sale'];
						foreach ($sale['links'] as $link) {
							if($link['rel'] == 'self'){
								$this->sale_detail_url = $link['href'];
								$this->sale_detail_method = $link['method'];
							}else if($link['rel'] == 'refund'){
								$this->refund_url = $link['href'];
								$this->refund_method = $link['method'];
							}
						}
					} else if($related_resource['refund']){
						$related_resources = $related_resources."refund";
					}
				}
			}
		}
/*
		echo "Payment Created successfully: " . $json_resp['id'] ." with state '". $json_resp['state']."'<br />";
		echo "Payment related_resources:". $related_resource_count . "(". $related_resources.")";
		echo "<br /> <br />";
		echo "###########################################<br />";
		echo "Obtaining Payment Details... <br />";
		$json_resp = $this->make_get_call($payment_detail_url);
		echo "Payment details obtained for: " . $json_resp['id'] ." with state '". $json_resp['state']. "'";
		echo "<br /> <br />";
		echo "###########################################<br />";
		echo "Obtaining Sale details...<br />";
		$json_resp = $this->make_get_call($sale_detail_url);
		echo "Sale details obtained for: " . $json_resp['id'] ." with state '". $json_resp['state']."'";
		echo "<br /> <br />";die;
*/
	}

	/**
	 * Saving a Credit Card in vault.
	 * @return bool
	 */
	public function saveCardInformation()
	{
		//トークン取得
		$this->token = $this->get_access_token($this->host.$this->token_endpoint,$this->token_postArgs);
		if(is_null($this->token)) echoMessage($this->message);

		$url = $this->host.'/v1/vault/credit-card';
		$creditcard = array(
			'payer_id' => 'info@bluemooninc.jp',
			'number' => $this->root->mContext->mRequest->getRequest('CardNo'),
			'type' => $this->root->mContext->mRequest->getRequest('CardName'),
			'expire_month' => $this->root->mContext->mRequest->getRequest('ExpireMonth'),
			'expire_year' => $this->root->mContext->mRequest->getRequest('ExpireYear'),
			'first_name' =>  $this->root->mContext->mRequest->getRequest('FirstName'),
			'last_name' => $this->root->mContext->mRequest->getRequest('LastName')
		);
		$json = json_encode($creditcard);
		$json_resp = $this->make_post_call($url, $json);
		$credit_card_id = $json_resp['id'];
		echo "Credit Card saved ".$credit_card_id." with state '".$json_resp['state']."'";
		return TRUE;
	}

	public function getCardList($MemberId)
	{
	}
}