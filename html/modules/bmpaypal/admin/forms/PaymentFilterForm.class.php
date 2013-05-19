<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/bmpaypal/class/AbstractFilterForm.class.php";

define('PAYMENT_SORT_KEY_PAYMENTID', 1);
define('PAYMENT_SORT_KEY_UID', 2);
define('PAYMENT_SORT_KEY_ORDERID', 3);
define('PAYMENT_SORT_KEY_STATE', 4);
define('PAYMENT_SORT_KEY_UTIME', 5);

define('PAYMENT_SORT_KEY_DEFAULT', PAYMENT_SORT_KEY_PAYMENTID);

class bmpaypal_PaymentFilterForm extends bmpaypal_AbstractFilterForm
{
	var $mSortKeys = array(
		PAYMENT_SORT_KEY_DEFAULT => 'id',
		PAYMENT_SORT_KEY_PAYMENTID => 'id',
		PAYMENT_SORT_KEY_UID => 'uid',
		PAYMENT_SORT_KEY_ORDERID => 'order_id',
		PAYMENT_SORT_KEY_STATE => 'state',
		PAYMENT_SORT_KEY_UTIME => 'utime',
	);

	function getDefaultSortKey()
	{
		return PAYMENT_SORT_KEY_DEFAULT;
	}
	
	function fetch()
	{
		parent::fetch();

		if (isset($_REQUEST['uid'])) {
			$this->mNavi->addExtra('uid', xoops_getrequest('uid'));
			$this->_mCriteria->add(new Criteria('uid', xoops_getrequest('uid')));
		}

		if (isset($_REQUEST['order_id'])) {
			$this->mNavi->addExtra('order_id', xoops_getrequest('order_id'));
			$this->_mCriteria->add(new Criteria('order_id', xoops_getrequest('order_id')));
		}
		
		$this->_mCriteria->addSort($this->getSort(), $this->getOrder());
	}
}

?>
