<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bluemooninc
 * Date: 2012/12/28
 * Time: 16:09
 * To change this template use File | Settings | File Templates.
 */
include_once "AcceptPayment.php";
require_once _MY_MODULE_PATH . 'app/Model/Payment.php';

class Controller_Bmpaypal extends AbstractAction {
	protected $index;
	protected $userObject;
	public function __construct()
	{
		parent::__construct();
		$this->mModel = Model_Payment::forge();
	}
	private function &_setupActionForm($object)
	{
		require_once _MY_MODULE_PATH .'/admin/forms/PaymentAdminEditForm.class.php';
		$mActionForm = new bmpaypal_PaymentAdminEditForm();
		$mActionForm->prepare();
		$mActionForm->load($object);
		return $mActionForm;
	}
	public function action_index(){
		$this->template = 'BmPayPal.html';
		$order_id = xoops_getrequest('order_id');
		$amount = xoops_getrequest('amount');
		$currency = xoops_getrequest('currency');
		$object = $this->mModel->get();
		$object->set('order_id',$order_id);
		$object->set('amount',$amount);
		$object->set('currency',$currency);
		$this->mActionForm = $this->_setupActionForm($object);
	}
	public function action_PaymentHistory(){
		$this->template = 'payment_history.html';
		$uid = 0;
		if ($this->mModuleAdmin){
			$uid = intval($this->mParams[0]);
		}
		if ($uid==0){
			$uid = $this->root->mContext->mXoopsUser->uid();
			$this->userObject = $this->root->mContext->mXoopsUser;
		}
		$this->paymentObjects = $this->mModel->getBy_uid($uid);
	}
	public function action_view(){
		/**
		 * make view
		 */
		$view = new View( $this->root );
		if (isset($this->mActionForm)){
			$view->set('actionForm', $this->mActionForm);
		}
		$view->set('paymentObjects', $this->paymentObjects);
		$view->set('userObject', $this->userObject);
		$view->setTemplate( $this->template );
	}
	public function executeForward(&$controller){
		$db = $controller->getDB();
		$controller->executeForward(XOOPS_URL."/modules/bmpaypal/AcceptPayment/index/".$db->getInsertId());
	}

}