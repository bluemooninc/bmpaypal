<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bluemooninc
 * Date: 12/07/28
 * Time: 11:06
 * To change this template use File | Settings | File Templates.
 */
class Model_Payment extends AbstractModel
{
	protected $orderId;
	protected $total;               // Amount total
	protected $currency = 'USD';    // Default currency doller
	/**
	 * constructor
	 */
	public function __construct()
	{
		$this->_module_names = $this->getModuleNames();
		$this->myHandler =& xoops_getModuleHandler('payment');
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
			$instance = new Model_Payment();
		}
		return $instance;
	}

	public function &get($id=0){
		if ($id){
			return $this->myHandler->get($id);
		}else{
			return $this->myHandler->create();
		}
	}

	public function getInsertId(){
		return $this->myHandler->getInsertId();
	}

	public function _getByPayPal_id($paypal_id,$uid){
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('paypal_id',$paypal_id));
		$criteria->add(new Criteria('uid',$uid));
		$objects = $this->myHandler->getObjects($criteria);
		if ($objects) return $objects[0];
	}

	/**
	 * Save transaction
	 */
	public function SavePaymentInfo($payment_id,$paypal_id,$state){
		$object = $this->myHandler->get($payment_id);
		$object->set('paypal_id',$paypal_id);
		$object->set('state',$state);
		$object->set('utime',time());
		return $this->myHandler->insert($object,true);
	}
	/**
	 * @param $paypal_id
	 * @param $uid
	 */
	public function cancel($paypal_id,$uid,$state){
		$object = $this->_getByPayPal_id($paypal_id,$uid);
		if ($object){
			$object->set('state',$state);
			$object->set('utime',time());
			$this->myHandler->insert($object,true);
		}
	}
	/**
	 * @param $paypal_id
	 * @param $uid
	 * @param $payer_id
	 */
	public function setPayerID($paypal_id,$uid,$state,$payer_id){
		$object = $this->_getByPayPal_id($paypal_id,$uid);
		if ($object){
			$object->set('state',$state);
			$object->set('payer_id',$payer_id);
			$object->set('utime',time());
			$this->myHandler->insert($object,true);
		}
	}
}
