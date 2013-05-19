<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bluemooninc
 * Date: 2013/05/16
 * Time: 12:50
 * To change this template use File | Settings | File Templates.
 */
require_once _MY_MODULE_PATH . 'app/Model/Payment.php';
require_once _MY_MODULE_PATH . 'app/Model/PayPal.class.php';
require_once _MY_MODULE_PATH . 'app/View/view.php';

class Controller_AcceptPayment extends AbstractAction{
	protected $links;
	protected $return_url;
	protected $cancel_url;
	protected $Model_PayPal;

	/**
	 * constructor
	 */
	public function __construct(){
		parent::__construct();
		$this->mModel = Model_Payment::forge();
		$this->Model_PayPal = Model_PayPal::forge();
		$this->return_url = XOOPS_URL . "/modules/bmpaypal/ExecutePayment/return/";
		$this->cencel_url = XOOPS_URL . "/modules/bmpaypal/ExecutePayment/cancel/";
	}
	public function action_index(){
		$payment_id = $this->mParams[0];
		$this->template = 'AcceptPayment.html';
		$object = $this->mModel->get($payment_id);
		$uid = $this->root->mContext->mXoopsUser->get('uid');
		$this->Model_PayPal->set($object);
		//$this->Model_PayPal->setAmount( 1, 1.0, "USD" );  // TODO: TEST as OrderID,Amount,Currency
		$json_resp = $this->Model_PayPal->AcceptPayment( $this->return_url, $this->cencel_url );     // call REST api
		$this->mModel->SavePaymentInfo( $payment_id, $json_resp['id'], $json_resp['state'] );
		$this->links = $this->Model_PayPal->getLinks();
		if ($json_resp){
			$_SESSION['bmpaypal'] = $json_resp;
		}
	}
	public function action_view(){
		/**
		 * make view
		 */
		$view = new View( $this->root );
		$view->set('title', "hoge");
		$view->set('links', $this->links );
		$view->setTemplate( $this->template );
	}
}