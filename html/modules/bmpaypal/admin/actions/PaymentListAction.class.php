<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bluemooninc
 * Date: 2013/05/16
 * Time: 23:21
 * To change this template use File | Settings | File Templates.
 */
require_once XOOPS_MODULE_PATH . "/bmpaypal/class/AbstractListAction.class.php";
require_once XOOPS_MODULE_PATH . "/bmpaypal/admin/forms/PaymentFilterForm.class.php";

class bmpaypal_PaymentListAction extends bmpaypal_AbstractListAction
{
	function _getId()
	{
		die (xoops_getrequest('id'));
		return xoops_getrequest('id');
	}
	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('payment');
		return $handler;
	}

	function &_getFilterForm()
	{
		$filter = new bmpaypal_PaymentFilterForm($this->_getPageNavi(), $this->_getHandler());
		return $filter;
	}

	function _getBaseUrl()
	{
		return "./index.php?action=PaymentList";
	}
	function _doExecute(){
		die("hoge");
	}
	function executeViewIndex(&$controller, &$render)
	{
		$render->setTemplateName("payment_list.html");
		$render->setAttribute("objects", $this->mObjects);
		$render->setAttribute("pageNavi", $this->mFilter->mNavi);
	}	
}