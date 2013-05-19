<?php
/**
 * @package user
 * @version $Id: UserAdminExecuteForm.class.php,v 1.2 2007/06/07 05:27:37 minahito Exp $
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/core/XCube_ActionForm.class.php";

class bmpaypal_PaymentAdminExecuteForm extends XCube_ActionForm
{
	function getTokenName()
	{
		return "module.user.PaymentAdminExecuteForm.TOKEN" . $this->get('id');
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['id'] =new XCube_IntProperty('id');
		//
		// Set field properties
		//
		$this->mFieldProperties['id'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['id']->setDependsByArray(array('required'));
		$this->mFieldProperties['id']->addMessage('required', _MD_PAYPAL_ERROR_REQUIRED, _MD_PAYPAL_ID);
	}

	function load(&$obj)
	{
		$this->set('id', $obj->get('id'));
	}

	function update(&$obj)
	{
		$obj->setVar('id', $this->get('id'));
	}
}

?>
