<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/bmpaypal/class/AbstractEditAction.class.php";

class bmpaypal_AbstractDeleteAction extends bmpaypal_AbstractEditAction
{
	function isEnableCreate()
	{
		return false;
	}

	function _doExecute()
	{
		return $this->mObjectHandler->delete($this->mObject);
	}
}

?>
