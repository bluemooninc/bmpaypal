<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/core/XCube_ActionForm.class.php";
require_once XOOPS_MODULE_PATH . "/legacy/class/Legacy_Validator.class.php";

class bmpaypal_PaymentAdminEditForm extends XCube_ActionForm
{
	var $mOldFileName = NULL;
	var $_mIsNew = FALSE;
	var $mFormFile = NULL;

	function getTokenName()
	{
		return "module.bmpaypal.PaymentAdminEditForm.TOKEN";// . $this->get('field_id');
	}

	function prepare()
	{
		//parent::setToken($this->getTokenName());    // Set Token to XCUBE_TOKEN session
		$token =& XoopsMultiTokenHandler::quickCreate($this->getTokenName());

		//
		// Set form properties
		//
		$this->mFormProperties['id'] =new XCube_IntProperty('id');
		$this->mFormProperties['uid'] =new XCube_IntProperty('uid');
		$this->mFormProperties['order_id'] =new XCube_IntProperty('order_id');
		$this->mFormProperties['amount'] =new XCube_FloatProperty('amount');
		$this->mFormProperties['currency'] =new XCube_StringProperty('currency');
		$this->mFormProperties['paypal_id'] =new XCube_StringProperty('paypal_id');
		$this->mFormProperties['state'] =new XCube_StringProperty('state');
		$this->mFormProperties['payer_id'] =new XCube_StringProperty('payer_id');
		$this->mFormProperties['utime'] =new XCube_IntProperty('utime');

		//
		// Set field properties
		//
		$this->mFieldProperties['amount'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['amount']->setDependsByArray(array('required'));
		$this->mFieldProperties['amount']->addMessage('required', _MD_PAYPAL_ERROR_REQUIRED, _MD_PAYPAL_ID);
	}
	private function _setFetch($root,$name){
		if (($value = $root->mContext->mRequest->getRequest($name)) !== null) {
			$this->set($name, trim($value));
		}
	}
	function fetch()
	{
		parent::fetch();
		$root =& XCube_Root::getSingleton();
		$this->set('uid', $root->mContext->mXoopsUser->uid());
		$this->_setFetch($root,'currency');
		$this->_setFetch($root,'order_id');
		$this->_setFetch($root,'amount');
		$this->_setFetch($root,'state');
		$this->set('utime', time());
	}
	function load(&$obj)
	{
		$id = xoops_getrequest('id') ? xoops_getrequest('id') : $obj->get('id');
		$this->set('id', $id);
		$this->set('uid', $obj->get('uid'));
		$this->set('order_id', $obj->get('order_id'));
		$this->set('amount', $obj->get('amount'));
		$this->set('currency', $obj->get('currency'));
		$this->set('state', $obj->get('state'));
		$this->set('utime', $obj->get('utime'));
	}

	function update(&$obj)
	{
		$obj->set('id', $this->get('id'));
		$obj->set('uid', $this->get('uid'));
		$obj->set('order_id', $this->get('order_id'));
		$obj->set('amount', $this->get('amount'));
		$obj->set('currency', $this->get('currency'));
		$obj->set('state', $this->get('state'));
		$obj->set('utime', $this->get('utime'));
	}
}
