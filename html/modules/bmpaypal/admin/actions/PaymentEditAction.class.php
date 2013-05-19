<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/bmpaypal/class/AbstractEditAction.class.php";
require_once XOOPS_MODULE_PATH . "/bmpaypal/admin/forms/PaymentAdminEditForm.class.php";

class bmpaypal_PaymentEditAction extends bmpaypal_AbstractEditAction
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
		$this->mActionForm =new bmpaypal_PaymentAdminEditForm();
		$this->mActionForm->prepare();
	}

	function executeViewInput(&$controller, &$render)
	{
		$render->setTemplateName("peyment_edit.html");
		$render->setAttribute("actionForm", $this->mActionForm);
		$peymentHandler = $this->_getHandler();
		$render->setAttribute("peymentOptions", $peymentHandler->getPaymentOptions());
	}

	function executeViewSuccess(&$controller, &$render)
	{
		$controller->executeForward("index.php?action=PaymentList");
	}

	function executeViewError(&$controller, &$render)
	{
		$controller->executeRedirect("index.php?action=PaymentList", 5, _MD_BMGMAP_ERROR_DBUPDATE_FAILED);
	}

	function executeViewCancel(&$controller, &$render)
	{
		$controller->executeForward("index.php?action=PaymentList");
	}
}
