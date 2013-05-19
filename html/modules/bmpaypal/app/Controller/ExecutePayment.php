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

class Controller_ExecutePayment extends AbstractAction{
	protected $links;
	protected $state;
	protected $Model_PayPal;
	/**
	 * constructor
	 */
	public function __construct(){
		parent::__construct();
		$this->mModel = Model_Payment::forge();
		$this->Model_PayPal = Model_PayPal::forge();
	}
	public function action_return(){
		$this->template = 'ExecutePayment.html';
		if(isset($_SESSION['bmpaypal'])){
			$uid = $this->root->mContext->mXoopsUser->get('uid');
			$token = xoops_getrequest('token');
			if ($_SESSION['payer_id']){
				$payer_id = $_SESSION['payer_id'];
			}else{
				$_SESSION['payer_id'] = $payer_id = xoops_getrequest('PayerID');
			}
			$paypal_id = $this->Model_PayPal->checkToken($_SESSION['bmpaypal'],$token);
			if ($paypal_id){
				$this->state = "Accepted";
				$this->mModel->setPayerID($paypal_id,$uid,$this->state,$payer_id);
			}
		}
	}
	public function action_cancel(){
		$this->template = 'ExecutePayment.html';
		if(isset($_SESSION['bmpaypal'])){
			$uid = $this->root->mContext->mXoopsUser->get('uid');
			$token = xoops_getrequest('token');
			$paypal_id = $this->Model_PayPal->checkToken($_SESSION['bmpaypal'],$token);
			if ($paypal_id){
				$this->state = "Canceled";
				$this->mModel->cancel($paypal_id,$uid,$this->state);
			}
		}
	}
	public function action_index(){
	}
	public function action_view(){
		/**
		 * make view
		 */
		$view = new View($this->root);
		$view->set('state',$this->state);
		$view->setTemplate($this->template);
	}
}