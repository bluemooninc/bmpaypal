<?php
/**
 * Created by JetBrains PhpStorm.
 * Execute: bluemooninc
 * Date: 2012/12/08
 * Time: 10:20
 * To change this template use File | Settings | File Templates.
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/bmpaypal/class/AbstractEditAction.class.php";
require_once XOOPS_MODULE_PATH . "/bmpaypal/admin/forms/PaymentAdminExecuteForm.class.php";
require_once XOOPS_MODULE_PATH . "/bmpaypal/app/Model/AbstractModel.class.php";
require_once XOOPS_MODULE_PATH . "/bmpaypal/app/Model/PayPal.class.php";

class bmpaypal_PaymentExecuteAction extends bmpaypal_AbstractEditAction
{
	function _getId()
	{
		return xoops_getrequest('id');
	}
	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('payment');
		return $handler;
	}
	function _setupActionForm()
	{
		$this->mActionForm = new bmpaypal_PaymentAdminExecuteForm();
		$this->mActionForm->prepare();
	}

	function _doExecute()
	{
		$root = XCube_Root::getSingleton();
		$handler =& xoops_getmodulehandler('payment');
		$object =& $handler->get($this->mObject->get('id'));
		$paypal_id = $object->getVar('paypal_id');
		$payer_id = $object->getVar('payer_id');
		$Model_PayPal = Model_PayPal::forge();
		// Note: Once a payment is complete, it is referred to as a sale. You can then look up the sale and refund it.
		$Model_PayPal->executePayment($paypal_id,$payer_id);
		$object->set('state','Executed');
		$object->set('utime',time());
		$handler->insert($object);
		return BMPAYMAPL_FRAME_VIEW_SUCCESS;
	}

	function executeViewInput(&$controller, &$render)
	{
		$render->setTemplateName("payment_execute.html");
		$render->setAttribute('actionForm', $this->mActionForm);
		$render->setAttribute('object', $this->mObject);
	}

	function executeViewSuccess(&$controller,  &$render)
	{
		$controller->executeForward("./index.php?action=PaymentList");
	}

	function executeViewError(&$controller,  &$render)
	{
		$controller->executeRedirect("./index.php?action=PaymentList", 3, _MD_BMCART_ERROR_DBUPDATE_FAILED);
	}

	function executeViewCancel(&$controller,  &$render)
	{
		$controller->executeForward("./index.php?action=PaymentList");
	}
}